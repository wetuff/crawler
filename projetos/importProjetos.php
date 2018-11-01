<!--<form action="importData.php" method="post" enctype="multipart/form-data" id="importFrm">
    <input type="file" name="file" />
    <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
</form>-->

<?php
	
	require_once '../functions.php';	
	header('Content-Type: text/html; charset=utf-8');
	$handle = curl_init();
	$keyPages = "total_pages";	
	$keyLinks = "links";
	$headers = array(
		"Authorization: Bearer 1435672.pt.sU2GxIrvkodZrCNYkIBu_5A5N-eTyh9cXAybzO5qzug1lXtamO8gZh9q8FQftEXrDWDRofyddUK_AwxHEy5BZg",
		"Harvest-Account-ID: 810112",
		"User-Agent: Crawler"
	);


	// IMPORT PROJECTS
	//////////////////

	$projetos = array();
	$keyProjects = "projects";	

	$urlProjects = "https://api.harvestapp.com/v2/projects";
	curl_setopt($handle, CURLOPT_URL, $urlProjects);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($handle, CURLOPT_USERAGENT, "Crawler");
	$responseProjects = curl_exec($handle);

	$totalPagesProjects = json_decode($responseProjects)->$keyPages;

	for ($x = 1; $x <= $totalPagesProjects; $x++) {		
	    curl_setopt($handle, CURLOPT_URL, $urlProjects."?page=$x&per_page=100");
	    curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($handle, CURLOPT_USERAGENT, "Crawler");
	    $response = curl_exec($handle);

	    $jsonObj = json_decode($response);
	    foreach ($jsonObj->$keyProjects as &$value) {

			// IMPORT CLIENTES
			//////////////////
	        $nome = $value->client->name;
			$id = $value->client->id;

			//check
			$result = mysqli_query($connection, "SELECT id FROM crawler.clientes WHERE idCliente = '$id'");
			$checkCadastro = mysqli_num_rows($result);

	        if(empty($checkCadastro)){
	            //insert
	            $execute = mysqli_query($connection, "INSERT INTO crawler.clientes (idCliente, cliente) VALUES ('$id', '$nome')");
	        } else {
				// update
				$execute = mysqli_query($connection, "UPDATE crawler.clientes SET cliente='$nome' WHERE idCliente = '$id'");
			}


			// IMPORT PROJECTS
			//////////////////

			//check 
			$result2 = mysqli_query($connection, "SELECT idProjeto FROM crawler.projetos WHERE idProjeto = '$value->id'");
			$checkCadastro2 = mysqli_num_rows($result2);

	        if(empty($checkCadastro2)){
				//insert
				$execute = mysqli_query($connection, "INSERT INTO crawler.projetos (idProjeto, idCliente, projeto, codigo, inicio, final, notas, horasTotais, horasBillable, budgetPor, budget, budgetGasto, custosTotais, custosTime, despesas, custoHora, fee) 
					VALUES ('$value->id', '$id', '$value->name', '$value->code', '$value->starts_on', '$value->ends_on', '$value->notes', '', '', '$value->budget_by', '$value->budget', '', '', '', '', '$value->hourly_rate', '$value->fee')");
			} else {
				//update
				$execute = mysqli_query($connection, "UPDATE crawler.projetos SET custoHora='$value->hourly_rate', fee='$value->fee' WHERE idProjeto = '$value->id'");
			}
	    }
	}

?>