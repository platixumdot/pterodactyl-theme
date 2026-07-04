<?php

declare(strict_types=1);

namespace Pltx\Theme\Console\Commands;

use Illuminate\Console\Command;
use Pltx\Theme\Jobs\PruneSystemLogs;

final class PruneLogsCommand extends Command
{
    protected $signature   = 'pltx:prune-logs {--days=30 : Number of days to keep}';
    protected $description = 'Prune old PLTX Theme system logs';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        PruneSystemLogs::dispatch($days);
        $this->info("Scheduled log pruning for entries older than {$days} days.");

        return self::SUCCESS;
    }
}
