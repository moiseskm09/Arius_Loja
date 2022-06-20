<?php
require_once './ferramentas/sql_bierp.php';
header("refresh: 90;bierp_2.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>BI ERP - TOTAIS DEPARTAMENTO</title>
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
        <link rel="stylesheet" href="assets/css/avaliacao.css">


        <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
        <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
        <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
    </head>

    <body class="tema">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card cards-supeiror">
                        <div class="card-body p-2">
                            <h4 class="text-center d-lg-flex justify-content-lg-center align-items-lg-center justify-content-xl-center card-title titulos"><img src="assets/img/a_arius.png" width="40" height="40">&nbsp;BI ARIUS ERP</h4>
                            <h6 class="text-muted card-subtitle mb-2"></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 col-md col-lg">
                    <div class="card cards-supeiror">
                        <div class="card-body">
                            <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-ticket-alt icones"></i>&nbsp;<?php echo $totalTicket["totalTicket"]; ?></h4>
                            <h6 class="text-muted card-subtitle mb-2 subtitulo">Total Tickets</h6>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md col-lg">
                    <div class="card cards-supeiror">
                        <div class="card-body">
                            <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="far fa-check-circle icones"></i>&nbsp;<?php echo $totalFechado["totalFechado"]; ?></h4>
                            <h6 class="text-muted card-subtitle mb-2 subtitulo">Concluídos</h6>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md col-lg">
                    <div class="card cards-supeiror">
                        <div class="card-body">
                            <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="far fa-check-circle icones"></i>&nbsp;<?php echo $totalCliente["totalCliente"]; ?></h4>
                            <h6 class="text-muted card-subtitle mb-2 subtitulo">Pendente Cliente</h6>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md col-lg">
                    <div class="card cards-supeiror">
                        <div class="card-body">
                            <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-business-time icones"></i>&nbsp;<?php echo $totalEmpresa["totalEmpresa"]; ?></h4>
                            <h6 class="text-muted card-subtitle mb-2 subtitulo">Pendente Empresa<br></h6>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md col-lg">
                    <div class="card cards-supeiror">
                        <div class="card-body">
                            <h4 class="d-lg-flex align-items-lg-center card-title titulos"><i class="fas fa-user-clock icones"></i>&nbsp;<?php echo $totalInterno["totalInterno"]; ?></h4>
                            <h6 class="text-muted card-subtitle mb-2 subtitulo">Pendente Interno</h6>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md col-lg">
                    <div class="card cards-supeiror">
                        <div class="card-body">
                            <h4 class="d-flex d-lg-flex align-items-center align-items-lg-center card-title titulos"><i class="fas fa-building icones"></i>&nbsp;<?php echo $totalFabrica["totalFabrica"]; ?></h4>
                            <h6 class="text-muted card-subtitle mb-2 subtitulo">Pendente Arius</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card cards-supeiror">
                        <div class="card-body">
                            <h1 class="d-xl-flex justify-content-xl-center titulos">Suporte - Anual</h1>
                            <div id="anychart-embed-samples-bct-column-chart-04" class="anychart-embed anychart-embed-samples-bct-column-chart-04">
                                <div id="ac_style_samples-bct-column-chart-04" style="display:none;"></div>
                                <div id="anychartconteudo"></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row" style="height: 99%">
                        <div class="col col-md-12">
                            <div class="card cards-supeiror" style="height: 99%">
                                <div class="card-body">
                                    <h1 class="d-xl-flex justify-content-xl-center titulos">Suporte - Por Período</h1>
                                    <div id="anychart-embed-samples-bct-column-chart-042" class="anychart-embed anychart-embed-samples-bct-column-chart-04">
                                        <div id="ac_style_samples-bct-column-chart-042" style="display:none;"></div>
                                        <div id="anychartconteudo2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row" style="height: 99%">
                        <div class="col col-md-12">
                            <div class="card cards-supeiror" style="height: 100%">
                                <div class="card-body">
                                    <h1 class="d-xl-flex justify-content-xl-center titulos text-center">Satisfação - Anual</h1>
                                    <h6 class="titulos-analistas text-center">Tickets + Atendimento Online</h6>
                                    <br>
                                    <div class="row">
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <!-- Progress bar 1 -->
                                            <div class="progress mx-auto" data-value='<?php echo number_format($percentualOtimo,0,",","."); ?>'>
                                                <span class="progress-left">
                                                    <span class="progress-bar otimo"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar otimo"></span>
                                                </span>
                                                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h3 text-center"><?php echo number_format($percentualOtimo,0,".","."); ?>%<br>Ótimo</div>
                                                </div>

                                            </div>
                                            <!-- END -->
                                            <h4 class="text-center cor-primaria mt-1"><i class="fas fa-ticket-alt icones-analistas"></i> <?php echo $otimo;?></h4>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <!-- Progress bar 1 -->
                                            <div class="progress mx-auto" data-value='<?php echo number_format($percentualSatisfatorio,0,".","."); ?>'>
                                                <span class="progress-left">
                                                    <span class="progress-bar regular"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar regular"></span>
                                                </span>
                                                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h3 text-center"><?php echo number_format($percentualSatisfatorio,0,".","."); ?>%<br>Regular</div>
                                                </div>
                                            </div>
                                            <!-- END -->
<h4 class="text-center cor-primaria mt-1"><i class="fas fa-ticket-alt icones-analistas"></i> <?php echo $satisfatorio;?></h4>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <!-- Progress bar 1 -->
                                            <div class="progress mx-auto" data-value='<?php echo number_format($percentualRuim,0,".","."); ?>'>
                                                <span class="progress-left">
                                                    <span class="progress-bar ruim"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar ruim"></span>
                                                </span>
                                                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h3 text-center"><?php echo number_format($percentualRuim,0,".","."); ?>%<br>Ruim </div>
                                                </div>
                                            </div>
                                            <!-- END -->
<h4 class="text-center cor-primaria mt-1"><i class="fas fa-ticket-alt icones-analistas"></i> <?php echo $totalRuim;?></h4>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <!-- Progress bar 1 -->
                                            <div class="progress mx-auto" data-value='<?php echo number_format($percentualna,0,".","."); ?>'>
                                                <span class="progress-left">
                                                    <span class="progress-bar naoavaliados"></span>
                                                </span>
                                                <span class="progress-right">
                                                    <span class="progress-bar naoavaliados"></span>
                                                </span>
                                                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                    <div class="h3 text-center"><?php echo number_format($percentualna,0,".","."); ?>%<br>N/A</div>
                                                </div>
                                            </div>
                                            <!-- END -->
<h4 class="text-center cor-primaria mt-1"><i class="fas fa-ticket-alt icones-analistas"></i> <?php echo $na;?></h4>
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
        <script src="assets/js/chart.min.js"></script>
        <script src="assets/js/bs-init.js"></script>
        <script src="assets/js/anychart.js"></script>
        <script>
            (function () {
                function ac_add_to_head(el) {
                    var head = document.getElementsByTagName('head')[0];
                    head.insertBefore(el, head.firstChild);
                }
                function ac_add_link(url) {
                    var el = document.createElement('link');
                    el.rel = 'stylesheet';
                    el.type = 'text/css';
                    el.media = 'all';
                    el.href = url;
                    ac_add_to_head(el);
                }
                function ac_add_style(css) {
                    var ac_style = document.createElement('style');
                    if (ac_style.styleSheet)
                        ac_style.styleSheet.cssText = css;
                    else
                        ac_style.appendChild(document.createTextNode(css));
                    ac_add_to_head(ac_style);
                }
                ac_add_link('https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css?hcode=a0c21fc77e1449cc86299c5faa067dc4');
                ac_add_style(document.getElementById("ac_style_samples-bct-column-chart-04").innerHTML);
                ac_add_style(".anychart-embed-samples-bct-column-chart-04{width:100%;height:255px;}");
            })();
            anychart.onDocumentReady(function () {

                // create a data set
                var data = anychart.data.set([
<?php
if ($janeiro > 0 OR $janeiroF > 0) {
    echo "['Jan',$janeiro, $janeiroF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>
<?php
if ($fevereiro > 0 OR $fevereiroF > 0) {
    echo "['Fev',$fevereiro, $fevereiroF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>
<?php
if ($marco > 0 OR $marcoF > 0) {
    echo "['Mar',$marco, $marcoF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>
<?php
if ($abril > 0 OR $abrilF > 0) {
    echo "['Abr',$abril, $abrilF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>
<?php
if ($maio > 0 OR $maioF > 0) {
    echo "['Mai',$maio, $maioF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>
<?php
if ($junho > 0 OR $junhoF > 0) {
    echo "['Jun',$junho, $junhoF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>

<?php
if ($julho > 0 OR $julhoF > 0) {
    echo "['Jul',$julho, $julhoF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>

<?php
if ($agosto > 0 OR $agostoF > 0) {
    echo "['Ago',$agosto, $agostoF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>
<?php
if ($setembro > 0 OR $setembroF > 0) {
    echo "['Set',$setembro, $setembroF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>
<?php
if ($outubro > 0 OR $outubroF > 0) {
    echo "['Out',$outubro, $outubroF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>
<?php
if ($novembro > 0 OR $novembroF > 0) {
    echo "['Nov',$novembro, $novembroF, '#1d42898f', '#f1be488f', null, {enabled: true}],";
}
?>

<?php
if ($dezembro > 0 OR $dezembroF > 0) {
    echo "['Dez',$dezembro, $dezembroF, '#1d42898f', '#f1be488f', null, {enabled: true}]";
}
?>
                ]);

                // map the data
                var seriesData_1 = data.mapAs({x: 0, value: 1, fill: 3, stroke: 5, label: 6});
                var seriesData_2 = data.mapAs({x: 0, value: 2, fill: 4, stroke: 5, label: 6});

                // create a chart
                var chart = anychart.column();

                // create the first series, set the data and name
                var series1 = chart.column(seriesData_1);
                series1.name("Abertos");
                series1.normal().fill("#1d4289", 0.8);
                series1.hovered().fill("#1d4289", 0.9);
                series1.selected().fill("#1d4289", 0.9);
                series1.normal().hatchFill("forward-diagonal", "#1d4289", 1, 15);
                series1.hovered().hatchFill("forward-diagonal", "#ffffff", 1, 15);
                series1.selected().hatchFill("forward-diagonal", "#1d4289", 1, 15);
                series1.stroke("#1d42898f");
                series1.hovered().stroke("#1d42898f", 2);
                series1.selected().stroke("#1d42898f", 4);

                series1.labels(true);
                labels = series1.labels();
                labels.fontColor('#1d4289');
                labels.fontSize("11px");
                labels.fontWeight(900);
                labels.position("center-top");
                labels.offsetY(-5);

                // create the second series, set the data and name
                var series2 = chart.column(seriesData_2);
                series2.name("Concluídos");
                series2.normal().fill("#f1be48", 0.3);
                series2.hovered().fill("#f1be48", 0.1);
                series2.selected().fill("#f1be48", 0.5);
                series2.normal().hatchFill("forward-diagonal", "#f1be48", 1, 15);
                series2.hovered().hatchFill("forward-diagonal", "#f1be48", 1, 15);
                series2.selected().hatchFill("forward-diagonal", "#f1be48", 1, 15);
                series2.normal().stroke("#f1be48");
                series2.hovered().stroke("#f1be48", 2);
                series2.selected().stroke("#f1be48", 4);

                series2.labels(true);
                labels = series2.labels();
                labels.fontColor('#1d4289');
                labels.fontSize("12px");
                labels.fontWeight(900);
                labels.position("center-top");
                labels.offsetY(-5);
                // enable the legend
                chart.legend(true);
                // set the layout of the legend
                chart.legend().itemsLayout("horizontal");
                // set the position of the legend
                chart.legend().align("center");
                // set the container id
                chart.container("anychartconteudo");

                // initiate drawing the chart
                chart.draw();
            });
        </script>

        <script>
            (function () {
                function ac_add_to_head(el) {
                    var head = document.getElementsByTagName('head')[0];
                    head.insertBefore(el, head.firstChild);
                }
                function ac_add_link(url) {
                    var el = document.createElement('link');
                    el.rel = 'stylesheet';
                    el.type = 'text/css';
                    el.media = 'all';
                    el.href = url;
                    ac_add_to_head(el);
                }
                function ac_add_style(css) {
                    var ac_style = document.createElement('style');
                    if (ac_style.styleSheet)
                        ac_style.styleSheet.cssText = css;
                    else
                        ac_style.appendChild(document.createTextNode(css));
                    ac_add_to_head(ac_style);
                }
                ac_add_link('https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css?hcode=a0c21fc77e1449cc86299c5faa067dc4');
                ac_add_style(document.getElementById("ac_style_samples-bct-column-chart-03").innerHTML);
                ac_add_style(".anychart-embed-samples-bct-column-chart-03{width:100%;height:250px;}");
            })();</script>
        <div id="container"></div>
        <script>
            anychart.onDocumentReady(function () {

                // create data
                var data = [
                    {x: "1 Dia", value: <?php echo $tabertosFechados1Dia["abertos1Dia"]; ?>,
                        normal: {
                            label: {enabled: true}
                        }
                    },

                    {x: "3 Dias", value: <?php echo $tabertosFechados3Dia["abertos3Dia"]; ?>,
                        normal: {
                            label: {enabled: true}
                        }
                    },
                    {x: "7 Dias", value: <?php echo $tabertosFechados7Dia["abertos7Dia"]; ?>,
                        normal: {
                            label: {enabled: true}

                        }
                    },
                    {x: "30 Dias", value: <?php echo $tabertosFechados30Dia["abertos30Dia"]; ?>,
                        normal: {
                            label: {enabled: true}
                        }
                    },
                    {x: "+ 30 Dias", value: <?php echo $tabertosFechados90Dia["abertos90Dia"]; ?>,
                        normal: {
                            label: {enabled: true}
                        }
                    }
                ];

                // create a chart
                var chart = anychart.column();



                // create a column series and set the data
                var series = chart.column(data);
                series.name("Concluídos");
                series.normal().fill("#f1be48", 0.5);
                series.hovered().fill("#f1be48", 0.1);
                series.selected().fill("#f1be48", 0.5);
                series.normal().hatchFill("forward-diagonal", "#f1be48", 1, 15);
                series.hovered().hatchFill("forward-diagonal", "#f1be48", 1, 15);
                series.selected().hatchFill("forward-diagonal", "#f1be48", 1, 15);
                series.normal().stroke("#f1be48");
                series.hovered().stroke("#f1be48", 2);
                series.selected().stroke("#f1be48", 4);

                series.labels(true);
                labels = series.labels();
                labels.fontColor('#1d4289');
                labels.fontSize("11px");
                labels.fontWeight(900);
                labels.position("center-top");
                labels.offsetY(-5);
                // enable the legend
                chart.legend(true);

                // set the container id
                chart.container("anychartconteudo2");

                // initiate drawing the chart
                chart.draw();
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
        <script src="assets/js/mini-card-items.js"></script>
        <script src="assets/js/avaliacao.js"></script>
    </body>

</html>