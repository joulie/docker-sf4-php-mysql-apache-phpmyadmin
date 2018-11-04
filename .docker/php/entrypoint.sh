#!/bin/bash

mkdir -v -m 777 -p /home/wwwroot/sf4/var/cache
mkdir -v -m 777 -p /home/wwwroot/sf4/var/log

#echo -e "\e[95mGetting vendors !"
#cd symfony
#php composer.phar install
exec "$@"