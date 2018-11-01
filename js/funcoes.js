

$(document).ready(function () {

    $(document).on('click', '.secHome .tiposCadastro li a, .secTipo .tiposCadastro li a', function (e) {
        e.preventDefault();

        var link = $(this).attr("href");
        $(link).addClass("active").siblings(".Aba").removeClass("active");
        $("html, body").animate({ scrollTop: $(link).offset().top }, '300');

    });

    $(document).on('click', '.Voltar', function (e) {
        e.preventDefault();
        $("#secHome").addClass("active").siblings(".Aba").removeClass("active");
        $("html, body").animate({ scrollTop: 0 }, '300');
    });

    $(document).on('submit', '#frmCadastro', function (e) {
        e.preventDefault();

        var nome = $("#txtNome").val();
        var empresa = $("#txtEmpresa").val();
        var email = $("#txtEmail").val();
        var cargo = $(document).find("#slcCargo option:selected").val();
        var negocio = $(document).find("#slcNegocio option:selected").val();
        var objetivo = $(document).find("#slcAssunto option:selected").val();
        var motivo = $(document).find("#slcMotivo option:selected").val();
        var genero = $(document).find("#slcGenero option:selected").val();
        var agente = navigator.userAgent;
        if (genero == "" || genero == null) { genero = "-"; }
        var Infos = { provider: 'email', id: $.now(), firstName: nome, lastName: "-", email: email, about: '-', gender: genero, locale: 'weme', picture: '-', link: '-', objetivo: objetivo, empresa: empresa, useragent: agente, cargo: cargo, negocio: negocio, motivo: motivo };
        cadastro(Infos, 'email');
    });

    $(document).on('submit', '#frmConsulta', function (e) {
        e.preventDefault();

        var email = $("#txtEmail2").val();
        var cargo = $(document).find("#slcCargo2 option:selected").val();
        var objetivo = $(document).find("#slcAssunto2 option:selected").val();
        var motivo = $(document).find("#slcMotivo2 option:selected").val();
        if (objetivo == "" || objetivo == null) { objetivo = "Não informado"; }
        var agente = navigator.userAgent;
        if (agente == null || agente == "") { agente = "Inválido"; }
        var Infos = { email: email, objetivo: objetivo, useragent: agente, id: $.now(), cargo: cargo, motivo: motivo };
        jaCadastrado(Infos, 'email');

    });

});

function checkLoginState() {
    var objetivo = $("#slcAssunto3").val();
    FB.getLoginStatus(function (response) {
        if (response.status === 'connected') {
            FB.api('/me', { locale: 'pt_BR', fields: 'about, first_name, last_name, name, email, id, cover, age_range, gender, link, locale, picture, timezone, location{location}' },
                function (response) {
                    update(response, 'facebook');
                }
            );
        }
    });
}

function update(response, plataforma) {

    if (plataforma == 'facebook') { desconectar(); }
    if (plataforma == 'linkedin') { IN.User.logout(removeProfileData); }
    var Infos;
    var objetivo = $("#slcAssunto3").val();

    var agente = navigator.userAgent;

    if (objetivo == "" || objetivo == null) {
        objetivo = "Não informado";
        if (plataforma == 'facebook') {
            var Summ = response.about; if (Summ == "" || Summ == null) { Summ = "-"; }
            var Email = response.email; if (Email == "" || Email == null) { Email = "-"; }
            var genero = response.gender; if (genero == "" || genero == null) { genero = "-"; }
            var localizacao = response.location; if (localizacao == "" || localizacao == null) { localizacao = "-"; }
            var url = response.link; if (url == "" || url == null) { url = "-"; }
            Infos = { provider: 'facebook', id: response.id, firstName: response.first_name, lastName: response.last_name, email: Email, about: Summ, gender: genero, locale: localizacao, picture: response.picture.data.url, link: url, objetivo: objetivo, empresa: "-", useragent: agente };
        }
        if (plataforma == 'linkedin') {
            var Summ = response.summary; if (Summ == "" || Summ == null) { Summ = response.headline; }
            var Email = response.emailAddress; if (Email == "" || Email == null) { Email = "-"; }
            var localizacao = response.location.name; if (localizacao == "" || localizacao == null) { localizacao = "-"; }
            var url = response.publicProfileUrl; if (url == "" || url == null) { url = "-"; }
            Infos = { provider: 'linkedin', id: response.id, firstName: response.firstName, lastName: response.lastName, email: response.emailAddress, about: Summ, gender: 'N', locale: localizacao, picture: response.pictureUrl, link: url, objetivo: objetivo, empresa: "-", useragent: agente };
        }

        cadastro(Infos, plataforma);

    } else {
        if (plataforma == 'facebook') {
            var Summ = response.about; if (Summ == "" || Summ == null) { Summ = "-"; }
            var Email = response.email; if (Email == "" || Email == null) { Email = "-"; }
            var genero = response.gender; if (genero == "" || genero == null) { genero = "-"; }
            var url = response.link; if (url == "" || url == null) { url = "-"; }
            Infos = { provider: 'facebook', id: response.id, firstName: response.first_name, lastName: response.last_name, email: response.email, about: Summ, gender: genero, locale: localizacao, picture: response.picture.data.url, link: url, objetivo: objetivo, empresa: "-", useragent: agente };
        }
        if (plataforma == 'linkedin') {
            var Summ = response.summary; if (Summ == "" || Summ == null) { Summ = response.headline; }
            var Email = response.emailAddress; if (Email == "" || Email == null) { Email = "-"; }
            var localizacao = response.location.name; if (localizacao == "" || localizacao == null) { localizacao = "-"; }
            var url = response.publicProfileUrl; if (url == "" || url == null) { url = "-"; }
            Infos = { provider: 'linkedin', id: response.id, firstName: response.firstName, lastName: response.lastName, email: response.emailAddress, about: Summ, gender: 'N', locale: localizacao, picture: response.pictureUrl, link: url, objetivo: objetivo, empresa: "-", useragent: agente };
        }
        cadastro(Infos, plataforma);
    }
}

