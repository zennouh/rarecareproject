<<<<<<< HEAD:services/medical-dossier/Dockerfile
FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip opcache \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install amqp \
&& docker-php-ext-enable amqp
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*
=======
# Use PHP 8.3 Nginx image
FROM webdevops/php-nginx:8.3-alpine
>>>>>>> main:services/authentication/docker/Dockerfile

WORKDIR /var/www/html

EXPOSE 8000

<<<<<<< HEAD:services/medical-dossier/Dockerfile
CMD php -S 0.0.0.0:8000 public/index.php
=======
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Set Document Root for webdevops image
ENV WEB_DOCUMENT_ROOT=/var/www/html/public

# Copy local Nginx configuration
COPY docker/nginx.conf /opt/docker/etc/nginx/vhost.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html
>>>>>>> main:services/authentication/docker/Dockerfile
