<?php 

header("Content-Type: text/html; charset=utf-8");

//-------------------------------------------------------------------------- 
  // Example php script for fetching data from mysql database
  //--------------------------------------------------------------------------

	$host = 'localhost';
	$dbname = 'crawler';
	$user = 'checkin@2018';
	$password = 'crawler';

  //--------------------------------------------------------------------------
  // 1) Connect to mysql database
  //--------------------------------------------------------------------------

	$link = mysqli_connect("132.148.223.5", "crawler", "checkin@2018",'crawler') or die("Não foi possível conectar: " . mysql_error());    

  //--------------------------------------------------------------------------
  // 2) Query database for data
  //--------------------------------------------------------------------------

	$query = "SELECT * FROM crawler.objetivos";
	$query2 = "SELECT t2.oauth_uid, t2.oauth_provider, t2.first_name, t2.last_name, t2.email, t2.about, t2.gender, t2.locale, t2.picture, t2.link, t2.visitas, t2.empresa, t3.name FROM crawler.users t2 LEFT OUTER JOIN crawler.cargo t3 ON t2.cargo = t3.id";
	$query3 = "SELECT * FROM crawler.invalido";

	//Query database
	$list = array();
	$objetivos = array();
	$users = array();
	$outros = array();
	$result = mysqli_query($link, $query);
	$result2 = mysqli_query($link, $query2);
	$result3 = mysqli_query($link, $query3);

	if ( $result ) 
	{ 
		while($aux = mysqli_fetch_array($result)){
			$useragent = utf8_encode("Não informado");
			$motivo = utf8_encode("Não informado");
			if(utf8_encode($aux["useragent"]) != "" && utf8_encode($aux["useragent"]) != null){ $useragent = utf8_encode($aux["useragent"]); }
			if(utf8_encode($aux["motivo"]) != "" && utf8_encode($aux["motivo"]) != null){ $motivo = utf8_encode($aux["motivo"]); }
			$objetivos[] = array( 'id' => $aux["oauth_uid"], 'objetivo' => utf8_encode($aux["objetivo"]), 'data' => $aux["created"], 'useragent' => $useragent, 'motivo' => $motivo);
		}
	}

	if ( $result2 ) 
	{ 
		while($aux = mysqli_fetch_array($result2)){
			$empresa = utf8_encode("Não informado");
			if(utf8_encode($aux["empresa"]) != "" && utf8_encode($aux["empresa"]) != null){ $empresa = utf8_encode($aux["empresa"]); }
			$cargo = utf8_encode("Não informado");
			if(utf8_encode($aux["name"]) != "" && utf8_encode($aux["name"]) != null){ $cargo = utf8_encode($aux["name"]); }
			$users[] = array( 'id' => $aux["oauth_uid"], 'name' => utf8_encode($aux["first_name"]), 'email' => $aux["email"], 'visitas' => $aux["visitas"], 'sobrenome' => utf8_encode($aux["last_name"]), 'provedor' => $aux["oauth_provider"], 'sobre' => utf8_encode($aux["about"]), 'local' => utf8_encode($aux["locale"]), 'imagem' => $aux["picture"], 'link' => utf8_encode($aux["link"]), 'empresa' => $empresa, 'gender' => $aux["gender"], 'cargo' => $cargo);
		}
	}

	if ( $result3 ) 
	{ 
		while($aux = mysqli_fetch_array($result3)){
			$useragent = utf8_encode("Não informado");
			if(utf8_encode($aux["useragent"]) != "" && utf8_encode($aux["useragent"]) != null){ $useragent = utf8_encode($aux["useragent"]); }
			$outros[] = array( 'id' => $aux["oauth_uid"], 'email' => $aux["email"], 'visitas' => $aux["visitas"], 'data' => $aux["created"], 'useragent' => $useragent);
		}
	}

	$list[] = array('objetivos' => $objetivos, 'pessoas' => $users, 'outros' => $outros);

  //--------------------------------------------------------------------------
  // 3) echo result as json 
 //--------------------------------------------------------------------------

  print_r(json_encode($list,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

?> 