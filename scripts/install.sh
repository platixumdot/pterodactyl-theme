#!/usr/bin/env bash
set -Eeuo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
# shellcheck disable=SC1091
source "$SCRIPT_DIR/lib.sh"

TARGET_DIR="${PLTX_PTERO_DIR:-/var/www/pterodactyl}"
BACKUP_DIR="${PLTX_BACKUP_DIR:-/var/backups/pltx-theme-$(date +%Y%m%d-%H%M%S)}"
PACKAGE_NAME="${PLTX_PACKAGE_NAME:-pltx/pterodactyl-theme}"
SOURCE_PATH="${PLTX_SOURCE_PATH:-}"

trap 'log "Install failed at: ${BASH_COMMAND}"; log "Install failed, rolling back..."; restore_target "$TARGET_DIR" "$BACKUP_DIR"' ERR

require_ubuntu
install_system_dependencies
require_command php
require_command composer

[[ -d "$TARGET_DIR" ]] || fail "Target directory does not exist: $TARGET_DIR"
ensure_theme_database "$TARGET_DIR"
backup_target "$TARGET_DIR" "$BACKUP_DIR"
backup_database "$TARGET_DIR" "$BACKUP_DIR" || true
rm -f "$(theme_database_path "$TARGET_DIR")"
ensure_theme_database "$TARGET_DIR"
database_ready=0
if require_database_connection "$TARGET_DIR"; then
    database_ready=1
fi
check_pterodactyl_version "$TARGET_DIR"

if [[ -n "$SOURCE_PATH" && -d "$SOURCE_PATH" ]]; then
    log "Installing from local source path: $SOURCE_PATH"
    (cd "$TARGET_DIR" && composer config repositories.pltx-theme path "$SOURCE_PATH" && composer require "$PACKAGE_NAME:*" --no-interaction)
else
    log "Installing package: $PACKAGE_NAME"
    (cd "$TARGET_DIR" && composer require "$PACKAGE_NAME:*" --no-interaction)
fi

install_deps "$TARGET_DIR"
run_artisan "$TARGET_DIR" vendor:publish --tag=pltx-theme-config --force
run_artisan "$TARGET_DIR" vendor:publish --tag=pltx-theme-assets --force
if [[ "$database_ready" -eq 1 ]]; then
    run_artisan "$TARGET_DIR" migrate --force
else
    log "Skipping migrations because the database is not available."
fi
run_artisan "$TARGET_DIR" config:clear
run_artisan "$TARGET_DIR" route:clear
run_artisan "$TARGET_DIR" view:clear
run_artisan "$TARGET_DIR" optimize:clear

if [[ -d "$SOURCE_PATH" ]]; then
    log "Copying built assets from source repository."
    mkdir -p "$TARGET_DIR/public/vendor/pltx-theme"
    cp -R "$SOURCE_PATH/public/vendor/pltx-theme/." "$TARGET_DIR/public/vendor/pltx-theme/"
fi

chown -R www-data:www-data "$TARGET_DIR/storage" "$TARGET_DIR/bootstrap/cache" || true
chmod -R 775 "$TARGET_DIR/storage" "$TARGET_DIR/bootstrap/cache" || true
restart_services

log "Installation completed successfully."
