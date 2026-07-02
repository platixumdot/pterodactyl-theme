<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Billing Module Settings
    |--------------------------------------------------------------------------
    */
    'enabled'      => env('PLTX_BILLING_ENABLED', true),
    'currency'     => env('PLTX_BILLING_CURRENCY', 'EUR'),
    'invoice_prefix'=> env('PLTX_BILLING_INVOICE_PREFIX', 'INV-'),
    'tax_rate'     => (float) env('PLTX_BILLING_TAX_RATE', 0.19),
];
