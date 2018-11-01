
jQuery(document).ready(function () {

    // Load Data
    ////////////////////

    if ($(document).find("#listaProjetos").length > 0) {
        var options = {
            valueNames: ['titulo', 'empresa']
        };
        var userList = new List('secProjetos', options);
    }

});

function loadProjetos(info, times) {

    console.log(info);

    var Projetos = info;
    Projetos = Projetos.sort(function (a, b) {
        var aName = (a.nome.toLowerCase());
        var bName = (b.nome.toLowerCase());
        return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
        //return (bName) < (aName) ? 1 : -1;    
    });

    // FILTRO EMPRESAS
    ////////////////////////

    var HTML = "";

    jQuery.each(Projetos, function (index, projeto) {

        var codigoProjeto = "";
        if (projeto.codigo != "" && projeto.codigo != null && parseInt(projeto.codigo) != 0) {
            codigoProjeto = '[' + projeto.codigo + '] ';
        }

        HTML += '<a href="/projetos/projeto.php?projeto=' + projeto.id + '">';
        HTML += '<div class="titulo">' + codigoProjeto + projeto.nome + '</div>';
        HTML += '<div class="empresa">' + projeto.nomeCliente + '</div>';
        HTML += '</a>';

    });

    $("#listaProjetos").append(HTML);

}