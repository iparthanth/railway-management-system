#!/bin/bash

set -e

# Clear caches baked at build time (they contain build-time defaults,
# not the runtime environment variables)
php artisan optimize:clear

# Run migrations with the correct runtime environment
echo "Running migrations and seeding database ..."
php artisan migrate --force

php artisan storage:link
php artisan optimize

echo "Starting Laravel server ..."

# Start the FrankenPHP server
docker-php-entrypoint --config /Caddyfile --adapter caddyfile 2>&1