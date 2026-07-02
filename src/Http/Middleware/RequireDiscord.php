<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequireDiscord
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('pltx-theme.features.discord_oauth', true)) {
            abort(503, 'Discord integration is disabled.');
        }

        return $next($request);
    }
}
