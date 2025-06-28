FROM php:8.1-apache

# Instalamos extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip zip git libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Activamos mod_rewrite para Yii
RUN a2enmod rewrite

# Cambiamos el DocumentRoot a /var/www/html/web
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/web|g' /etc/apache2/sites-available/000-default.conf

# Copiamos Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
