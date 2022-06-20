<?php
date_default_timezone_set('America/Sao_Paulo'); // Hora oficial do Brasil.
include("menu.php");
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
	<title> Licenças</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/menu.css">
  <style type="text/css">
    tr:hover{
      color: #f4ba5b;
    }
      .footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
  
   color: #A9A9A9;
   text-align: right;
}

  </style>

<script>
	$(function () {
                //Comportamento do botao de disparo
                $('#procurar_loja').click(function () {
                    getResponse();
                });
            });
            /**
             * Dispara o modal e espera a resposta do script 'testing.resp.php'
             * @returns {void}
             */
            function getResponse() {
                //Preenche e mostra o modal
                $('#loadingModal_content').html('Carregando...');
                $('#loadingModal').modal('show');
                //Envia a requisicao e espera a resposta
                $.post("licenca.php")
                    .done(function () {
                        //Se nao houver falha na resposta, preenche o modal
                        $('#loader').removeClass('loader');
                        $('#loader').addClass('glyphicon glyphicon-ok');
                        $('#loadingModal_label').html('Sucesso!');
                        $('#loadingModal_content').html('<br>Licença encontrada!');
                        resetModal();
                    })
                    .fail(function () {
                        //Se houver falha na resposta, mostra o alert
                        $('#loader').removeClass('loader');
                        $('#loader').addClass('glyphicon glyphicon-remove');
                        $('#loadingModal_label').html('Falha!');
                        $('#loadingModal_content').html('<br>licença não econtrada!');
                        resetModal();
                    });
            }
            function resetModal(){
                //Aguarda 2 segundos ata restaurar e fechar o modal
                setTimeout(function() {
                    $('#loader').removeClass();
                    $('#loader').addClass('loader');
                    $('#loadingModal_label').html('<span class="glyphicon glyphicon-refresh"></span>Aguarde...');
                    $('#loadingModal').modal('hide');
                }, 3000);
            }
        </script>

   </head>
  <body>

  <?php
$data = date('Y-m-d H:i');
$loja = $_POST['loja'];
$cgc = mysqli_query ($conexao, "SELECT * FROM clientes WHERE lojasap = $loja");
$resultado = mysqli_fetch_assoc($cgc);
$cnpj= $resultado["cnpj"];

session_start(); # Deve ser a primeira linha do arquivo
$frase = "$cnpj";
$_SESSION['cnpj'] = $frase;
	
	
chdir ('/var/www/temp/');
$comando="./verifica_licenca -v -f licencas$cnpj.dat";
 
//apaga dados do cnpj pesquisado para inserir um novo
$delete= mysqli_query ($conexao, "DELETE FROM licenca WHERE cnpj='$cnpj'");

//Executa o comando para verificar licença e armazena na variavel $line
$licencas = exec(escapeshellcmd($comando), $output);
reset($output);
while (list(,$line) = each($output)){ 
//Grava resultado da execução da execução no banco de dados
$stmt = mysqli_prepare($conexao, "INSERT INTO licenca (cnpj,dados, data) VALUES(?,?,?)");
mysqli_stmt_bind_param($stmt, 'sss', $cnpj, $line, $data);
mysqli_stmt_execute($stmt);
}

$sql = mysqli_query($conexao,"select * FROM licenca WHERE cnpj='$cnpj' and dados like 'Expira%'");
$sql3 = mysqli_query($conexao,"select * FROM licenca WHERE cnpj='$cnpj' and dados like 'Numero de PDV%'");
$sql4 = mysqli_query($conexao,"select * FROM licenca WHERE cnpj='$cnpj' and dados like 'Micro Terminal%'");
$sql5 = mysqli_query($conexao,"select * FROM licenca WHERE cnpj='$cnpj' and dados like 'Modulo de TEF%'");
$sql6 = mysqli_query($conexao,"select * FROM licenca WHERE cnpj='$cnpj' and dados like 'Modulo de Bomba%'");
$sql7 = mysqli_query($conexao,"select * FROM licenca WHERE cnpj='$cnpj' and dados like 'Numero de NFC%'");
$sql8 = mysqli_query($conexao,"select * FROM licenca WHERE cnpj='$cnpj' and dados like 'Armazena NFC%'");
$sql9 = mysqli_query($conexao,"select * FROM licenca WHERE cnpj='$cnpj' and dados like 'Pleno%'");
$sql10 = mysqli_query($conexao,"select * FROM licenca WHERE cnpj='$cnpj' and dados like 'App Vendas%'");
$exibe = mysqli_fetch_assoc($sql);
$exibe3 = mysqli_fetch_assoc($sql3);
$exibe4 = mysqli_fetch_assoc($sql4);
$exibe5 = mysqli_fetch_assoc($sql5);
$exibe6 = mysqli_fetch_assoc($sql6);
$exibe7 = mysqli_fetch_assoc($sql7);
$exibe8 = mysqli_fetch_assoc($sql8);
$exibe9 = mysqli_fetch_assoc($sql9);
$exibe10 = mysqli_fetch_assoc($sql10);
chdir ('/var/www/');
?>

