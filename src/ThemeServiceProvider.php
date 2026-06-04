<?php

declare(strict_types=1);

namespace Pltx\Theme;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

final class ThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pltx-theme.php', 'pltx-theme');
        $databasePath = config('pltx-theme.database.path', storage_path('app/pltx-theme.sqlite'));
        config([
            'database.connections.pltx_theme' => [
                'driver' => 'sqlite',
                'database' => $databasePath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'pltx-theme');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'pltx-theme');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if (config('pltx-theme.routes.enabled', true)) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        }

        Paginator::useBootstrapFive();

        $this->publishes([
            __DIR__ . '/../config/pltx-theme.php' => config_path('pltx-theme.php'),
        ], 'pltx-theme-config');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/pltx-theme'),
        ], 'pltx-theme-assets');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/pltx-theme'),
        ], 'pltx-theme-views');
    }
}
