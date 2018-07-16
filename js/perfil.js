
var Meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
var Interesses = ['Design', 'Tecnologia', 'Empreendedorismo', 'Saúde', 'Educação', 'Outros'];
var Cores = ['#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236', '#166a8f', '#00a950', '#58595b', '#8549ba'];
var Provedores = ["Facebook", "Linkedin", "Outros"];
var Generos = ["Feminino", "Masculino"];
var Empresas = [];
window.chartColors = { red: 'rgb(255, 99, 132)', orange: 'rgb(255, 159, 64)', yellow: 'rgb(255, 205, 86)', green: 'rgb(75, 192, 192)', blue: 'rgb(54, 162, 235)', purple: 'rgb(153, 102, 255)', grey: 'rgb(201, 203, 207)', black: 'rgb(0, 0, 0)' };
window.chartColorsOpacity = { red: 'rgb(255, 99, 132, 0.5)', orange: 'rgb(255, 159, 64, 0.5)', yellow: 'rgb(255, 205, 86, 0.5)', green: 'rgb(75, 192, 192, 0.5)', blue: 'rgb(54, 162, 235, 0.5)', purple: 'rgb(153, 102, 255, 0.5)', grey: 'rgb(201, 203, 207, 0.5)', black: 'rgb(0, 0, 0, 0.5)' };

