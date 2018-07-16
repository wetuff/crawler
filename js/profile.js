
jQuery(document).ready(function () {

    if ($(document).find("#contactList").length > 0) {
        var options = {
            valueNames: ['titulo']
        };
        var userList = new List('secProfile', options);
    }

});

function loadUsers(info, empresas, workshops) {

    informacoes = info.sort(function (a, b) {
        var aName = a.name.toLowerCase();
        var bName = b.name.toLowerCase();
        return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
    });

    var HTML = "";
    var emails = [];

    jQuery.each(informacoes, function (index, usuario) {

        var infoEmpresa = "";
        var teste = (usuario.email).substring((usuario.email).indexOf("@") + 1);

        jQuery.each(empresas, function (index, empresa) {

            if (empresa.tipo == "privado" && teste == empresa.dominio) {
                infoEmpresa = '<span class="empresa">' + (empresa.nome).toString() + '</span>';
            }

        });

        HTML += '<a href="/visitante/perfil.php?email=' + usuario.email + '"><span class="titulo">' + usuario.name + '</span>' + infoEmpresa + '<span class="email">' + usuario.email + '</span></a>';

    });

    jQuery(document).find("#contactList").html(HTML);
}

function cadastroinfo(Infos, location) {

    jQuery.ajax({
        type: "POST",
        data: Infos,
        url: '/update2.php',
        success: function (data) {
            console.log("Cadastro com sucesso");
        }, error: function (data) {
            console.log("Erro no cadastro");
        }
    });
}

function loadWorkshopProfile(Infos) {

    var HTML = "";
    var total = 0;

    if (Infos != "" && Infos != null) {

        HTML += '<h3>Participação</h3>';

        jQuery.each(Infos, function (index, investimento) {
            HTML += '<div class="evento">&bull; evento: ' + investimento.workshop + '</div>';
            if (investimento.ps != "gratuito") {
                total = total + parseInt(investimento.preco);
            }
        });

        HTML += '<div class="total">Total investido no hub, até o momento: <b>R$ ' + total + '</b></div>';

        jQuery(document).find("#investimento").html(HTML);
    }
}

function loadTendencia(micros) {

    console.log(micros);
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

    $(".interesses span").html(HTML);
}