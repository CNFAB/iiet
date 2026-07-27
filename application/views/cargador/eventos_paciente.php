<!DOCTYPE html>

<html lang="es">
<head>
	<title>Eventos: <?= $titulo ?></title>
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
				<h2 class="col-8 mb-0">Eventos: <?= $titulo ?></h2>
				<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="links" class="col-4 navbar-collapse collapse justify-content-end">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a id="ir-inicio" class="nav-link" href="/iiet/inicio/operario"><span class="fa fa-arrow-circle-left mr-1"></span> Volver a Inicio</a>
						</li>
					</ul>
				</div>
		</div>
	</div>
</header>
<section class="container-fluid">
	<div class="row justify-content-center mb-3">
		<form name="buscPaciente" class="col-8 text-center">
			<div class="row">
				<label for="busc-paciente" class="col-2 text-right pr-0 pt-1 pb-1 mb-0">Paciente</label>
				<div class="col-8">
					<div class="w-100">
						<input type="text" id="busc-paciente" class="form-control w-100 text-capitalize" name="paciente" autofocus autocomplete="off" required/>
						<button type="button" id="limpiar-buscador">&times;</button>
						<span id="dni-paciente"></span>
						<button type="button" id="btn-crear-paciente" class="btn btn-success btn-block d-none">
							Registrar Paciente
							<i class="fa fa-user-plus ml-1"></i>
						</button>
						<ul id="lista-pacientes" class="list-group list-group-flush w-100"></ul>
					</div>
				</div>
				<button type="button" id="btn-datos-paciente" class="btn btn-primary fas fa-address-card" title="Ver / Editar Datos"></button>
			</div>
		</form>	
	</div>
	<input type="hidden" id="id_interv" name="intervencion[numero]" form="form_estudios" />
	<input type="hidden" id="id_paciente" name="intervencion[paciente]" form="form_estudios" />
	<input type="hidden" id="id_campania" name="intervencion[campania]" form="form_estudios" />
	<div id="paginacion" class="row">
		<div id="pag-contenido" class="col-12 pt-3 pb-3">
			<div id="datos-interv" class="row pl-3 d-none">
				<div id="datos-campania" class="dropdown d-inlineblock">
					<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
						Campa&ntilde;a: <span class="datos-interv-item"></span>
					</button>
					<div class="dropdown-menu">
						<p class="dropdown-item"><span>Fecha:</span> <span class="datos-interv-item"></span></p>
						<p class="dropdown-item"><span>Tipo:</span> <span class="datos-interv-item"></span></p>
						<p class="dropdown-item"><span>Localidad:</span> <span class="datos-interv-item"></span></p>
					</div>
				</div>
				<div id="datos-externo" class="dropdown d-inlineblock d-none">
					<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
						Ambulatorio: <span class="datos-interv-item"></span>
					</button>
					<div class="dropdown-menu">
						<p class="dropdown-item"><span>Fecha:</span> <span class="datos-interv-item"></span></p>
						<p class="dropdown-item"><span>Procedencia:</span> <span class="datos-interv-item"></span></p>
						<p class="dropdown-item"><span>Localidad:</span> <span class="datos-interv-item"></span></p>
					</div>
				</div>
			</div>
			<?= $form ?>
			<div id="msj-cargando" class="no-estudio row justify-content-center align-items-center h-100">
				<div class="col-6 text-center">
					<span class="fa fa-spinner fa-spin fa-3x"></span>
				</div>
			</div>
			<div id="msj-no-paciente" class="no-estudio row justify-content-center align-items-center h-100 d-none">
				<div class="col-4 text-center">
					<p>No hay paciente seleccionado</p>
				</div>
			</div>
			<div id="msj-no-interv" class="no-estudio row justify-content-center align-items-center h-100 d-none">
				<div class="col-6 text-center">
					<p>No hay eventos para este paciente</p>
					<button id="btn-nueva-interv" type="button" class="btn btn-cargar" data-toggle="modal" data-target="#modal-crear-interv" data-backdrop="static" data-keyborad="false">Crear Evento</button>
				</div>
			</div>
			<div id="msj-no-estudios" class="no-estudio row justify-content-center align-items-center h-100 d-none">
				<div class="col-6 text-center">
					<p>No se ha cargado <span class="nombre-form font-weight-bold text-uppercase mr-1 ml-1"></span> para este paciente en este evento</p>
					<button id="btn-cargar" type="button" class="btn btn-cargar">Cargar <span class="nombre-form"></span></button>
				</div>
			</div>
		</div>
		<nav id="pag-indices" class="col-12 align-self-end">
			<ul class="pagination justify-content-center mb-0 pt-2 pb-2">
				<li class="page-item"><button type="button" class="pag-anterior page-link">Anterior</button></li>
				<li class="page-item"><button type="button" class="pag-posterior page-link">Siguiente</button></li>
			</ul>
		</nav>
	</div>
