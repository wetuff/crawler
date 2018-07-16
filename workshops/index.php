<?php
	
	require_once '../functions.php';	
	header('Content-Type: text/html; charset=utf-8');

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<section class="secWorkshops" id="secWorkshops">
					<div class="Content">
						<div class="Conteudo">
							<div class="row">
								<div class="col-md-12">
									<h2 style="margin-bottom:0">w/shops e w/talks na weme</h2>
									<p class="Extra"></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
								</div>
								<div class="col-md-8">
									<h3>Top 5 eventos mais movimentados</h3>
									<div class="Grafico"><canvas id="grfTop5EventosMovimentados"></canvas></div>
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
							<div class="row">
								<div class="col-md-12">									
									<ul id="listaWorkshops" class="list"></ul>
								</div>
							</div>
						</div>

					</div>
				</section>

			</div>
		</div>

		<?php include '../footer.php'; ?>

		<link rel="stylesheet" media="all" href="/css/perfil.css" />
		<link rel="stylesheet" media="all" href="/css/workshops.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
		<script type="text/javascript" src="/js/list.min.js"></script>
		<script type="text/javascript" src="/js/workshops.js"></script>
	</body>
</html>

<?php

	$workshops; $tendendias = array(); $relacao = array();
	$query = "SELECT id, name, description, date, price, subscriptions FROM workshops";
	$query2 = "SELECT * FROM crawler.microtendencias";
	$query3 = "SELECT * FROM crawler.mt_workshop";
	$result = mysqli_query($connection, $query);
	$result2 = mysqli_query($connection, $query2);
	$result3 = mysqli_query($connection, $query3);

	if ( $result ) 
	{ 
		while($aux = mysqli_fetch_array($result)){		
			$workshops[] = array( 'workshop' => $aux["id"], 'nome' => $aux["name"], 'descricao' => $aux["description"], 'data' => $aux["date"], 'preco' => $aux["price"], 'inscritos' => $aux["subscriptions"] );
		}
	}

	if ( $result2 ) 
	{ 
		while($aux = mysqli_fetch_array($result2)){
			$tendendias[] = array( 'id' => $aux["id"], 'tendencia' => $aux["tendencia"]);
		}
	}

	if ( $result3 ) 
	{ 
		while($aux = mysqli_fetch_array($result3)){
			$relacao[] = array( 'id' => $aux["workshop_id"], 'tendencia' => $aux["tendencia_id"]);
		}
	}

	echo '<script type="text/javascript">loadWorkshops('.json_encode($workshops,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).', '.json_encode($tendendias,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).', '.json_encode($relacao,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).');</script>'
?>