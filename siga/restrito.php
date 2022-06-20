<?php
date_default_timezone_set('America/Sao_Paulo'); // Hora oficial do Brasil.
include ("config/conexao.php");
include ("config/config_geral.php");
error_reporting(0);
ini_set(“display_errors”, 0 );
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Acesso restrito</title>
	<meta http-equiv="refresh" content="30">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	
   </head>
  <body>
  <?php 
  
if ($_SESSION["niveldeacesso"] != 2 ) {
	echo '<div class="alert alert-danger">Erro, você não tem permissão para acessar essa página!</div>';
	header("refresh: 2;inicio.php");
}else{	
header("Location: ftpconciliacao.php");

}
  ?>
  
</body>
</html>
