<?php
	header('Content-Type: text/html; charset=utf-8');
	require '../dbconfig.php';

	$idTendencia = $_POST['tendencia'];
	$tendencias = array();

	if (!isset($_POST)){
		return 0;
	}

	if($idTendencia != "" && $idTendencia != null){
		$query = "SELECT mt_workshop.workshop_id, c1.name, mt_workshop.tendencia_id, c2.tendencia, c4.first_name, c4.email FROM crawler.mt_workshop 
				INNER JOIN crawler.workshops c1 ON mt_workshop.workshop_id = c1.id AND mt_workshop.tendencia_id IN ('$idTendencia')
				INNER JOIN crawler.microtendencias c2 ON mt_workshop.tendencia_id = c2.id
				INNER JOIN crawler.user_workshop c3 ON mt_workshop.workshop_id = c3.workshop_id
				INNER JOIN crawler.users c4 ON c4.id = c3.user_id";
	} else {
		$query = "SELECT mt_workshop.tendencia_id, c2.tendencia FROM crawler.mt_workshop 
				INNER JOIN crawler.workshops c1 ON mt_workshop.workshop_id = c1.id AND mt_workshop.tendencia_id IN (SELECT id FROM crawler.microtendencias)
				INNER JOIN crawler.microtendencias c2 ON mt_workshop.tendencia_id = c2.id
				INNER JOIN crawler.user_workshop c3 ON mt_workshop.workshop_id = c3.workshop_id";
	}

	$result = mysqli_query($connection, $query);

	if ( $result ) 
	{ 
		if($idTendencia != "" && $idTendencia != null){
			while($aux = mysqli_fetch_array($result)){			
				$tendencias[] = array( 'id' => $aux["workshop_id"], 'name' => $aux["name"], 'idT' => $aux["tendencia_id"], 'tendencia' => $aux["tendencia"], 'nome' => $aux["name"], 'nome' => $aux["first_name"], 'email' => $aux["email"]);
			}
		} else {
			while($aux = mysqli_fetch_array($result)){			
				$tendencias[] = array( 'idT' => $aux["tendencia_id"], 'tendencia' => $aux["tendencia"] );
			}
		}
	}

	print_r(json_encode($tendencias,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

?>