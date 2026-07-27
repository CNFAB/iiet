import { Almacen } from './Almacen.js';

$('#contenedor').height(window.innerHeight - $('#contenedor').offset().top);

var almacen = new Almacen('estcamp'),
	campania = almacen.campania();

if(campania)
	document.getElementById('nombre-campania').textContent = campania.nombre;

document.getElementById('ir-campanias').addEventListener('click', function(e) {
	e.preventDefault();

	almacen.limpiar();

	window.location.href = '/iiet/campanias';
});