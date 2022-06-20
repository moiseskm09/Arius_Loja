<?
require_once "../../../sistema/bd.class.php";

/**
 * Definição das imagens
 */

define("CALENDAR_ICON", IMAGE_PATH. "ico_calendario.gif");
define("CALCULATOR_ICON", IMAGE_PATH . "ico_calculadora.gif");

/**
 * Definição da class
 */

//$FORM->input("text", "data", "Data",  array("class"=>"cmpMaior", "maxlength"=>"50", "required"=>"T"));


class form {
    var $DB;                                            // objeto de conexão ao banco de dados

    //atributos do método form
    var $action;                                        // ação do formulario
    var $method;                                        // method (get / post)
    var $nome;                                            // nome e id do form

    //atributos do método erro
    var $msg_erro;

    //atributos do método input
    var $type_valido;
    var $type;
    var $propriedade = array();
    var $name_input;

    //guarda os dados para printar na tela depois
    var $form;
    var $formClose;
    var $input = array();
    var $label = array();
    var $campos = array();


    var $campo_obrigatorio = array();
    var $script_mask_js;
    var $script_mask;
    var $script_js;

    /**
     * Construtor da classe
     */
    function form($name_form, $action = "", $method = "post") {
        //valida campos
        if(empty($name_form)) {
            $this->_msgErro("Não foi definido o nome do form!");
        }

        $this->DB = new bd;
        $this->DB->connect();

        //seta nome do form
        $this->nome = $name_form;

        //gera tag <form>
        $this->geraTagForm($name_form, $action, $method);
    }

    /**
     * Gera Form <form>
     */
    function geraTagForm($name_form, $action, $method) {
        //gera form
        $this->form[$name_form] .= "<form name=\"".($name_form)."\" id=\"".($name_form)."\" action=\"".($action)."\" method=\"".($method)."\" onSubmit=\"return ".$name_form."_submit();\" enctype=\"multipart/form-data\">";
    }

    /**
     * Verifica tipo de input
     */
    function input($type, $name_input, $label, $propriedade = array()) {
        //valida campos
        if(empty($type) || empty($name_input)){
            $this->_msgErro("Nome e tipo do input são obrigatórios!");
        }

        //array das opções válidas
        $type = strtolower($type);
        $this->type_valido = array("text", "password",  "file", "select", "selectdynamic", "radio", "checkbox", "textarea", "editorfield", "hidden", "submit", "reset", "button", "lookupselection");
        $this->propriedade = $propriedade;
        $this->type = $type;
        $this->name_input = $name_input;

        // guarda label
        $this->label[$this->name_input] = $label;


        //testa se o tipo é valido
        if(!in_array($this->type ,$this->type_valido)) {
            $this->_msgErro("Tipo ".$type." inválido!");
        }


        //verifica o tipo de input e chama o método correspondente
        switch($type) {
            case "file" :
            case "reset" :
            case "password" :
            case "hidden" :
            case "text" : $this->_text();
                break;
            case "textarea" : $this->_textarea();
                break;
            case "editorfield" : $this->_editorfield();
                break;
            case "select" : $this->_select();
                break;
            case "selectdynamic" : $this->_selectdynamic();
                break;
            case "lookupselection" : $this->_lookupselection();
                break;
            case "button" :
            case "submit" : $this->_submit();
                break;
        }
    }

