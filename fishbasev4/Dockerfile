FROM php:7.4-apache

#RUN mkdir /srv/code

#COPY ./conf/000-default.conf /etc/apache2/sites-available/000-default.conf
#COPY ./conf/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
#COPY ./site/ /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && \
    apt-get install -y \
        git \
        zlib1g-dev \
        libzip-dev \
        zip \
        unzip \
        libmcrypt-dev \
        libpng-dev \
		libonig-dev \
		libonig-dev \
		libfreetype6-dev \
		libjpeg62-turbo-dev

#RUN chown -R www-data:www-data /srv/code
RUN a2enmod rewrite
RUN a2enmod speling
#RUN docker-php-ext-install pdo pdo_mysql zip mbstring opcache
RUN docker-php-ext-install pdo pdo_mysql
# for mysqli if you want
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN pecl install mcrypt-1.0.3
RUN docker-php-ext-enable mcrypt

# Clean
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/*
