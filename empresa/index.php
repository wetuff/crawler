

		<?php include '../header.php'; ?>

		<div data-role="page" class="secWeme" id="secWeme">
			<div role="main">

				<section class="secEmpresa" id="secEmpresa">
					<div class="Content">
						<div class="Conteudo">
							<div class="row">
								<div class="col-md-12">
									<h2 style="margin-bottom:0">Empresas que já visitaram a weme</h2>
								</div>
							</div>
							<div class="row" style="display:none">
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
								<ul id="listaEmpresas" class="list"></ul>
							</div>
						</div>
					</div>
				</section>

			</div>
		</div>

		<?php include '../footer.php'; ?>

		<link rel="stylesheet" media="all" href="/css/perfil.css" />
		<link rel="stylesheet" media="all" href="/css/empresa.css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script type="text/javascript" src="/js/list.min.js"></script>
		<script type="text/javascript" src="/js/empresas.js"></script>
	</body>
</html>
