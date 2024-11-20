<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = 'vi';
        if (optional(auth()->user())->language) {
            $locale = auth()->user()->language;
        } elseif (function_exists('get_settings')) {
            $locale = get_settings('language', true);
        }

        app()->setlocale(session('language', ($locale ? $locale : 'vi')));
        return $next($request);
    }
}
