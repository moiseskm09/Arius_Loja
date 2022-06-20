<?php
$host = 'localhost';
$user = 'root';
$pass = 'm221213';
$banco = 'siga';

$conexao = mysqli_connect ($host, $user, $pass) or die (mysqli_error("falha na conexao"));
mysqli_select_db($conexao, $banco) or die (mysqli_error("banco de dados nao encontrado"));
?>
