<?php session_start();

	require_once '../functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$dominio = $_GET['dominio'];
	$valorHora = 300;

	$query = "SELECT sum(visitas) FROM crawler.users WHERE email LIKE '%@$dominio'";
	$query2 = "SELECT t2.*, t3.name FROM crawler.users t2 LEFT JOIN crawler.cargo t3 ON (t2.cargo IS NOT NULL AND t2.cargo = t3.id) WHERE email LIKE '%@$dominio' ORDER BY first_name ASC";
	$query3 = "SELECT * FROM crawler.empresas WHERE dominio='$dominio'";
	$query4 = "SELECT sum(c1.price) FROM crawler.user_workshop
			INNER JOIN crawler.workshops c1 ON user_workshop.workshop_id = c1.id
			WHERE user_workshop.user_id IN (SELECT id FROM crawler.users WHERE email LIKE '%@$dominio')";
	$query5 = "SELECT mt_workshop.tendencia_id, c3.tendencia FROM crawler.mt_workshop
			INNER JOIN crawler.workshops c1 ON mt_workshop.workshop_id = c1.id
			INNER JOIN crawler.user_workshop c2 ON c1.id = c2.workshop_id
			INNER JOIN crawler.microtendencias c3 ON mt_workshop.tendencia_id = c3.id
			WHERE c2.user_id IN (SELECT id FROM crawler.users WHERE email LIKE '%@$dominio')";
	$query6 = "SELECT t1.*, t2.idProjeto, t2.projeto, t2.codigo, t2.budgetPor, t2.budget, t2.custoHora, t2.fee FROM crawler.clientes_empresas t1
			INNER JOIN crawler.projetos t2 ON t1.cliente_id = t2.idCliente
			WHERE t1.empresa_id = (SELECT id FROM crawler.empresas WHERE dominio='$dominio')";

	$result = mysqli_query($connection, $query);
	$result2 = mysqli_query($connection, $query2);
	$result3 = mysqli_query($connection, $query3);
	$result4 = mysqli_query($connection, $query4);
	$result5 = mysqli_query($connection, $query5);
	$result6 = mysqli_query($connection, $query6);
	$result7 = mysqli_query($connection, $query6);

	$id; $name; $email; $about; $empresa=""; $endereco=""; $telefone=""; $interesses = array(); $imagem = "";

	if ( $result3 ) 
	{ 
		while($aux = mysqli_fetch_array($result3)){
			$empresa = ($aux["nome"]);
			if($aux["endereco"] != '' && $aux["endereco"] != null && $aux["endereco"] != '-'){
				$endereco = '<b>endereço: </b>'.($aux["endereco"]);
			}
			if($aux["telefone"] != '' && $aux["telefone"] != null && $aux["telefone"] != '-'){
				$telefone = '<b>telefone: </b>'.($aux["telefone"]);
			}
		}
	}

	if ( $result5 ) 
	{ 
		while($aux = mysqli_fetch_array($result5)){
			$interesses[] = array( 'idT' => $aux["tendencia_id"], 'tendencia' => $aux["tendencia"]);
		}
	}

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<section class="secProfile" id="secProfile" style="margin-bottom:0">
					<div class="Content">
						<div class="Conteudo">
							<h2>Perfil empresarial</h2>
							<div id="profile">
								<div class="row">
									<div class="col-md-12">
										<div class="Table">
											<div class="Cell">
												<div class="logo"></div>
											</div>
											<div class="Cell">
												<div class="nome"><?php echo $empresa; ?></div>
												<div class="endereco"><?php echo $endereco; ?></div>
												<div class="telefone"><?php echo $telefone; ?></div>	
											</div>
										</div>
									</div>
								</div>
								<div class="row Outros">
									<div class="col-md-6">
										<div class="Extra">Total de visitas até o momento:<br><b><?php if ( $result ) { while($aux = mysqli_fetch_array($result)){ echo ( intval($aux[0]) + 0 ); } } else { echo "0"; } ?></b></div>
									</div>
									<div class="col-md-6">
										<div class="Extra">Total de retorno em eventos:<br><b>R$ <?php if ( $result4 ) { while($aux = mysqli_fetch_array($result4)){ echo ( intval($aux[0]) + 0 ); } } else { echo "0"; } ?></b></div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="Tendencias">
											<h3>Tendências</h3>
											<div class="interesses"><span></span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="Conteudo">
									<h3>Projetos</h3>
									<div class="row Outros">
										<div class="col-md-4">
											<div class="Extra">Total de Projetos cadastrados no Harvest:<br><b><?php if ( $result7 ) { $number = mysqli_num_rows($result7); echo $number; } else { echo '0'; } ?></b></div>
										</div>
										<div class="col-md-4">
											<div class="Extra">Total de retorno em projetos (apenas Harvest):<br><b><?php if ( $result7 ) { $budget = 0; while($aux2 = mysqli_fetch_array($result7)){ if($aux2["fee"] != 0){ $budget = (int)($budget) + (int)($aux2["fee"]); } else { $budget = (int)($budget) + ((int)($aux2["budget"]) * (int)($aux2["custoHora"]) ); } } echo 'R$ '.number_format($budget, 2, ',', '.'); } ?></b></div>
										</div>
										<div class="col-md-4">
											<div class="Extra">Ticket médio:<br><b><?php if((int)($budget/$number) != 0) { echo number_format((int)($budget/$number), 2, ',', '.'); } else { echo '0'; } ?></b></div>
										</div>
									</div>
									<div class="Projetos">
										<div id="listProjetos" class="info">
										<?php
											if ( $result6 ) 
											{
												while($aux = mysqli_fetch_array($result6)){

													$codigoProjeto = "";
													if ($aux["codigo"] != "" && $aux["codigo"] != null && ($aux["codigo"]) != 0) { $codigoProjeto = '[' . $aux["codigo"] . '] '; }

													$custo = 0;
													$custoHora = 0;
													if((int)($aux["custoHora"]) == 0){ $custoHora = $valorHora; } else { $custoHora = (int)($aux["custoHora"]); }
													if($aux["fee"] != 0){ $custo = (int)($custo) + (int)($aux["fee"]); } else { $custo = (int)($custo) + ((int)($aux["budget"]) * $custoHora ); }
													$custo = number_format($custo, 2, ',', '.'); 

													echo '<a class="projeto" href="/projetos/projeto.php?projeto='.strtolower($aux["idProjeto"]).'">
														<span class="titulo">
															<span class="codigoProjeto">'.$codigoProjeto.'</span>
															<span class="nomeProjeto">'.ucwords($aux["projeto"]).'</span>
														</span>
														<span class="infos">
															<span class="budgetPor">'.ucwords($aux["budgetPor"]).'</span>
															<span class="budget">'.$custo.'</span>
														</span></a>';
												}

											} else {
												echo 'Nenhum projeto encontrado.';
											}
										?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="Conteudo">
									<h3>Contatos</h3>
								</div>
								<div class="Participantes">
									<div class="info">
									<?php
										if ( $result2 ) 
										{ 
											while($aux = mysqli_fetch_array($result2)){
												echo '<a class="visitante" href="/visitante/perfil.php?email='.strtolower($aux["email"]).'"><span class="nomeVisitante">'.ucwords($aux["first_name"]).'</span><span class="emailVisitante">'.strtolower($aux["email"]).'</span><span class="cargoVisitante"><b>Cargo:</b> '.($aux["name"]).'</span><span class="visitasVisitante"><b>Visitas: </b>'.($aux["visitas"]).'</span></a>';
											}
										}
									?>
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
		<link rel="stylesheet" media="all" href="/css/profile.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="/js/profile.js"></script>
		<?php 


			echo '<script type="text/javascript">loadTendencia('.json_encode($interesses,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).');</script>';
		?>	
	</body>
</html>
