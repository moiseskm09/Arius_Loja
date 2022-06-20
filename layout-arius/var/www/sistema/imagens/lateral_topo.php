<?php
require_once "../sistema/autenticacao.class.php";
require_once "../sistema/phemplate.class.php";
include_once "../sistema/config.inc.php";

$aut = new autenticacao;
$tpl = new phemplate;

if ($aut->autenticar(1)) {
    $tpl->set_var("TEMA", $_SESSION["USUARIO"]["TEMA"]);

    $tpl->set_file("text", "lateral_topo.htm");
    echo $tpl->process("", "text");
}
?>