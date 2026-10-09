<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use DeviceDetector\DeviceDetector;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackPageVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Sirf successful GET requests track karo
        if (
            !$request->isMethod('GET') ||
            $response->getStatusCode() >= 400 ||
            $request->expectsJson() ||
            $request->is('admin') ||
            $request->is('admin/*') ||
            $request->is('api') ||
            $request->is('api/*')
        ) {
            return $response;
        }

        // Visitor ID
        $visitorId = $request->cookie('analytics_visitor_id');

        if (!is_string($visitorId) || !Str::isUuid($visitorId)) {
            $visitorId = (string) Str::uuid();
        }

        // UTM parameters
        $utmSource = $this->stringValue($request->query('utm_source'));
        $utmMedium = $this->stringValue($request->query('utm_medium'));
        $utmCampaign = $this->stringValue($request->query('utm_campaign'));
        $utmContent = $this->stringValue($request->query('utm_content'));
        $utmTerm = $this->stringValue($request->query('utm_term'));

        // Referrer
        $referer = $request->headers->get('referer');
        $refererHost = null;
        $cleanReferer = null;

        if (is_string($referer) && filter_var($referer, FILTER_VALIDATE_URL)) {
            $refererHost = parse_url($referer, PHP_URL_HOST);

            if ($refererHost) {
                $cleanReferer = parse_url($referer, PHP_URL_SCHEME)
                    . '://' . $refererHost
                    . (parse_url($referer, PHP_URL_PATH) ?? '');
            }
        }

        // Traffic source
        $source = 'direct';

        if ($utmSource !== null) {
            $source = Str::limit($utmSource, 100, '');
        } elseif (
            $refererHost &&
            strcasecmp($refererHost, $request->getHost()) !== 0
        ) {
            $source = Str::limit($refererHost, 100, '');
        }

        // Device, browser aur operating system
        $deviceType = null;
        $browser = null;
        $operatingSystem = null;

        try {
            $userAgent = $request->userAgent() ?? '';

            if ($userAgent !== '') {
                $detector = new DeviceDetector($userAgent);
                $detector->parse();

                $deviceType = $detector->getDeviceName() ?: 'Unknown';

                $client = $detector->getClient();
                $browser = $client['name'] ?? 'Unknown';

                $os = $detector->getOs();
                $operatingSystem = $os['name'] ?? 'Unknown';

                logger()->info('Visitor device detection', [
                    'user_agent' => $userAgent,
                    'device_type' => $deviceType,
                    'browser' => $browser,
                    'operating_system' => $operatingSystem,
                ]);
            }
        } catch (Throwable $e) {
            // Detection fail ho toh tracking continue rahe
        }

        $country = null;
        $countryCode = null;

        $ip = $request->ip();

        $databasePath = storage_path(
            'app/geoip/GeoLite2-Country.mmdb'
        );

        logger()->info('GeoIP debug', [
            'ip' => $ip,
            'database_exists' => File::exists($databasePath),
            'is_public_ip' => $ip
                ? (bool) filter_var(
                    $ip,
                    FILTER_VALIDATE_IP,
                    FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                )
                : false,
        ]);

        if (
            $ip &&
            filter_var(
                $ip,
                FILTER_VALIDATE_IP,
                FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
            ) &&
            File::exists($databasePath)
        ) {
            try {
                $reader = new Reader($databasePath);
                $record = $reader->country($ip);

                $country = $record->country->name;
                $countryCode = $record->country->isoCode;

                $reader->close();

                logger()->info('GeoIP lookup result', [
                    'country' => $country,
                    'country_code' => $countryCode,
                ]);
            } catch (Throwable $e) {
                logger()->error('GeoIP lookup failed', [
                    'message' => $e->getMessage(),
                ]);
            }
        }

        // Page visit database mein save karo
        PageVisit::create([
            'visitor_id' => $visitorId,
            'session_id' => $request->hasSession()
                ? $request->session()->getId()
                : null,

            'url' => '/' . ltrim($request->path(), '/'),

            'utm_source' => $utmSource,
            'utm_medium' => $utmMedium,
            'utm_campaign' => $utmCampaign,
            'utm_content' => $utmContent,
            'utm_term' => $utmTerm,

            'referer' => $cleanReferer,
            'source' => $source,

            'country' => $country,
            'country_code' => $countryCode,
            'device_type' => $deviceType,
            'browser' => $browser,
            'operating_system' => $operatingSystem,

            'visited_at' => now(),
        ]);

        // Visitor cookie: one year
        $existingCookie = $request->cookie('analytics_visitor_id');

        if (!is_string($existingCookie) || !Str::isUuid($existingCookie)) {
            $response->withCookie(cookie(
                'analytics_visitor_id',
                $visitorId,
                60 * 24 * 365,
                '/',
                null,
                $request->isSecure(),
                true,
                false,
                'lax'
            ));
        }

        return $response;
    }

    private function stringValue(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }
}