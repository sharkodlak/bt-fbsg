FROM php:8.3-fpm AS base

COPY ./docker/images/php/php-fpm.conf /usr/local/etc/php-fpm.d/zzz_custom.conf

RUN apt-get update && \
    apt-get install --no-install-recommends -y \
        7zip \
        less \
        locales \
        libpq-dev \
        nano \
        zip \
        && \
    apt-get -qy autoremove && \
    apt-get -y clean && \
    rm -rf /var/lib/apt/lists/* && \
    rm -rf /tmp/*

RUN sed -i '/^# cs_CZ.UTF-8 /s/^# //' /etc/locale.gen && \
	locale-gen cs_CZ.UTF-8 && \
	ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_pgsql

EXPOSE 9000

CMD ["php-fpm"]


#-----------------------------------------------------------------------------------------------------------------------

FROM base AS development

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY ./docker/images/php/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY ./docker/images/php/init.sh /docker-entrypoint-init.d/init.sh

CMD ["/docker-entrypoint-init.d/init.sh"]

#-----------------------------------------------------------------------------------------------------------------------

FROM base AS production

COPY --chown=www-data:www-data . /app

WORKDIR /app

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
