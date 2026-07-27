var tablaCampanias    = document.getElementById('tabla_campanias'),
	tablaPacientes    = document.getElementById('tabla_pacientes'),
	tablaCopro        = document.getElementById('tabla_copro'),
	tablaSangre       = document.getElementById('tabla_sangre'),
	tablaBiologMolec  = document.getElementById('tabla_biolog_molec'),
	tablaTratamientos = document.getElementById('tabla_tratamientos'),
	tablaFinal        = document.getElementById('tabla_final');

var formCampania           = document.form_campania,
	formFechaInicio        = document.form_f_ini,
	formFechaFin           = document.form_f_fin,
	formTipo               = document.form_tipo_campania,
	formEscuela            = document.form_escuela,
	formBarrio             = document.form_barrio,
	formPuesto             = document.form_puesto,
	formParaje             = document.form_paraje,
	formLocalidad          = document.form_localidad,
	formSexo               = document.form_sexo,
	formEdad               = document.form_edad,
	formBarrioPaciente     = document.form_barrio_paciente,
	formPuestoPaciente     = document.form_puesto_paciente,
	formParajePaciente     = document.form_paraje_paciente,
	formLocalidadPaciente  = document.form_localidad_paciente,
	formFechaCopro         = document.form_fecha_copro,
	formPesoCopro          = document.form_peso_copro,
	formConsistencia       = document.form_consistencia_copro,
	formAscarisConc        = document.form_ascaris_conc,
	formGiardiaConc        = document.form_giardia_conc,
	formEntamoebacoliConc  = document.form_entamoebacoli_conc,
	formUncinariasConc     = document.form_uncinarias_conc,
	formStrongyloidesConc  = document.form_strongyloides_conc,
	formHymenolepisConc    = document.form_hymenolepis_conc,
	formTrichurisConc      = document.form_trichuris_conc,
	formEnterobiusConc     = document.form_entrobius_conc,
	formTaeniaConc         = document.form_taenia_conc,
	formAscarisMM          = document.form_ascaris_mm,
	formUncinariasMM       = document.form_uncinarias_mm,
	formHymenolepisMM      = document.form_hymenolepis_mm,
	formTrichurisMM        = document.form_trichuris_mm,
	formEnterobiusMM       = document.form_enterobius_mm,
	formTaeniaMM           = document.form_taenia_mm,
	formStrongyloidesHM    = document.form_strongyloides_hm,
	formAncylostomaHM      = document.form_ancylostoma_hm,
	formNecatorHM          = document.form_necator_hm,
	formEnterobiusHM       = document.form_enterobius_hm,
	formStrongyloidesBM    = document.form_strongyloides_bm,
	formAncylostomaBM      = document.form_ancylostoma_bm,
	formNecatorBM          = document.form_necator_bm,
	formStrongyloidesPA    = document.form_strongyloides_pa,
	formAncylostomaPA      = document.form_ancylostoma_pa,
	formNecatorPA          = document.form_necator_pa,
	formFechaSangre        = document.form_fecha_sangre,
	formGlobulosBlancos    = document.form_globulos_blancos,
	formHemoglobina        = document.form_hemoglobina,
	formEosinofilos        = document.form_eosinofilos,
	formTituloSerologia    = document.form_titulo_serologia,
	formResultadoSerologia = document.form_resultado_serologia,
	formFechaTratamiento   = document.form_fecha_tratamiento,
	formNoTratado          = document.form_no_tratado,
	formPesoPaciente       = document.form_peso_paciente,
	formTallaPaciente      = document.form_talla_paciente,
	formPerimCefalico      = document.form_perimetro_paciente,
	formFechaTratPrevio    = document.form_fecha_trat_prev,
	formAlbendTratPrevio   = document.form_albendazol_trat_prev,
	formIvermecTratPrevio  = document.form_ivermectina_trat_prev,
	formMebendTratPrevio   = document.form_mebendazol_trat_prev,
	formMetrodinTratPrevio = document.form_metrodinazol_trat_prev,
	formDosisAlbendazol    = document.form_dosis_albendazol,
	formMotivExcAlbend     = document.form_mot_exc_albendazol,
	formDosisIvermectina   = document.form_dosis_ivermectina,
	formMotivExcIvermct    = document.form_mot_exc_ivermectina,
	formDosisMebendazol    = document.form_dosis_mebendazol,
	formMotivExcMebend     = document.form_mot_exc_mebendazol;

var btnFechaIni         = document.getElementById('btn_nueva_f_ini'),
	btnFechaFin         = document.getElementById('btn_nueva_f_fin'),
	btnEdad             = document.getElementById('btn_edad'),
	btnPesoCopro        = document.getElementById('btn_nuevo_peso_copro'),
	btnFechaCopro       = document.getElementById('btn_nueva_f_copro'),
	btnAscarisMM        = document.getElementById('btn_nuevo_ascaris_mm'),
	btnUncinariasMM     = document.getElementById('btn_nuevo_uncinarias_mm'),
	btnHymenolepisMM    = document.getElementById('btn_nuevo_hymenolepis_mm'),
	btnTrichurisMM      = document.getElementById('btn_nuevo_trichuris_mm'),
	btnEnterobiusMM     = document.getElementById('btn_nuevo_enterobius_mm'),
	btnTaeniaMM         = document.getElementById('btn_nuevo_taenia_mm'),
	btnFechaSangre      = document.getElementById('btn_nueva_f_sangre'),
	btnGlobulosBlancos  = document.getElementById('btn_nuevo_glob_blanc'),
	btnHemoglobina      = document.getElementById('btn_nueva_hemoglobina'),
	btnEosinofilos      = document.getElementById('btn_nuevo_eosinofilos'),
	btnTituloSerologia  = document.getElementById('btn_nuevo_titulo'),
	btnFechaTratamiento = document.getElementById('btn_nueva_f_tratamiento'),
	btnPesoPaciente     = document.getElementById('btn_nuevo_peso_paciente'),
	btnTallaPaciente    = document.getElementById('btn_nuevo_talla_paciente'),
	btnPerimCefalico    = document.getElementById('btn_nuevo_perim_paciente'),
	btnFechaTratPrevio  = document.getElementById('btn_nueva_f_trat_prev'),
	btnAlbendazol       = document.getElementById('btn_nuevo_dosis_albendazol'),
	btnIvermectina      = document.getElementById('btn_nuevo_dosis_ivermectina'),
	btnMebendazol       = document.getElementById('btn_nuevo_dosis_mebendazol');

var tFecha = document.getElementById('t_fecha').content,
	tNro = document.getElementById('t_numero').content,
	tItem = document.getElementById('t_item').content;

var gCondiciones = {
	campanias: {
		numero: null,
		f_ini: null,
		f_fin: null,
		tipo: null,
		escuela: null,
		barrio: null,
		puesto: null,
		paraje: null,
		localidad: null
	},
	pacientes: {
		sexo: null,
		edad: null
	},
	copro: {
		fecha: null,
		peso: null,
		consistencia: null,
		concentrado: {
			ascaris: null,
			giardia: null,
			entamoebacoli: null,
			uncinarias: null,
			strongyloides: null,
			hymenolepis: null,
			trichuris: null,
			enterobius: null,
			taenia: null
		},
		mc_master: {
			ascaris: null,
			uncinarias: null,
			hymenolepis: null,
			trichuris: null,
			enterobius: null,
			taenia: null
		},
		harada_mori: {
			strongyloides: null,
			ancylostoma: null,
			necator: null,
			enterobius: null
		},
		baerman: {
			strongyloides: null,
			ancylostoma: null,
			necator: null
		},
		placa_agar: {
			strongyloides: null,
			ancylostoma: null,
			necator: null
		}
	},
	sangre: {
		fecha: null,
		nro_tubo: null,
		hemograma: {
			globulos_blancos: null,
			hemoglobina: null,
			eosinofilos: null
		},
		serologia: {
			titulo: null,
			resultado: null
		}
	},
	biolog: null,
	tratamientos: {
		fecha: null,
		no_tratado: null,
		medidas: {
			peso: null,
			talla: null,
			perimetro: null
		},
		albendazol: {
			dosis: null,
			motivo_exclusion: null
		},
		ivermectina: {
			dosis: null,
			motivo_exclusion: null
		},
		mebendazol: {
			dosis: null,
			motivo_exclusion: null
		},
		trat_previo: {
			fecha: null,
			albendazol: null,
			ivermectina: null,
			mebendazol: null,
			metrodinazol: null
		}
	}
};

