@extends('pltx-theme::layouts.app')

@section('page-title', 'Status')

@section('content')
    <section class="page-header">
        <h2>Öffentliche Statusseite</h2>
        <p>Panel-, Node-, Datenbank- und Netzwerkstatus mit Incident-Verlauf.</p>
    </section>

    <div class="card-grid">
        <article class="glass-card"><span class="card-kicker">Panel</span><h3 data-live-status>Operational</h3></article>
        <article class="glass-card"><span class="card-kicker">Incidents</span><h3>{{ $entries->total() }}</h3></article>
        <article class="glass-card"><span class="card-kicker">Updates</span><h3 data-live-update>Current</h3></article>
    </div>

    <div class="table-card">
        <table>
            <thead><tr><th>Typ</th><th>Titel</th><th>Status</th><th>Zeitraum</th></tr></thead>
            <tbody>
                @forelse($entries as $entry)
                    <tr>
                        <td>{{ $entry->type }}</td>
                        <td>{{ $entry->title }}</td>
                        <td>{{ $entry->status }}</td>
                        <td>{{ optional($entry->starts_at)->format('d.m.Y H:i') ?? '-' }} - {{ optional($entry->ends_at)->format('d.m.Y H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">Keine Einträge vorhanden.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
