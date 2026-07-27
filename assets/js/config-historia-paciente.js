import { FormCopro } from './forms-estudios/FormCopro.js';
import { FormSangre } from './forms-estudios/FormSangre.js';
import { FormBiologMolec } from './forms-estudios/FormBiologMolec.js';
import { FormTratamiento } from './forms-estudios/FormTratamiento.js';
import { Almacen } from './Almacen.js';

function Paginacion(html, almacen) {
	var intervenciones = almacen.intervencion() || [],
		estudios = almacen.estudios() || [],
		indice = almacen.indicePag();

	this.almacen = almacen;
	this.intervenciones = [];
	this.estudios = [];
	this.indices = html.getElementsByClassName('pagination')[0];

	this.iSel = -1;

	if(indice !== null) {
		this.cargarIntervenciones(intervenciones);
		this.estudios = estudios;
		//this.selectItem(indice);
	}

	else
		mostrarNoInterv();

	html.getElementsByClassName('pag-anterior')[0].addEventListener('click', e => this.selectItem(this.iSel - 1));
	html.getElementsByClassName('pag-posterior')[0].addEventListener('click', e => this.selectItem(this.iSel + 1));
}

Paginacion.construir = function(html, almacen) {
	var pag = new Paginacion(html, almacen),
		i = almacen.indicePag();

	if(i !== null)
		pag.selectItem(i);

	return pag;
};

Paginacion.prototype.cargarIntervenciones = function(datos) {
	this.intervenciones = datos;
	this.almacen.intervencion(this.intervenciones);

	var itemSig = this.indices.removeChild(this.indices.lastElementChild);

	while(this.indices.lastElementChild !== this.indices.firstElementChild)
		this.indices.removeChild(this.indices.lastElementChild);

	for(let i = 0; i < this.intervenciones.length; ++i)
		this.indices.appendChild(this.nuevoItem(i, this.intervenciones[i]));

	this.indices.appendChild(itemSig);
};

Paginacion.prototype.cargarEstudios = function(posInterv, datos) {
	this.estudios[posInterv] = datos;
	this.almacen.estudios(this.estudios);
};

Paginacion.prototype.cargarUnaIntervencion = function(interv) {
	var pos = this.obtenerPosInterv(interv.numero);

	if(pos > -1) {
		this.estudios[pos] = null;
		this.intervenciones[pos] = interv;

		this.almacen.estudios(this.estudios);
		this.almacen.intervencion(this.intervenciones);

		return pos;
	}

	if(interv.tipo == 'CAMPANIA')
		pos = this.intervenciones.findIndex(i => i['datos_tipo'].numero == interv['datos_tipo'].numero);

	if(pos > -1) {
		this.estudios[pos] = null;
		this.intervenciones[pos] = interv;

		this.almacen.estudios(this.estudios);
		this.almacen.intervencion(this.intervenciones);

		return pos;
	}

	else {
		pos = this.intervenciones.findIndex(i => i['datos_tipo'].fecha > interv['datos_tipo'].fecha);
		pos = pos === -1 ? this.intervenciones.length : pos;
	}

	this.deselecItem();

	this.intervenciones.splice(pos, 0, interv);
	this.estudios.splice(pos, 0, null);

	this.almacen.intervencion(this.intervenciones);
	this.almacen.estudios(this.estudios);

	var itemSig = this.indices.removeChild(this.indices.lastElementChild);
	var itemAnt = this.indices.children[pos + 1] || null;

	this.indices.insertBefore(this.nuevoItem(pos, interv), itemAnt);
	this.renombrarItems(pos + 1);

	this.indices.appendChild(itemSig);

	return pos;
};

Paginacion.prototype.obtenerPosInterv = function(nro_interv) {
	return this.intervenciones.findIndex(i => i.numero == nro_interv);
};

Paginacion.prototype.obtenerEstudios = function(posInterv) {
	return this.estudios[posInterv];
};

Paginacion.prototype.obtenerIntervActual = function() {
	return this.intervenciones[this.iSel];
};

// elimina una intervención
Paginacion.prototype.eliminarInterv = function(nroInterv) {
	var pos = this.obtenerPosInterv(nroInterv);

	this.intervenciones.splice(pos, 1);
	this.estudios.splice(pos, 1);

	var item = this.indices.children[pos + 1];
	this.indices.removeChild(item);

	this.renombrarItems(pos);

	this.almacen.intervencion(this.intervenciones);
	this.almacen.estudios(this.estudios);
};

