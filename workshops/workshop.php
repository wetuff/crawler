<?php

	require_once '../functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$id = $_GET['id'];

	$query = "SELECT * FROM crawler.microtendencias";
	$query2 = "SELECT * FROM crawler.workshops WHERE id='$id'";
	$query3 = "SELECT * FROM crawler.mt_workshop WHERE workshop_id='$id'";
	$query4 = "SELECT * FROM crawler.macrotendencias";
	$query5 = "SELECT * FROM crawler.mat_workshop WHERE workshop_id='$id'";
	$result = mysqli_query($connection, $query);
	$result2 = mysqli_query($connection, $query2);
	$result3 = mysqli_query($connection, $query3);
	$result4 = mysqli_query($connection, $query4);
	$result5 = mysqli_query($connection, $query5);

	$name; $descricao; $preco; $data; $inscricoes; $tendendias = array(); $relacao = array(); $macro = array(); $relacaoMacro = array();

	if ( $result ) 
	{ 
		while($aux = mysqli_fetch_array($result)){
			$tendendias[] = array( 'id' => $aux["id"], 'tendencia' => $aux["tendencia"]);
		}
	}

	if ( $result2 ) 
	{ 
		while($aux = mysqli_fetch_array($result2)){
			$name = $aux["name"];
			$descricao = $aux["description"];
			$preco = $aux["price"];
			$data = $aux["date"];
			$inscricoes = $aux["subscriptions"];
		}
	}

	if ( $result3 ) 
	{ 
		while($aux = mysqli_fetch_array($result3)){
			$relacao[] = array( 'id' => $aux["workshop_id"], 'tendencia' => $aux["tendencia_id"]);
		}
	}

	if ( $result4 ) 
	{ 
		while($aux = mysqli_fetch_array($result4)){
			$macro[] = array( 'id' => $aux["id"], 'tendencia' => $aux["tendencia"]);
		}
	}

	if ( $result5 ) 
	{ 
		while($aux = mysqli_fetch_array($result5)){
			$relacaoMacro[] = array( 'id' => $aux["workshop_id"], 'tendencia' => $aux["tendencia_id"]);
		}
	}

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<section class="secWorkshop" id="secWorkshop">
					<div class="Content">
						<div class="Conteudo">
							<h2>Workshop</h2>

							<div id="profile">
								<div class="nome"><input type="text" id="txtName" value="<?php echo $name; ?>"></div>

								<div class="infos">
									<div class="data">
									<?php
										setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
										date_default_timezone_set('America/Sao_Paulo');
										echo strftime('%d de %B de %Y', strtotime($data));
									?>
									</div>
									<div class="preco"><?php echo $preco; ?></div>
									<div class="inscricoes"><?php echo $inscricoes; ?></div>
								</div>

								<div class="tendencias">
									<div class="macro">
										<h3>Macrotendência</h3>
										 <select id="macroTendencias">
										</select> 
									</div>
									<div class="micro">
										<h3>Tags</h3>
										 <select id="microTendencias" style="height: 100px;" multiple>
										</select>
										<div class="Adicionar">
											<h4>Adicionar tags</h4>
											<input type="text" id="txtNovaTendencia">
											<div class="botao"><a id="btnAddTendencia">Salvar</div>
										</div>
									</div>
								</div>

								<div class="descricao"><?php echo $descricao; ?></div>

								<div class="botao"><a id="btnSaveEvent" evento="<?php echo $id; ?>">Salvar</a></div>
								
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
		<script type="text/javascript" src="/js/workshops.js"></script>	
	</body>
</html>

<?php echo '<script type="text/javascript">loadTendencias('.json_encode($tendendias,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).', '.json_encode($relacao,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).', '.json_encode($id,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).', '.json_encode($macro,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).', '.json_encode($relacaoMacro,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).');</script>' ?>