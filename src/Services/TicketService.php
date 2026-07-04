<?php

declare(strict_types=1);

namespace Pltx\Theme\Services;

use Illuminate\Http\Request;
use Pltx\Theme\Events\TicketCreated;
use Pltx\Theme\Events\TicketClosed;
use Pltx\Theme\Events\TicketArchived;
use Pltx\Theme\Models\Ticket;
use Pltx\Theme\Support\Security\Sanitizer;

final class TicketService
{
    public function create(array $data, ?int $userId): Ticket
    {
        $ticket = Ticket::query()->create([
            'user_id'  => $userId,
            'category' => Sanitizer::text($data['category'], 80) ?? 'general',
            'priority' => $data['priority'],
            'subject'  => Sanitizer::text($data['subject'], 150) ?? $data['subject'],
            'body'     => Sanitizer::html($data['body'], 10000) ?? $data['body'],
            'status'   => 'open',
            'activity' => [['type' => 'created', 'at' => now()->toIso8601String()]],
        ]);

        event(new TicketCreated($ticket));

        return $ticket;
    }

    public function close(Ticket $ticket): void
    {
        $ticket->forceFill([
            'status'    => 'closed',
            'closed_at' => now(),
            'activity'  => array_merge($ticket->activity ?? [], [['type' => 'closed', 'at' => now()->toIso8601String()]]),
        ])->save();

        event(new TicketClosed($ticket));
    }

    public function archive(Ticket $ticket): void
    {
        $ticket->forceFill([
            'archived_at' => now(),
            'activity'    => array_merge($ticket->activity ?? [], [['type' => 'archived', 'at' => now()->toIso8601String()]]),
        ])->save();

        event(new TicketArchived($ticket));
    }

    public function addNote(Ticket $ticket, string $note, ?int $authorId): void
    {
        $ticket->forceFill([
            'notes' => array_merge($ticket->notes ?? [], [[
                'author' => $authorId,
                'note'   => Sanitizer::html($note, 5000) ?? $note,
                'at'     => now()->toIso8601String(),
            ]]),
        ])->save();
    }
}
