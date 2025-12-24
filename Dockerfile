FROM php:8.2-cli-bookworm

RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    ca-certificates \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /app
COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# FIX PERMISSION (INI YANG KAMU BELUM BERES)
RUN mkdir -p storage/logs bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
