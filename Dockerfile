FROM php:8.2-apache

RUN apt-get update && apt-get install -y libzip-dev zip && docker-php-ext-install zip pdo_mysql pdo

RUN a2enmod rewrite

COPY . /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
