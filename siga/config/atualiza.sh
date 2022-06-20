#!/bin/bash 

dbname='siga'

echo "Por favor insira as informacoes conforme solicitado"

echo "IP do Banco de dados Ex: localhost"
read host

echo "Nome de usuario do banco de dados:"
read user

echo "Senha do usuario do banco de dados:"
read -ers pass


if [ $host >0 ]; then
echo "" 
echo "Tentando conexao com a base de dados $dbname - usando o usuario $user"

banco=$(mysql -u$user -p$pass -B -N -e "SELECT usuario FROM siga.usuarios WHERE usuario = 'administrador'")

if [ $banco >0 ]; then
	echo "Banco de dados do SIGA ja existe. Proseguindo com a atualizacao"
	mysql -u$user -p$pass < /var/www/config/atualiza_banco.sql
	wait
	echo "Atualizacao do banco de dados concluida."
	echo ""
	echo "Atualizacao do SIGA concluida com sucesso."
else if [ $banco =< 0 ]; then
echo "Criando base de dados siga"
	mysql -u$user -p$pass < /var/www/config/cria_banco.sql
	wait
	echo "Configuracao do banco de dados concluida."
	echo""
	echo "Ajustando mais algumas coisas..."
	echo "<?php" >> /var/www/config/config_bd.php
	echo '$endereco_bd='"'$host'"';' >> /var/www/config/config_bd.php
	wait
	echo '$usuario_bd='"'$user'"';'  >> /var/www/config/config_bd.php
	wait
	echo '$senha_bd='"'$pass'"';' >> /var/www/config/config_bd.php
	wait
	echo '$base_principal='"'$dbname'"';' >> /var/www/config/config_bd.php
	wait
	echo "?>" >> /var/www/config/config_bd.php
	wait

	rm /etc/apache2/apache2.conf
	wait
	mv /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf_old
	mv /etc/apache2/apache2.conf /etc/apache2/apache2.conf_old
	wait
	mv /var/www/siga/install/apache2.conf /etc/apache2/apache2.conf
	wait
	mv /var/www/siga/install/000-default.conf /etc/apache2/sites-available/000-default.conf
	wait

	chmod 777 /var/www/log
	chmod 777 /var/www/licftp
	chmod 777 /var/www/temp
	chmod 777 /var/www/licenca
	chmod 777 /var/www/compartilhamento
	chmod 777 /var/www/rhftp.sh
	chmod 777 /var/www/pbftp.sh
	wait
	chmod 777 /var/www/temp/verifica_licenca
	chmod 777 /var/www/licftp/verifica_licenca
	wait
	chown root:root /etc/apache2/sites-available/000-default.conf
	chown root:root /etc/apache2/apache2.conf
	chmod 644 /etc/apache2/sites-available/000-default.conf
	chmod 644 /etc/apache2/apache2.conf
	/etc/init.d/apache2 restart
	wait
	echo "removendo arquivos temporarios da instalacao"
	rm -rf /var/www/install
	wait

	echo "Intalacao concluida com sucesso."

	echo "Para acessar o sistema, abra o navegador e digite : IP_do_servidor"
	echo "Ex: localhost"

	else 
	echo "por favor verifique as informacoes e tente novamente."
	exit
fi
fi
fi
