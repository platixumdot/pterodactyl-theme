@extends('pltx-theme::layouts.guest')

@section('content')
    <div class="error-screen">
        <p class="eyebrow">404</p>
        <h1>Seite nicht gefunden</h1>
        <p>Die angeforderte Route existiert nicht oder wurde verschoben.</p>
        <a class="primary-button" href="{{ route('theme.home') }}">Zurück zum Dashboard</a>
    </div>
@endsection