    /**
     * _text()
     * gera textfield
     */
    function _text() {
        $dados = array();

        //valida propriedades do input textfield
        $propriedade_valida = array("required" ,"mask", "maxlength", "size", "script", "value", "tabindex", "autocomplete", "align", "class", "readonly");
        foreach($this->propriedade as $k => $v) {
            if(!in_array($k, $propriedade_valida)) {
                $this->_msgErro("Propriedade <b>".$k."</b> do campo <b>".$this->name_input."</b> é inválida!");
            }

            //pega propriedades do input
            if($k != "required" && $k != "mask" && $k != "script" && $k != "align") {
                $dados[] = $k."=\"".$v."\"";
            }

            //marca campo obrigatório
            if($k == "required" && $v == "T") {
                $this->campo_obrigatorio[$this->name_input] = "T";
            }

            //todos campo
            $this->campos[$this->name_input] = "";

            //verifica a mascara do campo
            if($k == "mask") {
                switch($v){
                    case "date":
                        $this->script_mask_js_date = "
                        <script type=\"text/javascript\" src=\"".INC_PATH."/calendar.js\"></script>
                        <script type=\"text/javascript\" src=\"".INC_PATH."/calendar-setup.js\"></script>
                        <script type=\"text/javascript\" src=\"".INC_PATH."/calendar-br.js\"></script>
                        <script type=\"text/javascript\" src=\"".INC_PATH."/date.js\"></script>
                        <style type=\"text/css\"> @import url(\"".INC_PATH."/calendar-system.css\"); </style>
                        ";

                        $this->script_mask[$this->name_input] = "date";
                        $dados[] = "id=\"".$this->name_input."_id\"";
                        $calendario = "
                        &nbsp;<img align=\"middle\" id='fcal_".$this->name_input."' src='".CALENDAR_ICON."' title=\"Calendário\" onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\">
                        <script type=\"text/javascript\">
                        Calendar.setup({
                            inputField     :    \"".$this->name_input."_id\",     // id of the input field
                            ifFormat       :    \"%d/%m/%Y\",      // format of the input field
                            button         :    \"fcal_".$this->name_input."\",  // trigger for the calendar (button ID)
                            singleClick    :    true
                        });
                        </script>";
                        break;
                    case "email":
                        $this->script_mask_js_email = "<script language='JavaScript' type='text/javascript' src='".JS_PATH."email.js'></script>\n";
                        $this->script_mask[$this->name_input] = "email";
                        $dados[] = "onKeyPress=\"return chkMaskEMAIL(this, event);\"";
                        break;
                    case "cnpj":
                        $this->script_mask_js_cnpj = "<script language='JavaScript' type='text/javascript' src='".JS_PATH."cpfcnpj.js'></script>\n";
                        $this->script_mask[$this->name_input] = "cnpj";
                        $dados[] = "onKeyPress=\"return chkMaskCPFCNPJ(this, event);\"";
                        break;
                    case "cep":
                        $this->script_mask_js_cep = "<script language='JavaScript' type='text/javascript' src='".JS_PATH."cep.js'></script>\n";
                        $this->script_mask[$this->name_input] = "cep";
                        $dados[] = "onKeyPress=\"return chkMaskCEP(this);\"";
                        break;
                    case "integer":
                        $this->script_mask_js_integer = "<script language='JavaScript' type='text/javascript' src='".JS_PATH."integer.js'></script>";
                        $this->script_mask[$this->name_input] = "integer";
                        $dados[] = "onKeyPress=\"return chkMaskINTEGER(this, event);\"";
                    break;
                    case "moeda":
                        $this->script_mask_js_moeda = "<script language='JavaScript' type='text/javascript' src='".JS_PATH."moeda.js'></script>";
                        $this->script_mask[$this->name_input] = "moeda";
                        $dados[] = "onKeyPress=\"return chkMaskMOEDA(this, event);\"";
                    break;
                    case "float":
                        $this->script_mask_js_float = "<script language='JavaScript' type='text/javascript' src='".JS_PATH."float.js'></script>";
                        $this->script_mask[$this->name_input] = "float";
                        $dados[] = "onKeyPress=\"return chkMaskFLOAT(this, event);\"";
                    break;
                }
            }

            //verifica se é align
            if($k == "align") {
                $dados[] = "style='text-align: $v;'";
            }

        }

        //gera input
        $this->input[$this->name_input] = "<input type=\"".$this->type."\" name=\"".$this->name_input."\" ".($this->type != 'submit' && $this->type != 'button' && $this->type != 'reset' && $this->type != 'hidden' ? ($GLOBALS[$this->name_input] > "" ? "value=\"".$GLOBALS[$this->name_input]."\"" : "") : "")." ".join(" ", $dados)." ".($this->propriedade["script"] ? $this->propriedade["script"] : "")."/>";

        //ícone calendario
        if($calendario) {
            $this->input[$this->name_input] .= $calendario;
        }
    }

