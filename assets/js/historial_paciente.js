var historia = new ObjFormEstudios();

var gTempForm         = document.getElementById('t_form_estudio').content,
	gTempMsjNoInterv  = document.getElementById('t_msj_no_interv').content,
	gTempMsjNoEstudio = document.getElementById('t_msj_no_estudio').content;

historia.prefijo = 'histpac';

var extPaciente = JSON.parse(localStorage.getItem('ext_paciente'));
historia.iniciar();

if(extPaciente) {
	Utils.ajax(
		'/iiet/intervenciones/intervenciones_paciente/' + extPaciente.numero,
		[],
		function(e) {
			historia.intervGuardadas = e.target.response;
			historia.almacenarInfo('intervenciones', historia.intervGuardadas);

			iniPaginacion(historia.intervGuardadas.length);
	});

	var datosBuscPaciente = {
		numero: extPaciente.numero,
		filtro: 'apynomb',
		valor : extPaciente.apellido + ', ' + extPaciente.nombre
	};

	historia.almacenarInfo('busc_paciente', datosBuscPaciente);
	historia.buscPaciente.establecerValores(datosBuscPaciente);

	localStorage.removeItem('ext_paciente');
}

else {
	historia.intervGuardadas = historia.extraerInfo('intervenciones');

	if(historia.intervGuardadas)
		historia.almacenarInfo('intervenciones', historia.intervGuardadas);
}

historia.paginacion = document.getElementsByTagName('wc-paginacion')[0];
historia.nuevoEstudio = false;

historia.datosBuscPaciente = historia.extraerInfo('busc_paciente');

historia.formSelecIntervencion = document.selec_intervencion;

historia.btnElimInterv  = document.getElementById('eliminar_intervencion');
historia.btnNuevaInterv = document.getElementById('nueva_intervencion');

if(historia.datosBuscPaciente) {
	historia.almacenarInfo('busc_paciente', historia.datosBuscPaciente);

	historia.inputPaciente.value = historia.datosBuscPaciente.numero;
	historia.buscPaciente.establecerValores(historia.datosBuscPaciente);

	historia.btnNuevaInterv.dataset.disabled = '';
}

else {
	historia.btnNuevaInterv.dataset.disabled = 'disabled';
	historia.btnElimInterv.dataset.disabled  = 'disabled';
}

cargarDatosEstudios();

historia.buscPaciente.fcConfItemSelec = function(datos) {
	historia.inputPaciente.value = historia.buscPaciente.itemSeleccionado.dataset.id;

	Utils.ajax(
		'/iiet/intervenciones/intervenciones_paciente/' + historia.inputPaciente.value,
		[],
		function(e) {
			historia.intervGuardadas = e.target.response;
			historia.almacenarInfo('intervenciones', historia.intervGuardadas);

			iniPaginacion(historia.intervGuardadas.length);
			historia.btnNuevaInterv.dataset.disabled = '';
	});

	historia.almacenarInfo('busc_paciente', datos);
	historia.reset();
};

historia.fSelecCampania.fcExito = function(e) {
	var respuesta = e.target.response;

	var indice       = historia.intervGuardadas.length,
		intervencion = {
			numero  : null,
			fecha   : respuesta.fecha_inicio,
			paciente: historia.inputPaciente.value,
			tipo    : 'CAMPANIA',
			campania: respuesta.numero,
			externo : null
		};

	cargarNuevaInterv(intervencion);

	historia.intervGuardadas[indice] = intervencion;
	historia.inputInterv.disabled = 'disabled';

	historia.fSelecCampania.vm.close();
};

historia.fSelecCampania.fcError = function(e) {
	historia.msjEstado.establecerTexto1('Ha ocurrido un error al seleccionar la campaña.');
	historia.msjEstado.establecerTexto2('');
	historia.msjEstado.mostrar(ObjMensajeEstado.ERROR);
};

