<?php 
require_once './config/conexao.php';
require_once './config/config_geral.php';

$total = mysqli_query ($conexao, "SELECT count(codticket) AS TOTAL FROM brazip_bi.ticket WHERE dtabertura >= '$DATAINICIAL'");
$tTicket = mysqli_fetch_assoc($total);

$tickets = mysqli_query($conexao, "SELECT COUNT(codticket) AS TOTAL_STATUS, codstatus FROM brazip_bi.ticket WHERE dtabertura >= '$DATAINICIAL' GROUP BY codstatus");

while($resultadoStatus = mysqli_fetch_assoc($tickets)){
    if ($resultadoStatus["codstatus"] == 3){
        $tconcluido = $resultadoStatus["TOTAL_STATUS"];
    }else if($resultadoStatus["codstatus"] == 4 && $resultadoStatus["codstatus"] == 5 && $resultadoStatus["codstatus"] == 14){
        $tpendentefabrica = $resultadoStatus["TOTAL_STATUS"];
    }else if ($resultadoStatus["codstatus"] == 1){
        $tpendenteempresa = $resultadoStatus["TOTAL_STATUS"];
}else if ($resultadoStatus["codstatus"] == 7 && $resultadoStatus["codstatus"] == 12){
        $tpendenteinterno = $resultadoStatus["TOTAL_STATUS"];
}else if ($resultadoStatus["codstatus"] == 11){
        $tpendentekw = $resultadoStatus["TOTAL_STATUS"];
}
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>suporte</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/estilo.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="tema">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-ticket-alt icones"></i>&nbsp;<?php echo $tTicket["TOTAL"]; ?></h4>
                        <h6 class="text-muted card-subtitle mb-2">Total de Tickets</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="far fa-check-circle icones"></i>&nbsp;<?php echo $tconcluido; ?></h4>
                        <h6 class="text-muted card-subtitle mb-2">Concluídos</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-user-clock icones"></i>&nbsp;<?php echo $tpendentecliente; ?></h4>
                        <h6 class="text-muted card-subtitle mb-2">Pendente Cliente</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-business-time icones"></i>&nbsp;<?php echo $tpendenteempresa; ?></h4>
                        <h6 class="text-muted card-subtitle mb-2">Pendente Empresa</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos">Resolvidos no Prazo</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/mini-card-items.js"></script>
</body>

</html>