<?php session_start();
	require_once '../functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$dominio = $_GET['dominio'];

	$query3 = "SELECT * FROM crawler.empresas WHERE dominio='$dominio'";
	$result3 = mysqli_query($connection, $query3);

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

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<section class="secProfile" id="secProfile">
					<div class="Content">
						<div class="Conteudo">
							<h2>Perfil empresarial</h2>
							<div id="profile">
								
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
								<div class="Participantes">
								</div>
								<div class="Outros">
									<div id="investimento"></div>
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

	</body>
</html>
