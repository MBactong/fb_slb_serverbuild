#!/bin/bash
echo Enter database name to update:

read databasename

echo Enter database source:

read databasesource

docker exec -i fb-mysql sh -c 'exec mysql -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" $databasename' < "$databasesource"


