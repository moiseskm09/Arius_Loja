<?php
include_once 'config.php';

//variáveis
$data = date('d-m-Y');
$minimo_dias = 10;
$cgc = mysqli_query($conexao, "SELECT cgc FROM pf_loja");

// verificando licença
if (mysqli_num_rows($cgc) > 0) {
    while ($cnpj_loja = mysqli_fetch_assoc($cgc)) {
        chdir('/servidor/');
        $comando = "./verifica_licenca -v -f licencas" . $cnpj_loja['cgc'] . ".dat";
        $cnpj = $cnpj_loja['cgc'];
        //Executa o comando para verificar licença e armazena na variavel $line
        $licencas = exec(escapeshellcmd($comando), $output);
        reset($output);
        while (list(, $line) = each($output)) {
//Grava resultado da execução da execução no banco de dados
            $t = date('Y-m-d');
            $stmt = mysqli_prepare($conexao, "INSERT INTO emk_licenca (cnpj,info, data) VALUES(?,?,?)");
            mysqli_stmt_bind_param($stmt, 'sss', $cnpj, $line, $t);
            mysqli_stmt_execute($stmt);
        }
//busca validade da licença
        $sql = mysqli_query($conexao, "select * FROM emk_licenca WHERE cnpj='$cnpj' and info like 'Expira%'");
        $exibe = mysqli_fetch_assoc($sql);
        $resultado = mb_substr($exibe["info"], 10, 10, 'UTF-8');
//$diferenca = $validade - $data;

        $validade = date('d/m/Y', strtotime($resultado));
        $data_inicio = new DateTime($validade);
        $data_fim = new DateTime($data);

// Resgata diferença entre as datas
        $intervalo = $data_inicio->diff($data_fim);

        if ($intervalo->days < $minimo_dias) {
            $backup = "sudo cp /servidor/licencas$cnpj.dat /servidor/emk_licenca/bkp_licenca/";
            system($backup);
            $local_file = "/servidor/licencas$cnpj.dat";
            $server_file = "/pub/cre/licenca/licencas$cnpj.dat";
            $ftp_server = "ftp.cre.com.br";
            $conn_id = ftp_connect($ftp_server, 2321)or die("Erro de conexão com $ftp_server");
            $ftp_user_name = "cre";
            $ftp_user_pass = "suporte";
            $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("Não foi possível realizar o Login");
            ftp_pasv($conn_id, true) or die("Não foi possível mudar para o modo passivo");
            ftp_get($conn_id, $local_file, $server_file, FTP_BINARY);
            ftp_close($conn_id);
            //$atualiza_licenca = "sudo mv /tmp/licenca/licencas$cnpj.dat /servidor/";
            //system($atualiza_licenca);
            $conteudo = "";
            $conteudo .= "Faltava $intervalo->days para a licencas$cnpj.dat expirar, por isso ela foi atualizada no dia $data ." . PHP_EOL;
            $name = "/servidor/emk_licenca/log.txt";
            $file = fopen($name, 'a+');
            fwrite($file, $conteudo);
            fclose($file);
        } else {
            
        }
    }

    $limpa_bd = mysqli_query($conexao, "DELETE FROM emk_licenca");

//reiniciar pdv_server
    chdir('/servidor/emk_licenca/');
    shell_exec("sudo ./reinicia.sh");
}