<?php
include("menu.php");
include ("config/conexao.php");
$consulta2 = mysqli_query ($conexao,"SELECT * FROM clientes ORDER BY codigo") or die (mysqli_error("nao foi possível realizar a consulta. Tente mais tarde!"));
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Consulta de Clientes</title>
           <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
    <link href="css/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="css/fontawesome/css/brands.css" rel="stylesheet">
    <link href="css/fontawesome/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/menu.css">

	<link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json" rel="stylesheet">
	<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<style type="text/css"> 
#dimensao {
			padding: 0px 12px;
			
		}

       tr:hover{
      color: #f4ba5b;
    }
    </style>
   </head>
  <body>
   <div class="container-fluid" >
	
<legend style="text-align: center;"> Consulta de Clientes</legend>


<table id="tabela" class="table table-striped table-bordered table-hover" >
  <thead>
    <tr>
			<td>Código</td>
	  <td>Loja</td>
	  <td>Grupo</td>
      <td>CNPJ</td>
	  <td>Nome Fantasia</td>
	 
	  <td>I.E</td>
	  <td>Opções</td>
      </tr>
	  </thead>
	  <tbody>
    <?php while($retorno = $consulta2->fetch_array()) { ?>
    <tr>
    <td id="dimensao"><?php echo $retorno['codigo']; ?></td>
    <td id="dimensao"><?php echo $retorno['lojasap']; ?></td>
	  <td id="dimensao"><?php echo $retorno['grupo']==1 ?'PB KIDS':'RIHAPPY'; ?></td>
	  <td id="dimensao"><?php echo $retorno['cnpj']; ?></td>
	  <td id="dimensao"><?php echo $retorno['fantasia']; ?></td>
	
	  <td id="dimensao"><?php echo $retorno['inscricao']; ?></td>
	  
        
      
	  <td id="dimensao">
	  <center>
	  <div class="btn btn-primary">
        <a href="editarcliente.php?codigo=<?php echo $retorno['codigo'] ?>" style="color:white"><i style="width: 5.5px;" class="fas fa-edit"></i></a>
		</div>
	
	 <div class="btn btn-danger">
<a href="deletarcliente.php?codigo=<?php echo $retorno['codigo'] ?>" style="color:white" onclick="return confirm('Tem certeza de que deseja remover?');"><i class="fas fa-trash-alt" style="width: 5.5px;"></i></a>		
</div>
</center>
      </td>
    </tr>
    
	<?php } ?>
	</tbody>
	</table>


  </div>

  <script>
  $(document).ready(function(){
      $('#tabela').DataTable({
          "language": {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "Pesquisar",
    "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    }
}
        });
  });
  </script>
  
     <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div> 

  </body>
</html>