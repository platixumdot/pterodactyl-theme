<?php

return [
    'version' => env('PLTX_THEME_VERSION', '1.0.0'),
    'database' => [
        'connection' => env('PLTX_THEME_DB_CONNECTION', 'pltx_theme'),
        'path' => env('PLTX_THEME_DB_PATH', storage_path('app/pltx-theme.sqlite')),
    ],
    'brand' => [
        'name' => env('PLTX_THEME_NAME', 'PLTX Theme'),
        'primary' => '#3b82f6',
        'background' => '#0f0f0f',
    ],
    'locale' => env('PLTX_THEME_LOCALE', 'de'),
    'features' => [
        'status_page' => true,
        'tickets' => true,
        'billing' => true,
        'server_extensions' => true,
        'user_profiles' => true,
        'admin_system' => true,
        'discord_oauth' => true,
        'webhooks' => true,
        'realtime_updates' => true,
    ],
    'discord' => [
        'client_id' => env('DISCORD_CLIENT_ID'),
        'client_secret' => env('DISCORD_CLIENT_SECRET'),
        'webhook_url' => env('PLTX_DISCORD_WEBHOOK_URL'),
    ],
    'locales' => ['de', 'en'],
    'api' => [
        'prefix' => 'api/theme',
        'rate_limit' => '120,1',
    ],
    'routes' => [
        'enabled' => env('PLTX_THEME_REGISTER_ROUTES', true),
        'web_prefix' => env('PLTX_THEME_WEB_PREFIX', 'theme'),
    ],
    'updates' => [
        'feed_url' => env('PLTX_THEME_UPDATE_FEED_URL'),
    ],
    'status' => [
        'public_cache_seconds' => 30,
    ],
];
