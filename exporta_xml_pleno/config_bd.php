<?php

$host = "localhost";
$user = "plenokw";
$pass = "6X2uQrpaLy7OjhWM";
$banco = "pleno";

$conexao = mysqli_connect($host, $user, $pass) or die(mysqli_error("falha na conexao"));
mysqli_select_db($conexao, $banco) or die(mysqli_error("banco de dados nao encontrado"));