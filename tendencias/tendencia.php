<?php 
	
	session_start();
	require_once '../functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$tendencias = array();
	$microRelacionado = array();
	$word = "";
	
	$idTendencia = $_GET['tendencia'];

	if (ctype_digit($idTendencia)) {

		$query = "SELECT mt_workshop.workshop_id, c1.name, mt_workshop.tendencia_id, c2.tendencia, c4.first_name, c4.email FROM crawler.mt_workshop 
				INNER JOIN crawler.workshops c1 ON mt_workshop.workshop_id = c1.id AND mt_workshop.tendencia_id IN ('$idTendencia')
				INNER JOIN crawler.microtendencias c2 ON mt_workshop.tendencia_id = c2.id
				INNER JOIN crawler.user_workshop c3 ON mt_workshop.workshop_id = c3.workshop_id
				INNER JOIN crawler.users c4 ON c4.id = c3.user_id";
		$result = mysqli_query($connection, $query);
		$num_rows = mysqli_num_rows($result);

		if ( $result ) 
		{
			while($aux = mysqli_fetch_array($result)){			
				$tendencias[] = array( 'id' => $aux["workshop_id"], 'name' => $aux["name"], 'idT' => $aux["tendencia_id"], 'tendencia' => $aux["tendencia"], 'nome' => $aux["first_name"], 'email' => $aux["email"]);
				$word = $aux["tendencia"];
			}
		}

	} else {

		$word = $_GET['tendencia'];

		$query = "(SELECT c2.oauth_uid, c2.first_name, c2.email FROM crawler.users c2 INNER JOIN crawler.objetivos c1 ON c1.objetivo='$idTendencia' AND c2.oauth_uid = c1.oauth_uid)
				UNION
				(SELECT c3.oauth_uid, '', c3.email FROM crawler.invalido c3 INNER JOIN crawler.objetivos c1 ON c1.objetivo='$idTendencia' AND c3.oauth_uid = c1.oauth_uid )";
		$query2 = "SELECT mt_workshop.tendencia_id, c1.tendencia FROM crawler.mt_workshop
				INNER JOIN crawler.microtendencias c1 ON mt_workshop.tendencia_id = c1.id
				WHERE workshop_id IN (SELECT mat_workshop.workshop_id FROM crawler.mat_workshop WHERE mat_workshop.tendencia_id IN (SELECT macrotendencias.id FROM crawler.macrotendencias WHERE macrotendencias.tendencia = 'Design'))";
		$result = mysqli_query($connection, $query);
		$result2 = mysqli_query($connection, $query2);
		$num_rows = mysqli_num_rows($result);

		if ( $result ) 
		{
			while($aux = mysqli_fetch_array($result)){			
				$tendencias[] = array( 'nome' => $aux["first_name"], 'email' => $aux["email"]);
			}
		}

		if ( $result2 ) 
		{
			while($aux = mysqli_fetch_array($result2)){			
				$microRelacionado[] = array( 'idT' => $aux["tendencia_id"], 'tendencia' => $aux["tendencia"]);
			}
		}
	
	}

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<div id="secHome" class="Table secHome Aba">
					<div class="Content">
						<div class="Conteudo">
							<h2>Tendência: <?php echo $word; ?></h2>
							<div id="Interessados">
								<p>Quantidade de interessados nesse assunto: <b><?php echo $num_rows; ?></b></p>
								<div id="exportaExcel" class="botao"><a>Exportar lista</a></div>
								<div id="excelHidden" class=""></div>
							</div>
							<div id="microtendencias" class="Micro">
								<h4>Microtendências relacionadas: <span></span></h4>
							</div>							
							<div id="Noticias">
								<h3>Últimas notícias relevantes sobre o assunto:</h3>
								<ul id="listaNoticias"></ul>
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
		<script type="text/javascript" src="/js/jquery.tabletoCSV.js"></script>
		<script type="text/javascript" src="/js/tendencia.js"></script>

		<?php
			echo '<script>loadTendencia('.json_encode($word).', '.json_encode($tendencias).', '.json_encode($microRelacionado).');</script>';
		?>
	</body>
</html>
