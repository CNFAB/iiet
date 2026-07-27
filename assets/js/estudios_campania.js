var estudiosCampania = new ObjFormEstudios();

estudiosCampania.prefijo = 'estcamp';

estudiosCampania.estudiosGuardados = estudiosCampania.extraerInfo('estudios');
estudiosCampania.iniciar();
estudiosCampania.datosBuscPaciente = estudiosCampania.extraerInfo('busc_paciente');

estudiosCampania.establecerForm(document.getElementById('contenedor_form').children[3]);
estudiosCampania.msjSelecCampania = document.getElementById('wrapper_msj_ini');

var campania = estudiosCampania.extraerInfo('campania');

if(campania) {
	estudiosCampania.almacenarInfo('campania', campania);

	estudiosCampania.cargarDatosCampania(campania);
	estudiosCampania.msjSelecCampania.className = 'oculto';
}

if(estudiosCampania.datosBuscPaciente) {
	estudiosCampania.almacenarInfo('busc_paciente', estudiosCampania.datosBuscPaciente);

	estudiosCampania.inputPaciente.value = estudiosCampania.datosBuscPaciente.numero;
	estudiosCampania.buscPaciente.establecerValores(estudiosCampania.datosBuscPaciente);
}

if(estudiosCampania.estudiosGuardados) {
	estudiosCampania.almacenarInfo('estudios', estudiosCampania.estudiosGuardados);
	estudiosCampania.cargarDatosEstudios(estudiosCampania.estudiosGuardados);
}

estudiosCampania.buscPaciente.fcConfItemSelec = function(datos) {
	estudiosCampania.inputPaciente.value = estudiosCampania.buscPaciente.itemSeleccionado.dataset.id;

	var campania = estudiosCampania.inputCampania.value,
		paciente = estudiosCampania.inputPaciente.value;

	Utils.ajax(
		'/iiet/intervenciones/estudios_paciente/CAMPANIA/' + campania + '/' + paciente,
		[],
		function(e) {
			var respuesta = e.target.response;

			if(respuesta)
				estudiosCampania.estudiosGuardados = respuesta.estudios;

			estudiosCampania.almacenarInfo('estudios', estudiosCampania.estudiosGuardados);
			estudiosCampania.cargarDatosEstudios(estudiosCampania.estudiosGuardados);
		}
	);

	estudiosCampania.almacenarInfo('busc_paciente', datos);
	estudiosCampania.reset();
};

estudiosCampania.fSelecCampania.fcExito = function(e) {
	var campania = e.target.response;

	estudiosCampania.msjSelecCampania.className = 'oculto';

	estudiosCampania.almacenarInfo('campania', campania);
	estudiosCampania.cargarDatosCampania(campania);

	estudiosCampania.fSelecCampania.vm.close();
};

estudiosCampania.fSelecCampania.fcError = function(e) {
	estudiosCampania.msjEstado.establecerTexto1('Ha ocurrido un error al seleccionar la campaña.');
	estudiosCampania.msjEstado.establecerTexto2('');
	estudiosCampania.msjEstado.mostrar(ObjMensajeEstado.ERROR);
};

estudiosCampania.fNuevoPaciente.fcExito = function(e) {
	estudiosCampania.nuevoPacienteExito(e.target.response);
	estudiosCampania.estudiosGuardados = null;
};

estudiosCampania.fNuevoPaciente.fcError = function(e) {
	estudiosCampania.nuevoPacienteError();
};

estudiosCampania.form.fcExito = function(e) {
	estudiosCampania.msjEstado.establecerTexto1('Se han cargado correctamente los datos.');
	estudiosCampania.msjEstado.establecerTexto2('');
	estudiosCampania.msjEstado.mostrar(ObjMensajeEstado.EXITO);

	var nroInterv = e.target.response;

	Utils.ajax(
		'/iiet/intervenciones/obtener_' + estudiosCampania.tipoForm + '/' + nroInterv,
		[],
		function(e) {
			var respuesta = e.target.response;

			if(!estudiosCampania.estudiosGuardados)
				estudiosCampania.estudiosGuardados = {};

			estudiosCampania.estudiosGuardados[estudiosCampania.tipoForm] = respuesta;

			estudiosCampania.almacenarInfo('estudios', estudiosCampania.estudiosGuardados);
		}
	);
};

estudiosCampania.form.fcError = function(e) {
	estudiosCampania.msjEstado.establecerTexto1('Ha ocurrido un error al intentar cargar los datos.');
	estudiosCampania.msjEstado.establecerTexto2('Por favor intentelo nuevamente.');
	estudiosCampania.msjEstado.mostrar(ObjMensajeEstado.ERROR);
};