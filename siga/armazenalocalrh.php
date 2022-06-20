<?php
include ("config/conexao.php");

$data = date ('d-m-Y H:i:s');
$dataatual = date ('dmY');
$lojarh=$_POST['lojarh'];
$select=mysqli_query ($conexao, "SELECT lojapdv FROM clientes WHERE lojasap=$lojarh");
$exibe = mysqli_fetch_assoc($select);
$lojapdv=$exibe["lojapdv"];
$datarh=$_POST['datarh'];
//transformar data no formato ddmmaaaa
$dataRh = explode('-', $datarh);
$dataRH = $dataRh[2].''.$dataRh[1].''.$dataRh[0];
$arquivorh="tefconsRHLJ$lojapdv$dataRH.txt"; 
$DIR="/siga/RH/$arquivorh";
$nome= $usuario_sessao;
$nome= $_SESSION['usuario'];



if ($lojarh > 0 ) {
  if (file_exists($DIR)) {
// ﻿We'll be outputting a PDF
header("Content-type: $DIR");

// It will be called downloaded.pdf
header("Content-Disposition: attachment; filename=$arquivorh");

// The PDF source is in original.pdf
readfile("$DIR");    

$conteudo = "";
$conteudo .= "".PHP_EOL;
$conteudo .= "____________________________________________________________".PHP_EOL;
$conteudo .= "Loja: $lojarh - Data de Geracao $data".PHP_EOL;
$conteudo .= "Arquivo gerado: $arquivorh".PHP_EOL;
$conteudo .= "Data do arquivo gerado: $datarh".PHP_EOL;
$conteudo .= "usuario geracao: $nome".PHP_EOL;
$conteudo .= "____________________________________________________________".PHP_EOL;
$name = "/var/www/log/gera_local$dataatual.txt";
$file = fopen ($name, 'a+'); 
fwrite($file, $conteudo);
fclose($file);

      } else {
       
         
header("location: geraconciliacaolocal.php?erro=1");


# -------------- Inicio envio de email --------------
# Exemplo de envio de e-mail SMTP PHPMailer
#
# Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
  require("PHPMailer/src/PHPMailer.php");
  require("PHPMailer/src/SMTP.php");

    $mail = new PHPMailer\PHPMailer\PHPMailer();

# Define os dados do servidor e tipo de conexão
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = $smtp_email; # Endereço do servidor SMTP
$mail->Port = $porta_email; // Porta TCP para a conexão
$mail->SMTPAutoTLS = false; // Utiliza TLS Automaticamente se disponível
$mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
$mail->Username = $remetente_email; # Usuário de e-mail
$mail->Password = $senha_email; // # Senha do usuário de e-mail

# Define o remetente (você)
$mail->From = $remetente_email; # Seu e-mail
$mail->FromName = "SIGA - Sistema Integrado de Gestão Arius"; // Seu nome

# Define os destinatário(s)
$mail->AddAddress($destinatario1); # Os campos podem ser substituidos por variáveis
$mail->AddAddress($destinatario2); # Os campos podem ser substituidos por variáveis
$mail->AddAddress($destinatario3); # Os campos podem ser substituidos por variáveis
$mail->AddAddress($destinatario4); # Os campos podem ser substituidos por variáveis
$mail->AddAddress($destinatario5); # Os campos podem ser substituidos por variáveis

#$mail->AddAddress('email'); # Caso queira receber uma copia
#$mail->AddCC('email', 'nome'); # Copia
#$mail->AddBCC('email', 'nome'); # Cópia Oculta


# Define os dados técnicos da Mensagem
$mail->IsHTML(true); # Define que o e-mail será enviado como HTML
$mail->CharSet = 'UTF-8'; # Charset da mensagem (opcional)

# Define a mensagem (Texto e Assunto)
$mail->Subject = "Loja: $lojarh - Arquivo não encontrado no SIGA"; # Assunto da mensagem

$mail->Body = "

<div class='es-wrapper-color' style='background-color:#F6F6F6;'> 
   <!--[if gte mso 9]>
			<v:background xmlns:v='urn:schemas-microsoft-com:vml' fill='t'>
				<v:fill type='tile' color='#f6f6f6'></v:fill>
			</v:background>
		<![endif]--> 
   <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;'> 
     <tr style='border-collapse:collapse;'> 
      <td valign='top' style='padding:0;Margin:0;'> 
       <table class='es-header' cellspacing='0' cellpadding='0' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;'> 
         <tr style='border-collapse:collapse;'> 
          <td align='center' style='padding:0;Margin:0;background-position:left top;'> 
           <table class='es-header-body' width='600' cellspacing='0' cellpadding='0' bgcolor='#efefef' align='center' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#EFEFEF;'> 
             <tr style='border-collapse:collapse;'> 
              <td align='left' style='padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;'> 
               <!--[if mso]><table width='560' cellpadding='0'
                            cellspacing='0'><tr><td width='180' valign='top'><![endif]--> 
               <table class='es-left' cellspacing='0' cellpadding='0' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;'> 
                 <tr style='border-collapse:collapse;'> 
                  <td class='es-m-p0r es-m-p20b' width='180' valign='top' align='center' src='https://i.ibb.co/GWBvBp3/logo2-siga.png' style='padding:0;Margin:0;'> 
                   <table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='center' style='padding:0;Margin:0;'><img class='adapt-img' src='https://i.ibb.co/GWBvBp3/logo2-siga.png' alt style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' width='180'></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width='20'></td><td width='360' valign='top'><![endif]--> 
               <table cellspacing='0' cellpadding='0' align='right' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                 <tr style='border-collapse:collapse;'> 
                  <td width='360' align='left' style='padding:0;Margin:0;'> 
                   <table width='100%' cellspacing='0' cellpadding='0' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                    <tbody class='ui-droppable-hover'> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='center' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><strong>SIGA - SISTEMA INTEGRADO DE GESTÃO ARIUS</strong></p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table> 
               <!--[if mso]></td></tr></table><![endif]--></td> 
             </tr> 
             <tr style='border-collapse:collapse;'> 
              <td align='left' style='padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;'> 
               <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                 <tr style='border-collapse:collapse;'> 
                  <td width='560' align='center' valign='top' style='padding:0;Margin:0;'> 
                   <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#333333;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#333333;'>O arquivo<strong><span style='color:#FF0000;'> $arquivorh </span></strong>não foi encontrado no SIGA!</p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#333333;'><br></p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
             <tr style='border-collapse:collapse;'> 
              <td align='left' style='padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;'> 
               <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                 <tr style='border-collapse:collapse;'> 
                  <td width='560' align='center' valign='top' style='padding:0;Margin:0;'> 
                   <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#333333;'>Dados da geração:</p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
             <tr style='border-collapse:collapse;'> 
              <td align='left' style='padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;'> 
               <!--[if mso]><table width='560' cellpadding='0' cellspacing='0'><tr><td width='194' valign='top'><![endif]--> 
               <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;'> 
                 <tr style='border-collapse:collapse;'> 
                  <td width='174' class='es-m-p0r es-m-p20b' align='center' style='padding:0;Margin:0;'> 
                   <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><strong>LOJA:</strong></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica, sans-serif;line-height:21px;color:#3D4C9D;'></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#FF0000;'><strong>$lojarh</strong></p></td> 
                     </tr> 
                   </table></td> 
                  <td class='es-hidden' width='20' style='padding:0;Margin:0;'></td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width='173' valign='top'><![endif]--> 
               <table cellpadding='0' cellspacing='0' class='es-left' align='left' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;'> 
                 <tr style='border-collapse:collapse;'> 
                  <td width='173' class='es-m-p20b' align='center' style='padding:0;Margin:0;'> 
                   <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><strong>Data do Arquivo:</strong></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#FF0000;'><strong>$datarh</strong></p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width='20'></td><td width='173' valign='top'><![endif]--> 
               <table cellpadding='0' cellspacing='0' class='es-right' align='right' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;'> 
                 <tr style='border-collapse:collapse;'> 
                  <td width='173' align='center' style='padding:0;Margin:0;'> 
                   <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><strong>Arquivo:</strong></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#FF0000;'><strong>$arquivorh</strong></p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table> 
               <!--[if mso]></td></tr></table><![endif]--></td> 
             </tr> 
             <tr style='border-collapse:collapse;'> 
              <td align='left' style='padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;'> 
               <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                 <tr style='border-collapse:collapse;'> 
                  <td width='560' align='center' valign='top' style='padding:0;Margin:0;'> 
                   <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><span style='color:#696969;'></span><strong>Observações:</strong><span style='color:#000000;'>Tentativa de geração local do arquivo</span><strong><span style='color:#FF0000;'> $arquivorh</span></strong></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#FF0000;'></p></td> 
                     </tr> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='center' style='padding:0;Margin:0;'><img class='adapt-img' src='https://i.ibb.co/GWBvBp3/logo2-siga.png' alt style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;' width='115'></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
             <tr style='border-collapse:collapse;'> 
              <td align='left' style='padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;'> 
               <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                 <tr style='border-collapse:collapse;'> 
                  <td width='560' align='center' valign='top' style='padding:0;Margin:0;'> 
                   <table cellpadding='0' cellspacing='0' width='100%' style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'> 
                     <tr style='border-collapse:collapse;'> 
                      <td align='center' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#333333;'>Gerado automaticamente pelo sistema. Não responda.<br></p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table></td> 
     </tr> 
   </table> 
  </div>  




";

$mail->AltBody = "O arquivo $arquivorh não foi encontado no SIGA! <br><br> Dados da Geração: <br> Loja: $lojarh <br> Data do arquivo: $datarh  <br> Arquivo: $arquivorh <br>  \r\n :)";

# Define os anexos (opcional)
#$mail->AddAttachment("c:/temp/documento.pdf", "documento.pdf"); # Insere um anexo

# Envia o e-mail
$enviado = $mail->Send();

# Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

#-------------------- fim envio de email -----------------
      
$conteudo = "";
$conteudo .= "".PHP_EOL;
$conteudo .= "____________________________________________________________".PHP_EOL;
$conteudo .= "Loja: $lojarh - Data de Geracao $data".PHP_EOL;
$conteudo .= "Arquivo gerado: $arquivorh".PHP_EOL;
$conteudo .= "Data do arquivo gerado: $datarh".PHP_EOL;
$conteudo .= "usuario geracao: $nome".PHP_EOL;
$conteudo .= "____________________________________________________________".PHP_EOL;
$name = "/var/www/log/gera_local$dataatual.txt";
$file = fopen ($name, 'a+'); 
fwrite($file, $conteudo);
fclose($file);
   
   }
}

?>﻿﻿﻿
