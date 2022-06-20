<?php
	require_once "bd.class.php";
	require_once "config.inc.php";
	
	class login
	{
	
		var $avisoLicenca = 0;
	
		/*
		construtor
		*/
		function login ()
		{
	
		}
	
		function logar ()
		{
			//mata a variável de sessão caso houver
			@session_destroy();
			@session_start();
			
			//conecta no banco de dados
			$con = new bd;
			$con->connect();
	
			$con2 = new bd;
			$con2->connect();
			
			function pega_ip(){
				 $variaveis_do_sistema = array('REMOTE_ADDR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_X_COMING_FROM', 'HTTP_COMING_FROM', 'HTTP_CLIENT_IP');
				$return = 'Unknown';
				foreach( $variaveis_do_sistema as $var ){
					if( isset( $_SERVER[$var] ) ){
						$return = $_SERVER[$var];
						break;
					}
				}
			   return $return;
			}
			
			function anti_injection( $parametro ){
				$retorno = true;
				
				$proibidos = array(  "and ", "or ", "limit", "join", "abort", "alter", "analyze", "begin", "checkpoint", "close", "cluster", "comment", "commit", "copy" ,"create", "declare", "delete", "drop", "end", "explain", "fetch", "grant", "insert", "listen", "load", "lock", "move", "notify", "reindex", "reset", "revoke", "rollback" ,"select", "set", "show", "truncate", "unlisten" ,"update", "vacuum" );
				
				foreach( $proibidos as $val ){
					if( eregi( $val, $parametro ) ){
						$retorno = false;
						$comando = $val;
						$digitado = $parametro;
						break;
					}
				}
				if( $retorno === true ){
					$retorno = str_replace('\'', '\\\'', $parametro);
				}else if( $retorno === false ){
					//configuração do log.
					$arquivo = "log.txt";
					$data = date("d/m/Y H:i:s");
					$ip = pega_ip();
					$host = getHostByAddr($ip); // Host de acesso.
					$navegador = $_SERVER["HTTP_USER_AGENT"];
					
					$dados_de_acesso = "Data: ".$data." | IP: ".$ip." | host: ".$host." | Navegador: ".$navegador." | Digitado: ".$digitado." | Injection detectado: ".$comando;
					
// 					$fp = fopen( $arquivo, "a");
// 					fwrite( $fp, $dados_de_acesso );
// 					fclose($fp);
 					exit( "<h2 style=\" color: red;\">Seus dados foram gravados no servidor de logs por tentativa de invasão:</h2><br /> ".str_replace( "|", "<br />", $dados_de_acesso ) );
				}
				return $retorno;
			}
			
			$user = ( anti_injection( $_POST["USUARIO"] ) );
			$pass = ( anti_injection( $_POST["SENHA"] ) );
			
			if( $user && $pass ){
				//busca configuração do usuário
				$sql = "SELECT ".
								"a.nome, ".
								"a.nivel, ".
								"a.senha, ".
								"b.diretorio ".
							"FROM ".
									BD_CONTROLE.".usuarios AS a ".
							"LEFT JOIN ".
									BD_CONTROLE.".temas AS b ".
							"ON ".
								"a.tema = b.codigo ".
							"WHERE ".
								"a.codigo = '".$user."' AND ".
								"a.senha = '".$this->montaSenha($user, $pass)."'";  // echo $sql."<br><br>";   exit;
				$con->query($sql);
// 				echo $sql;exit;
			}
			
			if ($con->num_rows == 1) {
					$row = $con->fetch_array();
	
					$_SESSION["USUARIO"]["CODIGO"] = $user;
					$_SESSION["USUARIO"]["NOME"]   = $row["nome"];
					$_SESSION["USUARIO"]["NIVEL"]  = $row["nivel"];
					$_SESSION["USUARIO"]["TEMA"]   = $row["diretorio"];
	
					//busca configuração da loja
					$sql = "
						SELECT
								cgc,
								razao,
								nroloja,
								inscestadual,
								endereco,
								cidade,
								uf,
								tiporetag,
								layout_importacao,
								layout_exportacao,
								casas_decimais
							FROM
								".BD_CONTROLE.".pf_loja
						";
					
	
					$con->query($sql);
			$row = $con->fetch_array();
					$_SESSION["LOJA"]["CGC"]           = $row["cgc"];
					$_SESSION["LOJA"]["RAZAO"]         = $row["razao"];
					$_SESSION["LOJA"]["NRO"]           = $row["nroloja"];
					$_SESSION["LOJA"]["IE"]            = $row["inscestadual"];
					$_SESSION["LOJA"]["ENDERECO"]      = $row["endereco"];
					$_SESSION["LOJA"]["CIDADE"]        = $row["cidade"];
					$_SESSION["LOJA"]["UF"]            = $row["uf"];
					$_SESSION["LOJA"]["TIPORETAG"]     = $row["tiporetag"];
					$_SESSION["LOJA"]["LAYOUTIMPORTACAO"] = $row["layout_importacao"];
					$_SESSION["LOJA"]["LAYOUTEXPORTACAO"] = $row["layout_exportacao"];
					$_SESSION["LOJA"]["CASASDECIMAIS"] = $row["casas_decimais"];
	
					//carregar configuração de níveis de acesso do usuário
					$sql = "SELECT m.nome,
										m.codigo,
								m.link
							FROM ".BD_CONTROLE.".menu m
							WHERE m.ativo = 1
									AND m.codigo_pai = 0
							ORDER BY m.ordem ASC";
	
					//die($sql);
					$con->query($sql);
	
					$_SESSION["MENULINKS"] = array(); //links que o usuário tem acesso
					$cont = 0; //contador do menu
					while ($row = $con->fetch_array()) {
						$cont++;
	
						//buscar menu
						$_SESSION["MENU"][$cont]["NOME"] = $row["nome"];
						$_SESSION["MENU"][$cont]["LINK"] = $row["link"];
	
						//guarda código do menu corrente
						$guardaContMenu = $cont;
	
						//buscar submenu
						$sql = "SELECT m.nome,
										m.codigo,
										m.link,
										IF(n.ativo = 1, 1, 0) as ativo
							FROM ".BD_CONTROLE.".menu m
									LEFT JOIN ".BD_CONTROLE.".menunivel n ON (m.codigo = n.codigo_menu)
							WHERE m.ativo = 1
									AND m.codigo_pai = '".$row["codigo"]."'
									AND n.codigo_nivel = '".$_SESSION["USUARIO"]["NIVEL"]."'
							ORDER BY m.nome";
	
						//die($sql);
						$con2->query($sql);
	
						$cont++;
	
						$contSubmenu = 0; //contador do submenu
						while ($row2 = $con2->fetch_array()) {
							if ($row2["ativo"] == 1) {
									$_SESSION["MENU"][$cont]["NOME"] = $row2["nome"];
									$_SESSION["MENU"][$cont]["LINK"] = $row2["link"];
	
									//guardar path formatada
									$paginaName = str_replace("..", "", $row2["link"]);
									array_push($_SESSION["MENULINKS"], dirname(DIRETORIO_APLICACAO.$paginaName));
									$contSubmenu++;
							}
	
							$cont++;
						}
	
						//verifica se tem pelo menos um submenu, se NÃO estiver excluir o menu
						if ($contSubmenu == 0) {
							unset($_SESSION["MENU"][$guardaContMenu]["NOME"]);
							unset($_SESSION["MENU"][$guardaContMenu]["LINK"]);
						}
					}
	
					//verificar licenca
					$licenca = new licenca();
					$retorno = $licenca->verificaLicenca($erro);
	
					//verifica se não ocorreu nenhum erro em executar a rotina em C, ou não encontrou o arquivo
					if ($erro == 0 && $retorno != 0) {
						//verificar validade da licenca
						if ($licenca->diasFaltantes <= $licenca->diasAviso && $licenca->diasFaltantes > 0) {
							$this->avisoLicenca = 1;
						} elseif ($licenca->diasFaltantes <= 0) {
							//licença expirada, destruir sessão do usuário
							session_destroy();
							unset($_SESSION);
							$this->avisoLicenca = 2;
						}
					}
	
					return true;
			} else {
					return false;
			}
	
		}
	
		function montaSenha($codigo, $senha)
		{
			$result = "";
			$codigo = str_pad($codigo, 6, "0", STR_PAD_LEFT);
			$senha = str_pad($senha, 4, "0", STR_PAD_LEFT);
			$senha = $senha[0]."0".$senha[1].$senha[2]."0".$senha[3];
	
			for ($i=0; $i<6; $i++) {
					$c = $codigo[$i];
					$s = $senha[$i];
					$aux = $s+$c;
					if ($aux < 10) {
						$result .= $aux;
					} else {
						settype($aux, "string");
						$result .= $aux[1];
					}
			}
			return $result;
		}
	
	}
	?>
