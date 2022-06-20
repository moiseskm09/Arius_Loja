#!/bin/bash


LOG=/var/www/log/log_exp`date +%Y%m%d`.txt
exec 1>>${LOG}
echo "[`date`] ==== Iniciando processo..."
exec 2>&1


/var/www/ftppb/enviaconciliacao.sh

wait 

rm /var/www/ftppb/enviaconciliacao.sh

> /var/www/ftppb/enviado

echo "[`date`] ==== Fim do processo..."
