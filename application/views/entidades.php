<!DOCTYPE html>

<html>

<head>
	<title>Departamentos</title>
	<meta charset="utf-8"/>

	<link rel="stylesheet" href="/iiet/assets/css/reset.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/general.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/variables.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/listado_divpolit.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/t_form_asinc.css"/>

	<link rel="import" href="/iiet/assets/web-components/form-asinc.html"/>
	<link rel="import" href="/iiet/assets/web-components/ventana-modal.html"/>

	<script src="/iiet/assets/js/Utils.js"></script>
	<link rel="import" href="/iiet/assets/web-components/templates/t_entidades.html"/>
	<link rel="import" href="/iiet/assets/web-components/templates/t_form-asinc.html"/>
</head>
<body>
	<header id="cabecera_principal">
		<h2>IIET</h2>
		<div>
			<span>Instituto de Investigaci&oacute;n de</span>
			<span>Enfermedades Tropicales</span>
		</div>
		<h1>Entidades</h1>
	</header>
	<ul id="nav">
	</ul>
	<div id="main">
		<section id="escuelas" class="entidad">
			<header>
				<h1>Escuelas</h1>
			</header>
			<article>
				<ul id="lista_escuelas" class="lista_entidades"></ul>
				<div class="cont_nueva_entidad">
					<a href="#form_escuela" id="nueva_escuela" class="btn nueva_entidad">Nueva Escuela</a>
				</div>
			</article>
		</section>
		<section id="puestos" class="entidad">
			<header>
				<h1>Puestos</h1>
			</header>
			<article>
				<ul id="lista_puestos" class="lista_entidades"></ul>
				<div class="cont_nueva_entidad">
					<a href="#form_puesto" id="nuevo_puesto" class="btn nueva_entidad">Nuevo Puesto</a>
				</div>
			</article>
		</section>
		<section id="parajes" class="entidad">
			<header>
				<h1>Parajes</h1>
			</header>
			<article>
				<ul id="lista_parajes" class="lista_entidades"></ul>
				<div class="cont_nueva_entidad">
					<a href="#form_paraje" id="nuevo_paraje" class="btn nueva_entidad">Nuevo Paraje</a>
				</div>
			</article>
		</section>
		<section id="barrios" class="entidad">
			<header>
				<h1>Barrios</h1>
			</header>
			<article>
				<ul id="lista_barrios" class="lista_entidades"></ul>
				<div class="cont_nueva_entidad">
					<a href="#form_barrio" id="nuevo_barrio" class="btn nueva_entidad">Nuevo Barrio</a>
				</div>
			</article>
		</section>
		<section id="localidades" class="entidad">
			<header>
				<h1>Localidades</h1>
			</header>
			<article>
				<ul id="lista_localidades" class="lista_entidades"></ul>
				<div class="cont_nueva_entidad">
					<a href="#form_localidad" id="nueva_localidad" class="btn nueva_entidad">Nueva Localidad</a>
				</div>
			</article>
		</section>
		<section id="departamentos" class="entidad entidad_activa">
			<header>
				<h1>Departamentos</h1>
			</header>
			<article>
				<ul id="lista_departamentos" class="lista_entidades"></ul>
				<div class="cont_nueva_entidad">
					<a href="#form_dpto" id="nuevo_dpto" class="btn nueva_entidad">Nuevo Departamento</a>
				</div>
			</article>
		</section>
	</div>
	<aside id="v_modales"></aside>
	<div id="estado_guardar">
		<span></span>
		<span></span>
	</div>
</body>
<script src="/iiet/assets/js/resp_form_asinc.js"></script>
<script src="/iiet/assets/js/config_entidades.js"></script>

</html>