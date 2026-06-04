#!/usr/bin/env bash
set -Eeuo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
# shellcheck disable=SC1091
source "$SCRIPT_DIR/lib.sh"

TARGET_DIR="${PLTX_PTERO_DIR:-/var/www/pterodactyl}"
BACKUP_DIR="${PLTX_BACKUP_DIR:-/var/backups/pltx-theme-uninstall-$(date +%Y%m%d-%H%M%S)}"

require_ubuntu
install_system_dependencies
require_command php
require_command composer

[[ -d "$TARGET_DIR" ]] || fail "Target directory does not exist: $TARGET_DIR"
backup_target "$TARGET_DIR" "$BACKUP_DIR"
backup_database "$TARGET_DIR" "$BACKUP_DIR" || true

(cd "$TARGET_DIR" && composer remove pltx/pterodactyl-theme --no-interaction) || true
run_artisan "$TARGET_DIR" optimize:clear || true
restart_services

log "Uninstall completed. Backup stored at $BACKUP_DIR"
