@extends('pltx-theme::layouts.app')

@section('page-title', 'Incidents')

@section('content')
    <section class="page-header">
        <h2>Vergangene Vorfälle</h2>
        <p>Chronologische Übersicht aller Incidents und Wartungen.</p>
    </section>

    <div class="stack-list">
        @forelse($incidents as $incident)
            <article class="glass-card">
                <span class="card-kicker">{{ $incident->status }}</span>
                <h3>{{ $incident->title }}</h3>
                <p>{{ $incident->message }}</p>
            </article>
        @empty
            <article class="glass-card">Keine Incidents vorhanden.</article>
        @endforelse
    </div>
@endsection
