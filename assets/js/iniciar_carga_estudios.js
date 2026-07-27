function iniciarCargaEstudios(esCampania) {


var contVMForm    	  = document.getElementById('cont_vmform'),
	fSelecCampania    = formSelecCampania(contVMForm),
	fNuevoPaciente    = formNuevoPaciente(contVMForm),
	formEstudios      = document.form_estudios,
	estudios 		  = document.getElementsByClassName('estudios'),
	inputPaciente     = document.getElementById('paciente');
	inputBuscPaciente = document.getElementById('valor_busqueda'),
	selectFiltro      = document.getElementById('buscar_por'),
	btnCrearPaciente  = document.getElementById('crear_paciente'),
	listaPaciente     = document.querySelector('.datalist'),
	inputValorOrig    = '',
	itemSeleccionado  = undefined,
	estudiosTodos 	  = document.querySelectorAll('#otros_estudios > a'),
	btnSalir		  = document.getElementById('btn_salir'),
	wrapperMsjIni 	  = document.getElementById('wrapper_msj_ini'),
	guardarEstudio	  = document.getElementById('guardar_estudio'),
	estadoCarga 	  = document.getElementById('estado_guardar');

	datosPaciente = null;

if(esCampania) {
	var datosPaciente = JSON.parse(localStorage.getItem('campania_paciente')),
		datosCampania = JSON.parse(localStorage.getItem('campania'));

	if(datosCampania)
		establecerCampania(datosCampania);

	else
		wrapperMsjIni.style.display = 'block';
}

else
	var datosPaciente = JSON.parse(localStorage.getItem('externo_paciente'));

if(datosPaciente)
	establecerPaciente(datosPaciente);

function establecerCampania(respuesta) {
	wrapperMsjIni.style.display = 'none';

	var lugarCampania  = document.getElementById('lugar_campania')
		nombreCampania = document.getElementById('nombre_campania'),
		campFechaIni   = document.getElementById('camp_f_ini'),
		campFechaFin   = document.getElementById('camp_f_fin');

	lugarCampania.innerHTML  = Utils.toCamelCase(respuesta.tipo_lugar) + ' ' + respuesta.nombre_lugar;
	nombreCampania.innerHTML = respuesta.nombre;
	campFechaIni.innerHTML   = respuesta.fecha_inicio;
	campFechaFin.innerHTML   = respuesta.fecha_fin;

	var campania = document.getElementById('campania'),
		tipo 	 = document.getElementById('tipo');

	campania.value = respuesta.numero;
	tipo.value = respuesta.tipo_lugar;

	inputBuscPaciente.focus();
}

function establecerPaciente(paciente) {
	seleccionItemList(itemSeleccionado);

	inputBuscPaciente.value = paciente.valor;
	selectFiltro.value = paciente.filtro;

	listaPaciente.className += ' oculto';
	listaPaciente.innerHTML = '';

	inputPaciente.value = paciente.numero;
}

fSelecCampania.fcExito = function(e) {
	localStorage.setItem('campania', JSON.stringify(e.target.response));

	establecerCampania(e.target.response);
	fSelecCampania.vm.close();
};

fNuevoPaciente.fcExito = function(e) {
	var respuesta = e.target.response;

	if(respuesta !== false) {
		let lista = [{
			numero	: respuesta.id,
			dni 	: fNuevoPaciente.dni.value,
			apellido: fNuevoPaciente.apellido.value,
			nombre 	: fNuevoPaciente.nombre.value
		}];

		inputPaciente.value = respuesta.id;

		selectFiltro.selectedIndex = 0;
		inputBuscPaciente.value = fNuevoPaciente.apellido.value + ', ' + fNuevoPaciente.nombre.value;
		inputBuscPaciente.focus();
		
		fNuevoPaciente.reset();

		var objPaciente = {
			numero: respuesta.id,
			filtro: selectFiltro.value,
			valor:  inputBuscPaciente.value
		};

		localStorage.setItem(esCampania ? 'campania_paciente' : 'externo_paciente', JSON.stringify(objPaciente));
		resetFormEstudios();
	}
};

formEstudios.fcExito = e => {
	var respuesta = e.target.response;

	if(e.target.status === 500 || respuesta === false) {
		estadoCarga.className = 'error_guardar';
		estadoCarga.children[0].textContent = 'Ha ocurrido un error al intentar cargar los datos.';
		estadoCarga.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoCarga.className = 'exito_guardar';
		estadoCarga.children[0].textContent = 'Se han cargado correctamente los datos.';
	}

	window.setTimeout(() => {
		estadoCarga.className = '';
	}, 5000);
};

function resetFormEstudios() {
	formEstudios.reset();

	for(let estudio of estudios)
		estudio.deshabilitar();

	inputBuscPaciente.focus();
};

inputBuscPaciente.addEventListener('keydown', function(e) {
	switch(e.keyCode) {
		// tecla de dirección hacia abajo
		case 40:
			listaPaciente.className = listaPaciente.className.replace(/(?:^|\s)oculto(?!\S)/g , '');
			marcarItemSiguiente(listaPaciente);
		break;

		// tecla de dirección hacia arriba
		case 38:
			listaPaciente.className = listaPaciente.className.replace(/(?:^|\s)oculto(?!\S)/g , '');
			marcarItemAnterior(listaPaciente);
		break;

		// tecla ENTER
		case 13:
			confirmarItemSeleccionado();
		break;

		// tecla ESC
		case 27:
			ocultarLista();
		break;
	}
});

inputBuscPaciente.addEventListener('input', function(e) {
	var datos, campoFiltro, valorFiltro;

	valorFiltro = this.value;

	valorFiltro = valorFiltro.replace(/^(\s+|,)/, '');
	valorFiltro = valorFiltro.replace(/\s+/g, ' ');
	valorFiltro = valorFiltro.replace(/\s,/g, ',');
	valorFiltro = valorFiltro.replace(/(?<=,)\w/g, $1 => ' ' + $1);
	valorFiltro = Utils.toCamelCase(valorFiltro);

	campoFiltro = selectFiltro.value;
	this.value = valorFiltro;
	inputValorOrig = valorFiltro;

	if(valorFiltro === '') {
		btnCrearPaciente.className = 'oculto';
		vaciarLista();

		return;
	}

	datos = new Map([
		['campo_filtro', campoFiltro],
		['valor_filtro', valorFiltro]
	]);

	Utils.ajax('/iiet/pacientes/filtrar_pacientes', datos, function(e) {
		var respuesta = e.target.response;

		if(respuesta.length > 0)
			listarPacientes(respuesta, campoFiltro);

		else {
			btnCrearPaciente.className = '';
			vaciarLista();
		}
	});
});

selectFiltro.addEventListener('change', function(e) {
	inputValorOrig = '';
	vaciarLista();
	btnCrearPaciente.className = 'oculto';
});

btnCrearPaciente.addEventListener('click', function(e) {
	this.className = 'oculto';

	if(selectFiltro.value == 'apynomb') {
		let nombres = inputBuscPaciente.value.split(/\s*,\s*/);

		fNuevoPaciente.apellido.value = nombres[0];
		fNuevoPaciente.nombre.value = nombres[1] || '';
	}

	else
		fNuevoPaciente.dni.value = inputBuscPaciente.value;

	btnCrearPaciente.className = 'oculto';
});

function listarPacientes(lista, campoFiltro) {
	vaciarLista();

	var i = 0;

	for(let item of lista) {
		let nombres, itemList;

		nombres = item['apellido'] + ', ' + item['nombre'];

		if(campoFiltro == 'apynomb')
			itemList = nuevoItemList(nombres, item['dni'], item['numero']);

		else
			itemList = nuevoItemList(item['dni'], nombres, item['numero']);

		itemList.indice = i++;
		listaPaciente.appendChild(itemList);
	}

	mostrarLista();
}

/**
 * Gestión de la lista de pacientes
 */

function nuevoItemList(texto1, texto2, valor) {
	var item, spanTexto1, spanTexto2;

	item = document.createElement('li');
	spanTexto1 = document.createElement('span');
	spanTexto2 = document.createElement('span');

	spanTexto1.textContent = texto1;
	spanTexto2.textContent = texto2;

	item.appendChild(spanTexto1);
	item.appendChild(spanTexto2);
	item.dataset.id = valor;

	item.addEventListener('click', confirmarItemSeleccionado);
	item.addEventListener('mouseover', e => marcarItem(item));
	item.addEventListener('mouseout', e => item.className = null);

	return item;
}

function seleccionItemList(item) {
	if(typeof item === 'undefined')
		inputBuscPaciente.value = inputValorOrig;

	else {
		inputBuscPaciente.value = item.children[0].textContent;

		item.className = 'item_selec';
		inputBuscPaciente.focus();
	}
}

function marcarItem(item) {
	if(typeof itemSeleccionado !== 'undefined')
		itemSeleccionado.className = null;

	itemSeleccionado = item;

	item.className = 'item_selec';
	inputBuscPaciente.focus();
}

function marcarItemSiguiente() {
	var indiceSig;

	if(typeof itemSeleccionado === 'undefined') {
		itemSeleccionado = listaPaciente.children[0];
		listaPaciente.scrollTop = 0;
	}
	
	else {
		itemSeleccionado.className = null;

		indiceSig = itemSeleccionado.indice + 1;
		itemSeleccionado = listaPaciente.children[indiceSig];
	}

	seleccionItemList(itemSeleccionado);
	gestionarScroll();
}

function marcarItemAnterior() {
	var indiceAnt, ultItem;

	if(typeof itemSeleccionado === 'undefined') {
		ultItem = listaPaciente.children.length - 1;
		itemSeleccionado = listaPaciente.children[ultItem];
		listaPaciente.scrollTop = ultItem * Utils.getHeight(itemSeleccionado);
	}
	
	else {
		itemSeleccionado.className = null;

		indiceAnt = itemSeleccionado.indice - 1;
		itemSeleccionado = listaPaciente.children[indiceAnt];
	}

	seleccionItemList(itemSeleccionado);
	gestionarScroll();
	inputBuscPaciente.value += '';
}

function gestionarScroll() {
	if(typeof itemSeleccionado === 'undefined')
		return;

	var topItem 	= Utils.getTop(itemSeleccionado),
		bottomItem  = Utils.getBottom(itemSeleccionado),
		bottomLista = Utils.getBottom(listaPaciente),
		topLista    = Utils.getTop(listaPaciente);

	if(bottomItem > bottomLista)
		listaPaciente.scrollTop += bottomItem - bottomLista;

	else if(topItem < topLista)
		listaPaciente.scrollTop -= topLista - topItem;
}

function confirmarItemSeleccionado() {
	seleccionItemList(itemSeleccionado);

	inputValorOrig = inputBuscPaciente.value;
	listaPaciente.className += ' oculto';
	listaPaciente.innerHTML = '';

	inputPaciente.value = itemSeleccionado.dataset.id;

	var objPaciente = {
		numero: itemSeleccionado.dataset.id,
		filtro: selectFiltro.value,
		valor:  inputBuscPaciente.value
	};

	Utils.ajax(
		'/iiet/campanias/obtener_estudios_paciente/' + inputPaciente.value,
		[],
		function(e) {
			console.log(e.target.response);
	});

	localStorage.setItem(esCampania ? 'campania_paciente' : 'externo_paciente', JSON.stringify(objPaciente));
	resetFormEstudios();
}

function mostrarLista() {
	listaPaciente.className = listaPaciente.className.replace(/(?:^|\s)oculto(?!\S)/g , '');

	listaPaciente.style.height = null;
	listaPaciente.style.overflowY = null;

	if(Utils.getBottom(listaPaciente) > window.innerHeight) {
		listaPaciente.style.height = (window.innerHeight - Utils.getTop(listaPaciente) - 10) + 'px';
		listaPaciente.style.overflowY = 'scroll';
	}
}

function ocultarLista() {
	listaPaciente.className += ' oculto';

	if(typeof itemSeleccionado !== 'undefined')
		itemSeleccionado.className = null;

	inputBuscPaciente.value = inputValorOrig;
	itemSeleccionado = undefined;

	inputBuscPaciente.focus();
}

function vaciarLista() {
	ocultarLista();

	listaPaciente.innerHTML = '';
}

btnSalir.addEventListener('click', e => {
	localStorage.clear();
});

if(esCampania)
	window.addEventListener('focus', e => {
		var campania = localStorage.getItem('campania');

		if(campania === null)
			window.location.reload();
	});

else
	window.addEventListener('focus', e => {
		var paciente = localStorage.getItem('externo_paciente');

		if(paciente === null)
			window.location.reload();
	});


}