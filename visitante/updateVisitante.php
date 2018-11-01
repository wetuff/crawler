<?php
	header('Content-Type: text/html; charset=utf-8');
	require '../dbconfig.php';

	$id = $_POST['id'];
	$cargo = json_decode($_POST['cargo']);
	$endereco = json_decode($_POST['endereco']);
	$telefone = json_decode($_POST['telefone']);

	$domain_name = substr(strrchr($id, "@"), 1);

	if (!isset($_POST)){
		return 0;
	}

	$jaCadasgtrado = mysqli_query($connection, "SELECT id FROM crawler.users WHERE email='$id'");
	$checkCadastro = mysqli_num_rows($jaCadasgtrado);	

	if(!empty($checkCadastro)){

		if($cargo != "" && $cargo != null && $cargo != "Não informado") {
			$query = "UPDATE crawler.users SET cargo='$cargo' where email='$id'";
			$execute = mysqli_query($connection, $query);
		}

	}

	$empresaUser = mysqli_query($connection, "SELECT * FROM crawler.empresas WHERE dominio='$domain_name'");
	$result3 = mysqli_num_rows($empresaUser);
	if(!empty($checkCadastro)){

		if($endereco != "" && $endereco != null && $endereco != "Não informado") {
			$query = "UPDATE crawler.empresas SET endereco='$endereco' where dominio='$domain_name'";
			$execute = mysqli_query($connection, $query);
		}

		if($telefone != "" && $telefone != null && $telefone != "Não informado") {
			$query = "UPDATE crawler.empresas SET telefone='$telefone' where dominio='$domain_name'";
			$execute = mysqli_query($connection, $query);
		}		

	}
?>