# Use PHP 8.3 Apache image
FROM php:8.3-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    libpq-dev \
    libicu-dev \
    git \
    unzip \
    && docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy local Apache configuration
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Start Apache in the foreground
CMD ["apache2-foreground"]
