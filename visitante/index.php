<?php
	
	require_once '../functions.php';	
	header('Content-Type: text/html; charset=utf-8');

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<section class="secProfile" id="secProfile">
					<div class="Content">
						<div class="Conteudo">
							<div class="row">
								<div class="col-md-12">
									<h2 style="margin-bottom:0">Lista de contatos</h2>
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
								<ul id="contactList" class="list"></ul>
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
		<script type="text/javascript" src="/js/list.min.js"></script>
		<script type="text/javascript" src="/js/profile.js"></script>
		
	</body>
</html>

<?php

	$users;
	$empresas;
	$workshops;
	$query = "SELECT user_id, workshop_id, paid, pagseguro_code, c1.name, c1.price FROM crawler.user_workshop INNER JOIN crawler.workshops c1 ON workshop_id = c1.id";
	$query2 = "SELECT * FROM crawler.users";
	$query3 = "SELECT * FROM crawler.empresas";
	$result = mysqli_query($connection, $query);
	$result2 = mysqli_query($connection, $query2);
	$result3 = mysqli_query($connection, $query3);

	if ( $result ) 
	{ 
		while($aux = mysqli_fetch_array($result)){		
			$workshops[] = array( 'usuario' => $aux["user_id"], 'workshop' => $aux["workshop_id"], 'paid' => $aux["paid"], 'nome' => $aux["name"], 'preco' => $aux["price"], 'ps' => $aux["pagseguro_code"] );
		}
	}

		if ( $result2 ) 
	{ 
		while($aux = mysqli_fetch_array($result2)){
			$empresa = ("Não informado");
			if(($aux["empresa"]) != "" && ($aux["empresa"]) != null){ $empresa = ($aux["empresa"]); }			
			$users[] = array( 'id' => $aux["oauth_uid"], 'name' => ($aux["first_name"]), 'email' => ($aux["email"]), 'visitas' => $aux["visitas"], 'sobrenome' => ($aux["last_name"]), 'provedor' => $aux["oauth_provider"], 'sobre' => ($aux["about"]), 'local' => ($aux["locale"]), 'imagem' => $aux["picture"], 'link' => ($aux["link"]), 'empresa' => $empresa);
		}
	}

	if ( $result3 ) 
	{ 
		while($aux = mysqli_fetch_array($result3)){
			$id;
			$nome = ("Não informado");
			$dominio = ("Não informado");
			$endereco = ("Não informado");
			$telefone = ("Não informado");
			$tipo = ("Não informado");

			if(($aux["id"]) != "" && ($aux["id"]) != null){ $id = ($aux["id"]); }
			if(($aux["nome"]) != "" && ($aux["nome"]) != null){ $nome = ($aux["nome"]); }
			if(($aux["dominio"]) != "" && ($aux["dominio"]) != null){ $dominio = ($aux["dominio"]); }
			if(($aux["endereco"]) != "" && ($aux["endereco"]) != null){ $endereco = ($aux["endereco"]); }
			if(($aux["telefone"]) != "" && ($aux["telefone"]) != null){ $telefone = ($aux["telefone"]); }
			if(($aux["tipo"]) != "" && ($aux["tipo"]) != null){ $tipo = ($aux["tipo"]); }

			$empresas[] = array( 'id' => $id, 'nome' => $nome, 'dominio' => $dominio, 'endereco' => $endereco, 'telefone' => $telefone, 'tipo' => $tipo );
		}
	}

	echo '<script type="text/javascript">loadUsers('.json_encode($users,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).', '.json_encode($empresas,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).', '.json_encode($workshops,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).');</script>'
?>