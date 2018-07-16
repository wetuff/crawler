<?php
	
	require_once '../functions.php';	
	header('Content-Type: text/html; charset=utf-8');

	////////////////////////////////////////
	/// QUERY FEMININO
	////////////////////////////////////////

	$queryQTDF = "SELECT * FROM crawler.users WHERE gender IN ('feminino', 'F');";
	$resultQTDF = mysqli_query($connection, $queryQTDF);
	$numQTDF = mysqli_num_rows($resultQTDF);

	$queryFeminino = "SELECT mt_workshop.tendencia_id, c2.tendencia FROM crawler.mt_workshop 
					INNER JOIN crawler.workshops c1 ON mt_workshop.workshop_id = c1.id AND mt_workshop.tendencia_id IN (SELECT id FROM crawler.microtendencias)
					INNER JOIN crawler.microtendencias c2 ON mt_workshop.tendencia_id = c2.id
					INNER JOIN crawler.user_workshop c3 ON mt_workshop.workshop_id = c3.workshop_id
					INNER JOIN crawler.users c4 ON c3.user_id = c4.id AND c4.gender IN ('feminino', 'F')";
	$resultFeminino = mysqli_query($connection, $queryFeminino);
	$tendenciasFeminino = array();

	if ( $resultFeminino ) 
	{
		while($aux = mysqli_fetch_array($resultFeminino)){			
			$tendenciasFeminino[] = array( 'idT' => $aux["tendencia_id"], 'tendencia' => $aux["tendencia"] );
		}
	}

	$queryWSfeminino = "SELECT user_workshop.workshop_id, c2.name FROM crawler.user_workshop
						INNER JOIN crawler.users c1 ON user_workshop.user_id = c1.id AND c1.gender IN ('feminino', 'F')
						INNER JOIN crawler.workshops c2 ON user_workshop.workshop_id = c2.id";
	$resultWSfeminino = mysqli_query($connection, $queryWSfeminino);
	$workshopfeminino = array();

	if ( $resultWSfeminino ) 
	{
		while($aux = mysqli_fetch_array($resultWSfeminino)){			
			$workshopfeminino[] = array( 'idWS' => $aux["workshop_id"], 'name' => $aux["name"] );
		}
	}

	////////////////////////////////////////
	/// QUERY MASCULINO
	////////////////////////////////////////

	$queryQTDM = "SELECT * FROM crawler.users WHERE gender IN ('masculino', 'M');";
	$resultQTDM = mysqli_query($connection, $queryQTDM);
	$numQTDM = mysqli_num_rows($resultQTDM);

	$querymasculino = "SELECT mt_workshop.tendencia_id, c2.tendencia FROM crawler.mt_workshop 
					INNER JOIN crawler.workshops c1 ON mt_workshop.workshop_id = c1.id AND mt_workshop.tendencia_id IN (SELECT id FROM crawler.microtendencias)
					INNER JOIN crawler.microtendencias c2 ON mt_workshop.tendencia_id = c2.id
					INNER JOIN crawler.user_workshop c3 ON mt_workshop.workshop_id = c3.workshop_id
					INNER JOIN crawler.users c4 ON c3.user_id = c4.id AND c4.gender IN ('masculino', 'M')";
	$resultMasculino = mysqli_query($connection, $querymasculino);
	$tendenciasMasculino = array();

	if ( $resultMasculino ) 
	{
		while($aux = mysqli_fetch_array($resultMasculino)){			
			$tendenciasMasculino[] = array( 'idT' => $aux["tendencia_id"], 'tendencia' => $aux["tendencia"] );
		}
	}

	$queryWSMasculino = "SELECT user_workshop.workshop_id, c2.name FROM crawler.user_workshop
						INNER JOIN crawler.users c1 ON user_workshop.user_id = c1.id AND c1.gender IN ('masculino', 'M')
						INNER JOIN crawler.workshops c2 ON user_workshop.workshop_id = c2.id";
	$resultWSMasculino = mysqli_query($connection, $queryWSMasculino);
	$workshopMasculino = array();

	if ( $resultWSMasculino ) 
	{
		while($aux = mysqli_fetch_array($resultWSMasculino)){			
			$workshopMasculino[] = array( 'idWS' => $aux["workshop_id"], 'name' => $aux["name"] );
		}
	}


	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme" style="display: block;">
			<div role="main">

				<section class="secGenero" id="secGenero">
					<div class="Content">
						<div class="Conteudo">
							<div class="row">
								<div class="col-md-12">
									<h2 style="margin-bottom:0">Relatório por gênero</h2>
								</div>
							</div>
						</div>
						<div class="Table Genero">
							<div class="Cell Feminino">
								<div class="row">
									<div class="col-md-12">
										<h3 id="totalVisitasF">Total de visitas: <span><?php echo $numQTDF; ?></span></h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h3>Top 5 microtendências</h3>
										<div class="Grafico chart-container"><canvas id="grfMicrotendenciasFeminino"></canvas></div>
									</div>
								</div>
								<hr></hr>
								<div class="row">
									<div class="col-md-12">
										<h3>Top 5 participação em eventos</h3>
										<div class="Grafico chart-container"><canvas id="grfWorkshopsFeminino"></canvas></div>
									</div>
								</div>
							</div>
							<div class="Cell Masculino">
								<div class="row">
									<div class="col-md-12">
										<h3 id="totalVisitasM">Total de visitas: <span><?php echo $numQTDM; ?></span></h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h3>Top 5 microtendências</h3>
										<div class="Grafico chart-container"><canvas id="grfMicrotendenciasMasculino"></canvas></div>
									</div>
								</div>
								<hr></hr>
								<div class="row">
									<div class="col-md-12">
										<h3>Top 5 participação em eventos</h3>
										<div class="Grafico chart-container"><canvas id="grfWorkshopsMasculino"></canvas></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

			</div>
		</div>

		<?php include '../footer.php'; ?>

		<link rel="stylesheet" media="all" href="/css/perfil.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
		<script type="text/javascript" src="/js/perfil.js"></script>
		
		<?php
			echo '<script>
				loadTendenciasFM('.json_encode($tendenciasFeminino).', "grfMicrotendenciasFeminino"); 
				loadTendenciasFM('.json_encode($tendenciasMasculino).', "grfMicrotendenciasMasculino");
				loadWorkshopsFM('.json_encode($workshopfeminino).', "grfWorkshopsFeminino");
				loadWorkshopsFM('.json_encode($workshopMasculino).', "grfWorkshopsMasculino");
			</script>';
		?>
	</body>
</html>
