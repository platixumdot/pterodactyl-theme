<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers;

use Illuminate\Contracts\View\View;
use Pltx\Theme\Models\BillingAccount;
use Pltx\Theme\Models\BillingInvoice;
use Pltx\Theme\Models\BillingTransaction;

final class BillingController
{
    public function index(): View
    {
        return view('pltx-theme::billing.index', [
            'accounts' => BillingAccount::query()->latest()->take(5)->get(),
            'transactions' => BillingTransaction::query()->latest()->take(10)->get(),
            'invoices' => BillingInvoice::query()->latest()->take(10)->get(),
        ]);
    }
}
