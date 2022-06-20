<?php
include ("config_bd.php");

$host = $endereco_bd;
$user = $usuario_bd;
$pass = $senha_bd;
$banco = $base_principal;

$conexao = mysqli_connect ($host, $user, $pass) or die (mysqli_error("falha na conexao"));
mysqli_select_db($conexao, $banco) or die (mysqli_error("banco de dados nao encontrado"));
?>