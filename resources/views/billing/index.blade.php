@extends('pltx-theme::layouts.app')

@section('title', 'Abrechnung')

@section('content')
<div class="page-header">
    <h2>Abrechnung</h2>
    <p>Konten, Transaktionen und Rechnungen.</p>
</div>

<div class="card-grid">
    <div class="glass-card">
        <div class="card-kicker">Konten</div>
        <h3 style="margin:8px 0 4px; font-size:28px; font-weight:800;">{{ $accounts->count() }}</h3>
        <p class="text-muted" style="margin:0; font-size:13px;">Aktive Konten</p>
    </div>
    <div class="glass-card">
        <div class="card-kicker">Transaktionen</div>
        <h3 style="margin:8px 0 4px; font-size:28px; font-weight:800;">{{ $transactions->count() }}</h3>
        <p class="text-muted" style="margin:0; font-size:13px;">Letzte Transaktionen</p>
    </div>
    <div class="glass-card">
        <div class="card-kicker">Rechnungen</div>
        <h3 style="margin:8px 0 4px; font-size:28px; font-weight:800;">{{ $invoices->count() }}</h3>
        <p class="text-muted" style="margin:0; font-size:13px;">Letzte Rechnungen</p>
    </div>
</div>

<div class="pltx-card">
    <div class="pltx-card__header">Letzte Transaktionen</div>
    <table class="pltx-table">
        <thead><tr><th>#</th><th>Typ</th><th>Betrag</th><th>Datum</th></tr></thead>
        <tbody>
            @forelse($transactions as $tx)
            <tr>
                <td class="text-muted">#{{ $tx->id }}</td>
                <td>{{ $tx->type }}</td>
                <td>{{ number_format((float)$tx->amount, 2, ',', '.') }} €</td>
                <td class="text-muted">{{ $tx->created_at?->format('d.m.Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; padding:32px; color:var(--pltx-text-muted);">Keine Transaktionen vorhanden.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
