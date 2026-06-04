<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

use Illuminate\Database\Eloquent\Model;

final class BillingAccount extends Model
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
