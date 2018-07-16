
window.chartColors = { red: 'rgb(255, 99, 132)', orange: 'rgb(255, 159, 64)', yellow: 'rgb(255, 205, 86)', green: 'rgb(75, 192, 192)', blue: 'rgb(54, 162, 235)', purple: 'rgb(153, 102, 255)', grey: 'rgb(201, 203, 207)', black: 'rgb(0, 0, 0)' };
window.chartColorsOpacity = { red: 'rgb(255, 99, 132, 0.5)', orange: 'rgb(255, 159, 64, 0.5)', yellow: 'rgb(255, 205, 86, 0.5)', green: 'rgb(75, 192, 192, 0.5)', blue: 'rgb(54, 162, 235, 0.5)', purple: 'rgb(153, 102, 255, 0.5)', grey: 'rgb(201, 203, 207, 0.5)', black: 'rgb(0, 0, 0, 0.5)' };

var PrincipaisNoticiasBrasil = "https://news.google.com.br/news/feeds?pz=1&cf=all&ned=pt-BR_br&hl=pt-BR&output=rss";
var PrincipaisNoticiasMundo = "https://news.google.com.br/news/feeds?pz=1&cf=all&ned=pt-BR_br&hl=pt-BR&topic=w&output=rss";
//var PrincipaisVideosBrasilURL = "https://content.googleapis.com/youtube/v3/videos?part=snippet&chart=mostPopular&locale=br&maxResults=5&key=";
var PrincipaisVideosBrasilURL = "https://content.googleapis.com/youtube/v3/videos?part=snippet&chart=mostPopular&locale=br&maxResults=5&key=";
var PrincipaisVideosBrasil;

jQuery(document).ready(function () {

    // Load Data
    ////////////////////

    jQuery(document).on('click', '#exportaExcel a', function (e) {
        e.preventDefault();

        jQuery("#excelHidden").tableToCSV();
    });

    if ($(document).find("#listaMicroTendencias").length > 0) {
        var options = {
            valueNames: ['titulo']
        };
        var userList = new List('secTendencias', options);
    }

});

function loadTendencia(word, infos, micros) {

    $("h2 span").html(word);

    //var urlFeed = "https://newsapi.org/v2/everything?q=" + word + " macrotendência&apiKey=";
    //var urlFeed = "https://news.google.com/search?q=tecnologia+macrotend%C3%AAncia&output=rss&hl=pt-BR&gl=BR&ceid=BR:pt-419";
    //var urlFeed = "https://news.google.com.br/news/feeds?pz=1&cf=all&ned=pt-BR_br&hl=pt-BR&q=" + word + " macrotendência&output=json";
    //var urlFeed = "https://api.rss2json.com/v1/api.json?rss_url=https%3A%2F%2Fnews.google.com.br%2Fnews%2Ffeeds%3Fpz%3D1%26cf%3Dall%26ned%3Dpt-BR_br%26hl%3Dpt-BR%26q%3D" + word + "%2Bmacrotend%C3%AAncia%26output%3Djson&api_key=";

    var urlFeed;
    if (word.toLowerCase() == "tecnologia") {
        urlFeed = "https://api.rss2json.com/v1/api.json?rss_url=https%3A%2F%2Fnews.google.com.br%2Fnews%2Ffeeds%3Fcf%3Dall%26hl%3Dpt-BR%26ned%3Dpt-BR_br%26output%3Djson%26pz%3D1%26q%3Dtendencia%2Btecnol%C3%B3gica&api_key=";
    }
    if (word.toLowerCase() == "empreendedorismo") {
        urlFeed = "https://api.rss2json.com/v1/api.json?rss_url=https%3A%2F%2Fnews.google.com.br%2Fnews%2Ffeeds%3Fcf%3Dall%26hl%3Dpt-BR%26ned%3Dpt-BR_br%26output%3Djson%26pz%3D1%26q%3Dempreendedorismo&api_key=";
    }
    if (word.toLowerCase() == "educação" || word.toLowerCase() == "educa%C3%A7%C3%A3o") {
        urlFeed = "https://api.rss2json.com/v1/api.json?rss_url=https%3A%2F%2Fnews.google.com.br%2Fnews%2Ffeeds%3Fcf%3Dall%26hl%3Dpt-BR%26ned%3Dpt-BR_br%26output%3Djson%26pz%3D1%26q%3Dtecnologia%2Beduca%25C3%25A7%25C3%25A3o&api_key=";
    }
    if (word.toLowerCase() == "design") {
        urlFeed = "https://api.rss2json.com/v1/api.json?rss_url=https%3A%2F%2Fnews.google.com.br%2Fnews%2Ffeeds%3Fcf%3Dall%26hl%3Dpt-BR%26ned%3Dpt-BR_br%26output%3Djson%26pz%3D1%26q%3Dinova%25C3%25A7%25C3%25A3o%2Bdesign&api_key=";
    }
    if (word.toLowerCase() == "saúde") {
        urlFeed = " https://api.rss2json.com/v1/api.json?rss_url=https%3A%2F%2Fnews.google.com.br%2Fnews%2Ffeeds%3Fcf%3Dall%26hl%3Dpt-BR%26ned%3Dpt-BR_br%26output%3Djson%26pz%3D1%26q%3Dinova%25C3%25A7%25C3%25A3o%2Bsa%25C3%25BAde&api_key=";
    }
    var visitante = "";

    jQuery.each(infos, function (index, interessado) {
        visitante += '<tr>';
        visitante += '<td class="nomeVisitante">' + interessado.nome + '</td>';
        visitante += '<td class="emailVisitante">' + interessado.email + '</td>';
        visitante += '</tr>';
    });

    $("#excelHidden").html(visitante);

    if (urlFeed != "" && urlFeed != null) {

        $.ajax({
            url: urlFeed,
            dataType: 'json',
            success: function (data) {

                var HTML = "";

                // FILTRO NOTICIAS
                ////////////////////////

                jQuery.each(data.items, function (index, noticia) {
                    HTML += '<li><a class="noticia" href="' + noticia.link + '">';
                    HTML += '<span class="titulo">' + noticia.title + '</span>';
                    HTML += '<span class="data">' + noticia.pubDate + '</span>';
                    HTML += '</a></li>';
                });

                $("#listaNoticias").html(HTML);
            }
        });
    } else {
        $("#Noticias").remove();
        if (infos.length <= 0) {
            $("#exportaExcel").remove();
        }
    }

    // MICROTENDÊNCIAS RELACIONADAS
    ///////////////////////////////

    var HTML = "";

    if (micros != "" && micros != null) {

        var idsMicro = [];
        var tendenciasMicro = [];
        var pesoMicro = [];

        jQuery.each(micros, function (index, tendencia) {
            if (jQuery.inArray(tendencia.idT, idsMicro) == -1) {
                idsMicro.push(tendencia.idT);
                tendenciasMicro.push(tendencia.tendencia);
                pesoMicro.push(1);
            } else {
                var posicao = jQuery.inArray(tendencia.idT, idsMicro);
                var valor = pesoMicro[posicao];
                valor++;
                pesoMicro[posicao] = valor;
            }
        });

        jQuery.each(idsMicro, function (index, tendencia) {
            HTML += '<li style="font-size:' + (parseInt(pesoMicro[index]) + 15) + 'px;"><a href="/tendencias/tendencia.php?tendencia=' + idsMicro[index] + '"><span class="titulo">' + tendenciasMicro[index] + '</span></a></li>';
        });

    }
    $("#microtendencias span").html(HTML);
}

