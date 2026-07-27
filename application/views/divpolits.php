<!DOCTYPE html>

<html lang="es">
<head>
	<title>Divisiones Pol&iacute;ticas e Instituciones</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/datatables.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/mdb.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

	<script src="https://openlayers.org/en/v4.6.5/build/ol.js"></script>

	<style type="text/css">
		.links {
			color: #5e88bf;
			font-weight: bold;
			background: none;
			border: none;
		}

		.links:hover {
			color: #5e88ff;
			text-decoration: none;
			cursor: pointer;
		}

		.links:active,
		.links:focus {
			border: none;
		}

		.btn-nuevo {
			position: fixed;
			right: 15px;
			bottom: 15px;
		}

		#contenedor-mapa {
			position: relative;
		}

		#txt-no-result-busq {
			position: absolute;
			bottom: 20px;
			left: 50%;

			transform: translateX(-50%);
		}

		.map {
			background-image: url('/iiet/assets/images/ic_no_ubicacion.svg');
			background-color: var(--iiet-gray);
			background-size: 30%;
			background-repeat: no-repeat;
			background-position: center;
		}

		.alert-exito {
			position: fixed;
			bottom: 20px;
			left: 20px;
		}

		#alerta-exito {
			position: fixed;
			right: 50%;
			left: 1.5rem;
			bottom: 1rem;
		}

		.card {
			background-color: #485357 !important;
		}

		article > header > form {
			margin-top: 1.5rem;
		}

		article > header > form > .form-group > label {
			font-weight: 400 !important;
			margin-right: 1rem;
		}

		article > header > form > .form-group > input {
			width: 25rem !important;
		}
	</style>
</head>
<body>

