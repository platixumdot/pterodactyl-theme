# Installation

Diese Anleitung beschreibt die **manuelle** Installation Schritt für Schritt. Für den schnellen Weg auf Ubuntu-Servern nutze stattdessen `scripts/install.sh` (siehe [README](../README.md#installer-skripte)).

## Schritt für Schritt

1. Paket in die Pterodactyl-Installation einbinden:
   ```bash
   composer require pltx/pterodactyl-theme
   ```
2. Konfiguration veröffentlichen:
   ```bash
   php artisan vendor:publish --tag=pltx-theme-config
   ```
3. Assets veröffentlichen:
   ```bash
   php artisan vendor:publish --tag=pltx-theme-assets
   ```
4. Migrationen ausführen:
   ```bash
   php artisan migrate
   ```
5. Falls die Source-Assets neu kompiliert werden sollen:
   ```bash
   npm install
   npm run build
   ```

## Hinweise

- Das Paket muss auf einem bestehenden Laravel-/Pterodactyl-System betrieben werden.
- Das Theme legt seine eigene SQLite-Datenbank an und benötigt dafür keine erreichbare Pterodactyl-MySQL.
- Die Theme-Routen laufen standardmäßig unter `/theme` und überschreiben damit keine Panel-Routen.
- Für Discord-OAuth2 und Webhooks müssen die Umgebungsvariablen aus [`ENV.md`](ENV.md) gesetzt werden.
- Automatisierte Install-, Update- und Uninstall-Skripte liegen unter [`scripts/`](../scripts/) und werden im [README](../README.md#installer-skripte) erklärt.
