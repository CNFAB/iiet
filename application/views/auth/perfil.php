<!DOCTYPE html>

<html lang="es">
<head>
	<title>Perfil de Usuario</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/datatables.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/mdb.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/forms.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tablas.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

	<style type="text/css">

		.container > .contenido {
			height: calc(100vh - 10rem);
		}

		form label {
			font-weight: 400 !important;
		}

		.clave-valida,
		.clave-valida:focus {
			border-color: #357835 !important;
		}

		.clave-invalida,
		.clave-invalida:focus {
			border-color: #a33 !important;
		}

		.usuario-campo {
			font-weight: 400;
		}

	</style>
</head>
<body>

<header class="mb-5">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
			<h2 class="col-6 mb-0">Perfil de Usuario</h2>
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="links" class="col-6 navbar-collapse collapse justify-content-end">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="/iiet"><span class="fa fa-arrow-circle-left mr-1"></span> Volver a Inicio</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>
<section class="container pb-1">
	<div class="row justify-content-center contenido">
		<div class="col-6 bg-dark p-4">
			<div class="row justify-content-center">
				<div class="col-2">
					<p class="usuario-campo">Apellido:</p>
				</div>
				<div class="col-10">
					<p class="usuario-valor"></p>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-2">
					<p class="usuario-campo">Nombre:</p>
				</div>
				<div class="col-10">
					<p class="usuario-valor"></p>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-2">
					<p class="usuario-campo">E-mail:</p>
				</div>
				<div class="col-10">
					<p class="usuario-valor"></p>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-2">
					<p class="usuario-campo">Grupos:</p>
				</div>
				<div class="col-10">
					<p class="usuario-valor"></p>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-end">
		<button type="button" id="btn-cambiar-clave" class="btn btn-primary" title="Cambiar contraseña" data-target="#modal-cambio-clave" data-toggle="modal">
			<i class="fas fa-user-lock"></i>
		</button>
	</div>
	<div id="modal-cambio-clave" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content pr-2 pl-2">
				<div class="modal-header">
					<h4 class="mb-0 w-100 text-center">Cambio de Contrase&ntilde;a</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form id="form-cambio-clave" name="formCambioClave">
						<div class="form-group">
							<label for="clave-act" class="control-label">Contrase&ntilde;a actual</label>
							<input type="password" id="clave-act" name="old" class="form-control" required autofocus />
						</div>
						<div class="form-group">
							<label for="clave-nueva" class="control-label">Contrase&ntilde;a nueva</label>
							<input type="password" id="clave-nueva" name="new" class="form-control" required autofocus />
						</div>
						<div class="form-group">
							<label for="clave-nueva-2" class="control-label">Repita la nueva Contrase&ntilde;a</label>
							<input type="password" id="clave-nueva-2" name="new_confirm" class="form-control" required autofocus />
						</div>
					</form>
					<div id="alert-error"></div>
				</div>
				<div class="modal-footer">
					<input type="reset" name="limpiar" class="btn btn-outline-danger" data-dismiss="modal" value="Cancelar"/>
					<input type="submit" name="enviar" class="btn btn-outline-primary" value="Aceptar" form="form-cambio-clave"/>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-cambio-clave-exito" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content pr-2 pl-2">
				<div class="modal-header">
					<h4 class="mb-0 w-100 text-center">Cambio de Contrase&ntilde;a Exitoso</h4>
				</div>
				<div class="modal-body">
					<p>El sistema cerrar&aacute; su sesi&oacute;n actual, por favor inicie sesi&oacute;n con su nueva contrase&ntilde;a.</p>
				</div>
				<div class="modal-footer">
					<a href="/iiet/auth" class="btn btn-outline-primary">Entendido</a>
				</div>
			</div>
		</div>
	</div>
</section>
<template id="t-alert-error">
	<p class="alert alert-danger">Ha ocurrido un error, por favor verifique que los datos introducidos sean los correctos <button type="button" class="close" data-dismiss="alert">&times;</button></p>
</template>
<template id="t-alert-error-red">
	<p class="alert alert-danger">Ha ocurrido un error de <strong>red</strong>, por favor verifique su conexi&oacute;n <button type="button" class="close" data-dismiss="alert">&times;</button></p>
</template>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/datatables.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<!-- <script src="/iiet/assets/js/check_validity_form.js"></script> -->
<script>

var campos = document.getElementsByClassName('usuario-valor');

var tAlertError    = document.getElementById('t-alert-error').content,
	tAlertErrorRed = document.getElementById('t-alert-error-red').content,
	alertError     = document.getElementById('alert-error');

fetch('/iiet/usuarios/datos')
	.then(respuesta => {
		if(respuesta.ok) {
			respuesta.json().then(datos => {
				campos[0].textContent = datos.apellido;
				campos[1].textContent = datos.nombre;
				campos[2].textContent = datos.email;
				campos[3].textContent = datos.grupos.join(' - ');
			});
		}
	});

document.formCambioClave.addEventListener('submit', function(e) {
	e.preventDefault();

	var fd     = new FormData(document.formCambioClave),
		clave1 = document.formCambioClave.new.value,
		clave2 = document.formCambioClave['new_confirm'].value;

	if(clave1 !== clave2)
		return;

	fetch('/iiet/usuarios/cambiar_clave', {
		method: 'POST',
		body: fd
	})
	.then(respuesta => {
		if(respuesta.ok) {
			respuesta.json().then(estado => {
				if(estado) {
					$('#modal-cambio-clave').modal('hide');

					$('#modal-cambio-clave-exito').modal('show', {
						backdrop: 'static',
						keyboard: 'false'
					});
				}

				else
					alertError.appendChild(document.importNode(tAlertError, true));
			});
		}
	})
	.catch( e => alertError.appendChild(document.importNode(tAlertErrorRed, true)) );
});

document.formCambioClave['new_confirm'].addEventListener('input', function(e) {
	if(this.value === document.formCambioClave.new.value) {
		this.classList.remove('clave-invalida');
		this.classList.add('clave-valida');
	}

	else {
		this.classList.remove('clave-valida');
		this.classList.add('clave-invalida');
	}
});

$('#modal-cambio-clave').on('hide.bs.modal', function(e) {
	document.formCambioClave.reset();

	document.formCambioClave['new_confirm'].classList.remove('clave-invalida');
	document.formCambioClave['new_confirm'].classList.remove('clave-valida');

	alertError.innerHTML = '';
});

</script>
</html>