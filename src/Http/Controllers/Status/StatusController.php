<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Status;

use Illuminate\Contracts\View\View;
use Pltx\Theme\Services\StatusService;

final class StatusController
{
    public function __construct(private readonly StatusService $status) {}

    public function index(): View
    {
        return view('pltx-theme::status.index', [
            'entries' => $this->status->publicEntries(),
        ]);
    }

    public function incidents(): View
    {
        return view('pltx-theme::status.incidents', [
            'incidents' => $this->status->incidents(),
        ]);
    }
}
