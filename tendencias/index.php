<?php 
	
	session_start();
	require_once '../functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$query = "SELECT mt_workshop.tendencia_id, c2.tendencia FROM crawler.mt_workshop 
			INNER JOIN crawler.workshops c1 ON mt_workshop.workshop_id = c1.id AND mt_workshop.tendencia_id IN (SELECT id FROM crawler.microtendencias)
			INNER JOIN crawler.microtendencias c2 ON mt_workshop.tendencia_id = c2.id
			INNER JOIN crawler.user_workshop c3 ON mt_workshop.workshop_id = c3.workshop_id";
	$result = mysqli_query($connection, $query);
	$tendencias = array();

	if ( $result ) 
	{
		while($aux = mysqli_fetch_array($result)){			
			$tendencias[] = array( 'idT' => $aux["tendencia_id"], 'tendencia' => $aux["tendencia"] );
		}
	}

	$query3 = "SELECT * FROM crawler.macrotendencias";
	$result3 = mysqli_query($connection, $query3);

	$macroTendencias = array();

	if ( $result3 ) 
	{ 
		while($aux = mysqli_fetch_array($result3)){
			$macroTendencias[] = array( 'idT' => $aux["id"], 'tendencia' => $aux["tendencia"] );
		}
	}

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<div id="secTendencias" class="Table secTendencias Aba">
					<div class="Content">
						<div class="Conteudo">
							<div class="row">
								<div class="col-md-12">
									<h2 style="margin-bottom:0">Macrotendências</h2>
									<p class="Extra ExtraMacro"></p>
									<ul id="listaMacroTendencias" class="listaTendencias">
								
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h2 style="margin-bottom:0">Microtendências</h2>
									<p class="Extra ExtraMicro"></p>
									<div class="row">
										<div class="col-md-2">
										</div>
										<div class="col-md-8">
											<h3>Top 5 microtendências</h3>
											<div class="Grafico"><canvas id="grfTop5Microtendencias"></canvas></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
								</div>
								<div class="col-md-8">
									<input class="search inputText" placeholder="Pesquisar" type="text" />
									<p style="font-style: italic;text-align: right;font-size: 12px;">
										<span data-es="Introduzca una palabra que el filtro se ajustará automáticamente">Digite uma palavra que o filtro será ajustado automaticamente</span>
									</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">

								<ul id="listaMicroTendencias" class="list listaTendencias">
								
								</ul>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<?php include '../footer.php'; ?>

		<link rel="stylesheet" media="all" href="/css/perfil.css" />
		<link rel="stylesheet" media="all" href="/css/tendencia.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
		<script type="text/javascript" src="/js/list.min.js"></script>
		<script type="text/javascript" src="/js/jquery.tabletoCSV.js"></script>
		<script type="text/javascript" src="/js/tendencia.js"></script>

		<?php
			echo '<script>loadAllTendencias('.json_encode($tendencias).', '.json_encode($macroTendencias).');</script>';
		?>
	</body>
</html>
