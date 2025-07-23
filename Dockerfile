<<<<<<< HEAD
<<<<<<< HEAD
FROM php:8.1-fpm
=======
FROM php:8.2-fpm
>>>>>>> 6517b4a...

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
=======
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
>>>>>>> 6517b4a (update: perubahan view, route, gambar, dan tambah Dockerfile)
