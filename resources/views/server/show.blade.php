@extends('pltx-theme::layouts.app')

@section('title', 'Server')

@section('content')
<div class="page-header">
    <h2>Server: <code>{{ $server }}</code></h2>
    <p>Letzte Metriken und Ressourcenauslastung.</p>
</div>

<div class="pltx-card">
    <table class="pltx-table">
        <thead><tr><th>Zeitpunkt</th><th>CPU</th><th>RAM</th><th>Disk</th><th>Net ↓</th><th>Net ↑</th></tr></thead>
        <tbody>
            @forelse($metrics as $m)
            <tr>
                <td class="text-muted">{{ $m->collected_at?->format('d.m.Y H:i') ?? $m->created_at?->format('d.m.Y H:i') }}</td>
                <td>{{ $m->cpu ?? '—' }}%</td>
                <td>{{ $m->memory ?? '—' }} MB</td>
                <td>{{ $m->disk ?? '—' }} MB</td>
                <td>{{ $m->network_in ?? '—' }}</td>
                <td>{{ $m->network_out ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; padding:32px; color:var(--pltx-text-muted);">Keine Metriken vorhanden.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
