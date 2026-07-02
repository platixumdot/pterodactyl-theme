<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Pltx\Theme\Models\Announcement;
use Pltx\Theme\Models\BillingAccount;
use Pltx\Theme\Models\ServerMetric;
use Pltx\Theme\Models\SystemLog;
use Pltx\Theme\Models\Ticket;

final class AdminController
{
    public function dashboard(): View
    {
        return view('pltx-theme::admin.dashboard', [
            'ticketCount'   => Ticket::query()->count(),
            'openTickets'   => Ticket::query()->where('status', 'open')->count(),
            'balances'      => BillingAccount::query()->sum('balance'),
            'latestLogs'    => SystemLog::query()->latest()->take(10)->get(),
            'announcements' => Announcement::query()->latest()->take(5)->get(),
            'latestMetrics' => ServerMetric::query()->latest()->take(5)->get(),
        ]);
    }
}
