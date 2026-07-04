# Development Guide

## Structure Overview

```
src/
├── Console/Commands/       # Artisan commands (install, update, diagnose, prune)
├── Events/                 # Domain events (TicketCreated, DiscordLinked, …)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin area controllers
│   │   ├── Api/V1/         # REST API (versioned)
│   │   ├── Auth/           # Discord OAuth
│   │   ├── Billing/
│   │   ├── Profile/
│   │   ├── Server/
│   │   ├── Status/
│   │   └── Ticket/
│   ├── Middleware/         # InjectThemeCss, EnsureThemeEnabled, ThemeAdmin, …
│   └── Requests/           # Form Request validation classes
├── Jobs/                   # Queueable background jobs
├── Listeners/              # Event listeners
├── Models/                 # Eloquent models
├── Policies/               # Authorization policies
├── Services/               # Business logic layer
└── Support/
    ├── Discord/            # DiscordWebhook
    ├── Security/           # Sanitizer
    └── Update/             # UpdateChecker
```

## Adding a new feature

1. Create a **Service** in `src/Services/` with the business logic.
2. Create a **Controller** in the relevant `src/Http/Controllers/<Module>/` folder.
3. Add a **Form Request** in `src/Http/Requests/<Module>/` for validation.
4. Fire **Events** from the service and attach **Listeners** if needed.
5. Register routes in `routes/web.php` or `routes/api.php`.
6. Write tests in `tests/Feature/` and `tests/Unit/`.

## Artisan Commands

| Command | Description |
|---------|-------------|
| `php artisan pltx:install` | Publish config, assets and run migrations |
| `php artisan pltx:update` | Check for available updates |
| `php artisan pltx:diagnose` | Verify installation health |
| `php artisan pltx:prune-logs` | Remove old system logs |
