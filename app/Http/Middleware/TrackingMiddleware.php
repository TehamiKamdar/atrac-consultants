<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(
            $request->has('utm_source') || 
            $request->has('utm_medium') || 
            $request->has('utm_campaign') || 
            $request->has('utm_content') || 
            $request->has('utm_term')
        ){
            session([
                "utm" => [
                    'medium' => $request->query('utm_medium'),
                    'source' => $request->query('utm_source'),
                    'campaign' => $request->query('utm_campaign'),
                    'content' => $request->query('utm_content'),
                    'term' => $request->query('utm_term'),
                ]
                ]);
        }
        return $next($request);
    }
}