// Person is now logged out
function desconectar() { FB.logout(function (response) { }); }
function logout() { IN.User.logout(removeProfileData); }

// Aithorize person
function LinkedINAuth() {
    IN.UI.Authorize().place();
    onLinkedInLoad();
}

// Setup an event listener to make an API call once auth is complete
function onLinkedInLoad() {
    IN.Event.on(IN, "auth", getProfileData);
}

// Use the API call wrapper to request the member's profile data
function getProfileData() {
    IN.API.Profile("me").fields("id", "firstName", "lastName", "positions:(company,title,summary,startDate,endDate,isCurrent)", "location:(name,country:(code))", "picture-url", "headline", "summary", "specialties", "num-connections", "public-profile-url", "distance", "email-address", "educations", "date-of-birth").result(displayProfileData).error(onError);
}

// Handle the successful return from the API call
function displayProfileData(data) {
    var user = data.values[0];
    update(user, 'linkedin');
}

// Handle an error response from the API call
function onError(error) {
    //console.log(error);
}

// Remove profile data from page
function removeProfileData() {
    document.getElementById('profileData').remove();
}

window.fbAsyncInit = function () {
    FB.init({
        appId: '576833395993329',
        status: true, // check login status
        cookie: true, // enable cookies to allow the server to access the session
        xfbml: true,
        version: 'v2.7',
        oauth: true
    });
    FB.AppEvents.logPageView();

    checkLoginState();
};

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) { return; }
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.12&appId=576833395993329&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function cadastro(Infos, location) {

    jQuery.ajax({
        type: "POST",
        data: Infos,
        url: '/update.php',
        success: function (data) {

            $("#secSucesso").addClass("active").siblings(".Aba").removeClass("active");
            ga('send', 'event', 'Check in ' + location, 'click', 'Campanha de Check in weme');
            if (location == 'facebook') { FB.logout(function (response) { }); }
            if (location == 'linkedin') { IN.User.logout(removeProfileData); }
            //alert("Check in realizado com sucesso!");
            setTimeout(function () {
                window.location.replace('http://192.168.0.5:8011/');
            }, 1500);
        }, error: function (data) {
            setTimeout(function () {
                window.location.replace('http://192.168.0.5:8011/');
            }, 1500);
        }
    });
}

function jaCadastrado(Infos, location) {

    jQuery.ajax({
        type: "POST",
        data: Infos,
        url: '/jaCadastrado.php',
        success: function (data) {

            $("#secSucesso").addClass("active").siblings(".Aba").removeClass("active");

            ga('send', 'event', 'Check in ' + location, 'click', 'Campanha de Check in weme');
            if (location == 'facebook') { FB.logout(function (response) { }); }
            if (location == 'linkedin') { IN.User.logout(removeProfileData); }
            //alert("Check in realizado com sucesso!");
            setTimeout(function () {
                window.location.replace('http://192.168.0.5:8011/');
            }, 1500);

        }, error: function (data) {
            setTimeout(function () {
                window.location.replace('http://192.168.0.5:8011/');
            }, 1500);
        }
    });
}