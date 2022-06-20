<?php
 
include ("config/conexao2.php");

// resgata os valores do formulário
$servidor = isset($_POST['servidor']) ? $_POST['servidor'] : null;
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$senha = isset($_POST['senha']) ? $_POST['senha'] : null;
$diretorioRH = isset($_POST['diretorioRH']) ? $_POST['diretorioRH'] : null;
$diretorioPB = isset($_POST['diretorioPB']) ? $_POST['diretorioPB'] : null;

 
// validação (bem simples, mais uma vez)
if (empty($servidor) || empty($usuario) || empty($senha) || empty($diretorioRH) || empty($diretorioPB))
{
    echo "Volte e preencha todos os campos";
    exit;
}
 
// atualiza o banco
$PDO = conexao();
$sql = "UPDATE ftp_conciliacao SET servidor = :servidor, usuario = :usuario, senha = :senha, diretorioRH = :diretorioRH, diretorioPB = :diretorioPB";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':servidor', $servidor);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':senha', $senha);
$stmt->bindParam(':diretorioRH', $diretorioRH);
$stmt->bindParam(':diretorioPB', $diretorioPB);
 
if ($stmt->execute())
{
    header('Location: ftpconciliacao.php');
}
else
{
    echo "Erro ao alterar";
    print_r($stmt->errorInfo());
}