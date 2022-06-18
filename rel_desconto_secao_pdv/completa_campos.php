<?php include_once("config_db.php");

$nroLoja = $_REQUEST['nroLoja'];

$infoLoja = "SELECT * FROM cfg_loja WHERE nroloja = $nroLoja";
$buscaInfoLoja = mysqli_query($conexao, $infoLoja);
$resultadoInfoLOja = mysqli_fetch_assoc($buscaInfoLoja);

$hostLoja=$resultadoInfoLOja["iploja"];
$userLoja=$resultadoInfoLOja["user"];
$passLoja=$resultadoInfoLOja["senha"];
$dbnameLoja="controle";
$conexaoLoja = mysqli_connect ($hostLoja, $userLoja, $passLoja);
if(mysqli_connect_error()){
    echo "Erro de conexão com o banco de dados. Contate o Administrador";
}else{
    mysqli_set_charset($conexaoLoja, "utf8");
    mysqli_select_db($conexaoLoja, $dbnameLoja);
}


$result_nroPdv = "SELECT * FROM pf_pdv WHERE nroloja=$nroLoja";
$resultado_nroPdv = mysqli_query($conexaoLoja, $result_nroPdv);

while ($row_nroPdv = mysqli_fetch_assoc($resultado_nroPdv) ) {
    $pdvs_post[] = array(
        'codigo'	=> $row_nroPdv['codigo'],
        'codigoPdv' => utf8_encode($row_nroPdv['codigo']),
    );
}

echo(json_encode($pdvs_post));