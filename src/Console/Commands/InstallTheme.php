<?php

declare(strict_types=1);

namespace Pltx\Theme\Console\Commands;

use Illuminate\Console\Command;

final class InstallTheme extends Command
{
    protected $signature   = 'pltx:install';
    protected $description = 'Install and initialise the PLTX Theme package';

    public function handle(): int
    {
        $this->info('Installing PLTX Theme...');
        $this->call('vendor:publish', ['--tag' => 'pltx-theme-config', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'pltx-theme-assets', '--force' => true]);
        $this->call('migrate', ['--path' => 'database/migrations', '--force' => true]);
        $this->info('PLTX Theme installed successfully.');

        return self::SUCCESS;
    }
}
