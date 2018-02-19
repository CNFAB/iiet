<!DOCTYPE html>

<html>
<head>
	<title>Consultas</title>

	<script src="/iiet/assets/js/tools.js"></script>
	<link rel="import" href="/iiet/assets/web-components/table-scroll.html"/>
	<link rel="import" href="/iiet/assets/web-components/tabla-asinc.html"/>

	<link rel="stylesheet" href="/iiet/assets/css/reset.css" />
	<link rel="stylesheet" href="/iiet/assets/css/general.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/consultas.css"/>
</head>
<body>
	<table is="tabla-asinc" data-target="/iiet/consultas/prueba" data-table="v_campanias">
		<thead>
			<tr>
				<th data-nombre="nombre">Nombre</th>
				<th data-nombre="tipo">Tipo</th>
				<th data-nombre="basal_control">Basal</th>
				<th data-nombre="lugar">Lugar</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</body>
</html>