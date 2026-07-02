<?php

declare(strict_types=1);

namespace Pltx\Theme\Console\Commands;

use Illuminate\Console\Command;

final class DiagnoseTheme extends Command
{
    protected $signature   = 'pltx:diagnose';
    protected $description = 'Run a diagnostics check on the PLTX Theme installation';

    public function handle(): int
    {
        $this->info('Running PLTX Theme diagnostics...');

        $checks = [
            'Config loaded'     => fn () => config('pltx-theme') !== null,
            'Assets published'  => fn () => file_exists(public_path('vendor/pltx-theme/css/theme.css')),
            'DB connection'     => function () {
                try {
                    \DB::connection(config('pltx-theme.database.connection', 'pltx_theme'))->getPdo();
                    return true;
                } catch (\Throwable) {
                    return false;
                }
            },
        ];

        foreach ($checks as $label => $check) {
            $pass = $check();
            $this->line(sprintf('  %-25s %s', $label, $pass ? '<info>✓ OK</info>' : '<error>✗ FAIL</error>'));
        }

        return self::SUCCESS;
    }
}
