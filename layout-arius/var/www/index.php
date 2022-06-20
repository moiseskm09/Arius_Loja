<?php
require_once "sistema/bd.class.php";
require_once "sistema/libs.php";
require_once "sistema/config.inc.php";
require_once "sistema/login.class.php";
require_once "sistema/licenca.class.php";

//setcookie('sso','AjExMDABAAdTQVBVU0VSAgADOTk5AwADRVhUBAAMMjAxMTA5MDcxMDQ2BQAEAAKsYAgAAQEgABFwb3J0YWw6UE9SVEFMVVNFUogAE2Jhc2ljYXV0aGVudGljYXRpb27/AT4wggE6BgkqhkiG9w0BBwKgggErMIIBJwIBATELMAkGBSsOAwIaBQAwCwYJKoZIhvcNAQcBMYIBBjCCAQICAQEwVzBMMQswCQYDVQQGEwJERTEcMBoGA1UEChMTbXlTQVAuY29tIFdvcmtwbGFjZTERMA8GA1UECxMIU0FQIFRlc3QxDDAKBgNVBAMTA1NZUwIHIBEIJBVVSDAJBgUrDgMCGgUAoF0wGAYJKoZIhvcNAQkDMQsGCSqGSIb3DQEHATAcBgkqhkiG9w0BCQUxDxcNMTEwOTA3MTA0NjEzWjAjBgkqhkiG9w0BCQQxFgQU4lvc!J0ne0uWJDAlmYY2vGhfkq4wCQYHKoZIzjgEAwQvMC0CFCuCpBG10JDoxYQ/QgqlN!Zc7rxRAhUAiaj46GoR3Ayo2PgJFZlNwg2axL4=',time()+60);

