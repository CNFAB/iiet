<!DOCTYPE html>

<html lang="es">
<head>
	<title>GeohelmintSoft</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>

	<style>
		.link {
			height: 100%;
			color: var(--text-color);
			font-size: 2rem;

			transition: all .3s ease-in-out;
		}

		.link:hover {
			color: var(--text-color);
			transition: all .3s ease-in-out;
		}

		.link > div {
			background-repeat: no-repeat;
			background-position: center;
			background-size: 30%;

			transition: all .3s ease-in-out;

			height: 80%;
		}

		#contenido > div > div > a:hover > div {
			background-size: 38%;
			transition: all .3s ease-in-out;
		}

		#contenido > div > :nth-child(1) > a {
			background-color: #c16766;
		}

		#contenido > div > :nth-child(1) > a > div {
			background-image: url('/iiet/assets/images/ic_pacientes.svg');
		}

		#contenido > div > :nth-child(1):hover > a {
			background-color: #bf5453;
		}

		#contenido > div > :nth-child(2) > a {
			background-color: #4fada2;
		}

		#contenido > div > :nth-child(2) > a > div {
			background-image: url('/iiet/assets/images/ic_casa.svg');
		}

		#contenido > div > :nth-child(2):hover > a {
			background-color: #199082;
		}

		#contenido > div > :nth-child(3) > a {
			background-color: #9774a0;
		}

		#contenido > div > :nth-child(3) > a > div {
			background-image: url('/iiet/assets/images/ic_carpeta.svg');
		}

		#contenido > div > :nth-child(3):hover > a {
			background-color: #8c5b99;
		}

		#contenido > div > :nth-child(4) > a {
			background-color: #e7b66b;;
		}

		#contenido > div > :nth-child(4) > a > div {
			background-image: url('/iiet/assets/images/ic_divinst.svg');
		}

		#contenido > div > :nth-child(4):hover > a {
			background-color: #cf9b4b;;
		}

	</style>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>
</head>
<body>
<header class="mb-3">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
			<h2 class="col-6">GeohelmintSoft</h2>
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="links" class="navbar-collapse collapse justify-content-end">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link active" href="#">Inicio</a>
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
<section id="contenido" class="container-fluid">
	<div class="row justify-content-center h-75 align-items-center">
		<div class="col-12 col-md-6 h-75 mb-4">
			<a href="/iiet/pacientes" class="link h-100 d-flex flex-column justify-content-center align-items-center p-3">
				<p class="text-center">Pacientes</p>
				<div class="w-100"></div>
			</a>
		</div>
		<div class="col-12 col-md-6 h-75 mb-4">
			<a href="/iiet/campanias" class="link h-100 d-flex flex-column justify-content-center align-items-center p-3">
				<p class="text-center">Campa&ntilde;as</p>
				<div class="w-100"></div>
			</a>
		</div>
		<div class="col-12 col-md-6 h-75 mb-4">
			<a href="/iiet/eventos" class="link h-100 d-flex flex-column justify-content-center align-items-center p-3">
				<p class="text-center">Eventos</p>
				<div class="w-100"></div>
			</a>
		</div>
		<div class="col-12 col-md-6 h-75 mb-4">
			<a href="/iiet/entidades" class="link h-100 d-flex flex-column justify-content-center align-items-center p-3">
				<p class="text-center">Divisiones Pol&iacute;ticas e Instituciones</p>
				<div class="w-100"></div>
			</a>
		</div>
	</div>
</section>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script>

window.addEventListener('load', function(e) {
	contenido.style.height = (window.innerHeight - contenido.getBoundingClientRect()["top"]) + 'px';
});

window.addEventListener('resize', function(e) {
	contenido.style.height = (window.innerHeight - contenido.getBoundingClientRect()["top"]) + 'px';
});

</script>
</html>