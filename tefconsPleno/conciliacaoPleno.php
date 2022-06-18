<?php
$host="172.16.0.90";
$user="plenoh";
$pass="plenoh";
$dbname="plenoh";
$conexao = mysqli_connect ($host, $user, $pass);
if(mysqli_connect_error()){
    echo "Erro de conexão com o banco de dados. Contate o Administrador";
}else{
    mysqli_set_charset($conexao, "utf8");
    mysqli_select_db($conexao, $dbname);
}
$sql = "SELECT cfg06_numero as nrofilial, pes03_estabelecimento_id AS pesid FROM cfg06_filial";
$infoLoja = mysqli_query($conexao, $sql);
//$hoje = date ("Y-m-d");
$ontem  = date('Y-m-d', strtotime('-41 days'));
//echo $ontem."<br>";
If(mysqli_num_rows($infoLoja) > 0) {
    while ($resultado = mysqli_fetch_assoc($infoLoja)) {
        $pesId = $resultado["pesid"];
        $sqltefCons = "SELECT cfg06_numero AS filial, pes03_estabelecimento_id, pes03_cnpj AS cnpj, fcx07_pdv AS pdv, fcx01_numero AS cupom, DATE_FORMAT(fcx07_data, '%d/%m/%Y') AS dataproc, fcx04_nsuhost AS nsuhost, fcx04_nsutrans AS nsutrans, fcx04_codrede AS codrede, fcx04_codbandeira AS codbandeira, fcx04_valor AS valor, fcx04_nrocartao AS nrocartao, fcx04_servico AS servico, fcx04_nroparcelas AS nroparcelas, fcx04_vlrsaque AS saque, DATE_FORMAT(fcx04_datadeposito, '%d%m%Y') AS datadep, fcx04_nsutransorig AS nsuorigem, fcx03_sequencia AS seqfpagto, fcx04_codestabelecimento AS codestabelecimento, IF(fcx04_servico < 4, 'DEB', 'CRE') AS operacaotef, IF(fcx04_servico < 4, '001', '002') AS modalidade, fcx04_rede AS rede, fcx04_bandeira AS bandeira FROM fcx04_regtef regtef INNER JOIN fcx07_abertura abertura ON regtef.fcx07_abertura_id = abertura.fcx07_id INNER JOIN cfg06_filial filial ON abertura.cfg06_filial_id = filial.cfg06_id INNER JOIN fcx03_cupom_mpagto mcupom ON regtef.fcx03_cupom_mpagto_id = mcupom.fcx03_id INNER JOIN fcx01_cupom cupom ON mcupom.fcx01_cupom_id = cupom.fcx01_id INNER JOIN pes03_estabelecimento estabelecimento ON filial.pes03_estabelecimento_id = estabelecimento.pes03_id WHERE abertura.fcx07_data = '$ontem' AND fcx04_flgconfirmada = 1 AND regtef.fcx04_codrede <> 203 AND regtef.fcx04_codrede <> 42 AND pes03_estabelecimento_id = $pesId UNION SELECT cfg06_numero AS filial, pes03_estabelecimento_id, pes03_cnpj AS cnpj, fcx07_pdv AS pdv, fcx01_numero AS cupom, DATE_FORMAT(fcx07_data, '%d/%m/%Y') AS dataproc, fcx05_nsuhost AS nsuhost, 0 AS nsutrans, 0 AS codrede, fcx05_codbandeira AS codbandeira, fcx03_valor AS valor, 0 AS nrocartao, 0 AS servico, fcx05_parcelas AS nroparcelas, 0 AS saque, 0 AS datadep, 0 AS nsuorigem, fcx03_sequencia AS seqfpagto, 0 AS codestabelecimento, IF( cfg09_descricao LIKE '%debito%', 'DEB', 'CRE') AS operacaotef, IF( cfg09_descricao LIKE '%debito%', '001', '002' ) AS modalidade, 0 AS rede, 0 AS bandeira FROM fcx05_regtefoff regtefoff INNER JOIN fcx07_abertura abertura ON regtefoff.fcx07_abertura_id = abertura.fcx07_id INNER JOIN cfg06_filial filial ON abertura.cfg06_filial_id = filial.cfg06_id INNER JOIN fcx03_cupom_mpagto mcupom ON regtefoff.fcx03_cupom_mpagto_id = mcupom.fcx03_id INNER JOIN fcx01_cupom cupom ON mcupom.fcx01_cupom_id = cupom.fcx01_id INNER JOIN cfg09_mpagto cfgmpagto ON mcupom.cfg09_mpagto_id = cfgmpagto.cfg09_id INNER JOIN pes03_estabelecimento estabelecimento ON filial.pes03_estabelecimento_id = estabelecimento.pes03_id WHERE abertura.fcx07_data >= '$ontem' AND pes03_estabelecimento_id = $pesId";
        $buscatefCons = mysqli_query($conexao, $sqltefCons);
        if(mysqli_num_rows($buscatefCons) > 0){
            $resultadoCabecalho = mysqli_fetch_assoc($buscatefCons);
            //Nome do arquivo de saida
            if($resultadoCabecalho["filial"] >= 1000 && $resultadoCabecalho["filial"] <= 1999){
                $empresa = "RH"; // empresa Ri Happy
            }elseif($resultadoCabecalho["filial"] >= 9000 && $resultadoCabecalho["filial"] <= 9999){
                $empresa = "PB"; // empresa PB Kids
            }else{
                $empresa = "END"; // empresa não definida
            }
            $arquivo = "tefcons".$empresa."LJ".str_pad(substr($resultadoCabecalho["filial"], 1), 3, "0", STR_PAD_LEFT).date("Ymd", strtotime($ontem)).".txt";
            //Abre o arquivo txt para gravar os registros
            $arquivo = fopen($arquivo, "a+");
            //cabeçalho cupom
            $cCNPJ = $resultadoCabecalho["cnpj"];
            $cdata = date("Ymd", strtotime($resultadoCabecalho["dataproc"]));
            $conteudo = "00;VENDAS ESTABELECIMENTO;$cCNPJ;$cdata;$cdata;ARIUS";
            $conteudo .="\r\n";
            fwrite($arquivo, $conteudo);
            //fim cabeçalho cupom
            //inicia inserção dos registros de transação tef e tefoff
            while($resultadotefCons = mysqli_fetch_assoc($buscatefCons)){
                $conteudo = "10;";
                $conteudo .= $resultadotefCons["cnpj"].";";
                $conteudo .= $resultadotefCons["dataproc"].";";
                $conteudo .= str_pad($resultadotefCons["codrede"], 3, "0", STR_PAD_LEFT).";";
                $conteudo .= str_pad($resultadotefCons["codestabelecimento"], 20, "0", STR_PAD_LEFT).";";
                $conteudo .= $resultadotefCons["operacaotef"].";";
                $conteudo .= str_pad($resultadotefCons["codbandeira"], 5, "0", STR_PAD_LEFT).";";
                $conteudo .= $resultadotefCons["modalidade"].";";
                $conteudo .= str_pad($resultadotefCons["nsuhost"], 10, "0", STR_PAD_LEFT).";";
                $conteudo .= str_pad($resultadotefCons["nsuorigem"], 10, "0", STR_PAD_LEFT).";";
                $conteudo .= str_pad(str_replace(['.',','],'', $resultadotefCons["valor"]), 12, "0", STR_PAD_LEFT).";";
                $conteudo .= str_repeat(" ", 10).";";
                $conteudo .= str_pad($resultadotefCons["nroparcelas"], 3, "0", STR_PAD_LEFT).";";
                $conteudo .= str_pad($resultadotefCons["nrocartao"], 6, "0", STR_PAD_LEFT).";";
                $conteudo .= str_pad($resultadotefCons["cupom"], 10, "0", STR_PAD_LEFT).";";
                $conteudo .= str_pad(substr($resultadotefCons["filial"], 1), 3, "0", STR_PAD_LEFT).";";
                $conteudo .= str_pad($resultadotefCons["nsutrans"], 10, "0", STR_PAD_LEFT).";";
                $conteudo .="\r\n";
                fwrite($arquivo, $conteudo);
            }
            //finaliza a inserção dos registros de transação tef e tefoff
            // incia rodapé do arquivo
            $conteudo = "99;FINAL DO ARQUIVO;";
            fwrite($arquivo, $conteudo);
            // fim rodapé do arquivo
            fclose($arquivo);
        }else{
           // echo "não há dados para geração do arquivo<br>";
        }
    }
}else{
        echo "erro de conexão";
    }