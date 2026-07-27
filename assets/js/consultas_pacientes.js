var listaDptosSelOrg = document.getElementById('list-dptos-sel-org'),
	listaDptosSelDst = document.getElementById('list-dptos-sel-dst'),
	listaDptosDatosSel = document.getElementById('list-dptos-datos-sel'),

	listaLocalidadesSelDst = document.getElementById('list-localidades-sel-dst'),
	listaLocalidadesDatosSel = document.getElementById('list-localidades-datos-sel'),

	listaBarriosSelDst = document.getElementById('list-barrios-sel-dst'),
	listaBarriosDatosSel = document.getElementById('list-barrios-datos-sel'),

	listaParajesSelDst = document.getElementById('list-parajes-sel-dst'),
	listaParajesDatosSel = document.getElementById('list-parajes-datos-sel'),

	listaPuestosSelDst = document.getElementById('list-puestos-sel-dst'),
	listaPuestosDatosSel = document.getElementById('list-puestos-datos-sel'),

	listaInstitBarriosSelDst = document.getElementById('list-instit-barrios-sel-dst'),
	listaInstitBarriosDatosSel = document.getElementById('list-instit-barrios-datos-sel'),

	listaInstitParajesSelDst = document.getElementById('list-instit-parajes-sel-dst'),
	listaInstitParajesDatosSel = document.getElementById('list-instit-parajes-datos-sel');


function solicitarDepartamentos() {
	fetch('/iiet/entidades/listado_departamentos')
		.then(respuesta => {
			if(respuesta.ok) {
				respuesta.json().then(dptos => {
					rellenarLista(listaDptosSelOrg, dptos, 'nombre', 'numero', true);
					Forms.cargarSelect(document.formSelLocalidad.departamento, dptos, 'nombre', 'numero');
					Forms.cargarSelect(document.formSelBarrio.departamento, dptos, 'nombre', 'numero');
					Forms.cargarSelect(document.formSelParaje.departamento, dptos, 'nombre', 'numero');
					Forms.cargarSelect(document.formSelPuesto.departamento, dptos, 'nombre', 'numero');
					Forms.cargarSelect(document.formSelInstitBarrio.departamento, dptos, 'nombre', 'numero');
					Forms.cargarSelect(document.formSelInstitParaje.departamento, dptos, 'nombre', 'numero');
				});
			}
		});
}

function rellenarLista(lista, datos, etiqueta, valor, selec) {
	lista.innerHTML = '';

	for(let i of datos) {
		let item = document.createElement('li');

		item.className = 'list-group-item list-group-item-dark';
		item.textContent = i[etiqueta];
		item.dataset.id = i[valor];
		lista.appendChild(item);

		if(selec)
			item.addEventListener('click', e => activarItem(lista, e.target));
	}
}

function crearItem(etiqueta, valor) {
	var item = document.createElement('li');

	item.className = 'list-group-item list-group-item-dark';
	item.textContent = etiqueta;
	item.dataset.id = valor;

	return item;
}

function activarItem(lista, item) {
	if(item.classList.contains('active')) {
		item.classList.remove('active');
		return;
	}

	var sel = lista.getElementsByClassName('active');

	if(sel.length > 0)
		sel[0].classList.remove('active');

	item.classList.add('active');
}

function listaEstaVacia(lista) {
	if(!lista.children.length || (lista.children.length === 1 && lista.children[0].classList.contains('item-vacio')))
		return true;

	return false;
}

function seleccionarUnItem(listaOrg, listaDst) {
	var item = listaOrg.getElementsByClassName('active');

	if(!item.length)
		return;

	var clon = document.importNode(item[0], true);

	if(listaEstaVacia(listaDst))
		listaDst.innerHTML = '';

	listaDst.appendChild(clon);

	item[0].classList.remove('active');
	clon.classList.remove('active');

	clon.addEventListener('click', e => activarItem(listaDst, e.target));
}

function seleccionarUnItem2(select, listaDst) {
	var i = select.selectedIndex;

	if(i < 1)
		return;

	var option = select.options[i],
		item   = crearItem(option.textContent, option.value);

	if(listaEstaVacia(listaDst))
		listaDst.innerHTML = '';

	listaDst.appendChild(item);

	item.addEventListener('click', e => activarItem(listaDst, e.target));
}

