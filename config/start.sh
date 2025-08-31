#!/bin/sh
mkdir -p /var/www/logs/api
touch /var/www/logs/api/app.log
touch /var/www/logs/api/php_errors.log
touch /var/www/logs/api/xdebug.log
chmod -R 777 /var/www/logs
exec php -S 0.0.0.0:8081 -t public
