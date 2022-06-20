<?php
date_default_timezone_set('America/Sao_Paulo'); // Hora oficial do Brasil.
include ("config/conexao.php");
include ("config/config_geral.php");
error_reporting(0);
ini_set(“display_errors”, 0 );

session_start(); # Deve ser a primeira linha do arquivo
$cnpj = $_SESSION['cnpj'];
$nome= $_SESSION['usuario'];
$dataatual = date ('dmY');
$data = date ('d-m-Y H:i:s');
$busca = mysqli_query ($conexao, "SELECT * FROM clientes WHERE cnpj = $cnpj");
$resultado = mysqli_fetch_assoc($busca);
$loja= $resultado["lojasap"];


if ($cnpj > 0) {

$conteudo = "";
$conteudo .= "".PHP_EOL;
$conteudo = "#!/bin/bash";
$conteudo .= "".PHP_EOL;
$conteudo .= "".PHP_EOL;

$conteudo .= "sudo cp /var/www/licftp/licencas$cnpj.dat /siga/licenca/".PHP_EOL;

$name = "/var/www/licenca/atualizacao_licenca.sh";
$file = fopen ($name, 'a+'); 
fwrite($file, $conteudo);
fclose($file);

$comando = "chmod +x $name";
$permissao = exec(escapeshellcmd($comando), $output);

$atualiza=shell_exec("sudo /var/www/licenca/atualizacao_licenca.sh");
unlink($name);

$log = "";
$log .= "".PHP_EOL;
$log .= "____________________________________________________________".PHP_EOL;
$log .= "Loja: $loja - Data de Geracao $data".PHP_EOL;
$log .= "Arquivo gerado: licencas$cnpj.dat".PHP_EOL;
$log .= "usuario geracao: $nome".PHP_EOL;
$log .= "____________________________________________________________".PHP_EOL;
$name = "/var/www/log/licencas$dataatual.txt";
$file = fopen ($name, 'a+'); 
fwrite($file, $log);
fclose($file);

header("location: licenca.php?sucesso=0");

} else {
header("location: licenca.php?erro=1");
	
}

?>