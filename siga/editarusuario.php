<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Edição de usuários</title>
      <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/menu.css">
  
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
 </head>
  <body>
 <?php
include("menu.php");
include ("config/conexao2.php");
date_default_timezone_set('America/Sao_Paulo');
 
// pega o ID da URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
 
// valida o ID
if (empty($id))
{
    echo "ID para alteração não definido";
    exit;
}
 
// busca os dados du usuário a ser editado
$PDO = conexao();
$sql = "SELECT cpf, nome, sobrenome, email, usuario, niveldeacesso FROM usuarios WHERE id = :id";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
 
$stmt->execute();
 
$user = $stmt->fetch(PDO::FETCH_ASSOC);
 
// se o método fetch() não retornar um array, significa que o ID não corresponde a um usuário válido
if (!is_array($user))
{
    echo "Nenhum usuário encontrado";
    exit;
}
?>	
    <div class="container-fluid" >
   <form id="validacao"  method="post" action="validaedicaousuario.php">
   <div class="alinhamento">
   <legend> Edição de Usuários</legend>
	<div class="form-row">
    <div class="form-group col-md-4">
      <label for="cpf">CPF</label>
      <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $user['cpf'] ?>" required>
	  <span class="help-block">Somente números</span>
    </div>
	
    <div class="form-group col-md-4">
      <label for="nome">Nome</label>
      <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $user['nome'] ?>" required>
    </div>
	
	<div class="form-group col-md-4">
      <label for="sobrenome">Sobrenome</label>
      <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?php echo $user['sobrenome'] ?>" required>
    </div>
	
	<div class="form-group col-md-4">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email'] ?>" required>
    </div>
	
	<div class="form-group col-md-4">
      <label for="usuario">Usuário</label>
      <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $user['usuario'] ?>" required>
    </div>
	
	 <div class="form-group col-md-4">
      <label for="niveldeacesso">Nível de Acesso</label>
      <select id="niveldeacesso" name="niveldeacesso" class="form-control"  required>
	  
        <option value="<?php echo $user['niveldeacesso'] ?>" selected><?php echo $user['niveldeacesso']==1 ?'Usuário':'Administrador';  ?></option>
        <option value="1" >Usuário</option>
		<option value="2" >Administrador</option>
      </select>
		</div>
		
		
	<div class="form-group col-md-10">
	<input type="hidden" name="id" value="<?php echo $id ?>">
   <button for="atualizar" type="submit" class="btn btn-primary">Atualizar</button>
      
	<input type="hidden" name="id" value="<?php echo $id ?>">  
	<a class="btn btn-danger" data-toggle="modal" href="#myModalsenha">Alterar Senha</a>
	</div>   
	
  </div>
    
    
</form>
</div>



  
  <!-- The Modal -->
  <div class="modal" id="myModalsenha">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Alterar senha</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form id="validacao"  method="post" action="alterarsenha.php" enctype="multipart/form-data">
	
	<label for="usuario">Usuário</label>
      <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $user['usuario'] ?>" readonly required>
	
	<br>
	<label for="senhaatual">Senha atual</label>
      <input type="password" class="form-control" id="senhaatual" name="senhaatual" placeholder="Digite a Senha atual" required minlength="8" maxlength="16">
	  
	<br>
<label for="novasenha">Nova Senha</label>
      <input type="password" class="form-control" id="novasenha" name="novasenha" placeholder="Digite a nova senha" required minlength="8" maxlength="16">
	  <span class="help-block">Deve conter entre 8 e 16 caracteres</span>	
<br>

<br>

<label for="confirmacao">Confirme a senha</label>
      <input type="password" class="form-control" id="confirmacao" name="confirmacao" placeholder="Confirme a nova senha" required minlength="8" maxlength="16">
	 	  
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
		<button type="submit" class="btn btn-primary" >Alterar Senha</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
         </form>
	
      </div>
    </div>
  </div> 




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