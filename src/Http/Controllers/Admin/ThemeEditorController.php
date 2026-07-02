<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Pltx\Theme\Services\ThemeEditorService;

final class ThemeEditorController
{
    public function __construct(private readonly ThemeEditorService $editor) {}

    public function index(): View
    {
        return view('pltx-theme::admin.editor', [
            'settings' => $this->editor->load(),
            'defaults' => ThemeEditorService::defaults(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->editor->save($request->except(['_token', '_method']));

        return redirect()
            ->route('theme.admin.editor')
            ->with('status', 'Theme gespeichert.');
    }

    public function reset(): RedirectResponse
    {
        $this->editor->reset();

        return redirect()
            ->route('theme.admin.editor')
            ->with('status', 'Theme auf Standard zurückgesetzt.');
    }

    public function exportJson(): Response
    {
        return response($this->editor->exportJson(), 200, [
            'Content-Type'        => 'application/json',
            'Content-Disposition' => 'attachment; filename="pltx-theme-export.json"',
        ]);
    }

    public function importJson(Request $request): RedirectResponse
    {
        $request->validate(['file' => ['required', 'file', 'mimes:json', 'max:512']]);

        $json    = file_get_contents($request->file('file')->getRealPath());
        $success = $this->editor->importJson($json ?: '{}');

        return redirect()
            ->route('theme.admin.editor')
            ->with('status', $success ? 'Theme-Einstellungen importiert.' : 'Ungültige JSON-Datei.');
    }

    /** Used by InjectThemeCss to serve dynamic CSS */
    public function dynamicCss(): Response
    {
        $css = $this->editor->toCss($this->editor->load());

        return response($css, 200, [
            'Content-Type'  => 'text/css',
            'Cache-Control' => 'public, max-age=60',
        ]);
    }

    /** Live-preview API — returns CSS from posted values without saving */
    public function preview(Request $request): JsonResponse
    {
        $css = $this->editor->toCss(
            array_merge(ThemeEditorService::defaults(), $request->all())
        );

        return response()->json(['css' => $css]);
    }
}
