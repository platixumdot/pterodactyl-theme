<?php

declare(strict_types=1);

namespace Pltx\Theme\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Pltx\Theme\Models\BillingInvoice;

final class InvoiceCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly BillingInvoice $invoice) {}
}
