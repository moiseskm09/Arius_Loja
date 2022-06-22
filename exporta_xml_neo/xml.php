<?php
include_once 'config_bd.php';
$sql = pg_query($conexao, "SELECT * FROM arius.loja ORDER BY codigo");
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
                crossorigin="anonymous"></script>
        <title>Arius - Exportação XML'S de venda</title>
        
        <style>
            body {
                background-color: #1d4289;
            }
            .fundo-incone{
                background-color: #f1be48;
            }
            .icone{
                color: #1d4289;

            }
            .titulo-input{
                color:#1d4289;
            }
            .btn-exportar{
                background-color: #f1be48;
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col-md-4 mb-4 mx-auto" style="margin-top:50px;">
                    <div class="card" style="border-radius: 15px; border: 2px solid #0159b1;">
                        <img src="logo_horizontal.png" class="card-img-top mx-auto mt-1" alt="logotipo" style="width: 200px;">
						<h6 class="text-center">Exportação XML's Arius NEO</h6>
                        <div class="card-body">

                            <form action="exportaXML.php" method="POST">
                                <label for="data_inicial" class="titulo-input" style="font-size: 13px;">Data Inicial</label>
                                <div class="input-group mb-2">
                                    
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text fundo-incone" id="basic-addon1"><i class="fas fa-calendar-alt icone"></i></span>
                                    </div>
                                    
                                    <input type="date" class="form-control" name="data_inicial" required="" autocomplete="off" aria-label="data_inicial" aria-describedby="basic-addon1" style="height: 40px;">
                                </div>
                                <label for="data_final" class="titulo-input" style="font-size: 13px;">Data Final</label>
                                <div class="input-group mb-2" >
                                    <div class="input-group-prepend" >
                                        <span class="input-group-text fundo-incone" id="basic-addon1"><i class="fas fa-calendar-alt icone"></i></span>
                                    </div>
                                    <input type="date" class="form-control" name="data_final" required=""  aria-label="data_final" aria-describedby="basic-addon1">
                                </div>
                                <?php
                                    if (pg_num_rows($sql) > 1) {
                                        ?>
                                <label for="loja" class="titulo-input" style="font-size: 13px;">Loja</label>
                                <div class="input-group mb-2" >
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fundo-incone" id="basic-addon1"><i class="fas fa-store icone"></i></span>
                                    </div>
                                    <select class="form-control" name="loja" required="" aria-label="loja" aria-describedby="basic-addon1">
                                       <?php
                                       while ($resultado = pg_fetch_assoc($sql)) {
                                          // echo $resultado["codigo"] . " - " . $resultado["nomefantasia"] . " - " . $resultado["razaosocial"]."<br>";?>
                                        <option value="<?php echo $resultado["codigo"];?>"><?php echo $resultado["codigo"]." - ".$resultado["nomefantasia"]; ?></option>
                                       <?php }?>
                                    </select>
                                </div>
                                
                                   <?php }else { 
                                       $resultadoLoja = $resultado = pg_fetch_assoc($sql);
                                       ?>
                                <input type="hidden" class="form-control" name="loja" value="<?php echo $resultado["codigo"];?>" required="">
                                  <?php }
                                        ?>
                                <button type="submit" class="btn btn-exportar form-control">EXPORTAR</button>
                            </form>
                            <?php
                            if(isset($_GET["erro"])){
                            $erro = (int) $_GET["erro"];
                            if ($erro === 1) {
                                echo '<p class="alert alert-danger text-center mt-2">Você não preencheu todos campos! Tente novamente.</p>';
                            }elseif($erro === 2){
                                echo '<p class="alert alert-danger text-center mt-2">Não foi possível gerar o arquivo de exportação! Tente novamente mais tarde.</p>';
                            }}
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
		
       <!-- Footer -->
        <footer class="page-footer font-small text-muted fixed-bottom mr-2">
            <!-- Copyright -->
            <div class="footer-copyright text-right py-2"><a href="https://www.be-mk.com/"
                                                                        target="_blank"><span class="text-white"
                            style="text-decoration: none;">be<span style="color:#f7af24;">M</span>K©</span></a>
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