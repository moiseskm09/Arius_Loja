<?php

if(isset($_GET) && $_GET['dataproc_i'] && $_GET['dataproc_f']){
    $interval = new DateInterval('P1D');
    $begin = new DateTime( formata_data($_GET['dataproc_i']) );
    $end = new DateTime( formata_data($_GET['dataproc_f']) );


    $con = new bd;
    $con->connect();
    $sql = "SELECT cgc,dirExp,nroloja FROM controle.pf_loja LIMIT 1";
    $con->query( $sql );
    if( $con->num_rows )
    {
        $row = $con->fetch_array();
        $cnpj = $row['cgc'];
        $file = $row['dirExp']."tefconsRHLJ".$row['nroloja'].date('dmY', strtotime('-1 days')).".txt";
    }
    $fd_cons = @fopen( $file, "wb");

    /* ---- GRAVA HEADER DO ARQUIVO CONCILIACAO ---- */
    $cnpj_loja = str_pad($cnpj, 14, 0, STR_PAD_LEFT);
    $lncons = "00;VENDAS ESTABELECIMENTO".";".$cnpj_loja.";".str_replace("-","",$begin->format("Y-m-d") ).";".str_replace("-","",$end->format("Y-m-d")).";KW                  \r\n";
    fputs( $fd_cons, $lncons );
    /* --------------------------------------------- */
    $daterange = new DatePeriod($begin,  $interval , ($end->add($interval)) );
    foreach($daterange as $date){
        exportaTefs($date->format("Y-m-d"), $fd_cons, $cnpj_loja);
    }
    /* ---- TRAILER DO ARQUIVO DE CONCILIACAO ---- */
    $lncons = "99;FINAL DO ARQUIVO;\r\n";
    fputs( $fd_cons, $lncons );
    fclose( $fd_cons );

}else{
    echo 'Selecione o período';
}

