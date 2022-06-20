<?php
require_once "../../../sistema/bd.class.php";

class senha
{
    /*
    construtor
    */
    function senha ()
    {

    }
	
	function verificaAcesso()
	{
		$con = new bd;
        $con->connect();
		
		
        $sql = "SELECT CodTipoSenhaMercadoria
               FROM ".BD_CONTROLE.".pf_loja
			   LIMIT 1";

		//die($sql);
        $con->query($sql);
		
		$row = $con->fetch_array();
		
		switch ($row["CodTipoSenhaMercadoria"]) {
			case 1:
				return 1;
				break;
			
			//verificar se a senha estс certo, e se possui validade
			case 2:
				return $this->validaSenha($_POST["SenhaMercadoria"]);
				break;
				
			case 3:
				return 3;
				break;
				
			default:
				return 3;
		}
	}
	
	/*
	verifica se precisa de senha para operaчуo
	*/
	function verificaSenha ()
	{
		$con = new bd;
        $con->connect();
		
		
        $sql = "SELECT CodTipoSenhaMercadoria
               FROM ".BD_CONTROLE.".pf_loja
			   LIMIT 1";

		//die($sql);
        $con->query($sql);
		
		$row = $con->fetch_array();
		
		if ($row["CodTipoSenhaMercadoria"] == 2) {
			return 1;
		} else {
			return 0;
		}
	}
	
	/*
	verifica se senha щ valida
	*/
	function validaSenha ($senha = "")
	{
		//echo $senha; die;
		$parte2 = ($_SESSION["LOJA"]["NRO"] * (date("w") + 1)) + date("d") * 3;
		$parte2 = trim($parte2);
		
		$auxHora = str_pad(substr($senha, 0, 2) - 15, 2, 0, STRP_PAD_LEFT) . ":" . str_pad(substr($senha, 2, 2) - 20, 2, 0, STRP_PAD_LEFT) . ":00";
		$horaLimite = mktime(substr($auxHora, 0, 2), substr($auxHora, 3, 2) + 30, substr($auxHora, 5, 2), date("m"), date("d"), date("Y"));
		
		if ($horaLimite > time()) {
			if (substr($senha, 4, 4) == $parte2) {
				return 3;
			} else {
				return 2;
			}
		} else {
			return 2;
		}
	}
	
	/*
	gerar nova senha
	*/
	function geraSenha ()
	{
		$hora = date("H");
		$minuto = date("i");
		
		$parte1 = (date("H") + 15) . (date("i") + 20);
		$parte2 = ($_SESSION["LOJA"]["NRO"] * (date("w") + 1)) + date("d") * 3;
		
		return $parte1.$parte2;
	}
}

?>