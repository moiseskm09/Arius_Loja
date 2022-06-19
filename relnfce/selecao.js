$(document).ready( function(){
    $("#dataproc_i").select();
    $(".data").mask('99/99/9999');
    $(".data").datepicker();
});

function submitForm ()
{
    $("#formulario").attr("action", 'config.phtml');
    $("#formulario").submit();
}

function buscaPrimeira ()
{
    $("#pagina").val(1);
    submitForm();
}

function buscaUltima ()
{
    totPaginas = $("#formulario").attr("data-total-paginas");
    $("#pagina").val( totPaginas );
    submitForm();
}

function buscaAnterior ()
{
    if($("#pagina").val() > 0){
        $("#pagina").val( parseInt($("#pagina").val()) - 1 );
        submitForm();
    }
}

function buscaProxima ()
{
    totPaginas = parseInt($("#formulario").attr("data-total-paginas"));
    
    if( parseInt($("#pagina").val()) < totPaginas){
        var pag = parseInt($("#pagina").val()) + 1;
        $("#pagina").val(pag);
        submitForm();
    }
}

$("#btn_csv").click(function(){
        if ( verifica_data() ) {
            $("#csv").val(1);
            $("#form1").attr("action", "selecao.php");
            $("#form1").attr("target", "_self");
            $("#form1").submit();
            $("#csv").val(0);
        }
    });