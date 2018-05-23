

jQuery(document).ready(function () {

    loadParticipantes();

    jQuery(document).on('click', '#exportaExcel button', function (e) {
        e.preventDefault();

        jQuery("#excelHidden").tableToCSV();
    });

    jQuery('#slcPeriodoIndicadores').change(function () {

        var periodo = jQuery(this).val();
        var ano = jQuery('#slcPeriodoIndicadores option:selected').parent().attr("label");
        var mes = jQuery('#slcPeriodoIndicadores option:selected').text();
        var NumerosRecepcao = 0, NumerosOutros = 0;

        jQuery("#excel").find("table").each(function (index) {
            jQuery(this).show();
        });

        if (periodo != "" && periodo != "") {

            jQuery("#excel").find("table").each(function (index) {
                if (jQuery(this).attr("periodo") != periodo) { jQuery(this).hide(); } else {
                    jQuery(this).show("10", function () {
                        if (jQuery(this).attr("local") == "Mobile") { NumerosOutros++; } else { NumerosRecepcao++; }
                    });
                }
            });

            jQuery("#excelHidden").find("tr").each(function (index) {
                if (jQuery(this).attr("periodo") != periodo) { jQuery(this).hide(); } else { jQuery(this).show(); }
            });

            var qtd = jQuery("#excel").find("table[periodo=" + periodo + "]").length;
            jQuery(document).find("h4.Numeros").html(mes + ' - ' + ano + ': ' + qtd + ' visitantes');
            jQuery(document).find("h4.Tecnologia .Recepcao").html("Checkin na recepção: " + NumerosRecepcao);
            jQuery(document).find("h4.Tecnologia .Outros").html("Checkin pelo mobile: " + NumerosOutros);

        } else {

            jQuery("#excel").find("table").each(function (index) { jQuery(this).show(); });
            jQuery("#excelHidden").find("tr").each(function (index) { jQuery(this).show(); });
            jQuery("#excel").find("table").each(function (index) {
                if (jQuery(this).attr("local") == "Mobile") { NumerosOutros++; } else { NumerosRecepcao++; }
            });

            var qtd = jQuery("#excel").find("table").length;
            jQuery(document).find("h4.Numeros").html('Total: ' + qtd);
            jQuery(document).find("h4.Tecnologia .Recepcao").html("Checkin na recepção: " + NumerosRecepcao);
            jQuery(document).find("h4.Tecnologia .Outros").html("Checkin pelo mobile: " + NumerosOutros);

        }
    });

});

