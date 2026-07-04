@extends('pltx-theme::layouts.app')

@section('title', 'Theme Editor')

@push('head')
<style>
.editor-wrap { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
.editor-panel { background: var(--pltx-surface); border: 1px solid var(--pltx-border); border-radius: var(--pltx-radius-lg); overflow: hidden; }
.editor-panel__head { padding: 16px 20px; border-bottom: 1px solid var(--pltx-border); display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: .06em; color: var(--pltx-text-muted); }
.editor-panel__body { padding: 20px; }
.editor-tabs { display: flex; gap: 2px; background: var(--pltx-bg); border-radius: var(--pltx-radius-md); padding: 4px; margin-bottom: 20px; }
.editor-tab { flex: 1; padding: 8px 0; text-align: center; border-radius: var(--pltx-radius-sm); font-size: 12px; font-weight: 600; cursor: pointer; border: none; background: transparent; color: var(--pltx-text-muted); transition: all var(--pltx-transition); }
.editor-tab.active { background: var(--pltx-surface2); color: var(--pltx-text); }
.tab-section { display: none; }
.tab-section.active { display: block; }
.field-group { margin-bottom: 20px; }
.field-group label { display: block; font-size: 12px; color: var(--pltx-text-muted); margin-bottom: 6px; font-weight: 500; }
.field-row { display: flex; align-items: center; gap: 8px; }
.color-swatch { width: 36px; height: 36px; border-radius: 8px; border: 2px solid var(--pltx-border); cursor: pointer; overflow: hidden; padding: 0; background: none; flex-shrink: 0; }
.color-swatch input[type=color] { width: 150%; height: 150%; margin: -25%; border: none; cursor: pointer; }
.pltx-input { background: var(--pltx-bg); border: 1px solid var(--pltx-border); border-radius: var(--pltx-radius-sm); color: var(--pltx-text); padding: 8px 10px; font-size: 13px; width: 100%; transition: border-color var(--pltx-transition); }
.pltx-input:focus { outline: none; border-color: var(--pltx-primary); }
.pltx-select { background: var(--pltx-bg); border: 1px solid var(--pltx-border); border-radius: var(--pltx-radius-sm); color: var(--pltx-text); padding: 8px 10px; font-size: 13px; width: 100%; }
.pltx-btn { padding: 10px 18px; border-radius: var(--pltx-radius-sm); font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all var(--pltx-transition); display: inline-flex; align-items: center; gap: 6px; }
.pltx-btn--primary { background: var(--pltx-primary); color: #fff; }
.pltx-btn--primary:hover { background: var(--pltx-primary-hover); }
.pltx-btn--ghost { background: var(--pltx-surface2); color: var(--pltx-text); border: 1px solid var(--pltx-border); }
.pltx-btn--ghost:hover { border-color: var(--pltx-primary); color: var(--pltx-primary); }
.pltx-btn--danger { background: rgba(239,68,68,.15); color: var(--pltx-danger); border: 1px solid rgba(239,68,68,.3); }
.pltx-btn--danger:hover { background: rgba(239,68,68,.25); }
.btn-row { display: flex; gap: 8px; flex-wrap: wrap; }
.preview-box { background: var(--pltx-card-bg); border: 1px solid var(--pltx-border); border-radius: var(--pltx-radius-lg); padding: 20px; }
.preview-topbar { background: var(--pltx-topbar-bg); border-radius: var(--pltx-radius-md); padding: 12px 16px; display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
.preview-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--pltx-primary); }
.preview-sidebar { background: var(--pltx-sidebar-bg); border-radius: var(--pltx-radius-md); width: 48px; height: 120px; display: inline-block; vertical-align: top; margin-right: 10px; }
.preview-content { display: inline-block; vertical-align: top; width: calc(100% - 70px); }
.preview-card { background: var(--pltx-card-bg); border: 1px solid var(--pltx-border); border-radius: var(--pltx-radius-md); padding: 12px; margin-bottom: 8px; }
.preview-btn-sample { background: var(--pltx-primary); color: #fff; border: none; border-radius: var(--pltx-radius-sm); padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: default; }
.preview-text { color: var(--pltx-text); font-size: 13px; font-family: var(--pltx-font-family); }
.preview-text-muted { color: var(--pltx-text-muted); font-size: 11px; font-family: var(--pltx-font-family); }
.section-divider { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--pltx-text-muted); margin-bottom: 12px; padding-bottom: 6px; border-bottom: 1px solid var(--pltx-border); }
textarea.pltx-input { min-height: 120px; resize: vertical; font-family: monospace; font-size: 12px; }
.import-area { border: 2px dashed var(--pltx-border); border-radius: var(--pltx-radius-md); padding: 20px; text-align: center; transition: border-color var(--pltx-transition); }
.import-area:hover { border-color: var(--pltx-primary); }
.live-indicator { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; color: var(--pltx-success); }
.live-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--pltx-success); animation: pulse 2s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
</style>
@endpush