var gDatos = null;


var columnas = document.getElementsByClassName('campo');

Utils.ajax(
	'/iiet/consultas/filtrar_campanias',
	[],
	function(e) {
		var campanias = e.target.response;
		var i = 1;

		for(let campania of campanias) {
			let fila = tablaCampanias.insertRow();

			fila.insertCell('td').textContent = i++;

			fila.insertCell('td').textContent = campania['campania_nombre']    !== null ? campania['campania_nombre']    : '--';
			fila.insertCell('td').textContent = campania['campania_basal']     !== null ? campania['campania_basal']     : '--';
			fila.insertCell('td').textContent = campania['campania_f_ini']     !== null ? campania['campania_f_ini']     : '--';
			fila.insertCell('td').textContent = campania['campania_f_fin']     !== null ? campania['campania_f_fin']     : '--';
			fila.insertCell('td').textContent = campania['campania_tipo']      !== null ? campania['campania_tipo']      : '--';
			fila.insertCell('td').textContent = campania['campania_escuela']   !== null ? campania['campania_escuela']   : '--';
			fila.insertCell('td').textContent = campania['campania_barrio']    !== null ? campania['campania_barrio']    : '--';
			fila.insertCell('td').textContent = campania['campania_puesto']    !== null ? campania['campania_puesto']    : '--';
			fila.insertCell('td').textContent = campania['campania_paraje']    !== null ? campania['campania_paraje']    : '--';
			fila.insertCell('td').textContent = campania['campania_localidad'] !== null ? campania['campania_localidad'] : '--';
		}

		tablaCampanias.normalize();
	}
);

Utils.ajax(
	'/iiet/consultas/campanias',
	[],
	function(e) {
		gDatos = e.target.response;

		cargarPacientes(gDatos, true);
		cargarCopro(gDatos, true);
		cargarSangre(gDatos, true);
		cargarTratamientos(gDatos, true);
		cargarBiologMolec(gDatos, true);

		//cargarDatosTodos();
	}
);

Utils.ajax(
	'/iiet/consultas/listado_campanias',
	[],
	function(e) {
		var campanias = e.target.response;

		for(let campania of campanias) {
			formCampania.children[1].appendChild(document.importNode(tItem, true));

			let n = formCampania.children[1].children.length,
				ultimo = formCampania.children[1].children[n - 1];

			ultimo.children[0].textContent = campania.nombre;
			ultimo.children[1].value = campania.numero;
		}
	}
);

Utils.ajax(
	'/iiet/consultas/listado_escuelas',
	[],
	function(e) {
		var escuelas = e.target.response;

		cargarOpciones(formEscuela, escuelas, 'campania_escuela');
	}
);

Utils.ajax(
	'/iiet/consultas/listado_barrios/campania',
	[],
	function(e) {
		var barrios = e.target.response;

		cargarOpciones(formBarrio, barrios, 'campania_barrio');
	}
);

Utils.ajax(
	'/iiet/consultas/listado_barrios/paciente',
	[],
	function(e) {
		var barrios = e.target.response;

		cargarOpciones(formBarrioPaciente, barrios, 'paciente_barrio');
	}
);

Utils.ajax(
	'/iiet/consultas/listado_puestos/campania',
	[],
	function(e) {
		var puestos = e.target.response;

		cargarOpciones(formPuesto, puestos, 'campania_puesto');
	}
);

Utils.ajax(
	'/iiet/consultas/listado_puestos/paciente',
	[],
	function(e) {
		var puestos = e.target.response;

		cargarOpciones(formPuestoPaciente, puestos, 'paciente_puesto');
	}
);

Utils.ajax(
	'/iiet/consultas/listado_parajes/campania',
	[],
	function(e) {
		var parajes = e.target.response;

		cargarOpciones(formParaje, parajes, 'campania_paraje');
	}
);

Utils.ajax(
	'/iiet/consultas/listado_parajes/paciente',
	[],
	function(e) {
		var parajes = e.target.response;

		cargarOpciones(formParajePaciente, parajes, 'paciente_paraje');
	}
);

Utils.ajax(
	'/iiet/consultas/listado_localidades/campania',
	[],
	function(e) {
		var localidades = e.target.response;

		cargarOpciones(formLocalidad, localidades, 'campania_localidad');
	}
);

Utils.ajax(
	'/iiet/consultas/listado_localidades/paciente',
	[],
	function(e) {
		var localidades = e.target.response;

		cargarOpciones(formLocalidadPaciente, localidades, 'paciente_localidad');
	}
);

function cargarOpciones(form, listaDatos, nombreCampo) {
	var arrNombre = nombreCampo.split('_');

	for(let datos of listaDatos) {
		form.children[0].appendChild(document.importNode(tItem, true));

		let n = form.children[0].children.length,
			ultimo = form.children[0].children[n - 1];

		ultimo.children[0].textContent = datos[nombreCampo];
		ultimo.children[1].value = datos[arrNombre[0] + '_nro_' + arrNombre[1]];
	}
}

function nuevaRestriccion(form, boton, template) {
	var padre = boton.parentNode;
	var contRest = padre.parentNode;

	contRest.insertBefore(document.importNode(template, true), padre);

	var fieldset = form.children[0],
		cant = fieldset.children.length;

	var restNueva = fieldset.children[cant - 2],
		radios = restNueva.querySelectorAll('input[type=radio]'),
		btnElimRest = restNueva.getElementsByClassName('eliminar_restric')[0];

	radios[0].name += form.i;
	radios[1].name += form.i;

	++form.i;

	btnElimRest.addEventListener('click', function(e) {
		var contenedor = btnElimRest.parentNode.parentNode;

		fieldset.removeChild(contenedor);
	});
}

function eliminarRestricciones(form) {
	var fieldset = form.children[0],
		cantHijos = fieldset.children.length;

	for(let i = cantHijos - 2; i > 0; --i)
		fieldset.removeChild(fieldset.children[i]);

	form.i = 0;
}

function cargarPacientes(pacientes, esNuevo) {
	//var pacientes = gDatos;
	var i = 1;

	if(esNuevo)
		tablaPacientes.clearBody();

	for(let paciente of pacientes) {
		let fila = tablaPacientes.insertRow();

		fila.insertCell('td').textContent = (gOffset - 1) * 30 + i++;

		fila.insertCell('td').textContent = paciente['paciente']           !== null ? paciente['paciente']           : '--';
		fila.insertCell('td').textContent = paciente['paciente_edad']      !== null ? paciente['paciente_edad']      : '--';
		fila.insertCell('td').textContent = paciente['paciente_sexo']      !== null ? paciente['paciente_sexo']      : '--';
		fila.insertCell('td').textContent = paciente['paciente_barrio']    !== null ? paciente['paciente_barrio']    : '--';
		fila.insertCell('td').textContent = paciente['paciente_puesto']    !== null ? paciente['paciente_puesto']    : '--';
		fila.insertCell('td').textContent = paciente['paciente_paraje']    !== null ? paciente['paciente_paraje']    : '--';
		fila.insertCell('td').textContent = paciente['paciente_localidad'] !== null ? paciente['paciente_localidad'] : '--';
	}

	tablaPacientes.normalize();
}

