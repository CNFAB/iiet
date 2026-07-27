<!DOCTYPE html>

<html lang="es">
<head>
	<title><?= $titulo ?></title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/mdb.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/modal-form.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/forms.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/intervenciones2.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>
</head>
<body>

<header class="mb-4">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
				<h2 class="col-8 mb-0">Campa&ntilde;a: <span id="nombre-campania"></span></h2>
				<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="links" class="col-4 navbar-collapse collapse justify-content-end">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a id="ir-campanias" class="nav-link" href="/iiet/welcome/campanias"><span class="fa fa-arrow-circle-left mr-1"></span> Volver a Campa&ntilde;as</a>
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
						<input type="text" id="busc-paciente" class="form-control w-100 text-capitalize" name="paciente" autofocus autocomplete="off" required />
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
	<input type="hidden" id="id_paciente" name="intervencion[paciente]" form="form_estudios" />
	<input type="hidden" id="id_campania" name="intervencion[campania]" form="form_estudios" />
	<?= $form ?>
	<div class="no-estudio row justify-content-center align-items-center">
		<div class="col-6 text-center">
			<span class="fa fa-spinner fa-spin fa-3x"></span>
		</div>
	</div>
	<div class="no-estudio row justify-content-center align-items-center d-none">
		<div class="col-4 text-center">
			<p>No hay paciente seleccionado</p>
		</div>
	</div>
	<div class="no-estudio row justify-content-center align-items-center d-none">
		<div class="col-6 text-center">
			<p>No se ha cargado <span class="nombre-form font-weight-bold text-uppercase mr-1 ml-1"></span> para este paciente en esta campa&ntilde;a</p>
			<button id="btn-cargar" type="button" class="btn btn-cargar">Cargar <span class="nombre-form"></span></button>
		</div>
	</div>
</section>
<aside id="btns-estudios">
	<a href="/iiet/campanias/copro" id="btn-copro" class="btn btn-block" title="Ir a Copro"></a>
	<a href="/iiet/campanias/sangre" id="btn-sangre" class="btn btn-danger btn-block" title="Ir a Sangre"></a>
	<a href="/iiet/campanias/biologia_molecular" id="btn-biomolec" class="btn btn-success btn-block" title="Ir a Biología Molecular"></a>
	<a href="/iiet/campanias/tratamiento" id="btn-tratamiento" class="btn btn-primary btn-block" title="Ir a Tratamiento"></a>
</aside>
<aside id="btns-operaciones">
	<button type="button" id="btn-eliminar" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal-eliminar" data-backdrop="static" data-keyborad="false"></button>
