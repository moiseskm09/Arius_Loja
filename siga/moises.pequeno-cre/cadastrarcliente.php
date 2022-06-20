<?php
include("menu.php");
include ("config/conexao.php");

date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Cadastro de Lojas</title>
  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/menu.css">

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
   <form id="validacao" method="post" action="">
   
   <legend> Cadastro de Lojas</legend>
   <br>
   <div class="alinhamento">
   <div class="form-row">
   
    <div class="form-group col-md-2">
      <label for="lojasap">Loja SAP</label>
      <input type="text" class="form-control" id="lojasap" name="lojasap" placeholder="Loja SAP" required>
    </div>
	
	 <div class="form-group col-md-2">
      <label for="lojapdv">Loja Abreviado</label>
      <input type="text" class="form-control" id="lojapdv" name="lojapdv" placeholder="Ex: 1020 = 20" required>
    </div>
	
	
	<div class="form-group col-md-5">
      <label for="fantasia">Razão Social ou Fantasia</label>
      <input type="text" class="form-control" id="fantasia" name="fantasia" placeholder="Digite a Razão Social ou Fantasia" required>
    </div>
	
	
	
    <div class="form-group col-md-3">
      <label for="cnpj">CNPJ</label>
      <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o CNPJ" required>
    </div>
	
	<div class="form-group col-md">
      <label for="inscricao">Inscrição Estadual</label>
      <input type="text" class="form-control" id="inscricao" name="inscricao" placeholder="Digite a I.E" required> 
    </div>
	
	<div class="form-group col-md-3">
      <label for="grupo">Grupo</label>
      <select id="grupo" name="grupo" class="form-control" required>
        <option>Escolher...</option>
        <option value="PB KIDS">PB KIDS</option>
		<option value="RI HAPPY">RI HAPPY</option>
      </select>
    </div>
	
	 <div class="form-group col-md">
      <label for="contato">Telefone</label>
      <input type="text" class="form-control" id="contato" name="contato" placeholder="Digite o Telefone" required>
      </div>
     
	
  </div>
    
	<div class="form-row">
   <div class="form-group col-md-4">
   <label for="cep">CEP</label>
   <input id="cep" name="cep" placeholder="Apenas números" class="form-control input-md" required="" value="" type="search" maxlength="8" pattern="[0-9]+$">

 </div>
 
  <div style="margin-top: 2em;" class="form-group">
  <button type="button" class="btn btn-primary" onclick="pesquisacep(cep.value)">Pesquisar</button>
 </div>
 	 </div>
	
     <div class="form-row">
   
    <div class="form-group col-md-4" for="prependedtext">
      <label for="estado">Estado</label>
	<input id="estado" name="estado" class="form-control" placeholder="" required=""  readonly="readonly" type="text">  
    </div>
	
   
    <div class="form-group col-md-4" for="prependedtext">
      <label for="cidade">Cidade</label>
       <input id="cidade" name="cidade" class="form-control" placeholder="" required=""  readonly="readonly" type="text">
    </div>
	
	
	<div class="form-group col-md-4" for="prependedtext">
      <label for="bairro">Bairro</label>
	   <input id="bairro" name="bairro" class="form-control" placeholder="" required="" readonly="readonly" type="text">
    </div>
	
	<div class="form-group col-md-11" for="prependedtext">
      <label for="endereco">Endereco</label>
	  <input id="endereco" name="endereco" class="form-control" placeholder="" required="" readonly="readonly" type="text">
    </div>
	
	<div class="form-group col-md-1" >
      <label for="numero">Nº</label>
	    <input id="numero" name="numero" class="form-control" placeholder="" required=""  type="text">
    </div>
	
  </div>
  
  <br>
  <div class="form-group">     
  <button for="cadastrar" type="submit" class="btn btn-primary">Cadastrar</button>
  </div>
  
</form>
</div>




<?php
     				
	if (isset($_POST['lojasap'], $_POST['lojapdv'], $_POST['fantasia'], $_POST['cnpj'], $_POST['inscricao'], $_POST['grupo'], $_POST['contato'], $_POST['estado'], $_POST['cidade'], $_POST['cep'], $_POST['endereco'], $_POST['bairro'], $_POST['numero'])){
	
			$data = date('Y-m-d H:i');
			$lojasap=$_POST['lojasap'];
			$lojapdv=$_POST['lojapdv'];
			$cnpj=$_POST['cnpj'];
			$fantasia=$_POST['fantasia'];
			$contato=$_POST['contato'];
			$inscricao=$_POST['inscricao'];
			$grupo= $_POST['grupo'];
			$estado= $_POST['estado'];
			$cidade= $_POST['cidade'];
			$cep= $_POST['cep'];	
			$endereco= $_POST['endereco'];
			$bairro= $_POST['bairro'];
			$numero= $_POST['numero'];
			
									
			$consulta = mysqli_query($conexao, "SELECT loja FROM clientes WHERE loja='$loja'");
			$linha = mysqli_num_rows($consulta);
			
			$consulta2 = mysqli_query($conexao, "SELECT cnpj FROM clientes WHERE cnpj='$cnpj'");
			$linha2 = mysqli_num_rows($consulta2);			
						
						
			if ($linha ==1) {
				echo '<div class="alert alert-danger">Está loja já existe na base de dados do sistema!</div>';
				
				
			} elseif ( $linha2 ==1 ) {
					echo '<div class="alert alert-danger">O CNPJ já existe na base de dados do sistema!</div>';		
				
				
			} elseif ($linha==0 && $linha2==0) {
						
							$sql= mysqli_query ($conexao, "INSERT INTO clientes (lojasap, lojapdv, cnpj, fantasia, contato, inscricao, grupo, estado, cidade, cep, endereco, bairro, numero, datadecriacao) VALUES ('$lojasap', '$lojapdv', '$cnpj', '$fantasia', 
							'$contato', '$inscricao', '$grupo', '$estado', '$cidade', '$cep', '$endereco', '$bairro', '$numero', NOW())");
					echo '<div class="alert alert-success">Loja cadastrada com sucesso!</div>';	

			} else {
						echo"erro";
		}
			}

    ?>	

   <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div>  

</body>
</html>