function cargarCopro(copro, esNuevo) {
	//var copro = gDatos;
	var i = 1;

	if(esNuevo)
		tablaCopro.clearBody();

	for(let c of copro) {
		let fila = tablaCopro.insertRow();

		fila.insertCell('td').textContent = (gOffset - 1) * 30 + i++;

		fila.insertCell('td').textContent = c['campania_nombre']    !== null ? c['campania_nombre']    : '--';
		fila.insertCell('td').textContent = c['paciente']           !== null ? c['paciente']           : '--';
		fila.insertCell('td').textContent = c['copro_fecha']        !== null ? c['copro_fecha']        : '--';
		fila.insertCell('td').textContent = c['copro_peso_materia'] !== null ? c['copro_peso_materia'] : '--';
		fila.insertCell('td').textContent = c['copro_consistencia'] !== null ? c['copro_consistencia'] : '--';
		fila.insertCell('td').textContent = c['conc_ascaris']       !== null ? c['conc_ascaris']       : '--';
		fila.insertCell('td').textContent = c['conc_giardia']       !== null ? c['conc_giardia']       : '--';
		fila.insertCell('td').textContent = c['conc_entamoebacoli'] !== null ? c['conc_entamoebacoli'] : '--';
		fila.insertCell('td').textContent = c['conc_uncinarias']    !== null ? c['conc_uncinarias']    : '--';
		fila.insertCell('td').textContent = c['conc_strongyloides'] !== null ? c['conc_strongyloides'] : '--';
		fila.insertCell('td').textContent = c['conc_hymenolepis']   !== null ? c['conc_hymenolepis']   : '--';
		fila.insertCell('td').textContent = c['conc_trichuris']     !== null ? c['conc_trichuris']     : '--';
		fila.insertCell('td').textContent = c['conc_enterobius']    !== null ? c['conc_enterobius']    : '--';
		fila.insertCell('td').textContent = c['conc_taenia']        !== null ? c['conc_taenia']        : '--';
		fila.insertCell('td').textContent = c['mm_ascaris']         !== null ? c['mm_ascaris']         : '--';
		fila.insertCell('td').textContent = c['mm_uncinarias']      !== null ? c['mm_uncinarias']      : '--';
		fila.insertCell('td').textContent = c['mm_hymenolepis']     !== null ? c['mm_hymenolepis']     : '--';
		fila.insertCell('td').textContent = c['mm_trichuris']       !== null ? c['mm_trichuris']       : '--';
		fila.insertCell('td').textContent = c['mm_enterobius']      !== null ? c['mm_enterobius']      : '--';
		fila.insertCell('td').textContent = c['mm_taenia']          !== null ? c['mm_taenia']          : '--';
		fila.insertCell('td').textContent = c['hm_strongyloides']   !== null ? c['hm_strongyloides']   : '--';
		fila.insertCell('td').textContent = c['hm_ancylostoma']     !== null ? c['hm_ancylostoma']     : '--';
		fila.insertCell('td').textContent = c['hm_necator']         !== null ? c['hm_necator']         : '--';
		fila.insertCell('td').textContent = c['hm_enterobius']      !== null ? c['hm_enterobius']      : '--';
		fila.insertCell('td').textContent = c['bm_strongyloides']   !== null ? c['bm_strongyloides']   : '--';
		fila.insertCell('td').textContent = c['bm_ancylostoma']     !== null ? c['bm_ancylostoma']     : '--';
		fila.insertCell('td').textContent = c['bm_necator']         !== null ? c['bm_necator']         : '--';
		fila.insertCell('td').textContent = c['pa_strongyloides']   !== null ? c['pa_strongyloides']   : '--';
		fila.insertCell('td').textContent = c['pa_ancylostoma']     !== null ? c['pa_ancylostoma']     : '--';
		fila.insertCell('td').textContent = c['pa_necator']         !== null ? c['pa_necator']         : '--';
	}

	tablaCopro.normalize();
}

function cargarSangre(sangre, esNuevo) {
	//var sangre = gDatos;
	var i = 1;

	if(esNuevo)
		tablaSangre.clearBody();

	for(let s of sangre) {
		let fila = tablaSangre.insertRow();

		fila.insertCell('td').textContent = (gOffset - 1) * 30 + i++;

		fila.insertCell('td').textContent = s['campania_nombre']     !== null ? s['campania_nombre']     : '--';
		fila.insertCell('td').textContent = s['paciente']            !== null ? s['paciente']            : '--';
		fila.insertCell('td').textContent = s['sangre_fecha']        !== null ? s['sangre_fecha']        : '--';
		fila.insertCell('td').textContent = s['nro_tubo']            !== null ? s['nro_tubo']            : '--';
		fila.insertCell('td').textContent = s['globulos_blancos']    !== null ? s['globulos_blancos']    : '--';
		fila.insertCell('td').textContent = s['hemoglobina']         !== null ? s['hemoglobina']         : '--';
		fila.insertCell('td').textContent = s['eosinofilos']         !== null ? s['eosinofilos']         : '--';
		fila.insertCell('td').textContent = s['serologia_titulo']    !== null ? s['serologia_titulo']    : '--';
		fila.insertCell('td').textContent = s['serologia_resultado'] !== null ? s['serologia_resultado'] : '--';
	}

	tablaSangre.normalize();
}

function cargarBiologMolec(biologMolec, esNuevo) {
	//var biologMolec = gDatos;
	var i = 1;

	if(esNuevo)
		tablaBiologMolec.clearBody();

	for(let b of biologMolec) {
		let fila = tablaBiologMolec.insertRow();

		fila.insertCell('td').textContent = (gOffset - 1) * 30 + i++;

		fila.insertCell('td').textContent = b['campania_nombre']    !== null ? b['campania_nombre']    : '--';
		fila.insertCell('td').textContent = b['paciente']           !== null ? b['paciente']           : '--';
		fila.insertCell('td').textContent = b['fuente']             !== null ? b['fuente']             : '--';
		fila.insertCell('td').textContent = b['pcr_strongyloides']  !== null ? b['pcr_strongyloides']  : '--';
		fila.insertCell('td').textContent = b['pcr_ancylostoma']    !== null ? b['pcr_ancylostoma']    : '--';
		fila.insertCell('td').textContent = b['pcr_necator']        !== null ? b['pcr_necator']        : '--';
		fila.insertCell('td').textContent = b['pcr_ascaris']        !== null ? b['pcr_ascaris']        : '--';
		fila.insertCell('td').textContent = b['pcr_trichuris']      !== null ? b['pcr_trichuris']      : '--';
		fila.insertCell('td').textContent = b['qpcr_strongyloides'] !== null ? b['qpcr_strongyloides'] : '--';
		fila.insertCell('td').textContent = b['qpcr_ancylostoma']   !== null ? b['qpcr_ancylostoma']   : '--';
		fila.insertCell('td').textContent = b['qpcr_necator']       !== null ? b['qpcr_necator']       : '--';
		fila.insertCell('td').textContent = b['qpcr_ascaris']       !== null ? b['qpcr_ascaris']       : '--';
		fila.insertCell('td').textContent = b['qpcr_trichuris']     !== null ? b['qpcr_trichuris']     : '--';
	}

	tablaBiologMolec.normalize();
}

function cargarTratamientos(tratamientos, esNuevo) {
	//var tratamientos = gDatos;
	var i = 1;

	if(esNuevo)
		tablaTratamientos.clearBody();

	for(let t of tratamientos) {
		let fila = tablaTratamientos.insertRow();

		fila.insertCell('td').textContent = (gOffset - 1) * 30 + i++;

		fila.insertCell('td').textContent = t['campania_nombre']        !== null ? t['campania_nombre']        : '--';
		fila.insertCell('td').textContent = t['paciente']               !== null ? t['paciente']               : '--';
		fila.insertCell('td').textContent = t['tratamiento_fecha']      !== null ? t['tratamiento_fecha']      : '--';
		fila.insertCell('td').textContent = t['no_tratado']             !== null ? t['no_tratado']             : '--';
		fila.insertCell('td').textContent = t['peso']                   !== null ? t['peso']                   : '--';
		fila.insertCell('td').textContent = t['talla']                  !== null ? t['talla']                  : '--';
		fila.insertCell('td').textContent = t['perimetro_cefalico']     !== null ? t['perimetro_cefalico']     : '--';
		fila.insertCell('td').textContent = t['trat_prev_fecha']        !== null ? t['trat_prev_fecha']        : '--';
		fila.insertCell('td').textContent = t['trat_prev_mebendazol']   !== null ? t['trat_prev_mebendazol']   : '--';
		fila.insertCell('td').textContent = t['trat_prev_albendazol']   !== null ? t['trat_prev_albendazol']   : '--';
		fila.insertCell('td').textContent = t['trat_prev_ivermectina']  !== null ? t['trat_prev_ivermectina']  : '--';
		fila.insertCell('td').textContent = t['trat_prev_metronidazol'] !== null ? t['trat_prev_metronidazol'] : '--';
		fila.insertCell('td').textContent = t['albendazol_dosis']       !== null ? t['albendazol_dosis']       : '--';
		fila.insertCell('td').textContent = t['albendazol_exclusion']   !== null ? t['albendazol_exclusion']   : '--';
		fila.insertCell('td').textContent = t['ivermectina_dosis']      !== null ? t['ivermectina_dosis']      : '--';
		fila.insertCell('td').textContent = t['ivermectina_exclusion']  !== null ? t['ivermectina_exclusion']  : '--';
		fila.insertCell('td').textContent = t['mebendazol_dosis']       !== null ? t['mebendazol_dosis']       : '--';
		fila.insertCell('td').textContent = t['mebendazol_exclusion']   !== null ? t['mebendazol_exclusion']   : '--';
	}

	tablaTratamientos.normalize();
}

