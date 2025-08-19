<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Read locale from session if available, otherwise fall back to cookie, then config
        $candidate = session('locale') ?? $request->cookie('locale') ?? config('app.locale');
        $allowed = ['en', 'ar'];
        $locale = in_array($candidate, $allowed, true) ? $candidate : config('app.locale');
        App::setLocale($locale);
        return $next($request);
    }
}
