(() => {
    const root = document.documentElement;
    const label = document.getElementById('theme-label');
    const storedTheme = localStorage.getItem('pltx-theme-mode');
    const preferred = window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';

    const applyTheme = (theme) => {
        root.setAttribute('data-theme', theme);
        if (label) {
            label.textContent = theme === 'light' ? 'Light' : 'Dark';
        }
        localStorage.setItem('pltx-theme-mode', theme);
    };

    applyTheme(storedTheme || preferred);

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const current = root.getAttribute('data-theme') || 'dark';
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });
    });

    const liveStatus = document.querySelector('[data-live-status]');
    const liveUpdate = document.querySelector('[data-live-update]');

    const refreshLiveData = async () => {
        try {
            const [statusResponse, updateResponse] = await Promise.all([
                fetch('/api/theme/status', { headers: { Accept: 'application/json' } }),
                fetch('/api/theme/update', { headers: { Accept: 'application/json' } }),
            ]);

            if (liveStatus && statusResponse.ok) {
                const statusPayload = await statusResponse.json();
                liveStatus.textContent = statusPayload.status?.status ?? 'unknown';
            }

            if (liveUpdate && updateResponse.ok) {
                const updatePayload = await updateResponse.json();
                liveUpdate.textContent = updatePayload.update_available ? `Update ${updatePayload.latest}` : 'Current';
            }
        } catch {
            // Fallback to static rendering when the API is unavailable.
        }
    };

    refreshLiveData();
    window.setInterval(refreshLiveData, 30000);
})();
