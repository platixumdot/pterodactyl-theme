<nav class="sidebar" aria-label="Hauptnavigation">
    <div class="brand-block">
        <div class="brand-mark">P</div>
        <span class="brand-name">{{ config('pltx-theme.brand.name', 'PLTX') }}</span>
    </div>

    <div class="nav-section">
        <div class="nav-label">Allgemein</div>
        <a href="{{ route('theme.home') }}" class="nav-link {{ request()->routeIs('theme.home') ? 'active' : '' }}">
            @include('pltx-theme::partials.sidebar-icons', ['icon' => 'dashboard'])
            Dashboard
        </a>
        <a href="{{ route('theme.profile.show') }}" class="nav-link {{ request()->routeIs('theme.profile.*') ? 'active' : '' }}">
            @include('pltx-theme::partials.sidebar-icons', ['icon' => 'profile'])
            Profil
        </a>
    </div>

    @if(config('pltx-theme.features.tickets', true))
    <div class="nav-section">
        <div class="nav-label">Support</div>
        <a href="{{ route('theme.tickets.index') }}" class="nav-link {{ request()->routeIs('theme.tickets.*') ? 'active' : '' }}">
            @include('pltx-theme::partials.sidebar-icons', ['icon' => 'ticket'])
            Tickets
        </a>
    </div>
    @endif

    @if(config('pltx-theme.features.billing', true))
    <div class="nav-section">
        <div class="nav-label">Abrechnung</div>
        <a href="{{ route('theme.billing.index') }}" class="nav-link {{ request()->routeIs('theme.billing.*') ? 'active' : '' }}">
            @include('pltx-theme::partials.sidebar-icons', ['icon' => 'billing'])
            Abrechnung
        </a>
    </div>
    @endif

    @if(config('pltx-theme.features.status_page', true))
    <div class="nav-section">
        <div class="nav-label">System</div>
        <a href="{{ route('theme.status') }}" class="nav-link {{ request()->routeIs('theme.status*') ? 'active' : '' }}">
            @include('pltx-theme::partials.sidebar-icons', ['icon' => 'status'])
            Status
        </a>
    </div>
    @endif

    @if(config('pltx-theme.features.admin_system', true))
    <div class="nav-section">
        <div class="nav-label">Admin</div>
        <a href="{{ route('theme.admin.dashboard') }}" class="nav-link {{ request()->routeIs('theme.admin.dashboard') ? 'active' : '' }}">
            @include('pltx-theme::partials.sidebar-icons', ['icon' => 'admin'])
            Übersicht
        </a>
        <a href="{{ route('theme.admin.editor') }}" class="nav-link {{ request()->routeIs('theme.admin.editor*') ? 'active' : '' }}">
            @include('pltx-theme::partials.sidebar-icons', ['icon' => 'editor'])
            Theme Editor
        </a>
    </div>
    @endif
</nav>
