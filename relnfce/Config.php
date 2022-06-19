<?php
require_once "../../../sistema/autenticacao.class.php";
require_once "../../../sistema/bd.class.php";
require_once "../../../sistema/libs.php";
require_once INC_DIR.'/libs.php';
require_once INC_DIR.'/bd.class.php';

class Config
{
    //input's dos filtros
    public $datai = '';
    public $dataf = '';
    public $cupom = '';
    public $chave = '';
    public $nfce = '';

    public $totalPaginas = 0;
    public $limit = 15;
    public $pagina = 1;
    public $totalRegistros = 0;
    public $flgContingencia = false;
    
    public function Config()
    {
        $aut = new autenticacao();
        if (! $aut->autenticar(5)) {
            exit();
        }
        
        $con = new bd;
        $con->connect();
        
        if($_POST){
            $this->pagina = $_POST['pagina'];
        }
        
        //Carregando Input com os tipos de status do NFCE
        $tipoStatus = array(
          999=>"Todos",
            0=>"Invalido",
            1=>"Processado",
            2=>"Indeterminado",
            3=>"Inutilizado",
            4=>"Cancelado Conting�ncia",
            5=>"Cancelado Operador",
          100=>"Pedente de Protocolo",
          101=>"Emitida em Contigencia",
            );
        //Carrega input com os pdv's
        //$inputPdv = $this->selectPdv();
        $this->inputPdv = combo("inputPdv", $inputPdv,(isset($_POST['pdv'])?$_POST['pdv']:$this->inputPdv[999]));

        $this->inputStatus = combo("inputStatus", $tipoStatus, (isset($_POST['tipoStatus'])?$_POST['tipoStatus']:999));


        //carregando input para reload de pagina
        $this->datai = $_POST['dataproc_i'] ?: date('Y-m-d');
        $this->dataf = $_POST['dataproc_f'] ?: date('Y-m-d');
        $this->chave = $_POST['chave'];
        $this->nfce = $_POST['nfce'];
        $this->cupom = $_POST['cupom'];
        $this->tipoStatus = $_POST['tipoStatus'];
        $this->pdv = $_POST['pdv'];
        
        $this->andInputStatus = '';
        if(isset($_POST['tipoStatus']) && $_POST['tipoStatus'] >= 0 && $_POST['tipoStatus'] <= 99){
            $this->andInputStatus = 'AND Status = '.$_POST['tipoStatus'];
        }
        else if($_POST['tipoStatus'] == 100){
            $this->andInputStatus = " AND protocolo_nfe = '' ";
        }
        else if($_POST['tipoStatus'] == 101){
            $this->andInputStatus =  " AND substr(chave_nfe, 35, 1) = 9 ";
        }
        $this->andInputPdv = '';
        if(isset($_POST['pdv']) && $_POST['pdv'] > 0 && $_POST['pdv'] != 999){
            $this->andInputPdv = "AND nfce.Pdv = '".$_POST['pdv']."'";
        }

        $this->andInputCupom = '';
        if(isset($_POST['cupom']) && $_POST['cupom'] != ''){
            $this->andInputCupom = "AND nfce.NroCupom = '".$_POST['cupom']."'";
        }

        $this->andInputNfce = '';
        if(isset($_POST['nfce']) && $_POST['nfce'] != ''){
            $this->andInputNfce = "AND numero_nfe = '".$_POST['nfce']."'";
        }

        $this->andInputChave = '';
        if(isset($_POST['chave']) && $_POST['chave'] != ''){
            $this->andInputChave = "AND chave_nfe LIKE '".$_POST['chave']."'";
        }
        
        $sql="
            SELECT count(nroloja) as totRegistros FROM ".BD_RETAG.".nfce
            WHERE nroloja='".$_SESSION["LOJA"]["NROLOJA"]."'
                AND DataProc between '$this->datai' AND '$this->dataf'
            ".$this->andInputStatus."
        ";
        $con->query($sql);
        if ($con->num_rows) {
            $res = $this->linhas1 = $con->fetch_row();
            $this->totalRegistros = $res['totRegistros'];
            $this->totalPaginas =  ($this->totalRegistros > $this->limit) ? intval( $this->totalRegistros / $this->limit ) : 1;
        }
        
    }
    
    public function carregaDados()
    {
        $con = new bd;
        $con->connect();
        
        //Query
        $sql="
            SELECT
                nfce.nroloja,
                nfce.DataProc,
                nfce.Pdv,
                nfce.NroCupom,
                numero_nfe,
                nfce.Status,
                tpAmb,
                cStat,
                chave_nfe,
                protocolo_nfe,
                dthr_emit_nfe,
                estornado,
                protocolo_canc,
                dthr_receb_sefaz,
                total
            FROM ".BD_RETAG.".nfce
            INNER JOIN ".BD_RETAG.".cupom
                ON nfce.NroCupom = cupom.NroCupom AND nfce.Pdv = cupom.Pdv
            WHERE nfce.nroloja='".$_SESSION["LOJA"]["NROLOJA"]."'
                AND nfce.DataProc between '$this->datai' AND '$this->dataf'
                ".$this->andInputStatus."
                ".$this->andInputCupom."
                ".$this->andInputPdv."
                ".$this->andInputChave."
                ".$this->andInputNfce."
            ORDER BY dthr_emit_nfe DESC
        ";
                  
        $con->query($sql);
//         echo $sql;
        if ($con->num_rows) {
            $this->linhas = $con->fetch_all();
        }
        //             $arr = $con->fetch_array();
    }
    
    function comboPagina(){
        $con = new bd;
        $con->connect();
    
        $combo = "<select id='pagina' name='pagina' onchange=submitForm() class='meio'>\n";
    
        for( $i = 1; $i <= $this->totalPaginas; $i++ ){
            $combo .= "<option value='".($i)."'".($this->pagina == $i ? " selected" : "").">".$i."\n";
        }
    
        return $combo .= "</select>";
    }

    
    
    function selectPdv(){
        $con = new bd;
        $con->connect();

        $sqlpdv = "
            SELECT
                codigo
            FROM ".BD_CONTROLE.".pf_pdv
            WHERE
                nroloja = '".$_SESSION['LOJA']['NROLOJA']."'
        ";
        $con->query($sql);
        $aPdvs = array();
        if($con->num_rows){
            $aPdvs[999]='Todos';
            while($result = $con->fetch_array()){
                $key = sprintf("%03s", $result['codigo'] );
                $aPdvs[$key]= $key;
            }
        }
        return $aPdvs;
    }
    
}


$conpdv = new bd;
$conpdv->connect();
$sqlpdv = "
            SELECT
                codigo
            FROM ".BD_CONTROLE.".pf_pdv
            WHERE
                nroloja = '".$_SESSION['LOJA']['NROLOJA']."'
        ";
$conpdv->query($sqlpdv);