@extends('pltx-theme::layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    <section class="hero-panel">
        <div>
            <p class="eyebrow">Hosting Control Center</p>
            <h2>Schwarz, Blau und präzise konstruierte Bedienoberflächen.</h2>
            <p class="hero-copy">Statusseite, Tickets, Billing, Profile und Admin-Module in einer update-freundlichen Laravel-Struktur für Pterodactyl.</p>
        </div>
        <div class="hero-stats">
            <div class="metric-card"><span>Panel</span><strong data-live-status>Operational</strong></div>
            <div class="metric-card"><span>Nodes</span><strong>12</strong></div>
            <div class="metric-card"><span>Updates</span><strong data-live-update>Current</strong></div>
        </div>
    </section>

    <section class="card-grid">
        <article class="glass-card">
            <span class="card-kicker">Statusseite</span>
            <h3>Panel, Node, DB und Netzwerk</h3>
            <p>Öffentliche Statusübersicht mit Incident-Historie und Wartungsfenstern.</p>
        </article>
        <article class="glass-card">
            <span class="card-kicker">Tickets</span>
            <h3>Kategorien, Prioritäten, Archiv</h3>
            <p>Support-Workflow mit internen Notizen, Anhängen und schneller Suche.</p>
        </article>
        <article class="glass-card">
            <span class="card-kicker">Billing</span>
            <h3>Guthaben, Rechnungen, Gutscheine</h3>
            <p>Stripe- und PayPal-fähige Struktur für Transaktionen und Abrechnung.</p>
        </article>
    </section>
@endsection
