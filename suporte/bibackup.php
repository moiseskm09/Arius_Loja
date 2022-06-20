<?php
require_once './ferramentas/sql_bibackup.php';
header("refresh: 90;bierp_1.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>BI BACKUP - MONITORAMENTO</title>
        <link rel="shortcut icon" href="assets/img/a_arius.png">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata&amp;display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
        <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
        <link rel="stylesheet" href="assets/css/estilo.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.css">
        <link rel="stylesheet" href="assets/css/backup.css">
        <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
    </head>

    <body class="tema" style="height: 100vh">
        <div class="container-fluid" style="height: 100%">
            <div class="row">
                <div class="col-md-12">
                    <div class="card cards-supeiror">
                        <div class="card-body p-2">
                            <h4 class="text-center d-lg-flex justify-content-lg-center align-items-lg-center justify-content-xl-center card-title titulos"><img src="assets/img/a_arius.png" width="40" height="40">&nbsp;BI BACKUP SERVIDORES</h4>
                            <h6 class="text-muted card-subtitle mb-2"></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="row">
                         <!-- card info -->
                         <div class="col-12 col-md-12 col-lg-12" >
                             <div class="card d-xxl-flex card-backup">
                                 <div class="card-body card-body-analistas">
                                     <div class="row text-center">
                                         <div class="col-12">
                                             <h6 class="titulos">SERVIDORES MONITORADOS</h6>
                                         </div>
                                         <div class="col-12">
                                             <h2 class="backup-valores"><?php echo $totalbackup; ?></h2>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-12 col-md-12 col-lg-12">
                             <div class="card d-xxl-flex card-backup">
                                 <div class="card-body card-body-analistas">
                                     <div class="row text-center">
                                         <div class="col-12">
                                             <h6 class="titulos">CLIENTES MONITORADOS</h6>
                                         </div>
                                         <div class="col-12">
                                             <h2 class="backup-valores"><?php echo $totalcliente; ?></h2>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="col-12 col-md-12 col-lg-12">
                             <div class="card d-xxl-flex card-backup">
                                 <div class="card-body card-body-analistas">
                                     <div class="row text-center">
                                         <div class="col-12">
                                             <h6 class="titulos">MONITOR GERAL</h6>
                                         </div>
                                         <div class="col-12">
                                             <div id="anychart-embed-samples-bct-doughnut-chart-01" class="anychart-embed anychart-embed-samples-bct-doughnut-chart-01">
<div id="ac_style_samples-bct-doughnut-chart-01" style="display:none;">
    
                                         </div>
                                                 <div id="backupgeral"></div>
                                     </div>
                                             
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <!-- card info -->
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card d-xxl-flex">
                                <div class="card-body card-body-analistas">
                                    <h6 class="text-center titulos mb-2">REALIZADOS COM SUCESSO</h6>
                                            <!-- Progress bar 1 -->
                                            <div class="progress mx-auto" data-value='<?php echo number_format($percentualS,0,".","."); ?>'>
                                                <span class="progress-left">
                                                    <span class="progress-bar realizado"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar realizado"></span>
                                                </span>
                                                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h2 text-center"><?php echo number_format($percentualS,2,".","."); ?>%</div>
                                                </div>

                                            </div>
                                            <!-- END -->
                                            <h4 class="text-center cor-primaria mt-1"><i class="fas fa-ticket-alt icones-analistas"></i> <?php echo $backupok;?></h4>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card d-xxl-flex">
                                <div class="card-body card-body-analistas ">
                                    <h6 class="text-center titulos mb-2">REALIZADOS COM DIVERGÊNCIA</h6>
                                            <!-- Progress bar 1 -->
                                            <div class="progress mx-auto" data-value='<?php echo number_format($percentualD,0,".","."); ?>'>
                                                <span class="progress-left">
                                                    <span class="progress-bar divergente"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar divergente"></span>
                                                </span>
                                                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h2 text-center"><?php echo number_format($percentualD,2,".","."); ?>%</div>
                                                </div>

                                            </div>
                                            <!-- END -->
                                            <h4 class="text-center cor-primaria mt-1"><i class="fas fa-ticket-alt icones-analistas"></i> <?php echo $backupdivergente;?></h4>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card d-xxl-flex" style="height: 99%">
                                <div class="card-body card-body-analistas ">
                                    <h6 class="text-center titulos mb-2">NÃO REALIZADOS</h6>
                                            <!-- Progress bar 1 -->
                                            <div class="progress mx-auto" data-value='<?php echo number_format($percentualE,0,".","."); ?>'>
                                                <span class="progress-left">
                                                    <span class="progress-bar naorealizado"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar naorealizado"></span>
                                                </span>
                                                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h2 text-center"><?php echo number_format($percentualE,2,".","."); ?>%</div>
                                                </div>

                                            </div>
                                            <!-- END -->
                                            <h4 class="text-center cor-primaria mt-1"><i class="fas fa-ticket-alt icones-analistas"></i> <?php echo $backuperro;?></h4>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card d-xxl-flex" style="height: 99%;">
                                <div class="card-body card-body-analistas card-erros">
                                    <h6 class="text-center titulos mb-4">RELAÇÃO DE ERROS</h6>
                                    <div class="relacao p-0">
                                        <div class="row">
                                            <?php  
                                            while($resultadoRelacaoErros = mysqli_fetch_assoc($buscaRelacaoerros)){
                                                ?>
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <div class="col-6 fw-bold"><?php echo $resultadoRelacaoErros["cliente"];?></div>
                                                    <div class="col-3"><?php echo $resultadoRelacaoErros["loja"];?></div>
                                                    <div class="col-3"><?php echo date('d-m-y', strtotime($resultadoRelacaoErros["dtatualizacao"]));?></div>
                                                </div>
                                            </div>
                                            
                                            <?php  }?>
                                            
                                       </div>
                                    </div>       
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
        <script src="assets/js/backup.js"></script>
        <script>(function(){
function ac_add_to_head(el){
	var head = document.getElementsByTagName('head')[0];
	head.insertBefore(el,head.firstChild);
}
function ac_add_link(url){
	var el = document.createElement('link');
	el.rel='stylesheet';el.type='text/css';el.media='all';el.href=url;
	ac_add_to_head(el);
}
function ac_add_style(css){
	var ac_style = document.createElement('style');
	if (ac_style.styleSheet) ac_style.styleSheet.cssText = css;
	else ac_style.appendChild(document.createTextNode(css));
	ac_add_to_head(ac_style);
}
ac_add_link('https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css?hcode=a0c21fc77e1449cc86299c5faa067dc4');
ac_add_style(document.getElementById("ac_style_samples-bct-doughnut-chart-01").innerHTML);
ac_add_style(".anychart-embed-samples-bct-doughnut-chart-01{width:100%;height:100%;}");
})();</script>

<script>
anychart.onDocumentReady(function () {

    // create data
    var data = [
      {x: "SUCESSO", value: <?php echo $backupok?>,
      normal:  {
      fill: "#198754",  
   },
      },
      {x: "DIVERGENTE", value: <?php echo $backupdivergente?>,
      normal:  {
      fill: "#ffc107",  
   },},
      {x: "FALHA", value: <?php echo $backuperro?>,
      normal:  {
      fill: "#dc3545",  
   },},
    ];

    // create a pie chart and set the data
    var chart = anychart.pie(data);

    /* set the inner radius
    (to turn the pie chart into a doughnut chart)*/
    chart.innerRadius("70%");
  
    // set the container id
    chart.container("backupgeral");

    // initiate drawing the chart
    chart.draw();
});
</script>

    </body>

</html>