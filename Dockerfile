FROM php:8.2-fpm

RUN apt-get update -y \
    && apt-get install -y nginx

RUN apt-get update -y && apt-get install -y \
    nginx \
    git \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    openssl \
    libpq-dev \
    libssl-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql

COPY .docker/nginx/default.conf /etc/nginx/sites-enabled/default
COPY .docker/nginx/entrypoint.sh /etc/entrypoint.sh
RUN chmod +x /etc/entrypoint.sh

COPY --chown=www-data:www-data . /var/www/html

WORKDIR /var/www/html

EXPOSE 80 443

ENTRYPOINT ["/etc/entrypoint.sh"]
