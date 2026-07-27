<!DOCTYPE html>

<html lang="es">
<head>
	<title>Usuarios</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/datatables.min.css"/>

	<!-- <script src="/iiet/assets/js/tools.js"></script>
	<script src="/iiet/assets/js/Utils.js"></script>
 -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

	<style type="text/css">
		.btn-group > .btn.inactivo {
			background-color: #dc354544 !important;
			border-color: #dc354522 !important;
			color: #6c757d;
		}

		.btn-group > .btn.activo {
			background-color: #28a74544;
			border-color: #28a74544;
			color: #6c757d;
		}

		.btn-group > .btn.inactivo.active {
			background-color: #dc3545 !important;
			border-color: #dc3545 !important;
			color: #fff;
		}

		.btn-group > .btn.activo.active {
			background-color: #28a745;
			border-color: #28a745;
			color: #fff;
		}
	</style>
</head>
<body>
<header class="mb-5">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
				<h2 class="col-6 text-light">Usuarios Registrados</h2>
				<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="links" class="navbar-collapse collapse justify-content-end">
					<ul class="navbar-nav">
						<!-- <li class="nav-item">
							<a class="nav-link" href="/iiet">Inicio</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/iiet/pacientes">Pacientes</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/iiet/campanias">Campa&ntilde;as</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/iiet/eventos">Eventos</a>
						</li>
						<li class="nav-item mr-3">
							<a class="nav-link" href="/iiet/entidades">Div. Politicas</a>
						</li> -->
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
												<button type="button" class="conmutador btn disabled">Admin</button>
											<?php endif; ?>
											<?php if(isset($operario)): ?>
												<a href="/iiet/inicio/operario" class="conmutador btn" title="Cambiar al panel del Operario">Operario</a>
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
<section class="container pb-5">
	<div class="row">
		<div id="alertas" class="col-12"></div>
	</div>
	<table id="usuarios" class="table table-responsive-sm">
		<thead>
			<tr>
				<th>Apellidos</th>
				<th>Nombres</th>
				<th>Email</th>
				<th data-orderable="false">Grupos</th>
				<th data-orderable="false">Estado</th>
				<th data-orderable="false">Acciones</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</section>

<a href="#modal-usuario" class="btn btn-outline-info btn-circle fas fa-user-plus" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-form-modo="nuevo"></a>

<div id="modal-usuario" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content pr-2 pl-2">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Nuevo Usuario</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form id="form-usuario" name="formUsuario">
					<input type="hidden" name="id" disabled />
					<div class="form-group">
						<label for="u_nombre" class="control-label">Nombres</label>
						<input type="text" id="u_nombre" name="first_name" class="form-control" required autocomplete="off" autofocus />
					</div>
					<div class="form-group">
						<label for="u_apellido" class="control-label">Apellidos</label>
						<input type="text" id="u_apellido" name="last_name" class="form-control" required autocomplete="off" />
					</div>
					<div class="form-group">
						<label for="u_email" class="control-label">Email</label>
						<input type="email" id="u_email" name="email" class="form-control" required autocomplete="off" />
					</div>
					<div id="password">
						<div class="form-group">
							<label for="u_clave" class="control-label">Contrase&ntilde;a</label>
							<input type="password" id="u_clave" name="password" class="form-control" required autocomplete="off" />
						</div>
						<div class="form-group">
							<label for="u_clave_conf" class="control-label">Confirme Contrase&ntilde;a</label>
							<input type="password" id="u_clave_conf" name="password_confirm" class="form-control" required autocomplete="off" />
						</div>
					</div>
					<fieldset id="grupos" class="form-group">
						<legend class="col-form-legend">Grupos</legend>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" name="groups[]" value="1" class="custom-control-input" id="g-admin" />
							<label for="g-admin" class="custom-control-label">ADMIN</label>
						</div>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" name="groups[]" value="2" class="custom-control-input" id="g-operario" />
							<label for="g-operario" class="custom-control-label">OPERARIO</label>
						</div>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" name="groups[]" value="3" class="custom-control-input" id="g-consultor" />
							<label for="g-consultor" class="custom-control-label">CONSULTOR</label>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<input type="reset" name="limpiar" class="btn btn-outline-danger" data-dismiss="modal" value="Cancelar"/>
				<input type="submit" name="enviar" class="btn btn-outline-primary" value="Crear" form="form-usuario"/>
			</div>
		</div>
	</div>
</div>

