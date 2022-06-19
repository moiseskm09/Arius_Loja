<?php
$sql = "
				SELECT
					i.pdv,
					i.nrocupom,
					i.item,
					i.valor,
					i.valororiginal,
					(i.valororiginal - i.valor) AS valordesconto,
					i.valorunitario as valorunitariooriginal,
					(i.valor/i.quantidade) as valorunitario,
					i.AcertoDesconto,
					i.dataproc as dataproc,
					i.operador as operador_cod,
					i.quantidade,
					ope.nome as operador_nome,
					s.descricao AS secao,
					d.descricao,
					m.descricao as descr_merc,
					c.codigocliente,
					(CASE WHEN oi.Supervisor IS NOT NULL THEN oi.Supervisor 
						 WHEN os.Supervisor IS NOT NULL THEN os.Supervisor
						 ELSE 0 END) as supervisor_cod, 
					(CASE WHEN si.nome IS NOT NULL THEN si.nome 
						 WHEN sc.nome IS NOT NULL THEN sc.nome 
						 ELSE oi.Supervisor END) as supervisor_nome 
				FROM retag.itens i
				LEFT JOIN retag.ocorrencias oi ON
					i.nroloja=oi.nroloja and
					i.dataproc=oi.dataproc and
					i.pdv=oi.pdv and
					i.nrocupom=oi.nrocupom and
					i.item=oi.item
				LEFT JOIN retag.usuarios si ON
					oi.nroloja = si.nroloja and
					oi.supervisor = si.codigo
				LEFT JOIN retag.ocorrencias os ON
					i.nroloja=os.nroloja and
					i.dataproc=os.dataproc and
					i.pdv=os.pdv and
					i.nrocupom=os.nrocupom and
					os.Descricao = 'LIBERAR DESCONTO'
				LEFT JOIN controle.usuarios sc ON 
					i.nroloja = sc.nroloja and 
					os.supervisor = sc.codigo					 
				LEFT JOIN controle.usuarios ope ON
					i.nroloja = ope.nroloja AND
					i.operador = ope.codigo
				LEFT JOIN controle.secoes s 	ON
					i.depto = s.codigo
				LEFT JOIN controle.conf_descontos_tipo d ON
					i.AcertoDesconto = d.codigo
				LEFT JOIN retag.mercador m ON
					m.nroloja=i.nroloja AND
					i.codigo=m.codigoean
				LEFT JOIN retag.cupom c ON
					c.nroloja=i.nroloja and
					i.dataproc=c.dataproc and
					i.pdv=c.pdv and
					i.nrocupom=c.nrocupom
				WHERE  i.nroloja=$nroLoja AND
					i.dataproc BETWEEN $dataproc_i AND $dataproc_f
					AND i.pdv = $pdv
					AND i.depto = $secao
					AND i.AcertoDesconto  = $tipoDesconto AND
					i.valor < i.valororiginal AND
					i.estornado = 0
				ORDER BY
					i.dataproc,
					i.pdv,
					i.nrocupom,
					i.item
";