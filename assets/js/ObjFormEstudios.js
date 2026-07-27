function ObjFormEstudios() {
	this.form = null;
	this.formEstudios = [];

	this.part2 = null;
	this.part3 = null;
	this.part4 = null;

	this.intervenciones = null;
	this.prefijo = '';
	this.idPaciente = null;

	// formularios asincronos
	this.fSelecCampania = null;
	this.fNuevoPaciente = null;
	this.fConsultExt    = null;

	this.buscPaciente   = null;

	this.tipoForm = null;
	this.datosBuscPaciente = null;

	this.msjEstado = null;

	// campos ocultos del formulario
	this.inputPaciente = null;
	this.inputCampania = null;
	this.inputInterv   = null;

	this.btnAccion = {
		salir: null,
		guardar: null,
		copro: null,
		sangre: null,
		biologMolec: null,
		tratamiento: null,
		diagPresunt: null
	};

	this.nuevoEstudio = false;
	this.clavesInfo   = new Array();
	this.redireccion  = null;
}

ObjFormEstudios.prototype.construct = ObjFormEstudios;

ObjFormEstudios.prototype.iniciar = function() {
	var contVMForm = document.getElementById('objform_cont_vm'),
		self       = this;

	this.inputPaciente  = document.getElementById('objform_paciente');
	this.inputCampania  = document.getElementById('objform_campania');
	this.inputInterv    = document.getElementById('objform_interv');

	this.btnAccion.salir       = document.getElementById('btn_salir');
	this.btnAccion.copro       = document.getElementById('link_copro');
	this.btnAccion.sangre      = document.getElementById('link_sangre');
	this.btnAccion.biologMolec = document.getElementById('link_biologmolec');
	this.btnAccion.tratamiento = document.getElementById('link_tratamientos');
	this.btnAccion.diagPresunt = document.getElementById('link_diagpresunt');

	this.fSelecCampania = formSelecCampania(contVMForm);
	this.fNuevoPaciente = formNuevoPaciente(contVMForm);
	this.fConsultExt    = formConsultExt(contVMForm);

	this.btnAccion.salir.addEventListener('click', e => salir.call(self, e));
	this.btnAccion.copro.addEventListener('click', e => salir.call(self, e));
	this.btnAccion.sangre.addEventListener('click', e => salir.call(self, e));
	this.btnAccion.biologMolec.addEventListener('click', e => salir.call(self, e));
	this.btnAccion.tratamiento.addEventListener('click', e => salir.call(self, e));

	if(this.btnAccion.diagPresunt)
		this.btnAccion.diagPresunt.addEventListener('click', e => salir.call(self, e));

	this.buscPaciente   = document.getElementsByClassName('objform_busc_paciente')[0];
	this.buscPaciente.fNuevoPaciente = this.fNuevoPaciente;

	this.msjEstado      = new ObjMensajeEstado();

	var vmConfirmSalida   = document.getElementById('vm_confirmar_salida'),
		btnsConfirmSalida = vmConfirmSalida.getElementsByClassName('btn_submit')[0];

	btnsConfirmSalida.children[0].addEventListener('click', e => redireccionar.call(self)); // botón Sí
	btnsConfirmSalida.children[1].addEventListener('click', e => vmConfirmSalida.close()); // botón No

	this.fNuevoPaciente.setOnPreSubmit(function() {
		var submit = this.querySelector('input[type=submit]');

		submit.className = 'load';
		submit.disabled  = 'disabled';
	});
};

ObjFormEstudios.prototype.cargarDatosPaciente = function() {
	if(!this.datosPaciente)
		return;

	this.buscPaciente.seleccionItemList();

	this.buscPaciente.input.value = this.datosPaciente.valor;
	this.buscPaciente.selectFiltro.value = this.datosPaciente.filtro;

	this.buscPaciente.listaOpciones.className += ' oculto';
	this.buscPaciente.listaOpciones.innerHTML = '';

	this.inputPaciente.value = this.datosPaciente.numero;
};

ObjFormEstudios.prototype.cargarDatosCampania = function(campania) {
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

	this.inputCampania.value  = campania.numero;
	this.inputInterv.disabled = 'disabled';

	this.ocultarBtnAccion('diagPresunt');

	this.buscPaciente.focus();
};

