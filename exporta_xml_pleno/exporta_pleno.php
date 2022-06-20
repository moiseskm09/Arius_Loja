<?php
 include_once 'config_bd.php';
 
 $nloja = $_POST['loja'];
$arquivocompact = 'xmlPleno-lj'.$nloja.'.zip'; // Nome do Arquivo
$local = '/usr/share/pleno/php/public/emk/XML'; // Pasta que contém os arquivos para download
$local_arquivo = $local."/".$arquivocompact; // Concatena o diretório com o nome do arquivo
$local_xml = '/servpleno/nfe/';


if (isset($_POST['loja'], $_POST['data_inicial'], $_POST['data_final'])) {
$loja = $_POST['loja'];
$data_inicial = $_POST['data_inicial'];
$data_final = $_POST['data_final'];

$consulta_loja = mysqli_query($conexao, "SELECT
    cfg06_numero,
    pes03_estabelecimento_id,
    pes03_cnpj
FROM
    cfg06_filial
INNER JOIN
    pes03_estabelecimento
ON
    cfg06_id = pes03_id
    
    WHERE cfg06_numero = '$loja'");

$result = mysqli_fetch_assoc($consulta_loja);
$id_loja= $result['pes03_estabelecimento_id'];

if ($result['pes03_estabelecimento_id'] > 0){
    
    $consultaChaveXml = mysqli_query($conexao, "SELECT
    fis01_nfe_chave
FROM
    fis01_notafiscal
WHERE
    pes04_pessoa_emit = '$id_loja' AND 
    fis01_data_emissao BETWEEN '$data_inicial' AND '$data_final' AND 
    fis01_nfe_chave IS NOT NULL");
    
   if (mysqli_num_rows($consultaChaveXml) > 0 ) {
       while ($chave_numero = mysqli_fetch_assoc($consultaChaveXml)) {
           $arquivo = $chave_numero['fis01_nfe_chave']."*.xml";
          system("cd $local_xml; cp $arquivo $local;");
          
       }
        //echo "seu id e :". $result['pes03_estabelecimento_id'];
       $compacta = "cd $local; zip $arquivocompact * > /dev/null ;";
       system($compacta);
       
    if (stripos($arquivocompact, './') !== false || stripos($arquivocompact, '../') !== false || !file_exists($local_arquivo)) {
    header("location: xml.php?erro=1");
} else {
    
    
    header("Content-type: $local_arquivo");
    header("Content-Disposition: attachment; filename=$arquivocompact");
    
    
    // Envia o arquivo Download
    readfile($local_arquivo);
    
    $limpa = "cd $local ; rm *;";
    system($limpa);
}
} else {
    
}
   }
   
    
}else {
    echo "por favor, contate o suporte.";
}





//echo $result['cfg06_numero'].','.$result['pes03_cnpj'].','.$result['pes03_estabelecimento_id'];
//echo '<br>';
//$cnpj_curto = substr($result['pes03_cnpj'], 0, -6);  // retorna "abcde"
//$local_xml = '/servpleno/nfe/'.$cnpj_curto;
//echo $local_xml;


