(() => {
    const root = document.documentElement;

    // ── Theme (dark / light) ────────────────────────────────────────
    const themeLabel = document.getElementById('theme-label');
    const storedTheme = localStorage.getItem('pltx-theme-mode');
    const preferredTheme = window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';

    const applyTheme = (theme) => {
        root.setAttribute('data-theme', theme);
        if (themeLabel) themeLabel.textContent = theme === 'light' ? 'Light' : 'Dark';
        localStorage.setItem('pltx-theme-mode', theme);
    };

    applyTheme(storedTheme || preferredTheme);

    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            applyTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
        });
    });

    // ── Lightweight mode ────────────────────────────────────────────
    // Priority: localStorage (user preference) → server-side meta default → off
    const lwMeta = document.querySelector('meta[name="pltx-lightweight"]');
    const lwServerDefault = lwMeta?.getAttribute('content') === 'true';
    const lwStored = localStorage.getItem('pltx-lightweight-mode');
    const lwInitial = lwStored !== null ? lwStored === 'true' : lwServerDefault;

    const lwLabel = document.getElementById('lw-label');

    const applyLightweight = (enabled) => {
        root.setAttribute('data-lightweight', enabled ? 'true' : 'false');
        localStorage.setItem('pltx-lightweight-mode', enabled ? 'true' : 'false');
        if (lwLabel) lwLabel.textContent = enabled ? 'On' : 'Off';

        // Hide/show decorative elements that may have been server-rendered
        document.querySelectorAll('.theme-bg, .theme-grid').forEach((el) => {
            el.style.display = enabled ? 'none' : '';
        });
    };

    applyLightweight(lwInitial);

    document.querySelectorAll('[data-lightweight-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            applyLightweight(root.getAttribute('data-lightweight') !== 'true');
        });
    });

    // ── Live data polling ───────────────────────────────────────────
    const liveStatus = document.querySelector('[data-live-status]');
    const liveUpdate = document.querySelector('[data-live-update]');

    const refreshLiveData = async () => {
        try {
            const [statusRes, updateRes] = await Promise.all([
                fetch('/api/theme/status', { headers: { Accept: 'application/json' } }),
                fetch('/api/theme/update',  { headers: { Accept: 'application/json' } }),
            ]);

            if (liveStatus && statusRes.ok) {
                liveStatus.textContent = (await statusRes.json()).status?.status ?? 'unknown';
            }
            if (liveUpdate && updateRes.ok) {
                const u = await updateRes.json();
                liveUpdate.textContent = u.update_available ? `Update ${u.latest}` : 'Current';
            }
        } catch {
            // API unavailable — keep static rendering.
        }
    };

    // Single fetch on load for all modes.
    // Polling every 30 s is skipped in lightweight mode to reduce background CPU/network usage.
    refreshLiveData();
    if (!lwInitial) {
        window.setInterval(refreshLiveData, 30_000);
    }
})();
