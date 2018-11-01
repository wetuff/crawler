

jQuery(document).ready(function () {

    loadParticipantes();

    jQuery("#txtData").datepicker({
        maxDate: '0',
        dateFormat: 'yy-mm-dd',
        onSelect: function (selectedDate) {
            filtroPeriodo(selectedDate);
        }
    });

    jQuery(document).on('click', '#exportaExcel button', function (e) {
        e.preventDefault();

        jQuery("#excelHidden").tableToCSV();
    });

    jQuery('#slcPeriodoIndicadores').change(function () {

        var periodo = jQuery(this).val();

        if (periodo == "" || periodo == null) {
            jQuery(document).find("#txtData").show();
        } else {
            var ano = jQuery('#slcPeriodoIndicadores option:selected').parent().attr("label");
            var mes = jQuery('#slcPeriodoIndicadores option:selected').text();
            jQuery(document).find("#txtData").hide();
            filtroPeriodo(periodo);
        }

    });

});

function loadParticipantes() {

    jQuery.ajax({
        type: "GET",
        url: "/loopAll.php",
        success: function (part) {
            var informacoes = JSON.parse(part);
            var People = informacoes[0].pessoas;
            var Obj = informacoes[0].objetivos;
            var Invalido = informacoes[0].outros;
            var Infos = "", Table = "", Numeros = "Total: " + Obj.length, NumerosRecepcao = 0, NumerosOutros = 0, NumerosEmpty = 0;

            Infos += '<tr periodo="all">';
            Infos += '<td class="Nome">Nome</td>';
            Infos += '<td class="Email">E-mail</td>';
            Infos += '<td class="Empresa">Empresa</td>';
            Infos += '<td class="Cargo">Cargo</td>';
            Infos += '<td class="Data">Data</td>';
            Infos += '<td class="Objetivo">Objetivo</td>';
            Infos += '<td class="Motivo">Motivo</td>';
            Infos += '<td class="Onde">Useragent</td>';
            Infos += '</tr>';

            function existsUid(id, Invalido) {
                var item, i = 0;
                while (item = Invalido[i++])
                    if (item.id == id) return true
                return false
            }

            jQuery.each(Obj, function (index, participante) {

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
            jQuery('#slcPeriodoIndicadores').prepend('<option value="yesterday">Ontem</option>').prepend('<option value="today">Hoje</option>').prepend('<option value="all" selected>Todos os cadastros</option>').prepend('<option value="">Selecione o período</option>');

            jQuery.each(Obj, function (index, value) {
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

            jQuery.each(Obj, function (index, participante) {

                var idObjetivo = participante.id, Email = "", ferramenta = "weme", Sobre = "Não informado", Empresa = "Não informado", Cargo = "Não informado", nome = "Não informado", Imagem = "", Useragent = "", LocalCheckin = "";

                var startDate = new Date(participante.data);
                var Nmonth = jQuery.datepicker.formatDate('mm', new Date(startDate));
                var Nyear = startDate.getFullYear();
                var Fmonth = jQuery.datepicker.formatDate('MM', new Date(startDate));

                Useragent = participante.useragent;
                if (Useragent == "" || Useragent == null || Useragent == "-" || Useragent == "Não informado") { Useragent = "Não informado"; LocalCheckin = "Não informado"; }
                if (Useragent == "Mozilla/5.0 (iPad; CPU OS 9_3_5 like Mac OS X) AppleWebKit/601.1 (KHTML, like Gecko) CriOS/63.0.3239.73 Mobile/13G36 Safari/601.1.46" && Useragent != "Não informado") { LocalCheckin = "Recepcao"; }
                if (Useragent != "Mozilla/5.0 (iPad; CPU OS 9_3_5 like Mac OS X) AppleWebKit/601.1 (KHTML, like Gecko) CriOS/63.0.3239.73 Mobile/13G36 Safari/601.1.46" && Useragent != "Não informado") { LocalCheckin = "Mobile"; }


                if (existsUid(idObjetivo, Invalido) == true) {

                    jQuery.each(Invalido, function (index, inv) {

                        // Usuários incompletos
                        if (idObjetivo == inv.id) {
                            Email += inv.email;
                            nome = "";
                            nome += Email;
                        }

                    });
                } else {

                    jQuery.each(People, function (index, ppl) {

                        // Usuários completos
                        if (idObjetivo == ppl.id) {

                            Email += ppl.email;

                            if (ppl.sobrenome != "" && ppl.sobrenome != null && ppl.sobrenome != "-") { nome = ""; nome += ppl.name + " " + ppl.sobrenome; } else { nome = ""; nome += ppl.name; }
                            if (nome == "" || nome == null) { nome = ""; nome += Email; }

                            if (ppl.oauth_provider != "" && ppl.oauth_provider != null) { ferramenta = ""; ferramenta += ppl.oauth_provider; }
                            if (ppl.empresa != "" && ppl.empresa != null) { Empresa = ""; Empresa += ppl.empresa; }
                            if (ppl.sobre != "" && ppl.sobre != null) { Sobre = ""; Sobre += ppl.sobre; }
                            if (ppl.cargo != "" && ppl.cargo != null) { Cargo = ""; Cargo += ppl.cargo; }

                            if (ppl.imagem != "" && ppl.imagem != null) {
                                if ((ppl.imagem).indexOf("http") >= 0) { Imagem += '<img src="' + ppl.imagem + '">'; }
                            }
                        }

                    });
                }

                Table += '<table periodo="' + Nyear + '-' + Nmonth + '" local="' + LocalCheckin + '"><tr>';
                Table += '<td class="Imagem" rowspan="9">' + Imagem + '</td>';
                Table += '<td class="Nome">Nome: ' + nome + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Email">E-mail: ' + Email + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Empresa">Empresa: ' + Empresa + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Cargo">Cargo: ' + Cargo + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Sobre">Sobre: ' + Sobre + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Data" data="' + (participante.data).slice(0, 10) + '">Data: ' + participante.data + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Objetivo">Objetivo: ' + participante.objetivo + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Motivo">Motivo: ' + participante.motivo + '</td>';
                Table += '</tr>';
                Table += '<tr>';
                Table += '<td class="Onde">Por onde fez o check-in: ' + Useragent + '</td>';
                Table += '</tr>';
                Table += '<tr><td class="Vazio"></td></tr></table>';

                Infos += '<tr periodo="' + Nyear + '-' + Nmonth + '">';
                Infos += '<td class="Nome">' + nome + '</td>';
                Infos += '<td class="Email">' + Email + '</td>';
                Infos += '<td class="Empresa">' + Empresa + '</td>';
                Infos += '<td class="Cargo">' + Cargo + '</td>';
                Infos += '<td class="Data" data="' + (participante.data).slice(0, 10) + '">' + participante.data + '</td>';
                Infos += '<td class="Objetivo">' + participante.objetivo + '</td>';
                Infos += '<td class="Motivo">' + participante.motivo + '</td>';
                Infos += '<td class="Onde">' + Useragent + '</td>';
                Infos += '</tr>';

            });

            jQuery(document).find("#excel").append(Table);
            jQuery(document).find("#excelHidden").append(Infos);
            jQuery(document).find("h4.Numeros").html(Numeros);
            jQuery(document).find("h4.Tecnologia .Recepcao").html("Checkin na recepção: " + NumerosRecepcao);
            jQuery(document).find("h4.Tecnologia .Outros").html("Checkin pelo mobile: " + NumerosOutros);

            //jQuery('#slcPeriodoIndicadores').val('today');
        }
    });
}

function filtroPeriodo(periodo) {

    jQuery("#excel").find("table").each(function (index) {
        jQuery(this).show();
    });

    var NumerosOutros = 0, NumerosRecepcao = 0;

    if (periodo == "today" || periodo == "yesterday" || periodo.length >= 10) {

        var dataEscolhida, diaEscolhido, mesEscolhido, anoEscolhido;

        if (periodo == "today") { dataEscolhida = new Date(); }
        else if (periodo == "yesterday") { dataEscolhida = new Date(); dataEscolhida.setDate(dataEscolhida.getDate() - 1); }
        else { dataEscolhida = new Date(periodo.slice(0, 4) + "/" + periodo.slice(5, 7) + "/" + periodo.slice(8, 10)); }

        diaEscolhido = ("0" + dataEscolhida.getDate()).slice(-2), mesEscolhido = ("0" + (dataEscolhida.getMonth() + 1)).slice(-2), anoEscolhido = dataEscolhida.getFullYear();

        jQuery("#excel").find("table").each(function (index) {
            if (jQuery(this).find(".Data").attr("data") != (anoEscolhido + "-" + mesEscolhido + "-" + diaEscolhido)) { jQuery(this).hide(); } else {
                if (jQuery(this).attr("local") == "Mobile") { NumerosOutros++; } else { NumerosRecepcao++; }
            }
        });

        jQuery("#excelHidden").find("tr").each(function (index) {
            if (jQuery(this).find(".Data").attr("data") != (anoEscolhido + "-" + mesEscolhido + "-" + diaEscolhido)) { jQuery(this).hide(); } else { jQuery(this).show(); }
        });

        var qtd = jQuery("#excel").find("table:visible").length;
        jQuery(document).find("h4.Numeros").html(diaEscolhido + '/' + mesEscolhido + '/' + anoEscolhido + ': ' + qtd + ' visitantes');
        jQuery(document).find("h4.Tecnologia .Recepcao").html("Checkin na recepção: " + NumerosRecepcao);
        jQuery(document).find("h4.Tecnologia .Outros").html("Checkin pelo mobile: " + NumerosOutros);

    }
    else if (periodo == "all") {

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
    else {

        jQuery("#excel").find("table").each(function (index) {
            if (jQuery(this).attr("periodo") != periodo) { jQuery(this).hide(); } else {
                if (jQuery(this).attr("local") == "Mobile") { NumerosOutros++; } else { NumerosRecepcao++; }
            }
        });

        jQuery("#excelHidden").find("tr").each(function (index) {
            if (jQuery(this).attr("periodo") != periodo) { jQuery(this).hide(); } else { jQuery(this).show(); }
        });

        var qtd = jQuery("#excel").find("table[periodo=" + periodo + "]").length;
        jQuery(document).find("h4.Numeros").html(periodo.slice(5, 7) + '/' + periodo.slice(0, 4) + ': ' + qtd + ' visitantes');
        jQuery(document).find("h4.Tecnologia .Recepcao").html("Checkin na recepção: " + NumerosRecepcao);
        jQuery(document).find("h4.Tecnologia .Outros").html("Checkin pelo mobile: " + NumerosOutros);

    }

    jQuery("#excelHidden").find("tr[periodo=all]").each(function (index) {
        jQuery(this).show();
    });

}