function tablaVacia(tabla) {
	var fila = tablaTratamientos.insertRow();

	fila.className = 'tabla_vacia';
	fila.insertCell('td').textContent = ' ';
}

function obtenerValores(form) {
	var valores = new Array();

	if(typeof form.valor.length === 'undefined') {
		if(form.valor.checked)
			valores.push(form.valor.value);
	}

	else {
		for(let v of form.valor) {
			if(v.checked)
				valores.push(v.value);
		}
	}

	return valores;
}

function obtenerValoresComplejos(form) {
	var valores = form.valor,
		operadores = form.operador,
		condiciones = gCondiciones;

	var arr = new Array();

	if(typeof valores === 'undefined')
		return null;

	if(typeof valores.length === 'undefined')
		arr.push([operadores.value, valores.value]);

	else
		for(let i = 0; i < valores.length; ++i) {
			let operador = operadores[i].value,
				valor = valores[i].value;

			arr.push([operador, valor]);
		}

	var cond = new Array();

	for(let i = 0; i < form.i; ++i) {
		let nombre = 'nexo_' + i;

		if(!typeof form[nombre] !== 'undefined') {
			cond.push(form[nombre].value);
			cond.push(arr.shift());
		}
	}

	return cond;
}

formCampania.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formCampania)
		condiciones = gCondiciones;

	condiciones.campanias.numero = valores;

	filtrar(formCampania, tablaCampanias, 1, valores.length > 0, condiciones);
});

formFechaInicio.i = 0;

btnFechaIni.addEventListener('click', e => nuevaRestriccion(formFechaInicio, btnFechaIni, tFecha));

formFechaInicio.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formFechaInicio),
		condiciones = gCondiciones;

	condiciones.campanias.f_ini = valores;

	filtrar(formFechaInicio, tablaCampanias, 3, valores !== null, condiciones);
});

formFechaInicio.addEventListener('reset', e => eliminarRestricciones(formFechaInicio));


formFechaFin.i = 0;

btnFechaFin.addEventListener('click', e => nuevaRestriccion(formFechaFin, btnFechaFin, tFecha));

formFechaFin.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formFechaFin),
		condiciones = gCondiciones;

	condiciones.campanias.f_fin = valores;

	filtrar(formFechaFin, tablaCampanias, 4, valores !== null, condiciones);
});

formFechaFin.addEventListener('reset', e => eliminarRestricciones(formFechaFin));


formTipo.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formTipo),
		condiciones = gCondiciones;

	condiciones.campanias.tipo = valores;

	filtrar(formTipo, tablaCampanias, 5, valores.length > 0, condiciones);
});

formEscuela.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formEscuela),
		condiciones = gCondiciones;

	condiciones.campanias.escuela = valores;

	filtrar(formEscuela, tablaCampanias, 6, valores.length > 0, condiciones);
});

formBarrio.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formBarrio),
		condiciones = gCondiciones;

	condiciones.campanias.barrio = valores;

	filtrar(formBarrio, tablaCampanias, 7, valores.length > 0, condiciones);
});

formPuesto.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formPuesto),
		condiciones = gCondiciones;

	condiciones.campanias.puesto = valores;

	filtrar(formPuesto, tablaCampanias, 8, valores.length > 0, condiciones);
});

formParaje.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formParaje),
		condiciones = gCondiciones;

	condiciones.campanias.paraje = valores;

	filtrar(formParaje, tablaCampanias, 9, valores.length > 0, condiciones);
});

formLocalidad.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formLocalidad),
		condiciones = gCondiciones;

	condiciones.campanias.localidad = valores;

	filtrar(formLocalidad, tablaCampanias, 10, valores.length > 0, condiciones);
});

formBarrioPaciente.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formBarrioPaciente),
		condiciones = gCondiciones;

	condiciones.pacientes.barrio = valores;

	filtrar(formBarrioPaciente, tablaPacientes, 4, valores.length > 0, condiciones);
});

formPuestoPaciente.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formPuestoPaciente),
		condiciones = gCondiciones;

	condiciones.pacientes.puesto = valores;

	filtrar(formPuestoPaciente, tablaPacientes, 5, valores.length > 0, condiciones);
});

formParajePaciente.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formParajePaciente),
		condiciones = gCondiciones;

	condiciones.pacientes.paraje = valores;

	filtrar(formParajePaciente, tablaPacientes, 6, valores.length > 0, condiciones);
});

formLocalidadPaciente.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formLocalidadPaciente),
		condiciones = gCondiciones;

	condiciones.pacientes.localidad = valores;

	filtrar(formLocalidadPaciente, tablaPacientes, 7, valores.length > 0, condiciones);
});


formEdad.i = 0;

btnEdad.addEventListener('click', e => nuevaRestriccion(formEdad, btnEdad, tNro));

formEdad.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formEdad),
		condiciones = gCondiciones;

	condiciones.pacientes.edad = valores;

	filtrar(formEdad, tablaPacientes, 2, valores !== null, condiciones);
});

formEdad.addEventListener('reset', e => eliminarRestricciones(formEdad));

formSexo.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formSexo),
		condiciones = gCondiciones;

	condiciones.pacientes.sexo = valores;

	filtrar(formSexo, tablaPacientes, 3, valores.length > 0, condiciones);
});

formPesoCopro.i = 0;

btnPesoCopro.addEventListener('click', e => nuevaRestriccion(formPesoCopro, btnPesoCopro, tNro));

formPesoCopro.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formPesoCopro),
		condiciones = gCondiciones;

	condiciones.copro.peso = valores;

	filtrar(formPesoCopro, tablaCopro, 4, valores !== null, condiciones);
});

formPesoCopro.addEventListener('reset', e => eliminarRestricciones(formPesoCopro));


formFechaCopro.i = 0;

btnFechaCopro.addEventListener('click', e => nuevaRestriccion(formFechaCopro, btnFechaCopro, tFecha));

formFechaCopro.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formFechaCopro),
		condiciones = gCondiciones;

	condiciones.copro.fecha = valores;

	filtrar(formFechaCopro, tablaCopro, 3, valores !== null, condiciones);
});

formFechaCopro.addEventListener('reset', e => eliminarRestricciones(formFechaCopro));


formConsistencia.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formConsistencia);
	var condiciones = gCondiciones;

	condiciones.copro.consistencia = valores;

	filtrar(formConsistencia, tablaCopro, 5, valores.length > 0, condiciones);
});

formAscarisConc.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formAscarisConc);
	var condiciones = gCondiciones;

	condiciones.copro.concentrado.ascaris = valores;

	filtrar(formAscarisConc, tablaCopro, 6, valores.length > 0, condiciones);
});

formGiardiaConc.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formGiardiaConc);
	var condiciones = gCondiciones;

	condiciones.copro.concentrado.giardia = valores;

	filtrar(formGiardiaConc, tablaCopro, 7, valores.length > 0, condiciones);
});

formEntamoebacoliConc.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formEntamoebacoliConc);
	var condiciones = gCondiciones;

	condiciones.copro.concentrado.entamoebacoli = valores;

	filtrar(formEntamoebacoliConc, tablaCopro, 8, valores.length > 0, condiciones);
});

formUncinariasConc.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formUncinariasConc);
	var condiciones = gCondiciones;

	condiciones.copro.concentrado.uncinarias = valores;

	filtrar(formUncinariasConc, tablaCopro, 9, valores.length > 0, condiciones);
});

formStrongyloidesConc.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formStrongyloidesConc);
	var condiciones = gCondiciones;

	condiciones.copro.concentrado.strongyloides = valores;

	filtrar(formStrongyloidesConc, tablaCopro, 10, valores.length > 0, condiciones);
});

formHymenolepisConc.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formHymenolepisConc);
	var condiciones = gCondiciones;

	condiciones.copro.concentrado.hymenolepis = valores;

	filtrar(formHymenolepisConc, tablaCopro, 11, valores.length > 0, condiciones);
});

