<?php session_start();
	require_once 'functions.php';
	header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html>
	<head>
		<title>Checkin weme</title>
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
						<h2 style="margin-bottom:0">já passaram pela weme</h2>
					</div>
				</div>
			</header>

			<div id="secRelatorio" class="Table secRelatorio Aba active">
				<div class="Content">
					<div class="Conteudo">
						<div id="listaParticipantes"></div>
						<div id="excel" class="Box"></div>
						<div id="excelHidden" class=""></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<link media="all" rel="stylesheet" href="css/style.css" />
	<link media="all" rel="stylesheet" href="css/bootstrap.css" />
	<link media="all" rel="stylesheet" href="css/font-awesome.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="js/pessoas.js?ver=2002"></script>
  </body>
</html>
