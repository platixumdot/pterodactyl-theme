@extends('pltx-theme::layouts.guest')

@section('content')
    <div class="auth-layout">
        <div class="auth-copy">
            <p class="eyebrow">Secure access</p>
            <h1>Modernes Login für das Pterodactyl Panel.</h1>
            <p>Discord OAuth2, mehrsprachige Oberfläche und ein reduziertes, markantes Dark-Theme.</p>
        </div>

        <form class="auth-card" method="POST" action="#">
            @csrf
            <label>E-Mail
                <input type="email" name="email" placeholder="admin@example.com">
            </label>
            <label>Passwort
                <input type="password" name="password" placeholder="••••••••">
            </label>
            <button class="primary-button button-full" type="submit">Anmelden</button>
            <a class="discord-button" href="{{ route('theme.auth.discord.redirect') }}">Mit Discord anmelden</a>
        </form>
    </div>
@endsection
