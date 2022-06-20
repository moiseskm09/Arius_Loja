<?php 
ini_set( 'display_errors', 0 );
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
  
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/novologin.css">

    <title>SIGA - AUTENTICAÇÃO</title>
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

<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					
					<img id="logoarius" src="img/logo_siga.png">
				</div>


				<form name="loginform" method="post" action="autenticar.php" class="login100-form validate-form">
					<span class="login100-form-title">
					<h6><img id="logoarius" src="img/logo_siga.png" style="width: 50px;"></h6><span style="color:#fff;">Sistema Integrado de Gestão Arius</span>
					</span>

					<div class="wrap-input100">
						<input name="usuario" class="input100" type="text" placeholder="Usuário" required autocomplete="off">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input name="senha" class="input100" type="password"  placeholder="Senha" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Entrar
						</button>

            <b class="text-center" >
                    <?php
                    $erro = (int) $_GET["erro"];
                    if ($erro === 1) {
                        echo "Usuário ou senha inválidos!";
                    }
                    ?>
                </b>
					</div>

          

					<div class="text-center p-t-12">
						<span class="txt1">
		
						</span>
						<a data-toggle="modal" href="#myModalsenha" class="txt2" >
						<span style="color:#fff;">Esqueceu a Senha ? </span>
						</a>
						<br>
						<a data-toggle="modal" href="#myModal" class="txt2" >
							<span style="color:#fff;">Cadastre-se</span>
						</a>
					</div>

								</form>
			</div>
		</div>
	</div>

	
<!-- The Modal -->
  <div class="modal" id="myModalsenha">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Esqueceu a senha</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form id="validacao"  method="post" action="esqueceusenha.php" enctype="multipart/form-data">
		   <label for="cpf">CPF</label>
      <input type="number" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF" minlength="8" maxlength="11" required>
	
<label for="usuario">Usuário</label>
      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite o Usuário" required>

<label for="senha">Nova Senha</label>
      <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite a Senha" required minlength="8" maxlength="16">
	  <span class="help-block">Deve conter entre 8 e 16 caracteres</span>	  	 
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
	
	
	
<!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Cadastro de Usuário</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form id="validacao"  method="post" action="cadastronovo.php" enctype="multipart/form-data">
		   <label for="cpf">CPF</label>
      <input type="number" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF" minlength="8" maxlength="11" required>
	
<label for="nome">Nome</label>
      <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o Nome" required>

<label for="sobrenome">Sobrenome</label>
      <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Digite o Sobrenome" required>

<label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="Digite o E-mail" required>

<label for="usuario">Usuário</label>
      <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite o Usuário" required>

<label for="senha">Senha</label>
      <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite a Senha" required minlength="8" maxlength="16">
	  <span class="help-block">Deve conter entre 8 e 16 caracteres</span>	  
		  		 
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
		<button type="submit" class="btn btn-primary" >Cadastrar</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        </div>
         </form>
	
      </div>
    </div>
  </div>


  </body>
</html>
