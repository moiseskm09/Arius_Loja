<?php 
include ("config/config_geral.php");

?>


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/menu.css">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="inicio.php"><h3 class="text-center"><img src="img/logo_siga.png" style="width: 150px;"></h3></a>
            <strong style="font-size: 12px; ">Sistema Integrado de Gestão Arius</strong>
        </div>

        <ul class="list-unstyled components">
            <li class="active">
                <a href="inicio.php">
                    <i class="fas fa-home"></i>
                INICIO
            </a>
            </li>
            <li>
           
                <a href="#cadastro" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-chalkboard-teacher"></i>
                    CADASTRO
                </a>
                <ul class="collapse list-unstyled" id="cadastro">
                    <li>
                        <a href="cadastraruser.php">Usuários</a>
                    </li>
                    <li>
                        <a href="cadastrarcliente.php">Lojas</a>
                    </li>
                              </ul>
            </li>


              <li>
           
                <a href="#consulta" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-search"></i>
                    CONSULTA
                </a>
                <ul class="collapse list-unstyled" id="consulta">
                    <li>
                        <a href="consultausuario.php">Usuários</a>
                    </li>
                    <li>
                        <a href="consultacliente.php">Lojas</a>
                    </li>
                    </ul>
            </li>

            <li>
           
                <a href="#conciliacao" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-copy"></i>
                    CONCILIAÇÃO
                </a>
                <ul class="collapse list-unstyled" id="conciliacao">
                    <li>
                        <a href="conciliacao.php">Painel</a>
                    </li>
                    <li>
                        <a href="reenviar.php">Reenviar FTP</a>
                    </li>
                    <li>
                        <a href="geraconciliacaolocal.php">Gerar Localmente</a>
                    </li>
                </ul>
          
            </li>
           <li >
                <a href="licenca.php">
                    <i class="fas fa-shield-alt"></i>
                LICENÇA
            </a>
            </li>

            <li >
                <a href="carga.php">
                   <i class="fas fa-exchange-alt"></i>
                IMPORTAÇÃO
            </a>
 	    <li >
                <a href="integracao.php">
                   <i class="fas fa-sitemap"></i>
                INTEGRAÇÃO
            </a>
            </li>

                  <li>
           
                <a href="#configuracao" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-copy"></i>
                    CONFIGURAÇÃO
                </a>
                <ul class="collapse list-unstyled" id="configuracao">
                    <li>
                        <a href="restrito.php">FTP Conciliação</a>
                    </li>
                    <li>
                        <a href="../phpmyadmin">phpMyAdmin</a>
                    </li>
                    </ul>
          
            </li>



                     

        </ul>
<h6 id="login"><i class="fas fa-user-circle"></i> <?php echo ucfirst($nome_logado);?></h6>

<a href="logout.php"><h6 id="sair"><i class="fas fa-sign-out-alt"></i> Sair</h6></a>
    </nav>


  <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
 
        <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

</body>


</html>
