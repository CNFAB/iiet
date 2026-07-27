<!DOCTYPE html>

<html lang="es">
<head>
	<title>Consultas</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/datatables.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/consultas_campanias.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

	<style type="text/css">
		#contenedor > .row > div {
			height: 90%;
		}

		.link {
			height: 100%;
			color: var(--text-color);
			font-size: 3rem;

			transition: all .3s ease-in-out;
		}

		.link:hover {
			color: var(--text-color);
			transition: all .3s ease-in-out;
		}

		.link > div {
			background-repeat: no-repeat;
			background-position: center;
			background-size: 50%;
			background-image: url('/iiet/assets/images/ic_busqueda_bd.svg');

			transition: all .3s ease-in-out;
		}

		#contenedor > div > :nth-child(1) > a {
			background-color: #c16766;
		}

		#contenedor > div > :nth-child(1):hover > a {
			background-color: #bf5453;
		}

		#contenedor > div > :nth-child(2) > a {
			background-color: #4fada2;
		}

		#contenedor > div > :nth-child(2):hover > a {
			background-color: #199082;
		}

		#contenedor > div > :nth-child(3) > a {
			background-color: #9774a0;
		}

		#contenedor > div > :nth-child(3):hover > a {
			background-color: #8c5b99;
		}

		#contenedor > div > div > a:hover > div {
			background-size: 55%;
			transition: all .3s ease-in-out;
		}
	</style>
</head>
<body>
<header class="mb-3">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
			<h2 class="col-6">Consultas</h2>
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="links" class="navbar-collapse collapse justify-content-end">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link active" href="#">Inicio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/iiet/consultas/campanias">Campa&ntilde;as</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/iiet/consultas/consult_ext">Consultorio Externo</a>
					</li>
					<li class="nav-item mr-3">
						<a class="nav-link" href="/iiet/consultas/pacientes">Pacientes</a>
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
											<a href="/iiet/inicio/operario" class="conmutador btn" title="Cambiar al panel del Operario">Operario</a>
										<?php endif; ?>
										<?php if(isset($consultor)): ?>
											<button type="button" class="conmutador btn disabled">Consultor</button>
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
<section id="contenedor" class="container-fluid pr-md-5 pl-md-5">
	<div class="row justify-content-center h-100 align-items-center">
		<div class="col-12 col-md-4 mb-3 mb-md-0">
			<a href="/iiet/consultas/campanias" class="link h-100 d-flex flex-column justify-content-center align-items-center p-5">
				<p class="text-center">Consultas por Campa&ntilde;as</p>
				<div class="h-25 h-md-50 w-50 w-md-100"></div>
			</a>
		</div>
		<div class="col-12 col-md-4 mb-3 mb-md-0">
			<a href="/iiet/consultas/consult_ext" class="link h-100 d-flex flex-column justify-content-center align-items-center p-5">
				<p class="text-center">Consultas por Consultorio Externo</p>
				<div class="h-25 h-md-50 w-50 w-md-100"></div>
			</a>
		</div>
		<div class="col-12 col-md-4 mb-3 mb-md-0">
			<a href="/iiet/consultas/pacientes" class="link h-100 d-flex flex-column justify-content-center align-items-center p-5">
				<p class="text-center">Consultas por Pacientes</p>
				<div class="h-25 h-md-50 w-50 w-md-100"></div>
			</a>
		</div>
	</div>
</section>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/datatables.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script src="/iiet/assets/js/Forms.js"></script>
<script src="/iiet/assets/js/consultas_pacientes.js"></script>
<script>
$('#contenedor').height(window.innerHeight - $('#contenedor').offset().top);
</script>
</html>