<?php

    function redirect($filename) {
    	if (!headers_sent())
    		header('Location: '.$filename);
    	else {
    		echo '<script type="text/javascript">';
    		echo 'alert("Tempo esgotado! Faça o login novamente! :)");';
    		echo 'window.location.href="'.$filename.'";';
    		echo '</script>';
    		echo '<noscript>';
    		echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
    		echo '</noscript>';
    	}
    }

	session_start();
	if(empty($_SESSION['session_ID'])){
		session_destroy();
		redirect('/login.php');
		die();
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
		<meta property="og:url" content="http://www.weme.com.br" />
		<meta property="og:description" content="Somos uma rede de pessoas e recursos para repensar negócios e experiências. Estamos aqui para apoiar e investir no desenvolvimento e rápido crescimento de ideias e negócios que vão transformar o mundo." />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="theme-color" content="#000000" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<link rel="apple-touch-startup-image" href="imagens/logo-weme.png">
		<link rel="image_src" href="imagens/logo-weme.png" />
		<link rel="manifest" href="manifest.json">
		<link rel="icon" href="http://www.weme.com.br/wp-content/uploads/2018/02/logo-weme-w300-100x100.png" sizes="32x32" />
		<link rel="icon" href="http://www.weme.com.br/wp-content/uploads/2018/02/logo-weme-w300.png" sizes="192x192" />
		<link rel="apple-touch-icon-precomposed" href="http://www.weme.com.br/wp-content/uploads/2018/02/logo-weme-w300.png" />
		<meta name="msapplication-TileImage" content="http://www.weme.com.br/wp-content/uploads/2018/02/logo-weme-w300.png" />
	</head>
	<body>
		<header class="collapse">
			<div class="nav-mobile-toggle">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="Logo"><img src="/imagens/logo-weme.png" /></div>
			</div>
			<nav>
				<ul>
					<li title="Home" hash="Home" class="Logo"><a href="/"><img src="/imagens/logo-weme.png" /></a></li>
					<li title="Home" hash="Home"><a href="/perfil">home</a></li>
					<li title="Empresas" hash="Empresas"><a href="/empresa/">Empresas</a></li>
					<li title="Visitantes" hash="Visitantes"><a href="/visitante/">Visitantes</a></li>
					<li title="Por Gênero" hash="Por Gênero"><a href="/perfil/genero.php">Por Gênero</a></li>
					<li title="Tendências" hash="Tendências"><a href="/tendencias/">Tendências</a></li>
					<li title="Workshops" hash="Workshops"><a href="/workshops/">Workshops</a></li>
				</ul>
			</nav>
		</header>