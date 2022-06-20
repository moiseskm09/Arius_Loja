<?php
 
require_once ('config/conexao2.php');
 
// pega o ID da URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
 
// valida o ID
if (empty($id))
{
    echo "ID não informado";
    exit;
}
 
// remove do banco
$PDO = conexao();
$sql = "DELETE FROM usuarios WHERE id = :id";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
 
if ($stmt->execute())
{
    header('Location: consultausuario.php');
}
else
{
    echo "Erro ao remover";
    print_r($stmt->errorInfo());
}