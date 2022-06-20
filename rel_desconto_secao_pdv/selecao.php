<?php
date_default_timezone_set('America/Sao_Paulo');
require_once 'config_db.php';
?>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="includes/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="includes/site-examples.css">
    <!-- buttons -->
    <link rel="stylesheet" type="text/css" href="includes/buttons.dataTables.min.css">
    <script src="includes/jquery.dataTables.min.js"></script>
    <script src="includes/dataTables.buttons.min.js"></script>
    <script src="includes/buttons.flash.min.js"></script>
    <script src="includes/jszip.min.js"></script>
    <script src="includes/pdfmake.min.js"></script>
    <script src="includes/vfs_fonts.js"></script>
    <script src="includes/buttons.html5.min.js"></script>
    <script src="includes/buttons.print.min.js"></script>
    <style>
        .fonte {
            font-size: 11px;
            color: #1d4289;
        }

        input.form-control, select.form-control {
            height: 30px;
            padding: 0;
            padding-left: 10px;
            color: #1d4289;
        }

        .carregando {
            color: #ff0000;
            display: none;
        }

        .cabecalho {
            background-color: #1d4289;
            color: #f1be48;
        }

        .linha {
            background-color: #ffffff;
        }

        .linha:hover {
            background-color: #f1be4889;
        }

        .fonte_totais {
            font-size: 13px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <section class="filtro">
        <form method="post" action="" id="formDesconto">
            <div class="row">
                <div class="col-12">
                    <h6 class="font-weight-bold p-1"
                        style="color:#1d4289;background-color: #f1be48; border-radius:8px;">Relatório de descontos por
                        Seção e Pdv<h6>
                </div>

                <div class="col-md-2 col-12">
                    <div class="form-group">
                        <label class="fonte">Loja <span class="text-danger">*</span></label>
                        <select class="form-control" name="nroLoja" id="nroLoja">
                            <option value="999">Escolha a loja</option>
                            <?php
                            $sqlLoja = "SELECT * FROM cfg_loja ORDER BY nroloja";
                            $queryLoja = mysqli_query($conexao, $sqlLoja);
                            while ($resultadoLoja = mysqli_fetch_assoc($queryLoja)) {
                                if (isset($_POST["nroLoja"]) && $_POST["nroLoja"] == $resultadoLoja["nroloja"]) {
                                    ?>
                                    <option selected
                                            value="<?php echo $resultadoLoja["nroloja"]; ?>"><?php echo $resultadoLoja["nroloja"] . " - " . $resultadoLoja["nomeloja"]; ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?php echo $resultadoLoja["nroloja"]; ?>"><?php echo $resultadoLoja["nroloja"] . " - " . $resultadoLoja["nomeloja"]; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <label class="fonte">Data Inicial <span class="text-danger">*</span></label>
                        <input type="date" name="dataproc_i" class="form-control input" id="dataproc_i"
                               value="<?php
                               if (isset($_POST["dataproc_i"]) && $_POST["dataproc_i"] != date("Y-m-d")) {
                                   echo $_POST["dataproc_i"];
                               } else {
                                   echo date("Y-m-d");
                               }

                               ?>" required>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <label class="fonte">Data Final <span class="text-danger">*</span></label>
                        <input type="date" name="dataproc_f" class="form-control input" id="dataproc_f"
                               value="<?php
                               if (isset($_POST["dataproc_f"]) && $_POST["dataproc_f"] != date("Y-m-d")) {
                                   echo $_POST["dataproc_f"];
                               } else {
                                   echo date("Y-m-d");
                               }

                               ?>" required>
                    </div>
                </div>
                <div class="col-md-2 col-12">
                    <div class="form-group">
                        <label class="fonte">PDV <span class="text-danger">*</span></label>
                        <select class="form-control" name="nroPdv" id="nroPdv">
                            <option selected value="<?php
                            if (isset($_POST["nroPdv"]) && $_POST[nroPdv] != "999") {
                                echo $_POST["nroPdv"];
                            } else {
                                echo "999";
                            } ?>">
                                <?php
                                if (isset($_POST["nroPdv"]) && $_POST[nroPdv] != "999") {
                                    echo $_POST["nroPdv"];
                                } else {
                                    echo "- Todos -";
                                } ?>
                            </option>

                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label class="fonte">Tipos de Descontos <span class="text-danger">*</span></label>
                        <select class="form-control" name="tipoDesconto" id="tipoDesconto">
                            <option selected value="999">Todos</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success form-control"><i class="fas fa-eye"></i>
                            Visualizar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <section class="resultado">
        <?php
        if (isset($_POST["nroLoja"]) && isset($_POST["dataproc_i"]) && isset($_POST["dataproc_f"])) {
            $lojaConsultada = $_POST["nroLoja"];
            $dataConsultaInicial = $_POST["dataproc_i"];
            $dataConsultaFinal = $_POST["dataproc_f"];
            if ($_POST["nroPdv"] == 999) {
                $pdvConsultado = "";
            } else {
                $pdvConsultado = $_POST["nroPdv"];
            }
            if ($_POST["tipoDesconto"] == 999) {
                $descontoConsultado = "";
            } else {
                $descontoConsultado = $_POST["tipoDesconto"];
            }
            $infoLoja = "SELECT * FROM cfg_loja WHERE nroloja =" . $_POST["nroLoja"];
            $buscaInfoLoja = mysqli_query($conexao, $infoLoja);
            $resultadoInfoLoja = mysqli_fetch_assoc($buscaInfoLoja);
            $hostLoja = $resultadoInfoLoja["iploja"];
            $userLoja = $resultadoInfoLoja["user"];
            $passLoja = $resultadoInfoLoja["senha"];
            $dbnameLoja = "controle";
            $conexaoLoja = mysqli_connect($hostLoja, $userLoja, $passLoja);
            if (mysqli_connect_error()) {
                echo "<span class='text-danger'>Erro de conexão com o banco de dados. Por favor, tente novamente</span>";
            } else {
                mysqli_set_charset($conexaoLoja, "utf8");
                //mysqli_select_db($conexaoLoja, $dbnameLoja);
            }
            $SqlInfoDesconto = "SELECT
					i.pdv,
					i.nrocupom,
					i.item,
					i.valor,
					i.valororiginal,
					(i.valororiginal - i.valor) AS valordesconto,
					i.valorunitario as valorunitariooriginal,
					(i.valor/i.quantidade) as valorunitario,
					i.AcertoDesconto,
					i.dataproc as dataproc,
					i.operador as operador_cod,
					i.quantidade,
					ope.nome as operador_nome,
					s.descricao AS secao,
					d.descricao,
					m.descricao as descr_merc,
					c.codigocliente,
					(CASE WHEN oi.Supervisor IS NOT NULL THEN oi.Supervisor 
						 WHEN os.Supervisor IS NOT NULL THEN os.Supervisor
						 ELSE 0 END) as supervisor_cod, 
					(CASE WHEN si.nome IS NOT NULL THEN si.nome 
						 WHEN sc.nome IS NOT NULL THEN sc.nome 
						 ELSE oi.Supervisor END) as supervisor_nome 
				FROM retag.itens i
				LEFT JOIN retag.ocorrencias oi ON
					i.nroloja=oi.nroloja and
					i.dataproc=oi.dataproc and
					i.pdv=oi.pdv and
					i.nrocupom=oi.nrocupom and
					i.item=oi.item
				LEFT JOIN controle.usuarios si ON
					oi.nroloja = si.nroloja and
					oi.supervisor = si.codigo
				LEFT JOIN retag.ocorrencias os ON
					i.nroloja=os.nroloja and
					i.dataproc=os.dataproc and
					i.pdv=os.pdv and
					i.item=os.item and
					i.nrocupom=os.nrocupom and
					os.Descricao = 'LIBERAR DESCONTO'
				LEFT JOIN controle.usuarios sc ON 
					i.nroloja = sc.nroloja and 
					os.supervisor = sc.codigo					 
				LEFT JOIN controle.usuarios ope ON
					i.nroloja = ope.nroloja AND
					i.operador = ope.codigo
				LEFT JOIN controle.secoes s 	ON
					i.depto = s.codigo
				LEFT JOIN controle.conf_descontos_tipo d ON
					i.AcertoDesconto = d.codigo
				LEFT JOIN retag.mercador m ON
					m.nroloja=i.nroloja AND
					i.codigo=m.codigoean
				LEFT JOIN retag.cupom c ON
					c.nroloja=i.nroloja and
					i.dataproc=c.dataproc and
					i.pdv=c.pdv and
					i.nrocupom=c.nrocupom
				WHERE  i.nroloja=$lojaConsultada AND
					i.dataproc BETWEEN '$dataConsultaInicial' AND '$dataConsultaFinal'
				    AND i.pdv like '%$pdvConsultado%' 
				    AND i.AcertoDesconto like '%$descontoConsultado%' and 
					i.valor < i.valororiginal AND
					i.estornado = 0
				ORDER BY
					i.dataproc,
					i.pdv,
					i.nrocupom,
					i.item";
            $resultado_infoDesconto = mysqli_query($conexaoLoja, $SqlInfoDesconto); ?>
            <table class="table table-bordered dataTable fonte" id="example">
                <thead class="cabecalho">
                <tr>
                    <th class="p-2" scope="col">Loja</th>
                    <th class="p-2" scope="col">Data</th>
                    <th class="p-2" scope="col">Pdv</th>
                    <th class="p-2" scope="col">Seção</th>
                    <th class="p-2" scope="col">Nro Cup</th>
                    <th class="p-2" scope="col">Merc</th>
                    <th class="p-2" scope="col">Oper.</th>
                    <th class="p-2" scope="col">Super.</th>
                    <th class="p-2" scope="col">Seq Item</th>
                    <th class="p-2" scope="col">Qtd</th>
                    <th class="p-2" scope="col">Un S/Desc</th>
                    <th class="p-2" scope="col">Un C/Desc</th>
                    <th class="p-2" scope="col">Tot S/Desc</th>
                    <th class="p-2" scope="col">Tot C/Desc</th>
                    <th class="p-2" scope="col">Tot Desc</th>
                    <th class="p-2" scope="col">Tipo Desc</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row_infoDesconto = mysqli_fetch_assoc($resultado_infoDesconto)) {
                    $total_quantidade += $row_infoDesconto["quantidade"];
                    $total_valor += $row_infoDesconto["valor"];
                    $total_original += $row_infoDesconto["valororiginal"];
                    $total_desconto += $row_infoDesconto["valordesconto"];
                    $total_valor_unit += $row_infoDesconto["valorunitario"];
                    $total_valor_unit_original += $row_infoDesconto["valorunitariooriginal"];
                    ?>
                    <tr class="linha">
                        <td class="p-1"><?php echo $lojaConsultada; ?></td>
                        <th class="p-1"
                            scope="row"><?php echo date('d-m-y', strtotime($row_infoDesconto["dataproc"])) ?></th>
                        <td class="p-1"><?php echo $row_infoDesconto["pdv"]; ?></td>
                        <td class="p-1"><?php echo substr($row_infoDesconto["secao"], 0, 10); ?></td>
                        <td class="p-1"><?php echo $row_infoDesconto["nrocupom"]; ?></td>
                        <td class="p-1"><?php echo substr($row_infoDesconto["descr_merc"], 0, 15); ?></td>
                        <td class="p-1"><?php echo $row_infoDesconto["operador_cod"]; ?></td>
                        <td class="p-1"><?php echo $row_infoDesconto["supervisor_cod"]; ?></td>
                        <td class="p-1"><?php echo $row_infoDesconto["item"]; ?></td>
                        <td class="p-1"><?php echo number_format($row_infoDesconto["quantidade"], 0, ",", "."); ?></td>
                        <td class="p-1"><?php echo number_format($row_infoDesconto["valorunitariooriginal"], 2, ",", "."); ?></td>
                        <td class="p-1"><?php echo number_format($row_infoDesconto["valorunitario"], 2, ",", "."); ?></td>
                        <td class="p-1"><?php echo number_format($row_infoDesconto["valororiginal"], 2, ",", "."); ?></td>
                        <td class="p-1"><?php echo number_format($row_infoDesconto["valor"], 2, ",", "."); ?></td>
                        <td class="p-1"><?php echo number_format($row_infoDesconto["valordesconto"], 2, ",", "."); ?></td>
                        <td class="p-1">
                            <?php
                            if($row_infoDesconto["AcertoDesconto"] == 1){
                                echo "Desconto Promocional";
                            }elseif ($row_infoDesconto["AcertoDesconto"] == 2){
                                echo "Acerto de Valor";
                            }elseif ($row_infoDesconto["AcertoDesconto"] == 3){
                                echo "Pack Virtual";
                            }elseif ($row_infoDesconto["AcertoDesconto"] == 4){
                                echo "Desconto Subtotal";
                            }elseif ($row_infoDesconto["AcertoDesconto"] == 3){
                                echo "Sócio Torcedor";
                            }elseif ($row_infoDesconto["AcertoDesconto"] == 6){
                                echo "Desconto Cliente/Secao";
                            }elseif ($row_infoDesconto["AcertoDesconto"] == 7){
                                echo "Desconto Programado";
                            }elseif ($row_infoDesconto["AcertoDesconto"] == 8){
                                echo "Desconto Secao/PDV";
                            }elseif ($row_infoDesconto["AcertoDesconto"] == 9){
                                echo "Desconto Plu/Finalizadora";
                            }else {
                                echo $row_infoDesconto["descricao"];
                            }
                            ?>
                        </td>
                    </tr>
                    <?php

                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td class="p-1 fonte_totais" colspan="9">Total Geral</td>
                    <td class="p-1 fonte_totais"><?php echo $total_quantidade; ?></td>
                    <td class="p-1 fonte_totais"><?php echo number_format($total_valor_unit_original, 2, ",", "."); ?></td>
                    <td class="p-1 fonte_totais"><?php echo number_format($total_valor_unit, 2, ",", "."); ?></td>
                    <td class="p-1 fonte_totais"><?php echo number_format($total_original, 2, ",", "."); ?></td>
                    <td class="p-1 fonte_totais"><?php echo number_format($total_valor, 2, ",", "."); ?></td>
                    <td class="p-1 fonte_totais"><?php echo number_format($total_desconto, 2, ",", "."); ?></td>
                    <td class="p-1 fonte_totais text-center"><a href="https://www.be-mk.com/" target="_blank"><span
                                    style="color:#164259;">be<span style="color:#f7af24;">M</span>K©</span></a></td>
                </tr>
                </tfoot>
            </table>
            <?php
        }
        ?>
    </section>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("jquery", "3.6.0");
</script>

<script type="text/javascript">
    $(function () {
        $('#nroLoja').change(function () {
            if ($(this).val()) {
                $('#nroPdv').hide();
                $('.carregando').show();
                $.getJSON('completa_campos.php?search=', {nroLoja: $(this).val(), ajax: 'true'}, function (j) {
                    var options = '<option value="999">Todos</option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].codigo + '">' + j[i].codigoPdv + '</option>';
                    }
                    $('#nroPdv').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#nroPdv').html('<option value="999">– Todos –</option>');
            }
            if ($(this).val()) {
                $('#tipoDesconto').hide();
                $('.carregando').show();
                $.getJSON('completa_desconto.php?search=', {nroLoja: $(this).val(), ajax: 'true'}, function (j) {
                    var options = '<option value="999">Todos</option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].codigo + '">' + j[i].descricao + '</option>';
                    }
                    $('#tipoDesconto').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#tipoDesconto').html('<option value="999">– Todos –</option>');
            }
        });
    });
</script>
<script type="text/javascript">

    $(document).ready(function () {
        $('#example').DataTable({
            pageLength: 12,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Relatório de Descontos por Seção e Pdv',
                    text: 'Exportar Excel',
                    footer: true,
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: 'Relatório de Descontos por Seção e Pdv',
                    text: 'Exportar CSV',
                    footer: true

                },
                {
                    extend: 'pdfHtml5',
                    title: 'Relatório de Descontos por Seção e Pdv',
                    text: 'Exportar PDF',
                    footer: true,
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
                {
                    extend: 'copyHtml5',
                    title: 'Relatório de Descontos por Seção e Pdv',
                    text: 'Copiar para &aacute;rea de transfer&ecirc;ncia',
                    footer: true
                },
                {
                    extend: 'print',
                    title: 'Relatório de Descontos por Seção e Pdv',
                    text: 'Imprimir',
                    footer: true
                }
            ],

            "filter": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json",
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        });
    });
</script>
</body>
</html>