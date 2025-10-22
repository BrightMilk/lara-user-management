FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    default-mysql-client \
    supervisor \
    nginx \
    netcat-traditional

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

COPY docker/app/nginx.conf /etc/nginx/sites-available/default
COPY docker/app/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

RUN composer install --no-dev --optimize-autoloader

RUN php artisan storage:link

EXPOSE 80

COPY docker/app/start-container.sh /usr/local/bin/start-container

CMD ["start-container"]
