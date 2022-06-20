<?php
session_start();
if (!isset($_SESSION["USUARIO"]["NIVEL"])) {
    header("location:../index.htm");
}

require_once "../sistema/config.inc.php";
require_once "../sistema/autenticacao.class.php";
require_once "../sistema/phemplate.class.php";

$aut = new autenticacao;
$tpl = new phemplate;


if ($aut->autenticar(1)) {

    $tpl->set_file("text", "principal.htm");
    echo $tpl->process("", "text");
}
?>