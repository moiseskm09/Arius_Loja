<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dados FTP</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
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
 <?php
include("menu.php");
include ("config/conexao.php");
date_default_timezone_set('America/Sao_Paulo');

$sql = mysqli_query ($conexao, "SELECT * FROM ftp_conciliacao");
$exibe = mysqli_fetch_assoc($sql);

?>	
    <div class="container-fluid" >
   <form id="validacao"  method="post" action="alteraftp.php">
   <br>
   <div class="alinhamento">
   <legend>Dados FTP Conciliação</legend>
	<div class="form-row">
    <div class="form-group col-md-4">
      <label for="servidor">Servidor</label>
      <input type="text" class="form-control" id="servidor" name="servidor" value="<?php echo $exibe['servidor'] ?>" required>
    </div>
	
    <div class="form-group col-md-4">
      <label for="usuario">Usuário</label>
      <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $exibe['usuario'] ?>" required>
    </div>
	
	<div class="form-group col-md-4">
      <label for="senha">Senha</label>
      <input type="password" class="form-control" id="senha" name="senha" value="<?php echo $exibe['senha'] ?>" required>
    </div>
	<br>
	<div class="form-group col-md-3">
      <label for="diretorioRH">Diretório de Integração RI HAPPY</label>
      <input type="text" class="form-control" id="diretorioRH" name="diretorioRH" value="<?php echo $exibe['diretorioRH'] ?>" required>
    </div>
	
	<div class="form-group col-md-3">
      <label for="diretorioPB">Diretório de Integração PB KIDS</label>
      <input type="text" class="form-control" id="diretorioPB" name="diretorioPB" value="<?php echo $exibe['diretorioPB'] ?>" required>
    </div>
	
	<div class="form-group col-md-10">
	<input type="hidden" name="id" value="">
   <button for="atualizar" type="submit" class="btn btn-primary">Atualizar</button>
      
  </div>
    
    
</form>
</div>

   <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div>  
 
</body>
</html>