#!/usr/bin/env bash
set -Eeuo pipefail

log() {
    printf '[%s] %s\n' "$(date +'%Y-%m-%d %H:%M:%S')" "$*"
}

fail() {
    log "ERROR: $*"
    exit 1
}

require_ubuntu() {
    [[ -f /etc/os-release ]] || fail "/etc/os-release not found."
    # shellcheck disable=SC1091
    source /etc/os-release
    [[ "${ID:-}" == "ubuntu" || "${ID_LIKE:-}" == *"ubuntu"* ]] || fail "This installer only supports Ubuntu."
}

require_command() {
    command -v "$1" >/dev/null 2>&1 || fail "Required command not found: $1"
}

install_system_dependencies() {
    export DEBIAN_FRONTEND=noninteractive
    apt-get update
    apt-get install -y ca-certificates curl git jq unzip rsync composer php-cli php-mbstring php-xml php-curl php-zip php-bcmath php-sqlite3
}

backup_target() {
    local target_dir="$1"
    local backup_dir="$2"
    mkdir -p "$backup_dir"
    tar -czf "$backup_dir/files.tar.gz" -C "$target_dir" .
}

require_database_connection() {
    local target_dir="$1"

    ensure_theme_database "$target_dir"
    log "Using dedicated PLTX database at $(theme_database_path "$target_dir")."
    return 0
}

theme_database_path() {
    local target_dir="$1"
    local override_value="${PLTX_THEME_DB_PATH:-}"

    if [[ -n "$override_value" ]]; then
        printf '%s' "$override_value"
        return 0
    fi

    printf '%s' "$target_dir/storage/app/pltx-theme.sqlite"
}

ensure_theme_database() {
    local target_dir="$1"
    local database_path

    database_path="$(theme_database_path "$target_dir")"
    mkdir -p "$(dirname "$database_path")"
    [[ -f "$database_path" ]] || : > "$database_path"
}

backup_database() {
    local target_dir="$1"
    local backup_dir="$2"
    local database_path

    database_path="$(theme_database_path "$target_dir")"
    if [[ -f "$database_path" ]]; then
        mkdir -p "$backup_dir"
        cp "$database_path" "$backup_dir/database.sqlite"
    fi
}

restore_database() {
    local target_dir="$1"
    local backup_dir="$2"
    local database_path

    [[ -f "$backup_dir/database.sqlite" ]] || return 0

    database_path="$(theme_database_path "$target_dir")"
    mkdir -p "$(dirname "$database_path")"
    cp "$backup_dir/database.sqlite" "$database_path"
}

restore_target() {
    local target_dir="$1"
    local backup_dir="$2"
    if [[ -f "$backup_dir/files.tar.gz" ]]; then
        rm -rf "$target_dir"/*
        tar -xzf "$backup_dir/files.tar.gz" -C "$target_dir"
    fi
    restore_database "$target_dir" "$backup_dir" || true
}

check_pterodactyl_version() {
    local target_dir="$1"
    local version
    version="$(cd "$target_dir" && composer show pterodactyl/panel --no-ansi --no-interaction 2>/dev/null | awk -F': ' '/versions/ {print $2; exit}')" || true
    if [[ -z "$version" ]]; then
        log "Pterodactyl version could not be detected via composer show; continuing with caution."
        return 0
    fi

    if [[ "$version" != 1.12* ]]; then
        fail "Unsupported Pterodactyl version detected: $version"
    fi
}

install_deps() {
    local target_dir="$1"
    if [[ -f "$target_dir/composer.json" ]]; then
        (cd "$target_dir" && composer install --no-dev --optimize-autoloader)
    fi
}

run_artisan() {
    local target_dir="$1"
    shift
    (cd "$target_dir" && php artisan "$@")
}

restart_services() {
    systemctl restart php8.3-fpm || true
    systemctl restart php8.2-fpm || true
    systemctl restart nginx || true
    systemctl restart redis-server || true
}
