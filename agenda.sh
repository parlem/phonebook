#!/bin/bash
apt update
apt upgrade
apt install apache2 php php-xml
cd /var/www/html/
rm index.html
wget https://raw.githubusercontent.com/parlem/phonebook/main/index.php
wget https://raw.githubusercontent.com/parlem/phonebook/main/process.php
wget https://raw.githubusercontent.com/parlem/phonebook/main/phonebook-yealink.xml
wget https://raw.githubusercontent.com/parlem/phonebook/main/phonebook-snom.xml
chown www-data:www-data -R /var/www/html/