if(isset($_COOKIE['sso'])){

    // verifica nome do usuário
    $sso = exec("/sso/sso -i  ".$_COOKIE['sso']." -p /sso/verify.pse 2>&1");


    //conecta no banco de dados e executa a consulta para ver se existe usuario no sistema com o mesmo nome do retorno do exec.
    $con = new bd;
    $con->connect();

    $sql = "SELECT codigo, senha, nroloja FROM ".BD_CONTROLE.".usuarios WHERE nome = '".$sso."'";
    $con->query($sql);

    // validar se a consulta trouxe resultados e se trouxe validar no sistema.

    if($con->num_rows){
        $row = $con->fetch_array();

        $codigoUsuario = $row['codigo'];
        $senhaUsuario = $row['senha'];
        $nroloja = $row['nroloja'];

        // efetua login

        //mata a variável de sessão caso houver

        @session_destroy();
        @session_start();

        // regerar a sessao para não dar conflito com o phpmyadmin
        session_regenerate_id();

        //conecta no banco de dados
        $con = new bd;
        $con->connect();

        $con2 = new bd;
        $con2->connect();

        if( $codigoUsuario && $senhaUsuario && $nroloja ){
            //busca configuração do usuário
            $sql = "
          SELECT
            a.nome,
            a.nivel,
            a.senha,
                a.taxaServico,
            b.diretorio,
            c.autoridade
          FROM
            ".BD_CONTROLE.".usuarios a
          LEFT JOIN
            ".BD_CONTROLE.".temas b
          ON
            a.tema = b.codigo
          LEFT JOIN
            ".BD_CONTROLE.".nivel c
          ON
            a.nivel = c.codnivel and
            c.nroloja='".$nroloja."'
          WHERE
                        a.codigo = '".$codigoUsuario."' AND
            a.nroloja = '".$nroloja."' AND
                    a.senha = '".$senhaUsuario."'
        ";   //echo $sql."<br><br>";   exit;

            $con->query( $sql );
        }

        //USUARIO JA LOGADO TROCA DE LOJA SEM REFAZER LOGIN
        if( $_POST['TROCA_NROLOJA'] && $codigoUsuario && $nroloja ){
            //busca configuração do usuário
            $sql = "
          SELECT
            a.nome,
            a.nivel,
            a.senha,
                  a.taxaServico,
            b.diretorio,
            c.autoridade
          FROM
            ".BD_CONTROLE.".usuarios a
          LEFT JOIN
            ".BD_CONTROLE.".temas b
          ON
            a.tema = b.codigo
          LEFT JOIN
            ".BD_CONTROLE.".nivel c
          ON
            a.nivel = c.codnivel and
            c.nroloja='".$nroloja."' 
          WHERE
                        a.codigo = '".$codigoUsuario."' AND
            a.nroloja = '".$nroloja."'
        ";   //echo $sql."<br><br>";   exit;

            $con->query( $sql );
        }
//      echo $sql;exit;

        if( $con->num_rows == 1 ){

            $row = $con->fetch_array();

            $_SESSION["USUARIO"]["CODIGO"] = $codigoUsuario;
            $_SESSION["USUARIO"]["NOME"] = $row["nome"];
            $_SESSION["USUARIO"]["NIVEL"] = $row["nivel"];
            $_SESSION["USUARIO"]["TEMA"] = $row["diretorio"];
            $_SESSION["USUARIO"]["TAXASERVICO"] = $row["taxaServico"];
            $_SESSION["USUARIO"]["AUTORIDADE"] = $row["autoridade"];

            //busca configuração da loja e seta a sessao com os dados da loja
            $objSess=new Sessao($nroloja);



            //carregar configuração de níveis de acesso do usuário
            $sql = "SELECT m.nome,
                m.codigo,
                m.link
              FROM ".BD_CONTROLE.".menu m
              WHERE m.ativo = 1
                  AND m.codigo_pai = 0
              ORDER BY m.ordem ASC";

            $con->query( $sql );

            $_SESSION["MENULINKS"] = array( ); //links que o usuário tem acesso
            $_SESSION["MENU"] = array();

            $cont = 0; //contador do menu
            while( $row = $con->fetch_array() ){
                $cont++;

                //buscar menu
                $_SESSION["MENU"][$cont]["NOME"] = $row["nome"];
                $_SESSION["MENU"][$cont]["LINK"] = $row["link"];
                $_SESSION["MENU"][$cont]["CODIGO"] = $row["codigo"];

                //guarda código do menu corrente
                $guardaContMenu = $cont;

                //buscar submenu
                $sql = "SELECT m.nome,
                    m.codigo,
                    m.link,
                    IF(n.ativo = 1, 1, 0) as ativo
              FROM ".BD_CONTROLE.".menu m
                  LEFT JOIN ".BD_CONTROLE.".menunivel n ON ( n.nroloja='".$_SESSION["LOJA"]["NROLOJA"]."' and m.codigo = n.codigo_menu )
              WHERE m.ativo = 1
                  AND m.codigo_pai = '".$row["codigo"]."'
                  AND n.codigo_nivel = '".$_SESSION["USUARIO"]["NIVEL"]."'
              ORDER BY m.nome";

                //die($sql);
                $con2->query( $sql );

                $cont++;

                $contSubmenu = 0; //contador do submenu
                while( $row2 = $con2->fetch_array() ){
                    if( $row2["ativo"] == 1 ){
                        $_SESSION["MENU"][$cont]["NOME"] = $row2["nome"];
                        $_SESSION["MENU"][$cont]["LINK"] = $row2["link"];
                        $_SESSION["MENU"][$cont]["CODIGO"] = $row2["codigo"];

                        //guardar path formatada
                        $paginaName = str_replace( "..", "", $row2["link"] );
                        array_push( $_SESSION["MENULINKS"], dirname( DIRETORIO_APLICACAO.$paginaName ) );
                        $contSubmenu++;
                    }

                    $cont++;
                }

                //verifica se tem pelo menos um submenu, se NÃO estiver excluir o menu
                if( $contSubmenu == 0 ){
                    unset( $_SESSION["MENU"][$guardaContMenu]["NOME"] );
                    unset( $_SESSION["MENU"][$guardaContMenu]["LINK"] );
                    unset( $_SESSION["MENU"][$guardaContMenu]["CODIGO"] );
                }
            }

            //verificar licenca
            $licenca = new licenca();
            $licenca->arquivoLicencas = "/servidor/licencas".$_SESSION["LOJA"]["CGC"].".dat";
            $retorno = $licenca->verificaLicenca( $erro );
            $_SESSION["LICENCA"]["DIASFALTANTES"] = $licenca->diasFaltantes;
            $_SESSION["LICENCA"]["DIASAVISO"] = $licenca->diasAviso;
            $_SESSION["LICENCA"]["DATAFORMATADA"] = $licenca->dataFormatada;

            if( $licenca->arq_licenca_not_found === true ){
                $this->avisoLicenca = 1;
                return true;
            }

            //verifica se não ocorreu nenhum erro em executar a rotina em C, ou não encontrou o arquivo
            if( $erro == 0 && $retorno != 0 ){
                //verificar validade da licenca
                if( ( ($licenca->diasFaltantes <= $licenca->diasAviso) && ($licenca->diasFaltantes > 0) ) ){
                    $this->avisoLicenca = 1;
                }elseif( $licenca->diasFaltantes <= 0 ){
                    //licença expirada, destruir sessão do usuário
                    session_destroy();
                    unset( $_SESSION );
                    $this->avisoLicenca = 2;
                }
            }

            header("Location: sistema/principal.php");
        }
    }else{

    }
}else{

    if ($_POST["ajax"] || $_GET["ajax"]) {
        $con = new bd;
        $con->connect();
        $ajax = ($_POST["ajax"] ? $_POST["ajax"] : $_GET["ajax"]);


        switch ($ajax) {
            case "verifica_novo_usuario":
                $user = $_POST["usuario"];
                if ($user) {
                    $sql = "
                             SELECT senha FROM " . BD_CONTROLE . ".usuarios WHERE codigo='" . $user . "' order by nroloja limit 1";
                    $con->query($sql);
                    if ($con->num_rows) {
                        $row = $con->fetch_array();
                        if ($row['senha'] === '0') {
                            $retorno = 'novo-usuario';
                        }
                    }
                }
                break;
            case "verifica_lojas_acesso":
                $user = $_POST["usuario"];
                $pass = $_POST["senha"];
                if ($user) {
                    $sql = "
                         SELECT nroloja FROM " . BD_CONTROLE . ".usuarios WHERE codigo='" . $user . "' order by nroloja limit 1";
                    $con->query($sql);
                    if ($con->num_rows) {
                        $cont = 0;
                        while ($row = $con->fetch_array()) {
                            $cont++;
                        }
                        if ($cont > 1) {
                            $retorno = "master";
                        } else {
//                         $sql = "
//                             SELECT nroloja FROM ".BD_CONTROLE.".usuarios WHERE senha='".montaSenha($user, $pass)."' order by nroloja limit 1"
//                         ;
                            $sql = "
                             SELECT nroloja FROM " . BD_CONTROLE . ".usuarios WHERE codigo ='" . $user . "' order by nroloja limit 1";
                            $con->query($sql);
                            $row = $con->fetch_array();
                            $retorno = $row["nroloja"];
                        }

                    }
                }
                break;
            case "verifica_lojas_quatidade":
                $master = $_POST["master"];
                $count = 0;
                $sql = "SELECT nroloja FROM " . BD_CONTROLE . ".pf_loja group by nroloja";
                $con->query($sql);
                if ($con->num_rows) {
                    while ($row = $con->fetch_array()) {
                        $count++;

                        $retorno = $row["nroloja"];
                        if ($count > 1) {
                            $retorno = 'false';
                            break;
                        }
                    }
                }
                break;
            case "verifica_lojas":
                $sql = "
                   SELECT nroloja FROM " . BD_CONTROLE . ".pf_loja";
                $con->query($sql);
                if ($con->num_rows) {
                    $row = $con->fetch_array();
                    $retorno = $row["nroloja"];
                }
                break;
            case "monta_combo_lojas":
                $user = $_POST["usuario"];
                $pass = $_POST["senha"];

                $sql = "select p.nroloja, concat(p.nroloja,' - ',p.razao) as descr from " . BD_CONTROLE . ".pf_loja p inner join " . BD_CONTROLE . ".usuarios u on u.codigo='" . $user . "'  where u.nroloja = p.nroloja   union select '#', 'Selecione'";
                $retorno = combo("nroloja", $sql, "", false);
                break;
            case "encripta_senha":

                $user = $_POST["usuario"];
                $pass = $_POST["senha"];

                $retorno = montaSenha($user, $pass);

                break;
        }

        echo $retorno;
        exit();
    }
}

