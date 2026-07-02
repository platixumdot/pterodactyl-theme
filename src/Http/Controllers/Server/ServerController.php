<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Server;

use Illuminate\Contracts\View\View;
use Pltx\Theme\Models\ServerMetric;

final class ServerController
{
    public function show(string $server): View
    {
        $metrics = ServerMetric::query()
            ->where('server_identifier', $server)
            ->latest()
            ->take(24)
            ->get();

        return view('pltx-theme::server.show', compact('server', 'metrics'));
    }
}
