<?php
date_default_timezone_set('America/Sao_Paulo'); // Hora oficial do Brasil.
include("menu.php");
include ("config/conexao.php");

$data = date('Y-m-d');

$sql = mysqli_query ($conexao, "SELECT * FROM carga WHERE data != '$data' ORDER BY data DESC") or die (mysqli_error("erro"));
$cargaD = mysqli_num_rows($sql);

$sql2 = mysqli_query ($conexao, "SELECT * FROM conciliacao WHERE data != '$data' ORDER BY data DESC") or die (mysqli_error("erro"));
$conciliacaoD = mysqli_num_rows($sql2);

$sql3 = mysqli_query ($conexao, "SELECT * FROM conciliacao WHERE data = '$data' ORDER BY data DESC") or die (mysqli_error("erro"));
$conciliacaook = mysqli_num_rows($sql3);

$sql4 = mysqli_query ($conexao, "SELECT * FROM carga WHERE data = '$data' ORDER BY data DESC") or die (mysqli_error("erro"));
$cargaok = mysqli_num_rows($sql4);
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Painel inicial</title>
	<meta http-equiv="refresh" content="30">
  
         <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/estilo.css">

<style type="text/css"> 

    </style>
	
   </head>
  <body>
   <div class="container-fluid">
  <div class="row">

      <div class="col-md-3">
      <div class="dbox dbox--color-2">
        <div class="dbox__icon">
          <i class="fas fa-copy fa-3x"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count"><?php echo "$conciliacaook" ?></span>
          <span class="dbox__title">Conciliação Enviada</span>
        </div>
        
        <div class="dbox__action">
          <a href="conciliacaoe.php"><button class="dbox__action__btn">Visualizar</button></a>
        </div>        
      </div>
    </div>


    <div class="col-md-3">
      <div class="dbox dbox--color-1">
        <div class="dbox__icon">
          <i class="fas fa-exclamation-triangle fa-3x"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count"><?php echo "$conciliacaoD" ?></span>
          <span class="dbox__title">Conciliação Pendente</span>
        </div>
        
        <div class="dbox__action">
          <a href="conciliacaop.php"><button class="dbox__action__btn">Visualizar</button></a>
        </div>        
      </div>
    </div>

  

    <div class="col-md-3">
      <div class="dbox dbox--color-10">
        <div class="dbox__icon">
          <i class="fas fa-exchange-alt fa-3x"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count"><?php echo "$cargaok" ?></span>
          <span class="dbox__title">Importação Ok</span>
        </div>
        
        <div class="dbox__action">
          <a href="cargae.php"><button class="dbox__action__btn">Visualizar</button></a>
        </div>        
      </div>
    </div>

    <div class="col-md-3">
      <div class="dbox dbox--color-3">
        <div class="dbox__icon">
          <i class="fa fa-minus-circle fa-3x"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count"><?php echo "$cargaD" ?></span>
          <span class="dbox__title">Importação Pendente</span>
        </div>
        
        <div class="dbox__action">
          <a href="cargad.php"><button class="dbox__action__btn">Visualizar</button></a>
        </div>        
      </div>
    </div>
  </div>
   </div>
   
  
   <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div>  
   
  </body>
</html>
