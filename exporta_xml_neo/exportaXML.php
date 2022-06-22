<?php
include_once 'config_bd.php';
$arquivo = 'xmls-NEO.zip'; // Nome do Arquivo
$local = '/arius/integracao/exportacao/xml'; // Pasta que contém os arquivos para download
$local_arquivo = $local . "/" . $arquivo; // Concatena o diretório com o nome do arquivo

if (isset($_POST['loja'], $_POST['data_inicial'], $_POST['data_final'])) {
    $loja = $_POST['loja'];
    $data_inicial = $_POST['data_inicial'];
    $data_final = $_POST['data_final'];
    $dataConsulta = $data_inicial;
    $dataConsulta = $data_inicial;
    do {
        //echo $dataConsulta."<br>";
        $dataFormatada = date("dmY", strtotime($dataConsulta));
        $local_xml = '/arius/arquivos/saida/xml/' . $dataFormatada . '/' . $loja . '/';
        //echo $local_xml."<br>";
        $entra = "cp " . $local_xml . "*.xml " . "$local;";
        // echo $entra;
        system($entra);
        $dataConsulta = date('Y-m-d', strtotime("+1 days", strtotime($dataConsulta)));
    } while ($dataConsulta <= $data_final);
    $compacta = "cd $local; zip $arquivo * > /dev/null ;";
    system($compacta);
    //echo $local_arquivo;
    if (file_exists($local_arquivo)) {
        header("Content-type: $local_arquivio");
        header("Content-Disposition: attachment; filename=$arquivo");
        readfile("$local_arquivo");

        // Envia o arquivo para Download
        readfile($local_arquivo);

        $limpa = "cd $local ; rm * ;";
        system($limpa);
    } else {
        header("location: xml.php?erro=2");
    }
} else {
    header("location: xml.php?erro=1");
}