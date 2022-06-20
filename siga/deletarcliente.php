<?php
 
require_once ('config/conexao2.php');
 
// pega o ID da URL
$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;
 
// valida o ID
if (empty($codigo))
{
    echo "ID não informado";
    exit;
}
 
// remove do banco
$PDO = conexao();
$sql = "DELETE FROM clientes WHERE codigo = :codigo";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
 
if ($stmt->execute())
{
    header('Location: consultacliente.php');
}
else
{
    echo "Erro ao remover";
    print_r($stmt->errorInfo());
}