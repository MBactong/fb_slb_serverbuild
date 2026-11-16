FROM php:7.4-apache

ARG GIT_ACCESS_TOKEN

RUN apt-get update && \
	apt-get install -y \
		git \
		zlib1g-dev \
		libpng-dev \
		libonig-dev \
		libonig-dev \
		libfreetype6-dev \
		libjpeg62-turbo-dev
 
RUN a2enmod rewrite
RUN a2enmod speling

RUN docker-php-ext-install mysqli opcache
RUN docker-php-ext-install mbstring \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd \
 && docker-php-ext-install bcmath
#RUN git clone https://${GIT_TOKEN}@github.com/FiN-FBSLB/FishBase3.5.git /var/www/html/
#RUN git clone https://github.com/FiN-FBSLB/FishBase3.5.git

#RUN chmod 777 /var/www/html/includes/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer
