<?php
	header('Content-Type: text/html; charset=utf-8');
	require 'dbconfig.php';

	$email = $_POST['email'];
	$cargo = $_POST['cargo'];
	$objetivo = $_POST['objetivo'];
	$useragent = $_POST['useragent'];
	$motivo = $_POST['motivo'];
	$id = $_POST['id'];

	if (!isset($_POST)){
		return 0;
	}	

	$jaCadasgtrado = mysqli_query($connection, "select * from users where email='$email'");
	$checkCadastro = mysqli_num_rows($jaCadasgtrado);
	$check = mysqli_query($connection, "select * from users where email='$email'");
	$check = mysqli_num_rows($check);	

	if(!empty($checkCadastro)){	
		foreach($jaCadasgtrado as $term_single) { $date = new DateTime($term_single['modified']); $id = $term_single['oauth_uid']; }
		$date->setTime(0, 01);
		$today = new DateTime();
		$today->setTime(0, 01);	
	} else{
		$today = new DateTime();
		$today->setTime(0, 01);	
	}

	if (!empty($check)) {

		if($today!=$date){

			$query = "UPDATE users SET visitas=visitas+1 where email='$email'";	
			$queryObjetivo = "INSERT INTO objetivos (oauth_uid, objetivo, useragent, motivo) VALUES ('$id','$objetivo','$useragent', '$motivo')";

			mysqli_query($connection, $query);
			mysqli_query($connection, $queryObjetivo);

			if($cargo != null && $cargo != ""){
				$queryC = "UPDATE users SET cargo='$cargo' WHERE email='$email'";
				mysqli_query($connection, $queryC);
			}

			print_r("update");
		}
	} else{

		$jaCadasgtrado2 = mysqli_query($connection, "select * from invalido where email='$email'");
		$checkCadastro2 = mysqli_num_rows($jaCadasgtrado2);

		if (empty($checkCadastro2)) {
			if($cargo != null && $cargo != ""){
				$query = "INSERT INTO invalido (oauth_uid, email, visitas, useragent, cargo) VALUES ('$id','$email','1','$useragent','$cargo')";
			} else {
				$query = "INSERT INTO invalido (oauth_uid, email, visitas, useragent) VALUES ('$id','$email','1','$useragent')";
			}
			$queryObjetivo = "INSERT INTO objetivos (oauth_uid, objetivo, useragent, motivo) VALUES ('$id','$objetivo','$useragent', '$motivo')";
			mysqli_query($connection, $query);
			mysqli_query($connection, $queryObjetivo);
			print_r("update 2");
		} else { 
			$query = "UPDATE invalido SET visitas=visitas+1 where email='$email'";
			foreach($jaCadasgtrado2 as $term_single) {
				$id = $term_single['oauth_uid'];
				$queryObjetivo = "INSERT INTO objetivos (oauth_uid, objetivo, useragent, motivo) VALUES ('$id','$objetivo','$useragent', '$motivo')";
			}
			mysqli_query($connection, $query);
			mysqli_query($connection, $queryObjetivo);
			if($cargo != null && $cargo != ""){
				$queryC = "UPDATE users SET cargo='$cargo' WHERE email='$email'";
				mysqli_query($connection, $queryC);
			}
			print_r("update 3");
		}

		
	}
?>