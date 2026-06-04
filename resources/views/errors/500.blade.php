@extends('pltx-theme::layouts.guest')

@section('content')
    <div class="error-screen">
        <p class="eyebrow">500</p>
        <h1>Serverfehler</h1>
        <p>Ein interner Fehler ist aufgetreten. Bitte prüfe die Logs und versuche es erneut.</p>
        <a class="primary-button" href="{{ route('theme.home') }}">Dashboard öffnen</a>
    </div>
@endsection