formTrichurisConc.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formTrichurisConc);
	var condiciones = gCondiciones;

	condiciones.copro.concentrado.trichuris = valores;

	filtrar(formTrichurisConc, tablaCopro, 12, valores.length > 0, condiciones);
});

formEnterobiusConc.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formEnterobiusConc);
	var condiciones = gCondiciones;

	condiciones.copro.concentrado.enterobius = valores;

	filtrar(formEnterobiusConc, tablaCopro, 13, valores.length > 0, condiciones);
});

formTaeniaConc.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formTaeniaConc);
	var condiciones = gCondiciones;

	condiciones.copro.concentrado.taenia = valores;

	filtrar(formTaeniaConc, tablaCopro, 14, valores.length > 0, condiciones);
});

formAscarisMM.i = 0;

btnAscarisMM.addEventListener('click', e => nuevaRestriccion(formAscarisMM, btnAscarisMM, tNro));

formAscarisMM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formAscarisMM),
		condiciones = gCondiciones;

	condiciones.copro.mc_master.ascaris = valores;

	filtrar(formAscarisMM, tablaCopro, 15, valores !== null, condiciones);
});

formAscarisMM.addEventListener('reset', e => eliminarRestricciones(formAscarisMM));


formUncinariasMM.i = 0;

btnUncinariasMM.addEventListener('click', e => nuevaRestriccion(formUncinariasMM, btnUncinariasMM, tNro));

formUncinariasMM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formUncinariasMM),
		condiciones = gCondiciones;

	condiciones.copro.mc_master.uncinarias = valores;

	filtrar(formUncinariasMM, tablaCopro, 16, valores !== null, condiciones);
});

formUncinariasMM.addEventListener('reset', e => eliminarRestricciones(formUncinariasMM));


formHymenolepisMM.i = 0;

btnHymenolepisMM.addEventListener('click', e => nuevaRestriccion(formHymenolepisMM, btnHymenolepisMM, tNro));

formHymenolepisMM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formHymenolepisMM),
		condiciones = gCondiciones;

	condiciones.copro.mc_master.hymenolepis = valores;

	filtrar(formHymenolepisMM, tablaCopro, 17, valores !== null, condiciones);
});

formHymenolepisMM.addEventListener('reset', e => eliminarRestricciones(formHymenolepisMM));


formTrichurisMM.i = 0;

btnTrichurisMM.addEventListener('click', e => nuevaRestriccion(formTrichurisMM, btnTrichurisMM, tNro));

formTrichurisMM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formTrichurisMM),
		condiciones = gCondiciones;

	condiciones.copro.mc_master.trichuris = valores;

	filtrar(formTrichurisMM, tablaCopro, 18, valores !== null, condiciones);
});

formTrichurisMM.addEventListener('reset', e => eliminarRestricciones(formTrichurisMM));


formEnterobiusMM.i = 0;

btnEnterobiusMM.addEventListener('click', e => nuevaRestriccion(formEnterobiusMM, btnEnterobiusMM, tNro));

formEnterobiusMM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formEnterobiusMM),
		condiciones = gCondiciones;

	condiciones.copro.mc_master.enterobius = valores;

	filtrar(formEnterobiusMM, tablaCopro, 19, valores !== null, condiciones);
});

formEnterobiusMM.addEventListener('reset', e => eliminarRestricciones(formEnterobiusMM));


formTaeniaMM.i = 0;

btnTaeniaMM.addEventListener('click', e => nuevaRestriccion(formTaeniaMM, btnTaeniaMM, tNro));

formTaeniaMM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formTaeniaMM),
		condiciones = gCondiciones;

	condiciones.copro.mc_master.taenia = valores;

	filtrar(formTaeniaMM, tablaCopro, 20, valores !== null, condiciones);
});

formTaeniaMM.addEventListener('reset', e => eliminarRestricciones(formTaeniaMM));


formStrongyloidesHM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formStrongyloidesHM);
	var condiciones = gCondiciones;

	condiciones.copro.harada_mori.strongyloides = valores;

	filtrar(formStrongyloidesHM, tablaCopro, 21, valores.length > 0, condiciones);
});

formAncylostomaHM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formAncylostomaHM);
	var condiciones = gCondiciones;

	condiciones.copro.harada_mori.ancylostoma = valores;

	filtrar(formAncylostomaHM, tablaCopro, 22, valores.length > 0, condiciones);
});

formNecatorHM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formNecatorHM);
	var condiciones = gCondiciones;

	condiciones.copro.harada_mori.necator = valores;

	filtrar(formNecatorHM, tablaCopro, 23, valores.length > 0, condiciones);
});

formEnterobiusHM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formEnterobiusHM);
	var condiciones = gCondiciones;

	condiciones.copro.harada_mori.enterobius = valores;

	filtrar(formEnterobiusHM, tablaCopro, 24, valores.length > 0, condiciones);
});

formStrongyloidesBM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formStrongyloidesBM);
	var condiciones = gCondiciones;

	condiciones.copro.baerman.strongyloides = valores;

	filtrar(formStrongyloidesBM, tablaCopro, 25, valores.length > 0, condiciones);
});

formAncylostomaBM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formAncylostomaBM);
	var condiciones = gCondiciones;

	condiciones.copro.baerman.ancylostoma = valores;

	filtrar(formAncylostomaBM, tablaCopro, 26, valores.length > 0, condiciones);
});

formNecatorBM.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formNecatorBM);
	var condiciones = gCondiciones;

	condiciones.copro.baerman.necator = valores;

	filtrar(formNecatorBM, tablaCopro, 27, valores.length > 0, condiciones);
});

formStrongyloidesPA.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formStrongyloidesPA);
	var condiciones = gCondiciones;

	condiciones.copro.placa_agar.strongyloides = valores;

	filtrar(formStrongyloidesPA, tablaCopro, 28, valores.length > 0, condiciones);
});

formAncylostomaPA.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formAncylostomaPA);
	var condiciones = gCondiciones;

	condiciones.copro.placa_agar.ancylostoma = valores;

	filtrar(formAncylostomaPA, tablaCopro, 29, valores.length > 0, condiciones);
});

formNecatorPA.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formNecatorPA);
	var condiciones = gCondiciones;

	condiciones.copro.placa_agar.necator = valores;

	filtrar(formNecatorPA, tablaCopro, 30, valores.length > 0, condiciones);
});


formFechaSangre.i = 0;

btnFechaSangre.addEventListener('click', e => nuevaRestriccion(formFechaSangre, btnFechaSangre, tFecha));

formFechaSangre.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formFechaSangre),
		condiciones = gCondiciones;

	condiciones.sangre.fecha = valores;

	filtrar(formFechaSangre, tablaSangre, 3, valores !== null, condiciones);
});

formFechaSangre.addEventListener('reset', e => eliminarRestricciones(formFechaSangre));


formGlobulosBlancos.i = 0;

btnGlobulosBlancos.addEventListener('click', e => nuevaRestriccion(formGlobulosBlancos, btnGlobulosBlancos, tNro));

formGlobulosBlancos.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formGlobulosBlancos),
		condiciones = gCondiciones;

	condiciones.sangre.hemograma.globulos_blancos = valores;

	filtrar(formGlobulosBlancos, tablaSangre, 5, valores !== null, condiciones);
});

formGlobulosBlancos.addEventListener('reset', e => eliminarRestricciones(formGlobulosBlancos));


formHemoglobina.i = 0;

btnHemoglobina.addEventListener('click', e => nuevaRestriccion(formHemoglobina, btnHemoglobina, tNro));

formHemoglobina.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formHemoglobina),
		condiciones = gCondiciones;

	condiciones.sangre.hemograma.hemoglobina = valores;

	filtrar(formHemoglobina, tablaSangre, 6, valores !== null, condiciones);
});

formHemoglobina.addEventListener('reset', e => eliminarRestricciones(formHemoglobina));


formEosinofilos.i = 0;

btnEosinofilos.addEventListener('click', e => nuevaRestriccion(formEosinofilos, btnEosinofilos, tNro));

formEosinofilos.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formEosinofilos),
		condiciones = gCondiciones;

	condiciones.sangre.hemograma.eosinofilos = valores;

	filtrar(formEosinofilos, tablaSangre, 7, valores !== null, condiciones);
});

formEosinofilos.addEventListener('reset', e => eliminarRestricciones(formEosinofilos));


