<!DOCTYPE html>

<html lang="es">
<head>
	<title>Pacientes</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/datatables.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/mdb.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/forms.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tablas.css"/>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>
</head>
<body>
<header class="mb-5">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
			<h2 class="col-6 mb-0">Pacientes</h2>
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="links" class="navbar-collapse collapse justify-content-end">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="/iiet">Inicio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="#">Pacientes</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/iiet/campanias">Campa&ntilde;as</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/iiet/eventos">Eventos</a>
					</li>
					<li class="nav-item mr-3">
						<a class="nav-link" href="/iiet/entidades">Div. Politicas</a>
					</li>
					<li class="nav-item ml-5">
						<div id="perfil-usuario" class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-user-circle fa-lg"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right p-4">
								<h4 class="mb-3"><?= $usuario ?></h4>
								<div class="mb-4 text-center">
									<p class="mb-2 text-left">Rol:</p>
									<?php if($cant_rol === 1): ?>
										<p class="ml-4 text-left"><?= $rol ?></p>
									<?php else: ?>
									<div class="btn-group btn-group-sm">
										<?php if(isset($admin)): ?>
											<a href="/iiet/inicio/admin" class="conmutador btn" title="Cambiar al panel del Administrador">Admin</a>
										<?php endif; ?>
										<?php if(isset($operario)): ?>
											<button type="button" class="conmutador btn disabled">Operario</button>
										<?php endif; ?>
										<?php if(isset($consultor)): ?>
											<a href="/iiet/inicio/consultor" class="conmutador btn" title="Cambiar al panel del Consultor">Consultor</a>
										<?php endif; ?>
									</div>
									<?php endif; ?>
								</div>
								<a href="/iiet/usuarios/perfil">Ver perfil</a>
								<div class="text-center">
									<a href="/iiet/usuarios/logout" class="btn fa fa-power-off cerrar-sesion" title="Salir"></a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>
<section class="container-fluid pr-5 pb-5 pl-5">
	<div class="row">
		<div id="alertas" class="col-12"></div>
	</div>
	<table id="tabla-pacientes" class="table">
		<thead>
			<tr>
				<th>N°</th>
				<th>DNI</th>
				<th>Apellido</th>
				<th>Nombre</th>
				<th>Sexo</th>
				<th data-orderable="false">Fecha Nacimiento</th>
				<th data-orderable="false">Acciones</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</section>
<div id="form-paciente" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Nuevo Pacientexd</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
	<div class="modal-body pr-4 pl-4">
		<form name="fPaciente" id="f-nuevo-pac" class="needs-validation" action="#" data-modo="nuevo" novalidate>
			<input type="hidden" name="numero" disabled />

			<div class="row">
				<!-- COLUMNA IZQUIERDA: Datos personales -->
				<div class="col-md-6">
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
							<input type="number" name="nro_cuaderno" min="1" id="fn-nro-cuaderno" class="form-control input-requerido" autocomplete="off" />
						</div>
					</div>
					<div class="form-row justify-content-between">
						<div class="form-group col-6">
							<label for="fn-apellido">Apellido</label>
							<input type="text" name="apellido" id="fn-apellido" class="form-control input-requerido" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								El Apellido es obligatorio
							</div>
						</div>
						<div class="form-group col-6">
							<label for="fn-nombre">Nombre</label>
							<input type="text" name="nombre" id="fn-nombre" class="form-control input-requerido" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								El Nombre es obligatorio
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-12">
							<label for="fn-fecha-nac">Fecha Nacimiento</label>
							<input type="date" name="fecha_nacimiento" id="fn-fecha-nac" class="form-control input-requerido" autocomplete="off" required />
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
				</div>

				<!-- COLUMNA DERECHA: Domicilio + Mapa -->
				<div class="col-md-6">
					<fieldset class="form-group">
						<legend class="col-form-legend">Domicilio</legend>
						<div class="form-row">
							<div class="form-group col-6">
								<label for="fn-dpto">Departamento</label>
								<select name="departamento" class="custom-select custom-select input-requerido" id="fn-dpto" required></select>
								<div class="invalid-feedback msj-invalido">
									El Departamento es obligatorio
								</div>
							</div>
							<div class="form-group col-6">
								<label for="fn-localidad">Localidad</label>
								<select name="localidad" class="custom-select custom-select input-requerido" id="fn-localidad" required></select>
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
									<select name="barrio" class="custom-select custom-select input-requerido" required></select>
									<div class="invalid-feedback msj-invalido">
										El Barrio es obligatorio
									</div>
								</div>
								<div id="grupo-paraje" class="d-none">
									<select name="paraje" class="custom-select custom-select input-requerido" required disabled></select>
									<div class="invalid-feedback msj-invalido">
										El Paraje es obligatorio
									</div>
								</div>
							</div>
							<div id="grupo-puesto" class="form-group col-6 d-none">
								<label for="fn-puesto">Puesto</label>
								<select name="puesto" class="custom-select custom-select input-requerido" id="fn-puesto" required disabled></select>
								<div class="invalid-feedback msj-invalido">
									El Puesto es obligatorio
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-12">
								<label for="fn-direc">Direcci&oacute;n</label>
								<input type="text" name="domicilio" class="form-control input-requerido" id="fn-direc" />
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-12">
								<label>Ubicaci&oacute;n en el mapa</label>
								<small class="form-text text-muted mb-2 d-block">
									Se ubica autom&aacute;ticamente al completar Departamento, Localidad y Direcci&oacute;n.
									Puede arrastrar el marcador para ajustar la posici&oacute;n exacta.
								</small>
								<div id="mapa-paciente" style="height: 220px; border-radius: 4px;"></div>
								<input type="hidden" name="latitud" id="fn-lat" />
								<input type="hidden" name="longitud" id="fn-lng" />
							</div>
						</div>
					</fieldset>
				</div>
			</div>

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
<div id="elim-paciente" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Eliminar Paciente</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div id="con_eventos">
					<p>El paciente <span class="text-paciente font-weight-bold text-info"></span> tiene intervenciones realizadas.</p>
					<p>¿Desea eliminarlo de todos modos?</p>
				</div>
				<div id="sin_eventos" class="d-none">
					<p>¿Est&aacute; seguro que quiere eliminar al paciente</p>
					<p><span class="text-paciente font-weight-bold text-info"></span> ?</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>
				<button type="button" id="elim-paciente-confirm" class="btn btn-outline-primary">S&iacute;</button>
			</div>
		</div>
	</div>
</div>
<a href="#form-paciente" class="btn btn-outline-info btn-circle fa fa-user-plus" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-form-modo="nuevo" title="Nuevo Paciente"></a>

</body>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="/iiet/assets/js/mapa-paciente.js" type="module"></script>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/datatables.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script src="/iiet/assets/js/check_validity_form.js"></script>
<script src="/iiet/assets/js/config-view-pacientes.js" type="module"></script>
</html>