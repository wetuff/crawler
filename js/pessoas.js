

$(document).ready(function () {

    loadParticipantes();

    $(document).on('click', '#exportaExcel', function (e) {
        e.preventDefault();

        jQuery.getScript('http://www.weme.com.br/checkin/js/jquery.tabletoCSV.js').done(function (script, textStatus) {
            jQuery("#excelHidden").tableToCSV();
        });
    });

});

function loadParticipantes() {
    jQuery.ajax({
        type: "GET",
        url: "/relatorio/loopParticipantes.php",
        success: function (part) {
            var Participantes = JSON.parse(part), Infos = "", Table = "";
            var ids = [];

            jQuery.each(Participantes, function (index, participante) {

                //console.log(jQuery.inArray(participante.id, ids));

                if (jQuery.inArray(participante.id, ids) == -1) {

                    var ferramenta = participante.oauth_provider;
                    if (ferramenta == "" || ferramenta == null) { ferramenta = "weme"; }

                    var nome = participante.name;
                    if (participante.sobrenome != "" && participante.sobrenome != null && participante.sobrenome != "-") { nome = participante.name + " " + participante.sobrenome; }

                    var Sobre = participante.sobre;
                    if (Sobre == "" || Sobre == null || Sobre == "-") { Sobre = "Não informado"; }

                    var Imagem = "";
                    if ((participante.imagem).indexOf("http") >= 0) { Imagem = '<img src="' + participante.imagem + '">'; }

                    Table += '<tr>';
                    Table += '<td class="Imagem" rowspan="6">' + Imagem + '</td>';
                    Table += '<td class="Nome">Nome: ' + nome + '</td>';
                    Table += '</tr>';
                    Table += '<tr>';
                    Table += '<td class="Email">E-mail: ' + participante.email + '</td>';
                    Table += '</tr>';
                    Table += '<tr>';
                    Table += '<td class="Sobre">Sobre: ' + Sobre + '</td>';
                    Table += '</tr>';
                    Table += '<tr>';
                    Table += '<td class="Data">Data: ' + participante.data + '</td>';
                    Table += '</tr>';
                    Table += '<tr>';
                    Table += '<td class="Objetivo">Objetivo: ' + participante.objetivo + '</td>';
                    Table += '</tr>';
                    Table += '<tr><td class="Vazio"></td></tr>';

                    ids.push(participante.id);
                }

            });

            jQuery(document).find("#excel").append(Table);
        }
    });
}