historia.fConsultExt.fcExito = function(e) {
	var idInterv     = e.target.response,
		intervencion = {
			numero  : idInterv,
			fecha   : historia.fConsultExt.fecha.value,
			paciente: historia.fConsultExt.paciente.value,
			tipo    : 'EXTERNO',
			campania: null,
			externo : null
		};

	cargarNuevaInterv(intervencion);

	historia.inputInterv.disabled = null;
	historia.inputInterv.value = idInterv;

	historia.msjEstado.establecerTexto1('Se ha creado correctamente la intervención');
	historia.msjEstado.establecerTexto2('por consultorio externo.');
	historia.msjEstado.mostrar(ObjMensajeEstado.EXITO);

	historia.mostrarBtnAccion('diagPresunt');

	historia.fConsultExt.vm.close();
};

historia.fConsultExt.fcError = function(e) {
	historia.msjEstado.establecerTexto1('Ha ocurrido un error al crear la intervención');
	historia.msjEstado.establecerTexto2('por consultorio externo.');
	historia.msjEstado.mostrar(ObjMensajeEstado.ERROR);
};

historia.fNuevoPaciente.fcExito = function(e) {
	historia.nuevoPacienteExito(e.target.response);
	historia.intervGuardadas = [];

	iniPaginacion(1);
};

historia.fNuevoPaciente.fcError = function(e) {
	historia.nuevoPacienteError();
};

function cargarNuevaInterv(intervencion) {
	var cantInterv = historia.intervGuardadas.length;

	historia.nuevoEstudio = true;

	if(cantInterv > 0) {
		historia.intervGuardadas[cantInterv] = intervencion;

		historia.paginacion.establecerCantPaginas(cantInterv + 1);
		historia.paginacion.establecerPagina(cantInterv + 1);
	}

	else {
		historia.intervGuardadas[0] = intervencion;

		historia.paginacion.establecerCantPaginas(1);
		historia.paginacion.establecerPagina(1);
	}

	historia.almacenarInfo('intervenciones', historia.intervGuardadas);
}

function iniPaginacion(indiceInicial) {
	if(historia.intervGuardadas.length > 0) {
		historia.paginacion.establecerCantPaginas(historia.intervGuardadas.length);
		historia.paginacion.establecerPagina(indiceInicial);
	}

	else {
		historia.paginacion.establecerCantPaginas(1);
		historia.paginacion.establecerPagina(1);
	}
}

historia.paginacion.manejadorEventoPaginacion(function(indice) {
	--indice;
	historia.almacenarInfo('indice_actual', indice);

	var intervencion = historia.intervGuardadas.length > 0 ? historia.intervGuardadas[indice] : null;

	if(!intervencion && !historia.nuevoEstudio) {
		historia.paginacion.insertarPagina(document.importNode(gTempMsjNoInterv, true));
		historia.btnNuevaInterv.dataset.disabled = '';
		historia.btnElimInterv.dataset.disabled  = 'disabled';
		return;
	}

	historia.paginacion.insertarPagina(document.importNode(gTempForm, true));

	historia.establecerForm(document.getElementById('contenedor_form').children[0]);

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

	establecerCallbacksForm();

	if(intervencion.numero)
		historia.btnElimInterv.dataset.disabled = '';
	else
		historia.btnElimInterv.dataset.disabled = 'disabled';

	window.setTimeout(function() {
		historia.paginacion.children[1].scrollTop = 0;
	}, 200);
});

function cargarDatosEstudios() {
	if(!historia.form)
		return;

	var indice       = historia.paginacion.pagActual - 1,
		intervencion = historia.intervGuardadas[indice];
console.log(intervencion);
	if(intervencion.tipo == 'CAMPANIA') {
		console.log("campania");
		historia.cargarDatosCampania(intervencion.campania);
	}

	else {
		console.log("externo");
		historia.cargarDatosConsultExt(intervencion.externo);
	}

	if(intervencion.estudios) {
		let algunEstudioRealizado = historia.cargarDatosEstudios(intervencion.estudios);

		if(!algunEstudioRealizado) {
			let contenedor = document.getElementById('contenedor_form');

			contenedor.className = 'vacio';
			contenedor.removeChild(contenedor.children[0]);
			contenedor.appendChild(document.importNode(gTempMsjNoEstudio, true));

			historia.form = null;

			let btnCrearEstudio = document.getElementById('crear_estudio');

			btnCrearEstudio.addEventListener('click', function(e) {
				var intervencion = historia.intervGuardadas[historia.paginacion.pagActual - 1];

				historia.nuevoEstudio = true;

				historia.paginacion.insertarPagina(document.importNode(gTempForm, true));

				if(intervencion.tipo == 'CAMPANIA')
					historia.cargarDatosCampania(intervencion.campania);

				else
					historia.cargarDatosConsultExt(intervencion.externo);

				historia.establecerForm(document.getElementById('contenedor_form').children[0]);
				establecerCallbacksForm();
			});
		}
	}
}

