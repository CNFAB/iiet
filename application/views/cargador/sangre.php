<!DOCTYPE html>

<html lang="es">
<head>
	<title>Sangre</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/modal-form.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/intervenciones2.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>
</head>
<body>

<header class="mb-4">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
				<h2 class="col-6 text-light mb-0">Campa&ntilde;a: Campo Chico 2015</h2>
				<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="links" class="col-6 navbar-collapse collapse justify-content-end">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="/iiet/welcome">Inicio</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/iiet/welcome/campanias">Campa&ntilde;as</a>
						</li>
					</ul>
				</div>
		</div>
	</div>
</header>
<section class="container-fluid pr-5 pb-5 pl-5">
	<div class="row justify-content-center mb-5">
		<form name="buscPaciente" class="col-8 text-center">
			<div class="row">
				<label for="busc-paciente" class="col-2 text-right pr-0 pt-1 pb-1 mb-0">Paciente</label>
				<div class="col-8">
					<div class="w-100">
						<input type="text" id="busc-paciente" class="form-control w-100" name="paciente" autofocus autocomplete="off" required />
						<button type="button" id="limpiar-buscador">&times;</button>
						<span id="dni-paciente"></span>
						<button type="button" id="btn-crear-paciente" class="btn btn-success btn-block d-none">Registrar Paciente<div class="fa fa-user-plus"></div></button>
						<ul id="lista-pacientes" class="list-group list-group-flush w-100 d-none"></ul>
					</div>
				</div>
				<button type="button" id="btn-datos-paciente" class="btn btn-primary fas fa-address-card"></button>
			</div>
		</form>
	</div>
	<form id="form_estudios" name="form_copro" is="form-asinc" action="/iiet/intervenciones/cargar_copro">
		<div class="form-row justify-content-center">
			<div class="form-group col-3">
				<label for="fs-fecha" class="mr-2">Fecha</label>
				<input type="date" name="fecha" id="fs-fecha" class="form-control" required="required" />
			</div>
			<div class="form-group col-3">
				<label for="fs-nro-tubo" class="mr-2">N° de Tubo</label>
				<input type="text" id="fs-nro-tubo" class="numero form-control" name="nro_tubo" required autocomplete="off" pattern="^[A-Z]{3,4}-\d{4}-\d{2}$" />
			</div>
		</div>
		<div class="form-row justify-content-center mt-4 contenedor-metodos">
			<div class="col-3 mr-3">
				<div class="accordion" id="hemograma">
					<div class="card">
						<div class="card-header cabecera-metodo">
							<h5 class="mb-0">
								<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-hemograma">HEMOGRAMA<div class="fa"></div></button>
							</h5>
						</div>
						<div id="result-hemograma" class="collapse" data-parent="#hemograma">
							<fieldset class="card-body cuerpo-metodo">
								<div class="form-row">
									<div class="col-12">
										<label for="globulos-blancos">Gl&oacute;bulos Blancos</label>
										<div class="grupo-control">
											<input type="text" id="globulos-blancos" class="numero form-control" name="hemograma[globulos_blancos]" pattern="^\d*(\.\d{1,2})?$" required autocomplete="off" />
											<span>mm&#179;</span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12">
										<label for="hemoglobina">Hemoglobina</label>
										<div class="grupo-control">
											<input type="text" id="hemoglobina" class="numero form-control" name="hemograma[hemoglobina]" pattern="^\d*(\.\d{1,2})?$" required autocomplete="off" />
											<span>gr&#47;dl</span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12">
										<label for="eosinofilos">Eosinofilos</label>
										<div class="grupo-control">
											<input type="text" id="eosinofilos" class="numero form-control" name="hemograma[eosinofilos]" pattern="^\d*(\.\d{1,2})?$" required autocomplete="off" />
											<span>&#37;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div class="col-3 mr-3">
				<div class="accordion" id="serologia">
					<div class="card">
						<div class="card-header cabecera-metodo">
							<h5 class="mb-0">
								<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-serologia">SEROLOGIA STRONGYLOIDES<div class="fa"></div></button>
							</h5>
						</div>
						<div id="result-serologia" class="collapse" data-parent="#serologia">
							<fieldset class="card-body cuerpo-metodo">
								<div class="form-row">
									<div class="col-12">
										<label for="titulo">T&iacute;tulo</label>
										<div class="grupo-control">
											<input type="text" id="titulo" class="numero form-control" name="serologia[titulo]" pattern="^\d*(\.\d{1,2})?$" required autocomplete="off" />
											<span>U</span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12">
										<input type="text" name="serologia[resultado]" class="form-control w-100"/>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script src="/iiet/assets/js/Forms.js"></script>
<script src="/iiet/assets/js/FormPaciente.js"></script>
<script src="/iiet/assets/js/FormBuscPaciente.js"></script>
<script src="/iiet/assets/js/forms-estudios/FormBase.js"></script>
<script src="/iiet/assets/js/forms-estudios/FormSimple.js"></script>
<script type="text/javascript">
	
new FormSimple(document.getElementById('hemograma'));
new FormSimple(document.getElementById('serologia'));

</script>
</html>