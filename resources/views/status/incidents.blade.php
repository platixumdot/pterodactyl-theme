@extends('pltx-theme::layouts.app')

@section('title', 'Vorfälle')

@section('content')
<div class="page-header">
    <h2>Vorfälle</h2>
    <p>Gemeldete Systemvorfälle und deren Status.</p>
</div>

<div class="pltx-card">
    @forelse($incidents as $incident)
    <div style="padding:20px; border-bottom:1px solid var(--pltx-border);">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;">
            <strong>{{ $incident->title }}</strong>
            @php $c = match($incident->status) { 'operational'=>'green','degraded'=>'yellow','outage'=>'red', default=>'gray' }; @endphp
            <span class="pltx-badge pltx-badge--{{ $c }}">{{ ucfirst($incident->status) }}</span>
        </div>
        @if($incident->message)
        <p class="text-muted" style="margin:0 0 8px; font-size:13px;">{{ $incident->message }}</p>
        @endif
        <span class="text-muted" style="font-size:11px;">{{ $incident->created_at?->format('d.m.Y H:i') }}</span>
    </div>
    @empty
    <div style="padding:40px; text-align:center; color:var(--pltx-text-muted);">Keine Vorfälle vorhanden.</div>
    @endforelse
</div>
@endsection