</section>
<aside id="btns-estudios">
	<a href="/iiet/eventos/copro" id="btn-copro" class="btn btn-block" title="Ir a Copro"></a>
	<a href="/iiet/eventos/sangre" id="btn-sangre" class="btn btn-danger btn-block" title="Ir a Sangre"></a>
	<a href="/iiet/eventos/biologia_molecular" id="btn-biomolec" class="btn btn-success btn-block" title="Ir a Biología Molecular"></a>
	<a href="/iiet/eventos/tratamiento" id="btn-tratamiento" class="btn btn-primary btn-block" title="Ir a Tratamiento"></a>
</aside>
<aside id="btns-operaciones">
	<div id="resumen"></div>
	<button type="button" id="btn-resumen" class="btn btn-success btn-block fas fa-clipboard-list fa-2x d-none" title="Resumen"></button>
	<button type="button" id="btn-crear-interv" class="btn btn-primary btn-block d-none" title="Nuevo Evento" data-toggle="modal" data-target="#modal-crear-interv" data-backdrop="static" data-keyborad="false"></button>
	<button type="button" id="btn-eliminar" class="btn btn-danger btn-block d-none" data-toggle="modal" data-target="#modal-eliminar" data-backdrop="static" data-keyborad="false"></button>
</aside>
<button type="submit" id="btn-guardar" class="btn btn-info btn-block d-none" form="form_estudios"></button>
<!-- formulario modal Paciente -->
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
<!-- formulario modal de selección de tipo de intervención -->
<div id="modal-crear-interv" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Nueva Intervenci&oacute;n</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body pr-4 pl-4">
				<form name="formTipoInterv">
					<fieldset class="form-group">
						<legend class="col-form-legend">Tipo</legend>
						<div class="custom-control custom-radio">
							<input type="radio" name="tipo" value="EXTERNO" class="custom-control-input" id="tipo-ext" checked />
							<label for="tipo-ext" class="custom-control-label">Consultorio Externo</label>
						</div>
						<div class="custom-control custom-radio mb-2">
							<input type="radio" name="tipo" value="CAMPANIA" class="custom-control-input" id="tipo-camp" />
							<label for="tipo-camp" class="custom-control-label">Campa&ntilde;a</label>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
				<button type="button" id="btn-sig-tipo-interv" class="btn btn-outline-primary">Siguiente</button>
			</div>
		</div>
	</div>
</div>
<!-- formulario modal de selección de campaña -->
<div id="modal-selec-campania" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Seleccionar Campa&ntilde;a</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body pr-4 pl-4">
				<form name="formSelecCampania">
					<div class="form-row">
						<div class="form-group col-6">
							<label for="sc-deparamento">Departamento</label>
							<select name="departamento" class="custom-select input-requerido" id="sc-deparamento" required></select>
							<div class="invalid-feedback msj-invalido">
								El Departamento es obligatorio
							</div>
						</div>
						<div class="form-group col-6">
							<label for="sc-localidad">Localidad</label>
							<select name="localidad" class="custom-select input-requerido" id="sc-localidad" required></select>
							<div class="invalid-feedback msj-invalido">
								La Localidad es obligatoria
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-6">
							<div class="custom-control custom-radio custom-control-inline" style="margin-bottom: .3rem !important;">
								<input type="radio" name="lugar" value="barrio" class="custom-control-input" data-ref="#sc-grupo-barrio" id="sc-lug-barrio" checked />
								<label for="sc-lug-barrio" class="custom-control-label">Barrio</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" name="lugar" value="paraje" class="custom-control-input" data-ref="#sc-grupo-paraje" id="sc-lug-paraje" />
								<label for="sc-lug-paraje" class="custom-control-label">Paraje</label>
							</div>
							<div id="sc-grupo-barrio">
								<select name="barrio" class="custom-select custom-select input-requerido" required></select>
								<div class="invalid-feedback msj-invalido">
									El Barrio es obligatorio
								</div>
							</div>
							<div id="sc-grupo-paraje" class="d-none">
								<select name="paraje" class="custom-select custom-select input-requerido" required disabled></select>
								<div class="invalid-feedback msj-invalido">
									El Paraje es obligatorio
								</div>
							</div>
						</div>
						<div id="grupo-puesto" class="form-group col-6 d-none">
							<label for="sc-puesto">Puesto</label>
							<select name="puesto" class="custom-select input-requerido" id="sc-puesto" required disabled></select>
							<div class="invalid-feedback msj-invalido">
								El Puesto es obligatorio
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-6">
							<div class="custom-control custom-checkbox custom-control-inline">
								<input type="checkbox" name="check-institucion" value="si" class="custom-control-input" id="sc-check-institucion" />
								<label for="sc-check-institucion" class="custom-control-label">Instituci&oacute;n</label>
							</div>
							<div class="d-none grupo-institucion">
								<select name="institucion" class="custom-select input-requerido" required disabled></select>
								<div class="invalid-feedback msj-invalido">
									La instituci&oacute;n es obligatoria
								</div>
							</div>
						</div>
						<div class="form-group col-6">
							<label for="sc-nombre">Campa&ntilde;a</label>
							<select name="campania" class="custom-select input-requerido" id="sc-nombre" required></select>
							<div class="invalid-feedback msj-invalido">
								El Departamento es obligatorio
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
				<button type="button" id="btn-selec-campania" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<!--- formulario modal de creación de intervención por consultorio externo -->
