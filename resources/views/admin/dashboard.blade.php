@extends('pltx-theme::layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between;">
    <div>
        <h2>Admin Dashboard</h2>
        <p>Systemübersicht, Tickets, Logs und Einstellungen.</p>
    </div>
    <a href="{{ route('theme.admin.editor') }}" class="pltx-btn pltx-btn--primary">
        🎨 Theme Editor
    </a>
</div>

<div class="card-grid">
    <div class="glass-card">
        <div class="card-kicker">Tickets gesamt</div>
        <h3 style="margin:8px 0 4px; font-size:32px; font-weight:800;">{{ $ticketCount }}</h3>
        <span class="pltx-badge pltx-badge--blue">{{ $openTickets }} offen</span>
    </div>
    <div class="glass-card">
        <div class="card-kicker">Gesamtsaldo</div>
        <h3 style="margin:8px 0 4px; font-size:32px; font-weight:800;">{{ number_format((float)$balances, 2, ',', '.') }} €</h3>
        <span class="text-muted" style="font-size:12px;">Alle Konten summiert</span>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
    {{-- Latest system logs --}}
    <div class="pltx-card">
        <div class="pltx-card__header">Systemprotokolle</div>
        <table class="pltx-table">
            <thead><tr><th>Level</th><th>Quelle</th><th>Meldung</th><th>Datum</th></tr></thead>
            <tbody>
                @forelse($latestLogs as $log)
                <tr>
                    <td><span class="pltx-badge pltx-badge--{{ match($log->level ?? '') { 'error','critical'=>'red','warning'=>'yellow', default=>'gray' } }}">{{ $log->level ?? '—' }}</span></td>
                    <td class="text-muted">{{ $log->source ?? '—' }}</td>
                    <td>{{ Str::limit($log->message ?? '', 60) }}</td>
                    <td class="text-muted">{{ $log->created_at?->format('d.m.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:20px; color:var(--pltx-text-muted);">Keine Logs.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Latest announcements --}}
    <div class="pltx-card">
        <div class="pltx-card__header">Neueste Ankündigungen</div>
        @forelse($announcements as $ann)
        <div style="padding:14px 20px; border-bottom:1px solid var(--pltx-border);">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
                <strong style="font-size:13px;">{{ $ann->title }}</strong>
                @if($ann->is_pinned)<span class="pltx-badge pltx-badge--yellow">📌 Angepinnt</span>@endif
            </div>
            <span class="text-muted" style="font-size:11px;">{{ $ann->published_at?->format('d.m.Y') ?? $ann->created_at?->format('d.m.Y') }}</span>
        </div>
        @empty
        <div style="padding:32px; text-align:center; color:var(--pltx-text-muted);">Keine Ankündigungen.</div>
        @endforelse
    </div>
</div>
@endsection
