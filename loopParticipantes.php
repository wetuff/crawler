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

	$link = mysqli_connect("107.180.51.22", "crawler", "checkin@2018",'crawler') or die("Não foi possível conectar: " . mysql_error());    

  //--------------------------------------------------------------------------
  // 2) Query database for data
  //--------------------------------------------------------------------------

	$query = "SELECT t1.oauth_uid, t1.objetivo, t1.created, t1.useragent, t2.oauth_provider, t2.first_name, t2.last_name, t2.email, t2.about, t2.gender, t2.locale, t2.picture, t2.link, t2.visitas, t2.empresa  FROM crawler.objetivos t1 INNER JOIN crawler.users t2 ON t1.oauth_uid = t2.oauth_uid";
	$query2 = "SELECT t1.objetivo, t1.created, t1.useragent, t2.email, t2.visitas FROM crawler.objetivos t1 INNER JOIN crawler.invalido t2 ON t1.created = t2.modified";

	//Query database
	$list = array();
	$result = mysqli_query($link, $query);
	$result2 = mysqli_query($link, $query2);

	if ( $result ) 
	{ 
		while($aux = mysqli_fetch_array($result)){
			$empresa = utf8_encode("Não informado");
			if(utf8_encode($aux["empresa"]) != "" && utf8_encode($aux["empresa"]) != null){ $empresa = utf8_encode($aux["empresa"]); }
			$useragent = utf8_encode("Não informado");
			if(utf8_encode($aux["useragent"]) != "" && utf8_encode($aux["useragent"]) != null){ $useragent = utf8_encode($aux["useragent"]); }
			$list[] = array( 'id' => $aux["oauth_uid"], 'name' => utf8_encode($aux["first_name"]), 'email' => $aux["email"], 'visitas' => $aux["visitas"], 'sobrenome' => utf8_encode($aux["last_name"]), 'provedor' => $aux["oauth_provider"], 'objetivo' => utf8_encode($aux["objetivo"]), 'data' => $aux["created"], 'sobre' => utf8_encode($aux["about"]), 'local' => utf8_encode($aux["locale"]), 'imagem' => $aux["picture"], 'link' => utf8_encode($aux["link"]), 'empresa' => $empresa, 'useragent' => $useragent);
		}
	}
	else
	{ 
		echo "0";
	} 
	if ( $result2 ) 
	{
		while($aux = mysqli_fetch_array($result2)){
			$useragent = utf8_encode("Não informado");
			if(utf8_encode($aux["useragent"]) != "" && utf8_encode($aux["useragent"]) != null){ $useragent = utf8_encode($aux["useragent"]); }
			$list[] = array( 'id' => 'invalido', 'email' => $aux["email"], 'visitas' => $aux["visitas"], 'objetivo' => utf8_encode($aux["objetivo"]), 'data' => $aux["created"], 'useragent' => $useragent);
		}
	}

  //--------------------------------------------------------------------------
  // 3) echo result as json 
 //--------------------------------------------------------------------------

  print_r(json_encode($list,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));


?> 