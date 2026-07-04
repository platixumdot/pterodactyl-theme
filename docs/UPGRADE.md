# Upgrade Guide

## From v1.x

1. Pull the latest code or run the update script (`scripts/update.sh`).
2. Run `php artisan pltx:install` to publish new config files and run migrations.
3. Old controller namespaces (`Pltx\Theme\Http\Controllers\AdminController` etc.)
   are preserved as backward-compatible shims — no changes required in custom routes.
4. Old `Support\DiscordWebhook`, `Support\Sanitizer`, `Support\UpdateChecker` shims
   are still loadable; migrate usages to `Support\Discord\*`, `Support\Security\*`
   and `Support\Update\*` at your own pace.
5. API routes are now versioned under `/api/theme/v1/`. The old prefix still works
   because the `routes/api.php` file uses the new V1 controllers directly.

## Config changes

Three new config files are published:
- `config/pltx-discord.php`
- `config/pltx-status.php`
- `config/pltx-billing.php`
- `config/pltx-api.php`

Run `php artisan vendor:publish --tag=pltx-theme-config --force` after upgrading.
