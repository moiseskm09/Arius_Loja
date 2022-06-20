<?php
 
require_once ('config/conexao2.php');
 

// resgata os valores do formulário
$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
$nome = isset($_POST['nome']) ? $_POST['nome'] : null;
$sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$niveldeacesso = isset($_POST['niveldeacesso']) ? $_POST['niveldeacesso'] : null;
$id = isset($_POST['id']) ? $_POST['id'] : null;
 
// validação (bem simples, mais uma vez)
if (empty($cpf) || empty($nome) || empty($sobrenome) || empty($email) || empty($usuario) || empty($niveldeacesso))
{
    echo "Volte e preencha todos os campos";
    exit;
}
 
// a data vem no formato dd/mm/YYYY
// então precisamos converter para YYYY-mm-dd
//$isoDate = dateConvert($birthdate);
 
// atualiza o banco
$PDO = conexao();
$sql = "UPDATE usuarios SET cpf = :cpf, nome = :nome, sobrenome = :sobrenome, email = :email, usuario = :usuario, niveldeacesso = :niveldeacesso WHERE id = :id";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':cpf', $cpf);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':sobrenome', $sobrenome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':niveldeacesso', $niveldeacesso);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
 
if ($stmt->execute())
{
    header('Location: consultausuario.php');
}
else
{
    echo "Erro ao alterar";
    print_r($stmt->errorInfo());
}