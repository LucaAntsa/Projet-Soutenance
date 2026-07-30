#!/usr/bin/env bash

set -e

echo "============================================"
echo "Démarrage du backend Education Familiale"
echo "============================================"

PORT="${PORT:-10000}"

echo "Configuration d'Apache sur le port ${PORT}..."

sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf

sed -i \
    "s/<VirtualHost \*:.*>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf

echo "Préparation des dossiers Laravel..."

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache

echo "Nettoyage des caches précédents..."

php artisan optimize:clear

echo "Découverte des packages..."

php artisan package:discover --ansi

echo "Exécution des migrations..."

php artisan migrate --force

echo "Création du lien storage..."

php artisan storage:link || true

echo "Création des caches de production..."

php artisan config:cache
php artisan view:cache

echo "Démarrage d'Apache sur 0.0.0.0:${PORT}..."

exec apache2-foreground
