/* PLTX Theme JS */
(() => {
    'use strict';
    const root = document.documentElement;

    // ── Dark/Light toggle ──────────────────────────────────────────
    const stored = localStorage.getItem('pltx-theme-mode');
    const preferred = window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
    const applyTheme = (t) => {
        root.setAttribute('data-theme', t);
        localStorage.setItem('pltx-theme-mode', t);
        document.querySelectorAll('[data-theme-label]').forEach(el => {
            el.textContent = t === 'light' ? 'Light' : 'Dark';
        });
    };
    applyTheme(stored || preferred);
    document.querySelectorAll('[data-theme-toggle]').forEach(btn =>
        btn.addEventListener('click', () =>
            applyTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark')
        )
    );

    // ── Lightweight mode ───────────────────────────────────────────
    const lwMeta = document.querySelector('meta[name="pltx-lightweight"]');
    const lwDefault = lwMeta?.getAttribute('content') === 'true';
    const lwStored  = localStorage.getItem('pltx-lightweight-mode');
    const applyLw = (on) => {
        root.setAttribute('data-lightweight', on ? 'true' : 'false');
        localStorage.setItem('pltx-lightweight-mode', on ? 'true' : 'false');
        document.querySelectorAll('[data-lw-label]').forEach(el => {
            el.textContent = on ? 'On' : 'Off';
        });
        document.querySelectorAll('.theme-bg, .theme-grid').forEach(el => {
            el.style.display = on ? 'none' : '';
        });
    };
    applyLw(lwStored !== null ? lwStored === 'true' : lwDefault);
    document.querySelectorAll('[data-lightweight-toggle]').forEach(btn =>
        btn.addEventListener('click', () =>
            applyLw(root.getAttribute('data-lightweight') !== 'true')
        )
    );

    // ── Mobile sidebar toggle ──────────────────────────────────────
    document.querySelectorAll('[data-sidebar-toggle]').forEach(btn =>
        btn.addEventListener('click', () =>
            document.querySelector('.sidebar')?.classList.toggle('sidebar--open')
        )
    );

    // ── Live data polling ──────────────────────────────────────────
    const liveEl = (sel) => document.querySelector(sel);
    const poll = async () => {
        try {
            const prefix = window.__pltxApiPrefix || '/api/theme/v1';
            const [sRes, uRes] = await Promise.all([
                fetch(`${prefix}/status`, { headers: { Accept: 'application/json' } }),
                fetch(`${prefix}/update`, { headers: { Accept: 'application/json' } }),
            ]);
            if (sRes.ok) {
                const d = await sRes.json();
                const el = liveEl('[data-live-status]');
                if (el) el.textContent = d.status?.status ?? d.status ?? 'operational';
            }
            if (uRes.ok) {
                const d = await uRes.json();
                const el = liveEl('[data-live-update]');
                if (el) el.textContent = d.update_available ? `v${d.latest} verfügbar` : 'Aktuell';
            }
        } catch (_) {}
    };
    if (!root.getAttribute('data-lightweight') || root.getAttribute('data-lightweight') === 'false') {
        poll();
        setInterval(poll, 60000);
    }
})();
