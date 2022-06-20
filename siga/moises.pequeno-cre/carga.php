<?php

date_default_timezone_set('America/Sao_Paulo'); // Hora oficial do Brasil.
include("menu.php");
include ("config/conexao2.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="15">
	<title>Controle de Importação - Geral</title>
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
#dimensa {
			padding: 1px 10px;
		}
    </style>
	
   </head>
  <body>
  <div class="container-fluid" >
  <center>
<legend> Controle de Importação</legend>
</center>
 
            <table id="tabela" class="table table-bordered">
                <thead >
                    <tr>
                        <th>#</th>
						<th>LOJA</th>
                        <th>DATA DE IMPORTAÇÃO</th>
						<th>ENVIADA PDV</th>
						<th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
					<?php				
					$PDO = conexao(); 
					//$sql = "SELECT loja, DATE(data) FROM conciliacao WHERE DATE(data) = CURDATE()";
					$sql = "SELECT data, datageracao, pdv, loja FROM carga";
					$stmt = $PDO->prepare($sql);
					$stmt->execute();
					 $dataAtual = date('Y-m-d') ;
					$result = $stmt->rowCount();
					if ($result>0) {
						while($mostrar = $stmt->FETCH(PDO::FETCH_ASSOC)){
						if($mostrar['data'] == $dataAtual ){
							
					?>
					
                    <tr id="dimensao" style="background-color:#98FB98">
					    <th id="dimensao" ><img src="img/ok.png" width="16" height="16"> </th>
                        <td id="dimensao" ><?php  echo $mostrar['loja']; ?></td>
                        <td id="dimensao" ><?php echo date('d/m/Y - H:i:s', strtotime($mostrar['datageracao'])); ?></td>
						<td id="dimensao" ><?php echo $mostrar['pdv']==1 ?'SIM':'NÃO'; ?></td>
						<td id="dimensao" ><?php  echo "CARGA OK" ; ?></td>
					
						
						
                    </tr> 
					
						<?php } else { ?>
						<tr id="dimensao" style="background-color:#FFC0CB">
						<th id="dimensao" ><img src="img/error.png" width="16" height="16"></th>
                        <td id="dimensao" ><?php  echo $mostrar['loja']; ?></td>
                        <td id="dimensao" ><?php  echo  date('d/m/Y - H:i:s', strtotime($mostrar['datageracao'])); ?></td>
						<td id="dimensao" ><?php echo $mostrar['pdv']==0 ?'NÃO':'SIM';?></td>
						<td id="dimensao" ><?php  echo "DIVERGENTE" ; ?></td>
						
						</tr> 
					
					
					<?php
						}
						}
					}				
					?>  
                </tbody>
            </table>
			
			</div>
   
			<link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
			<link href="//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json" rel="stylesheet">
			<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
			<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  
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
  
<script type="text/javascript">
(jQuery);*/

$(document).ready(function () {
    $('#tabela').tableAddCounter();
    $.getScript("js/jquery-ui.js").done(function (script, textStatus) { $('tbody').sortable();$(".alert-info").alert('close');$(".alert-success").show(); });
});
</script>


   <div class="footer">
  <p>SIGA - Versão <?php echo versao_sistema; ?> </p>
</div> 

</body>
</html>
