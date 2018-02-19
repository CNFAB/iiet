<!DOCTYPE html>

<html>
<head>
	<title>IIET</title>
	<meta charset="utf-8"/>

	<link rel="stylesheet" href="/iiet/assets/css/reset.css" />
	<link rel="stylesheet" href="/iiet/assets/css/variables.css" />
	<link rel="stylesheet" href="/iiet/assets/css/general.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/inicio.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/t_form_asinc.css"/>

	<script src="/iiet/assets/js/Utils.js"></script>
	<link rel="import" href="/iiet/assets/web-components/ventana-modal.html" />
	<link rel="import" href="/iiet/assets/web-components/form-asinc.html" />
	<link rel="import" href="/iiet/assets/web-components/templates/t_form-asinc.html" />
</head>
<body>
	<header id="cabecera_principal">
		<h2>IIET</h2>
		<div>
			<span>Instituto de Investigaci&oacute;n de</span>
			<span>Enfermedades Tropicales</span>
		</div>
		<h1>Inicio</h1>
	</header>
	<section id="contenido_principal">
		<div>
			<a href="#form_campania"><span>Nueva Campa&ntilde;a</span></a>
			<a href="/iiet/estudios/campania"><span>Cargar Campa&ntilde;a</span></a>
			<a href="/iiet/estudios/externo"><span>Cargar Consultorio Externo</span></a>
		</div>
		<div>
			<a href="#form_paciente"><span>Cargar Pacientes</span></a>
			<a href="/iiet/entidades"><span>Divisiones Pol&iacute;ticas</span></a>
			<a href="/iiet/consultas"><span>Consultas</span></a>
		</div>
	</section>
	<aside id="contenedor_vm"></aside>
	<div id="estado_guardar">
		<span></span>
		<span></span>
	</div>
</body>
<script src="/iiet/assets/js/resp_form_asinc.js"></script>
<script>
	
var contenidoPrincipal = document.getElementById('contenido_principal'),
	contenedorVM 	   = document.getElementById('contenedor_vm');

contenidoPrincipal.style.height = (window.innerHeight - Utils.getTop(contenidoPrincipal)) + 'px';

var fCampania = formNuevaCampania(contenedorVM),
	fPaciente = formNuevoPaciente(contenedorVM);

fCampania.fcExito = respFormCampania;
fPaciente.fcExito = respFormPacienteVarios;

</script>
</html>