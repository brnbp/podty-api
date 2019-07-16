#!/bin/sh

chmod 755 -R /var/www
chmod -R o+w /var/www/storage

/etc/init.d/php7.2-fpm start
/etc/init.d/nginx start

/bin/bash
