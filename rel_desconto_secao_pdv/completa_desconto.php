<?php include_once("config_db.php");

$nroLoja = $_REQUEST['nroLoja'];

$infoLoja = "SELECT * FROM cfg_loja WHERE nroloja = $nroLoja";
$buscaInfoLoja = mysqli_query($conexao, $infoLoja);
$resultadoInfoLOja = mysqli_fetch_assoc($buscaInfoLoja);

$hostLoja = $resultadoInfoLOja["iploja"];
$userLoja = $resultadoInfoLOja["user"];
$passLoja = $resultadoInfoLOja["senha"];
$dbnameLoja = "controle";
$conexaoLoja = mysqli_connect($hostLoja, $userLoja, $passLoja);
if (mysqli_connect_error()) {
    echo "Erro de conexão com o banco de dados. Contate o Administrador";
} else {
    mysqli_set_charset($conexaoLoja, "utf8");
    mysqli_select_db($conexaoLoja, $dbnameLoja);
}

$result_tipoDesconto = "SELECT codigo, descricao FROM conf_descontos_tipo";
$resultado_tipoDesconto = mysqli_query($conexaoLoja, $result_tipoDesconto);

while ($row_tipoDesconto = mysqli_fetch_assoc($resultado_tipoDesconto)) {
    $tipoDesconto_post[] = array(
        'codigo' => $row_tipoDesconto['codigo'],
        'descricao' => utf8_encode($row_tipoDesconto['descricao']),
    );
}

echo(json_encode($tipoDesconto_post));
