<?php 
	
	session_start();
	require_once '../functions.php';
	header('Content-Type: text/html; charset=utf-8');

	$interesse = $_GET['interesse'];

	$query2 = "SELECT t2.oauth_uid, t2.oauth_provider, t2.first_name, t2.last_name, t2.email, t2.about, t2.gender, t2.locale, t2.picture, t2.link, t2.visitas, t2.empresa FROM crawler.users t2";
	$result2 = mysqli_query($connection, $query2);

	include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">


			</div>
		</div>

		<footer>
			<div class="Content">
				<div class="Conteudo">
					<div class="Table">
						<div class="Cell Left"><div class="Copyright">© powered by weme</div></div>
						<div class="Cell Right">
							<p>Av. Jesuíno Marcondes Machado, 630 | Nova Campinas</p>
							<p>Campinas/SP | <a href="mailto:info@weme.nu">info@weme.nu</a> | 19 3045-8300</p>
						</div>
					</div>
				</div>
			</div>
		</footer>

		<link rel="stylesheet" media="all" href="/css/perfil.css" />
		<link rel="stylesheet" media="all" href="/css/interesse.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		
	</body>
</html>
