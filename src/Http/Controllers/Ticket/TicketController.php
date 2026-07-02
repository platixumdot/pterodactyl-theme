<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Ticket;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Pltx\Theme\Http\Requests\Ticket\StoreTicketRequest;
use Pltx\Theme\Http\Requests\Ticket\StoreNoteRequest;
use Pltx\Theme\Models\Ticket;
use Pltx\Theme\Services\TicketService;

final class TicketController
{
    public function __construct(private readonly TicketService $tickets) {}

    public function index(Request $request): View
    {
        $search = (string) $request->string('search');

        $tickets = Ticket::query()
            ->when($search !== '', fn ($q) => $q->where(function ($nested) use ($search): void {
                $nested->where('subject', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pltx-theme::tickets.index', compact('tickets', 'search'));
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $this->tickets->create($request->validated(), $request->user()?->id);

        return redirect()->route('theme.tickets.index')->with('status', 'Ticket erstellt.');
    }

    public function close(Ticket $ticket): RedirectResponse
    {
        $this->tickets->close($ticket);

        return redirect()->route('theme.tickets.index')->with('status', 'Ticket geschlossen.');
    }

    public function archive(Ticket $ticket): RedirectResponse
    {
        $this->tickets->archive($ticket);

        return redirect()->route('theme.tickets.index')->with('status', 'Ticket archiviert.');
    }

    public function note(StoreNoteRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->tickets->addNote($ticket, $request->validated('note'), $request->user()?->id);

        return redirect()->route('theme.tickets.index')->with('status', 'Admin-Notiz gespeichert.');
    }
}
