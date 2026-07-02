<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PLTX Theme API Settings
    |--------------------------------------------------------------------------
    */
    'prefix'        => env('PLTX_API_PREFIX', 'api/theme'),
    'rate_limit'    => env('PLTX_API_RATE_LIMIT', '120,1'),
    'versioning'    => env('PLTX_API_VERSIONING', true),
    'current_version'=> 'v1',
];
