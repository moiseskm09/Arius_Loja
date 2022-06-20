<?php
require_once './config/conexao.php';
require_once './config/config_geral.php';

$cTotal = mysqli_query ($conexao, "SELECT count(codticket) AS totalTicket FROM $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and coddepartamento = $DEPARTAMENTOERP");
$totalTicket = mysqli_fetch_assoc($cTotal);

$cTotalFechado = mysqli_query($conexao, "SELECT count(codticket) AS totalFechado from $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and codstatus in (3,13) and coddepartamento = $DEPARTAMENTOERP");
$totalFechado = mysqli_fetch_assoc($cTotalFechado);

$cFabrica = mysqli_query($conexao, "SELECT count(codticket) AS totalFabrica from $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and codstatus in (7,12) and coddepartamento = $DEPARTAMENTOERP");
$totalFabrica = mysqli_fetch_assoc($cFabrica);

$cInterno = mysqli_query($conexao, "SELECT count(codticket) AS totalInterno from $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and codstatus in (4, 5, 14) and coddepartamento = $DEPARTAMENTOERP");
$totalInterno = mysqli_fetch_assoc($cInterno);

$cEmpresa = mysqli_query($conexao, "SELECT count(codticket) AS totalEmpresa from $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and codstatus in (1, 10) and coddepartamento = $DEPARTAMENTOERP");
$totalEmpresa = mysqli_fetch_assoc($cEmpresa);

$cCliente = mysqli_query($conexao, "SELECT count(codticket) AS totalCliente from $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and codstatus = 2 and coddepartamento = $DEPARTAMENTOERP");
$totalCliente = mysqli_fetch_assoc($cCliente);

$cAbertosMes = mysqli_query($conexao, "SELECT COUNT(codticket) AS abertosMes, DATE_FORMAT(dtabertura, '%c') as mesAbertura FROM $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and coddepartamento = $DEPARTAMENTOERP group BY mesAbertura");

$janeiro = 0; $fevereiro = 0; $marco = 0; $abril = 0; $maio = 0; $junho = 0; $julho = 0; $agosto = 0; $setembro = 0; $outubro = 0; $novembro = 0; $dezembro = 0;
while($tAbetosMes = mysqli_fetch_assoc($cAbertosMes)){
    if($tAbetosMes["mesAbertura"] == 1){
        $janeiro = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 2){
        $fevereiro = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 3){
        $marco = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 4){
        $abril = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 5){
        $maio = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 6){
        $junho = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 7){
        $julho = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 8){
        $agosto = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 9){
        $setembro = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 10){
        $outubro = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 11){
        $novembro = $tAbetosMes["abertosMes"];
    }else if($tAbetosMes["mesAbertura"] == 12){
        $dezembro = $tAbetosMes["abertosMes"];
    }
}

$cFechadosMes = mysqli_query($conexao, "SELECT COUNT(codticket) AS fechadosMes, DATE_FORMAT((IF(dtfechamento = '1969-12-31', dtalteracao, dtfechamento)), '%c') as mesFechamento FROM $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and coddepartamento = $DEPARTAMENTOERP and codstatus in(3, 13) group BY mesFechamento");

$janeiroF = 0; $fevereiroF = 0; $marcoF = 0; $abrilF = 0; $maioF = 0; $junhoF = 0; $julhoF = 0; $agostoF = 0; $setembroF = 0; $outubroF = 0; $novembroF = 0; $dezembroF = 0;
while($tFechadosMes = mysqli_fetch_assoc($cFechadosMes)){
    if($tFechadosMes["mesFechamento"] == 1){
        $janeiroF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 2){
        $fevereiroF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 3){
        $marcoF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 4){
        $abrilF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 5){
        $maioF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 6){
        $junhoF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 7){
        $julhoF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 8){
        $agostoF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 9){
        $setembroF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 10){
        $outubroF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 11){
        $novembroF = $tFechadosMes["fechadosMes"];
    }else if($tFechadosMes["mesFechamento"] == 12){
        $dezembroF = $tFechadosMes["fechadosMes"];
    }
}


$caberto1Dia = mysqli_query($conexao, "SELECT count(codticket) AS abertos1Dia FROM $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and dtfechamento <= '$DATAFINAL' and (dtfechamento - dtabertura >= 0 ) AND (dtfechamento - dtabertura <= 1 )  and coddepartamento = $DEPARTAMENTOERP and codstatus in(3, 13)");
$tabertosFechados1Dia = mysqli_fetch_assoc($caberto1Dia);

$caberto3Dia = mysqli_query($conexao, "SELECT count(codticket) AS abertos3Dia FROM $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and dtfechamento <= '$DATAFINAL' and (dtfechamento - dtabertura >= 2 ) AND (dtfechamento - dtabertura <= 3 ) and coddepartamento = $DEPARTAMENTOERP and codstatus in(3, 13)");
$tabertosFechados3Dia = mysqli_fetch_assoc($caberto3Dia);

$caberto7Dia = mysqli_query($conexao, "SELECT count(codticket) AS abertos7Dia FROM $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and dtfechamento <= '$DATAFINAL' and (dtfechamento - dtabertura >= 4 ) AND (dtfechamento - dtabertura <= 7 ) and coddepartamento = $DEPARTAMENTOERP and codstatus in(3, 13)");
$tabertosFechados7Dia = mysqli_fetch_assoc($caberto7Dia);

