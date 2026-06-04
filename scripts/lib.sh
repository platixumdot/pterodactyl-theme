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
    apt-get install -y ca-certificates curl git jq unzip rsync composer mysql-client php-cli php-mbstring php-xml php-curl php-zip php-bcmath
}

backup_target() {
    local target_dir="$1"
    local backup_dir="$2"
    mkdir -p "$backup_dir"
    tar -czf "$backup_dir/files.tar.gz" -C "$target_dir" .
}

load_env_value() {
    local env_file="$1"
    local key="$2"

    [[ -f "$env_file" ]] || return 1
    grep -E "^${key}=" "$env_file" | tail -n 1 | cut -d '=' -f 2- | sed 's/^"//; s/"$//' | sed "s/^'//; s/'$//"
}

resolve_database_value() {
    local target_dir="$1"
    local override_key="$2"
    local env_key="$3"
    local default_value="$4"
    local env_file="$target_dir/.env"
    local override_value

    override_value="${!override_key:-}"
    if [[ -n "$override_value" ]]; then
        printf '%s' "$override_value"
        return 0
    fi

    if [[ -f "$env_file" ]]; then
        local env_value
        env_value="$(load_env_value "$env_file" "$env_key" || true)"
        if [[ -n "$env_value" ]]; then
            printf '%s' "$env_value"
            return 0
        fi
    fi

    printf '%s' "$default_value"
}

database_connection_available() {
    local db_host="$1"
    local db_port="$2"
    local db_username="$3"
    local db_password="$4"

    MYSQL_PWD="$db_password" mysqladmin ping -h "${db_host:-localhost}" -P "${db_port:-3306}" -u "$db_username" --silent >/dev/null 2>&1
}

require_database_connection() {
    local target_dir="$1"
    local db_host db_port db_database db_username db_password

    db_host="$(resolve_database_value "$target_dir" PLTX_DB_HOST DB_HOST localhost)"
    db_port="$(resolve_database_value "$target_dir" PLTX_DB_PORT DB_PORT 3306)"
    db_database="$(resolve_database_value "$target_dir" PLTX_DB_DATABASE DB_DATABASE "")"
    db_username="$(resolve_database_value "$target_dir" PLTX_DB_USERNAME DB_USERNAME "")"
    db_password="$(resolve_database_value "$target_dir" PLTX_DB_PASSWORD DB_PASSWORD "")"

    if [[ -z "$db_database" || -z "$db_username" ]]; then
        log "Database credentials are missing. Skipping database-dependent steps."
        return 1
    fi

    if ! database_connection_available "${db_host:-localhost}" "${db_port:-3306}" "$db_username" "$db_password"; then
        log "MySQL is not reachable at ${db_host:-localhost}:${db_port:-3306}. Skipping database-dependent steps."
        return 1
    fi
}

backup_database() {
    local target_dir="$1"
    local backup_dir="$2"
    local db_host db_port db_database db_username db_password

    db_host="$(resolve_database_value "$target_dir" PLTX_DB_HOST DB_HOST localhost)"
    db_port="$(resolve_database_value "$target_dir" PLTX_DB_PORT DB_PORT 3306)"
    db_database="$(resolve_database_value "$target_dir" PLTX_DB_DATABASE DB_DATABASE "")"
    db_username="$(resolve_database_value "$target_dir" PLTX_DB_USERNAME DB_USERNAME "")"
    db_password="$(resolve_database_value "$target_dir" PLTX_DB_PASSWORD DB_PASSWORD "")"

    if [[ -n "$db_database" && -n "$db_username" ]]; then
        if ! database_connection_available "${db_host:-localhost}" "${db_port:-3306}" "$db_username" "$db_password"; then
            log "Database backup skipped because the MySQL server is not reachable."
            return 0
        fi

        mkdir -p "$backup_dir"
        MYSQL_PWD="$db_password" mysqldump --single-transaction --routines --triggers -h "${db_host:-localhost}" -P "${db_port:-3306}" -u "$db_username" "$db_database" > "$backup_dir/database.sql"
    fi
}

restore_database() {
    local target_dir="$1"
    local backup_dir="$2"
    local db_host db_port db_database db_username db_password

    [[ -f "$backup_dir/database.sql" ]] || return 0

    db_host="$(resolve_database_value "$target_dir" PLTX_DB_HOST DB_HOST localhost)"
    db_port="$(resolve_database_value "$target_dir" PLTX_DB_PORT DB_PORT 3306)"
    db_database="$(resolve_database_value "$target_dir" PLTX_DB_DATABASE DB_DATABASE "")"
    db_username="$(resolve_database_value "$target_dir" PLTX_DB_USERNAME DB_USERNAME "")"
    db_password="$(resolve_database_value "$target_dir" PLTX_DB_PASSWORD DB_PASSWORD "")"

    if [[ -n "$db_database" && -n "$db_username" ]]; then
        if ! database_connection_available "${db_host:-localhost}" "${db_port:-3306}" "$db_username" "$db_password"; then
            log "Database restore skipped because the MySQL server is not reachable."
            return 0
        fi

        MYSQL_PWD="$db_password" mysql -h "${db_host:-localhost}" -P "${db_port:-3306}" -u "$db_username" "$db_database" < "$backup_dir/database.sql"
    fi
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
    version="$(cd "$target_dir" && composer show pterodactyl/panel --no-ansi --no-interaction 2>/dev/null | awk -F': ' '/versions/ {print $2; exit}')"
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
