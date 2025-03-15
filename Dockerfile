FROM php:8.2-fpm

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    mariadb-client \
    cron \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sL https://github.com/jwilder/dockerize/releases/download/v0.6.1/dockerize-linux-amd64-v0.6.1.tar.gz | tar -xzC /usr/local/bin

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --prefer-dist --optimize-autoloader

RUN mkdir -p storage/framework/{sessions,views,cache} && chmod -R 777 storage bootstrap/cache

RUN echo "* * * * * php /var/www/artisan schedule:run >> /var/log/cron.log 2>&1" > /etc/cron.d/schedule-cron \
    && chmod 0644 /etc/cron.d/schedule-cron

COPY nginx/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN touch /var/log/cron.log && chmod 666 /var/log/cron.log

CMD ["php-fpm"]

EXPOSE 9000
