<?php
/*
 * Ativar php e postgres
 sudo apt-get install php-pgsql
 editar arquivo /etc/php/7.2/apache2/php.ini
 tirar ; do extension=pdo_pgsql e extension=pgsql
*/
$servidor = "localhost";
$porta = 5432;
$bancoDeDados = "postgres";
$usuario = "arius";
$senha = "automa";

$conexao = pg_connect("host=$servidor port=$porta dbname=$bancoDeDados user=$usuario password=$senha");
if(!$conexao) {
    die("Não foi possível se conectar ao banco de dados.");
}