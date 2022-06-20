<?php 
require_once 'ferramentas/sql_biloja_uc.php';
header("refresh: 90;bibackup.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>BI LOJA - TOTAIS ANALISTAS E CLIENTES</title>
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
    <link rel="stylesheet" href="assets/css/Simple-Slider.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="tema">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card cards-supeiror">
                    <div class="card-body p-2">
                        <h4 class="text-center d-lg-flex justify-content-lg-center align-items-lg-center justify-content-xl-center card-title titulos"><img src="assets/img/a_arius.png" width="40" height="40">&nbsp;BI ARIUS LOJA</h4>
                        <h6 class="text-muted card-subtitle mb-2"></h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="row" style="height: 100%">
                    <div class="col-12">
                        <div class="card" style="height: 100%;">
                            <div class="card-body card-info-time">
                                <h1 class="text-center titulos"><i class="fas fa-user-tie cor-secundaria"></i>&nbsp;TIME</h1>
                                <div class="row">
                                    <?php 
                                    while($resultado = mysqli_fetch_assoc($consultatck)){
                                    ?>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="card d-xxl-flex">
                                            <div class="card-body card-body-analistas">
                                                <div class="row">
                                                    <div class="col-12 col-md-4 col-lg-4">
                                                        <div class="profile-image"><img src="assets/img/avatar/<?php echo $resultado["avatar"]; ?>"></div>
                                                    </div>
                                                    <div class="col-12 col-md-8 col-lg-8">
                                                        <div>
                                                            <h6 class="titulos-analistas"><?php echo $resultado["usuario"];?></h6>
                                                            <div class="row">
                                                                <div class="col-4"><i class="fas fa-ticket-alt icones-analistas"></i>
                                                                    <h6 class="titulos-valores"><?php echo $resultado["tt"];?></h6>
                                                                </div>
                                                                <div class="col-4"><i class="far fa-comments icones-analistas"></i>
                                                                    <h6 class="titulos-valores"><?php echo $resultado["tto"];?></h6>
                                                                </div>
                                                                <div class="col-4"><i class="fas fa-chart-line icones-analistas"></i>
                                                                    <h6 class="titulos-valores"><?php echo $resultado["ttg"];?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }
                                    ?>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="row" style="height: 100%">
                    <div class="col-12">
                        <div class="card" style="height: 100%">
                            <div class="card-body card-info-cliente">
                                <h1 class="text-center titulos"><i class="fas fa-building cor-secundaria"></i>&nbsp;CLIENTES</h1>
                                <div class="row">
                                    <?php 
                                    while($resultadoEmpresa = mysqli_fetch_assoc($consultaEmpresa)){
                                    ?>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="card d-xxl-flex">
                                            <div class="card-body card-body-analistas">
                                                <div class="row">
                                                    <div class="col-12 col-md-9 col-lg-9">
                                                        <div>
                                                            <h6 class="titulos-clientes"><?php echo ucwords (strtolower($resultadoEmpresa["nomeempresa"]));?></h6>
                                                            <div class="row">
                                                                <div class="col-4"><i class="fas fa-ticket-alt icones-analistas"></i>
                                                                    <h6 class="titulos-valores"><?php echo $resultadoEmpresa["tt"];?></h6>
                                                                </div>
                                                                <div class="col-4"><i class="far fa-comments icones-analistas"></i>
                                                                    <h6 class="titulos-valores"><?php echo $resultadoEmpresa["tto"];?></h6>
                                                                </div>
                                                                <div class="col-4"><i class="fas fa-chart-line icones-analistas"></i>
                                                                    <h6 class="titulos-valores"><?php echo $resultadoEmpresa["ttg"];?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3 col-lg-3">
                                                        <div class="profile-image-cliente"><img src="assets/img/logotipo/<?php echo $resultadoEmpresa["avatar"];?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    }
                                    ?>
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
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/grafico.js"></script>
    <script src="assets/js/grggrafico.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/mini-card-items.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
</body>

</html>