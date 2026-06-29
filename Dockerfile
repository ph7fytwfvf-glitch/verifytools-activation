FROM php:8.1-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev unzip git libonig-dev \
  && docker-php-ext-install pdo pdo_mysql \
  && a2enmod rewrite headers \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
