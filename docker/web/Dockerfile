### Set Image Ubuntu 17.10
FROM ubuntu:17.10

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

#####################
### INSTALL PHP 7 ###
#####################
RUN apt-get install -y --force-yes \
    php7.1 \
    php7.1-cgi \
    php7.1-cli \
    php7.1-common \
    php7.1-curl \
    php7.1-dom \
    php7.1-fpm \
    php7.1-gd \
    php7.1-json \
    php7.1-mbstring \
    php7.1-mysql \
    php7.1-mongodb \
    php7.1-opcache \
    php7.1-sqlite \
    php7.1-xml \
    php7.1-readline \
    php7.1-zip \
    libapache2-mod-php7.1

COPY php/fpm-pool-www.conf /etc/php/7.1/fpm/pool.d/www.conf

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

###############
### MONGODB ###
###############
RUN apt-get install -y mongodb
RUN mkdir /data
RUN mkdir /data/db
RUN chmod 755 -R /data

WORKDIR /var/www

# startup services
COPY startup.sh /usr/bin/startup

RUN chmod +x /usr/bin/startup
CMD /usr/bin/startup
