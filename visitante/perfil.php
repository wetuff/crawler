<?php 

	require_once '../functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$email = $_GET['email'];
	$domain_name = substr(strrchr($email, "@"), 1);
	
	$query2 = "SELECT t2.oauth_uid, t2.oauth_provider, t2.first_name, t2.last_name, t2.email, t2.about, t2.gender, t2.locale, t2.picture, t2.link, t2.visitas, t2.empresa, t2.cargo, t3.name FROM crawler.users t2 INNER JOIN crawler.cargo t3 ON t2.cargo = t3.id WHERE email='$email'";
	$query3 = "SELECT * FROM crawler.empresas WHERE dominio='$domain_name'";
	$query = "SELECT mt_workshop.tendencia_id, c3.tendencia FROM crawler.mt_workshop
		INNER JOIN crawler.user_workshop c1 ON mt_workshop.workshop_id = c1.workshop_id
		INNER JOIN crawler.users c2 ON c1.user_id = c2.id AND c2.email='$email'
		INNER JOIN crawler.microtendencias c3 ON mt_workshop.tendencia_id = c3.id";
	$query4 = "SELECT * FROM crawler.cargo ORDER BY name ASC";	
	
	$result = mysqli_query($connection, $query);
	$result2 = mysqli_query($connection, $query2);
	$result3 = mysqli_query($connection, $query3);
	$result4 = mysqli_query($connection, $query4);

	$id; $name=""; $email; $about=""; $empresa=""; $cargo="Não informado"; $idCargo = ""; $endereco="Não informado"; $telefone=""; $interesses = array(); $imagem = ""; $cargos = "";

	if ( $result2 ) 
	{ 
		while($aux = mysqli_fetch_array($result2)){
			$id = $aux["oauth_uid"];
			$name = $aux["first_name"];
			$email = $aux["email"];
			$about = $aux["about"];

			if($aux["name"] != '' && $aux["name"] != null && $aux["name"] != '-'){
				$cargo = $aux["name"];
				$idCargo = $aux["cargo"];
			}			

			if($aux["picture"] != '' && $aux["picture"] != null && $aux["picture"] != '-'){
				$imagem = '<img src="'.$aux["picture"].'">';
			}
		}
	}

	if ( $result3 ) 
	{ 
		while($aux = mysqli_fetch_array($result3)){
			$empresa = ($aux["nome"]);
			if($aux["endereco"] != '' && $aux["endereco"] != null && $aux["endereco"] != '-'){
				$endereco = $aux["endereco"];
			}
			if($aux["telefone"] != '' && $aux["telefone"] != null && $aux["telefone"] != '-'){
				$telefone = $aux["telefone"];
			}
		}
	}

	if ( $result ) 
	{ 
		while($aux = mysqli_fetch_array($result)){
			$interesses[] = array( 'idT' => $aux["tendencia_id"], 'tendencia' => $aux["tendencia"]);
		}
	}

	if ( $result4 ) 
	{ 
		while($aux = mysqli_fetch_array($result4)){
			if($cargo == "Não informado" || $cargo == null || $cargo == ""){
				$cargos .= '<option value="'.$aux["id"].'">'.$aux["name"].'</option>';				
			} else {
				if((int)$aux["id"] == (int)$idCargo){
					$cargos .= '<option value="'.$aux["id"].'" selected="selected">'.$aux["name"].'</option>';				
				} else {
					$cargos .= '<option value="'.$aux["id"].'">'.$aux["name"].'</option>';				
				}
			}			
		}
	}

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<section class="secProfile" id="secProfile">
					<div class="Content">
						<div class="Conteudo">
							<h2>Perfil</h2>
							<div id="profile">
								<div class="row">
									<div class="col-md-12">
										<div class="Table">
											<div class="Cell">
												<div class="imagem"><?php echo $imagem; ?></div>
											</div>
											<div class="Cell">
												<div class="nome"><?php echo $name; ?></div>
												<div class="email"><?php echo $email; ?></div>
												<div class="sobre"><b>Sobre:</b> <?php echo $about; ?></div>
												<div class="interesses"><b>Interesses:</b> <span></span></div>

												<div id="dadosEmpresa">
													<h4>Empresa: <span class="empresa"><?php echo $empresa; ?></span></h4>
													<div class="dados cargo"><div class="Cell">Cargo: </div><div class="Cell"><select id="slcCargo2" name="slcCargo2"><option value="-">Selecione</option><?php echo $cargos; ?></select></div></div>
													<div class="dados endereco"><div class="Cell">Endereço: </div><div class="Cell"><input type="text" id="txtEndereco" value="<?php echo $endereco; ?>"></div></div>
													<div class="dados telefone"><div class="Cell">Telefone: </div><div class="Cell"><input type="tel" maxlength="15" autocomplete="off" id="txtTelefone" value="<?php echo $telefone; ?>"></div></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="Outros">
											<div id="investimento"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
									</div>
									<div class="col-md-6">
										<div class="botao"><a id="btnSaveProfile" profile="<?php echo $email; ?>">Atualizar</a></div>
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
		<script type="text/javascript" src="/js/jquery.mask.js"></script>
		<script type="text/javascript" src="/js/profile.js"></script>
		<?php 
			$workshops;
			$query = "SELECT c2.email, pagseguro_code, c1.name, c1.price FROM crawler.user_workshop INNER JOIN crawler.workshops c1 ON workshop_id = c1.id INNER JOIN crawler.users c2 ON user_id = c2.id WHERE c2.email='$email'";
			$result = mysqli_query($connection, $query);

			if ( $result ) 
			{ 
				while($aux = mysqli_fetch_array($result)){		
					$workshops[] = array( 'usuario' => $aux["email"], 'workshop' => $aux["name"], 'preco' => $aux["price"], 'ps' => $aux["pagseguro_code"] );
				}
			}

			echo '<script type="text/javascript">loadWorkshopProfile('.json_encode($workshops,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'); loadTendencia('.json_encode($interesses,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).');</script>';
		?>		
	</body>
</html>

