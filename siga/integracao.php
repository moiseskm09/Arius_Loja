        <?php
        date_default_timezone_set('America/Sao_Paulo'); // Hora oficial do Brasil.
	require_once 'menu.php';
        require_once 'config/conexao.php';
        $data = date('Y-m-d');
        $consulta = mysqli_query ($conexao,"SELECT * FROM mon99_pendentes WHERE dataproc = '$data' ORDER BY cnt_pendente DESC");
        ?>

        <!DOCTYPE html>
        <html lang="pt-br">
          <head>
            <!-- Meta tags Obrigatórias -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="refresh" content="60">
            <title>Integração Loja x Pleno</title>
             <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/menu.css">






          </head>
          <body>
              <div class="container-fluid" >
              <div class="form-row" style="margin-left:6px;">
        <?php while($resultado2 = mysqli_fetch_assoc($consulta)) { 
           if($resultado2["cnt_pendente"] > 15 ) { ?>

        <span class="text-center bg-danger border border-danger" style=" width:70px; background-color: #FF0000; color: #fff; margin: 2px; border-radius: 15px;">
        <?php echo $resultado2["nroloja"];?><br><?php echo $resultado2["cnt_pendente"];?>
        </span>

        <?php }else if ($resultado2["cnt_pendente"] > 5 ) { ?>

                   <span class="text-center bg-warning border border-warning" style=" width:70px; background-color: #ffff66; color: #000; margin: 2px; border-radius: 15px;">
        <?php echo $resultado2["nroloja"];?><br><?php echo $resultado2["cnt_pendente"];?>

        </span>
        <?php }else if ($resultado2["cnt_pendente"] >= 0){ ?>

                      <span class="text-center bg-success border border-success" style=" width: 70px; background-color: #0000CD; color: #fff; margin: 2px; border-radius: 15px;">
        <?php echo $resultado2["nroloja"];?><br><?php echo $resultado2["cnt_pendente"];?>
        </span>

        <?php 
                 }else{ 
                     }
                          }?>   
		
        </div>
	<?php if (mysqli_num_rows($consulta) == 0) {?>  
          <center>
            <h3 style="margin-top: 20%;">Não tem cupons pendentes</h3>
                <img style="width: 20%; position: relative;" src="img/goal.png">
          </center>
              
             
              
             
            <?php }else {

            }
            ?>
        </div>
          </body>
        </html>


