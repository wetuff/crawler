

		<?php include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<div id="secHome" class="Table secHome Aba">
					<div class="Content">
						<div class="Conteudo">
							<div class="row">
								<div class="col-md-12">
									<h2>Dashboard weme</h2>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<h3>Visitantes neste ano</h3>
									<div class="Grafico"><canvas id="grfPessoas"></canvas></div>
								</div>
								<div class="col-md-6">
									<h3>Interesses</h3>
									<div class="Grafico"><canvas id="grfInteresses"></canvas></div>
								</div>
								<div class="col-md-6">
									<h3>Tipo de login</h3>
									<div class="Grafico"><canvas id="grfTipoLogin"></canvas></div>
								</div>
								<div class="col-md-6">
									<h3>Visitantes por gênero</h3>
									<div class="Grafico"><canvas id="grfGenero"></canvas></div>
								</div>

							</div>
							<div class="row" style="display:none">
								<div class="col-md-6">
									<h3>Top 3 dias mais movimentados</h3>
									<div class="Grafico"><canvas id="grfTop3DiasMovimentados"></canvas></div>
								</div>
								<div class="col-md-6">
									<h3>Top 3 eventos mais movimentados</h3>
									<div class="Grafico"><canvas id="grfTop3EventosMovimentados"></canvas></div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<?php include '../footer.php'; ?>

		<link rel="stylesheet" media="all" href="/css/perfil.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
		<script type="text/javascript" src="/js/perfil.js"></script>
	</body>
</html>