ObjFormEstudios.prototype.cargarDatosConsultExt = function(externo) {
	console.log("dentro de cargarDatosConsultExt");
	if(!externo)
		return;
console.log("cargando datos...");
	var secCampania = document.getElementById('datos_campania'),
		secExterno  = document.getElementById('datos_externo');

	secCampania.className = 'oculto';
	secExterno.className = null;

	var fechaExterno       = document.getElementById('fecha_externo'),
		procedenciaExterno = document.getElementById('procedencia_externo');

	fechaExterno.textContent       = externo.fecha;
	procedenciaExterno.textContent = externo.procedencia;

	this.inputInterv.disabled = null;
	this.inputInterv.value    = externo.intervencion;

	historia.mostrarBtnAccion('diagPresunt');

	this.buscPaciente.focus();
};

ObjFormEstudios.prototype.establecerForm = function(form) {
	var self = this;

	this.form = form;
	this.formEstudios = this.form.getElementsByClassName('estudios');

	this.part2 = document.getElementById('form_part_2');
	this.part3 = document.getElementById('form_part_3');
	this.part4 = document.getElementById('form_part_4');

	this.establecerTipoForm();

	if(this.tipoForm == 'copro') {
		var btnPositividad = document.getElementById('positividad');

		btnPositividad.addEventListener('click', function(e) {
			document.getElementById('datos_positividad').className = '';
		});
	}

	else if(this.tipoForm == 'tratamiento') {
		let radios = this.form.fue_tratado;

		radios[0].addEventListener('change', e => self.mostrarDatosTratamiento());

		radios[1].addEventListener('change', e => self.ocultarDatosTratamiento());

		this.mostrarDatosTratamiento();
	}
};

ObjFormEstudios.prototype.cargarDatosEstudios = function(estudios) {
	if(!estudios)
		return;

	switch(this.tipoForm) {
		case 'copro':
			if(estudios.copro)
				this.cargarDatosCopro(estudios.copro);
		break;

		case 'sangre':
			if(estudios.sangre)
				this.cargarDatosSangre(estudios.sangre);
		break;

		case 'biologmolec':
			if(estudios.biologmolec)
				this.cargarDatosBiologMolec(estudios.biologmolec);
		break;

		case 'tratamiento':
			if(estudios.tratamiento)
				this.cargarDatosTratamiento(estudios.tratamiento);
		break;

		case 'diagpresunt':
			if(estudios.diagpresunt)
				this.cargarDatosDiagPresunt(estudios.diagpresunt);
		break;
	}

	return estudios[this.tipoForm] ? true : false;
};

ObjFormEstudios.prototype.cargarDatosCopro = function(copro) {
	this.form.fecha.value        = copro.fecha;
	this.form.peso_materia.value = copro.peso_materia;
	this.form.consistencia.value = copro.consistencia;
	this.form.nro_muestra.value  = copro.nro_muestra;

	var result_ascaris       = null,
		result_uncinarias    = null,
		result_ancylostoma   = null,
		result_necator       = null,
		result_strongyloides = null,
		result_trichuris     = null;

	if(copro.concentrado) {
		this.formEstudios[0].cargarDatos(copro.concentrado);

		result_ascaris       = copro.concentrado.ascaris == 'POSITIVO';
		result_uncinarias    = copro.concentrado.uncinarias == 'POSITIVO';
		result_strongyloides = copro.concentrado.strongyloides == 'POSITIVO';
		result_trichuris     = copro.concentrado.trichuris == 'POSITIVO';
	}

	if(copro.mc_master) {
		this.formEstudios[1].cargarDatos(copro.mc_master);

		if(copro.concentrado) {
			result_ascaris    = result_ascaris || (copro.mc_master.ascaris > 0);
			result_uncinarias = result_uncinarias || (copro.mc_master.uncinarias > 0);
		}

		else {
			result_ascaris    = copro.mc_master.ascaris > 0;
			result_uncinarias = copro.mc_master.uncinarias > 0;
		}
	}

	if(copro.harada_mori) {
		this.formEstudios[2].cargarDatos(copro.harada_mori);

		result_ancylostoma = copro.harada_mori.ancylostoma != 'NEGATIVO';
		result_necator     = copro.harada_mori.necator != 'NEGATIVO';

		if(copro.concentrado || copro.mc_master) {
			result_uncinarias = result_uncinarias || result_ancylostoma || result_necator;

			if(copro.concentrado)
				result_strongyloides = result_strongyloides || (copro.harada_mori.strongyloides != 'NEGATIVO');
		}

		else
			result_strongyloides = copro.harada_mori.strongyloides != 'NEGATIVO';
	}

	if(copro.baerman) {
		this.formEstudios[3].cargarDatos(copro.baerman);

		result_ancylostoma = copro.baerman.ancylostoma != 'NEGATIVO';
		result_necator     = copro.baerman.necator != 'NEGATIVO';

		if(copro.concentrado || copro.mc_master || copro.harada_mori) {
			result_uncinarias = result_uncinarias || result_ancylostoma || result_necator;

			if(copro.concentrado || copro.harada_mori)
				result_strongyloides = result_strongyloides || (copro.baerman.strongyloides != 'NEGATIVO');
		}

		else
			result_strongyloides = copro.baerman.strongyloides != 'NEGATIVO';
	}

	if(copro.placa_agar) {
		this.formEstudios[4].cargarDatos(copro.placa_agar);

		result_ancylostoma = copro.placa_agar.ancylostoma != 'NEGATIVO';
		result_necator     = copro.placa_agar.necator != 'NEGATIVO';

		if(copro.concentrado || copro.mc_master || copro.harada_mori || copro.baerman) {
			result_uncinarias = result_uncinarias || result_ancylostoma || result_necator;

			if(copro.concentrado || copro.harada_mori || copro.baerman)
				result_strongyloides = result_strongyloides || (copro.placa_agar.strongyloides != 'NEGATIVO');
		}

		else
			result_strongyloides = copro.placa_agar.strongyloides != 'NEGATIVO';
	}

	var datosPositividad = document.getElementById('datos_positividad').children[1].children;

	datosPositividad[0].children[0].className = obtenerClassName(result_ascaris);
	datosPositividad[1].children[0].className = obtenerClassName(result_uncinarias);
	datosPositividad[2].children[0].className = obtenerClassName(result_ancylostoma);
	datosPositividad[3].children[0].className = obtenerClassName(result_necator);
	datosPositividad[4].children[0].className = obtenerClassName(result_strongyloides);
	datosPositividad[5].children[0].className = obtenerClassName(result_trichuris);
};

