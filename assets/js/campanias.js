var contenVM = document.getElementById('vm_conten');
var tablaCampanias = document.getElementById('tabla_campanias');

var formCampania = formNuevaCampania(contenVM);
var formFiltro = document.filtro_campania;
var btnNuevaCampania = document.getElementById('btn_nueva_campania');


formFiltro.valor_filtro.addEventListener('input', filtrar);

var gCampanias = [];

var gMsjEstado = new ObjMensajeEstado();

var vmMsjEliminarCampania = document.getElementById('msj_eliminar'),
	boxBtnsElimCampania   = document.getElementById('btns_eliminar'),
	btnsEliminarCampania  = {
		si       : boxBtnsElimCampania.children[0],
		no       : boxBtnsElimCampania.children[1]
	};

btnsEliminarCampania.si.vm = vmMsjEliminarCampania;

btnsEliminarCampania.si.addEventListener('click', eliminarCampania);
btnsEliminarCampania.no.addEventListener('click', e => vmMsjEliminarCampania.close());


var vmMsjEliminarCampania2 = document.getElementById('msj_eliminar_2'),
	boxBtnsElimCampania2   = document.getElementById('btns_eliminar_2'),
	btnsEliminarCampania2  = {
		si       : boxBtnsElimCampania2.children[0],
		no       : boxBtnsElimCampania2.children[1]
	};

btnsEliminarCampania2.si.vm = vmMsjEliminarCampania2;

btnsEliminarCampania2.si.addEventListener('click', eliminarCampania);
btnsEliminarCampania2.no.addEventListener('click', e => vmMsjEliminarCampania2.close());

window.addEventListener('load', function(e) {
	var top = Utils.getTop(tablaCampanias);

	tablaCampanias.dataset.maxWidth  = (window.innerWidth - 60) + 'px';
	tablaCampanias.dataset.maxHeight = (window.innerHeight - top - 10) + 'px';

	filtrar(true);
});

function peticion(condicion) {
	var cantFilas = tablaCampanias.rows.length - 1;

	Utils.ajax(
		'/iiet/campanias/listado/' + cantFilas,
		condicion,
		function(e) {
			var campanias = e.target.response;

			for(let campania of campanias) {
				let fila = tablaCampanias.insertRow();

				cargarFila(fila, campania);
				gCampanias.push(campania);
			}

			tablaCampanias.normalize();
		}
	);
}

function filtrar(nuevo) {
	var campoFiltro = formFiltro.campo_filtro.value,
		valorFiltro = formFiltro.valor_filtro.value,
		datos       = [];

	if(valorFiltro)
		datos = new Map([
			['campo_filtro', campoFiltro],
			['valor_filtro', valorFiltro]
		]);

	if(nuevo) {
		tablaCampanias.clearBody();
		gCampanias = new Array();
	}

	peticion(datos);
}

function cargarFila(fila, campania) {
	fila.insertCell('td').textContent = campania['nombre'];
	fila.insertCell('td').textContent = campania['basal_control'];
	fila.insertCell('td').textContent = campania['tipo'];
	fila.insertCell('td').textContent = campania['institucion'] || campania['barrio'] || campania['puesto'];
	fila.insertCell('td').textContent = campania['localidad'];

	var operaciones      = fila.insertCell('td'),
		btnVerActualizar = document.createElement('button'),
		btnCargarDatos   = document.createElement('button'),
		btnEliminar      = document.createElement('button'),
		btnInforme       = document.createElement('a');

	btnVerActualizar.textContent = 'Editar';
	btnVerActualizar.campania    = campania['numero'];
	btnVerActualizar.type        = 'button';
	btnVerActualizar.title       = 'Editar datos campaña';
	btnVerActualizar.addEventListener('click', verActualizar);

	btnCargarDatos.textContent = 'Cargar';
	btnCargarDatos.campania    = campania['numero'];
	btnCargarDatos.type        = 'button';
	btnCargarDatos.title       = 'Cargar intervenciones';
	btnCargarDatos.addEventListener('click', irCargarDatosCampania);

	btnEliminar.textContent = 'Eliminar';
	btnEliminar.campania    = campania['numero'];
	btnEliminar.type        = 'button';
	btnEliminar.title       = 'Eliminar campaña';
	btnEliminar.addEventListener('click', eliminar);

	btnInforme.textContent = 'Informe';
	btnInforme.href = '/iiet/campanias/informe/' + campania['numero'];
	btnInforme.title = 'Ver informe';

	operaciones.appendChild(btnVerActualizar);
	operaciones.appendChild(btnCargarDatos);
	operaciones.appendChild(btnEliminar);
	operaciones.appendChild(btnInforme);
}

btnNuevaCampania.addEventListener('click', function(e) {
	formCampania.establecerModo(formCampania.NUEVO);

	window.location.hash = '#form_campania';
});

