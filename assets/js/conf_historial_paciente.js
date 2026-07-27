var gTempForm         = document.getElementById('form_estudio').content,
	gTempMsjNoInterv  = document.getElementById('t_msj_no_interv').content,
	gTempMsjNoEstudio = document.getElementById('t_msj_no_estudio').content;

var gBuscPaciente   = document.getElementById('datos_paciente'),
	gBtnSalir       = document.getElementById('btn_salir'),
	gEstadoCarga     = document.getElementById('estado_guardar'),
	gContVMForm     = document.getElementById('cont_vmform'),
	gFSelecCampania = formSelecCampania(gContVMForm),
	gFNuevoPaciente = formNuevoPaciente(gContVMForm),
	gFConsultExt    = formConsultExt(gContVMForm);

var gIntervencionesGuardadas = JSON.parse(localStorage.getItem('estudios')),
	gDatosCampania           = JSON.parse(localStorage.getItem('campania')),
	gDatosPaciente           = JSON.parse(localStorage.getItem('paciente')),
	gIdPaciente              = document.getElementById('paciente'),
	gNroInterv               = document.getElementById('nro_interv');

var gFormEstudios     = null,
	gEstudios         = null,
	gPaginacion       = document.querySelector('wc-paginacion'),
	gBtnNuevoActivado = false;

var gMsjEstado = new ObjMensajeEstado();


window.addEventListener('load', e => {
	var top = Utils.getTop(gPaginacion);
	gPaginacion.style.height = (window.innerHeight - top) + 'px';

	if(gIntervencionesGuardadas) {
		var indice = localStorage.getItem('indice_actual') - 0;

		iniPaginacion(indice + 1);
	}
});

cargarDatosEstudios();
establecerPaciente();

function establecerCampania() {
	var indice   = gPaginacion.pagActual - 1,
		campania = gIntervencionesGuardadas[indice].campania;

	if(!campania)
		return;

	var lugarCampania  = document.getElementById('lugar_campania'),
		nombreCampania = document.getElementById('nombre_campania'),
		campFechaIni   = document.getElementById('camp_f_ini'),
		campFechaFin   = document.getElementById('camp_f_fin');

	lugarCampania.innerHTML  = Utils.toCamelCase(campania.tipo_lugar) + ' ' + campania.nombre_lugar;
	nombreCampania.innerHTML = campania.nombre;
	campFechaIni.innerHTML   = campania.fecha_inicio;
	campFechaFin.innerHTML   = campania.fecha_fin;

	var inputCampania = document.getElementById('campania');

	inputCampania.value = campania.numero;
	gNroInterv.disabled = 'disabled';

	gBuscPaciente.focus();
}

function establecerConsultExt() {
	var indice  = gPaginacion.pagActual - 1,
		externo = gIntervencionesGuardadas[indice].externo;

	if(!externo)
		return;

	var fechaExterno       = document.getElementById('fecha_externo'),
		procedenciaExterno = document.getElementById('procedencia_externo');

	gNroInterv.disabled = null;
	gNroInterv.value = gIntervencionesGuardadas[indice].numero;

	fechaExterno.textContent       = externo.fecha;
	procedenciaExterno.textContent = 'Centro de Salud ' + externo.procedencia;

	gBuscPaciente.focus();
}

function establecerPaciente() {
	if(!gDatosPaciente)
		return;

	gBuscPaciente.seleccionItemList();

	gBuscPaciente.input.value = gDatosPaciente.valor;
	gBuscPaciente.selectFiltro.value = gDatosPaciente.filtro;

	gBuscPaciente.listaOpciones.className += ' oculto';
	gBuscPaciente.listaOpciones.innerHTML = '';

	gIdPaciente.value = gDatosPaciente.numero;
}

gFSelecCampania.fcExito = function(e) {
	var respuesta = e.target.response,
		indice = gPaginacion.pagActual,
		intervencion = {
			numero: null,
			fecha: respuesta.fecha_inicio,
			paciente: gIdPaciente.value,
			tipo: 'CAMPANIA',
			campania: respuesta.numero,
			externo: null
		};

	gIntervencionesGuardadas[indice] = intervencion;
	gNroInterv.disabled = 'disabled';

	gBtnNuevoActivado = true;

	gPaginacion.establecerCantPaginas(indice + 1);
	gPaginacion.establecerPagina(indice + 1);

	//gDatosCampania = respuesta;
	//localStorage.setItem('campania', JSON.stringify(respuesta));

	//establecerCampania();
	gFSelecCampania.vm.close();
};