<div id="edit_usuario" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Editar Usuario</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form id="editar_usuario" is="form-asinc" action="/iiet/auth/create_user" method="POST">
					<div class="form-group">
						<label for="eu_nombre" class="control-label">Nombres</label>
						<input type="text" id="eu_nombre" name="first_name" class="form-control" required autocomplete="off" autofocus />
					</div>
					<div class="form-group">
						<label for="eu_apellido" class="control-label">Apellidos</label>
						<input type="text" id="eu_apellido" name="last_name" class="form-control" required autocomplete="off" />
					</div>
					<div class="form-group">
						<label for="eu_email" class="control-label">Email</label>
						<input type="email" id="eu_email" name="email" class="form-control" required autocomplete="off" />
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<input type="reset" name="limpiar" class="btn btn-outline-danger" data-dismiss="modal" value="Cancelar" form="editar_usuario"/>
				<input type="submit" name="enviar" class="btn btn-outline-primary" data-dismiss="modal" value="Actualizar" form="editar_usuario"/>
			</div>
		</div>
	</div>
</div>

<div id="elim_usuario" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Eliminar Usuario</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<p>¿Est&aacute; seguro que quiere eliminar el usuario?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-outline-primary" data-dismiss="modal">S&iacute;</button>
			</div>
		</div>
	</div>
</div>

<!-- <p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p> -->
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/datatables.min.js"></script>
<script src="/iiet/assets/js/dataTables.rowReorder.min.js"></script>
<script src="/iiet/assets/js/dataTables.responsive.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script>

var tablaUsuarios = $('#usuarios').DataTable({
	language: {
		sProcessing:     "Procesando...",
		sLengthMenu:     "Mostrar _MENU_ usuarios",
		sZeroRecords:    "No se encontraron resultados",
		sEmptyTable:     "Ningún dato disponible en esta tabla",
		sInfo:           "Mostrando usuarios del _START_ al _END_ de un total de _TOTAL_ usuarios",
		sInfoEmpty:      "Mostrando usuarios del 0 al 0 de un total de 0 usuarios",
		sInfoFiltered:   "(filtrado de un total de _MAX_ usuarios)",
		sInfoPostFix:    "",
		sSearch:         "Buscar:",
		sUrl:            "",
		sInfoThousands:  ",",
		sLoadingRecords: "Cargando...",
		oPaginate: {
			sFirst:    "Primero",
			sLast:     "Último",
			sNext:     "Siguiente",
			sPrevious: "Anterior"
		},
		oAria: {
			sSortAscending:  ": Activar para ordenar la columna de manera ascendente",
			sSortDescending: ": Activar para ordenar la columna de manera descendente"
		}
	},
	rowId: 'id',
	columns: [
		{ data: 'apellidos' },
		{ data: 'nombres' },
		{ data: 'email' },
		{ data: u => u.grupos.map( e => e.name.toUpperCase()).join(', ')  },
		{ data: u => generarEstado(u.estado) },
		{ data: u => crearBtnsAcciones(u.id) }
	],
	ajax: '/iiet/auth/usuarios'
});

function generarEstado(estado) {
	var contenedor = document.createElement('div'),
		grupoBtns = document.createElement('div'),
		boton1 = document.createElement('button'),
		boton2 = document.createElement('button');

	boton1.type = 'button';
	boton1.className = 'btn btn-success activo';
	boton1.textContent = 'ACTIVO';

	boton2.type = 'button';
	boton2.className = 'btn btn-danger inactivo';
	boton2.textContent = 'INACTIVO';

	grupoBtns.className = 'btn-group btn-group-sm';
	grupoBtns.appendChild(boton1);
	grupoBtns.appendChild(boton2);

	contenedor.appendChild(grupoBtns);

	if(estado == 1) {
		boton2.classList.remove('active');
		boton1.classList.add('active');
	}

	else {
		boton1.classList.remove('active');
		boton2.classList.add('active');
	}

	return contenedor.innerHTML;
}

function crearBtnsAcciones(id) {
	var btnEdit = document.createElement('a'),
		contenedor = document.createElement('div');

	btnEdit.href = '#modal-usuario';
	btnEdit.className = 'btn btn-outline-success fa fa-pencil-alt mr-1';
	btnEdit.title = 'Editar';
	btnEdit.dataset.toggle = 'modal';
	btnEdit.dataset.backdrop = 'static';
	btnEdit.dataset.keyboard = 'false';
	btnEdit.dataset.formModo = 'editar';

	contenedor.appendChild(btnEdit);

	return contenedor.innerHTML;
}