function obtenerClassName(resultado) {
	return resultado ? 'result_positivo'
		: (resultado === false ? 'result_negativo' : 'no_realizado');
}

ObjFormEstudios.prototype.cargarDatosSangre = function(sangre) {
	this.form.fecha.value    = sangre.fecha;
	this.form.nro_tubo.value = sangre.nro_tubo;

	if(sangre.hemograma)
		this.formEstudios[0].cargarDatos(sangre.hemograma);

	if(sangre.serologia)
		this.formEstudios[1].cargarDatos(sangre.serologia);
};

ObjFormEstudios.prototype.cargarDatosBiologMolec = function(biologMolec) {
	this.form.fuente.value = biologMolec.fuente;

	if(biologMolec.pcr)
		this.formEstudios[0].cargarDatos(biologMolec.pcr);

	if(biologMolec.qpcr)
		this.formEstudios[1].cargarDatos(biologMolec.qpcr);
};

ObjFormEstudios.prototype.cargarDatosTratamiento = function(tratamiento) {
	this.form.fecha.value = tratamiento.fecha;

	if(tratamiento.no_tratado) {
		this.form.fue_tratado[1].checked = true;
		this.ocultarDatosTratamiento();
		this.form.no_tratado.value = tratamiento.no_tratado;
	}

	else {
		this.mostrarDatosTratamiento();

		if(tratamiento.medidas)
			this.formEstudios[0].cargarDatos(tratamiento.medidas);

		if(tratamiento.tratamiento_previo)
			this.formEstudios[1].cargarDatos(tratamiento.tratamiento_previo);

		if(tratamiento.mebendazol)
			this.formEstudios[2].cargarDatos(tratamiento.mebendazol);

		if(tratamiento.albendazol)
			this.formEstudios[3].cargarDatos(tratamiento.albendazol);

		if(tratamiento.ivermectina)
			this.formEstudios[4].cargarDatos(tratamiento.ivermectina);
	}
};

ObjFormEstudios.prototype.cargarDatosDiagPresunt = function(diagPresunt) {
	this.formEstudios[0].cargarDatos(diagPresunt);
};

ObjFormEstudios.prototype.mostrarDatosTratamiento = function() {
	this.part2.className = '';
	this.part3.className = '';
	this.part4.className = 'oculto';

	this.form.no_tratado.disabled = 'disabled';
};

ObjFormEstudios.prototype.ocultarDatosTratamiento = function() {
	this.part2.className = 'oculto';
	this.part3.className = 'oculto';
	this.part4.className = '';

	this.formEstudios[0].deshabilitar(); // medidas
	this.formEstudios[0].children[0].children[0].checked = false;
	this.formEstudios[1].deshabilitar(); // tratamiento previo
	this.formEstudios[1].children[0].children[0].checked = false;
	this.formEstudios[2].deshabilitar(); // mebendazol
	this.formEstudios[2].children[0].children[0].checked = false;
	this.formEstudios[3].deshabilitar(); // albendazol
	this.formEstudios[3].children[0].children[0].checked = false;
	this.formEstudios[4].deshabilitar(); // ivermectina
	this.formEstudios[4].children[0].children[0].checked = false;

	this.form.no_tratado.disabled = null;
};