<?php
if ($cnpj > 0) {
$local_file = "licftp/licencas$cnpj.dat";
$server_file = "/pub/cre/licenca/kw/licencas$cnpj.dat";
$ftp_server="ftp.cre.com.br";
$conn_id = ftp_connect($ftp_server,2321)or die("Erro de conexão com $ftp_server");
$ftp_user_name="cre";
$ftp_user_pass="suporte";
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("Não foi possível realizar o Login");
ftp_pasv($conn_id, true) or die("Não foi possível mudar para o modo passivo");
ftp_get($conn_id, $local_file, $server_file, FTP_ASCII);
	}else {
		
ftp_close($conn_id);
	}
?>


<?php


	
chdir ('/var/www/licftp/');
$comando2="./verifica_licenca -v -f licencas$cnpj.dat";
$delete2= mysqli_query ($conexao, "DELETE FROM licencaftp WHERE cnpj='$cnpj'");

$licencas2 = exec(escapeshellcmd($comando2), $output2);
reset($output2);
while (list(,$line2) = each($output2)){ 
//Grava resultado da execução da execução no banco de dados
$stmt2 = mysqli_prepare($conexao, "INSERT INTO licencaftp (cnpj,dados, data) VALUES(?,?,?)");
mysqli_stmt_bind_param($stmt2, 'sss', $cnpj, $line2, $data);
mysqli_stmt_execute($stmt2);
}

$sql11 = mysqli_query($conexao,"select * FROM licencaftp WHERE cnpj='$cnpj' and dados like 'Expira%'");
$sql12 = mysqli_query($conexao,"select * FROM licencaftp WHERE cnpj='$cnpj' and dados like 'Numero de PDV%'");
$sql13 = mysqli_query($conexao,"select * FROM licencaftp WHERE cnpj='$cnpj' and dados like 'Micro Terminal%'");
$sql14 = mysqli_query($conexao,"select * FROM licencaftp WHERE cnpj='$cnpj' and dados like 'Modulo de TEF%'");
$sql15 = mysqli_query($conexao,"select * FROM licencaftp WHERE cnpj='$cnpj' and dados like 'Modulo de Bomba%'");
$sql16 = mysqli_query($conexao,"select * FROM licencaftp WHERE cnpj='$cnpj' and dados like 'Numero de NFC%'");
$sql17 = mysqli_query($conexao,"select * FROM licencaftp WHERE cnpj='$cnpj' and dados like 'Armazena NFC%'");
$sql18 = mysqli_query($conexao,"select * FROM licencaftp WHERE cnpj='$cnpj' and dados like 'Pleno%'");
$sql19 = mysqli_query($conexao,"select * FROM licencaftp WHERE cnpj='$cnpj' and dados like 'App Vendas%'");
$exibe11 = mysqli_fetch_assoc($sql11);
$exibe12 = mysqli_fetch_assoc($sql12);
$exibe13 = mysqli_fetch_assoc($sql13);
$exibe14 = mysqli_fetch_assoc($sql14);
$exibe15 = mysqli_fetch_assoc($sql15);
$exibe16 = mysqli_fetch_assoc($sql16);
$exibe17 = mysqli_fetch_assoc($sql17);
$exibe18 = mysqli_fetch_assoc($sql18);
$exibe19 = mysqli_fetch_assoc($sql19);
?>



