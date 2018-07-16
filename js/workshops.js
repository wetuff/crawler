
window.chartColors = { red: 'rgb(255, 99, 132)', orange: 'rgb(255, 159, 64)', yellow: 'rgb(255, 205, 86)', green: 'rgb(75, 192, 192)', blue: 'rgb(54, 162, 235)', purple: 'rgb(153, 102, 255)', grey: 'rgb(201, 203, 207)', black: 'rgb(0, 0, 0)' };
window.chartColorsOpacity = { red: 'rgb(255, 99, 132, 0.5)', orange: 'rgb(255, 159, 64, 0.5)', yellow: 'rgb(255, 205, 86, 0.5)', green: 'rgb(75, 192, 192, 0.5)', blue: 'rgb(54, 162, 235, 0.5)', purple: 'rgb(153, 102, 255, 0.5)', grey: 'rgb(201, 203, 207, 0.5)', black: 'rgb(0, 0, 0, 0.5)' };

jQuery(document).ready(function () {

    if ($(document).find("#listaWorkshops").length > 0) {
        var options = {
            valueNames: ['titulo']
        };
        var userList = new List('secWorkshops', options);
    }

    $(document).on('click', '#btnSaveEvent', function () {
        var id = $(this).attr("evento");
        updateEvento(id);
    });

    $(document).on('click', '#btnAddTendencia', function () {
        var tendencia = $(document).find("#txtNovaTendencia").val();
        adicionaTendencia(tendencia);
    });

});

function loadWorkshops(Infos, Tendencias, Relacao) {

    informacoes = Infos.sort(function (a, b) {
        var aName = a.data.toLowerCase();
        var bName = b.data.toLowerCase();
        return ((aName > bName) ? -1 : ((aName < bName) ? 1 : 0));
    });

    var HTML = "";
    jQuery.each(informacoes, function (index, workshop) {

        var tendencias = "";

        jQuery.each(Relacao, function (index, relacao) {
            jQuery.each(Tendencias, function (index, tendencia) {
                if (relacao.id == workshop.workshop && relacao.tendencia == tendencia.id) {
                    tendencias += (tendencia.tendencia + ', ');
                }
            });
        });

        var total = (parseInt(workshop.inscritos) * parseInt(workshop.preco));
        HTML += '<a href="/workshops/workshop.php?id=' + workshop.workshop + '"><span class="titulo">' + workshop.nome + '</span><span class="infos"><span class="data">' + workshop.data + '</span><span class="preco">' + workshop.preco + '</span><span class="inscritos">' + workshop.inscritos + '</span><span class="total">R$ ' + total + '</span></span><span class="tags">' + tendencias + '</span></a>';
    });

    jQuery(document).find("#listaWorkshops").html(HTML);
    jQuery(document).find(".Extra").html('Já foram realizados <b>' + informacoes.length + '</b> eventos até o momento.');

    // Tipos de Gráficos
    ////////////////////

    var Top5EventosMovimentadosFinal = [];
    var Top5EventosMovimentadosNomes = [];
    var grfTop5EventosMovimentados = document.getElementById('grfTop5EventosMovimentados');
    var grfTop5EventosMovimentadosData = {};

    var informacoesGrf = Infos.sort(function (a, b) {
        var aName = a.inscritos.toLowerCase();
        var bName = b.inscritos.toLowerCase();
        return bName - aName
    });

    jQuery.each(informacoesGrf, function (index, workshop) {
        if (index < 5) {
            Top5EventosMovimentadosFinal.push(parseInt(workshop.inscritos));
            Top5EventosMovimentadosNomes.push(workshop.nome);
        }
    });

    var grfTop5EventosMovimentadosData = {
        datasets: [{
            data: Top5EventosMovimentadosFinal,
            backgroundColor: [window.chartColors.red, window.chartColors.orange, window.chartColors.yellow, window.chartColors.green, window.chartColors.blue]
        }],
        labels: Top5EventosMovimentadosNomes
    };
    var grfTop5EventosMovimentados = new Chart(grfTop5EventosMovimentados, {
        type: 'pie',
        data: grfTop5EventosMovimentadosData,
        options: {
            responsive: true, legend: { position: 'bottom' }
        }
    });

}

function loadTendencias(Infos, Relacao, Evento, Macro, RelacaoMacro) {

    // MICROTENDÊNCIAS
    ////////////////////
    var HTML = "";

    jQuery.each(Infos, function (index, tendencia) {
        HTML += '<option value="' + tendencia.id + '">' + tendencia.tendencia + '</option>';
    });

    $("#microTendencias").html('').append(HTML);

    jQuery.each(Relacao, function (index, relation) {
        $("#microTendencias option[value='" + relation.tendencia + "']").prop("selected", true).attr('selected', 'selected');
    });

    // MACROTENDÊNCIAS
    ////////////////////
    var HTML = '<option value="0">Selecione uma tendência</option>';

    jQuery.each(Macro, function (index, tendencia) {
        HTML += '<option value="' + tendencia.id + '">' + tendencia.tendencia + '</option>';
    });

    $("#macroTendencias").html('').append(HTML);

    jQuery.each(RelacaoMacro, function (index, relation) {
        $("#macroTendencias option[value='" + relation.tendencia + "']").prop("selected", true).attr('selected', 'selected');
    });
}

function updateEvento(id) {

    var nome, micro = [], macro;

    nome = $(document).find("#txtName").val();
    macro = $(document).find("#macroTendencias option:selected").val();
    $(document).find("#microTendencias option:selected").each(function (i) {
        micro.push({ id: $(this).val(), tendencia: $(this).text() })
    });

    $.ajax({
        type: "POST",
        url: "/workshops/updateEvento.php",
        data: { id: id, nome: JSON.stringify(nome), macro: JSON.stringify(macro), micro: JSON.stringify(micro) },
        success: function (data) {
            alert("Atualização realizada com sucesso");
            window.location = "/workshops/";
        }
    });

}

function adicionaTendencia(tendencia) {

    $.ajax({
        type: "POST",
        url: "/workshops/addTendencia.php",
        data: { nome: JSON.stringify(tendencia) },
        success: function (data) {
            $(document).find("#txtNovaTendencia").val('');
            location.reload();
        }
    });
}