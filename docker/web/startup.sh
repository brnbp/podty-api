#!/bin/sh

chmod 755 -R /var/www
chmod -R o+w /var/www/storage

/etc/init.d/mongodb start
/etc/init.d/php7.1-fpm start
/etc/init.d/nginx start

/bin/bash