# Use the official PHP image with Apache as the base image
FROM php:8.2-apache

# Install system dependencies required for Laravel and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Clear package cache to reduce the final image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install and enable essential PHP extensions required by Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the application source code into the container
COPY . /var/www/html

# Copy the latest Composer executable from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies (optimized for production, ignoring dev packages)
RUN composer install --no-dev --optimize-autoloader

# Update the Apache DocumentRoot to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set the appropriate ownership and permissions for Laravel's storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 to allow incoming HTTP traffic
EXPOSE 80