gFSelecCampania.fcError = function(e) {
	gMsjEstado.establecerTexto1('Ha ocurrido un error al seleccionar la campaña.');
	gMsjEstado.establecerTexto2('');
	gMsjEstado.mostrar(ObjMensajeEstado.ERROR);
};

gFConsultExt.fcExito = function(e) {
	var idInterv = e.target.response,
		indice = gPaginacion.pagActual,
		intervencion = {
			numero: idInterv,
			fecha: gFConsultExt.fecha,
			paciente: gFConsultExt.paciente.value,
			tipo: 'EXTERNO',
			campania: null,
			externo: null
		};

	gNroInterv.disabled = null;
	gNroInterv.value = idInterv;

	gBtnNuevoActivado = true;

	if(gIntervencionesGuardadas.length > 0) {
		gIntervencionesGuardadas[indice] = intervencion;

		gPaginacion.establecerCantPaginas(indice + 1);
		gPaginacion.establecerPagina(indice + 1);
	}

	else {
		gIntervencionesGuardadas[0] = intervencion;

		gPaginacion.establecerCantPaginas(1);
		gPaginacion.establecerPagina(1);
	}

	gMsjEstado.establecerTexto1('Se ha creado correctamente la intervención');
	gMsjEstado.establecerTexto2('por consultorio externo.');
	gMsjEstado.mostrar(ObjMensajeEstado.EXITO);

	localStorage.setItem('estudios', JSON.stringify(gIntervencionesGuardadas));

	gFConsultExt.vm.close();
};

gFConsultExt.fcError = function(e) {
	gMsjEstado.establecerTexto1('Ha ocurrido un error al crear la intervención');
	gMsjEstado.establecerTexto2('por consultorio externo.');
	gMsjEstado.mostrar(ObjMensajeEstado.ERROR);
};

gFNuevoPaciente.fcExito = function(e) {
	var respuesta = e.target.response;

	if(respuesta !== false) {
		let lista = [{
			numero	: respuesta.id,
			dni 	: gFNuevoPaciente.dni.value,
			apellido: gFNuevoPaciente.apellido.value,
			nombre 	: gFNuevoPaciente.nombre.value
		}];

		gIdPaciente.value = respuesta.id;

		gBuscPaciente.selectFiltro.selectedIndex = 0;
		gBuscPaciente.input.value = gFNuevoPaciente.apellido.value + ', ' + gFNuevoPaciente.nombre.value;
		gBuscPaciente.input.focus();

		gMsjEstado.establecerTexto1('Se han cargado correctamente los datos del paciente:');
		gMsjEstado.establecerTexto2(gBuscPaciente.input.value + ' (' + gFNuevoPaciente.dni.value + ')');
		gMsjEstado.mostrar(ObjMensajeEstado.EXITO);
		
		gFNuevoPaciente.vm.close();

		var objPaciente = {
			numero: respuesta.id,
			filtro: selectFiltro.value,
			valor:  gBuscPaciente.value
		};

		localStorage.setItem('paciente', JSON.stringify(objPaciente));
		resetFormEstudios();
	}
};

gFNuevoPaciente.fcError = function(e) {
	gMsjEstado.establecerTexto1('Ha ocurrido un error al cargar los datos del paciente.');
	gMsjEstado.establecerTexto2('Por favor intentelo nuevamente.');
	gMsjEstado.mostrar(ObjMensajeEstado.ERROR);
};

function resetFormEstudios() {
	if(!gFormEstudios)
		return;

	gFormEstudios.reset();

	for(let estudio of gEstudios)
		estudio.deshabilitar();

	gBuscPaciente.input.focus();
};

gBuscPaciente.fcConfItemSelec = function(datos) {
	gIdPaciente.value = gBuscPaciente.itemSeleccionado.dataset.id;

	Utils.ajax(
		'/iiet/intervenciones/intervenciones_paciente/' + gIdPaciente.value,
		[],
		function(e) {
			gIntervencionesGuardadas = e.target.response;
			localStorage.setItem('estudios', JSON.stringify(gIntervencionesGuardadas));

			iniPaginacion(gIntervencionesGuardadas.length);
	});

	localStorage.setItem('paciente', JSON.stringify(datos));
	resetFormEstudios();
};

