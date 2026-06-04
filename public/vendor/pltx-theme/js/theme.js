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
})();
