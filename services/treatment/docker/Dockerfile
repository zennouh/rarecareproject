# Use PHP 8.3 Nginx image
FROM webdevops/php-nginx:8.3-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    libxml2-dev \
    oniguruma-dev \
    postgresql-dev \
    icu-dev \
    git \
    unzip

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