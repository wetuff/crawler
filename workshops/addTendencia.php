<?php
	header('Content-Type: text/html; charset=utf-8');
	require '../dbconfig.php';

	$name = json_decode($_POST['nome']);
	$idMicro = 0;

	if (!isset($_POST)){
		return 0;
	}

	$jaCadasgtrado = mysqli_query($connection, "SELECT id FROM crawler.microtendencias WHERE tendencia='$name'");
	$checkCadastro = mysqli_num_rows($jaCadasgtrado);	

	if(empty($checkCadastro)){
		$queryObjetivo = "INSERT INTO crawler.microtendencias (tendencia) VALUES ('$name')";
	    $idMicro = mysqli_query($connection, $queryObjetivo);
		$resutado[] = array('id' => $idMicro, 'tendencia' => $name);
		print_r(json_encode($resutado,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
	}
	
?>