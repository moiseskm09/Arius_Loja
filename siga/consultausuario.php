<?php
include("menu.php");
include ("config/conexao.php");
$consulta = mysqli_query ($conexao,"SELECT * FROM usuarios ORDER BY id") or die (mysqli_error("nao foi possível realizar a consulta. Tente mais tarde!"));

?>


<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Consulta de Usuários</title>
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
<style>
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
	
<legend style="text-align: center;"> Consulta de Usuários</legend>

  <table id="tabela" class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
	      <td>Código</td>
	  <td>CPF</td>
      <td>Nome</td>
	  <td>E-mail</td>
	  <td>Usuário</td>
	  <td>Nivel</td>
      <td>Cadastro</td>
	  <td>Opções</td>
    </tr>
	  </thead>
	  <tbody>
    <?php while($dados = $consulta->fetch_array()) { ?>
    <tr>
    <td id="dimensao"><?php echo $dados['id']; ?></td>
    <td id="dimensao"><?php echo $dados['cpf']; ?></td>
	  <td id="dimensao"><?php echo $dados['nome']; ?></td>
	  <td id="dimensao"><?php echo $dados['email']; ?></td>
	  <td id="dimensao"><?php echo $dados['usuario']; ?></td>
	  <td id="dimensao"><?php echo $dados['niveldeacesso']==1 ?'Usuário':'Administrador'; ?></td>
      <td id="dimensao"><?php echo date('d/m/Y', strtotime($dados['datadecadastro'])); ?></td>
      
	  <td id="dimensao">
	  <center>
	  <div class="btn btn-primary">
        <a href="editarusuario.php?id=<?php echo $dados['id'] ?>" style="color:white"><i style="width: 5.5px;" class="fas fa-edit"></i></a>
		</div>
       <div class="btn btn-danger">
<a href="deletaruser.php?id=<?php echo $dados['id'] ?>"  style="color:white" onclick="return confirm('Tem certeza de que deseja remover?');"><i class="fas fa-trash-alt" style="width: 5.5px;"></i></a>    
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