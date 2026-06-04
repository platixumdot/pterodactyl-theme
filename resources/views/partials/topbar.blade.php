<header class="topbar">
    <div>
        <p class="eyebrow">Modern Pterodactyl Theme</p>
        <h1>@yield('page-title', 'Dashboard')</h1>
    </div>
    <div class="topbar-actions">
        @include('pltx-theme::partials.theme-toggle')
        <a class="primary-button" href="{{ route('theme.login') }}">Login</a>
    </div>
</header>
