var gBuscPaciente   = document.getElementById('datos_paciente'),
	gBtnSalir       = document.getElementById('btn_salir'),
	wrapperMsjIni   = document.getElementById('wrapper_msj_ini'),
	estadoCarga     = document.getElementById('estado_guardar'),
	gContVMForm     = document.getElementById('cont_vmform'),
	gFSelecCampania = formSelecCampania(gContVMForm),
	gFNuevoPaciente = formNuevoPaciente(gContVMForm),
	gFormEstudios   = document.getElementById('form_estudios'),
	gIdPaciente     = document.getElementById('paciente');

var gEstudiosActuales = document.getElementsByClassName('estudios');

var gEstudiosGuardados = JSON.parse(localStorage.getItem('estudios')),
	gDatosCampania     = JSON.parse(localStorage.getItem('campania')),
	gDatosPaciente     = JSON.parse(localStorage.getItem('paciente'));

var gPart2 = document.getElementById('form_part_2'),
	gPart3 = document.getElementById('form_part_3'),
	gPart4 = document.getElementById('form_part_4');

cargarDatosEstudios();
establecerCampania();
establecerPaciente();

function establecerCampania() {
	if(!gDatosCampania)
		return;

	wrapperMsjIni.style.display = 'none';

	var lugarCampania  = document.getElementById('lugar_campania'),
		nombreCampania = document.getElementById('nombre_campania'),
		campFechaIni   = document.getElementById('camp_f_ini'),
		campFechaFin   = document.getElementById('camp_f_fin');

	lugarCampania.innerHTML  = Utils.toCamelCase(gDatosCampania.tipo_lugar) + ' ' + gDatosCampania.nombre_lugar;
	nombreCampania.innerHTML = gDatosCampania.nombre;
	campFechaIni.innerHTML   = gDatosCampania.fecha_inicio;
	campFechaFin.innerHTML   = gDatosCampania.fecha_fin;

	var campania = document.getElementById('campania'),
		tipo 	 = document.getElementById('tipo');

	campania.value = gDatosCampania.numero;
	tipo.value = gDatosCampania.tipo_lugar;

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
	var respuesta = e.target.response;

	gDatosCampania = respuesta;
	localStorage.setItem('campania', JSON.stringify(respuesta));

	establecerCampania();
	gFSelecCampania.vm.close();
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
		
		gFNuevoPaciente.reset();

		var objPaciente = {
			numero: respuesta.id,
			filtro: selectFiltro.value,
			valor:  gBuscPaciente.value
		};

		localStorage.setItem('paciente', JSON.stringify(objPaciente));
		resetFormEstudios();
	}
};

gFormEstudios.fcExito = e => {
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
	gFormEstudios.reset();

	for(let estudio of gEstudiosActuales)
		estudio.deshabilitar();

	gBuscPaciente.input.focus();
};

gBuscPaciente.fcConfItemSelec = function(datos) {
	gIdPaciente.value = gBuscPaciente.itemSeleccionado.dataset.id;

	Utils.ajax(
		'/iiet/campanias/obtener_estudios_paciente/' + gDatosCampania.numero + '/' + gIdPaciente.value,
		[],
		function(e) {
			gEstudiosGuardados = e.target.response;
			localStorage.setItem('estudios', JSON.stringify(gEstudiosGuardados));

			cargarDatosEstudios();
	});

	localStorage.setItem('paciente', JSON.stringify(datos));
	resetFormEstudios();
};


gBtnSalir.addEventListener('click', e => {
	localStorage.clear();
});

window.addEventListener('focus', e => {
	if(!gDatosCampania)
		window.location.reload();
});

