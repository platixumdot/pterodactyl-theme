# Installation

1. Paket in die Pterodactyl-Installation einbinden.
2. `php artisan vendor:publish --tag=pltx-theme-config` ausführen.
3. `php artisan vendor:publish --tag=pltx-theme-assets` ausführen.
4. `php artisan migrate` ausführen.
5. Frontend-Assets mit `npm install` und `npm run build` erzeugen, falls du die Source-Assets neu kompilierst.

## Hinweise
- Das Paket muss auf einem bestehenden Laravel-/Pterodactyl-System betrieben werden.
- Das Theme legt seine eigene SQLite-Datenbank an und benötigt dafür keine erreichbare Pterodactyl-MySQL.
- Für Discord OAuth2 und Webhooks müssen die Umgebungsvariablen gesetzt werden.
- Update- und Uninstall-Skripte liegen unter `scripts/`.
