<?php
require_once "../sistema/autenticacao.class.php";
require_once "../sistema/phemplate.class.php";
require_once "../sistema/config.inc.php";

$aut = new autenticacao;
$tpl = new phemplate;

/*if ($aut->autenticar(1)) {*/
    $tpl->set_var("TEMA", $_SESSION["USUARIO"]["TEMA"]);

	$menu = "<table border='0' cellpading='0' cellspacing='0' width='100%'><tr><td>";

	if ($_SESSION["MENU"]) {
		foreach ($_SESSION["MENU"] as $k => $v) {
			if (!$v["LINK"] && !empty($v["NOME"])) {
				if ($v["NOME"]) {
					$menu .= "</div>";
				}

				$menu .= "
					<table border='0' cellpading='0' cellspacing='0' width='100%'>
						<tr>
							<td class='titulo_lateral' onClick='javascript: abreMenu(\"layer".$k."\");' style='cursor:pointer;'>".$v["NOME"]."</td>
						</tr>
					</table>
					<input type='hidden' value='layer".$k."'>
					<div id='layer".$k."' style='display: none;' style='visibility: hidden;'>
				";
			} elseif (!empty($v["NOME"])) {
				$menu .= "
						<table>
							<tr>
								<td class='link_lateral'>
									<a class='lateral' href='".$v["LINK"]."' target='basefrm'>- ".$v["NOME"]."</a>
								</td>
							</tr>
						</table>
				";
			}
		}
	}
	
	$menu .= "</div>";
	
// 	$menu .= "
// 					<table border='0' cellpading='0' cellspacing='0' width='100%'>
// 						<tr>
// 							<td class='titulo_lateral' onClick='javascript: abreMenu(\"layerT\");' style='cursor:pointer;'>TESTES</td>
// 						</tr>
// 					</table>
// 					<input type='hidden' value='layerT'>
// 					<div id='layerT' style='display: none;' style='visibility: hidden;'>
// 						<table>
// 							<tr>
// 								<td class='link_lateral'>
// 									<a class='lateral' href='http://localhost/testes/teste.php' target='basefrm'>- Testes</a>
// 								</td>
// 							</tr>
// 						</table>
// 					</div>
// 				";
	
	
	
	$menu .= "</td></tr></table>";

    $tpl->set_var("menu", $menu);

    $tpl->set_file("text", "lateral.htm");
    echo $tpl->process("", "text");
/*}*/

?>