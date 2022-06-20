<?php
require_once './config/conexao.php';
require_once './config/config_geral.php';


$consultatck = mysqli_query($conexao, "SELECT qb.usuario, qb.avatar, SUM(qb.totaltck) as tt, SUM(qb.totalonline) as tto, SUM(qb.totaltck) + SUM(qb.totalonline) as ttg
from (
SELECT usuario, avatar, count(tck.codticket) AS totaltck, 0 totalonline
FROM $DATABASE.usuarios AS u
INNER JOIN $DATABASE.ticket AS tck ON u.id = tck.codusuario
WHERE u.departamento = $DEPARTAMENTOLOJA
AND tck.dtabertura >= '$DATAINICIAL'
group by tck.codusuario
union
SELECT usuario, avatar, 0 totaltck, count(codatendimento) as totalonline
from $DATABASE.atendimentoonline as online
INNER JOIN $DATABASE.usuarios AS u ON u.id = online.codusuario
WHERE u.departamento = $DEPARTAMENTOLOJA
and datasolicitacao >= '$DATAINICIAL'
group by u.id
    ) AS qb group by usuario, avatar ORDER BY 5 DESC");


$consultaEmpresa = mysqli_query($conexao, "SELECT LEFT(qb.nomeempresa, 15) AS nomeempresa, qb.avatar, SUM(qb.totaltckemp) as tt, SUM(qb.totaltoemp) as tto, SUM(qb.totaltckemp) + SUM(qb.totaltoemp) as ttg
from (
SELECT count(tck.codticket) as totaltckemp, 0 as totaltoemp, emp.nomeempresa, avatar FROM $DATABASE.ticket as tck
INNER JOIN $DATABASE.clientes as  cli ON tck.codcliente = cli.codcliente
INNER JOIN $DATABASE.empresas as emp ON cli.codempresa = emp.codempresa
WHERE tck.dtabertura >= '$DATAINICIAL' AND tck.coddepartamento = $DEPARTAMENTOLOJA 
group by emp.codempresa
UNION
SELECT 0 as totaltckemp, count(ato.codatendimento) as totaltoemp, emp.nomeempresa, avatar FROM $DATABASE.atendimentoonline as ato
INNER JOIN $DATABASE.empresas as emp ON emp.codempresa = ato.codempresa
WHERE ato.datasolicitacao >= '$DATAINICIAL' AND ato.iddepartamento = 12
group by emp.codempresa
) AS qb group by nomeempresa, avatar
ORDER BY 5 DESC
LIMIT 12");