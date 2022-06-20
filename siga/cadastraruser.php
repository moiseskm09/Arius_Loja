<?php
include("menu.php");
include ("config/conexao.php");

date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Cadastro de usuários</title>
   
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/menu.css">


 <style type="text/css">
     .footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
  
   color: #A9A9A9;
   text-align: right;
}
    </style>

   </head>
  <body>
  
    <div class="container-fluid" >
   <form id="validacao"  method="POST" action="">
   <br>
   <div class="alinhamento">
   <legend> Cadastro de Usuários</legend>
	<div class="form-row">
    <div class="form-group col-md-4">
      <label for="cpf">CPF</label>
      <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF" minlength="8" maxlength="11" required>
	  <span class="help-block">Somente números</span>
    </div>
	
    <div class="form-group col-md-4">
      <label for="nome">Nome</label>
      <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o Nome" required>
    </div>
	
	<div class="form-group col-md-4">
      <label for="sobrenome">Sobrenome</label>
      <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Digite o Sobrenome" required>
    </div>
	
	<div class="form-group col-md-4">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Digite o E-mail" required>
    </div>
	
	<div class="form-group col-md-4">
      <label for="usuario">Usuário</label>
      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite o Usuário" required>
    </div>
	
	 <div class="form-group col-md-4">
      <label for="niveldeacesso">Nível de Acesso</label>
      <select id="niveldeacesso" name="niveldeacesso" class="form-control" required>
        <option value="0" selected>Escolher...</option>
        <option value="1" >Usuário</option>
		<option value="2" >Administrador</option>
      </select>
		</div>
		
		
		<div class="form-group col-md-3">
      <label for="senha">Senha</label>
      <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite a Senha" required minlength="8" maxlength="16">
	  <span class="help-block">Deve conter entre 8 e 16 caracteres</span>
    </div>
	
	<div class="form-group col-md-3">
      <label for="csenha">Confirme a senha</label>
      <input type="password" class="form-control" id="csenha" name="csenha" placeholder="Confirme a Senha" required minlength="8" maxlength="16">
	  <span class="help-block">Deve conter entre 8 e 16 caracteres</span>
    </div>
	
		
	<div class="form-group col-md-10">
   <button for="cadastrar" type="submit" class="btn btn-primary">Cadastrar</button>
  </div>
    
  </div>
    
    
</form>
</div>

<?php

    if (isset($_POST['cpf'], $_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['usuario'], $_POST['senha'], $_POST['niveldeacesso'])) {
            
      $data = date('Y-m-d H:i');
      $cpf=$_POST['cpf'];
      $nome=$_POST['nome'];
      $sobrenome=$_POST['sobrenome'];
      $email=$_POST['email'];
      $usuario=$_POST['usuario'];
      $senha=$_POST['senha'];
      $csenha=$_POST['csenha'];
      $criptsenha=md5($senha);
      $niveldeacesso=$_POST['niveldeacesso'];
      
      
      $consulta = mysqli_query($conexao, "SELECT usuario FROM usuarios WHERE usuario='$usuario'");
      $linha = mysqli_num_rows($consulta);
      $consulta2 = mysqli_query($conexao, "SELECT email FROM usuarios WHERE email='$email'");
      $linha2 = mysqli_num_rows($consulta2);
      $consulta3 = mysqli_query($conexao, "SELECT cpf FROM usuarios WHERE cpf='$cpf'");
      $linha3 = mysqli_num_rows($consulta3);
      
      if ($linha ==1) {
        echo '<div class="alert alert-danger">Erro, Usuário já existe na base de dados do sistema!</div>';
        
        } elseif ( $linha2 ==1 ) {
          echo '<div class="alert alert-danger">Erro, E-mail já existe na base de dados do sistema!</div>';
          
          } elseif ( $linha3 ==1 ) {
          echo '<div class="alert alert-danger">Erro, CPF já existe na base de dados do sistema!</div>';
          
          } elseif ($senha != $csenha) {
          echo '<div class="alert alert-danger">Erro, as senhas não coincidem!</div>';
          
          } elseif ( $linha==0 && $linha2==0 && $linha3==0 ) {
              
          $sql= mysqli_query ($conexao,"INSERT INTO usuarios (cpf, nome, sobrenome, email, usuario, senha, niveldeacesso, datadecadastro) VALUES ('$cpf', '$nome', '$sobrenome', '$email', '$usuario', '$criptsenha', '$niveldeacesso', NOW())");
          echo '<div class="alert alert-success">Usuário cadastrado com sucesso!</div>';       
          } else {
            
    }
      }

    ?>    

<script>
$(document).ready( function() {
  $("#validacao").validate({
    // Define as regras
      rules:{
		  
	    email:{
        // campoEmail será obrigatório (required) e precisará ser um e-mail válido (email)
         email: true
           }		   
    },
    // Define as mensagens de erro para cada regra
    messages:{
       
      email:{
        required: "Digite o e-mail",
        email: "Digite um e-mail válido"
          }
    }
  });
});
</script>

   <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div> 

  </body>
</html>