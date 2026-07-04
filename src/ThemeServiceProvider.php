<?php

declare(strict_types=1);

namespace Pltx\Theme;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Pltx\Theme\Http\Middleware\InjectThemeCss;
use Pltx\Theme\Services\ThemeEditorService;
use Pltx\Theme\Support\Discord\DiscordWebhook;
use Pltx\Theme\Support\Update\UpdateChecker;

final class ThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pltx-theme.php',   'pltx-theme');
        $this->mergeConfigFrom(__DIR__ . '/../config/pltx-discord.php', 'pltx-discord');
        $this->mergeConfigFrom(__DIR__ . '/../config/pltx-status.php',  'pltx-status');
        $this->mergeConfigFrom(__DIR__ . '/../config/pltx-billing.php', 'pltx-billing');
        $this->mergeConfigFrom(__DIR__ . '/../config/pltx-api.php',     'pltx-api');

        // Register the SQLite connection for all theme models
        $databasePath = config('pltx-theme.database.path', storage_path('app/pltx-theme.sqlite'));
        config([
            'database.connections.pltx_theme' => [
                'driver'                 => 'sqlite',
                'database'               => $databasePath,
                'prefix'                 => '',
                'foreign_key_constraints'=> true,
            ],
        ]);

        // Singletons
        $this->app->singleton(UpdateChecker::class);
        $this->app->singleton(ThemeEditorService::class);
        $this->app->singleton(DiscordWebhook::class, fn () => new DiscordWebhook(
            config('pltx-theme.discord.webhook_url')
        ));
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

        // Inject theme CSS + JS into ALL HTML responses (including Pterodactyl core pages)
        $this->app['router']->pushMiddlewareToGroup('web', InjectThemeCss::class);

        Paginator::useBootstrapFive();

        $this->registerPublishes();
        $this->registerCommands();
        $this->registerBladeComponents();
    }

    private function registerPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config/pltx-theme.php'   => config_path('pltx-theme.php'),
            __DIR__ . '/../config/pltx-discord.php'  => config_path('pltx-discord.php'),
            __DIR__ . '/../config/pltx-status.php'   => config_path('pltx-status.php'),
            __DIR__ . '/../config/pltx-billing.php'  => config_path('pltx-billing.php'),
            __DIR__ . '/../config/pltx-api.php'      => config_path('pltx-api.php'),
        ], 'pltx-theme-config');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/pltx-theme'),
        ], 'pltx-theme-assets');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/pltx-theme'),
        ], 'pltx-theme-views');
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\InstallTheme::class,
                Console\Commands\UpdateTheme::class,
                Console\Commands\DiagnoseTheme::class,
                Console\Commands\PruneLogsCommand::class,
            ]);
        }
    }

    private function registerBladeComponents(): void
    {
        $this->callAfterResolving('blade.compiler', function ($blade): void {
            $blade->componentNamespace('Pltx\\Theme\\View\\Components', 'pltx');
        });
    }
}
