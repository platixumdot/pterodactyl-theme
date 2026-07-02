<header class="topbar">
    <div>
        <p class="eyebrow">Modern Pterodactyl Theme</p>
        <h1>@yield('page-title', 'Dashboard')</h1>
    </div>
    <div class="topbar-actions">
        @include('pltx-theme::partials.theme-toggle')
        <button class="ghost-button lw-toggle-btn" data-lightweight-toggle title="Lightweight Mode umschalten" aria-label="Lightweight Mode umschalten">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
            <span id="lw-label">Off</span>
        </button>
        <a class="primary-button" href="{{ route('theme.login') }}">Login</a>
    </div>
</header>
