<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

final class BillingAccount extends ThemeModel
{
    protected $table = 'pltx_billing_accounts';

    protected $fillable = [
        'user_id',
        'balance',
        'currency',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];
}
