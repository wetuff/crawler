<?php

	require_once '../functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$id = $_GET['projeto'];

	$query = "SELECT t1.*, t2.projeto_id FROM crawler.microtendencias t1 INNER JOIN crawler.mt_projeto t2 ON t1.id = t2.tendencia_id";
	$query2 = "SELECT t1.*, t2.cliente FROM crawler.projetos t1 INNER JOIN crawler.clientes t2 ON t1.idCliente = t2.idCliente WHERE t1.idProjeto='$id'";
	$result = mysqli_query($connection, $query);
	$result2 = mysqli_query($connection, $query2);

	$tendencias=""; $name = ""; $codigo = ""; $valor = 0; $cliente = "";

	if ($result) 
	{ 
		while($aux = mysqli_fetch_array($result)){

			if((int)$aux["projeto_id"] == (int)$id){
				$tendencias .= '<option value="'.$aux["id"].'" selected="selected">'.$aux["tendencia"].'</option>';				
			} else {
				$tendencias .= '<option value="'.$aux["id"].'">'.$aux["tendencia"].'</option>';				
			}

		}
	}

	if ( $result2 ) 
	{ 
		while($aux = mysqli_fetch_array($result2)){
			$name = $aux["projeto"];
			if($aux["codigo"] != "" && $aux["codigo"] != null && (int)$aux["codigo"] != 0){
				$codigo = "[".$aux["codigo"]."] ";
			}

			if((int)$aux["fee"] != 0) {
				$valor = $aux["fee"];
			} else {
				$valor = (int)$aux["budget"] * (int)$aux["custoHora"];
			}

			$cliente = $aux["cliente"];
		}
	}

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<section class="secProjetos" id="secProjetos">
					<div class="Content">
						<div class="Conteudo">
							<h2>Projeto</h2>

							<div id="profile">
								<div class="nome"><?php echo $codigo; echo $name; ?></div>

								<div class="infos">
									<div class="cliente"></div>
									<div class="valor"><?php echo 'R$ '.number_format($valor, 2, ',', '.'); ?></div>
									<div class="participantes"></div>
								</div>

								<div class="tendencias">
									<div class="micro">
										<h3>Tags</h3>
										<select id="microTendencias" style="height: 100px;" multiple>
											<?php echo $tendencias; ?>
										</select>
										<div class="Adicionar">
											<h4>Adicionar tags</h4>
											<input type="text" id="txtNovaTendencia">
											<div class="botao"><a id="btnAddTendencia">Salvar</div>
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
		<link rel="stylesheet" media="all" href="/css/projetos.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="/js/projetos.js"></script>
	
	</body>
</html>