function exportaTefs( $data, $fd_cons, $cnpj, $header_cnpf = false ){
    $con = new bd;
    $con->connect();

    $descricao = "TEF´s";

    // busca valores fpagtos
    $sql = "
			SELECT
				pdv,
				nrocupom,
				DATE_FORMAT(dataproc, '%d%m%Y') AS dataproc,
				nsuhost,
				nsutrans,
				codrede,
				codbandeira,
				valor,
				nrocartao,
				servico,
				parcelas,
				saque,
				DATE_FORMAT(datadeposito, '%d%m%Y') AS datadep,
                nsutransorig,
                seqfpagtos,
                codestabelecimento,
                rede,
                bandeira
			FROM ".
        BD_RETAG.".regtef
			WHERE
				dataproc = '".$data."' 
				AND	confirmada = 1 
				AND codrede <> 203
				AND codrede <> 42"
    ;
//		echo $sql."<br><br>";
    $con->query( $sql );
    if( $con->num_rows ) {
        $linha = '';

        while( $row = $con->fetch_array() ){
            $cod_bandeira = busca_bandeira( $row["nrocartao"], $row["servico"] );
            $cod_bandeira = $cod_bandeira[0];

            /* ---- MONTA REGISTRO DO ARQUIVO DE CONCILIACAO ---- */
            $lncons =   "10";                                                                       //Id do Registro
            $lncons .=  ";".$cnpj;                                                                 //cnpj do estab.comercial
            $lncons .=  ";".str_replace("-","",formata_data($data, false,"aaaammdd"));                  //Data do movimento
            $lncons .=  ";".str_pad( $row["codrede"], 3, "0",STR_PAD_LEFT );                            //Administradora
            $lncons .=  ";".str_pad( $row["codestabelecimento"], 20, "0", STR_PAD_LEFT);                //Cod. Estabelecimento
            if( intval($row["servico"]) < 5)
            {
                $prod = "DEB";
                $modalidade = "001";
            }
            else if( intval($row["servico"]) < 8)
            {
                $prod = "CRE";
                $modalidade = intval($row["servico"]) == 5 ? "001" : "002";
            }
            else
                continue;    //Nao grava cancelamentos de tef
            $lncons .=  ";".$prod;                                                                          //Produto
            $lncons .=  ";".str_pad( $row["codbandeira"], 5, "0", STR_PAD_LEFT );                            //Bandeira
            $lncons .=  ";".$modalidade;                                                                    //Modalidade
            $lncons .=  ";".str_pad( $row["nsuhost"], 10, "0", STR_PAD_LEFT );                              //NSU Host
            $lncons .=  ";".str_pad( $row["nsutransorig"], 10, "0", STR_PAD_LEFT );                         //Cod.Autorizacao
            $lncons .=  ";".str_pad( substitui( ".", "-", "", $row["valor"] ), 12, "0", STR_PAD_LEFT);      //Valor transacao
            $lncons .=  ";".str_repeat(" ", 20);                                                            //Nro POS maquineta
            $lncons .=  ";".str_pad($row["parcelas"], 3, "0", STR_PAD_LEFT);                                //Nro de parcelas
            $lncons .=  ";".str_pad(substr(substitui(" ","", $row["nrocartao"]),0,6),6,"0",STR_PAD_LEFT);    //Nro Cartao
            $lncons .=  ";".str_pad( $row["nrocupom"], 10, "0", STR_PAD_LEFT );
            $lncons .=  ";".str_pad( $_SESSION["LOJA"]["NROLOJA"], 3, "0", STR_PAD_LEFT);
            $lncons .=  ";".str_pad( $row["nsutrans"], 10, "0", STR_PAD_LEFT );                             //Nsu Trans
            $lncons .=  ";"."\r\n";
            fputs( $fd_cons, $lncons );
            /* -------------------------------------------------- */
        }
        /* ------------------------------------------- */
        echo "&nbsp;".$descricao." - Data: ".formata_data($data,false,'d/m/Y')." ok.<br />";
    }
    // Enviando arquivos TEF Offline
    $sql = "SELECT 
                r.pdv,
                r.nrocupom,
                DATE_FORMAT(r.dataproc, '%d%m%y') AS dataproc, 
                r.nsuhost, 
                r.codbandeira,
                r.parcelas,
                IFNULL(r.nrocartao, '') as nrocartao,
                p.valor 
                FROM retag.regtefoff r
                INNER JOIN retag.fpagtoCupom p ON p.nroloja=r.nroloja AND p.dataproc = r.dataproc AND p.pdv = r.pdv AND p.nrocupom = r.nrocupom AND p.Sequencia = r.seqfpagto 
                LEFT JOIN retag.cupom c ON c.nroloja = r.nroloja AND c.dataproc = r.dataproc AND c.pdv = r.pdv AND c.nrocupom = r.nrocupom 
                WHERE
                c.FlagFimCupom = 1 AND
                r.dataproc = '".$data."'";
    $con->query( $sql );
    if( $con->num_rows ) {
        $linha = '';
        while( $row = $con->fetch_array() )
        {
            /* ---- MONTA REGISTRO DO ARQUIVO DE CONCILIACAO ---- */
            $lncons =   "10";                                                                       //Id do Registro
            $lncons .=  ";".$cnpj;                                                                 //cnpj do estab.comercial
            /*$lncons .=  ";".$row["dataproc"];                                                       //Data do movimento---*/
            $lncons .=  ";".str_replace("-","",formata_data($data, false,"aaaammdd"));                  //Data do movimento
            $lncons .=  ";"; //.str_pad( $row["codrede"], 3, "0",STR_PAD_LEFT );                            //Administradora
            $lncons .=  ";"; //.str_pad( $row["codestabelecimento"], 20, "0", STR_PAD_LEFT);                //Cod. Estabelecimento
            if( intval($row["servico"]) < 5)
            {
                $prod = "DEB";
                $modalidade = "001";
            }
            else if( intval($row["servico"]) < 8 )
            {
                $prod = "CRE";
                $modalidade = intval($row["servico"]) == 5 ? "001" : "002";
            }
            else
                continue;    //Nao grava cancelamentos de tef
            $lncons .=  ";";//.$prod;                                                                          //Produto
            $lncons .=  ";";//.str_pad( $row["codbandeira"], 5, "0", STR_PAD_LEFT );                            //Bandeira
            $lncons .=  ";";//.$modalidade;                                                                    //Modalidade
            $lncons .=  ";".str_pad( $row["nsuhost"], 10, "0", STR_PAD_LEFT );                              //NSU Host
            $lncons .=  ";";//.str_pad( $row["nsutransorig"], 10, "0", STR_PAD_LEFT );                         //Cod.Autorizacao
            $lncons .=  ";".str_pad( substitui( ".", "-", "", $row["valor"] ), 12, "0", STR_PAD_LEFT);      //Valor transacao
            $lncons .=  ";".str_repeat(" ", 20);                                                            //Nro POS maquineta
            $lncons .=  ";".str_pad($row["parcelas"], 3, "0", STR_PAD_LEFT);                                //Nro de parcelas
            $lncons .=  ";".str_pad(substr(substitui(" ","", $row["nrocartao"]),0,6),6,"0",STR_PAD_LEFT);    //Nro Cartao
            $lncons .=  ";".str_pad( $row["nrocupom"], 10, "0", STR_PAD_LEFT );
            $lncons .=  ";".str_pad( $_SESSION["LOJA"]["NROLOJA"], 3, "0", STR_PAD_LEFT);
            $lncons .=  ";".str_pad( $row["nsutrans"], 10, "0", STR_PAD_LEFT );                             //Nsu Trans
            $lncons .=  ";"."\r\n";
            fputs( $fd_cons, $lncons );
        }
    }
}

// fim exportaTefs
