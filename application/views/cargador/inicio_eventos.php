<!DOCTYPE html>

<html lang="es">
<head>
	<title>Eventos</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/modal-form.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/intervenciones2.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

	<style type="text/css">
		.link {
			width: 100%;
			height: 100%;

			background-repeat: no-repeat;
			background-position: center;
			background-size: 75%;

			transition: all .3s ease-in-out;
		}

		.link:hover {
			background-size: 85%;

			transition: all .3s ease-in-out;
		}

		#copro{
			background-image: url('/iiet/assets/images/ic_microscopio.svg');
			background-color: #cc7731;
		}

		#sangre{
			background-image: url('/iiet/assets/images/ic_sangre.svg');
		}

		#biologmolec{
			background-image: url('/iiet/assets/images/ic_adn.svg');
		}

		#tratamiento{
			background-image: url('/iiet/assets/images/ic_pastillas.svg');
		}
	</style>
</head>
<body>

<header class="mb-4">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
				<h2 class="col-6 mb-0">Eventos</h2>
				<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="links" class="col-6 navbar-collapse collapse justify-content-end">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="/iiet/inicio/operario"><span class="fa fa-arrow-circle-left mr-1"></span> Volver a Inicio</a>
						</li>
					</ul>
				</div>
		</div>
	</div>
</header>
<section id="contenedor" class="container-fluid pr-5 pl-5">
	<div class="row justify-content-center h-100 align-items-center">
		<div class="col-3 h-75">
			<a href="/iiet/eventos/copro" id="copro" class="link btn" title="Coproparasitológico"></a>
		</div>
		<div class="col-3 h-75">
			<a href="/iiet/eventos/sangre" id="sangre" class="link btn btn-danger" title="Sangre"></a>
		</div>
		<div class="col-3 h-75">
			<a href="/iiet/eventos/biologia_molecular" id="biologmolec" class="link btn btn-success" title="Biología Molecular"></a>
		</div>
		<div class="col-3 h-75">
			<a href="/iiet/eventos/tratamiento" id="tratamiento" class="link btn btn-primary" title="Tratamiento"></a>
		</div>
	</div>
</section>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script>

$('#contenedor').height(window.innerHeight - $('#contenedor').offset().top);

</script>
</html>