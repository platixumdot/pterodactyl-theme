<?php

declare(strict_types=1);

namespace Pltx\Theme\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pltx\Theme\Models\ServerMetric;

final class CollectServerMetrics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly string $serverIdentifier) {}

    public function handle(): void
    {
        // Placeholder: integrate with Pterodactyl Wings API to collect real metrics.
        ServerMetric::query()->create([
            'server_identifier' => $this->serverIdentifier,
            'collected_at'      => now(),
        ]);
    }
}
