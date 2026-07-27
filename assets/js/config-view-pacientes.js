import { Almacen } from './Almacen.js';

/*******************************************************/
/*                  tabla pacientes                    */
/*******************************************************/

var tablaPacientes = $('#tabla-pacientes').DataTable({
	language: obtenerObjIdioma('pacientes', 'Apellido , Nombre : DNI'),
    processing: true,
    serverSide: true,
    ajax: $.fn.dataTable.pipeline({
        url: '/iiet/pacientes/listar',
        method: 'POST',
        pages: 5 // number of pages to cache
    }),
    rowId: 'dt_rowid',
  	columns: [
  		{ data: 'numero' },
  		{ data: 'dni' },
  		{ data: 'apellido' },
  		{ data: 'nombre' },
  		{ data: 'sexo' },
  		{ data: p => formatearFecha(p.fecha_nacimiento) },
  		{ data: p => crearBtnsAccionPaciente(p.numero) }
  	]
});

function formatearFecha(strFecha) {
	var fecha = new Date(strFecha),
		dia = fecha.getDate() + 1,
		mes = fecha.getMonth() + 1,
		anio = fecha.getFullYear();

	dia = dia < 10 ? '0' + dia : dia;
	mes = mes < 10 ? '0' + mes : mes;

	return (dia + '/' + mes + '/' + anio);
}

function crearBtnsAccionPaciente(id) {
	var operaciones = document.createElement('div'),
		btnEditar   = document.createElement('a'),
		btnEvent    = document.createElement('button'),
		btnEliminar = document.createElement('a');

	btnEditar.href      = '#form-paciente';
	btnEditar.title     = 'Editar datos';
	btnEditar.className = 'btn-editar btn btn-outline-success fa fa-pencil-alt mr-1';
	btnEditar.dataset.toggle = 'modal';
	btnEditar.dataset.backdrop = 'static';
	btnEditar.dataset.keyboard = 'false';
	btnEditar.dataset.formModo = 'actualizar';

	btnEvent.type      = 'button';
	btnEvent.title     = 'Abrir panel de Eventos';
	btnEvent.className = 'btn-eventos btn btn-outline-info fa fa-folder-open mr-1';

	btnEliminar.href      = '#elim-paciente';
	btnEliminar.title     = 'Eliminar paciente';
	btnEliminar.className = 'btn-eliminar btn btn-outline-danger fa fa-trash-alt';
	btnEliminar.dataset.toggle   = 'modal';
	btnEliminar.dataset.backdrop = 'static';
	btnEliminar.dataset.keyboard = 'false';

	operaciones.appendChild(btnEditar);
	operaciones.appendChild(btnEvent);
	operaciones.appendChild(btnEliminar);

	return operaciones.innerHTML;
}

tablaPacientes.on('click', 'tbody .btn-eventos', function(e) {
	var fila = e.target.parentNode.parentNode,
		datos = tablaPacientes.row(fila).data();

	var almacen = new Almacen('histpac');

	almacen.paciente({
		id: datos.numero,
		dni: datos.dni,
		str: datos.apellido + ', ' + datos.nombre
	});

	almacen.indicePag(0);

	$.ajax('/iiet/intervenciones/intervenciones_paciente/' + datos.numero, {
		dataType: 'json',
		success: function(interv) {
			almacen.intervencion(interv);
			window.location.href = '/iiet/eventos';
		}
	});
});


/*******************************************************/
/*            modal y formulario pacientes             */
/*******************************************************/

var formPaciente = document.fPaciente;

$('#form-paciente').on('show.bs.modal', function(e) {
	var formModo = e.relatedTarget.dataset.formModo;

	formPaciente.reset();
	formPaciente.dataset.modo = formModo;

	if(formModo == 'nuevo')
		configModalNuevoPaciente();

	else {
		var fila = e.relatedTarget.parentNode.parentNode,
			datos = tablaPacientes.row(fila).data();

		configModalEditarPaciente(datos);
	}
});

