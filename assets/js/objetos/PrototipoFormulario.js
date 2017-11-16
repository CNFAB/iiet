PrototipoFormulario = Object.create(HTMLElement.prototype);

PrototipoFormulario.template = null;

PrototipoFormulario.createdCallback = function() {
	this.appendChild(document.importNode(this.template, true));

	this.establecerPropiedades();
	this.establecerEventos();
};

PrototipoFormulario.establecerPropiedades = function() {
	this.habilitador = this.querySelector(".activar");
	this.datosFormulario = this.querySelector(".datos_formulario");
};

PrototipoFormulario.establecerEventos = function() {
	var self = this;

	this.habilitador.addEventListener("click", function(e) {
		if(this.checked)
			self.habilitar();

		else
			self.deshabilitar();
	});
};

PrototipoFormulario.habilitar = function() {
	this.datosFormulario.disabled = null;
};

PrototipoFormulario.deshabilitar = function() {
	this.datosFormulario.disabled = "disabled";
};