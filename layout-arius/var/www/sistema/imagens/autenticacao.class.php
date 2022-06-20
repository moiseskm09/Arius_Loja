<?php
session_start();
	class autenticacao{
		/*
		carrega dependencias;
		*/
		function autenticacao ()	{
	
		}
	
		/*
		controla acesso a pagina;
		*/
		function autenticar ( $codigo_menu = 0 ){
			
			//verifica se a sessão do usuário está ativa.
			if( !isset( $_SESSION["USUARIO"]["NIVEL"] ) ){
				return $this->erro(true);
			}
			
			if( $codigo_menu ){
				require_once "bd.class.php";
				$con = new bd;
				$con->connect();
// 				$sql = "
// 					select
// 						mn.codigo_nivel,
// 						mn.codigo_menu,
// 						mn.ativo as mn_ativo,
// 						m.ativo as m_ativo
// 					from
// 						".BD_CONTROLE.".menunivel mn
// 					left join
// 						".BD_CONTROLE.".menu m
// 					on
// 						mn.codigo_menu = m.codigo
// 					WHERE
// 						m.ativo = 2 and
// 						mn.codigo_menu = '".$codigo_menu."' and
// 						mn.codigo_nivel = '".$_SESSION["USUARIO"]["NIVEL"]."'
// 				";
				$sql = "
					select
						m.ativo as m_ativo,
						mn.ativo as mn_ativo
					from
						".BD_CONTROLE.".menu m
					left join
						".BD_CONTROLE.".menunivel mn
					on
						mn.codigo_menu = m.codigo
					where
						mn.codigo_menu = '".$codigo_menu."' and
						mn.codigo_nivel = '".$_SESSION["USUARIO"]["NIVEL"]."' and
						m.ativo = 2
				";
// 				echo($sql);
				$con->query($sql);
				$row = $con->fetch_array();
				if( $con->num_rows ){
					if( $row["mn_ativo"] > 0 ){
						return 2;
					}
				}
			}
			
			$arquivosValidos = array(DIRETORIO_APLICACAO."/sistema");
	
			$paginaName = dirname($_SERVER["PHP_SELF"]);
// 			print_r( $arquivosValidos );
// 			echo $paginaName;
// 			print_r( $_SESSION["MENULINKS"] );
			//testa se os arquivos são válidos
			if ( !in_array($paginaName, $arquivosValidos) && !in_array($paginaName, $_SESSION["MENULINKS"])) {
// 			if( !in_array( $paginaName, $_SESSION["MENULINKS"] ) ){
				return $this->erro(true);
			}
	
			//se não houver erro
			return $this->erro(false);
	
		}
	
		function erro($erro){
			if ($erro == true) {
				echo "<font face='verdana' size='1'><br>&nbsp;Acesso Restrito</font>";
				return 0;
			}else{
				return 1;
			}
		}
	}
?>