<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d H:i');
include ("config/conexao.php");

session_start ();
$usuario = $_SESSION['usuario'];
session_destroy();
mysqli_query ($conexao,"UPDATE login SET datafimlogin ='$data', status = 0 WHERE nome='$usuario'") or die (mysqli_error("nao foi possivel inserir"));
header ("Location: index.html");
?>