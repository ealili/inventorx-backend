#!/bin/sh

cd /var/www

php artisan key:generate

/usr/bin/supervisord -c /etc/supervisord.conf