<div id="modal-crear-externo" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Consultorio Externo</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body pr-4 pl-4">
				<form name="formExterno">
					<input type="hidden" name="paciente"/>
					<div class="form-row">
						<div class="form-group col-6">
							<label for="ext-fecha">Fecha</label>
							<input type="date" name="fecha" id="ext-fecha" class="form-control validar" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								La Fecha es obligatoria y no debe ser posterior a la fecha actual
							</div>
						</div>
					</div>
					<fieldset class="form-group">
						<legend class="col-form-legend">Procedencia</legend>
						<div class="form-row">
							<div class="form-group col-6">
								<label for="ext-dpto">Departamento</label>
								<select name="departamento" class="custom-select custom-select validar" id="ext-dpto" required></select>
								<div class="invalid-feedback msj-invalido">
									El Departamento es obligatorio
								</div>
							</div>
							<div class="form-group col-6">
								<label for="ext-localidad">Localidad</label>
								<select name="localidad" class="custom-select custom-select validar" id="ext-localidad" required></select>
								<div class="invalid-feedback msj-invalido">
									La Localidad es obligatoria
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-6">
								<div class="custom-control custom-radio custom-control-inline" style="margin-bottom: .3rem !important;">
									<input type="radio" name="lugar" value="barrio" class="custom-control-input" data-ref="#ext-grupo-barrio" id="ext-lug-barrio" checked />
									<label for="ext-lug-barrio" class="custom-control-label">Barrio</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" name="lugar" value="paraje" class="custom-control-input" data-ref="#ext-grupo-paraje" id="ext-lug-paraje" />
									<label for="ext-lug-paraje" class="custom-control-label">Paraje</label>
								</div>
								<div id="ext-grupo-barrio">
									<select name="barrio" class="custom-select custom-select validar" required></select>
									<div class="invalid-feedback msj-invalido">
										El Barrio es obligatorio
									</div>
								</div>
								<div id="ext-grupo-paraje" class="d-none">
									<select name="paraje" class="custom-select custom-select validar" required disabled></select>
									<div class="invalid-feedback msj-invalido">
										El Paraje es obligatorio
									</div>
								</div>
							</div>
							<div class="form-group col-6">
								<label for="ext-institucion">Instituci&oacute;n</label>
								<select name="institucion" class="custom-select custom-select validar" id="ext-institucion" required></select>
								<div class="invalid-feedback msj-invalido">
									La instituci&oacute;n es obligatoria
								</div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
				<button type="button" id="btn-crear-externo" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<!-- modal de confirmación de eliminación de intervención -->
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
<template id="t-resumen">
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p class="font-weight-bold">RESUMEN</p>
		<p class="mb-1"><i class="fas mr-3"></i>Ascaris</p>
		<p class="mb-2"><i class="fas mr-3"></i>Uncinarias</p>
		<p class="mb-1 ml-4"><i class="fas mr-3"></i>Ancylostoma</p>
		<p class="mb-2 ml-4"><i class="fas mr-3"></i>Necator</p>
		<p class="mb-1"><i class="fas mr-3"></i>Strongyloides</p>
		<p class="mb-1"><i class="fas mr-3"></i>Trichuris</p>
	</div>
</template>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script src="/iiet/assets/js/Forms.js"></script>
<script src="/iiet/assets/js/FormPaciente.js"></script>
<script src="/iiet/assets/js/FormBuscPaciente.js"></script>
<script src="/iiet/assets/js/config-historia-paciente.js" type="module"></script>
</html>