function verActualizar(e) {
	var indice = buscarCampaniaEnTabla(this.campania);

	formCampania.establecerModo(formCampania.ACTUALIZAR);
	formCampania.cargarDatos(gCampanias[indice - 1]);

	window.location.hash = '#form_campania';
}

function irCargarDatosCampania(e) {
	var indice   = buscarCampaniaEnTabla(this.campania),
		campania = gCampanias[indice - 1],
		datosCampania = {
			numero:       campania.numero,
			nombre:       campania.nombre,
			fecha_inicio: campania.fecha_inicio,
			fecha_fin:    campania.fecha_fin,
			tipo_lugar:   campania.tipo,
			nombre_lugar: campania.escuela || campania.barrio || campania.puesto
		};

	localStorage.setItem('estcamp_campania', JSON.stringify(datosCampania));

	window.location = '/iiet/intervenciones/campania';
}

function eliminar(e) {
	var idCampania = this.campania,
		indice     = buscarCampaniaEnTabla(this.campania),
		campania   = gCampanias[indice - 1];

	Utils.ajax(
		'/iiet/campanias/tiene_intervenciones/' + idCampania,
		[],
		function(e) {
			var respuesta = e.target.response;

			if(respuesta) {
				let span = vmMsjEliminarCampania.content.children[1].children[0];
					str  = campania.nombre;

				span.textContent = str;

				btnsEliminarCampania.si.campania        = idCampania;

				window.location.hash = '#msj_eliminar';
			}

			else {
				let p    = vmMsjEliminarCampania2.content.children[2].children[0];
					str  = campania.nombre;

				p.textContent = str;

				btnsEliminarCampania2.si.campania = idCampania;

				window.location.hash = '#msj_eliminar_2';
			}
		}
	);
}

function eliminarCampania() {
	var idCampania = this.campania,
		vm         = this.vm,
		indice     = buscarCampaniaEnTabla(this.campania),
		campania   = gCampanias[indice - 1];

	Utils.ajax(
		'/iiet/campanias/eliminar/' + idCampania,
		[],
		function(e) {
			gMsjEstado.establecerTexto1('La campaña ' + campania.nombre);
			gMsjEstado.establecerTexto2('ha sido eliminada.');
			gMsjEstado.mostrar(ObjMensajeEstado.EXITO);

			filtrar(true);

			vm.close();
		},
		function(e) {
			gMsjEstado.establecerTexto1('Ha ocurrido un error al intentar eliminar la campaña.');
			gMsjEstado.establecerTexto2('');
			gMsjEstado.mostrar(ObjMensajeEstado.ERROR);
		}
	);
}

function buscarCampaniaEnTabla(idCampania) {
	var i = 0;

	while(i < gCampanias.length && gCampanias[i++].numero != idCampania);

	return i;
}

formCampania.fcExito = function(e) {
	var idCampania = e.target.response;

	var nombreCampania = formCampania.nombre.value;

	if(formCampania.modo == formCampania.NUEVO) {
		tablaCampanias.clearBody();
		gCampanias = new Array();

		filtrar(true);

		gMsjEstado.establecerTexto1('Se han cargado correctamente los datos de la campaña:');
	}

	else if(formCampania.modo == formCampania.ACTUALIZAR) {
		let posicion = buscarCampaniaEnTabla(idCampania);

		Utils.ajax(
			'/iiet/campanias/datos_completos/' + idCampania,
			[],
			function(e) {
				tablaCampanias.deleteRow(posicion);

				var datos = e.target.response,
					fila  = tablaCampanias.insertRow(posicion);

					cargarFila(fila, datos);
					gCampanias[posicion - 1] = datos;

					tablaCampanias.normalize();

					tablaCampanias.rows[posicion].className = 'modificado';	
			}
		);

		gMsjEstado.establecerTexto1('Se han actualizado correctamente los datos de la campaña:');
	}

	gMsjEstado.establecerTexto2(nombreCampania);
	gMsjEstado.mostrar(ObjMensajeEstado.EXITO);

	formCampania.vm.close();

	var submitCampania = formCampania.querySelector('input[type=submit]');

	submitCampania.className = null;
	submitCampania.disabled  = '';
};

formCampania.fcError = function(e) {
	if(formCampania.modo == formCampania.NUEVO)
		gMsjEstado.establecerTexto1('Ha ocurrido un error al cargar los datos de la campaña.');

	else if(formCampania.modo == formCampania.ACTUALIZAR)
		gMsjEstado.establecerTexto1('Ha ocurrido un error al actualizar los datos de la campaña.');
	
	gMsjEstado.establecerTexto2('Por favor intentelo nuevamente.');
	gMsjEstado.mostrar(ObjMensajeEstado.ERROR);
};