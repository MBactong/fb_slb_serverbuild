#!/bin/bash

mysql -u root -p"${MYSQL_ROOT_PASSWORD}" -D mysql -e "ALTER USER '"${MYSQL_USER}"'@'%' IDENTIFIED WITH mysql_native_password BY '"${MYSQL_PASSWORD}"'; GRANT ALL PRIVILEGES ON *.* TO '"${MYSQL_USER}"'@'%'; FLUSH PRIVILEGES; CREATE USER '"${MYSQL_USER}"'@'localhost' IDENTIFIED WITH mysql_native_password BY '"${MYSQL_PASSWORD}"'; GRANT ALL PRIVILEGES ON *.* TO '"${MYSQL_USER}"'@'localhost'; FLUSH PRIVILEGES; SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"

