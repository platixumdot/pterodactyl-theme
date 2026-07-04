@extends('pltx-theme::layouts.guest')

@section('title', '500 – Serverfehler')

@section('content')
<div class="error-screen">
    <h1 style="color:var(--pltx-danger);">500</h1>
    <p style="font-size:18px; font-weight:600; margin-bottom:8px;">Interner Serverfehler</p>
    <p class="text-muted" style="margin-bottom:24px;">Etwas ist schiefgelaufen. Bitte versuche es später erneut.</p>
    <a href="{{ route('theme.home') }}" class="pltx-btn pltx-btn--primary">← Zurück zum Dashboard</a>
</div>
@endsection
