### Set Image Ubuntu 19.04
FROM ubuntu:19.04

EXPOSE 80

##########################################
### INSTALL GIT AND BASIC DEPENDENCIES ###
##########################################
RUN apt-get update && apt-get install -y \
  git \
  curl \
  wget \
  debconf-utils \
  vim

RUN apt-get install -y --no-install-recommends software-properties-common build-essential

RUN  DEBIAN_FRONTEND=noninteractive
RUN ln -fs /usr/share/zoneinfo/America/New_York /etc/localtime

#####################
### INSTALL PHP 7 ###
#####################
RUN apt-get install -y \
    php \
    php-cgi \
    php-cli \
    php-common \
    php-curl \
    php-dom \
    php-fpm \
    php-gd \
    php-json \
    php-mbstring \
    php-mysql \
    php-xml \
    php-zip \
    libapache2-mod-php

COPY php/fpm-pool-www.conf /etc/php/7.2/fpm/pool.d/www.conf

###############
## COMPOSER ###
###############
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer

#####################
### INSTALL NGINX ###
#####################
RUN apt-get install nginx -y

# Nginx configs default to use php with root directory /var/www/public/
COPY nginx/default /etc/nginx/sites-enabled/default

WORKDIR /var/www

# startup services
COPY startup.sh /usr/bin/startup

RUN chmod +x /usr/bin/startup
CMD /usr/bin/startup
