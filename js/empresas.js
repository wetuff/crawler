
jQuery(document).ready(function () {

    //if ($(document).find("#listaEmpresas").length > 0) {
    //    var options = {
    //        valueNames: ['titulo']
    //    };
    //    var userList = new List('secEmpresa', options);
    //}

    // Load Data
    ////////////////////

    jQuery(document).on('click', '#listaEmpresas > li', function (e) {
        jQuery("#listaEmpresas > li.active").removeClass("active");
        jQuery(this).addClass("active");

        $('html, body').animate({
            scrollTop: $(this).offset().top - 100
        }, 700);
    });

    jQuery.ajax({
        type: "GET",
        url: "/empresa/loopEmpresa.php",
        success: function (part) {
            var informacoes = JSON.parse(part);
            var People = informacoes[0].pessoas;
            var Obj = informacoes[0].objetivos;
            var Empresas = informacoes[0].empresas;

            var d = new Date();
            var ano = d.getFullYear();

            // ORDENAÇÃO
            ////////////////////////

            Empresas = Empresas.sort(function (a, b) {
                var aName = a.dominio.toLowerCase();
                var bName = b.dominio.toLowerCase();
                return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
            });

            People = People.sort(function (a, b) {
                var aName = a.name.toLowerCase();
                var bName = b.name.toLowerCase();
                return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
            });

            // FILTRO EMPRESAS
            ////////////////////////

            jQuery.each(Empresas, function (index, empresa) {

                if (empresa.tipo == "privado") {

                    var HTML = "", dominio = empresa.dominio, dataVisitas = 0, visitante = "", nomeEmpresa = "";
                    nomeEmpresa = (empresa.nome).toString();

                    if ((empresa.nome).toLowerCase().indexOf("encontrado") >= 0 || (empresa.nome).toLowerCase().indexOf("informado") >= 0) {
                        nomeEmpresa = empresa.dominio;
                    }

                    ////////////////////
                    // CALCULO VISITAS
                    jQuery.each(People, function (index, pessoa) {
                        if (pessoa.email != "" && pessoa.email != null) {
                            var teste = (pessoa.email).substring((pessoa.email).indexOf("@") + 1);
                            if (teste == dominio) {

                                visitante += '<a class="visitante" href="/visitante/perfil.php?email=' + pessoa.email + '">';

                                var objetivoVisitante = "";

                                dataVisitas = dataVisitas + parseInt(pessoa.visitas);
                                var nome = "";
                                if (pessoa.sobrenome != "" && pessoa.sobrenome != null && pessoa.sobrenome != "-") { nome = ""; nome += pessoa.name + " " + pessoa.sobrenome; } else { nome = ""; nome += pessoa.name; }
                                visitante += '<span class="nomeVisitante">' + nome + '</span>';
                                visitante += '<span class="emailVisitante">' + pessoa.email + '</span>';
                                visitante += '<span class="objetivoVisitante"><b>Interesse: </b>';

                                jQuery.each(Obj, function (index, objetivo) {
                                    if (objetivo.id == pessoa.id && objetivoVisitante.indexOf(objetivo.objetivo) == -1) {
                                        objetivoVisitante += objetivo.objetivo + ', ';
                                    }
                                });
                                visitante += objetivoVisitante.slice(0, -2);
                                visitante += '</span>';
                                visitante += '<span class="visitasVisitante"><b>Visitas: </b>' + pessoa.visitas + '</span>';
                                visitante += '</a>';
                            }
                        }
                    });

                    HTML += '<li empresa="' + empresa.id + '">';
                    HTML += '<div class="titulo">' + nomeEmpresa + '</div>';
                    HTML += '<div class="visitas"><span>' + dataVisitas + '</span></div>';                    
                    HTML += '<div class="endereco"><b>Endereço:</b> ' + empresa.endereco + '</div>';
                    HTML += '<div class="telefone"><b>Telefone:</b> ' + empresa.telefone + '</div>';
                    HTML += '<a class="mais" href="/empresa/empresa.php?dominio=' + empresa.dominio + '">Saiba mais</a>';
                    HTML += '<div class="info">';
                    HTML += visitante;
                    HTML += '</div>';
                    HTML += '</li>';

                    $("#listaEmpresas").append(HTML);
                }

            });

        }
    });

});