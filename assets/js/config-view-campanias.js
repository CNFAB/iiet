import { Almacen } from './Almacen.js';

var tablaCampanias = $('#tabla-campanias').DataTable({
	language: obtenerObjIdioma('campañas', 'Nombre , Localidad : Tipo'),
    processing: true,
    serverSide: true,
    ajax: $.fn.dataTable.pipeline({
        url: '/iiet/campanias/listar',
        method: 'POST',
        pages: 5 // number of pages to cache
    }),
    rowId: 'dt_rowid',
  	columns: [
  		{ data: 'nombre' },
  		{ data: 'basal_control' },
  		{ data: 'tipo' },
  		{ data: c => c.institucion || c.barrio || c.puesto },
  		{ data: 'localidad' },
  		{ data: c => crearBtnsAccionCampania(c.numero) }
  	]
});

function crearBtnsAccionCampania(id) {
	var operaciones    = document.createElement('div'),
		btnEditar      = document.createElement('a'),
		btnPacientes   = document.createElement('a'),
		btnCargarDatos = document.createElement('button'),
		//btnInformeEst  = document.createElement('a'),
		/*btnExportar    = document.createElement('a'),*/
		btnEliminar    = document.createElement('a');

	btnEditar.href      = '#form-campania';
	btnEditar.className = 'btn btn-outline-success fas fa-pencil-alt mr-1';
	btnEditar.title     = 'Editar datos';
	btnEditar.dataset.toggle = 'modal';
	btnEditar.dataset.backdrop = 'static';
	btnEditar.dataset.keyboard = 'false';
	btnEditar.dataset.formModo = 'actualizar';

	btnPacientes.href      = '#modal-pacientes';
	btnPacientes.className = 'btn btn-outline-success fas fa-users mr-1';
	btnPacientes.title     = 'Ver pacientes intervenidos';
	btnPacientes.dataset.toggle = 'modal';
	btnPacientes.dataset.backdrop = 'static';
	btnPacientes.dataset.keyboard = 'false';

	btnCargarDatos.className = 'btn-interv btn btn-outline-info fas fa-folder-open mr-1';
	btnCargarDatos.type      = 'button';
	btnCargarDatos.title     = 'Cargar intervenciones';

	/*btnInformeEst.href = '/iiet/campanias/detalle/' + id;
	btnInformeEst.className = 'btn btn-outline-primary fas fa-chart-pie mr-1';
	btnInformeEst.title = 'Informe Estadístico';*/

	/*btnExportar.href      = '/iiet/campanias/config_exportar/' + id;
	btnExportar.className = 'btn btn-outline-success fas fa-file-excel mr-1';
	btnExportar.title     = 'Exportar campaña';*/

	btnEliminar.href      = '#elim-campania';
	btnEliminar.className = 'btn btn-outline-danger fas fa-trash-alt mr-1';
	btnEliminar.title     = 'Eliminar campaña';
	btnEliminar.dataset.toggle = 'modal';
	btnEliminar.dataset.backdrop = 'static';
	btnEliminar.dataset.keyboard = 'false';

	operaciones.appendChild(btnEditar);
	operaciones.appendChild(btnPacientes);
	operaciones.appendChild(btnCargarDatos);
	//operaciones.appendChild(btnInformeEst);
	//operaciones.appendChild(btnExportar);
	operaciones.appendChild(btnEliminar);

	return operaciones.innerHTML;
}

$('#tabla-campanias tbody').on('click', '.btn-interv', function(e) {
	var fila  = e.target.parentNode.parentNode,
		datos = tablaCampanias.row(fila).data(),
		almacen = new Almacen('estcamp');

	var datosCampania = {
		numero: datos.numero,
		nombre: datos.nombre
	};

	almacen.limpiar();
	almacen.campania(datosCampania);

	window.location.href = '/iiet/campanias/eventos';
});

var tablaPacientes = document.getElementById('tabla-pacientes-interv');

