<?php
date_default_timezone_set('America/Sao_Paulo'); // Hora oficial do Brasil.
include("menu.php");
include ("config/conexao.php");

error_reporting(0);
ini_set(“display_errors”, 0 );

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Reenviar Conciliação FTP</title>
          <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
	
	<script>
	$(function () {
                //Comportamento do botao de disparo
                $('#enviar').click(function () {
                    getResponse();
                });
            });
            /**
             * Dispara o modal e espera a resposta do script 'testing.resp.php'
             * @returns {void}
             */
            function getResponse() {
                //Preenche e mostra o modal
                $('#loadingModal_content').html('Carregando...');
                $('#loadingModal').modal('show');
                //Envia a requisicao e espera a resposta
                $.post("reenviar.php")
                    .done(function () {
                        //Se nao houver falha na resposta, preenche o modal
                        $('#loader').removeClass('loader');
                        $('#loader').addClass('glyphicon glyphicon-ok');
                        $('#loadingModal_label').html('Sucesso!');
                        $('#loadingModal_content').html('<br>Arquivo enviado!');
                        resetModal();
                    })
                    .fail(function () {
                        //Se houver falha na resposta, mostra o alert
                        $('#loader').removeClass('loader');
                        $('#loader').addClass('glyphicon glyphicon-remove');
                        $('#loadingModal_label').html('Falha!');
                        $('#loadingModal_content').html('<br>arquivo  não econtrado!');
                        resetModal();
                    });
            }
            function resetModal(){
                //Aguarda 2 segundos ata restaurar e fechar o modal
                setTimeout(function() {
                    $('#loader').removeClass();
                    $('#loader').addClass('loader');
                    $('#loadingModal_label').html('<span class="glyphicon glyphicon-refresh"></span>Aguarde...');
                    $('#loadingModal').modal('hide');
                }, 3000);
            }
        </script>
		
		<script>
	$(function () {
                //Comportamento do botao de disparo
                $('#enviarpb').click(function () {
                    getResponse();
                });
            });
            /**
             * Dispara o modal e espera a resposta do script 'testing.resp.php'
             * @returns {void}
             */
            function getResponse() {
                //Preenche e mostra o modal
                $('#loadingModal_content').html('Enviando...');
                $('#loadingModal').modal('show');
                //Envia a requisicao e espera a resposta
                $.post("reenviar.php")
                    .done(function () {
                        //Se nao houver falha na resposta, preenche o modal
                        $('#loader').removeClass('loader');
                        $('#loader').addClass('glyphicon glyphicon-ok');
                        $('#loadingModal_label').html('Sucesso!');
                        $('#loadingModal_content').html('<br>Arquivo enviado!');
						
                        resetModal();
                    })
                    .fail(function () {
                        //Se houver falha na resposta, mostra o alert
                        $('#loader').removeClass('loader');
                        $('#loader').addClass('glyphicon glyphicon-remove');
                        $('#loadingModal_label').html('Falha!');
                        $('#loadingModal_content').html('<br>arquivo  não econtrado!');
                        resetModal();
                    });
            }
            function resetModal(){
                //Aguarda 2 segundos ata restaurar e fechar o modal
                setTimeout(function() {
                    $('#loader').removeClass();
                    $('#loader').addClass('loader');
                    $('#loadingModal_label').html('<span class="glyphicon glyphicon-refresh"></span>Aguarde...');
                    $('#loadingModal').modal('hide');
                }, 3000);
            }
        </script>
   </head>
  <body>

<div class="container-fluid">
<div class="row">
    <div class="col-md-12 text-center alert alert-warning">
       <span><strong>Atenção!</strong> Só poderão ser enviados arquivos que foram gerados no mês atual!</span>
      </div>
</div>

  <div class="row" style="padding-top: 120px;">

    <div class="col-5">
     <legend> Preencha aqui para RI HAPPY</legend> 
     <div class="box_rihappy">
<form id="reenviar" method="post" action="">
<div class="form-group col-md-4">
      <label for="lojarh">Loja</label>
      <input type="text" class="form-control" id="lojarh" name="lojarh" placeholder="Loja" >
    </div>

  <div class="form-group col-md-7">
      <label for="datarh">Data</label>
      <input type="date" class="form-control" id="datarh" name="datarh" placeholder="" >
    </div>
  
  <div  class="container" align="center" >
  <button  id="enviar" type="submit" class="btn btn-success "> Enviar arquivo</button>
      </div>
  
  <script type="text/javascript">
document.enviar.reset();
</script>

