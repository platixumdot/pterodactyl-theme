<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

final class BillingInvoice extends ThemeModel
{
    protected $table = 'pltx_billing_invoices';

    protected $fillable = [
        'billing_account_id',
        'invoice_number',
        'status',
        'total',
        'paid_total',
        'due_at',
        'lines',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'paid_total' => 'decimal:2',
        'due_at' => 'datetime',
        'lines' => 'array',
    ];
}
