@extends('pltx-theme::layouts.app')

@section('title', 'Systemstatus')

@section('content')
<div class="page-header">
    <h2>Systemstatus</h2>
    <p>Aktuelle Betriebsstatus-Meldungen und Vorfälle.</p>
</div>

<div class="pltx-card">
    <table class="pltx-table">
        <thead>
            <tr><th>Typ</th><th>Titel</th><th>Status</th><th>Von</th><th>Bis</th></tr>
        </thead>
        <tbody>
            @forelse($entries as $entry)
            <tr>
                <td><span class="pltx-badge pltx-badge--gray">{{ $entry->type }}</span></td>
                <td>{{ $entry->title }}</td>
                <td>
                    @php $c = match($entry->status) { 'operational'=>'green','degraded'=>'yellow','outage'=>'red', default=>'gray' }; @endphp
                    <span class="pltx-badge pltx-badge--{{ $c }}">{{ ucfirst($entry->status) }}</span>
                </td>
                <td class="text-muted">{{ $entry->starts_at?->format('d.m.Y H:i') ?? '—' }}</td>
                <td class="text-muted">{{ $entry->ends_at?->format('d.m.Y H:i') ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; padding:32px; color:var(--pltx-text-muted);">Keine Einträge vorhanden.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($entries->hasPages())
    <div style="padding:16px 20px; border-top:1px solid var(--pltx-border);">
        {{ $entries->links() }}
    </div>
    @endif
</div>
@endsection
