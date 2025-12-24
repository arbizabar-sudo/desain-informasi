FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

WORKDIR /app
COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

EXPOSE 8080
CMD php artisan serve --host 0.0.0.0 --port 8080
