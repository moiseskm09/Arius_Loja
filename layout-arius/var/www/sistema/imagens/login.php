<?php
require_once "login.class.php";
require_once "licenca.class.php";

$login = new login;

if ($login->logar()) {
	//verifica para onde apontar o usuсrio conforme licenчa de uso
	if ($login->avisoLicenca == 1 || $login->avisoLicenca == 2) {
		//direciona para a tela de aviso de expiraчуo da licenчa ou licenчa expirado
		header("location: aviso_licenca.php");
	} else {
		//entra direto no sistema
		header("location: principal.php");
	}
} else {
    header("location: ../index.php?erro=1");
}
?>