function deseleccionarUnItem(lista) {
	var item = lista.getElementsByClassName('active');

	if(!item.length)
		return;

	lista.removeChild(item[0]);

	if(listaEstaVacia(lista))
		insertarItemVacio(lista);
}

function seleccionarItemsTodos(listaOrg, listaDst) {
	listaDst.innerHTML = '';

	for(let item of listaOrg.children) {
		var clon = document.importNode(item, true);

		listaDst.appendChild(clon);

		item.classList.remove('active');
		clon.classList.remove('active');

		clon.addEventListener('click', e => activarItem(listaDst, e.target));
	}
}

function deseleccionarItemsTodos(lista) {
	insertarItemVacio(lista);
}

function insertarItemVacio(lista, li = true) {
	var itemVacio = document.createElement(li ? 'li' : 'div'),
		txtVacio  = document.createElement('p');

	lista.innerHTML = '';

	itemVacio.className = 'item-vacio';
	txtVacio.textContent = 'No hay datos seleccionados';

	itemVacio.appendChild(txtVacio);
	lista.appendChild(itemVacio);
}

document.getElementById('btn-sel-dpto').addEventListener('click', e => seleccionarUnItem(listaDptosSelOrg, listaDptosSelDst));
document.getElementById('btn-sel-dpto-todo').addEventListener('click', e => seleccionarItemsTodos(listaDptosSelOrg, listaDptosSelDst));
document.getElementById('btn-desel-dpto').addEventListener('click', e => deseleccionarUnItem(listaDptosSelDst));
document.getElementById('btn-desel-dpto-todo').addEventListener('click', e => deseleccionarItemsTodos(listaDptosSelDst));

document.getElementById('btn-sel-localidad').addEventListener('click', e => seleccionarUnItem2(document.formSelLocalidad.localidad, listaLocalidadesSelDst));
document.getElementById('btn-desel-localidad').addEventListener('click', e => deseleccionarUnItem(listaLocalidadesSelDst));
document.getElementById('btn-desel-localidad-todo').addEventListener('click', e => deseleccionarItemsTodos(listaLocalidadesSelDst));

document.getElementById('btn-sel-barrio').addEventListener('click', e => seleccionarUnItem2(document.formSelBarrio.barrio, listaBarriosSelDst));
document.getElementById('btn-desel-barrio').addEventListener('click', e => deseleccionarUnItem(listaBarriosSelDst));
document.getElementById('btn-desel-barrio-todo').addEventListener('click', e => deseleccionarItemsTodos(listaBarriosSelDst));

document.getElementById('btn-sel-paraje').addEventListener('click', e => seleccionarUnItem2(document.formSelParaje.paraje, listaParajesSelDst));
document.getElementById('btn-desel-paraje').addEventListener('click', e => deseleccionarUnItem(listaParajesSelDst));
document.getElementById('btn-desel-paraje-todo').addEventListener('click', e => deseleccionarItemsTodos(listaParajesSelDst));

document.getElementById('btn-sel-puesto').addEventListener('click', e => seleccionarUnItem2(document.formSelPuesto.puesto, listaPuestosSelDst));
document.getElementById('btn-desel-puesto').addEventListener('click', e => deseleccionarUnItem(listaPuestosSelDst));
document.getElementById('btn-desel-puesto-todo').addEventListener('click', e => deseleccionarItemsTodos(listaPuestosSelDst));

document.getElementById('btn-sel-instit-barrio').addEventListener('click', e => seleccionarUnItem2(document.formSelInstitBarrio.institucion, listaInstitBarriosSelDst));
document.getElementById('btn-desel-instit-barrio').addEventListener('click', e => deseleccionarUnItem(listaInstitBarriosSelDst));
document.getElementById('btn-desel-instit-barrio-todo').addEventListener('click', e => deseleccionarItemsTodos(listaInstitBarriosSelDst));

document.getElementById('btn-sel-instit-paraje').addEventListener('click', e => seleccionarUnItem2(document.formSelInstitParaje.institucion, listaInstitParajesSelDst));
document.getElementById('btn-desel-instit-paraje').addEventListener('click', e => deseleccionarUnItem(listaInstitParajesSelDst));
document.getElementById('btn-desel-instit-paraje-todo').addEventListener('click', e => deseleccionarItemsTodos(listaInstitParajesSelDst));