// elimina un estudio de una intervención
Paginacion.prototype.eliminarEstudioInterv = function(nroInterv, estudio) {
	var pos = this.obtenerPosInterv(nroInterv);

	this.estudios[pos][estudio] = null;
	this.almacen.estudios(this.estudios);
};

// crea un nuevo item con el textContent igual a 'i+1', establece la propiedad data-i
// con el valor 'i' y un title con una descripción de la intervención
Paginacion.prototype.nuevoItem = function(i, interv) {
	var li = document.createElement('li'),
		button  = document.createElement('button');

	li.className = 'page-item';

	button.type = 'button';
	button.className = 'page-link';
	button.dataset.i = i;
	button.textContent = (i + 1);

	if(interv.tipo == 'CAMPANIA')
		button.title = 'Campaña: ' + interv['datos_tipo'].nombre;
	
	else
		button.title = 'Ambulatorio: ' + interv['datos_tipo'].fecha;

	button.addEventListener('click', e => this.selectItem(parseInt(e.target.dataset.i)));

	li.appendChild(button);

	return li;
};

// cambia el textContent de los items a partir de la posición 'posIni'
Paginacion.prototype.renombrarItems = function(posIni) {
	for(let i = posIni; i < this.intervenciones.length; ++i) {
		this.indices.children[i+1].children[0].textContent = i + 1;
		this.indices.children[i+1].children[0].dataset.i = i;
	}
};

Paginacion.prototype.selectPrimerItem = function() {
	this.selectItem(0);
};

Paginacion.prototype.selectUltimoItem = function() {
	this.selectItem(this.intervenciones.length - 1);
};

Paginacion.prototype.selectItem = function(item) {
	document.getElementById('resumen').innerHTML = '';

	if(this.intervenciones.length === 0) {
		mostrarNoInterv();
		return;
	}

	if(this.iSel > -1 && this.iSel < this.intervenciones.length)
		this.indices.children[this.iSel+1].classList.remove('active');

	this.indices.children[item+1].classList.add('active');
	this.iSel = item;
	this.almacen.indicePag(item);

	if(item === 0)
		this.indices.firstElementChild.classList.add('disabled');

	else
		this.indices.firstElementChild.classList.remove('disabled');


	if(item + 1 === this.intervenciones.length)
		this.indices.lastElementChild.classList.add('disabled');

	else
		this.indices.lastElementChild.classList.remove('disabled');

	var interv = this.intervenciones[item],
		estudios = this.obtenerEstudios(item);

	if(interv.tipo == 'CAMPANIA') {
		mostrarDatosCampania(interv['datos_tipo']);

		gInputsId.interv.disabled = 'disabled';
		gInputsId.campania.disabled = null;
		gInputsId.campania.value = interv['datos_tipo'].numero;
	}

	else {
		mostrarDatosExterno(interv['datos_tipo']);

		gInputsId.interv.disabled = null;
		gInputsId.interv.value = interv.numero;
		gInputsId.campania.disabled = 'disabled';
	}

	if(!estudios) {
		if(interv.tipo == 'CAMPANIA') {
			$.ajax('/iiet/intervenciones/estudios_paciente/CAMPANIA/' + interv['datos_tipo'].numero + '/' + this.almacen.paciente().id, {
				dataType: 'json',
				success: resp => procesarRespuesta(resp, item)
			});
		}

		else {
			$.ajax('/iiet/intervenciones/estudios_paciente/EXTERNO/' + interv.numero, {
				dataType: 'json',
				success: resp => procesarRespuesta(resp, item)
			});
		}
	}

	else {
		objForm.reset();
		
		var estado = objForm.cargarDatosEstudios(estudios);

		if(estado)
			mostrarForm(false);

		else
			mostrarNoEstudio();
	}
};

Paginacion.prototype.deselecItem = function() {
	if(this.iSel > -1) {
		this.indices.children[this.iSel + 1].classList.remove('active');
		this.iSel = -1;
	}
};

Paginacion.prototype.vaciar = function() {
	this.iSel = -1;
	this.intervenciones = [];
	this.estudios = [];

	this.almacen.indicePag(this.iSel);
	this.almacen.intervencion(this.intervenciones);
	this.almacen.estudios(this.estudios);
};