ObjFormEstudios.prototype.establecerTipoForm = function() {
	if(!this.form) 
		return;

	switch(this.form.name) {
		case 'form_copro':
			this.tipoForm = 'copro';
		break;

		case 'form_sangre':
			this.tipoForm = 'sangre';
		break;

		case 'form_biologmolec':
			this.tipoForm = 'biologmolec';
		break;

		case 'form_tratamiento':
			this.tipoForm = 'tratamiento';
		break;

		case 'form_diagpresunt':
			this.tipoForm = 'diagpresunt';
		break;
	}
};

ObjFormEstudios.prototype.reset = function() {
	if(!this.form)
		return;

	this.form.reset();

	for(let estudio of this.formEstudios)
		estudio.deshabilitar();

	this.buscPaciente.input.focus();
};

ObjFormEstudios.prototype.almacenarInfo = function(clave, valor) {
	var nuevaClave = this.prefijo + '_' + clave;

	this.clavesInfo.push(nuevaClave);
	localStorage.setItem(nuevaClave, JSON.stringify(valor));
};

ObjFormEstudios.prototype.extraerInfo = function(clave) {
	var strJSON = localStorage.getItem(this.prefijo + '_' + clave);

	return JSON.parse(strJSON);
};

ObjFormEstudios.prototype.borrarInfo = function() {
	for(let clave of this.clavesInfo)
		localStorage.removeItem(clave);

	this.clavesInfo = new Array();
};

ObjFormEstudios.prototype.ocultarBtnAccion = function(btn) {
	if(this.btnAccion[btn])
		this.btnAccion[btn].className = 'oculto';
};

ObjFormEstudios.prototype.mostrarBtnAccion = function(btn) {
	this.btnAccion[btn].className = '';
};

ObjFormEstudios.prototype.nuevoPacienteExito = function(respuesta) {
	var formPaciente = this.fNuevoPaciente;

	if(respuesta !== false) {
		let apellido = formPaciente.apellido.value,
			nombre   = formPaciente.nombre.value,
			dni      = formPaciente.dni.value;

		this.inputPaciente.value = respuesta.id;

		this.buscPaciente.selectFiltro.selectedIndex = 0;
		this.buscPaciente.input.value = apellido + ', ' + nombre;
		this.buscPaciente.input.focus();

		if(formPaciente.modo == formPaciente.NUEVO) {
			this.msjEstado.establecerTexto1('Se han cargado correctamente los datos del paciente:');
			this.msjEstado.establecerTexto2(this.buscPaciente.input.value + ' (' + dni + ')');
		}

		else if(formPaciente.modo == formPaciente.ACTUALIZAR) {
			this.msjEstado.establecerTexto1('Se han actualizado correctamente los datos del paciente:');
			this.msjEstado.establecerTexto2(this.buscPaciente.input.value + ' (' + dni + ')');
		}

		this.msjEstado.mostrar(ObjMensajeEstado.EXITO);
		
		formPaciente.vm.close();

		var objPaciente = {
			numero: respuesta.id,
			filtro: this.buscPaciente.selectFiltro.value,
			valor:  this.buscPaciente.input.value
		};

		this.borrarInfo();
		this.almacenarInfo('busc_paciente', objPaciente);
		this.reset();

		var submitPaciente = formPaciente.querySelector('input[type=submit]');

		submitPaciente.className = null;
		submitPaciente.disabled  = '';
	}
};

ObjFormEstudios.prototype.nuevoPacienteError = function() {
	var formPaciente = this.fNuevoPaciente;

	if(formPaciente.modo == formPaciente.NUEVO)
		this.msjEstado.establecerTexto1('Ha ocurrido un error al cargar los datos del paciente.');

	else if(formPaciente.modo == formPaciente.ACTUALIZAR)
		this.msjEstado.establecerTexto1('Ha ocurrido un error al actualizar los datos del paciente.');
	
	this.msjEstado.establecerTexto2('Por favor intentelo nuevamente.');
	this.msjEstado.mostrar(ObjMensajeEstado.ERROR);
};

function salir(e) {
	var target = e.target;

	this.redireccion = target.dataset.href;

	if(this.nuevoEstudio) {
		window.location.hash = '#vm_confirmar_salida';
	}

	else
		redireccionar.call(this);
}

function redireccionar() {
	if(this.redireccion) {
		if(this.redireccion == '/iiet')
			this.borrarInfo();

		window.location = this.redireccion;
	}
}