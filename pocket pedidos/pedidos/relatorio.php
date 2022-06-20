<?php

   require_once "../../../../sistema/config.inc.php";
   require_once INC_DIR."/autenticacao.class.php";
   require_once INC_DIR."/class.TemplatePower.inc.php";
   require_once INC_DIR.'/libs.php';
   require_once INC_DIR.'/bd.class.php';
//     require_once INC_DIR.'/html2fpdf/html2fpdf.php';

   $aut = new autenticacao;

   if( $aut->autenticar( 1 ) ){
       $con = new bd;
       $con->connect();

       $con2 = new bd;
       $con2->connect();

       $tpl = new TemplatePower( "relatorio.htm" );
       $tpl->prepare();

       //AJAX.
       if( $_POST["AJAX"] ){
           ob_start();
           if( $_POST["pedido"] ){
               $tpl->newBlock( "blk_pedidos_itens" );
               $tpl->assign( "pedido", $_POST["pedido"] );
               $sql = "
                    select
                        i.codigoean,
                        if(i.valor=0, m.valor, i.valor) as valor,
                                                i.desconto,
                        i.quantidade,
                        ifnull( m.descricao, '.') as descricao,
						i.cancelado
                    from
                        ".BD_RETAG.".pocket_pedidos_itens i
                    left join
                        ".BD_RETAG.".mercador m
                    on
                        i.nroloja = m.nroloja and
                        i.codigoean = m.codigoean
                    where
                         i.nroloja='".$_SESSION["LOJA"]["NROLOJA"].
                  "' and numero_pedido='".$_POST["pedido"]."'
                ";
               $con->query( $sql );
               if( $con->num_rows ){
                   $dig_bal = buscaDigitoBalanca();
                   while( $row = $con->fetch_array() ){
                       if( substr( $row["codigoean"], 0, 1 ) == '2' && strlen( $row["codigoean"] ) == 13 ){//merc pesada
                           $codean = substr( $row["codigoean"], 0, ($dig_bal + 1 ) ).str_repeat( "0", (12 - $dig_bal ) );
                       }else{
                           $codean = $row["codigoean"];
                       }
                       $sql = "select ifnull( descricao, '.') as descricao from ".BD_RETAG.".mercador
                                where nroloja =".$_SESSION["LOJA"]["NROLOJA"]." and codigoean = ".$codean.";";
                       $con2->query( $sql );
                       if( $con2->num_rows ){
                           $row2 = $con2->fetch_array();
                       }
                       
                       
                       $tpl->newBlock( "blk_linhas_itens" );
                       $tpl->assign( "ean", $row["codigoean"] );
                       $tpl->assign( "descricao", $row2["descricao"] );
                       $tpl->assign( "valorOriginal", number_format( $row["valor"], 2, ",", "" ) );
                       
//                       $valorFinal = $row["valor"] - $row["desconto"];
                       $tpl->assign( "desconto", number_format( $row["desconto"], 2, ",", "" ) );
                       $tpl->assign( "quantidade", $row["quantidade"] );
                       $tpl->assign( "total_iten", number_format( ( $row["valor"] * $row["quantidade"] ), 2, ",", "" ) );
					   
					   //situação do item
					   if($row["cancelado"] == 1){
					   $tpl->assign( "situacao", "cancelado");
					   $tpl->assign( "risca", 'class="risca"');
					   }else{
						   $tpl->assign( "situacao", "normal");
					   }
					   
                   }
               }
//                 $tpl->gotoBlock( "_ROOT" );
           }
           $tpl->printToScreen();
           $html = ob_get_contents();
           ob_end_clean();
           echo $html;
           exit();
       }
       $tpl->newBlock( "blk_geral" );
       $tpl->assign( "inc_path", INC_PATH );
       $tpl->assign( "TEMA", $_SESSION["USUARIO"]["TEMA"] );
       $tpl->assign( "IMAGE_PATH", IMAGE_PATH );

       if( !$_GET["print"] ){
           $tpl->newBlock( "blk_dadosrelatorio" );
       }else{
           $tpl->assignGlobal( "print", "onload='javascript: window.print();window.close();'" );
       }

       $tpl->assign( "dataproc_i", $_GET["dataproc_i"] ? $_GET["dataproc_i"] : date( "d/m/Y" ) );
       $tpl->assign( "dataproc_f", $_GET["dataproc_f"] ? $_GET["dataproc_f"] : date( "d/m/Y" ) );

       

       $tpl->assign("status", combo( "status", enum( BD_RETAG.".pocket_pedidos", "status" ), $_GET["status"], false, false, "---Todos---" ) );
       
       $sqlComanda = "SELECT codigo, descricao FROM ".BD_RETAG.".pocket_comandas WHERE nroloja = '".$_SESSION["LOJA"]["NROLOJA"]."'";
       $tpl->assign("comanda", combo( "comanda", $sqlComanda, $_GET["comanda"], false, false, "---Todos---" ) );
       
       $sqlc = "select distinct u.codigo, u.nome from ".BD_CONTROLE.".usuarios u inner join ".BD_RETAG.".pocket_pedidos   p on u.codigo = p.codigo_usuario";
       $tpl->assign( "vendedor", combo( "vendedor", $sqlc, $_GET["vendedor"], false, false, "---Todos---" ) );

       if( $_GET ){
           //QUERY.
           if( $_GET["vendedor"] != '#' ){
               $vendedor = $_GET["vendedor"];
           }
          $sql = "
                SELECT
                    u.nome,
                    p.nomeCliente,
                    p.placaCarro,
                    p.cpfCliente,
                    p.numero_pedido,
                    p.codigo_usuario,
                    p.codigo_mesa,
                    p.status,
                    p.codigo_comanda as comanda,
                    date(p.dataproc) as dataproc,
					i.cancelado,
                    sum( ( IF(i.valor=0,m.valor,i.valor) * i.quantidade ) ) as total_pedido,
                                        sum(i.desconto) as total_desconto
                FROM
                    ".BD_RETAG.".pocket_pedidos p
                LEFT JOIN
                    ".BD_RETAG.".pocket_pedidos_itens i
                ON
                    p.nroloja = i.nroloja and
                    p.numero_pedido = i.numero_pedido
                LEFT JOIN
                   ".BD_RETAG.".mercador m
                ON
                    p.nroloja = m.nroloja and
                    m.codigoean = i.codigoean
                LEFT JOIN
                    ".BD_CONTROLE.".usuarios u
                ON
                    p.nroloja = u.nroloja and
                    p.codigo_usuario = u.codigo
                WHERE
                    p.nroloja='".$_SESSION["LOJA"]["NROLOJA"]."' and
                    date(p.dataproc) between '".formata_data( $_GET["dataproc_i"] )."' and '".formata_data( $_GET["dataproc_f"] )."'
                    ".( $_GET["status"]  ? " and p.status = '".$_GET["status"]."'" : "" )."
                    /* comentado para homologacao".( $_GET["status"]  ? " and p.status = '".$_GET["status"]."'" : "and p.status != 'cancelado' " )."*/
                    ".( $_GET["vendedor"] ? " and p.codigo_usuario = '".$_GET["vendedor"]."'" : "" )."
                    ".( $_GET["cpf"]  ? " and p.cpfCliente = '".$_GET["cpf"]."'" : "" )."
                    ".( $_GET["placa"]  ? " and p.placaCarro = '".$_GET["placa"]."'" : "" )."
                    ".( $_GET["comanda"] ? " and p.codigo_comanda = '".$_GET["comanda"]."'" : "" )."
                GROUP BY
                    p.codigo_comanda,
                    p.numero_pedido
                ORDER BY
                    p.dataproc,
                    p.numero_pedido
            ";
//             echo $sql;
           //QUERY FIM.

           $con->query( $sql );

           if( $con->num_rows ){
               $cont = 0;

               if( $_GET["print"] ){
                   ob_start();
                   $tpl->newBlock( "blk_cabecalho_pdf" );
                   $tpl->assign( "dataproc_i", $_GET['dataproc_i'] ? $_GET['dataproc_i'] : date( 'd/m/Y' )  );
                   $tpl->assign( "dataproc_f", $_GET['dataproc_f'] ? $_GET['dataproc_f'] : date( 'd/m/Y' ) );
                   $tpl->assign( "data_atual", date( 'd/m/Y' ) );
                   $tpl->assign( "loja", str_pad( $_SESSION["LOJA"]["NRO"], 3, 0, STR_PAD_LEFT ) );
                   $tpl->assign( "razao", $_SESSION["LOJA"]["RAZAO"] );
                   $tpl->assign( "cnpj", $_SESSION["LOJA"]["CGC"] );
                   $tpl->gotoBlock( "_ROOT" );
               }

               $tpl->newBlock( "blk_relatorio" );
               $tpl->assign( "border", $_GET["print"] ? 1 : 0  );

               $arr = $con->fetch_all();
               $comanda_ant = '';
               foreach( $arr as $ch=>$row ){
                   $tpl->newBlock( "blk_linhas" );
                    $tpl->newBlock( "blk_cabecalho" );
                   //cabecalho data.
                   if( $dataproc_ant != $row["dataproc"] ){
                       $dataproc_ant = $row["dataproc"];
                     
                       $tpl->assign( "dataproc", formata_data( $row["dataproc"] ) );
                      
                       $cabecalho = true;
                   }

                   //cabecalho comanda.
//                   if( $comanda_ant != $row["comanda"] ){

                       $comanda_ant = $row["comanda"];
                       $tpl->newBlock( "blk_cabecalho2" );
                       $tpl->assign( "comanda", $row["comanda"] );
                       if( $row["nomeCliente"] != "" ){
                           $tpl->assign( "nomeCliente", " Nome Cliente: ".$row["nomeCliente"] );
                       }
                       if( $row["cpfCliente"] != "" ){
                           $tpl->assign( "cpfCliente", " Cpf Cliente: ".$row["cpfCliente"] );
                       }
                       if( $row["placaCarro"] != "" ){
                           $tpl->assign( "placa", " Placa Carro : ".$row["placaCarro"] );
                       }
                       $tpl->gotoBlock( "blk_linhas" );
                       $cabecalho2 = true;
//                   }

                   $tpl->assign( "cor_linha", "even" );
                   if( $cont % 2 == 0 ){
                       $tpl->assign( "cor_linha", "odd" );
                   }
                   $cont++;
                   //linhas data..
                   $tpl->assign( "comanda", $row["comanda"] );
                   if( $row["nomeCliente"] != "" ){
                       $tpl->assign( "nomeCliente", $row["nomeCliente"] );
                   }
                   if( $row["cpfCliente"] != "" ){
                       $tpl->assign( "cpfCliente", $row["cpfCliente"] );
                   }
                   if( $row["placaCarro"] != "" ){
                       $tpl->assign( "placa", $row["placaCarro"] );
                   }
                   
                   $total_final = $row["total_pedido"] - $row["total_desconto"];
                   $tpl->assign( "pedido", $row["numero_pedido"] );
                   $tpl->assign( "usuario", $row["nome"] );
                   $tpl->assign( "status", $row["status"] );
                   $tpl->assign( "total_pedido", number_format( $row["total_pedido"], 2, ",", "" ) );
                   $tpl->assign( "total_desconto", number_format( $row["total_desconto"], 2, ",", "" ) );
                   $tpl->assign( "total_pedido_final", number_format( $total_final, 2, ",", "" ) );
                   
                   $total_comanda += $total_final;
                   $total_data += $total_final;
                   $total_periodo += $total_final;

                   //total comanda.
                   if( ( $cabecalho2 === true ) && ( $arr[$ch + 1]["comanda"] != $row["comanda"] ) ){
                       $tpl->newBlock( "blk_total_comanda" );
                       $tpl->assign( "total_comanda", number_format( $total_comanda, 2, ",", "." ) );
                       $tpl->gotoBlock( "blk_linhas" );
                       unset( $total_comanda );
                   }

                   //total data.
                   if( ( $cabecalho === true ) && ( $arr[$ch + 1]["dataproc"] != $row["dataproc"] ) ){
                       $tpl->newBlock( "blk_total_data" );
                       $tpl->assign( "total_data", number_format( $total_data, 2, ",", "." ) );
                       $tpl->gotoBlock( "blk_linhas" );
                       unset( $total_data );
                   }
               }
               $tpl->newBlock( "blk_total_periodo" );
               $tpl->assign( "total_periodo", number_format( $total_periodo, 2, ",", "." ) );
               $tpl->gotoBlock( "_ROOT" );
               unset( $total_periodo );
           }
       }
       $tpl->printToScreen();
       if( $_GET["print"] ){
           $html = ob_get_contents();
           ob_end_clean();
           echo $html;
       }
   }
?>
