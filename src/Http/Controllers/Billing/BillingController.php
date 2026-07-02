<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Billing;

use Illuminate\Contracts\View\View;
use Pltx\Theme\Services\BillingService;

final class BillingController
{
    public function __construct(private readonly BillingService $billing) {}

    public function index(): View
    {
        return view('pltx-theme::billing.index', $this->billing->getSummary());
    }
}
