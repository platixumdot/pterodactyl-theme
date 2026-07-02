# PLTX Pterodactyl Theme

Modernes, dunkles Pterodactyl-Theme mit Addon-Struktur. Bringt Statusseite, Ticket-System, Billing, Server-Profile, Admin-Module, Discord-OAuth und eine REST-API mit – ohne eine einzige Core-Datei von Pterodactyl anzufassen.

## Inhaltsverzeichnis

- [Features](#features)
- [Voraussetzungen](#voraussetzungen)
- [Schnellstart](#schnellstart)
- [Installer-Skripte](#installer-skripte)
- [Manuelle Installation](#manuelle-installation)
- [Konfiguration](#konfiguration)
- [Umgebungsvariablen](#umgebungsvariablen)
- [Routen](#routen)
- [REST-API](#rest-api)
- [Architektur](#architektur)
- [Troubleshooting](#troubleshooting)
- [Weiterführende Doku](#weiterführende-doku)

## Features

| Modul | Beschreibung |
|---|---|
| Statusseite | Zeigt Systemstatus, Incidents und Wartungsfenster |
| Tickets | Erstellen, schließen, archivieren, intern kommentieren |
| Billing | Abrechnungsübersicht pro Nutzer |
| Server-Profile | Erweiterte Detailansicht pro Server |
| Admin-Dashboard | Eigener Admin-Bereich für das Theme |
| Discord-OAuth | Login über Discord |
| Webhooks | Discord-Webhook-Benachrichtigungen |
| REST-API | Eigene Endpunkte unter `/api/theme/*` |

Das Theme ist als update-freundliches Laravel-Paket gebaut: alle Daten landen in einer **eigenen SQLite-Datenbank**, getrennt von der Pterodactyl-MySQL. Dadurch übersteht das Theme auch Panel-Updates, ohne dass Core-Dateien überschrieben werden müssen.

## Voraussetzungen

- Ubuntu-Server (die Installer-Skripte prüfen das aktiv und brechen sonst ab)
- Bestehende, lauffähige Pterodactyl-Installation (Version `1.12.x`)
- PHP, Composer, `git`, `curl`, `jq`, `unzip`, `rsync` (werden vom Installer bei Bedarf automatisch nachinstalliert)
- Root- bzw. sudo-Rechte auf dem Server

## Schnellstart

Der schnellste Weg auf einem produktiven Panel-Server ist das mitgelieferte Installer-Skript. Es übernimmt Composer-Einbindung, Konfiguration, Migrationen, Assets und einen Service-Neustart in einem Rutsch:

```bash
bash <(curl -sSL https://raw.githubusercontent.com/platixumdot/pterodactyl-theme/main/scripts/install.sh)
```

Das Skript legt vor jeder Änderung automatisch ein Backup an und macht bei einem Fehler alles rückgängig (siehe [Installer-Skripte](#installer-skripte)).

## Installer-Skripte

Im Ordner [`scripts/`](scripts/) liegen drei fertige Bash-Skripte, die den kompletten Lebenszyklus des Themes abdecken. Alle drei sind abgesichert: vor jeder Aktion wird ein Backup erstellt, bei einem Fehler (`trap ... ERR`) wird automatisch der vorherige Zustand wiederhergestellt.

### `install.sh`

Installiert das Theme komplett neu:
1. Prüft, dass auf Ubuntu installiert wird, und installiert fehlende System-Pakete (`apt-get install ...`).
2. Sichert das bestehende Pterodactyl-Verzeichnis und die Theme-Datenbank nach `/var/backups/pltx-theme-<Zeitstempel>/`.
3. Bindet das Paket per Composer ein (entweder von Packagist oder, falls vorhanden, direkt aus dem lokalen Repo-Pfad).
4. Veröffentlicht Konfiguration und Assets (`vendor:publish`).
5. Führt die Migrationen für die Theme-Datenbank aus.
6. Leert alle Laravel-Caches und startet PHP-FPM, Nginx und Redis neu.

### `update.sh`

Aktualisiert ein bereits installiertes Theme auf die neueste Version, inklusive Backup, Composer-Update und erneuter Migration. Funktioniert wie `install.sh`, lässt aber bereits vorhandene Daten unangetastet.

### `uninstall.sh`

Entfernt das Theme-Paket wieder sauber per `composer remove`, leert die Caches und startet die Dienste neu. Vorher wird ebenfalls ein vollständiges Backup angelegt, damit nichts verloren geht.

### Steuerung per Umgebungsvariablen

Alle drei Skripte lassen sich über Variablen anpassen, ohne den Code zu verändern:

| Variable | Standardwert | Zweck |
|---|---|---|
| `PLTX_PTERO_DIR` | `/var/www/pterodactyl` | Pfad zur Pterodactyl-Installation |
| `PLTX_BACKUP_DIR` | `/var/backups/pltx-theme-<Zeitstempel>` | Zielordner für Backups |
| `PLTX_PACKAGE_NAME` | `pltx/pterodactyl-theme` | Composer-Paketname |
| `PLTX_SOURCE_PATH` | (leer) | Lokaler Pfad zum Theme-Quellcode, z. B. fürs Testen vor einem Release |
| `PLTX_THEME_DB_PATH` | `storage/app/pltx-theme.sqlite` | Pfad zur Theme-Datenbank |

Beispiel mit eigenem Panel-Pfad:

```bash
PLTX_PTERO_DIR=/srv/pterodactyl bash scripts/install.sh
```

## Manuelle Installation

Falls du lieber selbst Schritt für Schritt vorgehst (z. B. auf einem nicht unterstützten OS), findest du die einzelnen Composer- und Artisan-Befehle in [`docs/INSTALL.md`](docs/INSTALL.md).

## Konfiguration

Nach der Installation liegt die zentrale Konfigurationsdatei unter `config/pltx-theme.php` im Panel. Wichtige Bereiche:

| Bereich | Beschreibung |
|---|---|
| `database` | Connection-Name und Pfad der Theme-SQLite-Datenbank |
| `brand` | Theme-Name, Primärfarbe (`#3b82f6`), Hintergrundfarbe (`#0f0f0f`) |
| `features` | Einzelne Module pro Boolean an-/abschaltbar (Statusseite, Tickets, Billing, …) |
| `discord` | Client-ID, Client-Secret und Webhook-URL für Discord-Integration |
| `api` | API-Prefix (`api/theme`) und Rate-Limit (`120,1`) |
| `routes` | Web-Prefix (`theme`) und ob die Theme-Routen überhaupt registriert werden |

## Umgebungsvariablen

| Variable | Zweck |
|---|---|
| `PLTX_THEME_NAME` | Anzeigename des Themes |
| `PLTX_THEME_VERSION` | Versionsnummer |
| `PLTX_THEME_LOCALE` | Standardsprache (`de` oder `en`) |
| `PLTX_THEME_UPDATE_FEED_URL` | Feed-URL für die Update-Prüfung |
| `PLTX_DISCORD_WEBHOOK_URL` | Discord-Webhook für Benachrichtigungen |
| `DISCORD_CLIENT_ID` / `DISCORD_CLIENT_SECRET` | Discord-OAuth-Zugangsdaten |
| `PLTX_THEME_DB_PATH` | Optionaler eigener Pfad zur Theme-Datenbank |
| `PLTX_THEME_REGISTER_ROUTES` | Theme-Routen aktivieren/deaktivieren |
| `PLTX_THEME_WEB_PREFIX` | URL-Prefix der Theme-Seiten (Standard: `theme`) |

Mehr Details dazu in [`docs/ENV.md`](docs/ENV.md).

## Routen

Alle Frontend-Seiten laufen standardmäßig unter `/theme/*` und überschreiben damit keine Pterodactyl-Panel-Routen:

| Route | Beschreibung |
|---|---|
| `/theme` | Dashboard-Startseite |
| `/theme/login` | Login-Seite |
| `/theme/status` | Statusseite |
| `/theme/tickets` | Ticket-Übersicht |
| `/theme/billing` | Billing-Übersicht |
| `/theme/profile` | Nutzerprofil |
| `/theme/servers/{server}` | Server-Detailansicht |
| `/theme/admin/dashboard` | Admin-Dashboard |
| `/theme/auth/discord/redirect` | Startet Discord-Login |
| `/theme/auth/discord/callback` | Discord-OAuth-Callback |

## REST-API

Alle API-Endpunkte laufen unter dem Prefix `/api/theme`:

| Methode | Endpunkt | Beschreibung |
|---|---|---|
| `GET` | `/api/theme/status` | Status, Incidents und Wartungen |
| `GET` | `/api/theme/update` | Aktuelle und neueste Theme-Version |
| `GET` | `/api/theme/tickets` | Ticketliste |
| `POST` | `/api/theme/tickets` | Neues Ticket erstellen |
| `GET` | `/api/theme/billing` | Billing-Daten |

Details und Hinweise zu Auth/Rate-Limiting in [`docs/API.md`](docs/API.md).

## Architektur

Kurzüberblick, ausführlich in [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md):

- Eigener Laravel Service Provider registriert Routen, Views, Migrationen, Übersetzungen und Publishes.
- Eigene Web- und API-Routen, getrennt vom Pterodactyl-Core.
- Eigene Datenbanktabellen für Status, Tickets, Billing, Profile, News und Logs.
- Veröffentlichbare Assets unter `public/vendor/pltx-theme`.
- Blade-Views mit dunklem, responsivem Layout.
- Sicherheitsprinzipien: Blade-Escaping als Standard, serverseitige Validierung, Sanitizing von Text-/HTML-Inhalten.

## Troubleshooting

| Problem | Lösung |
|---|---|
| Installer bricht mit „This installer only supports Ubuntu“ ab | Skripte funktionieren nur auf Ubuntu/Ubuntu-basierten Systemen, andere OS benötigen die [manuelle Installation](#manuelle-installation) |
| „Unsupported Pterodactyl version detected“ | Aktuell wird nur Pterodactyl `1.12.x` unterstützt |
| Migrationen werden übersprungen | Die Theme-Datenbank konnte nicht erstellt/erreicht werden – Pfad in `PLTX_THEME_DB_PATH` prüfen |
| Nach einem fehlgeschlagenen Install/Update ist alles beim Alten | Gewollt: Bei einem Fehler stellen die Skripte automatisch das Backup aus `PLTX_BACKUP_DIR` wieder her  |
| Discord-Login funktioniert nicht | `DISCORD_CLIENT_ID`, `DISCORD_CLIENT_SECRET` und die Redirect-URL im Discord-Developer-Portal prüfen |

## Weiterführende Doku

- [`docs/INSTALL.md`](docs/INSTALL.md) – manuelle Installation Schritt für Schritt
- [`docs/ENV.md`](docs/ENV.md) – alle Umgebungsvariablen im Detail
- [`docs/API.md`](docs/API.md) – REST-API-Referenz
- [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md) – Architektur und Sicherheitsprinzipien

