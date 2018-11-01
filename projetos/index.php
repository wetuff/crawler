<?php 
	
	require_once '../functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$projetos;
	$query3 = "SELECT t1.*, t2.cliente FROM crawler.projetos t1 INNER JOIN crawler.clientes t2 ON t1.idCliente = t2.idCliente";
	$result3 = mysqli_query($connection, $query3);
	if ( $result3 ) 
	{ 
		while($aux = mysqli_fetch_array($result3)){
			
			$inicio = ("Não informado");
			$final = ("Não informado");
			$notas = ("Não informado");

			if(($aux["inicio"]) != "" && ($aux["inicio"]) != null){ $inicio = ($aux["inicio"]); }
			if(($aux["final"]) != "" && ($aux["final"]) != null){ $final = ($aux["final"]); }
			if(($aux["notas"]) != "" && ($aux["notas"]) != null){ $notas = ($aux["notas"]); }

			$projetos[] = array( 'id' => $aux["idProjeto"], 'nome' => $aux["projeto"], 'cliente' => $aux["idCliente"], 'nomeCliente' => $aux["cliente"], 'codigo' => $aux["codigo"], 'budget' => $aux["budget"] );
		}
	}

	$horas = "";

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<div id="secProjetos" class="Table secProjetos Aba">
					<div class="Content">
						<div class="Conteudo">
							<div class="row">
								<div class="col-md-12">
									<h2 style="margin-bottom:0">Projetos</h2>
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
								<ul id="listaProjetos" class="list"></ul>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<?php include '../footer.php'; ?>

		<link rel="stylesheet" media="all" href="/css/perfil.css" />
		<link rel="stylesheet" media="all" href="/css/projetos.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="/js/list.min.js"></script>
		<script type="text/javascript" src="/js/projetos.js"></script>

		<?php echo '<script>loadProjetos('.json_encode($projetos).', '.json_encode($horas).');</script>'; ?>
	</body>
</html>