window.addEventListener('load', e => {
	var top = Utils.getTop(historia.paginacion);

	historia.paginacion.style.height = (window.innerHeight - top) + 'px';

	if(historia.intervGuardadas) {
		var indice = historia.extraerInfo('indice_actual') - 0;

		iniPaginacion(indice + 1);
	}

	historia.buscPaciente.input.focus();
});

historia.formSelecIntervencion.addEventListener('submit', function(e) {
	e.preventDefault();

	if(historia.formSelecIntervencion.tipo[0].checked)
		window.location.hash = '#form_selec_campania';

	else {
		historia.fConsultExt.paciente.value = historia.inputPaciente.value;
		window.location.hash = '#form_consult_ext';
	}
});

function establecerCallbacksForm() {
	if(!historia.form)
		return;

	historia.form.fcExito = function(e) {
		historia.msjEstado.establecerTexto1('Se han cargado correctamente los datos.');
		historia.msjEstado.establecerTexto2('');
		historia.msjEstado.mostrar(ObjMensajeEstado.EXITO);

		var indice       = historia.paginacion.pagActual - 1,
			intervencion = historia.intervGuardadas[indice];

		intervencion.numero = e.target.response;

		Utils.ajax(
			'/iiet/intervenciones/obtener_' + historia.tipoForm + '/' + intervencion.numero,
			[],
			function(e) {
				var respuesta = e.target.response;

				if(!intervencion.estudios)
					intervencion.estudios = {};

				intervencion.estudios[historia.tipoForm] = respuesta;
				historia.intervGuardadas[indice] = intervencion;

				historia.almacenarInfo('intervenciones', historia.intervGuardadas);
				historia.nuevoEstudio = false;
			}
		);
	};

	historia.form.fcError = function(e) {
		historia.msjEstado.establecerTexto1('Ha ocurrido un error al intentar cargar los datos.');
		historia.msjEstado.establecerTexto2('Por favor intentelo nuevamente.');
		historia.msjEstado.mostrar(ObjMensajeEstado.ERROR);
	};
}

var vmElimInterv = document.getElementById('vm_confirmar_eliminacion'),
	boxBtnsElim  = vmElimInterv.getElementsByClassName('btn_submit')[0],
	btnElimSi    = boxBtnsElim.children[0],
	btnElimNo    = boxBtnsElim.children[1];

btnElimSi.addEventListener('click', function(e) {
	var indice       = historia.extraerInfo('indice_actual'),
		intervencion = historia.intervGuardadas[indice];

	Utils.ajax(
		'/iiet/intervenciones/eliminar/' + intervencion.numero,
		[],
		function(e) {
			vmElimInterv.close();

			historia.msjEstado.establecerTexto1('Se ha eliminado correctamente la intervención.');
			historia.msjEstado.establecerTexto2('');
			historia.msjEstado.mostrar(ObjMensajeEstado.EXITO);

			historia.intervGuardadas.splice(indice, 1);

			var nuevoIndice = indice > 0 ? indice - 1 : 0;

			historia.almacenarInfo('intervenciones', historia.intervGuardadas);
			historia.almacenarInfo('indice_actual', nuevoIndice);

			iniPaginacion(nuevoIndice + 1);
		},
		function(e) {
			historia.msjEstado.establecerTexto1('Ha ocurrido un error al intentar eliminar la intervención.');
			historia.msjEstado.establecerTexto2('');
			historia.msjEstado.mostrar(ObjMensajeEstado.ERROR);
		}
	);
});

btnElimNo.addEventListener('click', function(e) {
	vmElimInterv.close();
});