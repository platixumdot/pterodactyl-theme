@extends('pltx-theme::layouts.app')

@section('title', 'Tickets')

@section('content')
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between;">
    <div>
        <h2>Tickets</h2>
        <p>Support-Anfragen erstellen und verwalten.</p>
    </div>
    <button class="pltx-btn pltx-btn--primary" onclick="document.getElementById('newTicketModal').style.display='flex'">
        + Neues Ticket
    </button>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('theme.tickets.index') }}" style="margin-bottom:20px;">
    <div style="display:flex; gap:8px; max-width:420px;">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Tickets durchsuchen…" class="pltx-input">
        <button type="submit" class="pltx-btn pltx-btn--secondary">Suchen</button>
    </div>
</form>

{{-- Ticket table --}}
<div class="pltx-card">
    <table class="pltx-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Betreff</th>
                <th>Kategorie</th>
                <th>Priorität</th>
                <th>Status</th>
                <th>Erstellt</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
            <tr>
                <td class="text-muted">#{{ $ticket->id }}</td>
                <td>{{ $ticket->subject }}</td>
                <td><span class="pltx-badge pltx-badge--gray">{{ $ticket->category }}</span></td>
                <td>
                    @php $pc = match($ticket->priority) { 'urgent'=>'red','high'=>'yellow','normal'=>'blue', default=>'gray' }; @endphp
                    <span class="pltx-badge pltx-badge--{{ $pc }}">{{ ucfirst($ticket->priority) }}</span>
                </td>
                <td>
                    @php $sc = match($ticket->status) { 'open'=>'green','closed'=>'gray','archived'=>'red', default=>'gray' }; @endphp
                    <span class="pltx-badge pltx-badge--{{ $sc }}">{{ ucfirst($ticket->status) }}</span>
                </td>
                <td class="text-muted">{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                <td style="display:flex; gap:6px; flex-wrap:wrap;">
                    @if($ticket->status === 'open')
                    <form method="POST" action="{{ route('theme.tickets.close', $ticket) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="pltx-btn pltx-btn--ghost pltx-btn--sm">Schließen</button>
                    </form>
                    @endif
                    @if($ticket->status !== 'archived' && $ticket->archived_at === null)
                    <form method="POST" action="{{ route('theme.tickets.archive', $ticket) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="pltx-btn pltx-btn--ghost pltx-btn--sm">Archivieren</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:40px; color:var(--pltx-text-muted);">
                    Keine Tickets gefunden.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($tickets->hasPages())
    <div style="padding:16px 20px; border-top:1px solid var(--pltx-border);">
        {{ $tickets->links() }}
    </div>
    @endif
</div>

{{-- New ticket modal --}}
<div id="newTicketModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.6); z-index:200; align-items:center; justify-content:center;">
    <div style="background:var(--pltx-surface); border:1px solid var(--pltx-border); border-radius:var(--pltx-radius-lg); padding:28px; width:100%; max-width:520px; position:relative;">
        <button onclick="document.getElementById('newTicketModal').style.display='none'" style="position:absolute; top:16px; right:16px; background:none; border:none; color:var(--pltx-text-muted); font-size:20px; cursor:pointer;">✕</button>
        <h3 style="margin:0 0 20px; font-size:17px; font-weight:700;">Neues Ticket erstellen</h3>
        <form method="POST" action="{{ route('theme.tickets.store') }}">
            @csrf
            <div class="pltx-field">
                <label class="pltx-label">Kategorie</label>
                <select name="category" class="pltx-input pltx-select" required>
                    <option value="general">Allgemein</option>
                    <option value="billing">Abrechnung</option>
                    <option value="technical">Technisch</option>
                    <option value="abuse">Missbrauch</option>
                </select>
            </div>
            <div class="pltx-field">
                <label class="pltx-label">Priorität</label>
                <select name="priority" class="pltx-input pltx-select" required>
                    <option value="low">Niedrig</option>
                    <option value="normal" selected>Normal</option>
                    <option value="high">Hoch</option>
                    <option value="urgent">Dringend</option>
                </select>
            </div>
            <div class="pltx-field">
                <label class="pltx-label">Betreff</label>
                <input type="text" name="subject" class="pltx-input" maxlength="150" required placeholder="Kurze Beschreibung…">
            </div>
            <div class="pltx-field">
                <label class="pltx-label">Nachricht</label>
                <textarea name="body" class="pltx-input pltx-textarea" maxlength="10000" required placeholder="Detaillierte Beschreibung deines Problems…"></textarea>
            </div>
            <div style="display:flex; gap:8px; justify-content:flex-end; margin-top:4px;">
                <button type="button" class="pltx-btn pltx-btn--ghost" onclick="document.getElementById('newTicketModal').style.display='none'">Abbrechen</button>
                <button type="submit" class="pltx-btn pltx-btn--primary">Ticket erstellen</button>
            </div>
        </form>
    </div>
</div>
@endsection
