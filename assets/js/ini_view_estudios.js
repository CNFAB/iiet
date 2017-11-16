/* Configuración de la barra de búsqueda de pacientes */
var formBuscaPaciente = document.busca_paciente;
var btnBuscaPaciente = document.getElementById("buscar_paciente");
var btnNoBuscaPaciente = document.getElementById("no_buscar_paciente");

btnBuscaPaciente.addEventListener("click", function(e) {
	formBuscaPaciente.className = "desplegar";
	formBuscaPaciente.f1.disabled = null;
});

btnNoBuscaPaciente.addEventListener("click", function(e) {
	formBuscaPaciente.className = "ocultar";
	formBuscaPaciente.f1.disabled = "disabled";
});



/* Configuración de los formularios Nueva Campañia y Nuevo Paciente */
function habilitarParaje(formulario) {
	formulario.paraje.disabled = null;
	formulario.barrio.disabled = "disabled";
}

function habilitarBarrio(formulario) {
	formulario.paraje.disabled = "disabled";
	formulario.barrio.disabled = null;
}

function seleccionarLugar(formulario) {
	if(formulario.lugar[0].checked) {
		habilitarParaje(formulario);
	}

	else {
		habilitarBarrio(formulario);
	}
}

function habilitarEscuela(formulario) {
	formulario.escuela.disabled = null;
}

function deshabilitarEscuela(formulario) {
	formulario.escuela.disabled = "disabled";
}



// ventanas modales
var vmNuevaCampania = document.getElementById("nueva_campania");
var vmNuevoPaciente = document.getElementById("nuevo_paciente");
// formularios
var formNuevaCampania = document.nueva_campania;
var formNuevoPaciente = document.nuevo_paciente;

var chkEscuela = formNuevaCampania.en_escuela;

formNuevaCampania.lugar[0].addEventListener("click", function(e) { seleccionarLugar(formNuevaCampania) });
formNuevaCampania.lugar[1].addEventListener("click", function(e) { seleccionarLugar(formNuevaCampania) });

formNuevoPaciente.lugar[0].addEventListener("click", function(e) { seleccionarLugar(formNuevoPaciente) });
formNuevoPaciente.lugar[1].addEventListener("click", function(e) { seleccionarLugar(formNuevoPaciente) });


vmNuevaCampania.close = function(formulario) {
	if(formulario === undefined)
		formNuevaCampania.reset();

	else
		Object.getPrototypeOf(vmNuevaCampania).close();
};

formNuevaCampania.addEventListener("reset", function(e) {
	habilitarParaje(this);
	deshabilitarEscuela(this);

	vmNuevaCampania.close(this);
});

chkEscuela.addEventListener("click", function(e) {
	if(this.checked)
		habilitarEscuela(formNuevaCampania);

	else
		deshabilitarEscuela(formNuevaCampania);
});


vmNuevoPaciente.close = function(formulario) {
	if(formulario === undefined)
		formNuevoPaciente.reset();

	else
		Object.getPrototypeOf(vmNuevoPaciente).close();
};

formNuevoPaciente.addEventListener("reset", function(e) {
	habilitarParaje(this);

	vmformNuevoPaciente.close(this);
});