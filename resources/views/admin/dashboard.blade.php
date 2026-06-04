@extends('pltx-theme::layouts.app')

@section('page-title', 'Admin Dashboard')

@section('content')
    <section class="page-header">
        <h2>Admin-System</h2>
        <p>Erweiterte Benutzerverwaltung, News, Widgets und Systemprotokolle.</p>
    </section>

    <section class="card-grid">
        <article class="glass-card"><span class="card-kicker">Tickets</span><h3>{{ $ticketCount }}</h3><p>Gesamte Tickets</p></article>
        <article class="glass-card"><span class="card-kicker">Offen</span><h3>{{ $openTickets }}</h3><p>Aktive Tickets</p></article>
        <article class="glass-card"><span class="card-kicker">Guthaben</span><h3>{{ number_format((float) $balances, 2, ',', '.') }}</h3><p>Gesamtsaldo</p></article>
    </section>
@endsection
