# Architektur

Dieses Paket ist als update-freundliches Laravel-Addon aufgebaut und vermeidet direkte Änderungen an Pterodactyl-Core-Dateien. Alle Theme-Daten leben in einer eigenen SQLite-Datenbank, getrennt von der Panel-MySQL.

## Bausteine

- **Service Provider** (`src/ThemeServiceProvider.php`) – registriert Routen, Views, Migrationen, Übersetzungen und Publishes.
- **Web-Routen** (`routes/web.php`) – Dashboard, Status, Tickets, Billing, Profil, Server-Detail, Admin-Dashboard, Discord-Auth, alle unter `/theme`.
- **API-Routen** (`routes/api.php`) – eigene REST-API unter `/api/theme`.
- **Datenbanktabellen** – Status, Tickets, Billing, Profile, News und Logs, definiert in `database/migrations`.
- **Veröffentlichbare Assets** unter `public/vendor/pltx-theme`.
- **Blade-Views** mit dunklem, responsivem Dashboard-Layout (`resources/views`).

## Sicherheitsprinzipien

- Blade-Escaping als Standard
- Serverseitige Validierung für Formulare
- Sanitizer für Text- und HTML-Inhalte
- Konfigurationswerte zentral über `config/pltx-theme.php`
