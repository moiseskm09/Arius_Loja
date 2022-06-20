<?php
include ("config_bd.php");

   
function conexao() {
global $usuario_bd;
global $senha_bd;
global $base_principal;
global $endereco_bd;


    $usuarioBD = $usuario_bd;
	$senhaBD = $senha_bd;
	$Banco = $base_principal;
	$Servidor = $endereco_bd;

$PDO = new PDO('mysql:host='.$Servidor.';dbname='.$Banco,$usuarioBD,$senhaBD); 
    return $PDO;
}
	
?>
