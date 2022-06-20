<!DOCTYPE html>
<html lang="pt-br">
  <head>
  
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Esqueceu a senha</title>
    <!--Made with love by Mutiullah Samim -->
   
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<!------ Include the above in your HEAD tag ---------->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	
	<body>
<?php

include ("config/conexao.php");

date_default_timezone_set('America/Sao_Paulo');

if (isset($_POST['cpf'],$_POST['usuario'], $_POST['senha'])){
$cpf = $_POST['cpf'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$criptsenha=md5($senha);


$consulta = mysqli_query($conexao, "SELECT usuario FROM usuarios WHERE usuario='$usuario'");
$linha = mysqli_num_rows($consulta);
		
$consulta2 = mysqli_query($conexao, "SELECT cpf FROM usuarios WHERE cpf='$cpf'");
$linha2 = mysqli_num_rows($consulta2);


$consulta3 = mysqli_query($conexao, "SELECT usuario FROM usuarios WHERE cpf='$cpf' AND usuario='$usuario'");
$linha3 = mysqli_num_rows($consulta3);
			
			
			
if ($linha == 0) {		
				echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.html'>
				<script type=\"text/javascript\">
					alert(\"Erro, Usuario nao existe em nosso sistema!\");
				</script>
			";				
			} elseif ( $linha2 == 0 ) {
							echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.html'>
				<script type=\"text/javascript\">
					alert(\"Erro, CPF nao existe em nossa base de dados!\");
				</script>
			";
			
			} elseif ( $linha3 == 0 ) {
							echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.html'>
				<script type=\"text/javascript\">
					alert(\"Nao foi encontrado usuario para este CPF!\");
				</script>
			";
			
					
			} elseif ( $linha==1 && $linha2==1 && $linha3==1 ) {
			$sql= mysqli_query ($conexao,"UPDATE usuarios SET senha='$criptsenha' WHERE cpf='$cpf' AND usuario='$usuario'");
						echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.html'>
				<script type=\"text/javascript\">
					alert(\"Senha alterada com sucesso.\");
				</script>
			";							
						
			} else {
						
		}
}

?>

</body>
</html>