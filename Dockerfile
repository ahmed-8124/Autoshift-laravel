# Step 1: Use an official PHP image with Apache optimized for Laravel
FROM php:8.2-apache

# Step 2: Install core production system packages
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql zip

# Step 3: Enable Apache URL rewriting modules for clean Laravel routing
RUN a2enmod rewrite

# Step 4: Force Apache's Document Root to point straight to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Step 5: Set up your working directory
WORKDIR /var/www/html

# Step 6: Copy project files into the container
COPY . /var/www/html

# Step 7: Install Composer & resolve dependencies safely
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Step 8: Fix internal server file permissions so Laravel can write logs/sessions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose standard web traffic port
EXPOSE 80

# Run migrations automatically BEFORE starting the Apache web server
CMD php artisan migrate --force && apache2-foreground