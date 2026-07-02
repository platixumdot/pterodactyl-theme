<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Status Page Settings
    |--------------------------------------------------------------------------
    */
    'enabled'              => env('PLTX_STATUS_ENABLED', true),
    'public_cache_seconds' => (int) env('PLTX_STATUS_CACHE_SECONDS', 30),
    'show_incidents'       => env('PLTX_STATUS_SHOW_INCIDENTS', true),
    'show_maintenance'     => env('PLTX_STATUS_SHOW_MAINTENANCE', true),
];
