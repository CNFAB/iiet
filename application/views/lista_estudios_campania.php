<!DOCTYPE html>

<html lang="es">

<head>
	<title>Campa&ntilde;a</title>
	<meta charset="utf-8"/>

	<link rel="stylesheet" href="/iiet/assets/css/reset.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/general.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/menu_estudios.css"/>
</head>
<body>
	<header id="cabecera_principal">
		<h2>IIET</h2>
		<div>
			<span>Instituto de Investigaci&oacute;n de</span>
			<span>Enfermedades Tropicales</span>
		</div>
		<h1>Campa&ntilde;a</h1>
	</header>
	<section id="listado_estudios">
		<a href="/iiet/estudios/campania/copro" title="Copro"></a>
		<a href="/iiet/estudios/campania/sangre" title="Sangre"></a>
		<a href="/iiet/estudios/campania/biologmolec" title="Biología Molecular"></a>
		<a href="/iiet/estudios/campania/tratamiento" title="Tratamientos"></a>
	</section>
</body>
<script src="/iiet/assets/js/Utils.js"></script>
<script>
	
var listadoEstudios = document.getElementById('listado_estudios');

listadoEstudios.style.height = (window.innerHeight - Utils.getTop(listadoEstudios)) + 'px';

</script>
</html>