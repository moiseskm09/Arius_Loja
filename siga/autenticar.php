<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

<title>Autenticando usuario</title>

<script type="text/javascript">
function loginsuccessfully() {
	setTimeout ("window.location='inicio.php'", 1000);
}
function loginfailed() {
	setTimeout("window.location='index.html'", 1000);
	}
	</script>
</head>
<body>
<div class="container text-center">
<?php
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d H:i');
include("config/conexao.php");
$usuario= $_POST['usuario'];
$senha= $_POST['senha'];
$csenha=md5($senha);
$sql = mysqli_query ($conexao,"SELECT * FROM usuarios WHERE usuario='$usuario' and senha='$csenha'");
$row = mysqli_num_rows($sql);
$resultado = mysqli_fetch_array ($sql);

$nivel = $resultado["niveldeacesso"];
$nome = $resultado["nome"];

if ($row > 0) {
	session_start();
	$_SESSION['usuario']=$usuario;
	$_SESSION['senha']=$senha;
	$_SESSION['niveldeacesso']=$nivel;
	$_SESSION['nome']=$nome;
	header("Location: inicio.php");
	mysqli_query ($conexao,"INSERT INTO login (nome, datalogin,status) VALUES ('$usuario', '$data', 1)");
	
} else{
	header("location: index.php?erro=1");

}
?>
</div>
</body>
</html>
