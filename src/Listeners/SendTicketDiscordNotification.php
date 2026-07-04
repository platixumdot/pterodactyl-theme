<?php

declare(strict_types=1);

namespace Pltx\Theme\Listeners;

use Pltx\Theme\Events\TicketCreated;
use Pltx\Theme\Support\Discord\DiscordWebhook;

final class SendTicketDiscordNotification
{
    public function __construct(private readonly DiscordWebhook $webhook) {}

    public function handle(TicketCreated $event): void
    {
        $this->webhook->send(
            'Neues Ticket',
            sprintf('[#%d] %s', $event->ticket->id, $event->ticket->subject),
            [
                'Kategorie' => $event->ticket->category,
                'Priorität' => $event->ticket->priority,
            ]
        );
    }
}
