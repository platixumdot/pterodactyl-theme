<header class="topbar">
    <div class="d-flex align-center gap-8">
        <button class="pltx-btn pltx-btn--ghost pltx-btn--sm" data-sidebar-toggle aria-label="Sidebar umschalten">☰</button>
        <span class="topbar-title">@yield('title', config('pltx-theme.brand.name', 'PLTX Theme'))</span>
    </div>

    <div class="d-flex align-center gap-8">
        {{-- Live status indicator --}}
        @if(config('pltx-theme.features.status_page', true))
        <span style="font-size:12px; color:var(--pltx-text-muted);">
            Status: <strong data-live-status>—</strong>
        </span>
        @endif

        {{-- Update badge --}}
        <span style="font-size:12px; color:var(--pltx-text-muted);">
            <span data-live-update></span>
        </span>

        {{-- Lightweight toggle --}}
        <button class="pltx-btn pltx-btn--ghost pltx-btn--sm" data-lightweight-toggle title="Leichtgewichtsmodus">
            ⚡ <span data-lw-label>Off</span>
        </button>

        {{-- Dark/light toggle --}}
        <button class="pltx-btn pltx-btn--ghost pltx-btn--sm" data-theme-toggle title="Farbschema">
            🌙 <span data-theme-label>Dark</span>
        </button>
    </div>
</header>
