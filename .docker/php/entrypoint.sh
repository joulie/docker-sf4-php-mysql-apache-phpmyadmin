#!/bin/bash

mkdir -v -m 777 -p /home/wwwroot/sf4/var/
mkdir -v -m 777 -p /home/wwwroot/sf4/var/cache
mkdir -v -m 777 -p /home/wwwroot/sf4/var/log

echo -e "\e[95mGetting vendors AJE"
cd sf4
php composer.phar install
cd -
echo -e "\e[95mThe php SF4 container is ready !"

exec "$@"