jQuery(document).ready(function () {

    // Tipos de Gráficos
    ////////////////////

    var grfPessoas = document.getElementById('grfPessoas');
    var grfPessoasData = {};

    var grfInteresses = document.getElementById('grfInteresses');
    var grfInteressesData = {};

    var grfTipoLogin = document.getElementById('grfTipoLogin');
    var grfTipoLoginData = {};

    var grfGenero = document.getElementById('grfGenero');
    var grfGeneroData = {};

    //var grfEmpresas = document.getElementById('grfEmpresas');
    //var grfEmpresasData = {};

    var grfTop3DiasMovimentados = document.getElementById('grfTop3DiasMovimentados');
    var grfTop3DiasMovimentadosData = {
        datasets: [{
            data: ["100", "100", "100"],
            backgroundColor: [window.chartColors.red, window.chartColors.green, window.chartColors.blue]
        }],
        labels: ["Lorem", "Ipsum", "Dolor"]
    };

    var grfTop3EventosMovimentados = document.getElementById('grfTop3EventosMovimentados');
    var grfTop3EventosMovimentadosData = {
        datasets: [{
            data: ["100", "100", "100"],
            backgroundColor: [window.chartColors.red, window.chartColors.green, window.chartColors.blue]
        }],
        labels: ["Lorem", "Ipsum", "Dolor"]
    };

    // Load Data
    ////////////////////

    jQuery.ajax({
        type: "GET",
        url: "/loopAll.php",
        success: function (part) {
            var informacoes = JSON.parse(part);
            var People = informacoes[0].pessoas;
            var Obj = informacoes[0].objetivos;
            var Invalido = informacoes[0].outros;

            var d = new Date();
            var ano = d.getFullYear();

            // FILTRO PESSOAS
            ////////////////////
            var pessoas = [], dataPessoas = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            jQuery.each(Obj, function (index, objetivo) {
                var anoObj, mesObj;
                anoObj = (objetivo.data).slice(0, 4);
                mesObj = (objetivo.data).slice(5, 7);

                if (parseInt(anoObj) == parseInt(ano)) {
                    var valor = dataPessoas[parseInt(mesObj)];
                    valor++;
                    dataPessoas[parseInt(mesObj)] = valor;
                }
            });

            dataPessoas = dataPessoas.slice(1);

            var grfPessoasData = {
                labels: Meses,
                datasets: [{
                    borderWidth: 1,
                    data: dataPessoas,
                    backgroundColor: window.chartColorsOpacity.black,
                    borderColor: window.chartColors.black,
                    borderWidth: 1,
                }]
            };

            var graficoPessoas = new Chart(grfPessoas, {
                type: 'line',
                data: grfPessoasData,
                options: { responsive: true, legend: { position: 'top', display: false }, title: { display: false } }
            });


            // FILTRO INTERESSES
            ////////////////////
            var interesses = [], nomeInteresses = [], dataInteresses = [];

            jQuery.each(Obj, function (index, objetivo) {
                if (jQuery.inArray(objetivo.objetivo, interesses) == -1 && objetivo.objetivo != "Teste weme" && objetivo.objetivo != "Teste\n" && objetivo.objetivo != "Teste" && objetivo.objetivo != "") {
                    interesses.push(objetivo.objetivo);
                }
            });

            jQuery.each(interesses, function (index, interesse) {
                var total = 0;
                var nome = (String(interesse)).replace('"', '');
                jQuery.each(Obj, function (index, objetivo) {
                    if (objetivo.objetivo == interesse) {
                        total++;
                    }
                });

                if (jQuery.inArray(nome, Interesses) != -1) {
                    nomeInteresses.push(nome);
                    dataInteresses.push(total);
                }
            });

            grfInteressesData = {
                datasets: [{
                    data: dataInteresses,
                    backgroundColor: Cores
                }],
                labels: nomeInteresses
            };
            var graficoInteresses = new Chart(grfInteresses, {
                type: 'pie',
                data: grfInteressesData,
                options: {
                    responsive: true, legend: { position: 'right' }
                }
            });

            // FILTRO TIPOS DE LOGIN
            ////////////////////////
            var dataProvedor = [0, 0, 0];

            jQuery.each(People, function (index, pessoa) {

                if (pessoa.provedor == "facebook") {
                    var valor = dataProvedor[0];
                    valor++;
                    dataProvedor[0] = valor;
                } else if (pessoa.provedor == "linkedin") {
                    var valor = dataProvedor[1];
                    valor++;
                    dataProvedor[1] = valor;
                } else {
                    var valor = dataProvedor[2];
                    valor++;
                    dataProvedor[2] = valor;
                }
            });

            var grfTipoLoginData = {
                datasets: [{
                    data: dataProvedor,
                    backgroundColor: [window.chartColors.orange, window.chartColors.blue, window.chartColors.green]
                }],
                labels: Provedores
            };
            var graficoTipoLogin = new Chart(grfTipoLogin, {
                type: 'pie',
                data: grfTipoLoginData,
                options: {
                    responsive: true, legend: { position: 'right' }
                }
            });

            // FILTRO GÊNERO
            ////////////////////////
            var dataGenero = [0, 0, 0];
            var dataGeneroFinal = [];

            jQuery.each(People, function (index, pessoa) {
                if (pessoa.gender == "feminino" || pessoa.gender == "F") {
                    var valor = dataGenero[0];
                    valor++;
                    dataGenero[0] = valor;
                } else if (pessoa.gender == "masculino" || pessoa.gender == "M") {
                    var valor = dataGenero[1];
                    valor++;
                    dataGenero[1] = valor;
                }
                var valortotal = dataGenero[2];
                valortotal++;
                dataGenero[2] = valortotal;
            });

            var feminino = ((100 * dataGenero[0]) / dataGenero[2]);
            var masculino = 100 - feminino;

            dataGeneroFinal.push(feminino.toFixed(2));
            dataGeneroFinal.push(masculino.toFixed(2));

            var grfGeneroData = {
                datasets: [{
                    data: dataGeneroFinal,
                    backgroundColor: [window.chartColors.pink, window.chartColors.blue]
                }],
                labels: Generos
            };
            var graficoGenero = new Chart(grfGenero, {
                type: 'pie',
                data: grfGeneroData,
                options: {
                    responsive: true, legend: { position: 'right' }
                }
            });

            // FILTRO EMPRESAS
            ////////////////////////
            var dataEmpresas = [], dataEmails = [], dataVisitas = [], Outros = [], Compilado = [], dataEmpresasFinal = [], dataVisitasFinal = [], cores = [];

            jQuery.each(People, function (index, pessoa) {
                if (pessoa.email != "" && pessoa.email != null && (pessoa.email).toLowerCase().indexOf(".com") >= 0) {

                    var teste = (pessoa.email).substring((pessoa.email).indexOf("@") + 1);

                    // Checa se existe senão adiciona
                    if (jQuery.inArray(teste, dataEmails) == -1) {
                        dataEmails.push($.trim(teste));
                        dataEmpresas.push($.trim(teste.slice(0, teste.indexOf(".com"))));
                        dataVisitas.push(1);
                    } else {
                        var posicao = jQuery.inArray(teste, dataEmails);
                        var valor = dataVisitas[posicao];
                        valor++;
                        dataVisitas[posicao] = valor;
                    }

                }
            });

            // Ordena e compila
            for (var i = 0, len = dataEmpresas.length; i < len; i++) {
                Compilado.push({ "empresa": dataEmpresas[i], "email": dataEmails[i], "visitas": dataVisitas[i] });
            }
            Compilado = Compilado.sort(function (obj1, obj2) {
                return obj2.visitas - obj1.visitas;
            });

            // Adiciona na lista principal - Ordem já definida anteriormente
            jQuery.each(Compilado, function (index, item) {
                dataEmpresasFinal.push(item.empresa);
                dataVisitasFinal.push(item.visitas);
                cores.push(dynamicColors());
            });

        }
    });

    // Chart Start
    ////////////////////

    var graficoTop3DiasMovimentados = new Chart(grfTop3DiasMovimentados, {
        type: 'pie',
        data: grfTop3DiasMovimentadosData,
        options: {
            responsive: true, legend: { position: 'right' }
        }
    });

    var graficoTop3EventosMovimentados = new Chart(grfTop3EventosMovimentados, {
        type: 'pie',
        data: grfTop3EventosMovimentadosData,
        options: {
            responsive: true, legend: { position: 'right' }
        }
    });

});

