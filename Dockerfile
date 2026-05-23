FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install pdo_mysql zip bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear

RUN chown -R www-data:www-data storage bootstrap/cache

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

RUN sed -ri -e 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf \
    && sed -ri -e 's/:80/:10000/g' /etc/apache2/sites-available/*.conf

EXPOSE 10000

CMD ["apache2-foreground"]