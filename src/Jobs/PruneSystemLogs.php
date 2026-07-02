<?php

declare(strict_types=1);

namespace Pltx\Theme\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pltx\Theme\Models\SystemLog;

final class PruneSystemLogs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly int $keepDays = 30) {}

    public function handle(): void
    {
        SystemLog::query()
            ->where('created_at', '<', now()->subDays($this->keepDays))
            ->delete();
    }
}