    /**
     * _text()
     * gera textfield
     */
    function _submit() {
        $dados = array();

        //valida propriedades do input textfield
        $propriedade_valida = array("script", "value", "image", "class");
        foreach($this->propriedade as $k => $v) {
            if(!in_array($k, $propriedade_valida)) {
                $this->_msgErro("Propriedade <b>".$k."</b> do campo <b>".$this->name_input."</b> é inválida!");
            }

            //pega propriedades do input
            if($k == "script" || $k == "class") {
                $dados[] = $k."=\"".$v."\"";
                //echo $dados[0]; die;
            }


            if($k == "value") {
                $value = $v;
            }

            if($k == "image") {
                $image = "<img src='".IMAGE_PATH.$v."' align='absmiddle' border='0'>&nbsp;";
            }

            //todos campo
            $this->campos[$this->name_input] = "";


        }

        //gera input
        $this->input[$this->name_input] = "<button type=\"".$this->type."\" name=\"".$this->name_input."\" ".($this->propriedade["script"] ? $this->propriedade["script"] : "")." ".join(" ", $dados)."/>".$image.$value."</button>";
        //$this->input[$this->name_input] = "<input type=\"".$this->type."\" value=\"".$value."\" name=\"".$this->name_input."\" ".($this->propriedade["script"] ? $this->propriedade["script"] : "")." ".join(" ", $dados)."/>";
    }

    /**
     * _text()
     * gera textfield
     */
    function _textarea() {
        $dados = array(); //inicia array

        //valida propriedades do input textfield
        $propriedade_valida = array("required" ,"cols", "rows", "value", "tabindex", "script", "class");
        foreach($this->propriedade as $k => $v) {
            if(!in_array($k, $propriedade_valida)) {
                $this->_msgErro("Propriedade <b>".$k."</b> do campo <b>".$this->name_input."</b> é inválida!");
            }

            //pega propriedades do input
            if($k != "required" && $k != "script") {
                $dados[] = $k."=\"".$v."\"";
            }

            //todos campo
            $this->campos[$this->name_input] = "";

            //marca campo obrigatório
            if($k == "required" && $v == "T"){
                $this->campo_obrigatorio[$this->name_input] = "T";
            }
        }

        //gera textarea
        $this->input[$this->name_input] = "<textarea name=\"".$this->name_input."\" ".join(" ", $dados)." ".($this->propriedade["script"] ? $this->propriedade["script"] : "")."/>".$GLOBALS[$this->name_input]."</textarea>";
    }

