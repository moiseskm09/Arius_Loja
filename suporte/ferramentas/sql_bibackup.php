<?php
require_once './config/conexao.php';
require_once './config/config_geral.php';

$data = date("Y-m-04");


$buscaTotalCliente = mysqli_query($conexao, "SELECT cliente FROM cre.backup group by cliente");
$totalcliente = mysqli_num_rows($buscaTotalCliente);

$buscaTotalbackup = mysqli_query($conexao, "SELECT cliente FROM cre.backup");
$totalbackup = mysqli_num_rows($buscaTotalbackup);

$sqlS = mysqli_query ($conexao, "SELECT * FROM cre.backup WHERE dtatualizacao = '$data' and tamanho >= 0.03 ORDER BY dtatualizacao DESC");
$backupok = mysqli_num_rows($sqlS);


$sqlD = mysqli_query ($conexao, "SELECT cliente, tamanho, loja, dtatualizacao FROM cre.backup WHERE tamanho <= 0.02 and dtatualizacao = '$data' ORDER BY dtatualizacao DESC");
$backupdivergente = mysqli_num_rows($sqlD);


$sqlE = mysqli_query ($conexao, "SELECT * FROM cre.backup WHERE dtatualizacao != '$data' ORDER BY dtatualizacao DESC");
$backuperro = mysqli_num_rows($sqlE);


$percentualS = $backupok / $totalbackup * 100;
$percentualD = $backupdivergente / $totalbackup * 100;
$percentualE = $backuperro / $totalbackup * 100;

$buscaRelacaoerros = mysqli_query ($conexao, "SELECT cliente, loja, dtatualizacao FROM cre.backup WHERE tamanho <= 0.02 and dtatualizacao = '$data'  or dtatualizacao != '$data' ORDER BY dtatualizacao ASC LIMIT 7");
?>