var fbp = new FormBuscPaciente(document.buscPaciente),
	formPaciente = new FormPaciente(document.getElementById('modal-paciente'));

var inputIdPaciente = document.getElementById('id_paciente'),
	inputIdCampania = document.getElementById('id_campania'),
	inputIdInterv = document.getElementById('id_interv'),
	idIntervencion = null;

var formulario = document.getElementById('form_estudios');

var objForm = null;

var tipoForm = null,
	claveForm = null;

var almacen = new Almacen('histpac');

var btnGuardar = document.getElementById('btn-guardar'),
	btnEliminar = document.getElementById('btn-eliminar'),
	btnCrearInterv = document.getElementById('btn-crear-interv');

var gPaginacion = null;

var gInputsId = {
	interv: document.getElementById('id_interv'),
	paciente: document.getElementById('id_paciente'),
	campania: document.getElementById('id_campania')
};

var gHTMLPag = {
	elem: document.getElementById('paginacion'),
	contenido: document.getElementById('pag-contenido'),
	indices: document.getElementById('pag-indices')
};

var gMsjsEstado = {
	cargando: document.getElementById('msj-cargando'),
	noPaciente: document.getElementById('msj-no-paciente'),
	noInterv: document.getElementById('msj-no-interv'),
	noEstudios: document.getElementById('msj-no-estudios')
};

var gModal = {
	selecCampania: document.getElementById('modal-selec-campania'),
	externo: document.getElementById('modal-crear-externo'),
	eliminarInterv: document.getElementById('modal-eliminar')
};

var gBtnsOperac = {
	resumen: document.getElementById('btn-resumen'),
	eliminar: document.getElementById('btn-eliminar'),
	nuevo: document.getElementById('btn-crear-interv'),
	guardar: document.getElementById('btn-guardar')
};

var datosCampania = document.querySelectorAll('#datos-campania .datos-interv-item');
var datosExterno = document.querySelectorAll('#datos-externo .datos-interv-item');

var gDatosInterv = {
	contenedor: document.getElementById('datos-interv'),
	campania: {
		contenedor: document.getElementById('datos-campania'),
		nombre: datosCampania[0],
		fecha: datosCampania[1],
		tipo: datosCampania[2],
		localidad: datosCampania[3]
	},
	externo: {
		contenedor: document.getElementById('datos-externo'),
		nombre: datosExterno[0],
		fecha: datosExterno[1],
		procedencia: datosExterno[2],
		localidad: datosExterno[3]
	}
};

var formSelecCampania = document.formSelecCampania,
	formExterno = document.formExterno;

var gTempResumen = document.getElementById('t-resumen').content;


iniciar();

window.addEventListener('resize', normalizarPagAlto);

function iniciar() {
	normalizarPagAlto();

	switch(formulario.name) {
		case 'form_copro':
			objForm = new FormCopro();
			tipoForm = 'copro';
			claveForm = 'copro';
		break;

		case 'form_sangre':
			objForm = new FormSangre();
			tipoForm = 'sangre';
			claveForm = 'sangre';
		break;

		case 'form_biologmolec':
			objForm = new FormBiologMolec();
			tipoForm = 'biología molecular';
			claveForm = 'biolog_molec';
		break;

		case 'form_tratamiento':
			objForm = new FormTratamiento();
			tipoForm = 'tratamiento';
			claveForm = 'tratamiento';
		break;
	}

	$('.nombre-form').text(tipoForm);

	gPaginacion = Paginacion.construir(document.getElementById('paginacion'), almacen);

	var paciente = almacen.paciente();

	if(paciente) {
		gInputsId.paciente.value = paciente.id;

		fbp.establecerValores(paciente);
	}

	else
		mostrarNoPaciente();

	$.ajax('/iiet/entidades/listado_departamentos', {
		dataType: 'json',
		success: function(respuesta) {
			Forms.cargarSelect(formSelecCampania.departamento, respuesta, 'nombre', 'numero');
			Forms.cargarSelect(formExterno.departamento, respuesta, 'nombre', 'numero');
		}
	});

	establecerEventos();
	configFormSelectCampania();
	configFormExterno();
	Forms.habilitarVerificacion(formulario);
}

