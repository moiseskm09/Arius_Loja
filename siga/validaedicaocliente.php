<?php
 
require_once ('config/conexao2.php');
 

// resgata os valores do formulário
$lojasap = isset($_POST['lojasap']) ? $_POST['lojasap'] : null;
$lojapdv = isset($_POST['lojapdv']) ? $_POST['lojapdv'] : null;
$cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : null;
$fantasia = isset($_POST['fantasia']) ? $_POST['fantasia'] : null;
$contato = isset($_POST['contato']) ? $_POST['contato'] : null;
$inscricao = isset($_POST['inscricao']) ? $_POST['inscricao'] : null;
$grupo= isset($_POST['grupo']) ? $_POST['grupo'] : null;
$estado= isset($_POST['estado']) ? $_POST['estado'] : null;
$cidade= isset($_POST['cidade']) ? $_POST['cidade'] : null;
$bairro= isset($_POST['bairro']) ? $_POST['bairro'] : null;
$cep= isset($_POST['cep']) ? $_POST['cep'] : null;
$endereco= isset($_POST['endereco']) ? $_POST['endereco'] : null;
$numero= isset($_POST['numero']) ? $_POST['numero'] : null;
$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : null;

			
 
// validação (bem simples, mais uma vez)
if (empty($lojasap) || empty($lojapdv) || empty($cnpj) || empty($fantasia) || empty($contato) || empty($inscricao) || empty($grupo) || empty($estado) || empty($cidade) || empty($bairro) || empty($cep) || empty($endereco) || empty($numero)){
    echo "Volte e preencha todos os campos";
    exit;
}
 
// a data vem no formato dd/mm/YYYY
// então precisamos converter para YYYY-mm-dd
//$isoDate = dateConvert($birthdate);
 
// atualiza o banco
$PDO = conexao();
$sql = "UPDATE clientes SET lojasap = :lojasap, lojapdv = :lojapdv, cnpj = :cnpj, fantasia = :fantasia, contato = :contato, inscricao = :inscricao , grupo = :grupo , estado = :estado , cidade = :cidade , bairro = :bairro , cep = :cep , endereco = :endereco, numero = :numero WHERE codigo = :codigo";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':lojasap', $lojasap);
$stmt->bindParam(':lojapdv', $lojapdv);
$stmt->bindParam(':cnpj', $cnpj);
$stmt->bindParam(':fantasia', $fantasia);
$stmt->bindParam(':contato', $contato);
$stmt->bindParam(':inscricao', $inscricao);
$stmt->bindParam(':grupo', $grupo);
$stmt->bindParam(':estado', $estado);
$stmt->bindParam(':cidade', $cidade);
$stmt->bindParam(':bairro', $bairro);
$stmt->bindParam(':cep', $cep);
$stmt->bindParam(':endereco', $endereco);
$stmt->bindParam(':numero', $numero);
$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
 
if ($stmt->execute())
{
	
    header('Location: consultacliente.php');
exit;
	
}
else
{
    echo "Erro ao alterar";
    print_r($stmt->errorInfo());
}
?>