$('#usuarios tbody').on('click', '.btn-group button', function (e) {
	var padre = this.parentNode,
		fila = padre.parentNode.parentNode,
		datos = tablaUsuarios.row(fila).data(),
		otroBtn = null,
		operacion = '';

	if(this.classList.contains('activo')) {
		operacion = 'activate';
		otroBtn = padre.children[1];
	}

	else {
		operacion = 'deactivate';
		otroBtn = padre.children[0];
	}
	
	otroBtn.classList.remove('active');
	this.classList.add('active');

	$.ajax('/iiet/auth/' + operacion + '/' + datos.id, {
		dataType: 'json',
		success: resp => resp || deshacerOperacion(operacion, padre),
		error: () => deshacerOperacion(operacion, padre)
	});
});

function deshacerOperacion(operacion, contenedorBtns) {
	if(operacion == 'activate') {
		contenedorBtns.children[0].classList.remove('active');
		contenedorBtns.children[1].classList.add('active');
	}

	else {
		contenedorBtns.children[1].classList.remove('active');
		contenedorBtns.children[0].classList.add('active');
	}
}


var formUsuario = document.formUsuario;

$('#modal-usuario').on('show.bs.modal', function(e) {
	var formModo = e.relatedTarget.dataset.formModo;

	formUsuario.reset();

	if(formModo == 'nuevo')
		configFormNuevoUsuario();

	else {
		var fila = e.relatedTarget.parentNode.parentNode,
			datos = tablaUsuarios.row(fila).data();

		configFormEditarUsuario(datos);
	}
});

$('#modal-usuario').on('shown.bs.modal', function(e) {
	formUsuario.first_name.focus();
});

function configFormNuevoUsuario() {
	formUsuario.dataset.modo = 'nuevo';

	$('#modal-usuario .modal-header h4').text('Nuevo Usuario');

	formUsuario.id.disabled = 'disabled';
	formUsuario.password.disabled = null;
	formUsuario.password_confirm.disabled = null;

	$('#password').removeClass('d-none');
	$('#grupos').addClass('d-none');
	$('#grupos')[0].disabled = 'disabled';
}

function configFormEditarUsuario(datos) {
	formUsuario.dataset.modo = 'editar';

	$('#modal-usuario .modal-header h4').text('Editar Usuario');
	formUsuario.enviar.value = 'Actualizar';

	formUsuario.id.disabled = null;
	formUsuario.password.disabled = 'disabled';
	formUsuario.password_confirm.disabled = 'disabled';

	$('#password').addClass('d-none');
	$('#grupos').removeClass('d-none');
	$('#grupos')[0].disabled = null;

	
	formUsuario.id.value = datos.id;
	formUsuario.first_name.value = datos.nombres;
	formUsuario.last_name.value = datos.apellidos;
	formUsuario.email.value = datos.email;

	var cbxGrupos = formUsuario['groups[]'];

	for(let grupo of datos.grupos)
		switch(grupo.name) {
			case 'admin':
				cbxGrupos[0].checked = true;
			break;

			case 'operario':
				cbxGrupos[1].checked = true;
			break;

			case 'consultor':
				cbxGrupos[2].checked = true;
			break;
		}
}

formUsuario.addEventListener('submit', function(e) {
	e.preventDefault();

	var url = '/iiet/auth/' + (formUsuario.dataset.modo == 'nuevo' ? 'create_user' : 'edit_user');

	$.ajax(url, {
		dataType: 'json',
		method: 'POST',
		data: $(this).serialize(),
		success: formUsuarioExito
	});
});

function formUsuarioExito(estado) {
	console.log(estado);
	if(estado === false) {
		formUsuarioError();
		return;
	}

	tablaUsuarios.ajax.reload();

	var p = document.createElement('p'),
		span = document.createElement('span'),
		button = document.createElement('button');

	p.className = 'alert alert-success';
	p.appendChild(document.createTextNode('El usuario '));

	span.className = 'font-weight-bold';
	span.textContent = formUsuario.last_name.value + ', ' + formUsuario.first_name.value;
	p.appendChild(span);

	if(formUsuario.dataset.modo == 'nuevo')
		p.appendChild(document.createTextNode(' fue creado con éxito'));
	else
		p.appendChild(document.createTextNode(' fue actualizado con éxito'));

	button.type = 'button';
	button.className = 'close';
	button.dataset.dismiss = 'alert';
	button.textContent = '\xd7';
	p.appendChild(button);

	$('#alertas').append(p);

	$('#modal-usuario').modal('hide');
}

</script>
</html>