function cargarDatosEstudios() {
	if(gEstudiosGuardados) {
		var estudios = gEstudiosGuardados.estudios;

		switch(gFormEstudios.name) {
			case 'form_copro':
				if(estudios.copro)
					cargarDatosCopro(estudios.copro);
			break;

			case 'form_sangre':
				if(estudios.sangre)
					cargarDatosSangre(estudios.sangre);
			break;

			case 'form_tratamiento':
				if(estudios.tratamiento)
					cargarDatosTratamiento(estudios.tratamiento);
			break;
		}
	}
}

function cargarDatosCopro(copro) {
	gFormEstudios.fecha.value        = copro.fecha;
	gFormEstudios.peso_materia.value = copro.peso_materia;
	gFormEstudios.consistencia.value = copro.consistencia;

	if(copro.concentrado)
		gEstudiosActuales[0].cargarDatos(copro.concentrado);

	if(copro.mc_master)
		gEstudiosActuales[1].cargarDatos(copro.mc_master);

	if(copro.harada_mori)
		gEstudiosActuales[2].cargarDatos(copro.harada_mori);

	if(copro.baerman)
		gEstudiosActuales[3].cargarDatos(copro.baerman);

	if(copro.placa_agar)
		gEstudiosActuales[4].cargarDatos(copro.placa_agar);
}

function cargarDatosSangre(sangre) {
	gFormEstudios.fecha.value    = sangre.fecha;
	gFormEstudios.nro_tubo.value = sangre.nro_tubo;

	if(sangre.hemograma)
		gEstudiosActuales[0].cargarDatos(sangre.hemograma);

	if(sangre.serologia)
		gEstudiosActuales[1].cargarDatos(sangre.serologia);
}

function cargarDatosTratamiento(tratamiento) {
	gFormEstudios.fecha.value = tratamiento.fecha;

	if(tratamiento.no_tratado) {
		gFormEstudios.fue_tratado[1].checked = true;
		ocultarDatosTratamiento();
		gFormEstudios.no_tratado.value = tratamiento.no_tratado;
	}

	else {
		mostrarDatosTratamiento();

		if(tratamiento.medidas)
			gEstudiosActuales[0].cargarDatos(tratamiento.medidas);

		if(tratamiento.tratamiento_previo)
			gEstudiosActuales[1].cargarDatos(tratamiento.tratamiento_previo);

		if(tratamiento.mebendazol)
			gEstudiosActuales[2].cargarDatos(tratamiento.mebendazol);

		if(tratamiento.albendazol)
			gEstudiosActuales[3].cargarDatos(tratamiento.albendazol);

		if(tratamiento.ivermectina)
			gEstudiosActuales[4].cargarDatos(tratamiento.ivermectina);
	}
}

if(gFormEstudios.name == 'form_tratamiento') {
	let radios = gFormEstudios.fue_tratado;
		
	radios[0].addEventListener('change', mostrarDatosTratamiento);

	radios[1].addEventListener('change', ocultarDatosTratamiento);

	mostrarDatosTratamiento();
}

function mostrarDatosTratamiento() {
	gPart2.className = '';
	gPart3.className = '';
	gPart4.className = 'oculto';

	gFormEstudios.no_tratado.disabled = 'disabled';
}

function ocultarDatosTratamiento() {
	gPart2.className = 'oculto';
	gPart3.className = 'oculto';
	gPart4.className = '';

	gEstudiosActuales[0].deshabilitar(); // medidas
	gEstudiosActuales[0].children[0].children[0].checked = false;
	gEstudiosActuales[1].deshabilitar(); // tratamiento previo
	gEstudiosActuales[1].children[0].children[0].checked = false;
	gEstudiosActuales[2].deshabilitar(); // mebendazol
	gEstudiosActuales[2].children[0].children[0].checked = false;
	gEstudiosActuales[3].deshabilitar(); // albendazol
	gEstudiosActuales[3].children[0].children[0].checked = false;
	gEstudiosActuales[4].deshabilitar(); // ivermectina
	gEstudiosActuales[4].children[0].children[0].checked = false;

	gFormEstudios.no_tratado.disabled = null;
}