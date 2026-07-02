# Security Guide

## Input Sanitisation

All user input passes through `Pltx\Theme\Support\Security\Sanitizer`:

- `Sanitizer::text()` – strips HTML tags, collapses whitespace, truncates.
- `Sanitizer::html()` – removes `<script>` tags, keeps safe HTML subset, truncates.

## Form Request Validation

Every mutating endpoint uses a dedicated `FormRequest` class so validation is
centralised and never bypassed.

## Policies

`TicketPolicy` and `BillingPolicy` gate access at the model level. Register
them in your application's `AuthServiceProvider` as needed.

## Middleware

| Middleware | Purpose |
|---|---|
| `InjectThemeCss` | Injects CSS/JS into HTML responses |
| `EnsureThemeEnabled` | Aborts 503 when theme routes are disabled |
| `ThemeAdmin` | Restricts access to admin-only areas |
| `RequireDiscord` | Aborts 503 when Discord integration is off |
| `ThemeMaintenance` | Allows IP-based bypass during maintenance |

## Reporting vulnerabilities

Please report security issues via private email rather than opening public issues.
