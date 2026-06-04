<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Pltx\Theme\Models\BillingAccount;
use Pltx\Theme\Models\BillingInvoice;
use Pltx\Theme\Models\BillingTransaction;

final class BillingApiController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'accounts' => BillingAccount::query()->latest()->take(10)->get(),
            'transactions' => BillingTransaction::query()->latest()->take(25)->get(),
            'invoices' => BillingInvoice::query()->latest()->take(25)->get(),
        ]);
    }
}
