<?php 
require_once './ferramentas/sql_bierp.php';

header("refresh: 30;bi_loja.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>BI ARIUS ERP</title>
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center justify-content-xl-center card-title titulos text-center"><i class="fas fa-chart-line" style="color:#f58322"></i>&nbsp;BI ARIUS ERP</h4>
                        <h6 class="text-muted card-subtitle mb-2"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg col-md col-6">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-ticket-alt icones"></i>&nbsp; <?php echo $totalTicket["totalTicket"]; ?></h4>
                        <h6 class="text-muted card-subtitle mb-2 subtitulo">Total Tickets</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md col-6">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="far fa-check-circle icones"></i>&nbsp; <?php echo $totalFechado["totalFechado"]; ?></h4>
                        <h6 class="text-muted card-subtitle mb-2 subtitulo">Concluídos</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md col-6">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-business-time icones"></i>&nbsp; <?php echo $totalEmpresa["totalEmpresa"]; ?></h4>
                        <h6 class="text-muted card-subtitle mb-2 subtitulo">Pendente Empresa<br></h6>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md col-6">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-user-clock icones"></i>&nbsp; <?php echo $totalInterno["totalInterno"]; ?></h4>
                        <h6 class="text-muted card-subtitle mb-2 subtitulo">Pendente Interno</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md col-12">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-building icones"></i>&nbsp; <?php echo $totalFabrica["totalFabrica"];?></h4>
                        <h6 class="text-muted card-subtitle mb-2 subtitulo">Pendente Arius</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-6">
                <div class="card cards-supeiror">
                    <div class="card-body">
                        <h1 class="d-xl-flex justify-content-xl-center titulos">Suporte ERP - Anual</h1>
                        <div><canvas data-bss-chart="{&quot;type&quot;:&quot;bar&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Jan&quot;,&quot;Fev&quot;,&quot;Mar&quot;,&quot;Abr&quot;,&quot;Mai&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Ago&quot;,&quot;Set&quot;,&quot;Out&quot;,&quot;Nov&quot;,&quot;Dez&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;Abertos&quot;,&quot;backgroundColor&quot;:&quot;#164259&quot;,&quot;borderColor&quot;:&quot;#164259&quot;,&quot;data&quot;:[&quot;<?php echo $janeiro;?>&quot;,&quot;<?php echo $fevereiro;?>&quot;,&quot;<?php echo $marco;?>&quot;,&quot;<?php echo $abril;?>&quot;,&quot;<?php echo $maio;?>&quot;,&quot;<?php echo $junho;?>&quot;,&quot;<?php echo $julho;?>&quot;,&quot;<?php echo $agosto;?>&quot;,&quot;<?php echo $setembro;?>&quot;,&quot;<?php echo $outubro;?>&quot;,&quot;<?php echo $novembro;?>&quot;,&quot;<?php echo $dezembro;?>&quot;],&quot;stack&quot;:&quot;1&quot;},{&quot;label&quot;:&quot;Concluídos&quot;,&quot;backgroundColor&quot;:&quot;#f58322&quot;,&quot;borderColor&quot;:&quot;#f58322&quot;,&quot;borderWidth&quot;:&quot;1&quot;,&quot;data&quot;:[&quot;<?php echo $janeiroF;?>&quot;,&quot;<?php echo $fevereiroF;?>&quot;,&quot;<?php echo $marcoF;?>&quot;,&quot;<?php echo $abrilF;?>&quot;,&quot;<?php echo $maioF;?>&quot;,&quot;<?php echo $junhoF;?>&quot;,&quot;<?php echo $julhoF;?>&quot;,&quot;<?php echo $agostoF;?>&quot;,&quot;<?php echo $setembroF;?>&quot;,&quot;<?php echo $outubroF;?>&quot;,&quot;<?php echo $novembroF;?>&quot;,&quot;<?php echo $dezembroF;?>&quot;],&quot;stack&quot;:&quot;2&quot;}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:true,&quot;legend&quot;:{&quot;display&quot;:true,&quot;labels&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}},&quot;title&quot;:{&quot;fontStyle&quot;:&quot;bold&quot;},&quot;scales&quot;:{&quot;xAxes&quot;:[{&quot;stacked&quot;:true,&quot;ticks&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}}],&quot;yAxes&quot;:[{&quot;stacked&quot;:true,&quot;ticks&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}}]}}}"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col col-md-6">
                <div class="row">
                    <div class="col col-md-12">
                        <div class="card cards-supeiror">
                            <div class="card-body">
                                <h1 class="d-xl-flex justify-content-xl-center titulos">Abertos e Fechados por Data</h1>
                                <div><canvas data-bss-chart="{&quot;type&quot;:&quot;horizontalBar&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;1 dia&quot;,&quot;Até 3 dias&quot;,&quot;Até 7 dias&quot;,&quot;Até 1 mês&quot;,&quot;Até 3 meses&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;Abertos&quot;,&quot;backgroundColor&quot;:&quot;#164259&quot;,&quot;borderColor&quot;:&quot;#164259&quot;,&quot;borderWidth&quot;:&quot;0&quot;,&quot;data&quot;:[&quot;<?php echo $tabertos1Dia["abertos1Dia"]; ?>&quot;,&quot;<?php echo $tabertos3Dia["abertos3Dia"]; ?>&quot;,&quot;<?php echo $tabertos7Dia["abertos7Dia"]; ?>&quot;,&quot;<?php echo $tabertos30Dia["abertos30Dia"]; ?>&quot;,&quot;<?php echo $tabertos90Dia["abertos90Dia"]; ?>&quot;],&quot;stack&quot;:&quot;1&quot;},{&quot;label&quot;:&quot;Concluídos&quot;,&quot;backgroundColor&quot;:&quot;#f58322&quot;,&quot;data&quot;:[&quot;<?php echo $tfechados1Dia["fechados1Dia"]; ?>&quot;,&quot;<?php echo $tfechados3Dia["fechados3Dia"]; ?>&quot;,&quot;<?php echo $tfechados7Dia["fechados7Dia"]; ?>&quot;,&quot;<?php echo $tfechados30Dia["fechados30Dia"]; ?>&quot;,&quot;<?php echo $tfechados90Dia["fechados90Dia"]; ?>&quot;],&quot;stack&quot;:&quot;2&quot;}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:true,&quot;legend&quot;:{&quot;display&quot;:true,&quot;labels&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}},&quot;title&quot;:{&quot;fontStyle&quot;:&quot;bold&quot;},&quot;scales&quot;:{&quot;xAxes&quot;:[{&quot;stacked&quot;:true,&quot;ticks&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}}],&quot;yAxes&quot;:[{&quot;stacked&quot;:true,&quot;ticks&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}}]}}}"></canvas></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/mini-card-items.js"></script>
</body>

</html>