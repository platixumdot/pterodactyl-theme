@extends('pltx-theme::layouts.app')

@section('page-title', 'Tickets')

@section('content')
    <section class="page-header">
        <h2>Ticket-System</h2>
        <p>Kategorien, Prioritäten, Archiv, interne Notizen und Dateianhänge.</p>
    </section>

    <form class="auth-card" method="POST" action="{{ route('theme.tickets.store') }}">
        @csrf
        <div class="card-grid" style="grid-template-columns: repeat(2, minmax(0, 1fr));">
            <label>Kategorie
                <input type="text" name="category" value="general" maxlength="80">
            </label>
            <label>Priorität
                <input type="text" name="priority" value="normal" maxlength="24">
            </label>
        </div>
        <label>Betreff
            <input type="text" name="subject" maxlength="150">
        </label>
        <label>Nachricht
            <input type="text" name="body" maxlength="10000">
        </label>
        <button class="primary-button" type="submit">Ticket erstellen</button>
    </form>

    <form class="inline-form" method="GET">
        <input type="search" name="search" value="{{ $search }}" placeholder="Tickets durchsuchen">
        <button class="primary-button" type="submit">Suchen</button>
    </form>

    <div class="stack-list">
        @forelse($tickets as $ticket)
            <article class="glass-card">
                <div class="row-between">
                    <div>
                        <span class="card-kicker">{{ $ticket->category }} · {{ $ticket->priority }}</span>
                        <h3>{{ $ticket->subject }}</h3>
                    </div>
                    <span class="pill">{{ $ticket->status }}</span>
                </div>
                <p>{{ $ticket->body }}</p>
                <div class="topbar-actions" style="margin-top: 16px; flex-wrap: wrap;">
                    <form method="POST" action="{{ route('theme.tickets.close', $ticket) }}">@csrf<button class="ghost-button" type="submit">Schließen</button></form>
                    <form method="POST" action="{{ route('theme.tickets.archive', $ticket) }}">@csrf<button class="ghost-button" type="submit">Archivieren</button></form>
                </div>
            </article>
        @empty
            <article class="glass-card">Keine Tickets vorhanden.</article>
        @endforelse
    </div>

    <div class="pagination-wrap">{{ $tickets->links() }}</div>
@endsection