//conecta no banco de dados e executa a consulta da razão social da loja
    $con = new bd;
    $con->connect();

    $sqlrazao = "SELECT razao FROM ".BD_CONTROLE.".pf_loja ";
    $con->query($sqlrazao);

        $rowrazao = $con->num_rows;
        $razao = $con->fetch_array($sqlrazao);

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Arius Loja - Autentica&ccedil;&atilde;o</title>
    <script type="text/javascript" src="sistema/js/jquery/jquery.js"></script>
    <script type="text/javascript" src="script.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/estilo.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link href="fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="fontawesome/css/brands.css" rel="stylesheet">
    <link href="fontawesome/css/solid.css" rel="stylesheet">

    </head>
  <body>
    <div class="container-fluid">
      <div class="row">

    <div class="col-sm col-md-12 col-lg-12 col-xl-12">
              <center>
              <div class="card text-center  ">
              <div class="card-header">
                <h5><?php if ($rowrazao > 1) {
                 //echo $razao["razao"] - Multiloja;
                  echo "{$razao['razao']} - Multiloja";
                  } else {
                  echo $razao["razao"];
                  } 
                  ?>
                </h5>
              </div>
              <div class="card-body">
                <form name="f" id="frm" method="post" action="sistema/login.php">
                <div class="form-group">
                  <img class="card-title" id="logo-login" src="sistema/imagens/ariuslogo.png" style="width: 200px;">
                </div> 
                

                <div class="form-group ">
                <input type="text" name="USUARIO" id="usuario" autocomplete="off" placeholder="Usu&aacute;rio">
                <input type="hidden" id="novo-usuario" name="NOVOUSUARIO" value="">
                </div>
                
                <div class="form-group">
                  <input type="password" name="SENHA" id="senha" autocomplete="off" placeholder="Senha">
                </div>
                

                <input type="hidden" id="tr_loja">
                <input type="hidden" id="td_combo">
             
              <b style="color: red;">
                    <?php
                    $erro = (int) $_GET["erro"];
                    if ($erro === 1) {
                        echo "Usu&aacute;rio ou senha inv&aacute;lidos!";
                    }
                    ?>
                </b>
                <div class="form-group">
                <input type="submit" id="botao" class="btn btn-primary" value="Entrar">     
                </div>

              </form>
              </div>
              <div class="card-footer text-muted">
                    <span><p id="direitos"><a href="http://www.arius.com.br" id="arius">Arius Sistemas</a> - Todos os direitos reservados&copy;</p></span>
                    <div class="d-flex justify-content-end social_icon">
                    <span><a target="_blank" href="https://www.facebook.com/ariussistemas/" id="social"><i class="fab fa-facebook-square"></i></a></span>
                    <span><a target="_blank" href="https://www.linkedin.com/company/arius-sistemas/" id="social"><i class="fab fa-linkedin"></i></a></span>
                    <span><a target="_blank" href="https://www.youtube.com/channel/UCg3VsGK0dHBfPz8eRvPjQDA" id="social"><i class="fab fa-youtube-square"></i></a></span>
                  </div>
              </div>
            </div>     
  

    <div id="inset_form"></div>
    <div id="form_newPass"></div>
</div>
</center>   


    <iframe id="chat" style="WIDTH: 200px; HEIGHT: 31px; position:absolute; bottom:0px; right:10px;"
      src="http://creautomacao.mysuite.com.br/empresas/cra/verificaID.php"
        frameborder=0 scrolling=no>
</iframe>
   

   </div>
   </div>
   
  
  </body>
</html>