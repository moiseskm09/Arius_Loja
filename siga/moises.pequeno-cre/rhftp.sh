#!/bin/bash


LOG=/var/www/log/log_exp`date +%Y%m%d`.txt
exec 1>>${LOG}
echo "[`date`] ==== Iniciando processo..."
exec 2>&1



/var/www/ftprh/enviaconciliacao.sh

wait 

rm /var/www/ftprh/enviaconciliacao.sh

> /var/www/ftprh/enviado

echo "[`date`] ==== Fim do processo..."
