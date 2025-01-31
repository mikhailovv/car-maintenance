# Dockerfile
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    intl \
    zip \
    opcache \
    bcmath

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY xdebug.ini "${PHP_INI_DIR}/conf.d"
# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer


# Set working directory
WORKDIR /var/www/html
