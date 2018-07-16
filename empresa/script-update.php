<?php
	header('Content-Type: text/html; charset=utf-8');
	require '../dbconfig.php';

	// GET STRING AFTER ITEM SELECTED
	//////////////////////
    function after ($info, $inthat)
    {
        if (!is_bool(strpos($inthat, $info)))
        return substr($inthat, strpos($inthat,$info)+strlen($info));
    }

	// GET TITLE FROM URL GIVEN
	//////////////////////
	function getTitle($url) {
		$file_headers = @get_headers($url);
		if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 403 Forbidden' || $file_headers[0] == 'HTTP/1.1 403 Forbidden: Access is denied.' || $file_headers[0] == 'HTTP/1.1 463'  || $file_headers[0] == 'HTTP request failed! HTTP/1.1 463' || $file_headers[0] == 'HTTP/1.1 409 Conflict') {
			$title = "Não encontrado";
		}
		else{
			$data = file_get_contents($url);
			$title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
		}
		return $title;
	}

	// LIST COMPANY
	//////////////////////
	$listEmpresas = array();
	$listEmpresas2 = array();

	$checkEmpresas = mysqli_query($connection, "select * from empresas");
	if (!empty($checkEmpresas)) {
		while($aux = mysqli_fetch_array($checkEmpresas)){
			array_push($listEmpresas, strtolower($aux["dominio"]));
		}
	}


	// LIST USERS
	//////////////////////
	$dataEmails = array();
	$dataEmpresas = array();
	$check = mysqli_query($connection, "select * from users");

	if (!empty($check)) {

	    $number = mysqli_num_rows($check);
	    $i = 1;		

		while($aux = mysqli_fetch_array($check)){

		    $teste = strtolower(after('@', $aux["email"]));
		    if (in_array($teste, $listEmpresas) == false && $teste != "" && $teste != null) {

				$titulo = getTitle("http://www.".$teste);
				$dominio = $teste;
				$tipo = "privado";

				$queryEmpresa = "INSERT INTO empresas (nome, dominio, tipo) VALUES ('$titulo','$dominio','$tipo')";
				mysqli_query($connection, $queryEmpresa);

				array_push($listEmpresas, $teste);

				echo "<br>";
				print_r($titulo);

		    }

		    if ($i < $number) { } else { echo "Finalizando..."; }

		    $i++;

		}

	}

?>