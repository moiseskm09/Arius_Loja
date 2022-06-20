<?php

class log
{

	var $fp;
	var $log_file_name = "";

	/*
	* Construtor
	*/
	
	function log () {
		if ($this->log_file_name == "") {
			return die("'log_file_name' campo obrigatório!");
		}
		
		$this->fp = @fopen($this->log_file_name, "ab");
		@chmod($this->log_file_name, 0755);
	}
	
	/*
	* Grava log no arquivo
	*/
	
	function grava ($texto = "") {
		if ($this->fp) {
			@fwrite($this->fp, $texto."\r\n");
		}
	}
	
	function fclose() {
		if ($this->fp) {
			fclose($this->fp);
		}
	}
}

?>