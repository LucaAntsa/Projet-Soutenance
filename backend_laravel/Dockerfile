# ============================================================
# Étape 1 : compilation des ressources frontend avec Vite
# ============================================================
FROM node:20-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json* ./

RUN if [ -f package-lock.json ]; then \
      npm ci; \
    else \
      npm install; \
    fi

COPY . .

RUN npm run build


# ============================================================
# Étape 2 : installation des dépendances PHP
# ============================================================
FROM composer:2 AS composer_dependencies

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts


# ============================================================
# Étape 3 : image finale PHP 8.2 + Apache
# ============================================================
FROM php:8.2-apache-bookworm

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        mbstring \
        bcmath \
        intl \
        zip \
        gd \
        opcache \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le dossier public de Laravel comme racine Apache
RUN sed -ri \
    's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf \
    && sed -ri \
    's/AllowOverride None/AllowOverride All/g' \
    /etc/apache2/apache2.conf

# Copier les dépendances Composer
COPY --from=composer_dependencies /app/vendor ./vendor

# Copier le projet Laravel
COPY . .

# Copier les ressources générées par Vite
COPY --from=frontend /app/public/build ./public/build

# Régénérer l'autoload après copie du projet
RUN composer dump-autoload \
    --no-dev \
    --optimize \
    --no-interaction \
    --no-scripts

# Préparer les dossiers d'écriture Laravel
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache

COPY docker/start.sh /usr/local/bin/start

# Corriger les éventuelles fins de ligne Windows
RUN sed -i 's/\r$//' /usr/local/bin/start \
    && chmod +x /usr/local/bin/start

EXPOSE 10000

CMD ["/usr/local/bin/start"]
