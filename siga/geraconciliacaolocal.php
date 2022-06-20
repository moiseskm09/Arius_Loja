<?php

date_default_timezone_set('America/Sao_Paulo'); // Hora oficial do Brasil.
include ("menu.php");
include ("config/conexao.php");
error_reporting(0);
ini_set(“display_errors”, 0 );

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Gerar Conciliação Local</title>
            <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
   </head>
  <body>
  
<div class="container-fluid">
<div class="row">
    <div class="col-md-12 text-center alert alert-warning">
       <span><strong>Atenção!</strong> Só poderão ser salvos arquivos que foram gerados no mês atual!</span>
      </div>
</div>

  <div class="row" style="padding-top: 120px;">

    <div class="col-5">
     <legend> Preencha aqui para RI HAPPY</legend> 
     <div class="box_rihappy">
<form id="reenviar" method="post" action="armazenalocalrh.php">
<div class="form-group col-md-4">
      <label for="lojarh">Loja</label>
      <input type="text" class="form-control" id="lojarh" name="lojarh" placeholder="Loja" >
    </div>

  <div class="form-group col-md-7">
      <label for="datarh">Data</label>
      <input type="date" class="form-control" id="datarh" name="datarh" placeholder="" >
    </div>
  
  <div  class="container" align="center" >
  <button  id="gerarh" type="submit" class="btn btn-success "> Salvar arquivo</button>
    </div>
</form> 
</div>
</div>


    <div class="col-2">
      <center>
        <img class="img-responsive" src="img/un.sao.paulo.png" id="logo_meio_arius">
      </center>
      
    </div>
    <div class="col-5">
      

<legend> Preencha aqui para PB KIDS</legend>
<div class="box_pbkids">
<form id="reenviarpb" method="post" action="armazenalocalpb.php">
<div class="form-group col-md-4">
      <label for="lojapb">Loja</label>
      <input type="text" class="form-control" id="lojapb" name="lojapb" placeholder="Loja" >
    </div>

  <div class="form-group col-md-7">
      <label for="datapb">Data</label>
      <input type="date" class="form-control" id="datapb" name="datapb" placeholder="" >
    </div>
  
  <div  class="container" align="center" >
  <button  id="gerapb" type="submit" class="btn btn-success "> Salvar arquivo</button>
    </div>

</form> 
</div>
</div>

</div>
<br>

<div class="row">
<div class="col-12"> 
 <p class="text-center alert-danger">
               <?php
                    $erro = (int) $_GET["erro"];
                    if ($erro === 1) {
                        echo "Arquivo não encontrado! O Suporte foi acionado, por favor tente novamente mais tarde!";
                    }
                    ?>
                </p>      
</div>
</div>


   <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div> 
</body>

</html>
