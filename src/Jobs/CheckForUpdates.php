<?php

declare(strict_types=1);

namespace Pltx\Theme\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pltx\Theme\Support\Update\UpdateChecker;

final class CheckForUpdates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(UpdateChecker $checker): void
    {
        if ($checker->hasUpdate()) {
            logger()->info('PLTX Theme update available', [
                'current' => $checker->currentVersion(),
                'latest'  => $checker->latestVersion(),
            ]);
        }
    }
}
