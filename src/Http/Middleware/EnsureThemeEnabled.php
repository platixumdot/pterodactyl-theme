<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureThemeEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('pltx-theme.routes.enabled', true)) {
            abort(503, 'Theme is currently disabled.');
        }

        return $next($request);
    }
}