function configFormSelectCampania() {
	// onChange departamento
	Forms.cambioSelect(
		formSelecCampania.departamento,
		formSelecCampania.localidad,
		'/iiet/entidades/listado_localidades/',
		'nombre',
		'numero'
	);
	// onChange localidad
	Forms.cambioSelect(
		formSelecCampania.localidad,
		formSelecCampania.barrio,
		'/iiet/entidades/listado_barrios/',
		'nombre',
		'numero'
	);

	Forms.cambioSelect(
		formSelecCampania.localidad,
		formSelecCampania.paraje,
		'/iiet/entidades/listado_parajes/',
		'nombre',
		'numero'
	);
	// onChange barrio
	Forms.cambioSelect(
		formSelecCampania.barrio,
		formSelecCampania.institucion,
		'/iiet/escuelas/listado_escuelas/barrio/',
		'nombre',
		'numero'
	);
	// onChange paraje
	Forms.cambioSelect(
		formSelecCampania.paraje,
		formSelecCampania.puesto,
		'/iiet/entidades/listado_puestos/',
		'nombre',
		'numero'
	);
	Forms.cambioSelect(
		formSelecCampania.paraje,
		formSelecCampania.institucion,
		'/iiet/escuelas/listado_escuelas/paraje/',
		'nombre',
		'numero'
	);

	formSelecCampania.barrio.addEventListener('change', solicitarCampanias);
	formSelecCampania.puesto.addEventListener('change', solicitarCampanias);
	formSelecCampania.institucion.addEventListener('change', solicitarCampanias);

	Forms.excluyentes(formSelecCampania.lugar);

	$(formSelecCampania.lugar).on('change', function(e) {
		if(formSelecCampania.lugar.value == 'barrio')
			Forms.deshabilitarCampoPuesto(formSelecCampania);

		else if(!formSelecCampania['check-institucion'].checked)
			Forms.habilitarCampoPuesto(formSelecCampania);
	});

	$('#sc-check-institucion').on('change', function(e) {
		if(this.checked) {
			Forms.deshabilitarCampoPuesto(formSelecCampania);
			Forms.habilitarCampoInstitucion(formSelecCampania);
		}

		else {
			if(formSelecCampania.lugar[1].checked)
				Forms.habilitarCampoPuesto(formSelecCampania);

			Forms.deshabilitarCampoInstitucion(formSelecCampania);
		}
	});

	document.getElementById('btn-selec-campania').addEventListener('click', function(e) {
		var nroCampania = formSelecCampania.campania.value;

		$.ajax('/iiet/campanias/datos/' + nroCampania, {
			dataType: 'json',
			success: function(campania) {
				var interv = {
					numero: null,
					tipo: 'CAMPANIA',
					datos_tipo: {
						numero: campania.numero,
						nombre: campania.nombre,
						fecha: campania.fecha_inicio,
						tipo: campania.tipo,
						localidad: campania.localidad
					}
				};

				var pos = gPaginacion.cargarUnaIntervencion(interv);
				gPaginacion.selectItem(pos);

				$(gModal.selecCampania).modal('hide');
				nuevaAlerta('exito', 'La intervención fue creada exitosamente');
			},
			error: function() {
				$(gModal.externo).modal('hide');
				nuevaAlerta('error', 'Ocurrió un error al intentar crear la intervención');
			}
		});
	});

	function solicitarCampanias() {
		var datos = {};

		if(formSelecCampania['check-institucion'].checked)
			datos = { escuela: formSelecCampania.institucion.value };

		else if(formSelecCampania.lugar[1].checked)
			datos = { puesto: formSelecCampania.puesto.value };

		else
			datos = { barrio: formSelecCampania.barrio.value };

		$.ajax('/iiet/campanias/listado_campanias', {
			dataType: 'json',
			method: 'POST',
			data: datos,
			success: function(resp) {
				Forms.cargarSelect(formSelecCampania.campania, resp, 'nombre', 'numero');
			}
		});
	}
}

