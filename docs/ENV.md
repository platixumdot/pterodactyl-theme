# Umgebung

## Wichtige Variablen
- `PLTX_THEME_NAME`
- `PLTX_THEME_VERSION`
- `PLTX_THEME_LOCALE`
- `PLTX_THEME_UPDATE_FEED_URL`
- `PLTX_DISCORD_WEBHOOK_URL`
- `DISCORD_CLIENT_ID`
- `DISCORD_CLIENT_SECRET`
- `PLTX_THEME_DB_PATH`

## Betrieb
- Das Paket erwartet eine bestehende Pterodactyl-Installation auf Ubuntu.
- Das Theme nutzt eine eigene SQLite-Datenbank unter `storage/app/pltx-theme.sqlite` und ist damit nicht an die Panel-MySQL gekoppelt.
- Die Installationsskripte sichern Datei- und Datenbankzustand vor Änderungen.
- Assets werden nach `public/vendor/pltx-theme` veröffentlicht.
