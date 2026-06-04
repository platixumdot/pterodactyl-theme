# Architektur

Dieses Paket ist als update-freundliches Laravel-Addon aufgebaut und vermeidet direkte Änderungen an Pterodactyl-Core-Dateien.

## Bausteine
- Service Provider für Routen, Views, Migrationen, Translationen und Publishes
- Eigene Web- und API-Routen
- Eigene Datenbanktabellen für Status, Tickets, Billing, Profile, News und Logs
- Veröffentlichbare Assets unter `public/vendor/pltx-theme`
- Blade-Views mit dunklem, responsivem Dashboard-Layout

## Sicherheitsprinzipien
- Blade-Escaping als Standard
- Serverseitige Validierung für Formulare
- Sanitizer für Text und HTML-Inhalte
- Konfigurationswerte über `config/pltx-theme.php`