$('#modal-pacientes').on('show.bs.modal', function(e) {
	var fila  = e.relatedTarget.parentNode.parentNode,
		id    = tablaCampanias.row(fila).data().numero,
		tBody = tablaPacientes.tBodies[0];

	while(tBody.lastElementChild)
		tBody.removeChild(tBody.lastElementChild);

	$.ajax('/iiet/campanias/pacientes/' + id, {
		dataType: 'json',
		success: function(resp) {
			for(let datos of resp) {
				var fila = tBody.insertRow(),
					cNro = fila.insertCell(),
					cDni = fila.insertCell(),
					cApe = fila.insertCell(),
					cNom = fila.insertCell();

				cNro.textContent = datos.numero;
				cDni.textContent = datos.dni;
				cApe.textContent = datos.apellido;
				cNom.textContent = datos.nombre;
			}
		}
	});
});

var formCampania = document.fCampania;

$('#form-campania').on('show.bs.modal', function(e) {
	var formModo = e.relatedTarget.dataset.formModo;

	formCampania.reset();
	formCampania.dataset.modo = formModo;

	if(formModo == 'nueva')
		configModalNuevaCampania();

	else {
		var fila = e.relatedTarget.parentNode.parentNode,
			datos = tablaCampanias.row(fila).data();

		configModalEditarCampania(datos);
	}
});

$('#form-campania').on('shown.bs.modal', function(e) {
	formCampania.nombre.focus();
});

function configModalNuevaCampania() {
	$('#form-campania .modal-header h4').text('Nueva Campaña');

	formCampania.enviar.value = 'Crear';
	formCampania.numero.disabled = 'disabled';
}
	
function configModalEditarCampania(datos) {
	$('#form-campania .modal-header h4').text('Actualizar Campaña');

	formCampania.enviar.value = 'Actualizar';
	formCampania.numero.disabled = null;

	formCampania.numero.value = datos.numero;
	formCampania.nombre.value = datos.nombre;
	formCampania.basal_control.value = datos.basal_control;
	formCampania.fecha_inicio.value = datos.fecha_inicio;
	formCampania.fecha_fin.value = datos.fecha_fin;

	Forms.cargarDivPolits(formCampania, datos);

	if(datos.tipo == 'INSTITUCION') {
		formCampania['check-institucion'].checked = true;
		Forms.habilitarCampoInstitucion(formCampania);
	}

	else
		Forms.habilitarCampoPuesto(formCampania);
}

$.ajax('/iiet/entidades/listado_departamentos', {
	dataType: 'json',
	success: function(respuesta) {
		Forms.cargarSelect(formCampania.departamento, respuesta, 'nombre', 'numero');
	}
});

// onChange departamento
Forms.cambioSelect(
	formCampania.departamento,
	formCampania.localidad,
	'/iiet/entidades/listado_localidades/',
	'nombre',
	'numero'
);
// onChange localidad
Forms.cambioSelect(
	formCampania.localidad,
	formCampania.barrio,
	'/iiet/entidades/listado_barrios/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	formCampania.localidad,
	formCampania.paraje,
	'/iiet/entidades/listado_parajes/',
	'nombre',
	'numero'
);
// onChange barrio
Forms.cambioSelect(
	formCampania.barrio,
	formCampania.institucion,
	'/iiet/escuelas/listado_escuelas/barrio/',
	'nombre',
	'numero'
);
// onChange paraje
Forms.cambioSelect(
	formCampania.paraje,
	formCampania.puesto,
	'/iiet/entidades/listado_puestos/',
	'nombre',
	'numero'
);

Forms.cambioSelect(
	formCampania.paraje,
	formCampania.institucion,
	'/iiet/escuelas/listado_escuelas/paraje/',
	'nombre',
	'numero'
);

Forms.validarFecha(formCampania.fecha_inicio);
Forms.validarFecha(formCampania.fecha_fin);

Forms.excluyentes(formCampania.lugar);

$(formCampania.lugar).on('change', function(e) {
	if(formCampania.lugar.value == 'barrio')
		deshabilitarCampoPuesto();

	else if(!formCampania['check-institucion'].checked)
		habilitarCampoPuesto();
});

