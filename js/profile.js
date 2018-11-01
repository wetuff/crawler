
jQuery(document).ready(function () {

    if ($(document).find("#txtTelefone").length > 0) {
        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        }, spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

        $('#txtTelefone').mask(SPMaskBehavior, spOptions);
    }

    if ($(document).find("#contactList").length > 0) {
        var options = {
            valueNames: ['titulo', 'email']
        };
        var userList = new List('secProfile', options);
    }

    $(document).on('click', '#btnSaveProfile', function () {
        var id = $(this).attr("profile");
        updateProfile(id);
    });

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
        var cargo = "";

        jQuery.each(empresas, function (index, empresa) {

            if (empresa.tipo == "privado" && teste == empresa.dominio) {
                infoEmpresa = '<span class="empresa">' + (empresa.nome).toString() + '</span>';
            }

        });

        if (usuario.cargo != "" && usuario.cargo != null) { cargo = '<b>cargo: </b>' + usuario.cargo; }

        HTML += '<a href="/visitante/perfil.php?email=' + usuario.email + '"><span class="titulo">' + usuario.name + '</span>' + infoEmpresa + '<span class="cargo">' + cargo + '</span><span class="email"><b>E-mail:</b> ' + usuario.email + '</span></a>';

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
            HTML += '<li style="font-size:' + ((parseInt(pesoMicro[index]) * 1.5) + 11.5) + 'px;"><a href="/tendencias/tendencia.php?tendencia=' + idsMicro[index] + '"><span class="titulo">' + tendenciasMicro[index] + '</span></a></li>';
        });
    }

    $(".interesses span").html(HTML);
}

function updateProfile(info) {

    var cargo, endereco, telefone;

    cargo = $(document).find("#slcCargo2 option:selected").val();
    endereco = $(document).find("#txtEndereco").val();
    telefone = $(document).find("#txtTelefone").val();

    if (confirm("Tem certeza que deseja realizar esta atualização?")) {
        $.ajax({
            type: "POST",
            url: "/visitante/updateVisitante.php",
            data: { id: info, cargo: JSON.stringify(cargo), endereco: JSON.stringify(endereco), telefone: JSON.stringify(telefone) },
            success: function (data) {
                alert("Atualização realizada com sucesso");
                window.location = "/visitante/";
            }
        });
    }

}