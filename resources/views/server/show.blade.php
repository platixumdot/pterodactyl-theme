@extends('pltx-theme::layouts.app')

@section('page-title', 'Server')

@section('content')
    <section class="page-header">
        <h2>Server {{ $server }}</h2>
        <p>Erweiterte Ressourcenanzeige und Live-Diagramme für CPU, RAM, Netzwerk und Speicher.</p>
    </section>

    <section class="card-grid">
        @forelse($metrics as $metric)
            <article class="glass-card">
                <span class="card-kicker">{{ $metric->created_at->format('d.m.Y H:i') }}</span>
                <h3>CPU {{ $metric->cpu }}%</h3>
                <p>RAM {{ $metric->memory }}% · Disk {{ $metric->disk }}%</p>
            </article>
        @empty
            <article class="glass-card">Keine Metriken vorhanden.</article>
        @endforelse
    </section>
@endsection