$('#check-institucion').on('change', function(e) {
	if(this.checked) {
		Forms.deshabilitarCampoPuesto(formCampania);
		Forms.habilitarCampoInstitucion(formCampania);
	}

	else {
		if(formCampania.lugar[1].checked)
			Forms.habilitarCampoPuesto(formCampania);

		Forms.deshabilitarCampoInstitucion(formCampania);
	}
});

formCampania.addEventListener('reset', function(e) {
	Forms.resetForm(formCampania);
	Forms.excluir(formCampania.lugar, formCampania.lugar[0]);
	Forms.deshabilitarCampoPuesto();
	Forms.limpiarDependientes(formCampania.departamento);
});

formCampania.addEventListener('submit', function(e) {
	e.preventDefault();

	this.classList.add('was-validated');

	if(this.checkValidity() === false) {
		e.preventDefault();
		e.stopPropagation();
	}

	else {
		$.ajax('/iiet/campanias/' + formCampania.dataset.modo, {
			method: 'POST',
			data: $(formCampania).serialize(),
			success: opCampaniaExito,
			error: opCampaniaError
		});
	}
});

function opCampaniaExito(respuesta) {
	tablaCampanias.clearPipeline();
	tablaCampanias.ajax.reload();

	var p = document.createElement('p'),
		span = document.createElement('span'),
		button = document.createElement('button');

	p.className = 'alert alert-success';
	p.appendChild(document.createTextNode('La campaña '));

	span.className = 'font-weight-bold';
	span.textContent = formCampania.nombre.value;
	p.appendChild(span);

	if(formCampania.dataset.modo == 'nueva')
		p.appendChild(document.createTextNode(' fue creada con éxito'));
	else
		p.appendChild(document.createTextNode(' fue actualizada con éxito'));

	button.type = 'button';
	button.className = 'close';
	button.dataset.dismiss = 'alert';
	button.textContent = '\xd7';
	p.appendChild(button);

	$('#alertas').append(p);

	$('#form-campania').modal('hide');
}

function opCampaniaError() {
	var p = document.createElement('p'),
		button = document.createElement('button');

	p.className = 'alert alert-danger';
	p.textContent = 'Ocurrió un error al intentar crear la campaña';

	button.type = 'button';
	button.className = 'close';
	button.dataset.dismiss = 'alert';
	button.textContent = '\xd7';
	p.appendChild(button);

	$('#alert-camp-error').append(p);
}

$('#elim-campania').on('show.bs.modal', function(e) {
	console.log("show");
	var fila = e.relatedTarget.parentNode.parentNode,
		datos = tablaCampanias.row(fila).data();

	$.ajax('/iiet/campanias/tiene_intervenciones/' + datos.numero, {
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

			$('#elim-campania-confirm').data('id-campania', datos.numero);

			$('.text-campania').text(datos.nombre);
		}
	});
});

$('#elim-campania-confirm').on('click', function(e) {
	var id = $(this).data('id-campania'),
		datos = tablaCampanias.row($('#tc_' + id)).data();

	$.ajax('/iiet/campanias/eliminar/' + id, {
		dataType: 'json',
		success: function(respuesta) {
			tablaCampanias.clearPipeline();
			tablaCampanias.ajax.reload(null, false);

			mostrarAlertElim(true, datos.nombre);

			$('#elim-campania').modal('hide');
		},
		error: function(respuesta) {
			mostrarAlertElim(true);

			$('#elim-campania').modal('hide');
		}
	});
});

function mostrarAlertElim(exito, nombreCampania) {
	var p = document.createElement('p'),
		span = document.createElement('span'),
		button = document.createElement('button');

	p.className = 'col-12 animated bounce alert alert-' + (exito ? 'success' : 'danger');

	span.className = 'font-weight-bold';
	span.textContent = nombreCampania;

	button.type = 'button';
	button.className = 'close';
	button.dataset.dismiss = 'alert';
	button.textContent = '\xd7';

	if(exito)
		p.innerHTML = 'Se ha eliminado correctamente la campaña ';

	else
		p.innerHTML = 'Ha ocurrido un error al intentar eliminar la campaña ';

	p.appendChild(span);
	p.appendChild(button);

	document.getElementById('alertas').appendChild(p);
}