$caberto30Dia = mysqli_query($conexao, "SELECT count(codticket) AS abertos30Dia FROM $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and dtfechamento <= '$DATAFINAL' and (dtfechamento - dtabertura >= 8 ) AND (dtfechamento - dtabertura <= 30 ) and coddepartamento = $DEPARTAMENTOERP and codstatus in(3, 13)");
$tabertosFechados30Dia = mysqli_fetch_assoc($caberto30Dia);

$caberto90Dia = mysqli_query($conexao, "SELECT count(codticket) AS abertos90Dia  FROM $DATABASE.ticket WHERE dtabertura >= '$DATAINICIAL' and dtfechamento <= '$DATAFINAL' and (IF(dtfechamento = '1969-12-31', CURRENT_DATE, dtfechamento) - dtabertura > 30 ) and coddepartamento = 8 and codstatus in(3, 13)");
$tabertosFechados90Dia = mysqli_fetch_assoc($caberto90Dia);

//avaliacao

$buscaTotais = mysqli_query($conexao, "SELECT
    tipo,
    SUM(qb.tticket) + SUM(qb.tonline) AS totalg
FROM
    (
    SELECT
        1 AS tipo,
        COUNT(tck.codticket) AS tticket,
        0 AS tonline
    FROM
        $DATABASE.usuarios u
    INNER JOIN $DATABASE.ticket tck ON
        u.id = tck.codusuario
    WHERE
        u.departamento = $DEPARTAMENTOERP AND tck.codstatus IN(3, 13) AND tck.dtabertura >= '$DATAINICIAL'
    UNION
SELECT
    2 AS tipo,
    0 AS tticket,
    COUNT(ao.idatendimento) AS tonline
FROM
    $DATABASE.usuarios u
INNER JOIN $DATABASE.atendimentoonline ao ON
    u.id = ao.codusuario
WHERE
    u.departamento = $DEPARTAMENTOERP AND ao.datasolicitacao >= '$DATAINICIAL'
) AS qb
GROUP BY
    tipo");

while($totalAtendimento = mysqli_fetch_assoc($buscaTotais)){
    if($totalAtendimento["tipo"] == 1){
        $totalTicketAnoAval = $totalAtendimento["totalg"];
    }else{
        $totalOnlineAnoAval = $totalAtendimento["totalg"];
    }
}




$buscaAvaliacao = mysqli_query($conexao, "SELECT
    qb.codavaliacao AS codaval,
    SUM(qb.totalao) + SUM(qb.totaltck) AS totalg
FROM
    (
    SELECT
        COUNT(codavaliacao) AS totalao,
        0 AS totaltck,
        codavaliacao
    FROM
        $DATABASE.usuarios u
    INNER JOIN $DATABASE.atendimentoonline ao ON
        u.id = ao.codusuario
    WHERE
        u.departamento = $DEPARTAMENTOERP AND datasolicitacao >= '$DATAINICIAL'
    GROUP BY
        codavaliacao
    UNION
SELECT
    0 AS totalao,
    COUNT(avaliacao) AS totaltck,
    CASE WHEN avaliacao IN(5, 4) THEN '1' WHEN avaliacao IN(3) THEN '2' WHEN avaliacao IN(2, 1) THEN '3' WHEN avaliacao = 0 THEN '0'
END AS codavaliacao
FROM
    $DATABASE.usuarios u
INNER JOIN $DATABASE.ticket tck ON
    u.id = tck.codusuario
WHERE
    u.departamento = $DEPARTAMENTOERP AND dtabertura >= '$DATAINICIAL' and codstatus in (3, 13)
GROUP BY
    codavaliacao
) AS qb
GROUP BY
    codaval");

$na = 0; $otimo = 0; $satisfatorio = 0; $ruim = 0; $pessimo = 0;
while($resultadoAvaliacao = mysqli_fetch_assoc($buscaAvaliacao)){
    $ttAvaliacao = $resultadoAvaliacao["codaval"];
    if($ttAvaliacao == 0){
        $na = $resultadoAvaliacao["totalg"];
       //echo $na;
    }elseif($ttAvaliacao == 1){
        $otimo = $resultadoAvaliacao["totalg"];
       //echo $otimo;
    }
    elseif($ttAvaliacao == 2){
        $satisfatorio = $resultadoAvaliacao["totalg"];
       //echo $satisfatorio;
    }elseif($ttAvaliacao == 3){
        $ruim = $resultadoAvaliacao["totalg"];
       //echo $ruim;
    }elseif($ttAvaliacao == 4){
        $pessimo = $resultadoAvaliacao["totalg"];
       //echo $pessimo;
    }
}

$totalTicketMaisOnline = $totalTicketAnoAval + $totalOnlineAnoAval;
$totalRuim = $ruim + $pessimo;

$percentualOtimo = $otimo / $totalTicketMaisOnline * 100;
$percentualSatisfatorio = $satisfatorio / $totalTicketMaisOnline * 100;
$percentualRuim = $totalRuim / $totalTicketMaisOnline * 100;
$percentualna = $na / $totalTicketMaisOnline * 100;

