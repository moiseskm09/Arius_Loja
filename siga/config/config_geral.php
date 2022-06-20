<?php
//verifica se a sessão é valida
session_cache_expire(3);
$cache_expire = session_cache_expire();

session_start();

session_regenerate_id();
// Define sessão para o usuário logado
$usuario_logado = $_SESSION["usuario"];
$nivel_logado = $_SESSION["niveldeacesso"];
$senha_logado = $_SESSION["senha"];
$nome_logado = $_SESSION["nome"];

if (!isset($usuario_logado) || !isset ($nivel_logado) || !isset ($senha_logado)) {
	header("Location: index.html");
	exit;
} else {
}

// versao do sistema
define("versao_sistema", "2.0",TRUE);


//Configuração para envio de email
$smtp_email = "smtp.arius.com.br"; // Endereço do servidor SMTP
$porta_email = "587"; // Porta TCP para a conexão
$remetente_email = 'moises.rosario@arius.com.br'; # Usuário de e-mail
$senha_email = 'Ema121213'; // # Senha do usuário de e-mail


//Destinatário de email de erro na geração de conciliação local e envio para ftp
$destinatario1 = "moises.rosario@arius.com.br";
$destinatario2 = "rafael.marchesi@arius.com.br";
$destinatario3 = "douglas@arius.com.br";
$destinatario4 = "ana.rafaela@arius.com.br";
$destinatario5 = "erisvaldo.silva@arius.com.br";


//informações de compartilhamento 

$Servidor_compartilhamento = "10.100.0.34";
$diretorio_compartilhamento_remoto = "/d/backup/";
$diretorio_compartilhamento_local = "/var/www/compartilhamento/";
$usuario_compartilhamento_remoto = "cre";
$senha_compartilhamento_remoto = "juntec";


?>


