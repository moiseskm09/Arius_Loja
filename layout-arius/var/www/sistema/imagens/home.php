<?php
require_once "../sistema/config.inc.php";
require_once "../sistema/autenticacao.class.php";
require_once "../sistema/licenca.class.php";
require_once "../sistema/phemplate.class.php";
require_once "../sistema/libs.php";

$aut = new autenticacao;
$licenca = new licenca;
$tpl = new phemplate;

if ($aut->autenticar(1)) {

    $tpl->set_var("TEMA", $_SESSION["USUARIO"]["TEMA"]);
    $tpl->set_var("VERSAO", VERSAO);
    $tpl->set_var("RAZAO", $_SESSION["LOJA"]["RAZAO"]);
    $tpl->set_var("LOJA", $_SESSION["LOJA"]["NRO"]);
    $tpl->set_var("CIDADE", $_SESSION["LOJA"]["CIDADE"]);
    $tpl->set_var("UF", $_SESSION["LOJA"]["UF"]);
    $tpl->set_var("path", PATH);
	$tpl->set_var("CGC", $_SESSION["LOJA"]["CGC"]);

	//executa o arquivo de licença
	$retorno = $licenca->verificaLicenca($erro);

	$block = false; //inicializa o block como falso
	if ($erro == 0 && !empty($retorno)) {
		if ($licenca->diasFaltantes <= $licenca->diasAviso && $licenca->diasFaltantes > 0) {
			$block = true;
			$licenca = "Sua licença é válida até a data de <b>".$licenca->dataFormatada.".</b>
				<br>Faltam <b>".$licenca->diasFaltantes."</b> dias para sua licença expirar.</b><br>";
		} elseif ($licenca->diasFaltantes > 0) {
			$block = true;
			$licenca = "Data de validade de sua licença: <b>".$licenca->dataFormatada.".
				<br>Faltam ".$licenca->diasFaltantes." dias para sua licença expirar.</b><br>";
		} else {
			$block = true;
			$licenca = "Licença expirada na data de <b>".$licenca->dataFormatada.".<br>";
		}

		if ($block) {
			$tpl->set_var("data", "<table border='0' width='298' class='meio' cellspacing='0' cellspading='0'><tr><td class='subtitulo_meio' height='20'>Validade da Licença de Uso</td></tr><tr><td class='meio'>".$licenca."</td></tr></table>");
		} else {
			$tpl->set_var("data", "");
		}
	} else {
		$tpl->set_var("data", "");
	}

	$tpl->set_file("text", "home.htm");
	echo $tpl->process("", "text");
}
?>
