<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Discord OAuth2 Credentials
    |--------------------------------------------------------------------------
    */
    'client_id'     => env('DISCORD_CLIENT_ID'),
    'client_secret' => env('DISCORD_CLIENT_SECRET'),
    'webhook_url'   => env('PLTX_DISCORD_WEBHOOK_URL'),
    'bot_token'     => env('PLTX_DISCORD_BOT_TOKEN'),
    'guild_id'      => env('PLTX_DISCORD_GUILD_ID'),
    'notify_on'     => [
        'ticket_created' => env('PLTX_DISCORD_NOTIFY_TICKETS', true),
        'invoice_created'=> env('PLTX_DISCORD_NOTIFY_INVOICES', true),
    ],
];
