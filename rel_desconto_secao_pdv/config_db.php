<?php
$host = "localhost";
$user = "root";
$pass = "123456";
$dbname = "controle";
$conexao = mysqli_connect($host, $user, $pass);
if (mysqli_connect_error()) {
    echo "Erro de conexão com o banco de dados. Contate o Administrador";
} else {
    mysqli_set_charset($conexao, "utf8");
    mysqli_select_db($conexao, $dbname);
}