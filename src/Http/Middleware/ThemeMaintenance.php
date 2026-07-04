<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ThemeMaintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('pltx-theme.maintenance.enabled', false)) {
            $allowedIps = config('pltx-theme.maintenance.allowed_ips', []);

            if (! in_array($request->ip(), $allowedIps, true)) {
                abort(503, 'Theme is under maintenance.');
            }
        }

        return $next($request);
    }
}