$('#form-paciente').on('shown.bs.modal', function(e) {
	formPaciente.dni.focus();
});

function configModalNuevoPaciente() {
	$('#form-paciente .modal-header h4').text('Nuevo Pacientexdxd');

	formPaciente.enviar.value = 'Crear';
	formPaciente.numero.disabled = 'disabled';
	formPaciente.dni.orig = null;
}

function configModalEditarPaciente(datos) {
    $('#form-paciente .modal-header h4').text('Actualizar Paciente');

    formPaciente.enviar.value = 'Actualizar';
    formPaciente.numero.disabled = null;
    formPaciente.dni.orig = datos.dni;

    formPaciente.numero.value = datos.numero;
    formPaciente.dni.value = datos.dni;
    formPaciente.nro_cuaderno.value = datos.nro_cuaderno;
    formPaciente.apellido.value = datos.apellido;
    formPaciente.nombre.value = datos.nombre;
    formPaciente.fecha_nacimiento.value = datos.fecha_nacimiento;
    formPaciente.sexo.value = datos.sexo.trim();

    cargarDivPolits(formPaciente, datos);

    if(datos.nro_puesto)
        habilitarCampoPuesto();

    formPaciente.domicilio.value = datos.domicilio;

    // ⭐ AGREGAR COORDENADAS
    if (datos.latitud && datos.longitud) {
        document.getElementById('fn-lat').value = datos.latitud;
        document.getElementById('fn-lng').value = datos.longitud;
        // Mover el mapa a la ubicación
        if (typeof moverMapa === 'function') {
            moverMapa(parseFloat(datos.latitud), parseFloat(datos.longitud));
        }
    } else {
        document.getElementById('fn-lat').value = '';
        document.getElementById('fn-lng').value = '';
        if (typeof resetMapa === 'function') {
            resetMapa();
        }
    }
}

$.ajax('/iiet/entidades/listado_departamentos', {
	dataType: 'json',
	success: function(respuesta) {
		cargarSelect(document.fPaciente.departamento, respuesta, 'nombre', 'numero');
	}
});

// onChange departamento
cambioSelect(
	formPaciente.departamento,
	formPaciente.localidad,
	'/iiet/entidades/listado_localidades/',
	'nombre',
	'numero'
);
// onChange localidad
cambioSelect(
	formPaciente.localidad,
	formPaciente.barrio,
	'/iiet/entidades/listado_barrios/',
	'nombre',
	'numero'
);

cambioSelect(
	formPaciente.localidad,
	formPaciente.paraje,
	'/iiet/entidades/listado_parajes/',
	'nombre',
	'numero'
);
// onChange paraje
cambioSelect(
	formPaciente.paraje,
	formPaciente.puesto,
	'/iiet/entidades/listado_puestos/',
	'nombre',
	'numero'
);

validarFecha(formPaciente.fecha_nacimiento);

excluyentes(formPaciente.lugar);

formPaciente.lugar[0].addEventListener('change', deshabilitarCampoPuesto);
formPaciente.lugar[1].addEventListener('change', habilitarCampoPuesto);

formPaciente.addEventListener('reset', function(e) {
	resetForm(formPaciente);
	excluir(formPaciente.lugar, formPaciente.lugar[0]);
	deshabilitarCampoPuesto();
	limpiarDependientes(formPaciente.departamento);

	$('#alert-np-error').html('');
});

formPaciente.addEventListener('submit', function(e) {
    e.preventDefault();

    this.classList.add('was-validated');

    if(this.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        return;
    }

    //  OBTENER COORDENADAS DE LOS CAMPOS OCULTOS
    var latitud = document.getElementById('fn-lat').value;
    var longitud = document.getElementById('fn-lng').value;

    //  CREAR OBJETO CON TODOS LOS DATOS
    var datosForm = $(formPaciente).serialize();
    
    //  SI HAY COORDENADAS, AGREGARLAS
    if (latitud && longitud) {
        datosForm += '&latitud=' + latitud + '&longitud=' + longitud;
    }

    $.ajax('/iiet/pacientes/' + formPaciente.dataset.modo, {
        method: 'POST',
        data: datosForm,
        success: opPacienteExito,
        error: opPacienteError
    });
});

