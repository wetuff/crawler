<?php
	header('Content-Type: text/html; charset=utf-8');
	require '../dbconfig.php';

	$id = $_POST['id'];
	$name = json_decode($_POST['nome']);
	$macros = json_decode($_POST['macro']);
	$micros = json_decode($_POST['micro']);

	if (!isset($_POST)){
		return 0;
	}

	$jaCadasgtrado = mysqli_query($connection, "SELECT id FROM crawler.workshops WHERE id='$id'");
	$checkCadastro = mysqli_num_rows($jaCadasgtrado);	

	if(!empty($checkCadastro)){
	    $query = "UPDATE crawler.workshops SET name='$name' where id='$id'";
	    $teste = mysqli_query($connection, $query);
	}

	$clearMicro = mysqli_query($connection, "DELETE FROM crawler.mt_workshop WHERE workshop_id='$id'");
	mysqli_num_rows($clearMicro);	
    
	foreach ($micros as $micro){

	    if($micro->id != "" && $micro->id != null){

	        $idMicro = $micro->id;

	        $check = mysqli_query($connection, "SELECT id FROM crawler.microtendencias WHERE id='$idMicro'");
	        $check = mysqli_num_rows($check);
	        if (empty($check)) {
	            $queryObjetivo = "INSERT INTO crawler.microtendencias (tendencia) VALUES ('$micro->tendencia')";
	            $idMicro = mysqli_query($connection, $queryObjetivo);
	        }

	        $jaCadasgtradoMicro = mysqli_query($connection, "SELECT * FROM crawler.mt_workshop WHERE workshop_id='$id' AND tendencia_id='$idMicro'");
	        $checkCadastroMicro = mysqli_num_rows($jaCadasgtradoMicro);

	        if(empty($checkCadastroMicro)){
	            $queryMT = "INSERT INTO crawler.mt_workshop (workshop_id, tendencia_id) VALUES ('$id','$idMicro')";
	            mysqli_query($connection, $queryMT);
	        }
	    } else {			
	        $queryObjetivo = "INSERT INTO crawler.microtendencias (tendencia) VALUES ('$micro->tendencia')";
	        $idMicro = mysqli_query($connection, $queryObjetivo);
	        $queryMT = "INSERT INTO crawler.mt_workshop (workshop_id, tendencia_id) VALUES ('$id','$idMicro')";
	        mysqli_query($connection, $queryMT);
	    }

	}

	if(!empty($macros)){

	    $clearMacro = mysqli_query($connection, "DELETE FROM crawler.mat_workshop WHERE workshop_id='$id'");
	    mysqli_num_rows($clearMacro);

	    if($macros != "" && $macros != null && $macros != 0){
	        $queryMAT = "INSERT INTO crawler.mat_workshop (workshop_id, tendencia_id) VALUES ('$id','$macros')";
	        mysqli_query($connection, $queryMAT);
	    }		

	}
?>