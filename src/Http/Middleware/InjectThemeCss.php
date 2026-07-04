<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Injects the PLTX theme CSS/JS into every HTML response,
 * including Pterodactyl's own panel pages.
 * Uses the dynamic /theme/dynamic.css endpoint so Theme Editor changes
 * are reflected immediately without a build step.
 */
final class InjectThemeCss
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $contentType = $response->headers->get('Content-Type', '');
        if (! str_contains($contentType, 'text/html')) {
            return $response;
        }

        $content = $response->getContent();
        if (! is_string($content) || ! str_contains($content, '</head>')) {
            return $response;
        }

        if (str_contains($content, 'pltx-dynamic.css') || str_contains($content, 'vendor/pltx-theme/css/theme.css')) {
            return $response;
        }

        $lightweight = (bool) config('pltx-theme.features.lightweight_mode', false);
        $dynamicCss  = route('theme.dynamic.css');
        $staticCss   = asset('vendor/pltx-theme/css/theme.css');
        $jsUrl       = asset('vendor/pltx-theme/js/theme.js');

        $inject  = "\n    <meta name=\"pltx-lightweight\" content=\"" . ($lightweight ? 'true' : 'false') . "\">";

        if (! $lightweight) {
            $inject .= "\n    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">";
            $inject .= "\n    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>";
            $inject .= "\n    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@400;600;700;800&display=swap\" rel=\"stylesheet\">";
        }

        // Dynamic CSS first (has CSS variables), then static theme CSS on top
        $inject .= "\n    <link rel=\"stylesheet\" href=\"{$dynamicCss}\" id=\"pltx-dynamic.css\">";
        $inject .= "\n    <link rel=\"stylesheet\" href=\"{$staticCss}\">";
        $inject .= "\n    <script src=\"{$jsUrl}\" defer></script>";

        $response->setContent(str_replace('</head>', $inject . "\n</head>", $content));

        return $response;
    }
}
