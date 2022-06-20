#!/bin/bash

DIR='/var/www/conciliacao/'
FILE="enviaconciliacao.sh"


if [ -e "$DIR$FILE" ] ; then
/var/www/conciliacao/enviaconciliacao.sh
wait
rm /var/www/conciliacao/enviaconciliacao.sh

else

	fi

