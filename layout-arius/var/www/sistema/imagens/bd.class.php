<?php
	@umask("0000");
	
	class bd
	{
		var $host;
		var $user;
		var $password;
		var $db_default;
		var $id;
		var $result;
		var $num_rows;
		var $row = array();
		var $table = array();
	
		/*
		construtor;
		*/
		function bd ()
		{
				include_once "config.inc.php";
	
				$this->host       = HOST;
				$this->user       = USER;
				$this->password   = PASSWORD;
				$this->db_default = BD_DEFAULT;
		}
	
		/*
		abre conexao;
		*/
		function connect ()
		{
			$this->id = mysql_connect($this->host, $this->user, $this->password);
			mysql_select_db($this->db_default) or $this->logError("mysql_connect(".$this->host.", ".$this->user.", ".$this->password.")" , mysql_error());
		}
		
		function conecta_integracao( $ip, $user, $passwd, $base ){
			$this->id = mysql_connect( $ip, $user, $passwd );
			mysql_select_db( $base ) or $this->logError("mysql_connect(".$ip.", ".$user.", ".$passwd.")" , mysql_error());
		}
		
		function conecta_ibi( $ip, $user, $passwd ){
			$this->id = mysql_connect( $ip, $user, $passwd );
			mysql_select_db( BD_IBI ) or $this->logError("mysql_connect(".$ip.", ".$user.", ".$passwd.")" , mysql_error());
			return $this->id;
		}
		
		/*
		executa sql;
		*/
		function query ($sql, $exibeErro = 1)
		{
			$this->result = @mysql_query($sql, $this->id) or $this->logError($sql , mysql_error(), $exibeErro);
			if ($this->result) {
					$this->num_rows = @mysql_num_rows($this->result);
			}
			return $this->result;
		}
		
		function affected_rows(){
			return ( mysql_affected_rows( $this->id ) > 0 ) ? mysql_affected_rows( $this->id ) : 0;
		}
		
		/*
		retorna array associativo com cada um dos registros resultantes da execucao da sql;
		*/
		function fetch_array ()
		{
			return $this->row = mysql_fetch_array($this->result);
		}
		
		/*
		retorna array numerico com cada um dos registros resultantes da execucao da sql;
		*/
		function fetch_row()
		{
			return $this->row = mysql_fetch_row($this->result);
		}
		
		/*
		retorna array com todos os registros resultantes da execucao da sql;
		*/
		function fetch_all ()
		{
			$array = array();
			while ($row = mysql_fetch_array($this->result)) {
					array_push($array, $row);
			}
			return $this->table = $array;
		}
	
		/*
		fecha conexao;
		*/
		function close ()
		{
			mysql_close($this->id) or $this->logError("" , mysql_error());
		}
	
		/*
		libera memoria;
		*/
		function free_result ()
		{
			mysql_free_result($this->id) or $this->logError("" , mysql_error());
		}
	
		/*
		grava log de erro;
		*/
		function logError ($comando, $erro, $exibeErro = 1)
		{
			if ($exibeErro == 1) {
					echo "<b>Comando:</b> ".$comando."<br>";
					echo "<b>Erro:</b> ".$erro."<br><br>";
			}
	
			$fp = fopen("/servidor/sqlError.log", "a");
			$log = "[".date("d-m-Y")." ".date("H:i:s")."] [comando]:".$comando." [erro]:".$erro."\n";
			fwrite($fp, $log);
			fclose($fp);
			$this->error = $erro;
		}
	
	}
?>
