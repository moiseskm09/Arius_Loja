<!DOCTYPE html>
<html lang="pt-br">
  <head>
  
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Cadastrando usuário...</title>
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

if (isset($_POST['cpf'], $_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['usuario'], $_POST['senha'])){
$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$criptsenha=md5($senha);


$consulta = mysqli_query($conexao, "SELECT usuario FROM usuarios WHERE usuario='$usuario'");
$linha = mysqli_num_rows($consulta);

$consulta2 = mysqli_query($conexao, "SELECT email FROM usuarios WHERE email='$email'");
$linha2 = mysqli_num_rows($consulta2);
			
$consulta3 = mysqli_query($conexao, "SELECT cpf FROM usuarios WHERE cpf='$cpf'");
$linha3 = mysqli_num_rows($consulta3);
			
			
			
if ($linha ==1) {		
				echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.html'>
				<script type=\"text/javascript\">
					alert(\"Erro, Usuário já existe na base de dados do sistema!\");
				</script>
			";
			} elseif ( $linha2 ==1 ) {				
					echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.html'>
				<script type=\"text/javascript\">
					alert(\"Erro, E-mail já existe na base de dados do sistema!\");
				</script>
			";
					
			} elseif ( $linha3 ==1 ) {
							echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.html'>
				<script type=\"text/javascript\">
					alert(\"Erro, CPF já existe na base de dados do sistema!\");
				</script>
			";
					
			} elseif ( $linha==0 && $linha2==0 && $linha3==0 ) {
			$sql= mysqli_query ($conexao,"INSERT INTO usuarios (cpf, nome, sobrenome, email, usuario, senha, niveldeacesso, datadecadastro) VALUES ('$cpf', '$nome', '$sobrenome', '$email', '$usuario', '$criptsenha', '1', NOW())");
						echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=index.html'>
				<script type=\"text/javascript\">
					alert(\"Usuário Cadastrado com Sucesso.\");
				</script>
			";							
						
			} else {
						
		}
}

?>

</body>
</html>