<div class="container-fluid">

  <div class="row" style="padding-top: 5px;">
    <div class="col-12 text-center">
      <form class="form-inline" action="" method="POST" name="licenca" >
      <input style="width: 300px; margin-left: 31%;" align="center" type="text" name="loja" class="form-control text-center" id="loja" placeholder="Digite o número da Loja">
      <button id="procurar_loja" type="submit" class="btn btn-success" style="margin-left: 10px;">Procurar</button>
    </form>
    </div>
    </div>

    <?php 
    if ($loja > 0) {
    $nao_encontrado= mysqli_num_rows($cgc);
      if ($nao_encontrado < 1) {
        echo "
  <div class='alert alert-warning'>
  <strong>Loja não encontrada. Por favor verifique as informações.</strong>!
</div>";
      }
    }

    ?>
      <script type="text/javascript">
    document.licenca.reset();
    </script>



  <div class="row" style="padding-top: 10px;">
    <div class="col-4">
      <div class="licenca_loja">
        <caption><strong style="color: #3d4c9d;">Disponível na Loja</strong></caption>

        <table class="table table-hover table-bordered">
          <tbody>
    
    <tr>
    <th scope="row" >CNPJ: </th>
    <td><?php echo $cnpj ?></td>
    
      </tr>
    
    <tr>
      <th scope="row">Expira em: </th>
      <td><?php echo mb_substr( $exibe["dados"], 10, 10, 'UTF-8' ); ?></td>
      </tr>
    
      <tr>
      <th scope="row">Número de PDV's:</th>
      <td><?php echo mb_substr( $exibe3["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
  
    <tr>
      <th scope="row">Micro Terminal: </th>
      <td><?php echo mb_substr( $exibe4["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
    
      <tr>
      <th scope="row">Módulo de TEF: </th>
      <td><?php echo mb_substr( $exibe5["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
    
      <tr>
      <th scope="row">Módulo de Bombas:</th>
      <td><?php echo mb_substr( $exibe6["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
  
  
    <tr>
      <th scope="row">Número de NFCE:</th>
      <td><?php echo mb_substr( $exibe7["dados"], 17, 20, 'UTF-8' ); ?></td></tr>
    </tr>
  
    <tr>
      <th scope="row">Armazena NFCE: </th>
      <td><?php echo mb_substr( $exibe8["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
    
      <tr>
      <th scope="row">Pleno: </th>
      <td><?php echo mb_substr( $exibe9["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
    
    <tr>
      <th scope="row">App de Vendas:</th>
      <td><?php echo mb_substr( $exibe10["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
  
  </tbody>
        </table>
      </div>

    </div>
    <div class="col">
      <div class="text-center">
       <?php 
       if ($cnpj > 0) {
         echo '<br><br><br><br><br><br><br><br>
        Gostaria de atualizar?
        <br>
        <button  type="button" class="btn btn-primary "><a style="color:white" href="atualizalicenca.php" onclick="return confirm("Tem certeza de que deseja atualizar?"");">Clique Aqui!</a></button>
      ';
       }else {
        echo '
        <br><br><br>
        <center>
                  <img class="img-responsive" src="img/un.sao.paulo.png" id="logo_meio_arius" style="width=max-width=100%;">
        </center>
      ';
       }
        

?>
</div>
    </div>
    <div class="col-4">
      <caption ><strong style="color: #3d4c9d;">Disponível para atualização</strong></caption>

      <table class="table table-hover table-bordered">
          <tbody>
       
    <tr>
      <th scope="row">CNPJ: </th>
      <td><?php echo $cnpj ?></td>
      </tr>
    
    <tr>
      <th scope="row">Expira em: </th>
      <td><?php echo mb_substr( $exibe11["dados"], 10, 10, 'UTF-8' ); ?></td>
      </tr>
    
      <tr>
      <th scope="row">Número de PDV's:</th>
      <td><?php echo mb_substr( $exibe12["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
  
    <tr>
      <th scope="row">Micro Terminal: </th>
      <td><?php echo mb_substr( $exibe13["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
    
      <tr>
      <th scope="row">Módulo de TEF: </th>
      <td><?php echo mb_substr( $exibe14["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
    
      <tr>
      <th scope="row">Módulo de Bombas:</th>
      <td><?php echo mb_substr( $exibe15["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
  
  
    <tr>
      <th scope="row">Número de NFCE:</th>
      <td><?php echo mb_substr( $exibe16["dados"], 17, 20, 'UTF-8' ); ?></td></tr>
    </tr>
  
    <tr>
      <th scope="row">Armazena NFCE: </th>
      <td><?php echo mb_substr( $exibe17["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
    
      <tr>
      <th scope="row">Pleno: </th>
      <td><?php echo mb_substr( $exibe18["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
    
    <tr>
      <th scope="row">App de Vendas:</th>
      <td><?php echo mb_substr( $exibe19["dados"], 17, 20, 'UTF-8' ); ?></td>
      </tr>
  
  </tbody>
        </table>
    </div>
  </div>
</div>


      
   <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div>  


<!-- loadingModal-->
        <div class="modal fade" data-backdrop="static" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal_label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loadingModal_label">
                            <span class="glyphicon glyphicon-refresh"></span>
                            Aguarde...
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class='alert' role='alert'>
                            <center>
                                <div class="loader" id="loader"></div><br>
                                <h4><b id="loadingModal_content"></b></h4>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- loadingModal-->
        <nav class="navbar"></nav>

        
  </body>
</html>