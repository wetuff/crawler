<?php
	header('Content-Type: text/html; charset=utf-8');
	require 'dbconfig.php';

	$provider = $_POST['provider'];
	$id = $_POST['id'];
	$about = $_POST['about'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$locale = $_POST['locale'];
	$picture = $_POST['picture'];
	$link = $_POST['link'];
	$empresa = $_POST['empresa'];
	$objetivo = $_POST['objetivo'];
	$useragent = $_POST['useragent'];
	$motivo = $_POST['motivo'];
	$cargo = $_POST['cargo'];
	$negocio = $_POST['negocio'];

	if($negocio == null && $negocio == ""){
		$negocio = 8;
	}

	if (!isset($_POST)){
		return 0;
	}
	
	if($provider != "email"){
		$check = mysqli_query($connection, "select * from users where oauth_uid='$id'");
		$check = mysqli_num_rows($check);
		$jaCadasgtrado = mysqli_query($connection, "select * from users where oauth_uid='$id'");
		$checkCadastro = mysqli_num_rows($jaCadasgtrado);
	} else{
		$jaCadasgtrado = mysqli_query($connection, "select * from users where email='$email'");
		$checkCadastro = mysqli_num_rows($jaCadasgtrado);
		$check = mysqli_query($connection, "select * from users where email='$email'");
		$check = mysqli_num_rows($check);
	}

	if(!empty($checkCadastro)){	
		foreach($jaCadasgtrado as $term_single) { $date = new DateTime($term_single['modified']); }
		$date->setTime(0, 01);
		$today = new DateTime();
		$today->setTime(0, 01);	
	}

	if (empty($check)) { // if new user . Insert a new record		

		if($cargo != null && $cargo != ""){
			$query = "INSERT INTO users (oauth_provider, oauth_uid, first_name, last_name, email, about, gender, locale, picture, link, visitas, empresa, cargo, negocio) VALUES ('$provider','$id','$firstName','$lastName','$email','$about','$gender','$locale','$picture','$link', '1','$empresa','$cargo','$negocio')";
		} else{
			$query = "INSERT INTO users (oauth_provider, oauth_uid, first_name, last_name, email, about, gender, locale, picture, link, visitas, empresa, negocio) VALUES ('$provider','$id','$firstName','$lastName','$email','$about','$gender','$locale','$picture','$link', '1','$empresa','$negocio')";
		}
		$queryObjetivo = "INSERT INTO objetivos (oauth_uid, objetivo, useragent, motivo) VALUES ('$id','$objetivo','$useragent','$motivo')";

		mysqli_query($connection, $query);
		mysqli_query($connection, $queryObjetivo);

		print_r("created");

	} else {   // If Returned user . update the user record		

		if($today!=$date){

			$query = "UPDATE users SET oauth_provider='$provider', first_name='$firstName', last_name='$lastName', email='$email', about='$about', gender='$gender', locale='$locale', picture='$picture', link='$link', visitas=visitas+1, empesa='$empresa' where email='$email'";	
			$queryObjetivo = "INSERT INTO objetivos (oauth_uid, objetivo, useragent, motivo) VALUES ('$id','$objetivo','$useragent','$motivo')";

			mysqli_query($connection, $query);
			mysqli_query($connection, $queryObjetivo);

			if($cargo != null && $cargo != ""){
				$queryC = "UPDATE users SET cargo='$cargo' where email='$email'";
				mysqli_query($connection, $queryC);
			}

			if($negocio != null && $negocio != ""){
				$queryD = "UPDATE users SET negocio='$negocio' where email='$email'";
				mysqli_query($connection, $queryD);
			}

			print_r("update");
		} else {
			print_r("jaRealizado");
		}
	}	
?>