</aside>
<button type="submit" id="btn-guardar" class="btn btn-info btn-block" form="form_estudios"></button>
<div id="modal-paciente" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Nuevo Paciente</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body pr-4 pl-4">
				<form name="fPaciente" id="f-nuevo-pac" class="needs-validation" action="#" data-modo="nuevo" novalidate>
					<input type="hidden" name="numero" disabled />
					<div class="form-row justify-content-between">
						<div class="form-group col-6">
							<label for="fn-dni">DNI</label>
							<input type="number" name="dni" min="1000000" max="100000000" id="fn-dni" class="form-control dni-unico" autocomplete="off" autofocus required />
							<div class="invalid-feedback msj-invalido">
								El DNI es obligatorio y debe contener 7 u 8 d&iacute;gitos
							</div>
							<div class="msj-dni-duplicado">
								El DNI ingresado le pertenece al paciente <span></span>
							</div>
						</div>
						<div class="form-group col-6">
							<label for="fn-nro-cuaderno">N° Cuaderno</label>
							<input type="number" name="nro_cuaderno" min="1" id="fn-nro-cuaderno" class="form-control validar" autocomplete="off" />
						</div>
					</div>
					<div class="form-row justify-content-between">
						<div class="form-group col-6">
							<label for="fn-apellido">Apellido</label>
							<input type="text" name="apellido" id="fn-apellido" class="form-control validar" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								El Apellido es obligatorio
							</div>
						</div>
						<div class="form-group col-6">
							<label for="fn-nombre">Nombre</label>
							<input type="text" name="nombre" id="fn-nombre" class="form-control validar" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								El Nombre es obligatorio
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-6">
							<label for="fn-fecha-nac">Fecha Nacimiento</label>
							<input type="date" name="fecha_nacimiento" id="fn-fecha-nac" class="form-control validar" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								La Fecha de Nacimiento es obligatoria y no debe ser posterior a la fecha actual
							</div>
						</div>
					</div>
					<fieldset class="form-group">
						<legend class="col-form-legend">Sexo</legend>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" name="sexo" value="MASCULINO" class="custom-control-input" id="fn-sex-m" checked />
							<label for="fn-sex-m" class="custom-control-label">Masculino</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" name="sexo" value="FEMENINO" class="custom-control-input" id="fn-sex-f" />
							<label for="fn-sex-f" class="custom-control-label">Femenino</label>
						</div>
					</fieldset>
					<fieldset class="form-group">
						<legend class="col-form-legend">Domicilio</legend>
						<div class="form-row">
							<div class="form-group col-6">
								<label for="fn-dpto">Departamento</label>
								<select name="departamento" class="custom-select custom-select validar" id="fn-dpto" required></select>
								<div class="invalid-feedback msj-invalido">
									El Departamento es obligatorio
								</div>
							</div>
							<div class="form-group col-6">
								<label for="fn-localidad">Localidad</label>
								<select name="localidad" class="custom-select custom-select validar" id="fn-localidad" required></select>
								<div class="invalid-feedback msj-invalido">
									La Localidad es obligatoria
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-6">
								<div class="custom-control custom-radio custom-control-inline" style="margin-bottom: .3rem !important;">
									<input type="radio" name="lugar" value="barrio" class="custom-control-input" data-ref="#grupo-barrio" id="fn-lug-barrio" checked />
									<label for="fn-lug-barrio" class="custom-control-label">Barrio</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" name="lugar" value="paraje" class="custom-control-input" data-ref="#grupo-paraje" id="fn-lug-paraje" />
									<label for="fn-lug-paraje" class="custom-control-label">Paraje</label>
								</div>
								<div id="grupo-barrio">
									<select name="barrio" class="custom-select custom-select validar" required></select>
									<div class="invalid-feedback msj-invalido">
										El Barrio es obligatorio
									</div>
								</div>
								<div id="grupo-paraje" class="d-none">
									<select name="paraje" class="custom-select custom-select validar" required disabled></select>
									<div class="invalid-feedback msj-invalido">
										El Paraje es obligatorio
									</div>
								</div>
							</div>
							<div id="grupo-puesto" class="form-group col-6 d-none">
								<label for="fn-puesto">Puesto</label>
								<select name="puesto" class="custom-select custom-select validar" id="fn-puesto" required disabled></select>
								<div class="invalid-feedback msj-invalido">
									El Puesto es obligatorio
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col">
								<label for="fn-direc">Direcci&oacute;n</label>
								<input type="text" name="domicilio" class="form-control validar" id="fn-direc" />
							</div>
						</div>
					</fieldset>
					<div class="form-row">
						<div id="alert-np-error" class="col-12">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<input type="reset" form="f-nuevo-pac" value="Cancelar" class="btn btn-outline-danger" data-dismiss="modal" />
				<input type="submit" name="enviar" form="f-nuevo-pac" value="Crear" class="btn btn-outline-primary" />
			</div>
		</div>
	</div>
</div>
<div id="modal-eliminar" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Eliminar <span class="nombre-form text-capitalize"></span></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body pr-4 pl-4">
				<p>¿Desea eliminar &eacute;ste estudio en particular o la intervenci&oacute;n completa (Copro, Sangre, Biolog&iacute;a Molecular, Tratamiento)?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-outline-success">S&oacute;lo el estudio</button>
				<button type="button" class="btn btn-outline-primary">Toda la intervenci&oacute;n</button>
			</div>
		</div>
	</div>
</div>
<div id="alertas"></div>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script src="/iiet/assets/js/Forms.js"></script>
<script src="/iiet/assets/js/FormPaciente.js"></script>
<script src="/iiet/assets/js/FormBuscPaciente.js"></script>
<script src="/iiet/assets/js/config-interv-campania.js" type="module"></script>
</html>