function loadParticipantes() {
    jQuery.ajax({
        type: "GET",
        url: "/loopParticipantes.php",
        success: function (part) {

            var Participantes = JSON.parse(part), Infos = "", Table = "", Numeros = "Total: " + Participantes.length, NumerosRecepcao = 0, NumerosOutros = 0, NumerosEmpty = 0;

            jQuery.each(Participantes, function (index, participante) {

                var dia, mes, ano;
                ano = participante.data.slice(0, 4);
                mes = participante.data.slice(5, 7);
                dia = participante.data.slice(8, 10);

                if (jQuery("#slcPeriodoIndicadores optgroup").length) {
                    jQuery(document).find("#slcPeriodoIndicadores").find("optgroup").each(function (index) {
                        var Label = jQuery(this).attr("label");
                        if (Label != ano) {
                            jQuery("#slcPeriodoIndicadores").append('<optgroup label="' + ano + '"></optgroup>');
                        }
                    });
                }
                else {
                    jQuery("#slcPeriodoIndicadores").append('<optgroup label="' + ano + '"></optgroup>');
                }

                var Useragent = participante.useragent;
                if (Useragent == "" || Useragent == null || Useragent == "-" || Useragent == "Não informado" || Useragent == "Mozilla/5.0 (iPad; CPU OS 9_3_5 like Mac OS X) AppleWebKit/601.1 (KHTML, like Gecko) CriOS/63.0.3239.73 Mobile/13G36 Safari/601.1.46") { NumerosRecepcao++; } else { NumerosOutros++; }
            });

            // CORTA DUPLICADOS
            var seen = {};
            jQuery("#slcPeriodoIndicadores optgroup").each(function () {
                var txt = jQuery(this).attr("label");
                if (seen[txt]) { jQuery(this).remove(); } else { seen[txt] = true; }
            });

            // ORDENA DUPLICADOS
            var selectList = jQuery('#slcPeriodoIndicadores optgroup');
            selectList.sort(function (a, b) {
                a = a.value;
                b = b.value;
                return b - a;
            });
            jQuery('#slcPeriodoIndicadores').html(selectList);
            jQuery('#slcPeriodoIndicadores').prepend('<option value="" selected>Selecione o período</option>');

            jQuery.each(Participantes, function (index, value) {
                var startDate = new Date(value.data);
                var Nmonth = jQuery.datepicker.formatDate('mm', new Date(startDate));
                var Nyear = startDate.getFullYear();
                var Fmonth = jQuery.datepicker.formatDate('MM', new Date(startDate));

                jQuery("#slcPeriodoIndicadores").find("optgroup").each(function (index) {
                    var Label = jQuery(this).attr("label");
                    if (Label == Nyear) {
                        if (jQuery(this).find('option:contains(' + Fmonth + ')').length) {
                        }
                        else {
                            jQuery(this).append('<option value="' + Nyear + '-' + Nmonth + '" mes="' + Nmonth + '">' + Fmonth + '</option>');
                        }
                    }
                });
            });

            console.log(Participantes);

            jQuery.each(Participantes, function (index, participante) {

                var startDate = new Date(participante.data);
                var Nmonth = jQuery.datepicker.formatDate('mm', new Date(startDate));
                var Nyear = startDate.getFullYear();
                var Fmonth = jQuery.datepicker.formatDate('MM', new Date(startDate));

                var ferramenta = participante.oauth_provider;
                if (ferramenta == "" || ferramenta == null) { ferramenta = "weme"; }

                var nome = participante.name;
                if (participante.sobrenome != "" && participante.sobrenome != null && participante.sobrenome != "-") { nome = participante.name + " " + participante.sobrenome; }
                if (nome == "" || nome == null) {
                    nome = participante.email;
                }

                var Sobre = participante.sobre;
                if (Sobre == "" || Sobre == null || Sobre == "-") { Sobre = "Não informado"; }

                var Empresa = participante.empresa;
                if (Empresa == "" || Empresa == null || Empresa == "-") { Empresa = "Não informado"; }

                var Useragent = participante.useragent;
                var LocalCheckin = "";
                if (Useragent == "" || Useragent == null || Useragent == "-" || Useragent == "Não informado") { Useragent = "Não informado"; LocalCheckin = "Não informado"; }
                if (Useragent == "Mozilla/5.0 (iPad; CPU OS 9_3_5 like Mac OS X) AppleWebKit/601.1 (KHTML, like Gecko) CriOS/63.0.3239.73 Mobile/13G36 Safari/601.1.46" && Useragent != "Não informado") { LocalCheckin = "Recepcao"; }
                if (Useragent != "Mozilla/5.0 (iPad; CPU OS 9_3_5 like Mac OS X) AppleWebKit/601.1 (KHTML, like Gecko) CriOS/63.0.3239.73 Mobile/13G36 Safari/601.1.46" && Useragent != "Não informado") { LocalCheckin = "Mobile"; }

                var Imagem = "";
                if (participante.imagem != "" && participante.imagem != null) {
                    if ((participante.imagem).indexOf("http") >= 0) { Imagem = '<img src="' + participante.imagem + '">'; }
                }
                Table += '<table periodo="' + Nyear + '-' + Nmonth + '" local="' + LocalCheckin + '"><tr>';
                Table += '<td class="Imagem" rowspan="7">' + Imagem + '</td>';
                Table += '<td class="Nome">Nome: ' + nome + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Email">E-mail: ' + participante.email + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Empresa">Empresa: ' + Empresa + '</td>';
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
                Table += '<tr>';
                Table += '<td class="Onde">Por onde fez o check-in: ' + Useragent + '</td>';
                Table += '</tr>';
                Table += '<tr><td class="Vazio"></td></tr></table>';

                Infos += '<tr periodo="' + Nyear + '-' + Nmonth + '">';
                Infos += '<td class="Nome">' + nome + '</td>';
                Infos += '<td class="Email">' + participante.email + '</td>';
                Infos += '<td class="Empresa">' + Empresa + '</td>';
                Infos += '<td class="Data">' + participante.data + '</td>';
                Infos += '<td class="Objetivo">' + participante.objetivo + '</td>';
                Infos += '<td class="Onde">' + Useragent + '</td>';
                Infos += '</tr>';
            });

            jQuery(document).find("#excel").append(Table);
            jQuery(document).find("#excelHidden").append(Infos);
            jQuery(document).find("h4.Numeros").html(Numeros);
            jQuery(document).find("h4.Tecnologia .Recepcao").html("Checkin na recepção: " + NumerosRecepcao);
            jQuery(document).find("h4.Tecnologia .Outros").html("Checkin pelo mobile: " + NumerosOutros);
        }
    });
}