@section('content')
<div style="padding: 24px;">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <div>
            <h1 style="font-size:22px; font-weight:700; margin:0;">🎨 Theme Editor</h1>
            <p style="color:var(--pltx-text-muted); font-size:13px; margin:4px 0 0;">Farben, Typografie, Abstände und mehr live anpassen</p>
        </div>
        <span class="live-indicator"><span class="live-dot"></span> Live Preview aktiv</span>
    </div>

    @if(session('status'))
    <div style="background:rgba(34,197,94,.12); border:1px solid rgba(34,197,94,.3); color:var(--pltx-success); padding:12px 16px; border-radius:var(--pltx-radius-sm); margin-bottom:20px; font-size:13px;">
        ✓ {{ session('status') }}
    </div>
    @endif

    <form id="editorForm" method="POST" action="{{ route('theme.admin.editor.update') }}">
        @csrf
        @method('PATCH')

        <div class="editor-wrap">
            {{-- ── Left: Editor panels ───────────────────────────── --}}
            <div>
                {{-- Tabs --}}
                <div class="editor-tabs" id="editorTabs">
                    <button type="button" class="editor-tab active" data-tab="colors">🎨 Farben</button>
                    <button type="button" class="editor-tab" data-tab="typography">✏️ Schrift</button>
                    <button type="button" class="editor-tab" data-tab="layout">📐 Layout</button>
                    <button type="button" class="editor-tab" data-tab="advanced">⚙️ Erweitert</button>
                    <button type="button" class="editor-tab" data-tab="import">📦 Import/Export</button>
                </div>

                {{-- Colors --}}
                <div class="tab-section active" id="tab-colors">
                    <div class="editor-panel">
                        <div class="editor-panel__body">
                            <div class="section-divider">Primärfarben</div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                @foreach([
                                    'color_primary'       => 'Primär',
                                    'color_primary_hover' => 'Primär (Hover)',
                                    'color_secondary'     => 'Sekundär',
                                    'color_accent'        => 'Akzent',
                                    'color_success'       => 'Erfolg',
                                    'color_warning'       => 'Warnung',
                                    'color_danger'        => 'Gefahr / Fehler',
                                ] as $key => $label)
                                <div class="field-group">
                                    <label>{{ $label }}</label>
                                    <div class="field-row">
                                        <button type="button" class="color-swatch" style="background:{{ $settings[$key] ?? '#000' }};">
                                            <input type="color" name="{{ $key }}" value="{{ $settings[$key] ?? '#000000' }}" class="live-color">
                                        </button>
                                        <input type="text" value="{{ $settings[$key] ?? '' }}" class="pltx-input hex-sync" data-for="{{ $key }}" style="font-family:monospace;">
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="section-divider" style="margin-top:24px;">Hintergrund & Oberflächen</div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                @foreach([
                                    'color_bg'         => 'Hintergrund',
                                    'color_surface'    => 'Oberfläche 1',
                                    'color_surface2'   => 'Oberfläche 2',
                                    'color_border'     => 'Rahmen',
                                    'color_sidebar_bg' => 'Sidebar',
                                    'color_topbar_bg'  => 'Topbar',
                                    'color_card_bg'    => 'Karte',
                                ] as $key => $label)
                                <div class="field-group">
                                    <label>{{ $label }}</label>
                                    <div class="field-row">
                                        <button type="button" class="color-swatch" style="background:{{ $settings[$key] ?? '#000' }};">
                                            <input type="color" name="{{ $key }}" value="{{ $settings[$key] ?? '#000000' }}" class="live-color">
                                        </button>
                                        <input type="text" value="{{ $settings[$key] ?? '' }}" class="pltx-input hex-sync" data-for="{{ $key }}" style="font-family:monospace;">
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="section-divider" style="margin-top:24px;">Textfarben</div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                @foreach([
                                    'color_text'       => 'Text',
                                    'color_text_muted' => 'Text gedimmt',
                                ] as $key => $label)
                                <div class="field-group">
                                    <label>{{ $label }}</label>
                                    <div class="field-row">
                                        <button type="button" class="color-swatch" style="background:{{ $settings[$key] ?? '#000' }};">
                                            <input type="color" name="{{ $key }}" value="{{ $settings[$key] ?? '#000000' }}" class="live-color">
                                        </button>
                                        <input type="text" value="{{ $settings[$key] ?? '' }}" class="pltx-input hex-sync" data-for="{{ $key }}" style="font-family:monospace;">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Typography --}}
                <div class="tab-section" id="tab-typography">
                    <div class="editor-panel">
                        <div class="editor-panel__body">
                            <div class="field-group">
                                <label>Schriftfamilie</label>
                                <select name="font_family" class="pltx-select live-input">
                                    @foreach([
                                        'Inter, system-ui, sans-serif'   => 'Inter',
                                        'Manrope, system-ui, sans-serif' => 'Manrope',
                                        'Geist, system-ui, sans-serif'   => 'Geist',
                                        'system-ui, sans-serif'          => 'System UI',
                                        'monospace'                      => 'Monospace',
                                    ] as $val => $lbl)
                                    <option value="{{ $val }}" @selected(($settings['font_family'] ?? '') === $val)>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @foreach([
                                'font_size_base'    => ['Basis-Schriftgröße', '14px'],
                                'font_size_sm'      => ['Klein', '12px'],
                                'font_size_lg'      => ['Groß', '16px'],
                                'line_height'       => ['Zeilenhöhe', '1.6'],
                            ] as $key => [$label, $placeholder])
                            <div class="field-group">
                                <label>{{ $label }}</label>
                                <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? $placeholder }}" placeholder="{{ $placeholder }}" class="pltx-input live-input">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Layout --}}
                <div class="tab-section" id="tab-layout">
                    <div class="editor-panel">
                        <div class="editor-panel__body">
                            <div class="section-divider">Border Radius</div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                @foreach([
                                    'border_radius_sm' => ['Klein', '6px'],
                                    'border_radius_md' => ['Mittel', '10px'],
                                    'border_radius_lg' => ['Groß', '16px'],
                                    'border_radius_xl' => ['Extra Groß', '24px'],
                                ] as $key => [$label, $ph])
                                <div class="field-group">
                                    <label>{{ $label }}</label>
                                    <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? $ph }}" class="pltx-input live-input">
                                </div>
                                @endforeach
                            </div>

                            <div class="section-divider" style="margin-top:24px;">Abstände</div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                @foreach([
                                    'spacing_xs' => ['XS', '4px'],
                                    'spacing_sm' => ['SM', '8px'],
                                    'spacing_md' => ['MD', '16px'],
                                    'spacing_lg' => ['LG', '24px'],
                                    'spacing_xl' => ['XL', '32px'],
                                ] as $key => [$label, $ph])
                                <div class="field-group">
                                    <label>{{ $label }}</label>
                                    <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? $ph }}" class="pltx-input live-input">
                                </div>
                                @endforeach
                            </div>

                            <div class="section-divider" style="margin-top:24px;">Sidebar & Topbar</div>
                            @foreach([
                                'sidebar_width'           => ['Sidebar-Breite', '240px'],
                                'sidebar_collapsed_width' => ['Sidebar eingeklappt', '64px'],
                                'topbar_height'           => ['Topbar-Höhe', '60px'],
                            ] as $key => [$label, $ph])
                            <div class="field-group">
                                <label>{{ $label }}</label>
                                <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? $ph }}" class="pltx-input live-input">
                            </div>
                            @endforeach

                            <div class="section-divider" style="margin-top:24px;">Schatten & Transition</div>
                            @foreach([
                                'shadow_sm'        => ['Schatten Klein', '0 1px 3px rgba(0,0,0,0.4)'],
                                'shadow_md'        => ['Schatten Mittel', '0 4px 12px rgba(0,0,0,0.5)'],
                                'shadow_lg'        => ['Schatten Groß', '0 8px 32px rgba(0,0,0,0.6)'],
                                'transition_speed' => ['Animationsgeschwindigkeit', '0.2s'],
                            ] as $key => [$label, $ph])
                            <div class="field-group">
                                <label>{{ $label }}</label>
                                <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? $ph }}" class="pltx-input live-input">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Advanced --}}
                <div class="tab-section" id="tab-advanced">
                    <div class="editor-panel">
                        <div class="editor-panel__body">
                            <div class="field-group">
                                <label>Brand-Name</label>
                                <input type="text" name="brand_name" value="{{ $settings['brand_name'] ?? 'PLTX Theme' }}" class="pltx-input">
                            </div>
                            <div class="field-group">
                                <label>Eigenes CSS (wird nach Theme-CSS eingefügt)</label>
                                <textarea name="custom_css" class="pltx-input" placeholder="/* Dein CSS hier */">{{ $settings['custom_css'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Import / Export --}}
                <div class="tab-section" id="tab-import">
                    <div class="editor-panel">
                        <div class="editor-panel__body">
                            <div class="section-divider">Export</div>
                            <p style="font-size:13px; color:var(--pltx-text-muted); margin-bottom:12px;">Aktuelle Einstellungen als JSON-Datei herunterladen.</p>
                            <a href="{{ route('theme.admin.editor.export') }}" class="pltx-btn pltx-btn--ghost" style="text-decoration:none;">⬇️ JSON exportieren</a>

                            <div class="section-divider" style="margin-top:28px;">Import</div>
                            <form method="POST" action="{{ route('theme.admin.editor.import') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="import-area">
                                    <input type="file" name="file" accept=".json" style="font-size:13px; color:var(--pltx-text);">
                                    <p style="font-size:12px; color:var(--pltx-text-muted); margin:8px 0 12px;">Nur .json-Dateien, max. 512 KB</p>
                                    <button type="submit" class="pltx-btn pltx-btn--primary">⬆️ Importieren</button>
                                </div>
                            </form>

                            <div class="section-divider" style="margin-top:28px;">Reset</div>
                            <p style="font-size:13px; color:var(--pltx-text-muted); margin-bottom:12px;">Alle Einstellungen auf Standardwerte zurücksetzen.</p>
                            <form method="POST" action="{{ route('theme.admin.editor.reset') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="pltx-btn pltx-btn--danger" onclick="return confirm('Wirklich zurücksetzen?')">🔄 Standard wiederherstellen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Right: Preview + Save ─────────────────────────────────────── --}}
            <div>
                <div class="editor-panel" style="margin-bottom:16px;">
                    <div class="editor-panel__head">👁️ Live-Vorschau</div>
                    <div class="editor-panel__body">
                        <div class="preview-box" id="livePreview">
                            <div class="preview-topbar">
                                <span class="preview-dot"></span>
                                <span class="preview-text" style="font-size:12px; font-weight:600;">{{ $settings['brand_name'] ?? 'PLTX Theme' }}</span>
                            </div>
                            <div>
                                <span class="preview-sidebar"></span>
                                <span class="preview-content">
                                    <div class="preview-card">
                                        <div class="preview-text" style="font-weight:600; margin-bottom:4px;">Dashboard</div>
                                        <div class="preview-text-muted">Übersicht & Statistiken</div>
                                    </div>
                                    <div class="preview-card" style="display:flex; align-items:center; justify-content:space-between;">
                                        <div class="preview-text-muted">Tickets offen</div>
                                        <button class="preview-btn-sample">Neu</button>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="editor-panel">
                    <div class="editor-panel__head">💾 Speichern</div>
                    <div class="editor-panel__body">
                        <p style="font-size:12px; color:var(--pltx-text-muted); margin-bottom:16px;">Einstellungen werden für alle Benutzer übernommen.</p>
                        <button type="submit" class="pltx-btn pltx-btn--primary" style="width:100%; justify-content:center;">
                            💾 Einstellungen speichern
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style id="liveStyles"></style>

@push('scripts')
<script>
(function () {
    'use strict';

    // ── Tab switching ──────────────────────────────────────────────
    document.querySelectorAll('.editor-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.editor-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-section').forEach(s => s.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById('tab-' + tab.dataset.tab)?.classList.add('active');
        });
    });

    // ── Color inputs: keep swatch + text in sync ───────────────────
    document.querySelectorAll('.live-color').forEach(input => {
        const swatch = input.closest('.color-swatch');
        const text   = document.querySelector(`.hex-sync[data-for="${input.name}"]`);

        input.addEventListener('input', () => {
            swatch.style.background = input.value;
            if (text) text.value = input.value;
            debouncePreview();
        });
        if (text) {
            text.addEventListener('input', () => {
                if (/^#[0-9a-f]{6}$/i.test(text.value)) {
                    input.value = text.value;
                    swatch.style.background = text.value;
                }
                debouncePreview();
            });
        }
    });

    document.querySelectorAll('.live-input').forEach(el => {
        el.addEventListener('input', debouncePreview);
    });

    // ── Live preview via API ───────────────────────────────────────
    let debounceTimer;
    function debouncePreview() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(applyPreview, 300);
    }

    function collectValues() {
        const data = {};
        new FormData(document.getElementById('editorForm')).forEach((v, k) => {
            if (k !== '_token' && k !== '_method') data[k] = v;
        });
        return data;
    }

    async function applyPreview() {
        try {
            const res = await fetch('{{ route("theme.admin.editor.preview") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(collectValues()),
            });
            if (res.ok) {
                const { css } = await res.json();
                document.getElementById('liveStyles').textContent = css;
            }
        } catch (e) { /* silent */ }
    }

    // initial preview on load
    applyPreview();
})();
</script>
@endpush
@endsection