    /**
     * _text()
     * gera editorfield
     */
    function _editorfield() {
        $dados = array(); //inicia array

        //valida propriedades do input textfield
        $propriedade_valida = array("cols", "rows", "value", "tabindex", "script", "class");
        foreach($this->propriedade as $k => $v) {
            if(!in_array($k, $propriedade_valida)) {
                $this->_msgErro("Propriedade <b>".$k."</b> do campo <b>".$this->name_input."</b> é inválida!");
            }

            //pega propriedades do input
            if($k != "required" && $k != "script") {
                $dados[] = $k."=\"".$v."\"";
            }

            //todos campo
            $this->campos[$this->name_input] = "";

        }


        //incluir js
        $this->script_js = "
        <script language=\"Javascript\">
            <!-- // load htmlarea
                _editor_url = \"".PLUGINS_PATH."htmlarea/\";   // URL to htmlarea files
                var win_ie_ver = parseFloat(navigator.appVersion.split(\"MSIE\")[1]);
                if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
                if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
                if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
                if (win_ie_ver >= 5.5) {
                  document.write('<scr' + 'ipt src=\"' +_editor_url+ 'editor.js\"');
                  document.write(' language=\"Javascript1.2\"></scr' + 'ipt>');
                } else {
                    document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>');
                }
            // -->
        </script>";

        //gera textarea
        $this->input[$this->name_input] = "<textarea name=\"".$this->name_input."\" ".join(" ", $dados)." ".($this->propriedade["script"] ? $this->propriedade["script"] : "")."/>".$GLOBALS[$this->name_input]."</textarea>
            <script language=\"javascript\">
            var config = new Object(); // create new config object
            config.stylesheet = \"".CSS_PATH."padrao.css\";

            config.fontstyles = [
            // leave classStyle blank if it's defined in config.stylesheet (above), like this:
            { name: \"Título\", className: \"titulo2\", classStyle: \"\" },
            { name: \"Texto Padrao\", className: \"textocapa\", classStyle: \"\" }
            ];

            editor_generate(\"".$this->name_input."\", config);
            </script>
        ";
    }

    /**
     * _selectdynamic()
     * gera select a partir de informações do banco
     */
    function _selectdynamic() {
        $dados = array(); //inicia array
        $selecione = 1; //inicia com o selecione

        //valida propriedades do input selectdynamic
        $propriedade_valida = array("required" , "sql", "value", "tabindex", "script", "class", "MULTIPLE", "size", "selecione");
        foreach($this->propriedade as $k => $v) {
            if(!in_array($k, $propriedade_valida)) {
                $this->_msgErro("Propriedade <b>".$k."</b> do campo <b>".$this->name_input."</b> é inválida!");
            }

            //pega propriedades do input
            if($k != "required" && $k != "script" && $k != "sql") {
                if($k == "MULTIPLE") {
                    $dados[] = "MULTIPLE";
                }else{
                    $dados[] = $k."=\"".$v."\"";
                }
            }

            //pega query sql
            if($k == "sql") {
                $sql = $v;
            }

            //pega query sql
            if($k == "selecione" && $v == "F") {
                $selecione = 0;
            }

            if($k == "value") {
                $value = $v;
            }

            //todos campo
            $this->campos[$this->name_input] = "";

            //marca campo obrigatório
            if($k == "required" && $v == "T") {
                $this->campo_obrigatorio[$this->name_input] = "T";
            }
        }

        //gera selectdynamic
        $this->input[$this->name_input] = "<select ".($k == "MULTIPLE" ? "MULTIPLE" : "")." name=\"".($this->name_input)."\" id=\"".($this->name_input)."\" ".join(" ", $dados)." ".($this->propriedade["script"] ? $this->propriedade["script"] : "")."/>";

        if($selecione) {
            $this->input[$this->name_input] .= "<option value=\"\">Selecione...</option>";
        }

        //gera select dinâmico
        $this->DB->query($sql);

        if ($this->DB->num_rows > 0) {
            while ($row =& $this->DB->fetch_array()) {
                if ($value == $row[0]) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $this->input[$this->name_input] .= "<option value=\"".$row[0]."\" $selected>".$row[1]."</option>";
            }
        }

        //fecha tag
        $this->input[$this->name_input] .= "</select>";
    }

    /**
     * _select()
     * gera select estático de acordo com a definição
     */
    function _select() {
        $dados = array(); //inicia array

        //valida propriedades do input select
        $propriedade_valida = array("required" , "value", "tabindex", "script", "option", "selected", "class");
        foreach($this->propriedade as $k => $v) {
            if(!in_array($k, $propriedade_valida)) {
                $this->_msgErro("Propriedade <b>".$k."</b> do campo <b>".$this->name_input."</b> é inválida!");
            }

            //pega propriedades do input
            if($k != "required" && $k != "script" && $k != "option" && $k != "selected") {
                $dados[] = $k."=\"".$v."\"";
            }

            //pega array option
            if($k == "option"){
                $option = $this->propriedade[$k];
            }

            //pega selected
            if($k == "selected"){
                $marca = $this->propriedade[$k];
            }

            //todos campo
            $this->campos[$this->name_input] = "";

            //marca campo obrigatório
            if($k == "required" && $v == "T"){
                $this->campo_obrigatorio[$this->name_input] = "T";
            }
        }

        //gera select
        $this->input[$this->name_input] = "<select name=\"".$this->name_input."\" id=\"".$this->name_input."\" ".join(" ", $dados)." ".($this->propriedade["script"] ? $this->propriedade["script"] : "")."/>";
        $this->input[$this->name_input] .= "<option value=\"\">Selecione...</option>";

        //gera select de acordo com o array $option
        if(count($option) > 0) {
            foreach($option as $k => $v){
                //inicia variável
                $selected = "";
                if(!isset($GLOBALS[$this->name_input])){
                    if($marca == $k){
                        $selected = "selected";
                    }
                }elseif($GLOBALS[$this->name_input] == $k){
                    $selected = "selected";
                }
                $this->input[$this->name_input] .= "<option value=\"".$k."\" $selected>".$v."</option>";
            }
        }

        //fecha tag
        $this->input[$this->name_input] .= "</select>";
    }

    /**
     * _lookupselection()
     * gera lookupselection dinâmico caixas de seleção
     */
    function _lookupselection() {
        //valida propriedades do input select
        $propriedade_valida = array("addimg"=>"direita1.gif" , "addallimg"=>"direita2.gif", "remimg"=>"esquerda1.gif",
                                    "remallimg"=>"esquerda2.gif", "insfield"=>"ja_inseridas", "remfield"=>"removidos",
                                    "sel_required"=>"F", "sel_size"=>"260", "avallabel"=>"Itens",
                                    "avalname"=>"itens","avalsize"=>"12" ,"aval_size"=>"260", "avalsql",
                                    "sellabel"=>"Itens Selecionados", "selname"=>"itens_selecionados", "selsql", "selfirst"=>"Selecionados", "selsize"=>"12",
                                    "required");

        //inclui array na variável $dados
        $dados = $propriedade_valida;
        foreach($this->propriedade as $k => $v) {
            if(!in_array($k, $propriedade_valida)) {
                $this->_msgErro("Propriedade <b>".$k."</b> do campo <b>".$this->name_input."</b> é inválida!");
            }

            //atualiza array $dados com informações fornecidas
            if($v > ""){
                $dados[$k] = $v;
            }

            //todos campo
            $this->campos[$this->name_input] = "";
        }


        //incluir js

        $this->script_js .= "<script language='JavaScript' type='text/javascript' src='".JS_PADRAO_PATH."lookupselection.js'></script>";


        $this->input[$this->name_input] =
            "<table cellpadding='2' cellspacing='0' border='0'>
                <tr>
                <td align='center'>
                <span class='texto1'>".$dados["avallabel"]."</span><br>
                </td>
                <td>&nbsp;</td>
                <td align='center'>
                <span class='texto1'>".$dados["sellabel"]."</span><br>
                </td>
                </tr>
                <tr>
                <td valign='top' rowspan='4'>
                <select name='".$dados["avalname"]."' id='".$dados["avalname"]."' size=".$dados["avalsize"]." multiple class='campos' style='width:".$dados["aval_size"]."px'>
                       ";
                //sql do primeiro select
                if($dados["avalsql"] > ""){
                    $this->DB->query($dados["avalsql"]);
                    while($row_aval =& $this->DB->fetch_array()){
                        $this->input[$this->name_input] .= "<option value='".$row_aval[0]."'>".$row_aval[1]."</option>\n";
                    }
                }

        $this->input[$this->name_input] .= "
                </select>
                </td>
                <td align='center' valign='middle'>
                <a href='javascript:void(0);' TITLE='Adicionar os Itens Selecionados'  ONMOUSEOVER='window.status=\"Adicionar os Itens Selecionados\"; return true;' ONMOUSEOUT='window.status=\"\"; return true;' onClick=selectAdd(\"".$this->nome."\",\"".$dados["avalname"]."\",\"".$dados["selname"]."\");><img src='".IMAGE_PATH.$dados["addimg"]."' border='0'></a>
                </td>
                <td align='center' rowspan='4' valign='top'><select name='".$dados["selname"]."' id='".$dados["selname"]."' style='width:".$dados["sel_size"]."px' size=".$dados["selsize"]." multiple class='campos'>
                   <option value='-1'>".$dados["selfirst"]."</option>
                   ";
                //sql do segundo select
                if($dados["selsql"] > ""){
                    $this->DB->query($dados["selsql"]);
                    while($row_sel =& $$this->DB->fetch_array()) {
                        $this->input[$this->name_input] .= "<option value='".$row_sel[0]."'>".$row_sel[1]."</option>\n";
                    }
                }

        $this->input[$this->name_input] .= "
                </select>
                </td>
                </tr>
                <tr>
                <td align='center' valign='middle'><a href='javascript:void(0);' TITLE='Adicionar Todos'  ONMOUSEOVER='window.status=\"Adicionar Todos\"; return true;' ONMOUSEOUT='window.status=\"\"; return true;' onClick=selectAddAll('".$this->nome."','".$dados["avalname"]."','".$dados["selname"]."');><img src='".IMAGE_PATH.$dados["addallimg"]."' border='0'></a>
                </td>
                </tr>
                <tr>
                <td align='center' valign='middle'><a href='javascript:void(0);' TITLE='Remover os Itens Selecionados'  ONMOUSEOVER='window.status=\"Remover os Itens Selecionados\"; return true;' ONMOUSEOUT='window.status=\"\"; return true;' onClick=selectRemove('".$this->nome."','".$dados["selname"]."');><img src='".IMAGE_PATH.$dados["remimg"]."' border='0'></a>
                </td>
                </tr>
                <tr>
                <td align='center' valign='middle'><a href='javascript:void(0);' TITLE='Remover Todos'  ONMOUSEOVER='window.status=\"Remover Todos\"; return true;' ONMOUSEOUT='window.status=\"\"; return true;' onClick=selectRemoveAll('".$this->nome."','".$dados["selname"]."');><img src='".IMAGE_PATH.$dados["remallimg"]."' border='0'></a>
                </td>
                </tr><tr><td colspan='3' align='right' class='texto1'>".$dados["sellabel"].":&nbsp;<input type='text' name='selinserted' size=3 style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #C0C0C0; border: 0px' onFocus='document.".$this->nome.".".$dados["selname"].".focus();' readonly>
                </td></tr>
            <input type='hidden' name='".$dados["insfield"]."'><input type='hidden' name='".$dados["remfield"]."'>
            <script language=\"javascript\">initLookupSelection(\"".$this->nome."\",\"".$dados["selname"]."\",\"".$dados["insfield"]."\",\"".$dados["remfield"]."\");</script>
            </table>";
    }

    /**
     * Print tag <form>
     */
    function addForm($nome) {
        //inclui js das maskaras
        $script .= $this->script_mask_js_date;
        $script .= $this->script_mask_js_moeda;
        $script .= $this->script_mask_js_integer;
        $script .= $this->script_mask_js_float;
        $script .= $this->script_mask_js_email;
        $script .= $this->script_mask_js_cep;
        $script .= $this->script_mask_js_cnpj;

        //incluir js de componentes
        if($this->script_js){
            $script .= $this->script_js;
        }

        //validação do formulário
        $script .= "<script language='JavaScript' type='text/javascript'>\n";
        $script .= "\n";
        $script .= "    function " . $nome . "_submit() {\n";
        $script .= "        msg = \"\";\n";

        //verificar campos para validação
        foreach($this->campos as $k => $v){
            if($this->campo_obrigatorio[$k] == "T"){
                $script .= "if (document.$nome.$k.value == '') {
                             msg = \"O campo '".$this->label[$k]."' é obrigatório.\"\n
                             if (msg > ''){
                                window.alert(msg);
                                document.$nome.$k.focus();
                                return false;
                             }
                        }
                ";
            }

            //se tiver mascara
            if($this->script_mask[$k]) {
                switch ($this->script_mask[$k]) {
                    case "date" :
                        $script .= "\n chk$nome = checkDATE(document.$nome.$k.value);
                                if (chk$nome == false) {
                                     msg = \"O campo \'".$this->label[$k]."\' contém um valor de Data inválido.\";
                                     alert(msg);
                                     document.$nome.$k.focus();
                                     return false;
                                }";
                        break;
                    case "email" :
                        $script .= "\n chk$nome = checkEMAIL(document.$nome.$k.value);
                                if (chk$nome == false) {
                                     msg = \"O campo \'".$this->label[$k]."\' contém um valor de email inválido.\";
                                     alert(msg);
                                     document.$nome.$k.focus();
                                     return false;
                                }";
                        break;
                    case "cnpj" :
                        $script .= "\n chk$nome = checkCPFCNPJ(document.$nome.$k.value);
                                if (chk$nome == false) {
                                     msg = \"O campo \'".$this->label[$k]."\' contém um valor de cnpj inválido.\";
                                     alert(msg);
                                     document.$nome.$k.focus();
                                     return false;
                                }";
                }
            }
        }
        $script .= "        return true;\n";
        $script .= "    }\n";
        $script .= "</script>";

        //printar script
        return $script."\n".$this->form[$nome];

        //printar html
//        echo $this->form[$nome];
    }

    /**
     * Print tag </form>
     */
    function addFormClose() {
        return "</form>";
    }

    /**
     * Print input
     */
    function addInput($nome) {
        return $this->input[$nome];
    }

    /**
     * Print label
     */
    function addLabel($nome) {
        if($this->campo_obrigatorio[$nome] == "T"){
            return $this->label[$nome]."*";
        }else{
            return $this->label[$nome];
        }
    }

    /**
     * _msgErro()
     * return mensgem de erro
     */
    function _msgErro($msg_erro) {
        die("<b>Classe Form:</b> ".$msg_erro);
    }

}
?>