function configFormExterno() {
	// onChange departamento
	Forms.cambioSelect(
		formExterno.departamento,
		formExterno.localidad,
		'/iiet/entidades/listado_localidades/',
		'nombre',
		'numero'
	);
	// onChange localidad
	Forms.cambioSelect(
		formExterno.localidad,
		formExterno.barrio,
		'/iiet/entidades/listado_barrios/',
		'nombre',
		'numero'
	);

	Forms.cambioSelect(
		formExterno.localidad,
		formExterno.paraje,
		'/iiet/entidades/listado_parajes/',
		'nombre',
		'numero'
	);
	// onChange barrio
	Forms.cambioSelect(
		formExterno.barrio,
		formExterno.institucion,
		'/iiet/escuelas/listado_escuelas/barrio/',
		'nombre',
		'numero'
	);
	// onChange paraje
	Forms.cambioSelect(
		formExterno.paraje,
		formExterno.institucion,
		'/iiet/escuelas/listado_escuelas/paraje/',
		'nombre',
		'numero'
	);

	Forms.excluyentes(formExterno.lugar);

	$(gModal.externo).on('show.bs.modal', function(e) {
		formExterno.paciente.value = formulario['intervencion[paciente]'].value;
	});

	document.getElementById('btn-crear-externo').addEventListener('click', function(e) {
		$.ajax('/iiet/intervenciones/nuevo_consult_ext', {
			dataType: 'json',
			method: 'POST',
			data: $(formExterno).serialize(),
			success: function(interv) {
				var pos = gPaginacion.cargarUnaIntervencion(interv);

				gPaginacion.selectItem(pos);
				$(gModal.externo).modal('hide');
				nuevaAlerta('exito', 'La intervención fue creada exitosamente');

			},
			error: function() {
				$(gModal.externo).modal('hide');
				nuevaAlerta('error', 'Ocurrió un error al intentar crear la intervención');
			}
		});
	});
}

function normalizarPagAlto() {
	var pagAlto = window.innerHeight - $(gHTMLPag.elem).offset().top;

	gHTMLPag.elem.style.height = pagAlto + 'px';
	gHTMLPag.contenido.style.height = pagAlto - $(gHTMLPag.indices).height() - 2 + 'px';
}

