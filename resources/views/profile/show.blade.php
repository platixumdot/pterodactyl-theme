@extends('pltx-theme::layouts.app')

@section('page-title', 'Profil')

@section('content')
    <section class="page-header">
        <h2>Benutzerprofil</h2>
        <p>Banner, Biografie, Aktivitätsverlauf und erweiterte Profileinstellungen.</p>
    </section>

    <section class="card-grid">
        <article class="glass-card">
            <span class="card-kicker">Banner</span>
            <h3>{{ $profile?->banner_path ? 'Hinterlegt' : 'Nicht gesetzt' }}</h3>
            <p>{{ $profile?->banner_path ?? 'Kein Banner vorhanden.' }}</p>
        </article>
        <article class="glass-card">
            <span class="card-kicker">Biografie</span>
            <h3>Profiltext</h3>
            <p>{{ $profile?->bio ?? 'Noch keine Biografie hinterlegt.' }}</p>
        </article>
        <article class="glass-card">
            <span class="card-kicker">Aktivität</span>
            <h3>{{ count($profile?->activity ?? []) }}</h3>
            <p>Einträge im Aktivitätsverlauf</p>
        </article>
    </section>
@endsection
