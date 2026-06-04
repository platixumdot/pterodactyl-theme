<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

use Illuminate\Database\Eloquent\Model;

final class BillingTransaction extends Model
{
    protected $table = 'pltx_billing_transactions';

    protected $fillable = [
        'billing_account_id',
        'type',
        'amount',
        'provider',
        'reference',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];
}
