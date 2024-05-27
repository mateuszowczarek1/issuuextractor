FROM php:8.1-apache

WORKDIR /var/www/html

COPY src/composer.json /var/www/html/composer.json
COPY src/composer.lock /var/www/html/composer.lock

RUN apt-get update

# Install necessary dependencies
RUN apt-get install -y nano libzip-dev imagemagick curl unzip

# Install the "zip" extension
RUN docker-php-ext-install zip

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 755 /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer

RUN composer update

EXPOSE 8000