#!/usr/bin/env bash
set -Eeuo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
# shellcheck disable=SC1091
source "$SCRIPT_DIR/lib.sh"

TARGET_DIR="${PLTX_PTERO_DIR:-/var/www/pterodactyl}"
BACKUP_DIR="${PLTX_BACKUP_DIR:-/var/backups/pltx-theme-update-$(date +%Y%m%d-%H%M%S)}"
SOURCE_PATH="${PLTX_SOURCE_PATH:-}"
if [[ -z "$SOURCE_PATH" && -f "$SCRIPT_DIR/../composer.json" ]]; then
    SOURCE_PATH="$(cd "$SCRIPT_DIR/.." && pwd)"
fi
PACKAGE_NAME="${PLTX_PACKAGE_NAME:-pltx/pterodactyl-theme}"

trap 'log "Update failed at: ${BASH_COMMAND}"; log "Update failed, rolling back..."; restore_target "$TARGET_DIR" "$BACKUP_DIR"' ERR

require_ubuntu
install_system_dependencies
require_command php
require_command composer

[[ -d "$TARGET_DIR" ]] || fail "Target directory does not exist: $TARGET_DIR"
ensure_theme_database "$TARGET_DIR"
backup_target "$TARGET_DIR" "$BACKUP_DIR"
backup_database "$TARGET_DIR" "$BACKUP_DIR" || true
database_ready=0
if require_database_connection "$TARGET_DIR"; then
    database_ready=1
fi
check_pterodactyl_version "$TARGET_DIR"

if [[ -n "$SOURCE_PATH" && -d "$SOURCE_PATH" ]]; then
    (cd "$TARGET_DIR" && composer config repositories.pltx-theme path "$SOURCE_PATH" && composer update "$PACKAGE_NAME" --no-interaction)
else
    (cd "$TARGET_DIR" && composer update "$PACKAGE_NAME" --no-interaction)
fi

if [[ "$database_ready" -eq 1 ]]; then
    run_artisan "$TARGET_DIR" migrate --force
else
    log "Skipping migrations because the database is not available."
fi
run_artisan "$TARGET_DIR" config:clear
run_artisan "$TARGET_DIR" route:clear
run_artisan "$TARGET_DIR" view:clear
run_artisan "$TARGET_DIR" optimize:clear
restart_services

log "Update completed successfully."
