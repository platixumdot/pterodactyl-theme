# Umgebungsvariablen

## Übersicht

| Variable | Standard | Zweck |
|---|---|---|
| `PLTX_THEME_NAME` | `PLTX Theme` | Anzeigename des Themes |
| `PLTX_THEME_VERSION` | `1.0.0` | Versionsnummer |
| `PLTX_THEME_LOCALE` | `de` | Standardsprache (`de` oder `en`) |
| `PLTX_THEME_UPDATE_FEED_URL` | – | Feed-URL für die Update-Prüfung |
| `PLTX_DISCORD_WEBHOOK_URL` | – | Discord-Webhook für Benachrichtigungen |
| `DISCORD_CLIENT_ID` | – | Discord-OAuth Client-ID |
| `DISCORD_CLIENT_SECRET` | – | Discord-OAuth Client-Secret |
| `PLTX_THEME_DB_PATH` | `storage/app/pltx-theme.sqlite` | Pfad zur Theme-Datenbank |
| `PLTX_THEME_DB_CONNECTION` | `pltx_theme` | Name der Laravel-DB-Connection für das Theme |
| `PLTX_THEME_REGISTER_ROUTES` | `true` | Theme-Routen aktivieren/deaktivieren |
| `PLTX_THEME_WEB_PREFIX` | `theme` | URL-Prefix der Theme-Seiten |
| `PLTX_LIGHTWEIGHT_MODE` | `false` | Lightweight Mode – deaktiviert Animationen, Backdrop-Filter, Gradienten, Google Fonts und Live-Polling |

## Betrieb

- Das Paket erwartet eine bestehende Pterodactyl-Installation auf Ubuntu (Version `1.12.x`).
- Das Theme nutzt eine eigene SQLite-Datenbank unter `storage/app/pltx-theme.sqlite` und ist damit nicht an die Panel-MySQL gekoppelt.
- Die Installationsskripte (`scripts/install.sh`, `scripts/update.sh`, `scripts/uninstall.sh`) sichern Datei- und Datenbankzustand vor jeder Änderung automatisch ab.
- Assets werden nach `public/vendor/pltx-theme` veröffentlicht.
