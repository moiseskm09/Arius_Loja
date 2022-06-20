<?php
require_once "login.class.php";
require_once "licenca.class.php";

$login = new login;

if ($login->logar()) {
	//verifica para onde apontar o usu�rio conforme licen�a de uso
	if ($login->avisoLicenca == 1 || $login->avisoLicenca == 2) {
		//direciona para a tela de aviso de expira��o da licen�a ou licen�a expirado
		header("location: aviso_licenca.php");
	} else {
		//entra direto no sistema
		header("location: principal.php");
	}
} else {
    header("location: ../index.php?erro=1");
}
?>