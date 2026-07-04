<?php

declare(strict_types=1);

namespace Pltx\Theme\Listeners;

use Pltx\Theme\Events\InvoiceCreated;
use Pltx\Theme\Support\Discord\DiscordWebhook;

final class SendInvoiceDiscordNotification
{
    public function __construct(private readonly DiscordWebhook $webhook) {}

    public function handle(InvoiceCreated $event): void
    {
        $this->webhook->send(
            'Neue Rechnung',
            sprintf('Rechnung #%d erstellt', $event->invoice->id),
            ['Betrag' => $event->invoice->amount ?? 'N/A']
        );
    }
}
