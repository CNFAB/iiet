<!DOCTYPE html>

<html lang="es">
<head>
	<title>Campa&ntilde;as</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/datatables.min.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/forms.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tablas.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

	<style type="text/css">
		select {
			height: auto !important;
		}
	</style>
</head>
<body>

<header class="mb-5">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
			<h2 class="col-6 mb-0">Campa&ntilde;as</h2>
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="links" class="navbar-collapse collapse justify-content-end">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="/iiet">Inicio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/iiet/pacientes">Pacientes</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="#">Campa&ntilde;as</a>
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
	<table id="tabla-campanias" class="table">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Basal / Control</th>
				<th>Tipo</th>
				<th data-orderable="false">Lugar</th>
				<th>Localidad</th>
				<th data-orderable="false">Acciones</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</section>
<div id="form-campania" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Nueva Campa&ntilde;a</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body pr-4 pl-4">
				<form name="fCampania" id="f-nueva-camp" class="needs-validation" action="#" novalidate>
					<input type="hidden" name="numero" disabled />
					<div class="form-row justify-content-between">
						<div class="form-group col-6">
							<label for="fn-nombre">Nombre</label>
							<input type="text" name="nombre" id="fn-nombre" class="form-control input-requerido" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								El Nombre es obligatorio
							</div>
						</div>
						<div class="form-group col-6">
							<label for="fn-basal">Basal</label>
							<select name="basal_control" class="custom-select custom-select input-requerido" id="fn-basal" required>
								<option>Basal 1</option>
								<option>Control 1</option>
								<option>Control 2</option>
								<option>Control 3</option>
								<option>Basal 2</option>
							</select>
							<div class="invalid-feedback msj-invalido">
								El Basal es obligatorio
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-6">
							<label for="fn-fecha-ini">Fecha de Inicio</label>
							<input type="date" name="fecha_inicio" id="fn-fecha-ini" class="form-control input-requerido" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								La Fecha de Inicio es obligatoria y no debe ser posterior a la fecha actual
							</div>
						</div>
						<div class="form-group col-6">
							<label for="fn-fecha-fin">Fecha de Finalizaci&oacute;n</label>
							<input type="date" name="fecha_fin" id="fn-fecha-fin" class="form-control input-requerido" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								La Fecha de Finalizaci&oacute;n es obligatoria y no debe ser posterior a la fecha actual
							</div>
						</div>
					</div>
					<fieldset class="form-group">
						<legend class="col-form-legend">Lugar</legend>
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
							<div class="form-group col-6">
								<div class="custom-control custom-checkbox custom-control-inline">
									<input type="checkbox" name="check-institucion" value="si" class="custom-control-input" id="check-institucion" />
									<label for="check-institucion" class="custom-control-label">Instituci&oacute;n</label>
								</div>
								<div class="grupo-institucion d-none">
									<select name="institucion" class="custom-select custom-select input-requerido" required disabled></select>
									<div class="invalid-feedback msj-invalido">
										La instituci&oacute;n es obligatoria
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<div class="form-row">
						<div id="alert-camp-error" class="col-12">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<input type="reset" form="f-nueva-camp" value="Cancelar" class="btn btn-outline-danger" data-dismiss="modal" />
				<input type="submit" name="enviar" form="f-nueva-camp" value="Crear" class="btn btn-outline-primary" />
			</div>
		</div>
	</div>
</div>
<div id="elim-campania" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Eliminar Campaña</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div id="con_eventos">
					<p>La campa&ntilde;a <span class="text-campania font-weight-bold text-info"></span> tiene intervenciones asociadas.</p>
					<p>¿Desea eliminarla de todos modos?</p>
				</div>
				<div id="sin_eventos" class="d-none">
					<p>¿Est&aacute; seguro que quiere eliminar la campa&ntilde;a</p>
					<p><span class="text-campania font-weight-bold text-info"></span> ?</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>
				<button type="button" id="elim-campania-confirm" class="btn btn-outline-primary">S&iacute;</button>
			</div>
		</div>
	</div>
</div>
<div id="modal-pacientes" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Pacientes Intervenidos</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<table id="tabla-pacientes-interv" class="table">
					<thead>
						<tr>
							<th>N°</th>
							<th>DNI</th>
							<th>Apellido</th>
							<th>Nombre</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-primary" data-toggle="close" data-dismiss="modal">Aceptar</button>
			</div>
		</div>
	</div>
</div>

<a href="#form-campania" class="btn btn-outline-info btn-circle fa fa-plus" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-form-modo="nueva" title="Nueva campaña" ></a>

</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/datatables.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script src="/iiet/assets/js/check_validity_form.js"></script>
<script src="/iiet/assets/js/Forms.js"></script>
<script src="/iiet/assets/js/config-view-campanias.js" type="module"></script>
</html>