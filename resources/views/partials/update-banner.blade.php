{{-- Update banner — only shown when an update is detected by JS polling --}}
<div class="update-banner" id="pltxUpdateBanner" style="display:none;">
    <span>🚀 Eine neue Version ist verfügbar. <strong data-update-version></strong></span>
    <a href="{{ route('theme.admin.dashboard') }}" class="pltx-btn pltx-btn--primary pltx-btn--sm">Mehr erfahren</a>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const banner = document.getElementById('pltxUpdateBanner');
    const verEl  = document.querySelector('[data-update-version]');
    fetch('/api/theme/v1/update', { headers: { Accept: 'application/json' } })
        .then(r => r.ok ? r.json() : null)
        .then(d => {
            if (d?.update_available && banner) {
                if (verEl) verEl.textContent = `v${d.latest}`;
                banner.style.display = 'flex';
            }
        }).catch(() => {});
});
</script>