function establecerEventos() {
	var formTipoInterv = document.formTipoInterv;

	document.getElementById('ir-inicio').addEventListener('click', function(e) {
		e.preventDefault();

		almacen.limpiar();

		window.location.href = '/iiet/inicio/operario';
	});

	window.addEventListener('buscpac.mostrar', function(e) {
		var paciente = e.detail.paciente;

		if(paciente) {
			$.ajax('/iiet/pacientes/obtener_datos/' + paciente.id, {
				dataType: 'json',
				success: function(resp) {
					formPaciente.configModalEditar(resp);

					$('#modal-paciente').modal({
						backdrop: 'static',
						keyboard: false
					});
				}
			});
		}
	});

	window.addEventListener('buscpac.nuevo', function(e) {
		var datos = e.detail.datosPaciente;

		formPaciente.configModalNuevo(datos);

		$('#modal-paciente').modal({
			backdrop: 'static',
			keyboard: false
		});
	});

	window.addEventListener('buscpac.cambio', function(e) {
		var paciente = e.detail.paciente;

		almacen.paciente(paciente);
		gPaginacion.vaciar();
		document.getElementById('resumen').innerHTML = '';

		if(paciente) {
			gInputsId.paciente.value = paciente.id;

			mostrarCargando();

			$.ajax('/iiet/intervenciones/intervenciones_paciente/' + paciente.id, {
				dataType: 'json',
				success: function(interv) {
					gPaginacion.cargarIntervenciones(interv);
					gPaginacion.selectItem(interv.length - 1);
				}
			});
		}

		else {
			gInputsId.paciente.value = null;
			mostrarNoPaciente();
		}
	});

	document.getElementById('btn-cargar').addEventListener('click', function(e) {
		mostrarForm(true);
	});

	objForm.accionPreSubmit( () => mostrarCargando() );

	objForm.exito(function(interv) {
		var pos = gPaginacion.cargarUnaIntervencion(interv);
		gPaginacion.selectItem(pos);

		nuevaAlerta('exito', 'Creación o actualización de los datos realizada con éxito');
	});

	objForm.error(function() {
		mostrarForm(false);
		nuevaAlerta('error', 'Ocurrió un error al intentar crear o actualizar los datos');
	});

	formPaciente.exito(function(resp) {
		var nombPac = formPaciente.elem.apellido.value + ', ' + formPaciente.elem.nombre.value,
			dni = formPaciente.elem.dni.value,
			paciente = {
				id: resp.id,
				dni: dni,
				str: nombPac
			};

		inputIdPaciente.value = paciente.id;

		fbp.establecerValores(paciente);
		almacen.paciente(paciente);

		var strExito = 'El paciente ' + nombPac + ' (' + dni + ') fue registrado con éxito';

		formPaciente.modal.modal('hide');

		mostrarNoEstudio();
		nuevaAlerta('exito', strExito);
	});

	var modalEliminar = document.getElementById('modal-eliminar'),
		btnsModal = modalEliminar.querySelectorAll('.modal-footer > button');

	btnsModal[1].addEventListener('click', function(e) {
		var interv = gPaginacion.obtenerIntervActual();

		$.ajax('/iiet/intervenciones/eliminar_' + claveForm + '/' + interv.numero, {
			success: function(quedanEstudios) {
				nuevaAlerta('exito', 'Estudio eliminado con éxito');

				if(quedanEstudios) {
					gPaginacion.eliminarEstudioInterv(interv.numero, claveForm);
					mostrarNoEstudio();
				}

				else {
					gPaginacion.eliminarInterv(interv.numero);
					gPaginacion.selectUltimoItem();
				}

				$(modalEliminar).modal('hide');
			}
		})
	});

	btnsModal[2].addEventListener('click', function(e) {
		var interv = gPaginacion.obtenerIntervActual();

		$.ajax('/iiet/intervenciones/eliminar/' + interv.numero, {
			dataType: 'json',
			success: function(resp) {
				$(modalEliminar).modal('hide');

				nuevaAlerta('exito', 'Intervención eliminada con éxito');
				gPaginacion.eliminarInterv(interv.numero);
				gPaginacion.selectUltimoItem();
			}
		});
	});

	document.getElementById('btn-sig-tipo-interv').addEventListener('click', function(e) {
		$('#modal-crear-interv').modal('hide');

		if(formTipoInterv.tipo.value == 'CAMPANIA')
			$('#modal-selec-campania').modal();

		else
			$('#modal-crear-externo').modal();
	});

	document.getElementById('btn-resumen').addEventListener('click', function(e) {
		var contResumen = document.getElementById('resumen');

		contResumen.innerHTML = '';

		var clon = document.importNode(gTempResumen, true);
		contResumen.appendChild(clon);

		var interv = gPaginacion.obtenerIntervActual(),
			posInterv = gPaginacion.obtenerPosInterv(interv.numero),
			copro = gPaginacion.obtenerEstudios(posInterv).copro,
			resumen = contResumen.children[0];

		var ascaris = esAscarisPositivo(copro),
			trichuris = esTrichurisPositivo(copro),
			strongyloides = esStrongyloidesPositivo(copro),
			ancylostoma = esAncylostomaPositivo(copro),
			necator = esNecatorPositivo(copro),
			uncinarias = esUncinariasPositivo(copro, ancylostoma, necator);

		resumen.children[2].children[0].classList.add(iconoPositividad(ascaris));
		resumen.children[3].children[0].classList.add(iconoPositividad(uncinarias));
		resumen.children[4].children[0].classList.add(iconoPositividad(ancylostoma));
		resumen.children[5].children[0].classList.add(iconoPositividad(necator));
		resumen.children[6].children[0].classList.add(iconoPositividad(strongyloides));
		resumen.children[7].children[0].classList.add(iconoPositividad(trichuris));
	});

	$('#form_estudios .collapse').on('shown.bs.collapse', calcularAltoForm);
	$('#form_estudios .collapse').on('hidden.bs.collapse', calcularAltoForm);
}

function mostrarDatosCampania(datos) {
	gDatosInterv.contenedor.classList.remove('d-none');
	gDatosInterv.campania.contenedor.classList.remove('d-none');
	gDatosInterv.externo.contenedor.classList.add('d-none');

	gDatosInterv.campania.nombre.textContent = datos.nombre;
	gDatosInterv.campania.fecha.textContent = datos.fecha.split('-').reverse().join('/');
	gDatosInterv.campania.tipo.textContent = datos.tipo;
	gDatosInterv.campania.localidad.textContent = datos.localidad;
}

function mostrarDatosExterno(datos) {
	gDatosInterv.contenedor.classList.remove('d-none');
	gDatosInterv.campania.contenedor.classList.add('d-none');
	gDatosInterv.externo.contenedor.classList.remove('d-none');

	gDatosInterv.externo.nombre.textContent = datos.fecha.split('-').reverse().join('/');
	gDatosInterv.externo.fecha.textContent = datos.fecha.split('-').reverse().join('/');
	gDatosInterv.externo.procedencia.textContent = datos.procedencia;
	gDatosInterv.externo.localidad.textContent = datos.localidad;
}

