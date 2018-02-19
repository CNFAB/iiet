<!DOCTYPE html>

<html lang="es">

<head>
	<title>Consultorio Externo</title>
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
		<h1>Consultorio Externo</h1>
	</header>
	<section id="listado_estudios">
		<a href="/iiet/estudios/externo/copro" title="Copro"></a>
		<a href="/iiet/estudios/externo/sangre" title="Sangre"></a>
		<a href="/iiet/estudios/externo/biologmolec" title="Biología Molecular"></a>
		<a href="/iiet/estudios/externo/tratamiento" title="Tratamientos"></a>
	</section>
</body>
<script src="/iiet/assets/js/Utils.js"></script>
<script>
	
var listadoEstudios = document.getElementById('listado_estudios');

listadoEstudios.style.height = (window.innerHeight - Utils.getTop(listadoEstudios)) + 'px';

</script>
</html>