<header class="mb-3">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
				<h2 class="col-6 mb-0">Divisiones Pol&iacute;ticas e Instituciones</h2>
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
							<a class="nav-link" href="/iiet/campanias">Campa&ntilde;as</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/iiet/eventos">Eventos</a>
						</li>
						<li class="nav-item mr-3">
							<a class="nav-link active" href="#">Div. Politicas</a>
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
	<article id="departamentos">
		<header class="text-center mb-3" style="border: none;">
			<h3>Departamentos de la Provincia de Salta</h3>
			<form class="form-inline">
				<div class="form-group">
					<label>Buscar</label>
					<input type="text" name="buscar" class="form-control" />
				</div>
			</form>
		</header>
		<div class="lista"></div>
		<div class="divpolit_vacio row align-items-center d-none">
			<div class="col-12 text-center">
				<p>No se cargaron departamentos para esta provincia.</p>
			</div>
		</div>
		<button type="button" class="btn-nuevo btn btn-warning fa fa-plus" title="Nuevo departamento"></button>
		<template class="t_divpolit">
			<div class="card mb-3 bg-primary datos_divpolitinst">
				<div class="row h-100">
					<div class="col-4">
						<div class="row h-100">
							<div class="col-4">
								<h1 class="card-header h-100 text-center nro_divpolit"></h1>
							</div>
							<div class="col-8">
								<div class="card-body h-100 row nombre_divpolit">
									<h2 class="card-title col-12"></h2>
									<div class="col-12 text-right">
										<div>
											<button type="button" data-target="#form-divpolit" class="btn-editar btn btn-success fa fa-pencil-alt" data-divpolit="departamento" data-modo="actualizar" title="Editar"></button>
										</div>
										<div class="mt-2">
											<a href="#elim-divpolit" class="btn-eliminar btn btn-danger fa fa-trash-alt" data-toggle="modal" data-backdrop="static" data-keyboard="false" title="Eliminar"></a>
										</div>
									</div>
									<div class="w-100 align-self-end">
										<div class="w-100 text-left">
											<button type="button" class="links" data-pos="0">Ver Localidades</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="map w-100" data-zoom="7" style="height: 400px;"></div>
					</div>
				</div>
			</div>
		</template>
	</article>
	<article id="localidades" class="d-none">
		<header class="row mb-3" style="border: none;">
			<div class="col-1">
				<button type="button" class="atras btn btn-info fa fa-chevron-left"></button>
			</div>
			<div class="col-10 text-center">
				<h3>Localidades de <span></span></h3>
			</div>
			<form class="col form-inline">
				<div class="form-group">
					<label>Buscar</label>
					<input type="text" name="buscar" class="form-control" />
				</div>
			</form>
		</header>
		<div class="lista"></div>
		<div class="divpolit_vacio row align-items-center d-none">
			<div class="col-12 text-center">
				<p>No se cargaron localidades para este departamento.</p>
			</div>
		</div>
		<button type="button" class="btn-nuevo btn btn-warning fa fa-plus" title="Nueva localidad"></button>
		<template class="t_divpolit">
			<div class="card mb-3 bg-primary datos_divpolitinst">
				<div class="row h-100">
					<div class="col-4">
						<div class="row h-100">
							<div class="col-4">
								<h1 class="card-header h-100 text-center nro_divpolit"></h1>
							</div>
							<div class="col-8">
								<div class="card-body h-100 row nombre_divpolit">
									<h2 class="card-title col-12"></h2>
									<div class="col-12 text-right">
										<div>
											<button type="button" data-target="#form-divpolit" class="btn-editar btn btn-success fa fa-pencil-alt" data-divpolit="localidad" data-modo="actualizar" title="Editar"></button>
										</div>
										<div class="mt-2">
											<a href="#elim-divpolit" class="btn-eliminar btn btn-danger fa fa-trash-alt" data-toggle="modal" data-backdrop="static" data-keyboard="false" title="Eliminar"></a>
										</div>
									</div>
									<div class="col-12 align-self-end">
										<button type="button" class="links d-block" data-pos="0">Ver Barrios</button>
										<button type="button" class="links d-block" data-pos="1">Ver Parajes</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="map w-100" data-zoom="9" style="height: 400px;"></div>
					</div>
				</div>
			</div>
		</template>
	</article>
	<article id="barrios" class="d-none">
		<header class="row mb-3" style="border: none;">
			<div class="col-1">
				<button type="button" class="atras btn btn-info fa fa-chevron-left"></button>
			</div>
			<div class="col-10 text-center">
				<h3>Barrios de <span></span></h3>
			</div>
			<form class="col form-inline">
				<div class="form-group">
					<label>Buscar</label>
					<input type="text" name="buscar" class="form-control" />
				</div>
			</form>
		</header>
		<div class="lista"></div>
		<div class="divpolit_vacio row align-items-center d-none">
			<div class="col-12 text-center">
				<p>No se cargaron barrios para esta localidad.</p>
			</div>
		</div>
		<button type="button" class="btn-nuevo btn btn-warning fa fa-plus" title="Nuevo barrio"></button>
		<template class="t_divpolit">
			<div class="card mb-3 bg-primary datos_divpolitinst">
				<div class="row h-100">
					<div class="col-4">
						<div class="row h-100">
							<div class="col-4">
								<h1 class="card-header h-100 text-center nro_divpolit"></h1>
							</div>
							<div class="col-8">
								<div class="card-body h-100 row nombre_divpolit">
									<h2 class="card-title col-12"></h2>
									<div class="col-12 text-right">
										<div>
											<button type="button" data-target="#form-divpolit" class="btn-editar btn btn-success fa fa-pencil-alt" data-divpolit="barrio" data-modo="actualizar" title="Editar"></button>
										</div>
										<div class="mt-2">
											<a href="#elim-divpolit" class="btn-eliminar btn btn-danger fa fa-trash-alt" data-toggle="modal" data-backdrop="static" data-keyboard="false" title="Eliminar"></a>
										</div>
									</div>
									<div class="col-12 align-self-end">
										<button type="button" class="links d-block" data-pos="0">Ver Instituciones</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="map w-100" data-zoom="14" style="height: 400px;"></div>
					</div>
				</div>
			</div>
		</template>
	</article>
	<article id="parajes" class="d-none">
		<header class="row mb-3" style="border: none;">
			<div class="col-1">
				<button type="button" class="atras btn btn-info fa fa-chevron-left"></button>
			</div>
			<div class="col-10 text-center">
				<h3>Parajes de <span></span></h3>
			</div>
			<form class="col form-inline">
				<div class="form-group">
					<label>Buscar</label>
					<input type="text" name="buscar" class="form-control" />
				</div>
			</form>
		</header>
		<div class="lista"></div>
		<div class="divpolit_vacio row align-items-center d-none">
			<div class="col-12 text-center">
				<p>No se cargaron parajes para esta localidad.</p>
			</div>
		</div>
		<button type="button" class="btn-nuevo btn btn-warning fa fa-plus" title="Nuevo paraje"></button>
		<template class="t_divpolit">
			<div class="card mb-3 bg-primary datos_divpolitinst">
				<div class="row h-100">
					<div class="col-4">
						<div class="row h-100">
							<div class="col-4">
								<h1 class="card-header h-100 text-center nro_divpolit"></h1>
							</div>
							<div class="col-8">
								<div class="card-body h-100 row nombre_divpolit">
									<h2 class="card-title col-12"></h2>
									<div class="col-12 mb-3 text-right">
										<div>
											<button type="button" data-target="#form-divpolit" class="btn-editar btn btn-success fa fa-pencil-alt" data-divpolit="paraje" data-modo="actualizar" title="Editar"></button>
										</div>
										<div class="mt-2">
											<a href="#elim-divpolit" class="btn-eliminar btn btn-danger fa fa-trash-alt" data-toggle="modal" data-backdrop="static" data-keyboard="false" title="Eliminar"></a>
										</div>
									</div>
									<div class="col-12 align-self-end">
										<button type="button" class="links d-block" data-pos="0">Ver Puestos</button>
										<button type="button" class="links d-block" data-pos="1">Ver Instituciones</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="map w-100" data-zoom="14" style="height: 400px;"></div>
					</div>
				</div>
			</div>
		</template>
	</article>
	<article id="instit_barrios" class="d-none">
		<header class="row mb-3" style="border: none;">
			<div class="col-1">
				<button type="button" class="atras btn btn-info fa fa-chevron-left"></button>
			</div>
			<div class="col-10 text-center">
				<h3>Instituciones del barrio <span></span></h3>
			</div>
			<form class="col form-inline">
				<div class="form-group">
					<label>Buscar</label>
					<input type="text" name="buscar" class="form-control" />
				</div>
			</form>
		</header>
		<div id="lista_instituciones" class="lista"></div>
		<div class="divpolit_vacio row align-items-center d-none">
			<div class="col-12 text-center">
				<p>No se cargaron instituciones para este barrio.</p>
			</div>
		</div>
		<button type="button" class="btn-nuevo btn btn-warning fa fa-plus" title="Nueva institución"></button>
		<template class="t_divpolit">
			<div class="card mb-3 bg-primary datos_divpolitinst">
				<div class="row h-100">
					<div class="col-4">
						<div class="row h-100">
							<div class="col-4">
								<h1 class="card-header h-100 text-center nro_divpolit"></h1>
							</div>
							<div class="col-8">
								<div class="card-body h-100 row nombre_divpolit">
									<h2 class="card-title col-12"></h2>
									<div class="col-12 text-right">
										<div>
											<button type="button" data-target="#form-divpolit" class="btn-editar btn btn-success fa fa-pencil-alt" data-divpolit="institucion" data-modo="actualizar" title="Editar"></button>
										</div>
										<div class="mt-2">
											<a href="#elim-divpolit" class="btn-eliminar btn btn-danger fa fa-trash-alt" data-toggle="modal" data-backdrop="static" data-keyboard="false" title="Eliminar"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="map w-100" data-zoom="18" style="height: 400px;"></div>
					</div>
				</div>
			</div>
		</template>
	</article>
	<article id="instit_parajes" class="d-none">
		<header class="row mb-3" style="border: none;">
			<div class="col-1">
				<button type="button" class="atras btn btn-info fa fa-chevron-left"></button>
			</div>
			<div class="col-10 text-center">
				<h3>Instituciones del paraje <span></span></h3>
			</div>
			<form class="col form-inline">
				<div class="form-group">
					<label>Buscar</label>
					<input type="text" name="buscar" class="form-control" />
				</div>
			</form>
		</header>
		<div class="lista"></div>
		<div class="divpolit_vacio row align-items-center d-none">
			<div class="col-12 text-center">
				<p>No se cargaron instituciones para este paraje.</p>
			</div>
		</div>
		<button type="button" class="btn-nuevo btn btn-warning fa fa-plus" title="Nueva institución"></button>
		<template class="t_divpolit">
			<div class="card mb-3 bg-primary datos_divpolitinst">
				<div class="row h-100">
					<div class="col-4">
						<div class="row h-100">
							<div class="col-4">
								<h1 class="card-header h-100 text-center nro_divpolit"></h1>
							</div>
							<div class="col-8">
								<div class="card-body h-100 row nombre_divpolit">
									<h2 class="card-title col-12"></h2>
									<div class="col-12 text-right">
										<div>
											<button type="button" data-target="#form-divpolit" class="btn-editar btn btn-success fa fa-pencil-alt" data-divpolit="institucion" data-modo="actualizar" title="Editar"></button>
										</div>
										<div class="mt-2">
											<a href="#elim-divpolit" class="btn-eliminar btn btn-danger fa fa-trash-alt" data-toggle="modal" data-backdrop="static" data-keyboard="false" title="Eliminar"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="map w-100" data-zoom="18" style="height: 400px;"></div>
					</div>
				</div>
			</div>
		</template>
	</article>
	<article id="puestos" class="d-none">
		<header class="row mb-3" style="border: none;">
			<div class="col-1">
				<button type="button" class="atras btn btn-info fa fa-chevron-left"></button>
			</div>
			<div class="col-10 text-center">
				<h3>Puestos de <span></span></h3>
			</div>
			<form class="col form-inline">
				<div class="form-group">
					<label>Buscar</label>
					<input type="text" name="buscar" class="form-control" />
				</div>
			</form>
		</header>
		<div class="lista"></div>
		<div class="divpolit_vacio d-none">
			<p>No se cargaron puestos para este paraje.</p>
		</div>
		<button type="button" class="btn-nuevo btn btn-warning fa fa-plus" title="Nueva institución"></button>
		<template class="t_divpolit">
			<div class="card mb-3 bg-primary datos_divpolitinst">
				<div class="row h-100">
					<div class="col-4">
						<div class="row h-100">
							<div class="col-4">
								<h1 class="card-header h-100 text-center nro_divpolit"></h1>
							</div>
							<div class="col-8">
								<div class="card-body h-100 row nombre_divpolit">
									<h2 class="card-title col-12"></h2>
									<div class="col-12 text-right">
										<div>
											<button type="button" data-target="#form-divpolit" class="btn-editar btn btn-success fa fa-pencil-alt" data-divpolit="puesto" data-modo="actualizar" title="Editar"></button>
										</div>
										<div class="mt-2">
											<a href="#elim-divpolit" class="btn-eliminar btn btn-danger fa fa-trash-alt" data-toggle="modal" data-backdrop="static" data-keyboard="false" title="Eliminar"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="map w-100" data-zoom="16" style="height: 400px;"></div>
					</div>
				</div>
			</div>
		</template>
	</article>
