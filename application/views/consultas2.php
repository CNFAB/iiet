<!DOCTYPE html>

<html>

<head>
	<title>Consultas</title>
	<meta charset="utf-8"/>

	<script src="/iiet/assets/js/tools.js"></script>
	<link rel="import" href="/iiet/assets/web-components/table-scroll.html"/>
	<link rel="import" href="/iiet/assets/web-components/secc-consultas.html"/>

	<link rel="stylesheet" href="/iiet/assets/css/reset.css" />
	<link rel="stylesheet" href="/iiet/assets/css/general.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/consultas.css"/>
</head>
<body>
	<header id="cabecera_principal">
		<h2>IIET</h2>
		<div>
			<span>Instituto de Investigaci&oacute;n de</span>
			<span>Enfermedades Tropicales</span>
		</div>
		<h1>Consultas</h1>
	</header>
	<secc-consultas id="consulta"></secc-consultas>
</body>
<script src="/iiet/assets/js/Utils.js"></script>
<script>

var consultaCampania = document.getElementById('consulta');

var top = Utils.getTop(consultaCampania);

consultaCampania.style.height = (window.innerHeight - Utils.getTop(consultaCampania)) + 'px';

var obj = [
	{
		texto: 'Fecha de inicio',
		accion: () => {
			consultaCampania.nuevaCondicionFecha('Fecha de inicio', 'fecha_inicio');
		}
	},
	{
		texto: 'Fecha de fin',
		accion: () => {
			consultaCampania.nuevaCondicionFecha('Fecha de fin', 'fecha_fin');
		}
	},
	{
		texto: 'Tipo campaña',
		accion: () => {
			consultaCampania.nuevaCondicionTipoCampania();
		}
	},
	{
		texto: 'Lugar',
		accion: () => {
			consultaCampania.nuevaCondicionTexto('Lugar', 'lugar');
		}
	}
];

consultaCampania.crearMenuNuevaCondicion(obj);
consultaCampania.establecerCabeceraTablaResultados(['Nombre', 'Fecha de Inicio', 'Fecha de Fin', 'Tipo', 'Lugar', 'Basal']);
consultaCampania.listaCondiciones.tabla = 'v_campanias';
consultaCampania.accionRespuestaConsulta = e => {
	var respuesta = e.target.response;

	consultaCampania.tablaResultados.clearBody();

	for(let datos of respuesta) {
		let fila = consultaCampania.tablaResultados.insertRow();

		fila.insertCell().insertTextContent(datos.nombre);
		fila.insertCell().insertTextContent(datos.fecha_inicio);
		fila.insertCell().insertTextContent(datos.fecha_fin);
		fila.insertCell().insertTextContent(datos.tipo);
		fila.insertCell().insertTextContent(datos.lugar);
		fila.insertCell().insertTextContent(datos.basal_control);
	}

	consultaCampania.tablaResultados.normalize();
};

</script>

</html>