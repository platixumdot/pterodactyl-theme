@extends('pltx-theme::layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h2>Dashboard</h2>
    <p>Willkommen zurück im PLTX Theme Panel.</p>
</div>

<div class="card-grid">
    @if(config('pltx-theme.features.tickets', true))
    <div class="glass-card">
        <div class="card-kicker">Support</div>
        <h3 style="margin:8px 0 4px; font-size:28px; font-weight:800;">—</h3>
        <p class="text-muted" style="margin:0; font-size:13px;">Offene Tickets</p>
        <a href="{{ route('theme.tickets.index') }}" class="pltx-btn pltx-btn--ghost pltx-btn--sm" style="margin-top:14px;">Tickets →</a>
    </div>
    @endif

    @if(config('pltx-theme.features.status_page', true))
    <div class="glass-card">
        <div class="card-kicker">Systemstatus</div>
        <h3 style="margin:8px 0 4px; font-size:28px; font-weight:800;" data-live-status>—</h3>
        <p class="text-muted" style="margin:0; font-size:13px;">Aktueller Status</p>
        <a href="{{ route('theme.status') }}" class="pltx-btn pltx-btn--ghost pltx-btn--sm" style="margin-top:14px;">Status →</a>
    </div>
    @endif

    @if(config('pltx-theme.features.billing', true))
    <div class="glass-card">
        <div class="card-kicker">Abrechnung</div>
        <h3 style="margin:8px 0 4px; font-size:28px; font-weight:800;">—</h3>
        <p class="text-muted" style="margin:0; font-size:13px;">Kontostand</p>
        <a href="{{ route('theme.billing.index') }}" class="pltx-btn pltx-btn--ghost pltx-btn--sm" style="margin-top:14px;">Billing →</a>
    </div>
    @endif
</div>
@endsection