function iniPaginacion(indiceInicial) {
	if(gIntervencionesGuardadas.length > 0) {
		gPaginacion.establecerCantPaginas(gIntervencionesGuardadas.length);
		gPaginacion.establecerPagina(indiceInicial);
	}

	else {
		gPaginacion.establecerCantPaginas(1);
		gPaginacion.establecerPagina(1);
	}
}

gPaginacion.manejadorEventoPaginacion(function(indice) {
	--indice;
	localStorage.setItem('indice_actual', indice);

	var intervencion = gIntervencionesGuardadas ? gIntervencionesGuardadas[indice] : null;

	if(!intervencion && !gBtnNuevoActivado) {
		gPaginacion.insertarPagina(document.importNode(gTempMsjNoInterv, true));
		return;
	}

	gPaginacion.insertarPagina(document.importNode(gTempForm, true));

	gFormEstudios = document.getElementById('contenedor_form').children[0];
	gEstudios = gFormEstudios.getElementsByClassName('estudios');

	if(intervencion.tipo == 'EXTERNO') {
		let secCampania = document.getElementById('datos_campania'),
			secExterno  = document.getElementById('datos_externo');

		secCampania.className = 'oculto';
		secExterno.className = null;
	}

	if(!intervencion.estudios) {
		let tipoInterv = intervencion.tipo,
			extCamp    = tipoInterv == 'CAMPANIA' ? intervencion.campania : intervencion.numero,
			paciente   = intervencion.paciente;

		Utils.ajax(
			'/iiet/intervenciones/estudios_paciente/' + tipoInterv + '/' + extCamp + '/' + paciente,
			[],
			function(e) {
				var respuesta = e.target.response;

				intervencion.campania = respuesta.campania;
				intervencion.externo  = respuesta.externo;
				intervencion.estudios = respuesta.estudios;

				cargarDatosEstudios();
			}
		);
	}

	else {
		cargarDatosEstudios();
	}

	gFormEstudios.fcExito = function(e) {
		gMsjEstado.establecerTexto1('Se han cargado correctamente los datos.');
		gMsjEstado.establecerTexto2('');
		gMsjEstado.mostrar(ObjMensajeEstado.EXITO);

		var indice       = gPaginacion.pagActual - 1,
			intervencion = gIntervencionesGuardadas[indice],
			form         = obtenerTipoForm();

		intervencion.numero = e.target.response;

		Utils.ajax(
			'/iiet/intervenciones/obtener_' + form + '/' + intervencion.numero,
			[],
			function(e) {
				var respuesta = e.target.response;

				if(!intervencion.estudio)
					intervencion.estudio = {};

				intervencion.estudio[form] = respuesta;
				gIntervencionesGuardadas[indice] = intervencion;

				localStorage.setItem('estudios', JSON.stringify(gIntervencionesGuardadas));
			}
		);
	};

	gFormEstudios.fcError = function(e) {
		gMsjEstado.establecerTexto1('Ha ocurrido un error al intentar cargar los datos.');
		gMsjEstado.establecerTexto2('Por favor intentelo nuevamente.');
		gMsjEstado.mostrar(ObjMensajeEstado.ERROR);
	};

	window.setTimeout(function() {
		gPaginacion.children[1].scrollTop = 0;
	}, 100);
});


gBtnSalir.addEventListener('click', e => {
	localStorage.clear();
});

/*window.addEventListener('focus', e => {
	if(!gDatosCampania)
		window.location.reload();
});*/

