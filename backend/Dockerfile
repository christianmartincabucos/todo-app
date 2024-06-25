FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www

COPY . /var/www

COPY --chown=www-data:www-data . /var/www

COPY start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start

EXPOSE 8000
CMD ["php-fpm"]
