<?php
	include_once "config.inc.php";
	class connect{
		var $DB;
		/*construtor*/
		function connect($tipo="mysql"){
			include('adodb/adodb.inc.php');
			#definindo conex�o ao MYSQL
			$this->DB = NewADOConnection($tipo);
			if( !$this->DB ){
				echo $this->DB->ErrorMsg()."<br />"; //Mostra a mensagem
				exit("------->Erro Cr�tico"."<br />");
			}
			
			#servidor, usuario, senha e banco
			if( $tipo == "mysql" ){
				$rs = $this->DB->Connect(HOST,USER, PASSWORD, BD_DEFAULT);
			}else if( $tipo == "oci8"){
				$rs = $this->DB->Connect( CON_ORACLE, USER_ORACLE, PASSWORD_ORACLE);
			}
			if( !$rs ){
				echo $this->DB->ErrorMsg()."<br />"; //Mostra a mensagem
				exit("-------> Erro Cr�tico"."<br />");
			}else{
				$this->DB->SetFetchMode(ADODB_FETCH_ASSOC);
				return  $rs;
			}
		}
		
		function Execute($sql = ""){
			$rs = $this->DB->Execute($sql);
			if( !$rs ){
				echo $this->DB->ErrorMsg()."<br />"; //Mostra a mensagem
				exit("-------> Erro Cr�tico"."<br />");
			}else{
				return  $rs;
			}
		}
	}
?>