formTituloSerologia.i = 0;

btnTituloSerologia.addEventListener('click', e => nuevaRestriccion(formTituloSerologia, btnTituloSerologia, tNro));

formTituloSerologia.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formTituloSerologia),
		condiciones = gCondiciones;

	condiciones.sangre.serologia.titulo = valores;

	filtrar(formTituloSerologia, tablaSangre, 8, valores !== null, condiciones);
});

formTituloSerologia.addEventListener('reset', e => eliminarRestricciones(formTituloSerologia));


formResultadoSerologia.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formResultadoSerologia),
		condiciones = gCondiciones;

	condiciones.sangre.serologia.resultado = valores;

	filtrar(formResultadoSerologia, tablaSangre, 9, valores.length > 0, condiciones);
});


formFechaTratamiento.i = 0;

btnFechaTratamiento.addEventListener('click', e => nuevaRestriccion(formFechaTratamiento, btnFechaTratamiento, tFecha));

formFechaTratamiento.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formFechaTratamiento),
		condiciones = gCondiciones;

	condiciones.tratamientos.fecha = valores;

	filtrar(formFechaTratamiento, tablaTratamientos, 3, valores !== null, condiciones);
});

formFechaTratamiento.addEventListener('reset', e => eliminarRestricciones(formFechaTratamiento));


formNoTratado.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formNoTratado),
		condiciones = gCondiciones;

	condiciones.tratamientos.no_tratado = valores;

	filtrar(formNoTratado, tablaTratamientos, 4, valores.length > 0, condiciones);
});


formPesoPaciente.i = 0;

btnPesoPaciente.addEventListener('click', e => nuevaRestriccion(formPesoPaciente, btnPesoPaciente, tNro));

formPesoPaciente.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formPesoPaciente),
		condiciones = gCondiciones;

	condiciones.tratamientos.medidas.peso = valores;

	filtrar(formPesoPaciente, tablaTratamientos, 5, valores !== null, condiciones);
});

formPesoPaciente.addEventListener('reset', e => eliminarRestricciones(formPesoPaciente));


formTallaPaciente.i = 0;

btnTallaPaciente.addEventListener('click', e => nuevaRestriccion(formTallaPaciente, btnTallaPaciente, tNro));

formTallaPaciente.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formTallaPaciente),
		condiciones = gCondiciones;

	condiciones.tratamientos.medidas.talla = valores;

	filtrar(formTallaPaciente, tablaTratamientos, 6, valores !== null, condiciones);
});

formTallaPaciente.addEventListener('reset', e => eliminarRestricciones(formTallaPaciente));


formPerimCefalico.i = 0;

btnPerimCefalico.addEventListener('click', e => nuevaRestriccion(formPerimCefalico, btnPerimCefalico, tNro));

formPerimCefalico.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formPerimCefalico),
		condiciones = gCondiciones;

	condiciones.tratamientos.medidas.perimetro = valores;

	filtrar(formPerimCefalico, tablaTratamientos, 7, valores !== null, condiciones);
});

formPerimCefalico.addEventListener('reset', e => eliminarRestricciones(formPerimCefalico));


formFechaTratPrevio.i = 0;

btnFechaTratPrevio.addEventListener('click', e => nuevaRestriccion(formFechaTratPrevio, btnFechaTratPrevio, tFecha));

formFechaTratPrevio.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formFechaTratPrevio),
		condiciones = gCondiciones;

	condiciones.tratamientos.trat_previo.fecha = valores;

	filtrar(formFechaTratPrevio, tablaTratamientos, 8, valores !== null, condiciones);
});

formFechaTratPrevio.addEventListener('reset', e => eliminarRestricciones(formFechaTratPrevio));


formAlbendTratPrevio.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formAlbendTratPrevio),
		condiciones = gCondiciones;

	condiciones.tratamientos.trat_previo.albendazol = valores;

	filtrar(formAlbendTratPrevio, tablaTratamientos, 9, valores.length > 0, condiciones);
});


formIvermecTratPrevio.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formIvermecTratPrevio),
		condiciones = gCondiciones;

	condiciones.tratamientos.trat_previo.ivermectina = valores;

	filtrar(formIvermecTratPrevio, tablaTratamientos, 10, valores.length > 0, condiciones);
});


formMebendTratPrevio.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formMebendTratPrevio),
		condiciones = gCondiciones;

	condiciones.tratamientos.trat_previo.mebendazol = valores;

	filtrar(formMebendTratPrevio, tablaTratamientos, 11, valores.length > 0, condiciones);
});


formMetrodinTratPrevio.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formMetrodinTratPrevio),
		condiciones = gCondiciones;

	condiciones.tratamientos.trat_previo.metrodinazol = valores;

	filtrar(formMetrodinTratPrevio, tablaTratamientos, 12, valores.length > 0, condiciones);
});


formDosisAlbendazol.i = 0;

btnAlbendazol.addEventListener('click', e => nuevaRestriccion(formDosisAlbendazol, btnAlbendazol, tNro));

formDosisAlbendazol.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formDosisAlbendazol),
		condiciones = gCondiciones;

	condiciones.tratamientos.albendazol.dosis = valores;

	filtrar(formDosisAlbendazol, tablaTratamientos, 13, valores !== null, condiciones);
});

formDosisAlbendazol.addEventListener('reset', e => eliminarRestricciones(formDosisAlbendazol));


formMotivExcAlbend.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formMotivExcAlbend),
		condiciones = gCondiciones;

	condiciones.tratamientos.albendazol.motivo_exclusion = valores;

	filtrar(formMotivExcAlbend, tablaTratamientos, 14, valores.length > 0, condiciones);
});


formDosisIvermectina.i = 0;

btnIvermectina.addEventListener('click', e => nuevaRestriccion(formDosisIvermectina, btnIvermectina, tNro));

formDosisIvermectina.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formDosisIvermectina),
		condiciones = gCondiciones;

	condiciones.tratamientos.ivermectina.dosis = valores;

	filtrar(formDosisIvermectina, tablaTratamientos, 15, valores !== null, condiciones);
});

formDosisIvermectina.addEventListener('reset', e => eliminarRestricciones(formDosisIvermectina));


formMotivExcIvermct.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formMotivExcIvermct),
		condiciones = gCondiciones;

	condiciones.tratamientos.ivermectina.motivo_exclusion = valores;

	filtrar(formMotivExcIvermct, tablaTratamientos, 16, valores.length > 0, condiciones);
});


formDosisMebendazol.i = 0;

btnMebendazol.addEventListener('click', e => nuevaRestriccion(formDosisMebendazol, btnMebendazol, tNro));

formDosisMebendazol.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValoresComplejos(formDosisMebendazol),
		condiciones = gCondiciones;

	condiciones.tratamientos.mebendazol.dosis = valores;

	filtrar(formDosisMebendazol, tablaTratamientos, 17, valores !== null, condiciones);
});

formDosisMebendazol.addEventListener('reset', e => eliminarRestricciones(formDosisMebendazol));


formMotivExcMebend.addEventListener('submit', function(e) {
	e.preventDefault();

	var valores = obtenerValores(formMotivExcMebend),
		condiciones = gCondiciones;

	condiciones.tratamientos.mebendazol.motivo_exclusion = valores;

	filtrar(formMotivExcMebend, tablaTratamientos, 18, valores.length > 0, condiciones);
});

function filtrar(form, tabla, iCol, booleano, condiciones) {
	Utils.ajax(
		'/iiet/consultas/campanias',
		new Map([['condiciones', JSON.stringify(condiciones)]]),
		function(e) {
			gDatos = e.target.response;

			tabla.cells[0][iCol].className = booleano ? 'filtrado' : null;

			gOffset = 1;

			cargarPacientes(gDatos, true);
			cargarCopro(gDatos, true);
			cargarSangre(gDatos, true);
			cargarTratamientos(gDatos, true);
			cargarBiologMolec(gDatos, true);

			form.parentNode.parentNode.close();
		}
	);
}