document.getElementById('btn-ok-sel-dptos').addEventListener('click', function(e) {
	seleccionarItemsTodos(listaDptosSelDst, listaDptosDatosSel);
	$('#consult-selec-dptos').modal('hide');
});

document.getElementById('btn-ok-sel-localidades').addEventListener('click', function(e) {
	seleccionarItemsTodos(listaLocalidadesSelDst, listaLocalidadesDatosSel);
	$('#consult-selec-localidades').modal('hide');
});

document.getElementById('btn-ok-sel-barrios').addEventListener('click', function(e) {
	seleccionarItemsTodos(listaBarriosSelDst, listaBarriosDatosSel);
	$('#consult-selec-barrios').modal('hide');
});

document.getElementById('btn-ok-sel-parajes').addEventListener('click', function(e) {
	seleccionarItemsTodos(listaParajesSelDst, listaParajesDatosSel);
	$('#consult-selec-parajes').modal('hide');
});

document.getElementById('btn-ok-sel-puestos').addEventListener('click', function(e) {
	seleccionarItemsTodos(listaPuestosSelDst, listaPuestosDatosSel);
	$('#consult-selec-puestos').modal('hide');
});

document.getElementById('btn-ok-sel-instit-barrios').addEventListener('click', function(e) {
	seleccionarItemsTodos(listaInstitBarriosSelDst, listaInstitBarriosDatosSel);
	$('#consult-selec-instit-barrios').modal('hide');
});

document.getElementById('btn-ok-sel-instit-parajes').addEventListener('click', function(e) {
	seleccionarItemsTodos(listaInstitParajesSelDst, listaInstitParajesDatosSel);
	$('#consult-selec-instit-parajes').modal('hide');
});

solicitarDepartamentos();

// formulario selcción localidades
Forms.cambioSelect(
	document.formSelLocalidad.departamento,
	document.formSelLocalidad.localidad,
	'/iiet/entidades/listado_localidades/',
	'nombre',
	'numero'
);

// formulario selección barrios
Forms.cambioSelect(
	document.formSelBarrio.departamento,
	document.formSelBarrio.localidad,
	'/iiet/entidades/listado_localidades/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	document.formSelBarrio.localidad,
	document.formSelBarrio.barrio,
	'/iiet/entidades/listado_barrios/',
	'nombre',
	'numero'
);

// formulario selección parajes
Forms.cambioSelect(
	document.formSelParaje.departamento,
	document.formSelParaje.localidad,
	'/iiet/entidades/listado_localidades/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	document.formSelParaje.localidad,
	document.formSelParaje.paraje,
	'/iiet/entidades/listado_parajes/',
	'nombre',
	'numero'
);

// formulario selección puestos
Forms.cambioSelect(
	document.formSelPuesto.departamento,
	document.formSelPuesto.localidad,
	'/iiet/entidades/listado_localidades/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	document.formSelPuesto.localidad,
	document.formSelPuesto.paraje,
	'/iiet/entidades/listado_parajes/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	document.formSelPuesto.paraje,
	document.formSelPuesto.puesto,
	'/iiet/entidades/listado_puestos/',
	'nombre',
	'numero'
);

// formulario selección instituciones en barrios
Forms.cambioSelect(
	document.formSelInstitBarrio.departamento,
	document.formSelInstitBarrio.localidad,
	'/iiet/entidades/listado_localidades/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	document.formSelInstitBarrio.localidad,
	document.formSelInstitBarrio.barrio,
	'/iiet/entidades/listado_barrios/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	document.formSelInstitBarrio.barrio,
	document.formSelInstitBarrio.institucion,
	'/iiet/escuelas/listado_escuelas/barrio/',
	'nombre',
	'numero'
);

// formulario selección instituciones en parajes
Forms.cambioSelect(
	document.formSelInstitParaje.departamento,
	document.formSelInstitParaje.localidad,
	'/iiet/entidades/listado_localidades/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	document.formSelInstitParaje.localidad,
	document.formSelInstitParaje.paraje,
	'/iiet/entidades/listado_parajes/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	document.formSelInstitParaje.paraje,
	document.formSelInstitParaje.institucion,
	'/iiet/escuelas/listado_escuelas/paraje/',
	'nombre',
	'numero'
);

