# PLTX Pterodactyl Theme

Modernes Pterodactyl-Theme mit Addon-Struktur für Statusseite, Tickets, Billing, Profile, Admin-Module und REST-API.

## Fokus
- Update-freundliche Laravel-Paketstruktur
- Keine direkten Änderungen an Core-Dateien
- Dunkles Dashboard-Design mit Blau als Akzentfarbe
- Deutsch/Englisch vorbereitet
- Install-, Update- und Uninstall-Skripte enthalten

## Installation
Dieses Repository ist als Paket-/Addon-Grundlage aufgebaut. Für ein echtes Pterodactyl-Panel wird das Paket per Composer eingebunden und anschließend mit den bereitgestellten Publish- und Migrations-Kommandos aktiviert. Das Theme speichert seine Daten in einer eigenen SQLite-Datenbank unter `storage/app/pltx-theme.sqlite`.

## Nächste Schritte
1. Composer-Abhängigkeiten installieren.
2. Konfiguration veröffentlichen.
3. Migrationen ausführen.
4. Assets veröffentlichen bzw. bauen.
5. Installer-Skript auf deinem Server hosten und auf die echte Panel-Umgebung anpassen.
