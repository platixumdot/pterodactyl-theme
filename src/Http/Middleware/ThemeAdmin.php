<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ThemeAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null || ! (method_exists($user, 'isRootAdmin') ? $user->isRootAdmin() : false)) {
            abort(403, 'Admin access required.');
        }

        return $next($request);
    }
}
