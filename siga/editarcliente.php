<?php
include("menu.php");
include ("config/conexao2.php");
date_default_timezone_set('America/Sao_Paulo');

// pega o ID da URL
$codigo = isset($_GET['codigo']) ? (int) $_GET['codigo'] : null;
 
// valida o ID
if (empty($codigo))
{
    echo "ID para alteração não definido";
    exit;
}
 
// busca os dados du usuário a ser editado
$PDO = conexao();
$sql = "SELECT lojasap, lojapdv, cnpj, fantasia, contato, inscricao, grupo, estado, cidade, cep, bairro, endereco, numero FROM clientes WHERE codigo = :codigo";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
 
$stmt->execute();
 
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
 
// se o método fetch() não retornar um array, significa que o ID não corresponde a um usuário válido
if (!is_array($cliente))
{
    echo "Nenhum usuário encontrado";
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Edição de Loja</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/menu.css">

  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<style type="text/css">
  .footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
  
   color: #A9A9A9;
   text-align: right;
}
</style>

<script>

    
    function limpa_formulario_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('endereco').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('estado').value=("");
            
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('endereco').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('estado').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulario_cep();
            alert("CEP não encontrado.");
            document.getElementById('cep').value=("");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep !== "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('endereco').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('estado').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulario_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulario_cep();
        }
    }

function formatar(mascara, documento){
  var i = documento.value.length;
  var saida = mascara.substring(0,1);
  var texto = mascara.substring(i);
  
  if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
  }
  
}
 
function idade (){
    var data=document.getElementById("dtnasc").value;
    var dia=data.substr(0, 2);
    var mes=data.substr(3, 2);
    var ano=data.substr(6, 4);
    var d = new Date();
    var ano_atual = d.getFullYear(),
        mes_atual = d.getMonth() + 1,
        dia_atual = d.getDate();
        
        ano=+ano,
        mes=+mes,
        dia=+dia;
        
    var idade=ano_atual-ano;
    
    if (mes_atual < mes || mes_atual == mes_aniversario && dia_atual < dia) {
        idade--;
    }
return idade;
} 
  
  
function exibe(i) {
    
   
        
	document.getElementById(i).readOnly= true;
	    
   
}

function desabilita(i){
    
     document.getElementById(i).disabled = true;    
    }
function habilita(i)
    {
        document.getElementById(i).disabled = false;
    }


function showhide()
 {
       var div = document.getElementById("newpost");
       
       if(idade()>=18){
 
    div.style.display = "none";
}
else if(idade()<18) {
    div.style.display = "inline";
}

 }

</script>


   </head>
   
  <body>
  <div class="container-fluid" >
   <form id="validacao" method="post" action="validaedicaocliente.php">
   
   <legend> Atualizar cadastro de Lojas</legend>
   <div class="alinhamento">
   <div class="form-row">
   
 	<div class="form-group col-md-1">
      <label for="lojasap">Loja SAP</label>
      <input type="text" class="form-control" id="lojasap" name="lojasap" value="<?php echo $cliente['lojasap'] ?>" required>
    </div>
	
	
	 <div class="form-group col-md-2">
      <label for="lojapdv">Loja Abreviado</label>
      <input type="text" class="form-control" id="lojapdv" name="lojapdv" value="<?php echo $cliente['lojapdv'] ?>" required>
    </div>
	
	
	<div class="form-group col-md-5">
      <label for="fantasia">Razão Social ou Fantasia</label>
      <input type="text" class="form-control" id="fantasia" name="fantasia" value="<?php echo $cliente['fantasia'] ?>" required>
    </div>
	
	
	<div class="form-group col-md-4">
      <label for="cnpj">CNPJ</label>
      <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?php echo $cliente['cnpj'] ?>" required>
    </div>
	
	
	<div class="form-group col-md">
      <label for="inscricao">Inscrição Estadual</label>
      <input type="text" class="form-control" id="inscricao" name="inscricao" value="<?php echo $cliente['inscricao'] ?>" required> 
    </div>
    
	
	
	<div class="form-group col-md-2">
      <label for="grupo">Grupo</label>
      <select id="grupo" name="grupo" class="form-control" required>
        <option value="<?php echo $cliente['grupo'] ?>"><?php echo $cliente['grupo'] ?></option>
        <option value="PB KIDS">PB KIDS</option>
		<option value="RI HAPPY">RI HAPPY</option>
      </select>
    </div>
	
	
	<div class="form-group col-md">
      <label for="contato">Telefone</label>
      <input type="text" class="form-control" id="contato" name="contato" value="<?php echo $cliente['contato'] ?>" required>
      </div>
	
	
  </div>
  
  
  
  	<div class="form-row">
   <div class="form-group col-md-4">
   <label for="cep">CEP</label>
   <input id="cep" name="cep" value="<?php echo $cliente['cep'] ?>" class="form-control input-md" required="" value="" type="search" maxlength="8" pattern="[0-9]+$">

 </div>
 
  <div style="margin-top: 2em;" class="form-group">
  <button type="button" class="btn btn-primary" onclick="pesquisacep(cep.value)">Pesquisar</button>
 </div>
 	 </div>
	
     <div class="form-row">
   
    <div class="form-group col-md-4" for="prependedtext">
      <label for="estado">Estado</label>
	<input id="estado" name="estado" class="form-control" value="<?php echo $cliente['estado'] ?>" required=""  readonly="readonly" type="text">  
    </div>
	
   
    <div class="form-group col-md-4" for="prependedtext">
      <label for="cidade">Cidade</label>
       <input id="cidade" name="cidade" class="form-control" value="<?php echo $cliente['cidade'] ?>" required=""  readonly="readonly" type="text">
    </div>
	
	
	<div class="form-group col-md-4" for="prependedtext">
      <label for="bairro">Bairro</label>
	   <input id="bairro" name="bairro" class="form-control" value="<?php echo $cliente['bairro'] ?>" required="" readonly="readonly" type="text">
    </div>
	
	<div class="form-group col-md-11" for="prependedtext">
      <label for="endereco">Endereco</label>
	  <input id="endereco" name="endereco" class="form-control" value="<?php echo $cliente['endereco'] ?>" required="" readonly="readonly" type="text">
    </div>
	
	<div class="form-group col-md-1" >
      <label for="numero">Nº</label>
	    <input id="numero" name="numero" class="form-control" value="<?php echo $cliente['numero'] ?>" required=""  type="text">
    </div>
	
  </div>
  
  
  
  <br>
  <div class="form-group">   
  <input type="hidden" name="codigo" value="<?php echo $codigo ?>">
  <button for="atualizar" type="submit" class="btn btn-primary">Atualizar</button>
  </div>
  
</form>
</div>
  
   <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div> 

</body>
</html>