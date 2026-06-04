<aside class="sidebar">
    <div class="brand-block">
        <div class="brand-mark">P</div>
        <div>
            <div class="brand-name">{{ config('pltx-theme.brand.name', 'PLTX Theme') }}</div>
            <div class="brand-subtitle">Pterodactyl Dashboard</div>
        </div>
    </div>

    <nav class="nav-stack">
        <a href="{{ route('theme.home') }}" class="nav-link">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 11.5 12 4l8 7.5V20a1 1 0 0 1-1 1h-4.5v-6.5h-5V21H5a1 1 0 0 1-1-1z"/></svg>
            Dashboard
        </a>
        <a href="{{ route('theme.status') }}" class="nav-link">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12h4l2-4 3 8 2-4h5"/></svg>
            Status
        </a>
        <a href="{{ route('theme.tickets.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16v4a2 2 0 0 0 0 4v4H4v-4a2 2 0 0 0 0-4z"/></svg>
            Tickets
        </a>
        <a href="{{ route('theme.billing.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6h12v12H6z"/><path d="M9 10h6M9 14h4"/></svg>
            Billing
        </a>
        <a href="{{ route('theme.profile.show') }}" class="nav-link">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-7 9a7 7 0 0 1 14 0"/></svg>
            Profil
        </a>
        <a href="{{ route('theme.admin.dashboard') }}" class="nav-link nav-link-accent">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 4 7v5c0 5 3.5 8.6 8 9 4.5-.4 8-4 8-9V7z"/><path d="m9 12 2 2 4-4"/></svg>
            Admin
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="mini-stat">
            <span>Theme</span>
            <strong>v1.0</strong>
        </div>
        <div class="mini-stat">
            <span>Mode</span>
            <strong id="theme-label">Dark</strong>
        </div>
    </div>
</aside>