</form> 
</div>
</div>


    <div class="col-2">
      <center>
        <img class="img-responsive" src="img/un.sao.paulo.png" id="logo_meio_arius">
      </center>
      
    </div>
    <div class="col-5">
      

<legend> Preencha aqui para PB KIDS</legend>
<div class="box_pbkids">
<form id="reenviarpb" method="post" action="">
<div class="form-group col-md-4">
      <label for="lojapb">Loja</label>
      <input type="text" class="form-control" id="lojapb" name="lojapb" placeholder="Loja" >
    </div>

  <div class="form-group col-md-7">
      <label for="datapb">Data</label>
      <input type="date" class="form-control" id="datapb" name="datapb" placeholder="" >
    </div>
  
  <div  class="container" align="center" >
  <button  id="enviarpb" type="submit" class="btn btn-success "> Enviar arquivo</button>
    </div>
  
</form> 
</div>
</div>

</div>




<?php

// Pegar digitação do cliente
$lojarh=$_POST['lojarh'];
$select=mysqli_query ($conexao, "SELECT lojapdv FROM clientes WHERE lojasap=$lojarh");
$exibe = mysqli_fetch_assoc($select);
$lojapdv=$exibe["lojapdv"];
$datarh=$_POST['datarh'];
//transformar data no formato ddmmaaaa
$dataRh = explode('-', $datarh);
$dataRH = $dataRh[2].''.$dataRh[1].''.$dataRh[0];
$arquivorh="tefconsRHLJ$lojapdv$dataRH.txt"; 
$DIR="/var/www";
$filename = '/var/www/ftprh/enviado';
$sucessorh="/siga/RH/$arquivorh";

if ($lojarh > 0) {
$conteudo = "";
$conteudo .= "".PHP_EOL;
$conteudo = "#!/bin/bash";
$conteudo .= "".PHP_EOL;
$conteudo .= "HOST='brcop-sl-ftp01.rihappy.local'".PHP_EOL;
$conteudo .= "".PHP_EOL;
$conteudo .= "USER='sftp.ariuscccon'".PHP_EOL;
$conteudo .= "".PHP_EOL;
$conteudo .= "".PHP_EOL;
$conteudo .= 'sudo -S -u retag bash -c "sftp $USER@$HOST <<SFTP'.PHP_EOL;
$conteudo .= "".PHP_EOL;
$conteudo .= "".PHP_EOL;
$conteudo .= "put /siga/RH/$arquivorh /RH/$arquivorh".PHP_EOL;
$conteudo .= '"'.PHP_EOL;
$conteudo .= "".PHP_EOL;
$conteudo .= "exit".PHP_EOL;
$conteudo .= "exit".PHP_EOL;
$name = "/var/www/ftprh/enviaconciliacao.sh";
$file = fopen ($name, 'a+'); 
fwrite($file, $conteudo);
fclose($file);

$comando = "chmod +x $name";
$permissao = exec(escapeshellcmd($comando), $output);


shell_exec('/var/www/rhftp.sh');

} else {
	
}

if ($lojarh > 0 ) {
  if (file_exists($sucessorh)) {
	     mysqli_query ($conexao, "UPDATE conciliacao SET data=CURDATE(),dataenvio=NOW() WHERE loja=$lojarh");  
    	echo '<div class="alert alert-success">Arquivo enviado com sucesso!</div>';	
      unlink($filename);		
     } else {
   echo '<div class="alert alert-danger">Arquivo não encontrado! Aguarde análise do suporte.</div>';
   
   # -------------- Inicicio envio de email --------------
# Exemplo de envio de e-mail SMTP PHPMailer - www.secnet.com.br
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
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><span style='color:#696969;'></span><strong>Observações:</strong><span style='color:#000000;'>Tentativa de envio do arquivo </span><strong><span style='color:#FF0000;'> $arquivorh</span></strong><span style='color:#000000;'> para FTP</span></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#FF0000;'></p></td> 
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
       
  }
}
		
?>


<?php
// ﻿We'll be outputting a PDF
header("Content-type: /siga/$arquivorh");

// It will be called downloaded.pdf
header("Content-Disposition: attachment; filename='$arquivorh'");

// The PDF source is in original.pdf
readfile("$arquivorh");
?>﻿﻿﻿





<?php

// Pegar digitação do cliente
$lojapb=$_POST['lojapb'];
$selectpb=mysqli_query ($conexao, "SELECT lojapdv FROM clientes WHERE lojasap=$lojapb");
$exibe = mysqli_fetch_assoc($selectpb);
$lojapdvpb=$exibe["lojapdv"];
$datapb=$_POST['datapb'];
//transformar data no formato ddmmaaaa
$dataPb = explode('-', $datapb);
$dataPB = $dataPb[2].''.$dataPb[1].''.$dataPb[0];
$arquivopb="tefconsPBLJ$lojapdvpb$dataPB.txt"; 
$DIR="/var/www";
$filenamepb = '/var/www/ftppb/enviado';
$sucessopb= "/siga/PB/$arquivopb";

