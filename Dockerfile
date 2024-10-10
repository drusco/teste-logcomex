# Base PHP image
FROM php:8.2-fpm

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_mysql gd zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/laravel-app

# Copy the application code to the container
COPY . .

# Expose port 9000
EXPOSE 9000

# Start the PHP-FPM service
CMD ["php-fpm"]