var dynamicColors = function () {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
}

// FILTRO FEMININO/MASCULINO
////////////////////////////
function loadTendenciasFM(infos, local) {

    var Top5MicrotendenciasVisitas = [];
    var Top5MicrotendenciasNomes = [];
    var grfTop5Microtendencias = document.getElementById(local);
    var grfTop5MicrotendenciasData = {};

    var nomeInteresses = [], idInteresses = [], dataInteresses = [], Compilado = [];

    jQuery.each(infos, function (index, interesse) {

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
        type: 'doughnut',
        data: grfTop5MicrotendenciasData,
        options: {
            responsive: true, legend: { position: 'bottom' }
        }
    });

}

// WORKSHOPS FEMININO/MASCULINO
///////////////////////////////

function loadWorkshopsFM(infos, local) {

    var Top5EventosVisitas = [];
    var Top5EventosNomes = [];
    var grfTop5EventosMovimentados = document.getElementById(local);
    var grfTop5EventosMovimentadosData = {};

    var nomeInteresses = [], idInteresses = [], dataInteresses = [], Compilado = [];

    jQuery.each(infos, function (index, workshop) {

        // Checa se existe senão adiciona
        if (jQuery.inArray(workshop.idWS, idInteresses) == -1) {
            idInteresses.push(workshop.idWS);
            nomeInteresses.push(workshop.name);
            dataInteresses.push(1);
        } else {
            var posicao = jQuery.inArray(workshop.idWS, idInteresses);
            var valor = dataInteresses[posicao];
            valor++;
            dataInteresses[posicao] = valor;
        }
    });

    // Ordena e compila
    for (var i = 0, len = dataInteresses.length; i < len; i++) {
        Compilado.push({ "name": nomeInteresses[i], "visitas": dataInteresses[i] });
    }
    Compilado = Compilado.sort(function (obj1, obj2) {
        return obj2.visitas - obj1.visitas;
    });

    jQuery.each(Compilado.slice(0, 5), function (index, interesse) {
        Top5EventosVisitas.push(parseInt(interesse.visitas));
        Top5EventosNomes.push(interesse.name);
    });

    var grfTop5EventosMovimentadosData = {
        datasets: [{
            data: Top5EventosVisitas,
            backgroundColor: [window.chartColors.red, window.chartColors.orange, window.chartColors.yellow, window.chartColors.green, window.chartColors.blue]
        }],
        labels: Top5EventosNomes
    };
    var grfTop5EventosMovimentados = new Chart(grfTop5EventosMovimentados, {
        type: 'doughnut',
        data: grfTop5EventosMovimentadosData,
        options: {
            responsive: true, legend: { position: 'bottom' }
        }
    });

}