function loadAllTendencias(micro, macro) {

    // MICROTENDÊNCIAS
    ////////////////////

    var ids = [];
    var tendencias = [];
    var HTML = "";

    jQuery.each(micro, function (index, tendencia) {
        if (jQuery.inArray(tendencia.idT, ids) == -1) {
            ids.push(tendencia.idT);
            tendencias.push(tendencia.tendencia);
        }
    });

    jQuery.each(ids, function (index, tendencia) {
        HTML += '<li><a href="/tendencias/tendencia.php?tendencia=' + tendencia + '"><span class="titulo">' + tendencias[index] + '</span></a></li>';
    });

    $("#listaMicroTendencias").html(HTML);

    var Top5MicrotendenciasVisitas = [];
    var Top5MicrotendenciasNomes = [];
    var grfTop5Microtendencias = document.getElementById('grfTop5Microtendencias');
    var grfTop5MicrotendenciasData = {};

    var nomeInteresses = [], idInteresses = [], dataInteresses = [], Compilado = [];

    jQuery.each(micro, function (index, interesse) {

        var nome = interesse.tendencia;

        // Checa se existe senão adiciona
        if (jQuery.inArray(interesse.idT, idInteresses) == -1) {
            idInteresses.push(interesse.idT);
            nomeInteresses.push(interesse.tendencia);
            dataInteresses.push(1);
        } else {
            var posicao = jQuery.inArray(interesse.idT, idInteresses);
            var valor = dataInteresses[posicao];
            valor++;
            dataInteresses[posicao] = valor;
        }
    });

    // Ordena e compila
    for (var i = 0, len = dataInteresses.length; i < len; i++) {
        Compilado.push({ "tendencia": nomeInteresses[i], "visitas": dataInteresses[i] });
    }
    Compilado = Compilado.sort(function (obj1, obj2) {
        return obj2.visitas - obj1.visitas;
    });

    jQuery.each(Compilado.slice(0, 5), function (index, interesse) {
        Top5MicrotendenciasVisitas.push(parseInt(interesse.visitas));
        Top5MicrotendenciasNomes.push(interesse.tendencia);
    });

    var grfTop5MicrotendenciasData = {
        datasets: [{
            data: Top5MicrotendenciasVisitas,
            backgroundColor: [window.chartColors.red, window.chartColors.orange, window.chartColors.yellow, window.chartColors.green, window.chartColors.blue]
        }],
        labels: Top5MicrotendenciasNomes
    };
    var grfTop5Microtendencias = new Chart(grfTop5Microtendencias, {
        type: 'pie',
        data: grfTop5MicrotendenciasData,
        options: {
            responsive: true, legend: { position: 'bottom' }
        }
    });

    jQuery(document).find(".ExtraMicro").html('Temos um total de <b>' + idInteresses.length + '</b> microtendências até o momento.');

    // MACROTENDÊNCIAS
    ////////////////////

    var ids = [];
    var tendencias = [];
    var HTML = "";

    jQuery.each(macro, function (index, tendencia) {
        if (jQuery.inArray(tendencia.idT, ids) == -1) {
            ids.push(tendencia.idT);
            tendencias.push(tendencia.tendencia);
        }
    });

    jQuery.each(ids, function (index, tendencia) {
        HTML += '<li><a href="/tendencias/tendencia.php?tendencia=' + tendencias[index] + '"><span class="titulo">' + tendencias[index] + '</span></a></li>';
    });

    $("#listaMacroTendencias").html(HTML);
    jQuery(document).find(".ExtraMacro").html('Temos um total de <b>' + ids.length + '</b> macrotendências até o momento.');
}