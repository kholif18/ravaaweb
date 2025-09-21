FROM php:8.3-apache

# Install ekstensi PHP
RUN apt-get update && apt-get install -y \
    unzip git libicu-dev libzip-dev libpng-dev libxml2-dev libonig-dev \
    && docker-php-ext-install intl pdo_mysql mysqli gd mbstring zip xml

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Set DocumentRoot ke folder public/
WORKDIR /var/www/html
COPY . .

# Konfigurasi Apache supaya pakai /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Permission untuk writable/
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80
