<?php session_start();
	require_once 'functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$query2 = "SELECT * FROM crawler.cargo ORDER BY name ASC";
	$result2 = mysqli_query($connection, $query2);

	$query3 = "SELECT * FROM crawler.macrotendencias";
	$result3 = mysqli_query($connection, $query3);

	$query4 = "SELECT * FROM crawler.negocios ORDER BY negocio ASC";
	$result4 = mysqli_query($connection, $query4);

	$interesses = "";
	$cargos = "";
	$negocios = "";

	if ( $result2 ) 
	{ 
		while($aux = mysqli_fetch_array($result2)){
			$cargos .= '<option value="'.$aux["id"].'">'.$aux["name"].'</option>';				
		}
	}

	if ( $result3 ) 
	{ 
		while($aux = mysqli_fetch_array($result3)){
			$interesses .= '<option value="'.$aux["tendencia"].'">'.$aux["tendencia"].'</option>';				
		}
	}

	if ( $result4 ) 
	{ 
		while($aux = mysqli_fetch_array($result4)){
			$negocios .= '<option value="'.$aux["idNegocio"].'">'.$aux["negocio"].'</option>';				
		}
	}

?>
<!doctype html>
<html>
	<head>
		<title>Check-in weme</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="author" content="weme" />
		<meta name="description" content="Somos uma rede de pessoas e recursos para repensar negócios e experiências. Estamos aqui para apoiar e investir no desenvolvimento e rápido crescimento de ideias e negócios que vão transformar o mundo." />
		<meta name="keywords" content="" />
		<meta name="language" content="pt-br" />
		<meta name="resource-type" content="document" />
		<meta http-equiv="cache-control" content="max-age=3600" />
		<meta property="og:title" content="weme" />
		<meta property="og:image" content="/imagens/logo-weme.png" />
		<meta property="og:url" content="http://www.weme.nu" />
		<meta property="og:description" content="Somos uma rede de pessoas e recursos para repensar negócios e experiências. Estamos aqui para apoiar e investir no desenvolvimento e rápido crescimento de ideias e negócios que vão transformar o mundo." />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="theme-color" content="#000000" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<link rel="apple-touch-startup-image" href="imagens/logo-weme.png">
		<link rel="image_src" href="imagens/logo-weme.png" />
		<link rel="manifest" href="manifest.json">
	</head>
	<body>

	<section>
		<div class="Cell">
			<header>
				<div class="Conteudo">
					<div class="Logo">
						<img src="imagens/logo-weme.png" />
					</div>
					<div class="Box Inicio">
						<h2>Check-in weme</h2>
						<h3>Além de nos ajudar a saber quem está aqui, o seu check in permite que a gente conecte você com as oportunidades e eventos que tem a sua cara, e ainda colabora para melhorar a nossa rede, e a sua experiência.</h3>
					</div>
				</div>
			</header>

			<div id="secHome" class="Table secHome Aba active">
				<div class="Content">
					<div class="Conteudo">
						<ul class="tiposCadastro">
							<li><a style="color: #202530; background:#f2f6ff; " href="#secTipo" target="_self">Primeira vez</a></li>
							<li><a style="background: #064fca;" href="#secConsulta" target="_self">Já fiz checkin antes</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div id="secTipo" class="Table secTipo Aba">
				<div class="Content">
					<div class="Conteudo">
						<ul class="tiposCadastro">
							<li><a style="color: #202530; background:#f2f6ff; " href="#secStandard" target="_self">Check in por e-mail</a></li>
							<li><a style="background: #064fca;" href="#secSocial" target="_self">Check in por rede social</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div id="secConsulta" class="Table secConsulta Aba">
				<div class="Content">
					<div class="Conteudo">
						<div class="Formulario">
							<form id="frmConsulta" name="frmConsulta">
							<div class="row">
								<div class="col-md-12">
									<label>E-mail:</label>
									<input type="email" name="txtEmail2" id="txtEmail2" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Cargo:</label>
									<select id="slcCargo2" name="slcCargo2">
										<option value="">Selecione</option>
										<?php echo $cargos; ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>O que você veio fazer aqui?</label>
									<select id="slcMotivo2" name="slcMotivo2" required>
										<option selected value="Não informado">Selecione</option>
										<option value="Uso do espaço">Uso do espaço</option>
										<option value="Home office">Home office</option>
										<option value="Eventos">Eventos</option>
										<option value="Projeto com time weme">Projeto com time weme</option>
										<option value="Reunião pontual">Reunião pontual</option>
										<option value="Programa de ensino">Programa de ensino</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Assunto de interesse:</label>
									<select id="slcAssunto2" name="slcAssunto2" required>
										<option value="Não informado">Selecione</option>
										<?php echo $interesses; ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<input type="submit" id="btnEnviarConsulta" name="btnEnviarConsulta" value="Enviar" class="Botao">
								</div>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div id="secStandard" class="Table secStandard Aba">
				<div class="Content">
					<div class="Conteudo">
						<div class="Formulario">
							<form id="frmCadastro" name="frmCadastro">
							<div class="row">
								<div class="col-md-12">
									<label>Nome:</label>
									<input type="text" name="txtNome" id="txtNome" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>E-mail:</label>
									<input type="email" name="txtEmail" id="txtEmail" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Empresa:</label>
									<input type="text" name="txtEmpresa" id="txtEmpresa" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Negócio:</label>
									<select id="slcNegocio" name="slcNegocio">
										<option value="">Selecione</option>
										<?php echo $negocios; ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Cargo:</label>
									<select id="slcCargo" name="slcCargo">
										<option value="">Selecione</option>
										<?php echo $cargos; ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>O que você veio fazer aqui?</label>
									<select id="slcMotivo" name="slcMotivo" required>
										<option selected value="Não informado">Selecione</option>
										<option value="Uso do espaço">Uso do espaço</option>
										<option value="Home office">Home office</option>
										<option value="Eventos">Eventos</option>
										<option value="Projeto com time weme">Projeto com time weme</option>
										<option value="Reunião pontual">Reunião pontual</option>
										<option value="Programa de ensino">Programa de ensino</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Assunto de interesse:</label>
									<select id="slcAssunto" name="slcAssunto" required>
										<option value="Não informado">Selecione</option>
										<?php echo $interesses; ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<input type="submit" id="btnEnviar" name="btnEnviar" value="Enviar" class="Botao">
								</div>
							</div>
							</form>
						</div>
						<a class="Botao Voltar">Voltar</a>
					</div>
				</div>
			</div>

			<div id="secSocial" class="Table secSocial Aba">
				<div class="Content">
					<div class="Conteudo">
						<div class="Box Objetivo">
							<div class="Objetivo">
								<textarea id="txtObjetivo" name="txtObjetivo" rows="4" placeholder="Caso precise, informe aqui o objetivo de sua visita ou deixe uma mensagem para a equipe weme."></textarea>
							</div>
							<div class="Botoes">
								<div class="Botao Facebook">
									<fb:login-button scope="public_profile,email,user_friends,user_about_me,user_location,user_hometown" data-width="250px" data-max-rows="1" data-size="large" onlogin="checkLoginState();" data-button-type="continue_with"></fb:login-button>
								</div>
								<div class="Botao Linkedin">
									<a class="btn btn-block btn-social btn-lg btn-linkedin" onclick="LinkedINAuth()"><i class="fa fa-linkedin"></i>Sign in with LinkedIn</a>
								</div>
							</div>
							<a class="Botao Voltar">Voltar</a>
						</div>

					</div>
				</div>
			</div>

			<div id="secSucesso" class="Table secSucesso Aba">
				<div class="Content">
					<div class="Conteudo">
						<div class="Box Sucesso">
							<h3>Checkin realizado. Aproveite bastante!</h3>
							<div class="Imagem">
								<img src="imagens/checked.png">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>

	<link media="all" rel="stylesheet" href="css/style.css" />
	<link media="all" rel="stylesheet" href="css/bootstrap.css" />
	<link media="all" rel="stylesheet" href="css/font-awesome.css" />
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-25632384-4"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-25632384-4');
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://platform.linkedin.com/in.js">
		api_key: 77shnbdvqjr2v7
		authorize: true
		//onLoad: onLinkedInLoad
		scope: r_basicprofile r_emailaddress
	</script>
	<script src="js/funcoes.js?ver=2002"></script>
  </body>
</html>