if ($lojapb > 0) {
	
$conteudopb = "";
$conteudopb .= "".PHP_EOL;
$conteudopb = "#!/bin/bash";
$conteudopb .= "".PHP_EOL;
$conteudopb .= "HOST='brcop-sl-ftp01.rihappy.local'".PHP_EOL;
$conteudopb .= "".PHP_EOL;
$conteudopb .= "USER='sftp.ariuscccon'".PHP_EOL;
$conteudopb .= "".PHP_EOL;
$conteudopb .= "".PHP_EOL;
$conteudopb .= 'sudo -H -u retag bash -c "sftp $USER@$HOST <<SFTP '.PHP_EOL;
$conteudopb .= "".PHP_EOL;
$conteudopb .= "".PHP_EOL;
$conteudopb .= "put /siga/PB/$arquivopb /PB/$arquivopb".PHP_EOL;
$conteudopb .= '"'.PHP_EOL;
$conteudopb .= "".PHP_EOL;
$conteudopb .= "exit".PHP_EOL;
$conteudopb .= "exit".PHP_EOL;
$namepb = "/var/www/ftppb/enviaconciliacao.sh";
$file = fopen ($namepb, 'a+'); 
fwrite($file, $conteudopb);
fclose($file);

$comandopb = "chmod +x $namepb";
$permissao = exec(escapeshellcmd($comandopb), $outputpb);

shell_exec('/var/www/pbftp.sh');

} else {
	
}

if ($lojapb > 0 ) {
  if (file_exists($sucessopb)) {
	     mysqli_query ($conexao, "UPDATE conciliacao SET data=CURDATE(),dataenvio=NOW() WHERE loja=$lojapb");  
    	echo '<div class="alert alert-success text-center">Arquivo enviado com sucesso!</div>';	
		unlink($filenamepb);
     } else {
   echo '<div class="alert alert-danger text-center">Arquivo não encontrado! Aguarde análise do suporte.</div>';
   
      # -------------- Inicicio envio de email --------------
# Exemplo de envio de e-mail SMTP PHPMailer - www.secnet.com.br
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
$mail->Subject = "Loja: $lojapb - Arquivo não encontrado no SIGA"; # Assunto da mensagem
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
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#333333;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#333333;'>O arquivo<strong><span style='color:#FF0000;'> $arquivopb </span></strong>não foi encontrado no SIGA!</p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#333333;'><br></p></td> 
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
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><strong>LOJA:</strong></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica, sans-serif;line-height:21px;color:#3D4C9D;'></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#FF0000;'><strong>$lojapb</strong></p></td> 
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
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><strong>Data do Arquivo:</strong></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#FF0000;'><strong>$datapb</strong></p></td> 
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
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><strong>Arquivo:</strong></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#FF0000;'><strong>$arquivopb</strong></p></td> 
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
                      <td align='left' style='padding:0;Margin:0;'><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><span style='color:#696969;'></span><strong>Observações:</strong><span style='color:#000000;'>Tentativa de envio do arquivo </span><strong><span style='color:#FF0000;'> $arquivopb</span></strong><span style='color:#000000;'> para FTP</span></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#3D4C9D;'><br></p><p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial,  helvetica, sans-serif;line-height:21px;color:#FF0000;'></p></td> 
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
$mail->AltBody = "O arquivo $arquivopb não foi encontado no SIGA! <br><br> Dados da Geração: <br> Loja: $lojarh <br> Data do arquivo: $datapb  <br> Arquivo: $arquivopb \r\n :)";

# Define os anexos (opcional)
#$mail->AddAttachment("c:/temp/documento.pdf", "documento.pdf"); # Insere um anexo

# Envia o e-mail
$enviado = $mail->Send();

# Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

#-------------------- fim envio de email -----------------
   
      
   
  }
}

?>


 <!-- loadingModal-->
        <div class="modal fade" data-backdrop="static" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal_label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loadingModal_label">
                            <span class="glyphicon glyphicon-refresh"></span>
                            Aguarde...
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class='alert' role='alert'>
                            <center>
                                <div class="loader" id="loader"></div><br>
                                <h4><b id="loadingModal_content"></b></h4>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- loadingModal-->
        <nav class="navbar"></nav>


   <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div> 
		
</body>

</html>
