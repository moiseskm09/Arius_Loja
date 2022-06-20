<?php
date_default_timezone_set('America/Sao_Paulo'); // Hora oficial do Brasil.
include("config/config_geral.php");
$dataAtual = date('Y-m-d') ;
$sql=mysqli_query ($conexao, "SELECT loja, data, dataenvio FROM conciliacao");
$resultado = mysqli_num_rows($sql);


if ($resultado > 0 ) {
while($mostrar = mysqli_fetch_array($sql)) {
if($mostrar['data'] != $dataAtual ){
$divergente=$mostrar["loja"];
$divergentedata=$mostrar['data'];
$conteudo = "";
$conteudo .= "".PHP_EOL;
$conteudo = "Loja: $divergente - Data último envio: $divergentedata ";
$conteudo .= "".PHP_EOL;
$name = "divergente.txt";
$file = fopen ($name, 'a+'); 
fwrite($file, $conteudo);
fclose($file);

} else {
	
	
	}
}

} else {
		
		}
		
		
		
  if ($resultado > 0 ) {
  if (file_exists($name)) {
		# -------------- Inicicio envio de email --------------
# Exemplo de envio de e-mail SMTP PHPMailer - www.secnet.com.br
#
# Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
  require("PHPMailer/src/PHPMailer.php");
  require("PHPMailer/src/SMTP.php");
  require ("PHPMailer/src/Exception.php");

$mail = new PHPMailer\PHPMailer\PHPMailer();

# Define os dados do servidor e tipo de conexão
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = "smtp.arius.com.br"; # Endereço do servidor SMTP
$mail->Port = 587; // Porta TCP para a conexão
$mail->SMTPAutoTLS = false; // Utiliza TLS Automaticamente se disponível
$mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
$mail->Username = 'moises.rosario@arius.com.br'; # Usuário de e-mail
$mail->Password = 'Ema121213'; // # Senha do usuário de e-mail

# Define o remetente (você)
$mail->From = "moises.rosario@arius.com.br"; # Seu e-mail
$mail->FromName = "SIGA - Sistema Integrado de Gestão Arius"; // Seu nome

# Define os destinatário(s)
$mail->AddAddress('moises.rosario@arius.com.br', 'Moises'); # Os campos podem ser substituidos por variáveis
$mail->AddAddress('douglas@arius.com.br', 'Douglas');
$mail->AddAddress('rafael.marchesi@arius.com.br', 'Rafael');
$mail->AddAddress('jorge.souza@arius.com.br', 'Jorge');
#$mail->AddAddress('email'); # Caso queira receber uma copia
#$mail->AddCC('email', 'nome'); # Copia
#$mail->AddBCC('email', 'nome'); # Cópia Oculta

# Define os dados técnicos da Mensagem
$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
$mail->CharSet = 'UTF-8'; # Charset da mensagem (opcional)

# Define a mensagem (Texto e Assunto)
$mail->Subject = "Lojas pendente de envio para FTP"; # Assunto da mensagem
$mail->Body = "Segue em anexo listagem das lojas que não enviaram os arquivos de conciliação para FTP <br> Por favor verifiquem. <br>  <br> <br> Sistema Integrado de Gestão Arius . <br> <br> Nao responda, esta mensagem foi gerada automaticamente. ";
$mail->AltBody = "oi  \r\n :)";

# Define os anexos (opcional)
#$mail->AddAttachment("C:\Users\Moises\Documents\arius\teste.txt", "teste.txt"); # Insere um anexo
$mail->addAttachment("$name");//anexa o arquivo


# Envia o e-mail
$enviado = $mail->Send();

# Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

#-------------------- fim envio de email -----------------
		
		
	unlink($name);
	
		}else {
		
		# -------------- Inicicio envio de email --------------
# Exemplo de envio de e-mail SMTP PHPMailer - www.secnet.com.br
#
# Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
  require("PHPMailer/src/PHPMailer.php");
  require("PHPMailer/src/SMTP.php");
  require ("PHPMailer/src/Exception.php");

$mail = new PHPMailer\PHPMailer\PHPMailer();

# Define os dados do servidor e tipo de conexão
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = "smtp.arius.com.br"; # Endereço do servidor SMTP
$mail->Port = 587; // Porta TCP para a conexão
$mail->SMTPAutoTLS = false; // Utiliza TLS Automaticamente se disponível
$mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
$mail->Username = 'moises.rosario@arius.com.br'; # Usuário de e-mail
$mail->Password = 'Ema121213'; // # Senha do usuário de e-mail

# Define o remetente (você)
$mail->From = "moises.rosario@arius.com.br"; # Seu e-mail
$mail->FromName = "SIGA - Sistema Integrado de Gestão Arius"; // Seu nome

# Define os destinatário(s)
$mail->AddAddress('moises.rosario@arius.com.br', 'Moises'); # Os campos podem ser substituidos por variáveis
$mail->AddAddress('douglas@arius.com.br', 'Douglas');
$mail->AddAddress('rafael.marchesi@arius.com.br', 'Rafael');
$mail->AddAddress('jorge.souza@arius.com.br', 'Jorge');
#$mail->AddAddress('email'); # Caso queira receber uma copia
#$mail->AddCC('email', 'nome'); # Copia
#$mail->AddBCC('email', 'nome'); # Cópia Oculta

# Define os dados técnicos da Mensagem
$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
$mail->CharSet = 'UTF-8'; # Charset da mensagem (opcional)

# Define a mensagem (Texto e Assunto)
$mail->Subject = "Arquivos de Conciliação - OK "; # Assunto da mensagem
$mail->Body = "Parabéns. <br> Todos os arquivos foram enviados para FTP. <br>  <br> <br> Sistema Integrado de Gestão Arius . <br> <br> Nao responda, esta mensagem foi gerada automaticamente.";
$mail->AltBody = "oi  \r\n :)";

# Define os anexos (opcional)
#$mail->AddAttachment("C:\Users\Moises\Documents\arius\teste.txt", "teste.txt"); # Insere um anexo
#$mail->addAttachment("$name");//anexa o arquivo


# Envia o e-mail
$enviado = $mail->Send();

# Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

#-------------------- fim envio de email -----------------
		}
		}
		
	?>
					
				
					
					
					
					
					