function mostrarForm(estaVacio) {
	gMsjsEstado.cargando.classList.add('d-none');
	gMsjsEstado.noPaciente.classList.add('d-none');
	gMsjsEstado.noInterv.classList.add('d-none');
	gMsjsEstado.noEstudios.classList.add('d-none');

	formulario.classList.remove('d-none');

	gHTMLPag.indices.classList.remove('d-none');

	gBtnsOperac.guardar.classList.remove('d-none');
	gBtnsOperac.nuevo.classList.remove('d-none');

	if(!estaVacio) {
		gBtnsOperac.eliminar.classList.remove('d-none');
		if(tipoForm == 'copro') {
			/*var interv = gPaginacion.obtenerIntervActual(),
				posInterv = gPaginacion.obtenerPosInterv(interv.numero),
				estudios = gPaginacion.obtenerEstudios(posInterv);*/

			//if(estudios.copro)
				gBtnsOperac.resumen.classList.remove('d-none');
		}
	}

	calcularAltoForm();

	fbp.enfocar();
	window.scrollTo(0, 0);
}

function mostrarNoPaciente() {
	formulario.classList.add('d-none');
	
	gMsjsEstado.cargando.classList.add('d-none');
	gMsjsEstado.noInterv.classList.add('d-none');
	gMsjsEstado.noEstudios.classList.add('d-none');

	gMsjsEstado.noPaciente.classList.remove('d-none');

	gDatosInterv.contenedor.classList.add('d-none');
	gHTMLPag.indices.classList.add('d-none');

	btnGuardar.classList.add('d-none');
	btnEliminar.classList.add('d-none');
	btnCrearInterv.classList.add('d-none');
}

function mostrarNoInterv() {
	formulario.classList.add('d-none');
	
	gMsjsEstado.cargando.classList.add('d-none');
	gMsjsEstado.noPaciente.classList.add('d-none');
	gMsjsEstado.noEstudios.classList.add('d-none');

	gMsjsEstado.noInterv.classList.remove('d-none');

	gHTMLPag.indices.classList.add('d-none');

	gDatosInterv.contenedor.classList.add('d-none');

	gBtnsOperac.guardar.classList.add('d-none');
	gBtnsOperac.resumen.classList.add('d-none');
	gBtnsOperac.eliminar.classList.add('d-none');
	gBtnsOperac.nuevo.classList.remove('d-none');
}

function mostrarNoEstudio() {
	formulario.classList.add('d-none');
	
	gMsjsEstado.cargando.classList.add('d-none');
	gMsjsEstado.noPaciente.classList.add('d-none');
	gMsjsEstado.noInterv.classList.add('d-none');

	gMsjsEstado.noEstudios.classList.remove('d-none');

	gHTMLPag.indices.classList.remove('d-none');

	gBtnsOperac.guardar.classList.add('d-none');
	gBtnsOperac.resumen.classList.add('d-none');
	gBtnsOperac.eliminar.classList.add('d-none');

	gBtnsOperac.nuevo.classList.remove('d-none');
}

function mostrarCargando() {
	formulario.classList.add('d-none');
	
	gMsjsEstado.noPaciente.classList.add('d-none');
	gMsjsEstado.noInterv.classList.add('d-none');
	gMsjsEstado.noEstudios.classList.add('d-none');

	gMsjsEstado.cargando.classList.remove('d-none');

	gHTMLPag.indices.classList.add('d-none');

	gBtnsOperac.guardar.classList.add('d-none');
	gBtnsOperac.resumen.classList.add('d-none');
	gBtnsOperac.eliminar.classList.add('d-none');
	gBtnsOperac.nuevo.classList.add('d-none');
}

function respuestaCargaDatosExito(respuesta) {
	procesarRespuesta(respuesta);
	nuevaAlerta('exito', 'Creación o actualización de los datos realizada con éxito');
}

function procesarRespuesta(resp, i) {
	if(resp && resp.estudios) {
		gPaginacion.cargarEstudios(i, resp.estudios);

		objForm.reset();
	
		var estado = objForm.cargarDatosEstudios(resp.estudios);

		if(estado)
			mostrarForm(false);

		else
			mostrarNoEstudio();
	}

	else {
		almacen.estudios(null);
		mostrarNoEstudio();
	}
}

