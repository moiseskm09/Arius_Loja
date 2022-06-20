<?php

ini_set("display_errors", 0);
error_reporting(0);


$host = "localhost";
$user = "root";
$pass = "123456";
$banco = "controle";

$conexao = mysqli_connect($host, $user, $pass) or die(mysqli_error("falha na conexao"));
mysqli_select_db($conexao, $banco) or die(mysqli_error("banco de dados nao encontrado"));

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
        <title>Arius - Exportação XML'S de venda</title>
        
        <style>
            body {
                background-color: #01478d; 
            } 
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col-md-4 mb-4 mx-auto" style="margin-top:120px;">
                    <div class="card" style="border-radius: 15px; border: 2px solid #0159b1;">
                        <img src="logo_horizontal.png" class="card-img-top mx-auto mt-1" alt="logotipo" style="width: 200px;">
						<h6 class="text-center">Exportação XML's Arius Loja</h6>
                        <div class="card-body">

                            <form action="exportaXML.php" method="POST">
                                <label for="data_inicial" class="text-primary" style="font-size: 13px;">Data Inicial</label>
                                <div class="input-group mb-3 ">
                                    
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text " id="basic-addon1"><i class="fas fa-calendar-alt text-primary"></i></span>
                                    </div>
                                    
                                    <input type="date" class="form-control" name="data_inicial" required="" autocomplete="off" aria-label="data_inicial" aria-describedby="basic-addon1" style="height: 40px;">
                                </div>
                                <label for="data_final" class="text-primary" style="font-size: 13px;">Data Final</label>
                                <div class="input-group mb-3" >
                                    <div class="input-group-prepend" >
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-alt text-primary"></i></span>
                                    </div>
                                    <input type="date" class="form-control" name="data_final" required=""  aria-label="data_final" aria-describedby="basic-addon1">
                                </div>
                                <?php 
                                $consultaLoja = mysqli_query($conexao, "SELECT nroloja FROM pf_loja ORDER BY nroloja");
                                    
                                    if (mysqli_num_rows($consultaLoja) > 1) {
                                        ?>
                                <label for="loja" class="text-primary" style="font-size: 13px;">Loja</label>
                                <div class="input-group mb-3" >
                                    <div class="input-group-prepend" >
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-building text-primary"></i></span>
                                    </div>
                                    <select class="form-control" name="loja" required="" aria-label="loja" aria-describedby="basic-addon1">
                                       <?php while ($resultadoLoja = mysqli_fetch_assoc($consultaLoja)) { ?>
                                        <option value="<?php echo $resultadoLoja['nroloja']?>"><?php echo $resultadoLoja['nroloja']?></option>
                                       <?php } ?>
                                    </select>
                                </div>
                                
                                   <?php }else { 
                                       $resultadoLoja = mysqli_fetch_assoc($consultaLoja);
                                       
                                       ?>
                                   
                                <input type="hidden" class="form-control" name="loja" value="<?php echo $resultadoLoja['nroloja']?>" required=""> 
                                  <?php }
                                        ?>
                                


                                <button type="submit" class="btn btn-success form-control">EXPORTAR</button>
                            </form>
                            <?php
                            $erro = (int) $_GET["erro"];
                            if ($erro === 1) {
                                echo '<p class="alert alert-danger text-center mt-2">Falha ao exportar! Tente novamente.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
		
       <!-- Footer -->
        <footer class="page-footer font-small text-muted fixed-bottom mr-2">
            <!-- Copyright -->
            <div class="footer-copyright text-right py-2 text-white">© 2020 Copyright:
                <a href="https://emksolucoes.com.br" style="color: #f58322"> EMK Soluções</a>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->

        <!-- JavaScript (Opcional) -->
        <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>