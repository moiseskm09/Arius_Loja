<?php
class licenca
{
	var $diasAviso = 15; //dias
	var $diasFaltantes; //dias
	var $dataFormatada; //data formatada a partir do timestemp
	
    /*
    construtor
    */
    function licenca ()
    {

    }

    /*
    verifica licenчa de uso do sistema
    */
    function verificaLicenca (&$erro)
    {
		
		//testa qual o sistema operacional
		if (strtoupper(substr(PHP_OS, 0,3) == 'WIN')) {
			$path = "/servidor/verifica_licenca.exe";
		} else {
			$path = "/servidor/verifica_licenca";
		}
		
		if (file_exists($path)) {
			
			$retorno = @exec($path, $x, $erro);
			
			//setar variсvel da diferenчa e data formatada
			$this->dataFormatada = date("d/m/Y", $retorno);
			$this->diasFaltantes = ceil(($retorno - mktime(0, 0, 0, date("m"), date("d"), date("Y"))) / 86400);
			//$this->diasFaltantes = ceil((mktime(0, 0, 0, date("m"), 25, date("Y")) - mktime(0, 0, 0, date("m"), date("d"), date("Y"))) / 86400);
			
			//retorno da funчуo
			return $retorno;
		}
	}
}

?>