FROM php:8.2

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  && \
  apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql

RUN useradd -G www-data,root -u "${uid}" -d "/home/${user}" "${user}" && \
  mkdir -p "/home/${user}/.composer" && \
  chown -R "${user}:${user}" "/home/${user}" && \
  mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

USER "${user}"

WORKDIR /var/www
