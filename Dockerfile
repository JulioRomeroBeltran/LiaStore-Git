# ── Stage 1: Build frontend assets ────────────────────────────────────────────
FROM node:20-alpine AS frontend

WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources/ resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

# ── Stage 2: PHP + Apache runtime ─────────────────────────────────────────────
FROM php:8.2-apache

# Install system deps + PHP extensions
RUN apt-get update && apt-get install -y \
        libzip-dev libpng-dev libonig-dev libxml2-dev libsqlite3-dev unzip \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip mbstring exif bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app source
COPY . .

# Copy compiled frontend assets from Stage 1
COPY --from=frontend /app/public/build public/build

# Install PHP dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Apache virtual host config
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

# Startup script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