</section>
<div id="alerta-exito"></div>
<div id="form-divpolit" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body pr-4 pl-4 pb-0">
				<form name="fDivPolit" id="f-divpolit" class="needs-validation" action="#" novalidate>
					<input type="hidden" name="numero" disabled />
					<input type="hidden" id="input-id-sup"/>
					<input type="hidden" name="latitud" />
					<input type="hidden" name="longitud" />
					<div class="form-row">
						<div class="form-group col-11">
							<label for="divp-nombre">Nombre</label>
							<input type="text" name="nombre" id="divp-nombre" class="form-control input-requerido" autocomplete="off" required />
							<div class="invalid-feedback msj-invalido">
								El Nombre es obligatorio
							</div>
						</div>
						<div class="col-1 align-self-end mb-3">
							<button type="button" class="btn btn-primary btn-buscar fa fa-search"></button>
						</div>
					</div>
					<div id="g-tipo-instit" class="form-row">
						<div class="form-group col-6">
							<label for="divp-tipo">Tipo</label>
							<select name="tipo" class="custom-select custom-select" id="divp-tipo" required>
								<option value="ESCUELA">ESCUELA</option>
								<option value="CENTRO SALUD">CENTRO DE SALUD</option>
								<option value="CARCEL">CARCEL</option>
								<option value="HOGAR">HOGAR</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-12">
							<label>Coordenadas</label>
							<div id="contenedor-mapa">
								<div id="form-mapa" class="w-100" style="height: 380px;"></div>
								<div id="txt-no-result-busq" class="bg-dark text-light pt-2 pb-2 pr-3 pl-3 d-none">No se encontraron resultados</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<input type="reset" form="f-divpolit" value="Cancelar" class="btn btn-outline-danger" data-dismiss="modal" />
				<input type="submit" name="enviar" form="f-divpolit" value="Crear" class="btn btn-outline-primary" />
			</div>
		</div>
	</div>
</div>
<div id="modal-eliminar" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Eliminar</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body pr-4 pl-4 pb-0">
				<p>¿Est&aacute; seguro que desea eliminar la divisi&oacute;n pol&iacute;tica <span class="nombre-divpolit font-weight-bold"></span>?</p>
				<div id="alerta-error"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-toggle="close" data-dismiss="modal">Cancelar</button>
				<button id="btn-eliminar-divpolit" type="button" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<template id="t-alerta-exito">
	<p class="alert alert-success alert-dismissible fade show">Se ha eliminado la divisi&oacute;n pol&iacute;tica <span class="nombre-divpolit"></span> <button type="button" class="close" data-dismiss="alert">&times;</button></p>
</template>
<template id="t-alerta-error">
	<p class="alert alert-danger alert-dismissible fade show">No puede eliminar la divisi&oacute;n pol&iacute;tica ya que hay otros elementos de dependen de este <button type="button" class="close" data-dismiss="alert">&times;</button></p>
</template>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/datatables.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script src="/iiet/assets/js/Mapa.js"></script>
<script src="/iiet/assets/js/config-view-divpolits.js"></script>
</html>