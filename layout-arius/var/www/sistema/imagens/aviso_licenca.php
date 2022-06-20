<?php
require_once "../sistema/config.inc.php";
require_once "../sistema/phemplate.class.php";
require_once "../sistema/licenca.class.php";

//verificar licenca
$licenca = new licenca();
$retorno = $licenca->verificaLicenca($erro);

if ($erro == 0) {
	$tpl = new phemplate();
	
	//verificar validade da licenca
	if ($licenca->diasFaltantes <= $licenca->diasAviso && $licenca->diasFaltantes > 0) {
		//expirar em N dias
		$tpl->set_var("button", "<input type='button' value='Entrar' onClick='javascript:location.href=\"principal.php\"'>");
		$tpl->set_var("erro", "Sua licen�a � v�lida at� a data de <b>".$licenca->dataFormatada.".</b>
				<br>Faltam <b>".$licenca->diasFaltantes."</b> dias para sua licen�a expirar.</b>");
	} elseif ($licenca->diasFaltantes <= 0) {
		//expirado
		$tpl->set_var("button", "<input type='button' value='Voltar' onClick='javascript:location.href=\"../index.htm\"'>");
		$tpl->set_var("erro", "Licen�a expirada na data de <b>".$licenca->dataFormatada.".</b><br>Favor entrar em contato com a KW Inform�tica.");
	}
	
	$tpl->set_file("text", "aviso_licenca.htm");
	echo $tpl->process("", "text");
} else {
	//sen�o achar mandar para a principal
	header("location: principal.php");
}

?>