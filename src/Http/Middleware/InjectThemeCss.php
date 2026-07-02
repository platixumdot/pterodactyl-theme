<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Injects the PLTX theme CSS and JS into every HTML response,
 * including Pterodactyl's own panel pages.
 *
 * When Lightweight Mode is active (server-side default via PLTX_LIGHTWEIGHT_MODE),
 * Google Fonts are omitted from the injection to save network and rendering cost.
 */
final class InjectThemeCss
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only process HTML responses
        $contentType = $response->headers->get('Content-Type', '');
        if (! str_contains($contentType, 'text/html')) {
            return $response;
        }

        $content = $response->getContent();
        if (! is_string($content) || ! str_contains($content, '</head>')) {
            return $response;
        }

        // Skip if our CSS is already present (own /theme/* pages include it via the layout)
        if (str_contains($content, 'vendor/pltx-theme/css/theme.css')) {
            return $response;
        }

        $lightweight = (bool) config('pltx-theme.features.lightweight_mode', false);
        $cssUrl      = asset('vendor/pltx-theme/css/theme.css');
        $jsUrl       = asset('vendor/pltx-theme/js/theme.js');

        // Communicate server-side lightweight default to the JS layer
        $inject = "\n    <meta name=\"pltx-lightweight\" content=\"" . ($lightweight ? 'true' : 'false') . "\">";

        if (! $lightweight) {
            $inject .= "\n    <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">";
            $inject .= "\n    <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>";
            $inject .= "\n    <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@400;600;700;800&display=swap\" rel=\"stylesheet\">";
        }

        $inject .= "\n    <link rel=\"stylesheet\" href=\"{$cssUrl}\">";
        $inject .= "\n    <script src=\"{$jsUrl}\" defer></script>";

        $response->setContent(str_replace('</head>', $inject . "\n</head>", $content));

        return $response;
    }
}
