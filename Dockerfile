FROM php:8.1-apache

COPY . /var/www
COPY .docker/ports.conf /etc/apache2/ports.conf
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www

RUN apt-get update

RUN apt-get install -y --no-install-recommends \
        libxml2-dev \
        locales \
        apt-transport-https \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen \
    && apt-get update

RUN apt-get install -y apt-utils net-tools libmcrypt-dev \
	vim libpng-dev libonig-dev libmagickwand-dev zip unzip
RUN docker-php-ext-install calendar mbstring pdo pdo_mysql mysqli soap

RUN pecl install imagick
RUN docker-php-ext-enable imagick

RUN apt-get install -y libfreetype6-dev \
        libjpeg-dev \
        libpng-dev

RUN docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-enable gd

RUN echo 'log_errors=On' >> /usr/local/etc/php/php.ini
RUN echo 'error_log="/var/www/logs/php_error.log"' >> /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www
RUN service apache2 restart

ENV PATH="/var/www/vendor/bin:${PATH}"