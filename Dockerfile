FROM php:8.1-fpm

RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev\
    zip \
    unzip

RUN apt clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure pdo_pgsql \
  && docker-php-ext-install pdo pdo_pgsql

RUN mkdir -p /var/www/.composer /app \
  && chown -R www-data:www-data /app /var/www/.composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
USER www-data