var tRestricFecha = document.getElementById('t-restric-fecha').content;
var listaFechasDatosSel = document.getElementById('list-fechas-datos-sel');
var iFecha = 1;

document.getElementById('btn-nueva-rest-fecha').addEventListener('click', function(e) {
	var clon = document.importNode(tRestricFecha, true);

	if(listaEstaVacia(document.formFechas))
		document.formFechas.innerHTML = '';

	document.formFechas.appendChild(clon);

	var fechas = document.formFechas.lastElementChild.getElementsByClassName('form-control');

	fechas[0].id += iFecha;
	fechas[0].parentNode.children[0].setAttribute('for', 'fn-fecha-ini-' + iFecha);

	fechas[1].id += iFecha;
	fechas[1].parentNode.children[0].setAttribute('for', 'fn-fecha-fin-' + iFecha);

	++iFecha;
});

document.formFechas.addEventListener('submit', function(e) {
	e.preventDefault();

	this.classList.add('was-validated');

	var datosItems = new Array();

	if(this.checkValidity()) {
		for(let items of document.formFechas.children) {
			var fechaIni = items.getElementsByClassName('fecha-ini')[0].value,
				fechaFin = items.getElementsByClassName('fecha-fin')[0].value,
				txtFecha = formatoFecha(fechaIni) + ' - ' + formatoFecha(fechaFin),
				dataFecha = fechaIni + '#' + fechaFin;

			datosItems.push({ texto: txtFecha, data: dataFecha });
		}

		if(datosItems.length)
			rellenarLista(listaFechasDatosSel, datosItems, 'texto', 'data', false);

		else
			insertarItemVacio(listaFechasDatosSel);

		$('#consult-selec-fechas').modal('hide');
	}
});

$('#consult-selec-fechas').on('show.bs.modal', function(e) {
	document.formFechas.classList.remove('was-validated');
});

function formatoFecha(fecha) {
	return fecha.split('-').reverse().join('/');
}


var tRestricEdad = document.getElementById('t-restric-edad').content;
var listaEdadesDatosSel = document.getElementById('list-edades-datos-sel');
var iEdad = 1;

document.getElementById('btn-nueva-rest-edad').addEventListener('click', function(e) {
	var clon = document.importNode(tRestricEdad, true);

	if(listaEstaVacia(document.formEdades))
		document.formEdades.innerHTML = '';

	document.formEdades.appendChild(clon);

	var edades = document.formEdades.lastElementChild.getElementsByClassName('form-control');

	edades[0].id += iEdad;
	edades[0].parentNode.children[0].setAttribute('for', 'edad-min-' + iEdad);

	edades[1].id += iEdad;
	edades[1].parentNode.children[0].setAttribute('for', 'edad-max-' + iEdad);

	++iEdad;
});

document.formEdades.addEventListener('submit', function(e) {
	e.preventDefault();

	this.classList.add('was-validated');

	var datosItems = new Array();

	if(this.checkValidity()) {
		for(let items of document.formEdades.children) {
			var EdadMin  = items.getElementsByClassName('edad-min')[0].value,
				EdadMax  = items.getElementsByClassName('edad-max')[0].value,
				txtEdad  = 'desde ' + EdadMin + ' año(s) hasta ' + EdadMax + ' año(s)',
				dataEdad = EdadMin + '#' + EdadMax;

			datosItems.push({ texto: txtEdad, data: dataEdad });
		}

		if(datosItems.length)
			rellenarLista(listaEdadesDatosSel, datosItems, 'texto', 'data', false);

		else
			insertarItemVacio(listaEdadesDatosSel);

		$('#consult-selec-edades').modal('hide');
	}
});


document.getElementById('btn-listo').addEventListener('click', function(e) {
	document.body.children[0].classList.add('d-none');
	document.body.children[1].classList.add('d-none');
	document.body.children[2].classList.remove('d-none');
	document.body.children[3].classList.remove('d-none');
});

