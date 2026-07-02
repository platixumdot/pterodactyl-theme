<?php

declare(strict_types=1);

namespace Pltx\Theme\Services;

use Pltx\Theme\Models\BillingAccount;
use Pltx\Theme\Models\BillingInvoice;
use Pltx\Theme\Models\BillingTransaction;

final class BillingService
{
    public function getSummary(int $accountLimit = 5, int $itemLimit = 10): array
    {
        return [
            'accounts'     => BillingAccount::query()->latest()->take($accountLimit)->get(),
            'transactions' => BillingTransaction::query()->latest()->take($itemLimit)->get(),
            'invoices'     => BillingInvoice::query()->latest()->take($itemLimit)->get(),
        ];
    }

    public function getApiSummary(): array
    {
        return [
            'accounts'     => BillingAccount::query()->latest()->take(10)->get(),
            'transactions' => BillingTransaction::query()->latest()->take(25)->get(),
            'invoices'     => BillingInvoice::query()->latest()->take(25)->get(),
        ];
    }
}
