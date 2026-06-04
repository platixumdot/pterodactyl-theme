<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Pltx\Theme\Models\Ticket;
use Pltx\Theme\Support\Sanitizer;

final class TicketController
{
    public function index(Request $request): View
    {
        $search = (string) $request->string('search');

        $tickets = Ticket::query()
            ->when($search !== '', fn ($query) => $query->where(function ($nested) use ($search): void {
                $nested->where('subject', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pltx-theme::tickets.index', compact('tickets', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'max:80'],
            'priority' => ['required', 'in:low,normal,high,urgent'],
            'subject' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string', 'max:10000'],
        ]);

        Ticket::query()->create([
            'user_id' => $request->user()?->id,
            'category' => Sanitizer::text($data['category'], 80) ?? 'general',
            'priority' => $data['priority'],
            'subject' => Sanitizer::text($data['subject'], 150) ?? $data['subject'],
            'body' => Sanitizer::html($data['body'], 10000) ?? $data['body'],
            'status' => 'open',
            'activity' => [['type' => 'created', 'at' => now()->toIso8601String()]],
        ]);

        return redirect()->route('theme.tickets.index')->with('status', 'Ticket erstellt.');
    }

    public function close(Ticket $ticket): RedirectResponse
    {
        $ticket->forceFill([
            'status' => 'closed',
            'closed_at' => now(),
            'activity' => array_merge($ticket->activity ?? [], [['type' => 'closed', 'at' => now()->toIso8601String()]]),
        ])->save();

        return redirect()->route('theme.tickets.index')->with('status', 'Ticket geschlossen.');
    }

    public function archive(Ticket $ticket): RedirectResponse
    {
        $ticket->forceFill([
            'archived_at' => now(),
            'activity' => array_merge($ticket->activity ?? [], [['type' => 'archived', 'at' => now()->toIso8601String()]]),
        ])->save();

        return redirect()->route('theme.tickets.index')->with('status', 'Ticket archiviert.');
    }

    public function note(Request $request, Ticket $ticket): RedirectResponse
    {
        $data = $request->validate([
            'note' => ['required', 'string', 'max:5000'],
        ]);

        $ticket->forceFill([
            'notes' => array_merge($ticket->notes ?? [], [[
                'author' => $request->user()?->id,
                'note' => Sanitizer::html($data['note'], 5000) ?? $data['note'],
                'at' => now()->toIso8601String(),
            ]]),
        ])->save();

        return redirect()->route('theme.tickets.index')->with('status', 'Admin-Notiz gespeichert.');
    }
}
