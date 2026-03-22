FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Permissions (VERY IMPORTANT)
RUN chmod -R 775 storage bootstrap/cache

# IMPORTANT: do NOT generate key here on Render
# Use Render ENV instead

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}