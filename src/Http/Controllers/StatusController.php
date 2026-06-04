<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Pltx\Theme\Models\StatusEntry;

final class StatusController
{
    public function index(Request $request): View
    {
        return view('pltx-theme::status.index', [
            'entries' => StatusEntry::query()
                ->where('is_public', true)
                ->latest()
                ->paginate(12),
        ]);
    }

    public function incidents(): View
    {
        return view('pltx-theme::status.incidents', [
            'incidents' => StatusEntry::query()
                ->where('type', 'incident')
                ->latest()
                ->get(),
        ]);
    }
}
