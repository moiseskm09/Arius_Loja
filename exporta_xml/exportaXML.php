<?php

$host = "localhost";
$user = "root";
$pass = "123456";
$banco = "controle";

$conexao = mysqli_connect($host, $user, $pass) or die(mysqli_error("falha na conexao"));
mysqli_select_db($conexao, $banco) or die(mysqli_error("banco de dados nao encontrado"));

$arquivo = 'XMLS.zip'; // Nome do Arquivo
$local = '/servidor/exportacao/XML'; // Pasta que contém os arquivos para download
$local_arquivio = $local."/".$arquivo; // Concatena o diretório com o nome do arquivo


if (isset($_POST['loja'], $_POST['data_inicial'], $_POST['data_final'])) {
$loja = $_POST['loja'];
$data_inicial = $_POST['data_inicial'];
$data_final = $_POST['data_final'];

$consulta = mysqli_query($conexao, "SELECT * FROM pf_loja WHERE nroloja = '$loja'");
$result = mysqli_fetch_assoc($consulta);
$cgc = $result['cgc'];

$local_xml = '/servidor/NFCEPROC/'.$cgc."/";

//Star date
$dateStart = $data_inicial;
$dateStart = implode('-', array_reverse(explode('/', substr($dateStart, 0, 10)))) . substr($dateStart, 10);
$dateStart = new DateTime($dateStart);

//End date
$dateEnd = $data_final;
$dateEnd = implode('-', array_reverse(explode('/', substr($dateEnd, 0, 10)))) . substr($dateEnd, 10);
$dateEnd = new DateTime($dateEnd);

//Prints days according to the interval
$dateRange = array();
while ($dateStart <= $dateEnd) {
    $dateRange[] = $dateStart->format('Y-m-d');
    $dateStart = $dateStart->modify('+1day');
}

foreach ($dateRange as $intervalo) {
    //$comando = "cp ".$local_xml.$intervalo."/* ".$local." <br>";
    $entra = "cd $local_xml$intervalo; cp *.xml $local;";
    system($entra);
}

if (isset($intervalo)) {
    $compacta = "cd $local; zip $arquivo * > /dev/null ;";
    system($compacta);
}

if (stripos($arquivo, './') !== false || stripos($arquivo, '../') !== false || !file_exists($local_arquivio)) {
    header("location: xml.php?erro=1");
} else {

    header("Content-type: $local_arquivio");
    header("Content-Disposition: attachment; filename=$arquivo");
    readfile("$local_arquivio");

    // Envia o arquivo Download
    readfile($local_arquivio);
    
    $limpa = "cd $local ; rm * ;";
    system($limpa);
}
} else {
    
}