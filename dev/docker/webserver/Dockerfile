FROM php:7.4-apache

RUN apt-get -y update --fix-missing
RUN apt-get upgrade -y

# Install useful tools
RUN apt-get -y install apt-utils nano wget dialog

# Install important libraries
RUN apt-get -y install --fix-missing apt-utils build-essential git curl libcurl4 libcurl4-gnutls-dev zip libzip-dev libonig-dev

# Install SSH Server
RUN apt-get -y install openssh-server
RUN mkdir /var/run/sshd
RUN echo 'root:develop' | chpasswd
RUN sed -i 's/#Port 22/Port 2020/' /etc/ssh/sshd_config
RUN sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

EXPOSE 2020

RUN apt-get -y install acl

# Other PHP7 Extensions

RUN apt-get -y install libyaml-dev
RUN pecl install yaml-2.0.4
RUN docker-php-ext-enable yaml

RUN apt-get -y install libsqlite3-dev libsqlite3-0
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo_sqlite
RUN docker-php-ext-install mysqli

RUN docker-php-ext-install curl
RUN docker-php-ext-install tokenizer
RUN docker-php-ext-install json

RUN apt-get -y install zlib1g-dev
RUN docker-php-ext-install zip

#RUN apt-get -y install libicu-dev
#RUN docker-php-ext-install -j$(nproc) intl

RUN docker-php-ext-install mbstring

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Enable apache modules
RUN a2enmod rewrite headers

# copy system config files
COPY ./dev/docker/webserver/config/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# copy project files
COPY ./public/ /var/www/html

# set permissions
RUN chmod -R 777 /var/www
RUN chown -R www-data /var/www
RUN chgrp -R www-data /var/www

CMD service ssh start && apache2-foreground
