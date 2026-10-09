<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Sirf successful public GET page requests
        if (
            !$request->isMethod('GET') ||
            $response->getStatusCode() >= 400 ||
            $request->expectsJson() ||
            $request->is('admin', 'admin/*', 'api', 'api/*')
        ) {
            return $response;
        }

        // Browser ko identify karne ke liye cookie
        $visitorId = $request->cookie('analytics_visitor_id');

        if (!is_string($visitorId) ||
            !Str::isUuid($visitorId)) {
            $visitorId = (string) Str::uuid();
        }

        $referer = $request->headers->get('referer');

        $utmSource = $request->query('utm_source');
        $utmMedium = $request->query('utm_medium');
        $utmCampaign = $request->query('utm_campaign');

        // UTM na ho to referrer host use karo
        $source = 'direct';

        if (is_string($utmSource) && trim($utmSource) !== '') {
            $source = Str::limit(trim($utmSource), 255, '');
        } elseif (is_string($referer) && $referer !== '') {
            $host = parse_url($referer, PHP_URL_HOST);

            if (is_string($host) && $host !== '') {
                $host = strtolower($host);

                // Apni website ke internal navigation ko
                // external referral na samjho
                $currentHost = strtolower($request->getHost());

                if ($host !== $currentHost) {
                    $source = $host;
                }
            }
        }

        PageVisit::create([
            'visitor_id' => $visitorId,
            'session_id' => $request->hasSession()
                ? $request->session()->getId()
                : null,

            // Query string aur sensitive parameters save na karo
            'url' => '/' . ltrim($request->path(), '/'),

            'utm_source' => $this->stringValue(
                $request->query('utm_source')
            ),
            'utm_medium' => $this->stringValue(
                $request->query('utm_medium')
            ),
            'utm_campaign' => $this->stringValue(
                $request->query('utm_campaign')
            ),
            'utm_content' => $this->stringValue(
                $request->query('utm_content')
            ),
            'utm_term' => $this->stringValue(
                $request->query('utm_term')
            ),

            'referer' => $this->safeReferer($referer),
            'source' => $source,
            'visited_at' => now(),
        ]);

        // Naye visitor ko 1 saal tak identify karo
        if (!$request->cookie('analytics_visitor_id') ||
            !Str::isUuid((string) $request->cookie('analytics_visitor_id'))) {
            $response->headers->setCookie(
                cookie(
                    'analytics_visitor_id',
                    $visitorId,
                    60 * 24 * 365,
                    '/',
                    null,
                    $request->isSecure(),
                    true,
                    false,
                    'lax'
                )
            );
        }

        return $response;
    }

    private function stringValue(mixed $value): ?string
    {
        if (!is_string($value) || trim($value) === '') {
            return null;
        }

        return Str::limit(trim($value), 255, '');
    }

    private function safeReferer(?string $referer): ?string
    {
        if (!$referer) {
            return null;
        }

        // Query parameters mein tokens ya personal data ho sakta hai
        $parts = parse_url($referer);

        if (!$parts || empty($parts['host'])) {
            return null;
        }

        return ($parts['scheme'] ?? 'https')
            . '://' . $parts['host']
            . ($parts['path'] ?? '/');
    }
    
}