function opPacienteExito(respuesta) {
	tablaPacientes.clearPipeline();
	tablaPacientes.ajax.reload();

	var p = document.createElement('p'),
		span = document.createElement('span'),
		button = document.createElement('button');

	var apellido = formPaciente.apellido.value,
		nombre = formPaciente.nombre.value,
		dni = formPaciente.dni.value;

	p.className = 'alert alert-success';
	p.appendChild(document.createTextNode('El paciente '));

	span.className = 'font-weight-bold';
	span.textContent = apellido + ', ' + nombre + ' ( DNI: ' + dni + ' )';
	p.appendChild(span);

	if(formPaciente.dataset.modo == 'nuevo')
		p.appendChild(document.createTextNode(' fue creado con éxito'));
	else
		p.appendChild(document.createTextNode(' fue actualizado con éxito'));

	button.type = 'button';
	button.className = 'close';
	button.dataset.dismiss = 'alert';
	button.textContent = '\xd7';
	p.appendChild(button);

	$('#alertas').append(p);

	$('#form-paciente').modal('hide');
}

function opPacienteError() {
	var p = document.createElement('p'),
		button = document.createElement('button');

	p.className = 'alert alert-danger';
	p.textContent = 'Ocurrió un error al intentar crear al paciente';

	button.type = 'button';
	button.className = 'close';
	button.dataset.dismiss = 'alert';
	button.textContent = '\xd7';
	p.appendChild(button);

	$('#alert-np-error').append(p);
}

$('#elim-paciente').on('show.bs.modal', function(e) {
	var fila = e.relatedTarget.parentNode.parentNode,
		datos = tablaPacientes.row(fila).data();

	$.ajax(
		'/iiet/pacientes/fue_intervenido/' + datos.numero,
		{
			dataType: 'json',
			success: function(respuesta) {
				if(respuesta === true) {
					$('#sin_eventos').addClass('d-none');
					$('#con_eventos').removeClass('d-none');
				}

				else {
					$('#con_eventos').addClass('d-none');
					$('#sin_eventos').removeClass('d-none');
				}

				$('#elim-paciente-confirm').data('id-paciente', datos.numero);

				$('.text-paciente').text(datos.apellido + ', ' + datos.nombre + ' ' + '( DNI: ' + datos.dni + ' )');
			}
		}
	);
});

$('#elim-paciente-confirm').on('click', function(e) {
	var id = $(this).data('id-paciente'),
		datos = tablaPacientes.row($('#tp_' + id)).data();

	$.ajax(
		'/iiet/pacientes/eliminar/' + id,
		{
			dataType: 'json',
			success: function(respuesta) {
				tablaPacientes.clearPipeline();
				tablaPacientes.ajax.reload(null, false);

				var textPaciente = datos.apellido + ', ' + datos.nombre + ' ' + '( DNI: ' + datos.dni + ' )';

				mostrarAlertElim(true, textPaciente);

				$('#elim-paciente').modal('hide');
			},
			error: function(respuesta) {
				mostrarAlertElim(true);

				$('#elim-paciente').modal('hide');
			}
		}
	);
});

function mostrarAlertElim(exito, textPaciente) {
	var p = document.createElement('p'),
		span = document.createElement('span'),
		button = document.createElement('button');

	p.className = 'col-12 animated bounce alert alert-' + (exito ? 'success' : 'danger');

	span.className = 'font-weight-bold';
	span.textContent = textPaciente;

	button.type = 'button';
	button.className = 'close';
	button.dataset.dismiss = 'alert';
	button.textContent = '\xd7';

	if(exito)
		p.innerHTML = 'Se ha eliminado correctamente al paciente ';

	else
		p.innerHTML = 'Ha ocurrido un error al intentar eliminar al paciente ';

	p.appendChild(span);
	p.appendChild(button);

	document.getElementById('alertas').appendChild(p);
}