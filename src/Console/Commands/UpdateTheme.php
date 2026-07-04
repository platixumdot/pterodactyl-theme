<?php

declare(strict_types=1);

namespace Pltx\Theme\Console\Commands;

use Illuminate\Console\Command;
use Pltx\Theme\Support\Update\UpdateChecker;

final class UpdateTheme extends Command
{
    protected $signature   = 'pltx:update';
    protected $description = 'Check for and display available PLTX Theme updates';

    public function __construct(private readonly UpdateChecker $checker)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $current = $this->checker->currentVersion();
        $latest  = $this->checker->latestVersion();

        $this->line("Current version : <info>{$current}</info>");
        $this->line("Latest version  : <info>" . ($latest ?? 'unknown') . "</info>");

        if ($this->checker->hasUpdate()) {
            $this->warn("An update is available. Please run the update script.");
        } else {
            $this->info('You are running the latest version.');
        }

        return self::SUCCESS;
    }
}