function cargarDatosTodos() {
	var i = 1;

	tablaFinal.clearBody();

	for(let registro of gDatos) {
		let fila = tablaFinal.insertRow();

		fila.insertCell('td').textContent = i++;

		fila.insertCell('td').textContent = registro['campania_nombre']        !== null ? registro['campania_nombre']        : '--';
		fila.insertCell('td').textContent = registro['campania_basal']         !== null ? registro['campania_basal']         : '--';
		fila.insertCell('td').textContent = registro['campania_f_ini']         !== null ? registro['campania_f_ini']         : '--';
		fila.insertCell('td').textContent = registro['campania_f_fin']         !== null ? registro['campania_f_fin']         : '--';
		fila.insertCell('td').textContent = registro['campania_tipo']          !== null ? registro['campania_tipo']          : '--';
		fila.insertCell('td').textContent = registro['campania_escuela']       !== null ? registro['campania_escuela']       : '--';
		fila.insertCell('td').textContent = registro['campania_barrio']        !== null ? registro['campania_barrio']        : '--';
		fila.insertCell('td').textContent = registro['campania_puesto']        !== null ? registro['campania_puesto']        : '--';
		fila.insertCell('td').textContent = registro['campania_paraje']        !== null ? registro['campania_paraje']        : '--';
		fila.insertCell('td').textContent = registro['campania_localidad']     !== null ? registro['campania_localidad']     : '--';

		fila.insertCell('td').textContent = registro['paciente']               !== null ? registro['paciente']               : '--';
		fila.insertCell('td').textContent = registro['paciente_edad']          !== null ? registro['paciente_edad']          : '--';
		fila.insertCell('td').textContent = registro['paciente_sexo']          !== null ? registro['paciente_sexo']          : '--';
		fila.insertCell('td').textContent = registro['paciente_barrio']        !== null ? registro['paciente_barrio']        : '--';
		fila.insertCell('td').textContent = registro['paciente_puesto']        !== null ? registro['paciente_puesto']        : '--';
		fila.insertCell('td').textContent = registro['paciente_paraje']        !== null ? registro['paciente_paraje']        : '--';
		fila.insertCell('td').textContent = registro['paciente_localidad']     !== null ? registro['paciente_localidad']     : '--';

		fila.insertCell('td').textContent = registro['copro_fecha']            !== null ? registro['copro_fecha']            : '--';
		fila.insertCell('td').textContent = registro['copro_peso_materia']     !== null ? registro['copro_peso_materia']     : '--';
		fila.insertCell('td').textContent = registro['copro_consistencia']     !== null ? registro['copro_consistencia']     : '--';
		fila.insertCell('td').textContent = registro['conc_ascaris']           !== null ? registro['conc_ascaris']           : '--';
		fila.insertCell('td').textContent = registro['conc_giardia']           !== null ? registro['conc_giardia']           : '--';
		fila.insertCell('td').textContent = registro['conc_entamoebacoli']     !== null ? registro['conc_entamoebacoli']     : '--';
		fila.insertCell('td').textContent = registro['conc_uncinarias']        !== null ? registro['conc_uncinarias']        : '--';
		fila.insertCell('td').textContent = registro['conc_strongyloides']     !== null ? registro['conc_strongyloides']     : '--';
		fila.insertCell('td').textContent = registro['conc_hymenolepis']       !== null ? registro['conc_hymenolepis']       : '--';
		fila.insertCell('td').textContent = registro['conc_trichuris']         !== null ? registro['conc_trichuris']         : '--';
		fila.insertCell('td').textContent = registro['conc_enterobius']        !== null ? registro['conc_enterobius']        : '--';
		fila.insertCell('td').textContent = registro['conc_taenia']            !== null ? registro['conc_taenia']            : '--';
		fila.insertCell('td').textContent = registro['mm_ascaris']             !== null ? registro['mm_ascaris']             : '--';
		fila.insertCell('td').textContent = registro['mm_uncinarias']          !== null ? registro['mm_uncinarias']          : '--';
		fila.insertCell('td').textContent = registro['mm_hymenolepis']         !== null ? registro['mm_hymenolepis']         : '--';
		fila.insertCell('td').textContent = registro['mm_trichuris']           !== null ? registro['mm_trichuris']           : '--';
		fila.insertCell('td').textContent = registro['mm_enterobius']          !== null ? registro['mm_enterobius']          : '--';
		fila.insertCell('td').textContent = registro['mm_taenia']              !== null ? registro['mm_taenia']              : '--';
		fila.insertCell('td').textContent = registro['hm_strongyloides']       !== null ? registro['hm_strongyloides']       : '--';
		fila.insertCell('td').textContent = registro['hm_ancylostoma']         !== null ? registro['hm_ancylostoma']         : '--';
		fila.insertCell('td').textContent = registro['hm_necator']             !== null ? registro['hm_necator']             : '--';
		fila.insertCell('td').textContent = registro['hm_enterobius']          !== null ? registro['hm_enterobius']          : '--';
		fila.insertCell('td').textContent = registro['bm_strongyloides']       !== null ? registro['bm_strongyloides']       : '--';
		fila.insertCell('td').textContent = registro['bm_ancylostoma']         !== null ? registro['bm_ancylostoma']         : '--';
		fila.insertCell('td').textContent = registro['bm_necator']             !== null ? registro['bm_necator']             : '--';
		fila.insertCell('td').textContent = registro['pa_strongyloides']       !== null ? registro['pa_strongyloides']       : '--';
		fila.insertCell('td').textContent = registro['pa_ancylostoma']         !== null ? registro['pa_ancylostoma']         : '--';
		fila.insertCell('td').textContent = registro['pa_necator']             !== null ? registro['pa_necator']             : '--';

		fila.insertCell('td').textContent = registro['sangre_fecha']           !== null ? registro['sangre_fecha']           : '--';
		fila.insertCell('td').textContent = registro['nro_tubo']               !== null ? registro['nro_tubo']               : '--';
		fila.insertCell('td').textContent = registro['globulos_blancos']       !== null ? registro['globulos_blancos']       : '--';
		fila.insertCell('td').textContent = registro['hemoglobina']            !== null ? registro['hemoglobina']            : '--';
		fila.insertCell('td').textContent = registro['eosinofilos']            !== null ? registro['eosinofilos']            : '--';
		fila.insertCell('td').textContent = registro['serologia_titulo']       !== null ? registro['serologia_titulo']       : '--';
		fila.insertCell('td').textContent = registro['serologia_resultado']    !== null ? registro['serologia_resultado']    : '--';

		fila.insertCell('td').textContent = registro['fuente']                 !== null ? registro['fuente']                 : '--';
		fila.insertCell('td').textContent = registro['pcr_strongyloides']      !== null ? registro['pcr_strongyloides']      : '--';
		fila.insertCell('td').textContent = registro['pcr_ancylostoma']        !== null ? registro['pcr_ancylostoma']        : '--';
		fila.insertCell('td').textContent = registro['pcr_necator']            !== null ? registro['pcr_necator']            : '--';
		fila.insertCell('td').textContent = registro['pcr_ascaris']            !== null ? registro['pcr_ascaris']            : '--';
		fila.insertCell('td').textContent = registro['pcr_trichuris']          !== null ? registro['pcr_trichuris']          : '--';
		fila.insertCell('td').textContent = registro['qpcr_strongyloides']     !== null ? registro['qpcr_strongyloides']     : '--';
		fila.insertCell('td').textContent = registro['qpcr_ancylostoma']       !== null ? registro['qpcr_ancylostoma']       : '--';
		fila.insertCell('td').textContent = registro['qpcr_necator']           !== null ? registro['qpcr_necator']           : '--';
		fila.insertCell('td').textContent = registro['qpcr_ascaris']           !== null ? registro['qpcr_ascaris']           : '--';
		fila.insertCell('td').textContent = registro['qpcr_trichuris']         !== null ? registro['qpcr_trichuris']         : '--';

		fila.insertCell('td').textContent = registro['tratamiento_fecha']      !== null ? registro['tratamiento_fecha']      : '--';
		fila.insertCell('td').textContent = registro['no_tratado']             !== null ? registro['no_tratado']             : '--';
		fila.insertCell('td').textContent = registro['peso']                   !== null ? registro['peso']                   : '--';
		fila.insertCell('td').textContent = registro['talla']                  !== null ? registro['talla']                  : '--';
		fila.insertCell('td').textContent = registro['perimetro_cefalico']     !== null ? registro['perimetro_cefalico']     : '--';
		fila.insertCell('td').textContent = registro['trat_prev_fecha']        !== null ? registro['trat_prev_fecha']        : '--';
		fila.insertCell('td').textContent = registro['trat_prev_mebendazol']   !== null ? registro['trat_prev_mebendazol']   : '--';
		fila.insertCell('td').textContent = registro['trat_prev_albendazol']   !== null ? registro['trat_prev_albendazol']   : '--';
		fila.insertCell('td').textContent = registro['trat_prev_ivermectina']  !== null ? registro['trat_prev_ivermectina']  : '--';
		fila.insertCell('td').textContent = registro['trat_prev_metronidazol'] !== null ? registro['trat_prev_metronidazol'] : '--';
		fila.insertCell('td').textContent = registro['albendazol_dosis']       !== null ? registro['albendazol_dosis']       : '--';
		fila.insertCell('td').textContent = registro['albendazol_exclusion']   !== null ? registro['albendazol_exclusion']   : '--';
		fila.insertCell('td').textContent = registro['ivermectina_dosis']      !== null ? registro['ivermectina_dosis']      : '--';
		fila.insertCell('td').textContent = registro['ivermectina_exclusion']  !== null ? registro['ivermectina_exclusion']  : '--';
		fila.insertCell('td').textContent = registro['mebendazol_dosis']       !== null ? registro['mebendazol_dosis']       : '--';
		fila.insertCell('td').textContent = registro['mebendazol_exclusion']   !== null ? registro['mebendazol_exclusion']   : '--';
	}

	tablaFinal.normalize();
}

