<?php
	require_once( "adodb/adodb-time.inc.php" );
	
	function nro_loja(){
		$con = new bd;
		$con->connect();
		$sql = "SELECT nroloja FROM ".BD_CONTROLE.".pf_loja";
		$con->query($sql);
		$row = $con->fetch_array();
		return $row["nroloja"];
	}
	
	function diretorioDeExportacao ()
	{
		$con = new bd;
		$con->connect();
	
		$sql = "SELECT ".
						"direxp ".
				"FROM ".
						BD_CONTROLE.".pf_loja";
		$con->query($sql);
	
		$row = $con->fetch_array();
		return $row["direxp"];
	}
	
	function diretorioDeImpressao ()
	{
		$con = new bd;
		$con->connect();
	
		$sql = "SELECT ".
						"DirImpressao ".
				"FROM ".
						BD_CONTROLE.".pf_loja";
		$con->query($sql);
	
		$row = $con->fetch_array();
		return $row["DirImpressao"];
	}
	
	function diretorioDeEtiquetas ()
	{
		$con = new bd;
		$con->connect();
	
		$sql = "SELECT ".
						"DirEtiquetas ".
				"FROM ".
						BD_CONTROLE.".pf_loja";
		$con->query($sql);
	
		$row = $con->fetch_array();
		return $row["DirEtiquetas"];
	}
	/*
	transforma data;
	*/
	function dataSqlBr ($data, $tipo = "am"){
		if( $tipo == "am" ){//transforma do formato brasileiro para americano.
			list($d, $m, $a) = explode ("/", $data);
			$data = $a."-".$m."-".$d;
		}else if( $tipo == "br" ){//transforma do formato americano para o brasileiro.
			list($a, $m, $d) = explode ("-", $data);
			$data = $d."/".$m."/".$a;
		}
		return $data;
	}
	
	function formata_decimal( $decimal ){
		if( strpos( $decimal, "," ) ){
			$decimal = str_replace( ",", ".", $decimal );
		}else if( strpos( $decimal, "." ) ){
			$decimal = str_replace( ".", ",", $decimal );
		}
		return $decimal;
	}
	
	/********************************************************************************************************
	* formata_data
	********************************************************************************************************
	Caso sejam passados os parametros:
			$formato_orig e $formato_dest
			onde $formato_orig eh o formato de origem (formato que a data esta)
			e
			$formato_dest eh o formato de destino (formato que a data deve ficar)
			a funcao ira formatar a data de acordo com os formatos passados.
	Se nao forem passados os parametros acima, a data devera estar no formato dd/mm/aaaa ou aaaa-mm-dd
			se a data estiver no fomato dd/mm/aaaa ela sera formatada automaticamente para o formato aaaa-mm-dd
			e se estiver como aaaa-mm-dd vai ser formatada para dd/mm/aaaa.
	O parametro $debug mostra mensagem de erro no uso da funcao caso seja passado true.
	********************************************************************************************************/
	function formata_data( $data, $formato_orig=false, $formato_dest=false, $debug=false ){
		if( $data ){
			if( !$formato_orig ){
				if( ( strpos( $data, "-" ) == 4 ) ){
					list($a, $m, $d) = explode ("-", $data);
					$data = $d."/".$m."/".$a;
				}else if( ( strpos( $data, "/" ) == 2 ) ){
					list($d, $m, $a) = explode ("/", $data);
					$data = $a."-".$m."-".$d;
				}
			}else if( $formato_orig && $formato_dest ){
				
				$ini_dia = strpos( $formato_orig, "d" );
				$fim_dia = strrpos( $formato_orig, "d" );
				if( $ini_dia && $fim_dia ){
					if( ( ( $fim_dia - $ini_dia ) != 1 ) ){
						$erro .= "formato incorreto no dia<br />";
					}
				}
				
				$ini_mes = strpos( $formato_orig, "m" );
				$fim_mes = strrpos( $formato_orig, "m" );
				if( $ini_mes && $fim_mes ){
					if( ( ( $fim_mes - $ini_mes ) != 1 ) ){
						$erro .= "formato incorreto no mes<br />";
					}
				}
				
				$ini_ano = strpos( $formato_orig, "a" );
				$fim_ano = strrpos( $formato_orig, "a" );
				if( $ini_ano && $fim_ano ){
					if( ( ( ( $fim_ano - $ini_ano ) != 3 ) && ( ( $fim_ano - $ini_ano ) != 1 ) ) ){
						$erro .= "formato incorreto no ano<br />";
					}
				}
				
				$d = substr( $data, $ini_dia, 2 );
				$m = substr( $data, $ini_mes, 2 );
				$a = substr( $data, $ini_ano, ( ( $fim_ano - $ini_ano ) + 1 ) );
				
				
				
				$timestamp = adodb_mktime(0, 0, 0, $m, $d, $a);
				
				$frmto = str_replace( "dd", "d", $formato_dest );
				$frmto = str_replace( "mm", "m", $frmto);
				$frmto = str_replace( "aaaa", "Y", $frmto);
				$frmto = str_replace( "aa", "y", $frmto);
				$data = adodb_date( $frmto, $timestamp );
				
				
				
				if( $debug && $erro ){
					echo "Erro: ".$erro."<br />Uso incorreto da função 'formata_data' <br /> string formata_data( string data  [, string formato origem, string formato destino  ] ) <br /> string data pode ser dd/mm/aaaa ou aaaa-mm-dd <br />";
				}
				
			}
			
			return $data;
		}else{
			return false;
		}
	}
	
	//formata conteúdo para inserir no template
	function conteudo($string, $tamanho)
	{
		$tam = strlen($string);
	
		for ($i = $tam; $i < $tamanho; $i++) {
			$espacos .= " ";
		}
	
		return $string.$espacos;
	}
	
	//para funcionar no windows
	function rename_win($oldfile,$newfile) {
		if (!rename($oldfile,$newfile)) {
		if (copy ($oldfile,$newfile)) {
				unlink($oldfile);
				return TRUE;
		}
		return FALSE;
		}
		return TRUE;
	}
	
	//exibir estrutura de um array
	function printr($array) {
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
	
	
	/**
	* Função Upload de Arquivos
	*/
	
	function upload($arquivo, $nome_real, $pasta_arq) {
		if(@$arquivo) {
			if(is_uploaded_file($arquivo)) {
					$nome_final = $pasta_arq . $nome_real;
					$copy = move_uploaded_file($arquivo, $nome_final);
					if(@$copy) {
						return true;
					}elseif(!$copy) {
						return false;
					}
			}
		}
	}
	
	function comboPagina ($selected = array(), $total_paginas, $pagina)
	{
		$con = new bd;
		$con->connect();
	
		$combo = "<select name='pagina' onchange=submitForm('".$_SERVER["PHP_SELF"]."') class='meio'>\n";
	
		for ($i=0; $i<$total_paginas; $i++) {
			$combo .= "<option value='".($i+1)."'".($pagina==$i+1?" selected":"").">".($i+1)."\n";
		}
		return $combo .= "</select>";
	}
	
	function location ($url) {
		?>
		<script language="javascript">
			location.href = "<? echo $url; ?>";
		</script>
		<?
	}
	
	function alert ($msg, $url = "") {
		?>
		<script language="javascript">
			alert("<? echo $msg; ?>");
					<?
					if (!empty($url)) {
					?>
						location.href = "<? echo $url; ?>";
					<?
					}
					?>
		</script>
		<?
	}
	
	function confirm ($msg, $url1 = "", $url2 = "") {
		?>
		<script language="javascript">
			if (confirm("<? echo $msg; ?>")) {
					<?
					if (!empty($url1)) {
					?>
						location.href = "<? echo $url1; ?>";
					<?
					}
					?>
			} else {
					<?
					if (!empty($url2)) {
					?>
						location.href = "<? echo $url2; ?>";
					<?
					}
					?>
			}
		</script>
		<?
	}
	
    /* funcao que joga para um array os vasilhame importados */
	function buscarVasilhame () {
		$con = new bd;
		$con->connect();
	
		//buscar tributação na tabela controle.converteTributacao
		$sql = "SELECT Sequencia,
						CodigoVas
					FROM ".BD_RETAG.".vasilhame";
	
		$con->query($sql, 0);
		unset($sql);
		if ($con->num_rows > 0) {
		    while ($row = $con->fetch_array()) {
                $arrVasilhame[ $row["Sequencia"] ] = $row["CodigoVas"];
		    }
        }    
		return $arrVasilhame;
	}

    function buscarTributacao () {
		$con = new bd;
		$con->connect();
	
		//buscar tributação na tabela controle.converteTributacao
		$sql = "SELECT codTrib,
							tributacao
					FROM ".BD_CONTROLE.".converteTributacao";
	
		$con->query($sql, 0);
		unset($sql);
		$arrTributacao = $con->fetch_all();
		return $arrTributacao;
	}
	/*
		Converte a tributacao vinda do clientes para a usada internamente pela KW
	*/
	function converteTributacao(){
	
		if ($_GET['externa']) {
			$tiporetag = $_GET["tiporetag"];
		} else {
			$tiporetag = $_SESSION["LOJA"]["TIPORETAG"];
		}
		$sql = "SELECT 
						codTrib,reducao,tributacao,tiporetag
				FROM ".
						BD_CONTROLE.".converteTributacao 
				WHERE 
						tiporetag=".$tiporetag.";";
	
		$con = new bd;
		$con->connect();
		$con->query($sql);
		if($con->num_rows > 0){
			while ($row = $con->fetch_array()) {
				$this->codtrib = $row["codTrib"];
				$this->arr_trib[$this->codtrib] = $row["tributacao"];
			}
			return $this->arr_trib;
		}
	}
	
	/*
		Converte a tributacao usada internamente pela KW para a tributação original do cliente
	*/
	Function buscaTribOriginal() {
		if ($_GET['externa']) {
			$tiporetag = $_GET["tiporetag"];
		} else {
			$tiporetag = $_SESSION["LOJA"]["TIPORETAG"];
		}
		
		$sql = "SELECT 
						codTrib,reducao,tributacao,tiporetag
			FROM ".
					BD_CONTROLE.".converteTributacao 
			WHERE 
					tiporetag=".$tiporetag.";";
	
		$con = new bd;
		$con->connect();
		$con->query($sql);
		if($con->num_rows > 0){
			while ($row = $con->fetch_array()) {
				$this->codtrib = $row["tributacao"];
				$this->arr_trib[$this->codtrib] = $row["codTrib"];
			}
		}  
		return $this->arr_trib;
	}
	
	/*
		Busca a situaçao fiscal para ser impressa na nota fiscal 
	*/
	function buscaSittrib() {
		$con = new bd;
		$con->connect();
		
		$sql = "SELECT * ".
				"FROM ".
						BD_CONTROLE.".tributacoes ".
				"WHERE ativa=1";
		//die ($sql);
		
		$con->query($sql);
		
		if ($con->num_rows > 0) {
			while ($row = $con->fetch_array()) {
				$arrSittrib[ $row["codigo"] ] = trim($row["sittrib"]);
			} 
		}
		return $arrSittrib;
	}
	
	function buscaDigitoBalanca () {
		$con = new bd;
		$con->connect();
	
		$sql = "SELECT bal_4digitos ".
				"FROM ".
						BD_CONTROLE.".pf_loja ".
				"WHERE 1";
		$con->query($sql);
		$row = $con->fetch_array();
	
		switch ($row["bal_4digitos"]) {
			case 1:
					$digito = 4;
					break;
	
			case 0:
					$digito = 5;
					break;
	
			case 2:
					$digito = 6;
					break;
		}
		return $digito;
	}
	
	function diretorioDeImportacao (){
		
		$con = new bd;
		$con->connect();
		$sql = "SELECT dirimp FROM ".BD_CONTROLE.".pf_loja";
		$con->query($sql);
		$row = $con->fetch_array();
		return $row["dirimp"];
	}
		
	
	//retorna numero de caracteres limite para colocar dv;
	
	function limiteDv ()
	{
		$con = new bd;
		$con->connect();
	
		$sql = "SELECT ".
						"semdvsemenor ".
				"FROM ".
						"controle.pf_loja";
		$con->query($sql);
	
		$row = $con->fetch_array();
		return $row["semdvsemenor"];
	}
	
	/*
	busca numero de caracteres limite para dv
	*/
				
	function buscaSemdvsemenor ()
	{
		$con = new bd;
		$con->connect();
	
		$sql = "SELECT semdvsemenor From ".BD_CONTROLE.".pf_loja";
		$con->query($sql);
	
		$row = $con->fetch_array();
		return $row["semdvsemenor"];
	
	}
	
	function formataFlagPeso( $ean, $digitoBalanca ){
		return "02".str_pad( sprintf( "%0".$digitoBalanca."s", substr( $ean+0, -$digitoBalanca ) ), 11, 0, STR_PAD_RIGHT );
	}
	
	/*
	retorna o check digit;
	*/
	
		function checkDigit ($s)
		{
			$i = strlen($s);
			for ($x=0, $j=1-($i&1); $j<$i; $j+=2) {
					$x += intval($s[$j]);
			}
			$x *= 3;
			for ($x2=0, $j=$i&1; $j<$i; $j+=2) {
					$x2 += intval($s[$j]);
			}
			$x += $x2;
			if (!$x) {
					return 0;
			}
			$x2 = 10-($x % 10);
			if ($x2 == 10) {
					$x2 = 0;
			}
			return $x2;
		}
	
	/*
	trunca um valor decimal;
	$float = valor a ser truncado;
	$int   = numero de casas decimais desejadas;
	*/
	function trunca ($float, $int=0)
	{
		$shift = pow(10, $int);
		return ((floor($float * $shift)) / $shift);
	}
	
	function montaHora ($timestamp)
	{
		$h = trunca(($timestamp)/60/60);
		$m = trunca(($timestamp - ($h*60*60))/60);
		$s = $timestamp - ($h*60*60) - ($m*60);
		return str_pad($h, 2, 0, STR_PAD_LEFT).":".str_pad($m, 2, 0, STR_PAD_LEFT).":".str_pad($s, 2, 0, STR_PAD_LEFT);
	}
	
	function verificaCPF($cpf) {
	if (strlen($cpf) <> 11) return 0;
		$soma1 = ($cpf[0] * 10) +
					($cpf[1] * 9) +
					($cpf[2] * 8) +
					($cpf[3] * 7) +
					($cpf[4] * 6) +
					($cpf[5] * 5) +
					($cpf[6] * 4) +
					($cpf[7] * 3) +
					($cpf[8] * 2);
		$resto = $soma1 % 11;
		$digito1 = $resto < 2 ? 0 : 11 - $resto;
		$soma2 = ($cpf[0] * 11) +
					($cpf[1] * 10) +
					($cpf[2] * 9) +
					($cpf[3] * 8) +
					($cpf[4] * 7) +
					($cpf[5] * 6) +
					($cpf[6] * 5) +
					($cpf[7] * 4) +
					($cpf[8] * 3) +
					($cpf[9] * 2);
		$resto = $soma2 % 11;
		$digito2 = $resto < 2 ? 0 : 11 - $resto;
		return ( $digito1.$digito2);
	//return (($cpf[9] == $digito1) && ($cpf[10] == $digito2));
	}
	
	/*
	* Validade CNPJ (Cadastro Nacional de Pessoa Jurídica)
	* @param   string $cnpj  CNPJ to validate
	* @return  bool          true if $cnpj is ok, false otherwise
	*/
	function verificaCNPJ ($cnpj){
		$cleaned = '';
		for ($i = 0; $i < strlen($cnpj); $i++) {
				$num = substr($cnpj, $i, 1);
				if (ord($num) >= 48 && ord($num) <= 57) {
					$cleaned .= $num;
				}
		}
		$cnpj = $cleaned;
	
		if (strlen($cnpj) != 14) {
				return false;
		} elseif ($cnpj == '00000000000000') {
				return false;
		} else {
			$soma = 0;
			$soma += ($cnpj[0] * 5);
			$soma += ($cnpj[1] * 4);
			$soma += ($cnpj[2] * 3);
			$soma += ($cnpj[3] * 2);
			$soma += ($cnpj[4] * 9); 
			$soma += ($cnpj[5] * 8);
			$soma += ($cnpj[6] * 7);
			$soma += ($cnpj[7] * 6);
			$soma += ($cnpj[8] * 5);
			$soma += ($cnpj[9] * 4);
			$soma += ($cnpj[10] * 3);
			$soma += ($cnpj[11] * 2); 
	
			$d1 = $soma % 11; 
			$d1 = $d1 < 2 ? 0 : 11 - $d1; 
	
			$soma = 0;
			$soma += ($cnpj[0] * 6); 
			$soma += ($cnpj[1] * 5);
			$soma += ($cnpj[2] * 4);
			$soma += ($cnpj[3] * 3);
			$soma += ($cnpj[4] * 2);
			$soma += ($cnpj[5] * 9);
			$soma += ($cnpj[6] * 8);
			$soma += ($cnpj[7] * 7);
			$soma += ($cnpj[8] * 6);
			$soma += ($cnpj[9] * 5);
			$soma += ($cnpj[10] * 4);
			$soma += ($cnpj[11] * 3);
			$soma += ($cnpj[12] * 2); 
		
			$d2 = $soma % 11; 
			$d2 = $d2 < 2 ? 0 : 11 - $d2; 
			return ($d1.$d2);
	
		}
	}
	
	//função que lista as opções de um campo tipo enum do mysql.
	function enum($tab, $col){
		$con = new bd;
		$con->connect();
		
		$query = "SHOW COLUMNS FROM ".$tab." LIKE '".$col."'";
		$con->query( $query );
		$arr = $con->fetch_array();
		if( $con->num_rows ){
			$arr_retorno = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$arr['Type']));
			foreach( $arr_retorno as $val ){
				$retorno[ $val ] = $val;
			}
		}else{
			$retorno =array(0=>'None');
		}
		return $retorno;
	}
	
	function busca_unidade( $ean ){
		//$ean = intval( $ean );
		$un = "UN";
		if( substr( $ean, 0, 1 ) == "2" ){
			$un = "KG";
		}
		return $un;
	}
	
	/*simula a funcao 'in' do mysql para versoes q não possuem tal funcao.
		PROTOTIPO:
			string in( STRING campo, STRING valor1[,STRING valor2[,STRING valor3]] )
			ou
			string in( STRING campo, ARRAY )
			ou
			string in( STRING campo, VAR string )
		pode receber varios valores, array ou variavel contendo string com valores separados por virgula ou tudo junto.
		pode receber quantos parametros forem necessarios.
		retorna uma string com: ( campo = valor1 OR campo = valor2 OR campo = valor3 )
	*/
	function in(){
		$num_args = func_num_args();
		$args = func_get_args();
		$campo = array_shift( $args );//retira o primeiro elemento( campo da base de dados ) do array e retorna-o.
		$i = $num_param_in = 0;
		
		foreach( $args as $arg ){
			if( is_array( $arg ) ){//se recebe os valores em um array.
				$tmp_arr = $arg;
				foreach( $tmp_arr as $v ){
					$merge_parametros[] = $v;
					$num_param_in ++;
				}
			}elseif( strpos( $arg, "," ) >= 0 ){//se recebe variavel contendo string com valores separados por virgula. Ex $v='a,b,c,2,4,8';
				$tmp_arr = explode( ",", $arg );
				foreach( $tmp_arr as $v ){
					$merge_parametros[] = $v;
					$num_param_in ++;
				}
			}else{//se os parametros sao passados diretamante para a funcao separados por virgula.
				$merge_parametros[] = $arg;
				$num_param_in ++;
			}
		}
// 		exit( print_r( $args ) );
// 		exit( count( $args )." - ".count( $merge_parametros )." - ".$num_param_in );
// 		exit( print_r( $merge_parametros ) );
		$in = " ( ";
		foreach( $merge_parametros as $arg ){
			$i ++;
			$in .= $campo." = '".$arg."'";
			$in .= $i < $num_param_in ? " OR " : "";
		}
		$in .= " ) ";
		return $in;
	}
	
	/*
	 Oposto da funcao 'in'.
	*/
	function not_in(){
		$num_args = func_num_args();
		$args = func_get_args();
		$campo = array_shift( $args );//retira o primeiro elemento( campo da base de dados ) do array e retorna-o.
		$i = $num_param_in = 0;
		
		foreach( $args as $arg ){
			if( is_array( $arg ) ){//se recebe os valores em um array.
				$tmp_arr = $arg;
				foreach( $tmp_arr as $v ){
					$merge_parametros[] = $v;
					$num_param_in ++;
				}
			}elseif( strpos( $arg, "," ) >= 0 ){//se recebe variavel contendo string com valores separados por virgula. Ex $v='a,b,c,2,4,8';
				$tmp_arr = explode( ",", $arg );
				foreach( $tmp_arr as $v ){
					$merge_parametros[] = $v;
					$num_param_in ++;
				}
			}else{//se os parametros sao passados diretamante para a funcao separados por virgula.
				$merge_parametros[] = $arg;
				$num_param_in ++;
			}
		}
// 		exit( print_r( $args ) );
// 		exit( count( $args )." - ".count( $merge_parametros )." - ".$num_param_in );
// 		exit( print_r( $merge_parametros ) );
		$in = " ( ";
		foreach( $merge_parametros as $arg ){
			$i ++;
			$in .= $campo." != '".$arg."'";
			$in .= $i < $num_param_in ? " AND " : "";
		}
		$in .= " ) ";
		return $in;
	}
	
	/*
	Funcao recursiva q busca o codigo da bandeira.
	*/
	function busca_bandeira( $bin, $servico ){
		if( !strlen( $bin ) ){
			return false;
		}
		$con = new bd;
		$con->connect();
		$sql = "
			select
				bin.COD_BANDEIRA,
				band.NOME_BANDEIRA
			from
				".BD_CONTROLE.".BININSTITUICAOBANDEIRA bin
			left join
				".BD_CONTROLE.".BANDEIRA band
			on
				bin.COD_BANDEIRA = band.COD_BANDEIRA
			where
				bin.COD_BIN = '".$bin."' and
				bin.COD_GRUPO_SERVICO = '".( $servico > 4 ? 2 : 1 )."'";
		$con->query($sql);
		if( $con->num_rows ){
			$row = $con->fetch_array();
			return array( $row["COD_BANDEIRA"], $row["NOME_BANDEIRA"] );
		}else{
			return busca_bandeira( substr( $bin, 0, ( strlen( $bin ) -1 )  ), $servico );
		}
	}
	
	function busca_dado_nota( $nronota, $campo ){
		$con = new bd;
		$con->connect();
		$sql = "select dado from ".BD_RETAG.".notafiscal_dados_notas where nronota = ".$nronota." and codigo_campo = ".$campo;
		$con->query($sql);
		$row = $con->fetch_array();
		return $row["dado"];
	}
	
	/*
	Substitui quantos caracteres forem necessarias por outro em uma string.
	Recebe quantos parametros forem necessarios, mas obrigatorioamente o ultimo eh a string eo penultimo o caractere q vai substituir os demais.
	Retorna a string com as substituicoes.
	Ex.
		$string = "Retirar virgulas(,) pontos(.) e asteriscos(*) desta string."
		$string = substitui( ",", ".", "*", "", $string );
		
		Retorna:
		 Retirar virgulas() pontos() e asteriscos() desta string
	*/
	function substitui(){
		$num_args = func_num_args();
		$args = func_get_args();
		$resultado = $args[ ( $num_args - 1 ) ];
		for( $i = 0; $i < ( $num_args - 2 ); $i++ ){
			$resultado = str_replace( $args[$i], $args[ ( $num_args - 2 ) ], $resultado );
		}
		return $resultado;
	}
	
	function casas_decimais_loja( $number, $dec_point = false, $casas_decimais = false ){
		if( $dec_point === false ){
			if( ( strpos( $number, "." ) ) === false ){
				$dec_point=".";
			}else{
				$dec_point="";
			}
		}
		if( $casas_decimais === false ){
			if( isset( $_SESSION["LOJA"]["CASASDECIMAIS"] ) ){
				$casas_decimais = $_SESSION["LOJA"]["CASASDECIMAIS"];
			}else{
				$con = new bd;
				$con->connect();
				
				$sql = "LOCK TABLES ".BD_CONTROLE.".pf_loja WRITE";
				$con->query($sql);
				
				$sql = "select casas_decimais from ".BD_CONTROLE.".pf_loja";
				$con->query($sql);
				
				$row = $con->fetch_array();
				$casas_decimais = $row["casas_decimais"];
				
				$sql = "UNLOCK TABLES;";
				$con->query($sql);
			}
		}
// 		exit("casas dec -> ".$casas_decimais." <-");
		$number = substitui( ",", ".", ";", " ", "", $number );
		$divide_by = ( $casas_decimais == 3 ) ? 1000 : 100;
		return number_format( ( $number / $divide_by ), $casas_decimais, $dec_point, "" );
	}
	
	function exibe_valor( $number, $dec_point = "," ){
		if( isset( $_SESSION["LOJA"]["CASASDECIMAIS"] ) ){
			$casas_decimais = $_SESSION["LOJA"]["CASASDECIMAIS"];
		}else{
			$con = new bd;
			$con->connect();
			
			$sql = "LOCK TABLES ".BD_CONTROLE.".pf_loja WRITE";
			$con->query($sql);
			
			$sql = "select casas_decimais from ".BD_CONTROLE.".pf_loja";
			$con->query($sql);
			
			$row = $con->fetch_array();
			$casas_decimais = $row["casas_decimais"];
			
			$sql = "UNLOCK TABLES;";
			$con->query($sql);
		}
		return number_format( $number, $casas_decimais, $dec_point, "" );
	}
	
	function grava_aplu( $cod, $imediata = false, $codigoint=false ){
		$con = new bd;
		$con->connect();
		
		$sql = "
			LOCK TABLES
				".BD_RETAG.".mercador a WRITE,
				".BD_RETAG.".PluDif b WRITE,
				".BD_CONTROLE.".conf_pludif cp WRITE
			;";
		$con->query($sql);
		
		// busca dados da mercadoria para gravacao no arq
		if( $codigoint === "only" ){
			$condicao = " a.codigoint = '".$cod."' ";
		}else if( $codigoint === false ){
			$condicao = " a.codigoean = '".$cod."' ";
		}else if( is_int( $codigoint ) ){
			$condicao = " a.codigoean = '".$cod."' and a.codigoint = '".$codigoint."' ";
		}
		$sql = "
			SELECT
				a.codigoean,
				a.codigoint,
				a.descricao,
				a.depto AS secao,
				a.tributacao,
				a.valor,
				a.precooferta,
				a.codvasil,
				a.valorvasil,
				a.desconto,
				a.fundos,
				IFNULL(b.percentualplu2, 0) AS perc_plu2,
				IFNULL(b.percentualplu3, 0) AS perc_plu3,
				cp.percPLU2 as perc_plu2_padrao,
				cp.percPLU3 as perc_plu3_padrao,
				a.eanassociado
			FROM ".
				BD_RETAG.".mercador AS a
			LEFT JOIN ".
				BD_RETAG.".PluDif AS b
			ON
				a.codigoean = b.codigoean
			LEFT JOIN
				".BD_CONTROLE.".conf_pludif AS cp
			ON
				1=1
			WHERE
				".$condicao;
		
		$con->query($sql);
		
		if( $con->num_rows ){
			
			$file_bplu = fopen("/servidor/bplui_loc.txt", "ab");
			
			if( $imediata ){
				$file_log_imediata = fopen("/servidor/log.imediata.".date("Ymd"), "a");
			}
			
			while( $row = $con->fetch_array() ){
				if( $row["precooferta"] > 0 ){
					$preco_unitario = $row["precooferta"];
				}else{
					$preco_unitario = $row["valor"];
				}
				
				if( $row["perc_plu2"] > 0 ){
					$preco_unitario2 = exibe_valor( exibe_valor( $row["valor"], "." ) - ( exibe_valor( $row["valor"], "." ) * ( $row["perc_plu2"] /100 ) ), "" );
				}elseif( $row["perc_plu2"] == 0 ){
					$preco_unitario2 = exibe_valor(exibe_valor($row["valor"], ".") - (exibe_valor($row["valor"], ".")*($row["perc_plu2_padrao"] / 100)), "");
				}
				
				if( $row["perc_plu3"] > 0 ){
// 					$preco_unitario3 = ( casas_decimais_loja($row["valor"]) - ( casas_decimais_loja($row["valor"]) * ( $row["perc_plu3"] / 100 ) ) );
					$preco_unitario3 = exibe_valor(exibe_valor($row["valor"], ".") - (exibe_valor($row["valor"], ".")*($row["perc_plu3"] / 100)), "");
				}elseif( $row["perc_plu3"] == 0 ){
					$preco_unitario3 = exibe_valor(exibe_valor($row["valor"], ".") - (exibe_valor($row["valor"], ".")*($row["perc_plu3_padrao"] / 100)), "");
// 					$preco_unitario3 = ( casas_decimais_loja($row["valor"]) - ( casas_decimais_loja($row["valor"]) * ( $row["perc_plu3_padrao"] / 100 ) ) );
				}
				
				if( $preco_unitario < $preco_unitario2 ){
					$preco_unitario2 = $preco_unitario;
				}
				
				if( $preco_unitario < $preco_unitario3 ){
					$preco_unitario3 = $preco_unitario;
				}
				
				$buffer =
					str_pad( substr( $row["codigoint"], 0, 6 ) , 6, 0, STR_PAD_LEFT).
					str_pad($row["codigoean"], 13, "#").
					str_pad($row["descricao"], 30, " ").
					str_pad($row["tributacao"], 1, "I").
					str_pad($row["secao"]+0, 2, 0, STR_PAD_LEFT).
					"0".
					"0".
					"0".
					sprintf( "%09s", substitui( ",", ".", "", number_format( $preco_unitario, 3, "", "" ) ) ).
					str_pad($row["codvasil"], 12, 0, STR_PAD_LEFT).
					str_pad($row["valorvasil"], 9, 0, STR_PAD_LEFT).
					str_pad($row["desconto"], 6, 0, STR_PAD_LEFT).
					str_pad($row["fundos"], 3, 0, STR_PAD_LEFT).
					sprintf( "%09s", substitui( ",", ".", "", number_format( $preco_unitario2, 3, "", "" ) ) ).
					sprintf( "%09s", substitui( ",", ".", "", number_format( $preco_unitario3, 3, "", "" ) ) ).
					str_pad($row["eanassociado"], 13, '0').
					"\n"
				;
				
				fwrite($file_bplu, $buffer, strlen($buffer));
				
				if( $imediata ){
					$sql .= "\r\n";
					fwrite($file_log_imediata, $sql, strlen($sql));
				}
			}
			fclose($file_bplu);
			if( $imediata ){
				fclose($file_log_imediata);
			}
		}
		
		$sql = "UNLOCK TABLES;";
		$con->query($sql);
	}
	
	function formata_quantidade( $quantidade ){
		$arr_quant = explode( ".", $quantidade );
		if( $arr_quant[1] > 0 ){
			$quant = $arr_quant[0].".".$arr_quant[1];
		}else{
			$quant = $arr_quant[0];
		}
		return $quant;
	}
	
	function valida_ean( $ean ){
// 		$ean = $ean+0;
// 		$ean = $ean."";
		$ean = preg_replace( "'^(0)*'", '', $ean );//retira zeros do inicio.
		if( strlen( $ean ) > limiteDv() ){
			$digito_no_ean = substr( $ean, -1 );
			for( $i = 11; $i >= 0; $i-- ){
				$somatorio += ( $ean{$i} * ( ( $i % 2 == 0 ) ? 1 : 3 ) );
			}
			$resultado_do_mod = 10 - ( $somatorio % 10 );
			$digito = $resultado_do_mod == 10 ? 0 : $resultado_do_mod;
	// 		echo $digito_no_ean." == ".$digito;
			if( $digito_no_ean == $digito ){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
	
	function formata_ean( $ean, $tipo = "gravacao" ){
		if( $tipo == "gravacao" ){
			$ean = preg_replace( "'^(0)*'", '', $ean );//retira zeros do inicio.
			if( strlen( $ean ) > limiteDv() ){
				if( valida_ean( $ean ) !== false ){
					$ean_formatado = "0".substr( $ean, 0, -1 );
				}else{
					$ean_formatado = null;
				}
			}else{
				$ean_formatado = str_pad( $ean, 13, 0, STR_PAD_LEFT );
			}
		}else if( $tipo == "consulta" ){
			for( $i = 12; $i > 0; $i-- ){
				$somatorio += ( $ean{$i} * ( ( $i % 2 == 0 ) ? 3 : 1 ) );
			}
			$resultado_do_mod = 10 - ( $somatorio % 10 );
			$digito = $resultado_do_mod == 10 ? 0 : $resultado_do_mod;
			$ean_formatado= substr( $ean, 1, ( strlen( $ean ) ) ).$digito;
		}else if( $tipo == "pocket" ){
			$tmp_ean = formata_ean( $ean, "consulta" );
			$tmp_ean = preg_replace( "'^(0)*'", '', $tmp_ean );//retira zeros do inicio.
			if( strlen( ( $tmp_ean ) ) > limiteDv() ){
				$ean_formatado = $tmp_ean;
			}else{
				$ean_formatado = $ean;
			}
		}
		return $ean_formatado;
	}
	
	function ean_existe_no_mercador( $ean ){
		$ean += 0;
		$con = new bd;
		$con->connect();
		if( strlen( $ean ) > limiteDv() ){
			$ean = substr( $ean, 0, -1 );
		}
		$ean = str_pad( $ean, 13, "0", STR_PAD_LEFT );
		$sql_consiste = "select count(1) as num_reg from ".BD_RETAG.".mercador where codigoean = '".$ean."'";
		$con->query( $sql_consiste );
		if( $con->num_rows ){
			$row = $con->fetch_array();
			if( $row["num_reg"] > 0 ){
				return true;
			}
		}
		return false;
	}
	
	function combo( $nome, $valores, $selecionar, $chaves_e_valores_sao_iguais = false, $extra = "" ){
		$combo = "<select name=\"".$nome."\" id=\"".$nome."\" class=\"meio\" ".$extra." >\r\n";
		if( !is_array( $valores ) ){
			$con = new bd;
			$con->connect();
			
			/*gambiarra para clientes com versoes de mysql q não suportam 'union'*/
			$arr_tmp = preg_split( '[union]i', $valores );
			$query_principal = $arr_tmp[0];
			$union = $arr_tmp[1];
			
			if( $union ){
				$arr_tmp_order = preg_split( '[order by]i', $union );
				$order_by = $arr_tmp_order[1];
				$con->query( $arr_tmp_order[0] );
				$row = $con->fetch_array();
				$combo .= "<option value=\"".$row[0]."\" ".( $row[0] == $selecionar ? "selected= \"selected\"" : "" )." >".$row[1]."</option>\r\n";
			}
// 			echo ( $query_principal.( $order_by ? " order by ".$order_by : "" ) );
// 			echo "<br />";
// 			echo $union;
// 			echo "<br />";
// 			echo $arr_tmp_order[0];
// 			echo "<br />";
			
			$con->query( $query_principal.( $order_by ? " order by ".$order_by : "" ) );
			if( $con->num_rows ){
				while( $row = $con->fetch_array() ){
					$descricao = $row[1];
					$valor = $chaves_e_valores_sao_iguais === true ? $row[1] : $row[0];
					$combo .= "<option value=\"".$valor."\" ".( $valor == $selecionar ? "selected= \"selected\"" : "" )." >".$descricao."</option>\r\n";
				}
			}
		}else{
			foreach( $valores as $valor=>$descricao ){
				$valor = $chaves_e_valores_sao_iguais === true ? $descricao : $valor;
				$combo .= "<option value=\"".$valor."\" ".( $valor == $selecionar ? "selected= \"selected\"" : "" )." >".$descricao."</option>\r\n";
			}
		}
		$combo .= "</select>";
		return $combo;
	}
	
	function subtrai_data( $dti, $dtf ){
		list( $di, $mi, $ai ) = explode( "/", $dti );
		list( $df, $mf, $af ) = explode( "/", $dtf );
		$timestamp_i = mktime( 0, 0, 0, $mi, $di, $ai );
		$timestamp_f = mktime( 0, 0, 0, $mf, $df, $af );
		
		//24 horas * 60 Min * 60 seg = 86400.
		return ceil( abs( ( $timestamp_f - $timestamp_i ) / 86400 ) );
	}
	
?>
