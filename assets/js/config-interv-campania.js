import { FormCopro } from './forms-estudios/FormCopro.js';
import { FormSangre } from './forms-estudios/FormSangre.js';
import { FormBiologMolec } from './forms-estudios/FormBiologMolec.js';
import { FormTratamiento } from './forms-estudios/FormTratamiento.js';
import { Almacen } from './Almacen.js';

var fbp = new FormBuscPaciente(document.buscPaciente),
	formPaciente = new FormPaciente(document.getElementById('modal-paciente'));

var inputIdPaciente = document.getElementById('id_paciente'),
	inputIdCampania = document.getElementById('id_campania'),
	idIntervencion = null;

var formulario = document.getElementById('form_estudios');

var objForm = null;

var tipoForm = null,
	claveForm = null;

var almacen = new Almacen('estcamp');

var noEstudio = document.getElementsByClassName('no-estudio');

var btnGuardar = document.getElementById('btn-guardar'),
	btnEliminar = document.getElementById('btn-eliminar');


iniciar();

function iniciar() {
	var alto = window.innerHeight - $(noEstudio[0]).offset().top - 100;

	noEstudio[0].style.height = alto + 'px';
	noEstudio[1].style.height = alto + 'px';
	noEstudio[2].style.height = alto + 'px';

	noEstudio[0].classList.add('d-none');
	noEstudio[1].classList.add('d-none');
	noEstudio[2].classList.add('d-none');

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

	var campania = almacen.campania(),
		paciente = almacen.paciente(),
		estudios = almacen.estudios(),
		idIntervencion = almacen.intervencion();

	if(campania) {
		document.getElementById('nombre-campania').textContent = campania.nombre;
		inputIdCampania.value = campania.numero;
	}

	if(paciente) {
		inputIdPaciente.value = paciente.id;

		fbp.establecerValores(paciente);

		if(estudios && objForm.cargarDatosEstudios(estudios))
			mostrarForm(false);

		else
			mostrarNoEstudio();
	}

	else
		mostrarNoPaciente();

	establecerEventos();

	Forms.habilitarVerificacion(formulario);
}

function establecerEventos() {
	document.getElementById('ir-campanias').addEventListener('click', function(e) {
		e.preventDefault();

		almacen.limpiar();

		window.location.href = '/iiet/campanias';
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

		if(paciente) {
			inputIdPaciente.value = paciente.id;

			mostrarCargando();

			$.ajax('/iiet/intervenciones/estudios_paciente/CAMPANIA/' + inputIdCampania.value + '/' + paciente.id, {
				dataType: 'json',
				success: procesarRespuesta
			});
		}

		else {
			inputIdPaciente.value = null;
			mostrarNoPaciente();
		}
	});

	document.getElementById('btn-cargar').addEventListener('click', function(e) {
		mostrarForm(true);
	});

	objForm.accionPreSubmit( () => mostrarCargando() );

	objForm.exito(function(interv) {
		idIntervencion = interv.numero; // TODO: revisar ya que parece inecesario el numero de intervencion
		almacen.intervencion(interv.numero);

		$.ajax('/iiet/intervenciones/estudios_paciente/CAMPANIA/' + inputIdCampania.value + '/' + inputIdPaciente.value, {
			dataType: 'json',
			success: respuestaCargaDatosExito
		});
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
		$.ajax('/iiet/intervenciones/eliminar_' + claveForm + '/' + almacen.intervencion(), {
			success: function(quedanEstudios) {
				nuevaAlerta('exito', 'Estudio eliminado con éxito');
				mostrarNoEstudio();

				if(quedanEstudios) {
					var estudios = almacen.estudios();

					estudios[claveForm] = null;
					almacen.estudios(estudios);
				}

				else {
					almacen.intervencion(null);
					almacen.estudios(null);
				}

				$(modalEliminar).modal('hide');
			}
		})
	});

	btnsModal[2].addEventListener('click', function(e) {
		$.ajax('/iiet/intervenciones/eliminar/' + almacen.intervencion(), {
			dataType: 'json',
			success: function(resp) {
				nuevaAlerta('exito', 'Intervención eliminada con éxito');
				mostrarNoEstudio();

				almacen.estudios(null);
				almacen.intervencion(null);

				$(modalEliminar).modal('hide');
			}
		});
	});
}

function mostrarForm(estaVacio) {
	noEstudio[0].classList.add('d-none');
	noEstudio[1].classList.add('d-none');
	noEstudio[2].classList.add('d-none');

	formulario.classList.remove('d-none');

	btnGuardar.classList.remove('d-none');

	estaVacio || btnEliminar.classList.remove('d-none');

	fbp.enfocar();
	window.scrollTo(0, 0);
}

function mostrarNoPaciente() {
	formulario.classList.add('d-none');
	noEstudio[0].classList.add('d-none');
	noEstudio[2].classList.add('d-none');

	noEstudio[1].classList.remove('d-none');

	btnGuardar.classList.add('d-none');
	btnEliminar.classList.add('d-none');
}

function mostrarNoEstudio() {
	formulario.classList.add('d-none');
	noEstudio[0].classList.add('d-none');
	noEstudio[1].classList.add('d-none');

	noEstudio[2].classList.remove('d-none');

	btnGuardar.classList.add('d-none');
	btnEliminar.classList.add('d-none');
}

function mostrarCargando() {
	formulario.classList.add('d-none');
	noEstudio[1].classList.add('d-none');
	noEstudio[2].classList.add('d-none');

	noEstudio[0].classList.remove('d-none');

	btnGuardar.classList.add('d-none');
	btnEliminar.classList.add('d-none');
}

function respuestaCargaDatosExito(respuesta) {
	procesarRespuesta(respuesta);
	nuevaAlerta('exito', 'Creación o actualización de los datos realizada con éxito');
}

function procesarRespuesta(respuesta) {
	if(respuesta && respuesta.estudios) {
		almacen.intervencion(respuesta.intervencion);
		almacen.estudios(respuesta.estudios);

		objForm.reset();
	
		var estado = objForm.cargarDatosEstudios(respuesta.estudios);

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