for(let i = 0; i < columnas.length; ++i) {
	columnas[i].dataset.i = i + 1;

	columnas[i].addEventListener('change', function(e) {
		establecerVisibilidadColumna(this);
		normalizarTabla(tablaFinal);
		/*var cantFilas = tablaFinal.cells.length,
			className = this.checked ? '' : 'oculto',
			c = this.dataset.i;

		for(let f = 0; f < cantFilas; ++f)
			tablaFinal.cells[f][c].className = className;*/
	});
}

var btnSiguiente = document.getElementById('siguiente'),
	btnAtras = document.getElementById('atras'),
	btnGuardar = document.getElementById('guardar'),
	btnExportar = document.getElementById('exp_excel'),
	btnMenu = document.getElementsByClassName('menu');

var seccMain = document.getElementById('main'),
	seccSelecCampos = document.getElementById('selec_campos');

var barraOperaciones = document.getElementsByClassName('barra_operaciones'),
	formGuardar = document.guardar_consulta;

formGuardar.addEventListener('submit', function(e) {
	e.preventDefault();

	var fd = new FormData(formGuardar);

	fd.append('condiciones', JSON.stringify(gCondiciones));
	fd.append('campos', JSON.stringify(obtenerCamposVisibles()));

	var xhr = new XMLHttpRequest();

	xhr.open('POST', '/iiet/consultas/guardar', true);
	xhr.responseType = 'json';
	xhr.addEventListener('load', function(e) {
		document.getElementById('vm_guardar').close();
	});

	xhr.send(fd);
});

btnSiguiente.addEventListener('click', function(e) {
	seccMain.className = 'oculto';
	seccSelecCampos.className = '';

	cargarDatosTodos();

	for(let columna of columnas)
		establecerVisibilidadColumna(columna);

	ocultarBarraOperaciones(0);
});

btnAtras.addEventListener('click', function(e) {
	seccMain.className = '';
	seccSelecCampos.className = 'oculto';

	ocultarBarraOperaciones(1);
});

btnGuardar.addEventListener('click', function(e) {
	window.location.hash = '#vm_guardar';
	formGuardar.nombre.focus();
	ocultarBarraOperaciones(1);
});

btnExportar.addEventListener('click', function(e) {
	var campos = obtenerCamposVisibles();

	var datos = new Map([
		['condiciones', JSON.stringify(gCondiciones)],
		['campos', JSON.stringify(campos)]
	]);

	Utils.ajax(
		'/iiet/consultas/cargar_datos_exportar',
		datos,
		function(e) {
			window.open('/iiet/consultas/exportar_excel', '_blank');
		}
	);
});

function obtenerCamposVisibles() {
	var columVisibles = tablaFinal.querySelectorAll('th:not(.oculto)'),
		campos = new Array();

	for(let i = 1; i < columVisibles.length; ++i) {
		let columna = columVisibles[i];

		campos.push([columna.dataset.campo, columna.textContent]);
	}

	return campos;
}

function ocultarBarraOperaciones(i) {
	var contenedor = barraOperaciones[i].children[0];
	contenedor.className = contenedor.className == '' ? 'oculto' : '';
}

var habilitadores = document.getElementsByClassName('habilitador');

for(let habilitador of habilitadores)
	habilitador.addEventListener('change', e => checkedTodos(habilitador));


function establecerVisibilidadColumna(input) {
	var cantFilas = tablaFinal.cells.length,
		className = input.checked ? '' : 'oculto',
		c = input.dataset.i;

	for(let f = 0; f < cantFilas; ++f)
		tablaFinal.cells[f][c].className = className;
}


function checkedTodos(input) {
	var estado = input.checked,
		campos = input.form.campo;

	for(let campo of campos) {
		campo.checked = estado;
		establecerVisibilidadColumna(campo);
	}

	normalizarTabla(tablaFinal);
}

function normalizarTabla(tabla) {
	var padding = tools.getPropertyOf(tabla.cells[0][0], 'outerWidth'),
		anchoTotal = 0,
		tw = 0;

	for(let cell of tabla.cells[0])
		if(cell.className != 'oculto')
			anchoTotal += tools.getNumber(cell.style.width) + padding;

	anchoTotal += tabla.scrollBarWidth;
	tw = anchoTotal;

	if(typeof tabla.dataset.maxWidth !== 'undefined') {
		let maxWidth = tools.getNumber(tabla.dataset.maxWidth);

		if(anchoTotal > maxWidth) {
			tw = maxWidth;
			tabla.style.display = 'block';
			tabla.style.overflowX = 'scroll';
		}
	}
	
	tabla.tHead.style.width = anchoTotal + 'px';
	tabla.tBodies[0].style.width = anchoTotal + 'px';
	tabla.style.width = tw + 'px';
}

btnMenu[0].addEventListener('click', function(e) {
	var contenedor = barraOperaciones[0].children[0];
	contenedor.className = contenedor.className == '' ? 'oculto' : '';
});

btnMenu[1].addEventListener('click', function(e) {
	var contenedor = barraOperaciones[1].children[0];
	contenedor.className = contenedor.className == '' ? 'oculto' : '';
});

var EXCESO = 367,
	gOffset = 1;

tablaPacientes.tBodies[0].addEventListener('scroll', function(e) {
	var alto = tablaPacientes.tBodies[0].scrollHeight,
		scrollY = tablaPacientes.tBodies[0].scrollTop;

	if(alto - scrollY <= EXCESO)
		peticion();
});

tablaCopro.tBodies[0].addEventListener('scroll', function(e) {
	var alto = tablaCopro.tBodies[0].scrollHeight,
		scrollY = tablaCopro.tBodies[0].scrollTop;

	if(alto - scrollY <= EXCESO)
		peticion();
});

tablaSangre.tBodies[0].addEventListener('scroll', function(e) {
	var alto = tablaSangre.tBodies[0].scrollHeight,
		scrollY = tablaSangre.tBodies[0].scrollTop;

	if(alto - scrollY <= EXCESO)
		peticion();
});

tablaBiologMolec.tBodies[0].addEventListener('scroll', function(e) {
	var alto = tablaBiologMolec.tBodies[0].scrollHeight,
		scrollY = tablaBiologMolec.tBodies[0].scrollTop;

	if(alto - scrollY <= EXCESO)
		peticion();
});

tablaTratamientos.tBodies[0].addEventListener('scroll', function(e) {
	var alto = tablaTratamientos.tBodies[0].scrollHeight,
		scrollY = tablaTratamientos.tBodies[0].scrollTop;

	if(alto - scrollY <= EXCESO)
		peticion();
});

function peticion() {
	Utils.ajax(
		'/iiet/consultas/campanias/' + (gOffset++),
		new Map([['condiciones', JSON.stringify(gCondiciones)]]),
		function(e) {
			var respuesta = e.target.response;

			gDatos = gDatos.concat(respuesta);

			cargarPacientes(respuesta, false);
			cargarCopro(respuesta, false);
			cargarSangre(respuesta, false);
			cargarTratamientos(respuesta, false);
			cargarBiologMolec(respuesta, false);
		}
	);
}