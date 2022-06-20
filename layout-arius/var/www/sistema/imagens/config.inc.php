<?php

//configuração de desenvolvimento
if ($_SERVER["SERVER_NAME"] == "InforServerLnx.localdomain") {
	// definicoes do banco
	define("HOST", "192.168.0.8");
	define("USER", "root");
	define("PASSWORD", "123456");
	define("BD_DEFAULT", "retag");
	define("BD_CONTROLE", "controle");
	define("BD_RETAG", "retag");
	define("BD_NOTAS", "notas");
	define("BD_SGDADOS", "sgdados");
	define("BD_SGLITE", "sglite");

	//diretório da aplicação
	define("DIRETORIO_APLICACAO", "/retaguarda");

//Configuração de teste
} else if ($_SERVER["SERVER_NAME"] == "neptune.localdomain") {
	// definicoes do banco
	define("HOST", "192.168.0.8");
	define("USER", "root");
	define("PASSWORD", "123456");
	define("BD_DEFAULT", "retag");
	define("BD_CONTROLE", "controle");
	define("BD_RETAG", "retag");
	define("BD_NOTAS", "notas");
	define("BD_SGDADOS", "sgdados");
	define("BD_SGLITE", "sglite");

	//diretório da aplicação
	define("DIRETORIO_APLICACAO", "/bleh/retaguarda");

//Configuração de Produção
} else {
		// definicoes do banco
	define("HOST", "localhost");
	define("USER", "root");
	define("PASSWORD", "123456");
	define("BD_DEFAULT", "retag");
	define("BD_CONTROLE", "controle");
	define("BD_RETAG", "retag");
	define("BD_NOTAS", "notas");
	define("BD_SGDADOS", "sgdados");
	define("BD_SGLITE", "sglite");
	define("BD_IBI", "ibi");
	define("CON_ORACLE","(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=192.168.0.24)(PORT=1521))(CONNECT_DATA=(SID=XE)))");
	define("USER_ORACLE", "SYSTEM");
	define("PASSWORD_ORACLE", "123456");
	
	//diretório da aplicação
	define("DIRETORIO_APLICACAO", "");
}

//Configuração PADRÃO
define("LOCAL_PATH", "http://".$_SERVER["HTTP_HOST"].DIRETORIO_APLICACAO."/");
define("PATH", "http://".$_SERVER["HTTP_HOST"]."/");

if (empty($_SERVER["DOCUMENT_ROOT"])) {
	define("DOCUMENT_ROOT", dirname($_SERVER["SCRIPT_NAME"]).DIRETORIO_APLICACAO."/");
} else {
	define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"].DIRETORIO_APLICACAO."/");
}
define('INC_DIR', DOCUMENT_ROOT.'sistema');

define('INC_PATH', 'http://'.$_SERVER["HTTP_HOST"].DIRETORIO_APLICACAO.'/sistema');
define('IMAGE_PATH', 'http://'.$_SERVER["HTTP_HOST"].DIRETORIO_APLICACAO.'/sistema/imagens/');
define("JS_PATH", 'http://'.$_SERVER["HTTP_HOST"].DIRETORIO_APLICACAO.'/sistema/js' );

ini_set('include_path', INC_DIR."/PEAR/");

//tipos de impressora para etiquetas.
$_SESSION["IMP_ETIQUETAS"] = array( 1=>"Argox", 2=>"Allegro", 3=>"Arquivo", 4=>"Allegro Pró" );
asort( $_SESSION["IMP_ETIQUETAS"] );

$_SESSION["TIPO_PDV"] = array( 1=>"Fiscal", 2=>"Treinamento", 3=>"Tira-teima", 4=>"Lancheria" );

define("MSG2", "*Campos obrigatórios");
define("MSG3", "Registro excluído com sucesso!");
define("MSG4", "Registro incluído com sucesso!");
define("MSG5", "Registro alterado com sucesso!");
define("MSG6", "Não é possível excluir. Seu nível de acesso atual não permite essa ação.");


//versão do sistema de retaguarda
define("VERSAO", "2.0r24 17-09-2008");
?>
