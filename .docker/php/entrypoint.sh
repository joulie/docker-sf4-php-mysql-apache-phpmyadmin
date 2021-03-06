#!/bin/bash

mkdir -v -m 777 -p /home/wwwroot/sf4/var/
mkdir -v -m 777 -p /home/wwwroot/sf4/var/cache
mkdir -v -m 777 -p /home/wwwroot/sf4/var/log

echo -e "\e[95m############################# Getting vendors AJE ########################################################"
cd sf4
php composer.phar install
php bin/console make:migration
php bin/console doctrine:migrations:migrate
cd -
echo -e "\e[95m############################# The php SF4 container is ready AJE ! #######################################"

exec "$@"