function cargarDatosEstudios() {
	if(!gFormEstudios)
		return;

	var indice = gPaginacion.pagActual - 1,
		intervencion = gIntervencionesGuardadas[indice];

	if(intervencion.tipo == 'CAMPANIA')
		establecerCampania();

	else
		establecerConsultExt();

	if(gBtnNuevoActivado) {
		gBtnNuevoActivado = false;
		return;
	}

	var estudios = intervencion.estudios,
		algunEstudioRealizado = true;

	if(estudios) {
		switch(gFormEstudios.name) {
			case 'form_copro':
				if(estudios.copro)
					cargarDatosCopro(estudios.copro);

				else
					algunEstudioRealizado = false;
			break;

			case 'form_sangre':
				if(estudios.sangre)
					cargarDatosSangre(estudios.sangre);

				else
					algunEstudioRealizado = false;
			break;

			case 'form_biologmolec':
				if(estudios.biologmolec)
					cargarDatosBiologMolec(estudios.biologmolec);

				else
					algunEstudioRealizado = false;
			break;

			case 'form_tratamiento':
				if(estudios.tratamiento)
					cargarDatosTratamiento(estudios.tratamiento);

				else
					algunEstudioRealizado = false;
			break;
		}

		if(!algunEstudioRealizado) {
			let contenedor = document.getElementById('contenedor_form');

			contenedor.className = 'vacio';
			contenedor.removeChild(contenedor.children[0]);
			contenedor.appendChild(document.importNode(gTempMsjNoEstudio, true));

			let btnCrearEstudio = document.getElementById('crear_estudio');

			btnCrearEstudio.addEventListener('click', function(e) {
				var intervencion = gIntervencionesGuardadas[gPaginacion.pagActual - 1];

				gBtnNuevoActivado = true;
				gPaginacion.establecerPagina(indice + 1);
			});
		}
	}
}

function cargarDatosCopro(copro) {
	gFormEstudios.fecha.value        = copro.fecha;
	gFormEstudios.peso_materia.value = copro.peso_materia;
	gFormEstudios.consistencia.value = copro.consistencia;

	if(copro.concentrado)
		gEstudios[0].cargarDatos(copro.concentrado);

	if(copro.mc_master)
		gEstudios[1].cargarDatos(copro.mc_master);

	if(copro.harada_mori)
		gEstudios[2].cargarDatos(copro.harada_mori);

	if(copro.baerman)
		gEstudios[3].cargarDatos(copro.baerman);

	if(copro.placa_agar)
		gEstudios[4].cargarDatos(copro.placa_agar);
}

function cargarDatosSangre(sangre) {
	gFormEstudios.fecha.value    = sangre.fecha;
	gFormEstudios.nro_tubo.value = sangre.nro_tubo;

	if(sangre.hemograma)
		gEstudios[0].cargarDatos(sangre.hemograma);

	if(sangre.serologia)
		gEstudios[1].cargarDatos(sangre.serologia);
}

function cargarDatosBiologMolec(biologMolec) {
	gFormEstudios.fuente.value = biologMolec.fuente;

	if(biologMolec.pcr)
		gEstudios[0].cargarDatos(biologMolec.pcr);

	if(biologMolec.qpcr)
		gEstudios[1].cargarDatos(biologMolec.qpcr);
}

function cargarDatosTratamiento(tratamiento) {
	gFormEstudios.fecha.value = tratamiento.fecha;

	if(tratamiento.medidas)
		gEstudios[0].cargarDatos(tratamiento.medidas);

	if(tratamiento.tratamiento_previo)
		gEstudios[1].cargarDatos(tratamiento.tratamiento_previo);

	if(tratamiento.mebendazol)
		gEstudios[2].cargarDatos(tratamiento.mebendazol);

	if(tratamiento.albendazol)
		gEstudios[3].cargarDatos(tratamiento.albendazol);

	if(tratamiento.ivermectina)
		gEstudios[4].cargarDatos(tratamiento.ivermectina);
}

var formIntervencion = document.intervencion;

formIntervencion.addEventListener('submit', function(e) {
	e.preventDefault();

	if(formIntervencion.tipo[0].checked)
		window.location.hash = '#form_selec_campania';

	else {
		gFConsultExt.paciente.value = gIdPaciente.value;
		window.location.hash = '#form_consult_ext';
	}
});

function obtenerTipoForm() {
	if(!gFormEstudios)
		return false;

	switch(gFormEstudios.name) {
		case 'form_copro':
			return 'copro';
		break;

		case 'form_sangre':
			return 'sangre';
		break;

		case 'form_biologmolec':
			return 'biologmolec';
		break;

		case 'form_tratamiento':
			return 'tratamiento';
		break;
	}
}