document.getElementById('btn-atras').addEventListener('click', function(e) {
	e.preventDefault();

	document.body.children[0].classList.remove('d-none');
	document.body.children[1].classList.remove('d-none');
	document.body.children[2].classList.add('d-none');
	document.body.children[3].classList.add('d-none');
});

document.formCamposConsulta.addEventListener('submit', function(e) {
	this.departamentos.value = JSON.stringify(formatearDatosLista(listaDptosDatosSel));
	this.localidades.value   = JSON.stringify(formatearDatosLista(listaLocalidadesDatosSel));
	this.barrios.value       = JSON.stringify(formatearDatosLista(listaBarriosDatosSel));
	this.parajes.value       = JSON.stringify(formatearDatosLista(listaParajesDatosSel));
	this.puestos.value       = JSON.stringify(formatearDatosLista(listaPuestosDatosSel));

	var institBarrio = formatearDatosLista(listaInstitBarriosDatosSel);
	var institParaje = formatearDatosLista(listaInstitParajesDatosSel);

	this.instituciones.value = JSON.stringify(institBarrio.concat(institParaje));
	
	this.fechas.value        = JSON.stringify(formatearDatosFechas(listaFechasDatosSel));
	this.edades.value        = JSON.stringify(formatearDatosEdades(listaEdadesDatosSel));
	this.sexo.value          = JSON.stringify(formatearDatosSexo());
	this.copro.value         = JSON.stringify(procesarCopro());
	this.sangre.value        = JSON.stringify(procesarSangre());
	this.biolog_molec.value  = JSON.stringify(procesarBiologMolec());
	this.tratamiento.value   = JSON.stringify(procesarTratamiento());
});

function formatearDatosLista(lista) {
	var arrayDatos = new Array();

	for(let item of lista.children)
		if(!item.classList.contains('item-vacio'))
			arrayDatos.push(item.dataset.id);

	return arrayDatos;
}

function formatearDatosFechas(lista) {
	var arrayDatos = new Array();

	for(let item of lista.children) {
		if(item.classList.contains('item-vacio'))
			break;

		let fecha = item.dataset.id.split('#');

		arrayDatos.push({ cota_inf: fecha[0], cota_sup: fecha[1] });
	}

	return arrayDatos;
}

function formatearDatosEdades(lista) {
	var arrayDatos = new Array();

	for(let item of lista.children) {
		if(item.classList.contains('item-vacio'))
			break;

		let edad = item.dataset.id.split('#');

		arrayDatos.push({ cota_inf: edad[0], cota_sup: edad[1] });
	}

	return arrayDatos;
}

function formatearDatosSexo() {
	var sexo = document.formRestricciones.sexo;

	return { masculino: sexo[0].checked, femenino: sexo[1].checked };
}

function procesarCopro() {
	var form = document.formRestricciones;

	return {
		concentrado: form.checkConcentrado.checked,
		mc_master:   form.checkMcMaster.checked,
		harada_mori: form.checkHaradaMori.checked,
		baerman:     form.checkBaerman.checked,
		placa_agar:  form.checkPlacaAgar.checked
	};
}

function procesarSangre() {
	var form = document.formRestricciones;

	return {
		hemograma: form.checkHemograma.checked,
		serologia:  form.checkSerologia.checked
	};
}

function procesarBiologMolec() {
	var form = document.formRestricciones;

	return {
		pcr: form.checkPCR.checked,
		qpcr:  form.checkQPCR.checked
	};
}

function procesarTratamiento() {
	var form = document.formRestricciones;

	return {
		trat_medidas: form.checkMedidas.checked,
		trat_previo:  form.checkTratPrevio.checked
	};
}

var checksCampos = document.querySelectorAll('.card .card-header .custom-control-input');

for(let checkbox of checksCampos)
	checkbox.addEventListener('change', marcarCheckboxs);


var checksEstudios = document.querySelectorAll('.col-form-legend .custom-control-input');

for(let checkbox of checksEstudios)
	checkbox.addEventListener('change', marcarCheckboxs);


function marcarCheckboxs(e) {
	var check       = e.target,
		contenedor  = check.parentNode.parentNode.parentNode,
		inputChecks = contenedor.querySelectorAll('.custom-control-input');

	inputChecks.forEach(c => c.checked = check.checked);
}