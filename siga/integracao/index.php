    <?php
    date_default_timezone_set('America/Sao_Paulo');
    require_once 'config/config.php';
    $data = date('Y-m-d');
    $consulta = mysqli_query ($conexao,"SELECT * FROM mon99_pendentes WHERE dataproc = '$data' ORDER BY cnt_pendente DESC");

    ?>

    <!DOCTYPE html>
    <html lang="pt-br">
      <head>
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="refresh" content="10">
            <title>Integração Loja x Pleno</title>
             <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
      </head>
      <body>
          <div class="container-fluid" style="width:99%; padding-top: 5px;">
          <div class="row">
			<h1 class="text-center">Está página mudou para o SIGA<a href="http://172.16.0.128"> Clique aqui para acessar</a></h1>
    </div>
              </div>
      </body>
    </html>
