@extends('pltx-theme::layouts.guest')

@section('title', '404 – Nicht gefunden')

@section('content')
<div class="error-screen">
    <h1>404</h1>
    <p style="font-size:18px; font-weight:600; margin-bottom:8px;">Seite nicht gefunden</p>
    <p class="text-muted" style="margin-bottom:24px;">Die angeforderte Seite existiert nicht.</p>
    <a href="{{ route('theme.home') }}" class="pltx-btn pltx-btn--primary">← Zurück zum Dashboard</a>
</div>
@endsection
