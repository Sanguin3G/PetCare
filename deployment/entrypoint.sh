#!/bin/sh
set -eu

if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY is required. Generate a key once and supply it through the environment." >&2
    exit 1
fi

mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ] && [ "${DB_DATABASE:-}" != ":memory:" ]; then
    mkdir -p "$(dirname "$DB_DATABASE")"
    touch "$DB_DATABASE"
fi
# Create the public disk link for optional uploads. Database initialization and
# Passport provisioning are explicit setup commands, never boot-time resets.
if [ ! -e public/storage ]; then
    php artisan storage:link --no-interaction
fi
exec "$@"