function nuevaAlerta(tipo, msj) {
	var alerta = document.createElement('p'),
		icono = document.createElement('span'),
		boton = document.createElement('button');

	alerta.className = 'alert animated slideInLeft';
	icono.className = 'fa mr-2';

	boton.type = 'button';
	boton.className = 'close ml-5';
	boton.dataset.dismiss = 'alert';
	boton.textContent = '\xd7';

	var classAlerta = 'alert-success',
		iconoAlerta = 'fa-check-circle';

	if(tipo == 'error') {
		classAlerta = 'alert-danger';
		iconoAlerta = 'fa-times-circle';
	}

	alerta.appendChild(icono);

	alerta.classList.add(classAlerta);
	alerta.appendChild(document.createTextNode(msj));

	icono.classList.add(iconoAlerta);

	alerta.appendChild(boton);

	document.getElementById('alertas').appendChild(alerta);
}

function calcularAltoForm() {
	if($(formulario).height() > $(gHTMLPag.contenido).height())
		gHTMLPag.contenido.style.overflowY = 'scroll';

	else
		gHTMLPag.contenido.style.overflowY = 'hidden';
}

function esAscarisPositivo(copro) {
	var resultado = null;

	if(copro.concentrado) {
		if(copro.concentrado.ascaris == 'POSITIVO')
			return true;

		resultado = false;
	}

	if(copro.mc_master) {
		if(copro.mc_master.ascaris > 0)
			return true;

		resultado = false;
	}

	return resultado;
}

function esTrichurisPositivo(copro) {
	var resultado = null;

	if(copro.concentrado) {
		if(copro.concentrado.trichuris == 'POSITIVO')
			return true;

		resultado = false;
	}

	if(copro.mc_master) {
		if(copro.mc_master.trichuris > 0)
			return true;

		resultado = false;
	}

	return resultado;
}

function esStrongyloidesPositivo(copro) {
	var resultado = null;

	if(copro.concentrado) {
		if(copro.concentrado.strongyloides == 'POSITIVO')
			return true;

		resultado = false;
	}

	if(copro.harada_mori) {
		if(copro.harada_mori.strongyloides != 'NEGATIVO')
			return true;

		resultado = false;
	}

	if(copro.baerman) {
		if(copro.baerman.strongyloides != 'NEGATIVO')
			return true;

		resultado = false;
	}

	if(copro.placa_agar) {
		if(copro.placa_agar.strongyloides != 'NEGATIVO')
			return true;

		resultado = false;
	}

	return resultado;
}

function esAncylostomaPositivo(copro) {
	var resultado = null;

	if(copro.harada_mori) {
		if(copro.harada_mori.ancylostoma != 'NEGATIVO')
			return true;

		resultado = false;
	}

	if(copro.baerman) {
		if(copro.baerman.ancylostoma != 'NEGATIVO')
			return true;

		resultado = false;
	}

	if(copro.placa_agar) {
		if(copro.placa_agar.ancylostoma != 'NEGATIVO')
			return true;

		resultado = false;
	}

	return resultado;
}

function esNecatorPositivo(copro) {
	var resultado = null;

	if(copro.harada_mori) {
		if(copro.harada_mori.necator != 'NEGATIVO')
			return true;

		resultado = false;
	}

	if(copro.baerman) {
		if(copro.baerman.necator != 'NEGATIVO')
			return true;

		resultado = false;
	}

	if(copro.placa_agar) {
		if(copro.placa_agar.necator != 'NEGATIVO')
			return true;

		resultado = false;
	}

	return resultado;
}

function esUncinariasPositivo(copro, ancylostoma, necator) {
	var resultado = null;

	if(copro.concentrado) {
		if(copro.concentrado.uncinarias == 'POSITIVO')
			return true;

		resultado = false;
	}

	if(copro.mc_master) {
		if(copro.mc_master.uncinarias > 0)
			return true;

		resultado = false;
	}

	if(ancylostoma === true)
		return true;

	if(ancylostoma === false)
		resultado = false;

	if(necator === true)
		return true;

	if(necator === false)
		resultado = false;

	return resultado;
}

function iconoPositividad(valor) {
	switch(valor) {
		case true:
			return 'fa-plus-circle';
		break;

		case false:
			return 'fa-minus-circle';
		break;

		default:
			return 'fa-times-circle';
	}
}