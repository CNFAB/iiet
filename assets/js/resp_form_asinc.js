function respFormCampania(e) {
	var respuesta 	  = e.target.response,
		estadoGuardar = document.getElementById('estado_guardar'),
		formCampania  = document.querySelector('#form_campania form');

	if(e.target.status === 500 || respuesta === false) {
		estadoGuardar.className = 'error_guardar';
		estadoGuardar.children[0].textContent = 'Ha ocurrido un error al intentar cargar la campaña.';
		estadoGuardar.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoGuardar.className = 'exito_guardar';
		estadoGuardar.children[0].textContent = 'Se ha cargado correctamente la campaña:';
		estadoGuardar.children[1].textContent = formCampania.nombre.value;
		formCampania.vm.close();
	}

	window.setTimeout(() => {
		estadoGuardar.className = '';
	}, 5000);
}

function respFormPacienteVarios(e) {
	var respuesta 	  = e.target.response,
		estadoGuardar = document.getElementById('estado_guardar'),
		formPaciente = document.querySelector('#form_paciente form');

	if(e.target.status === 500 || respuesta === false) {
		estadoGuardar.className = 'error_guardar';
		estadoGuardar.children[0].textContent = 'Ha ocurrido un error al intentar cargar los datos del paciente.';
		estadoGuardar.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoGuardar.className = 'exito_guardar';
		estadoGuardar.children[0].textContent = 'Se han cargado correctamente los datos del paciente:';
		estadoGuardar.children[1].textContent = formPaciente.apellido.value + ', ' + formPaciente.nombre.value + ' (' + formPaciente.dni.value + ')';
		formPaciente.reset();
	}

	window.setTimeout(() => {
		estadoGuardar.className = '';
	}, 5000);
}

function respFormPaciente(e) {
	var respuesta 	  = e.target.response,
		estadoGuardar = document.getElementById('estado_guardar'),
		formPaciente = document.querySelector('#form_paciente form');

	if(e.target.status === 500 || respuesta === false) {
		estadoGuardar.className = 'error_guardar';
		estadoGuardar.children[0].textContent = 'Ha ocurrido un error al intentar cargar los datos del paciente.';
		estadoGuardar.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoGuardar.className = 'exito_guardar';
		estadoGuardar.children[0].textContent = 'Se han cargado correctamente los datos del paciente:';
		estadoGuardar.children[1].textContent = formPaciente.apellido.value + ', ' + formPaciente.nombre.value + ' (' + formPaciente.dni.value + ')';
		formPaciente.vm.close();
	}

	window.setTimeout(() => {
		estadoGuardar.className = '';
	}, 5000);
}

function respFormDepartamento(e) {
	var respuesta 	  	 = e.target.response,
		estadoGuardar 	 = document.getElementById('estado_guardar'),
		formDepartamento = document.querySelector('#form_dpto form');

	if(e.target.status === 500 || respuesta === false) {
		estadoGuardar.className = 'error_guardar';
		estadoGuardar.children[0].textContent = 'Ha ocurrido un error al intentar cargar los datos.';
		estadoGuardar.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoGuardar.className = 'exito_guardar';
		estadoGuardar.children[0].textContent = 'Se ha cargado correctamente el departamento:';
		estadoGuardar.children[1].textContent = formDepartamento.nombre.value;
		formDepartamento.vm.close();
	}

	window.setTimeout(() => {
		estadoGuardar.className = '';
	}, 5000);
}

function respFormLocalidad(e) {
	var respuesta 	  	 = e.target.response,
		estadoGuardar 	 = document.getElementById('estado_guardar'),
		formLocalidad = document.querySelector('#form_localidad form');

	if(e.target.status === 500 || respuesta === false) {
		estadoGuardar.className = 'error_guardar';
		estadoGuardar.children[0].textContent = 'Ha ocurrido un error al intentar cargar los datos.';
		estadoGuardar.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoGuardar.className = 'exito_guardar';
		estadoGuardar.children[0].textContent = 'Se ha cargado correctamente la localidad:';
		estadoGuardar.children[1].textContent = formLocalidad.nombre.value;
		formLocalidad.vm.close();
	}

	window.setTimeout(() => {
		estadoGuardar.className = '';
	}, 5000);
}

function respFormBarrio(e) {
	var respuesta 	  	 = e.target.response,
		estadoGuardar 	 = document.getElementById('estado_guardar'),
		formBarrio = document.querySelector('#form_barrio form');

	if(e.target.status === 500 || respuesta === false) {
		estadoGuardar.className = 'error_guardar';
		estadoGuardar.children[0].textContent = 'Ha ocurrido un error al intentar cargar los datos.';
		estadoGuardar.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoGuardar.className = 'exito_guardar';
		estadoGuardar.children[0].textContent = 'Se ha cargado correctamente el barrio:';
		estadoGuardar.children[1].textContent = formBarrio.nombre.value;
		formBarrio.vm.close();
	}

	window.setTimeout(() => {
		estadoGuardar.className = '';
	}, 5000);
}

function respFormParaje(e) {
	var respuesta 	  	 = e.target.response,
		estadoGuardar 	 = document.getElementById('estado_guardar'),
		formParaje = document.querySelector('#form_paraje form');

	if(e.target.status === 500 || respuesta === false) {
		estadoGuardar.className = 'error_guardar';
		estadoGuardar.children[0].textContent = 'Ha ocurrido un error al intentar cargar los datos.';
		estadoGuardar.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoGuardar.className = 'exito_guardar';
		estadoGuardar.children[0].textContent = 'Se ha cargado correctamente el paraje:';
		estadoGuardar.children[1].textContent = formParaje.nombre.value;
		formParaje.vm.close();
	}

	window.setTimeout(() => {
		estadoGuardar.className = '';
	}, 5000);
}

function respFormPuesto(e) {
	var respuesta 	  	 = e.target.response,
		estadoGuardar 	 = document.getElementById('estado_guardar'),
		formPuesto = document.querySelector('#form_puesto form');

	if(e.target.status === 500 || respuesta === false) {
		estadoGuardar.className = 'error_guardar';
		estadoGuardar.children[0].textContent = 'Ha ocurrido un error al intentar cargar los datos.';
		estadoGuardar.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoGuardar.className = 'exito_guardar';
		estadoGuardar.children[0].textContent = 'Se ha cargado correctamente el puesto:';
		estadoGuardar.children[1].textContent = formPuesto.nombre.value;
		formPuesto.vm.close();
	}

	window.setTimeout(() => {
		estadoGuardar.className = '';
	}, 5000);
}

function respFormEscuela(e) {
	var respuesta 	  	 = e.target.response,
		estadoGuardar 	 = document.getElementById('estado_guardar'),
		formEscuela = document.querySelector('#form_escuela form');

	if(e.target.status === 500 || respuesta === false) {
		estadoGuardar.className = 'error_guardar';
		estadoGuardar.children[0].textContent = 'Ha ocurrido un error al intentar cargar los datos.';
		estadoGuardar.children[1].textContent = 'Por favor intentelo nuevamente.';
	}

	else {
		estadoGuardar.className = 'exito_guardar';
		estadoGuardar.children[0].textContent = 'Se ha cargado correctamente la escuela:';
		estadoGuardar.children[1].textContent = formEscuela.nombre.value;
		formEscuela.vm.close();
	}

	window.setTimeout(() => {
		estadoGuardar.className = '';
	}, 5000);
}