<?php

class log_mercadoria extends log
{
	
	/*
	* Construtor
	*/
	
	function log_mercadoria() {
		$this->log_file_name = "/servidor/retaguarda_mercadoria.log";
		$this->log();
	}
}

?>