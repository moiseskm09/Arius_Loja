<?php

$hostloja = "localhost";
$userloja = "root";
$passloja = "123456";
$bancoloja = "controle";
$conexaoloja = mysqli_connect ($hostloja, $userloja, $passloja) or die (mysqli_error("falha na conexao"));
mysqli_select_db($conexaoloja, $bancoloja) or die (mysqli_error("banco de dados nao encontrado"));
//mysqli_set_charset($conexaoloja,"utf8");
?>