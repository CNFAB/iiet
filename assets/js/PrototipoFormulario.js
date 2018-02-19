PrototipoFormulario = Object.create(HTMLElement.prototype);

PrototipoFormulario.template = null;

PrototipoFormulario.createdCallback = function() {
	this.appendChild(document.importNode(this.template, true));

	this.establecerPropiedades();
	this.establecerEventos();
};

PrototipoFormulario.establecerPropiedades = function() {
	this.habilitador = this.querySelector(".switcher");
	this.datosFormulario = this.querySelector(".datos_formulario");
};

PrototipoFormulario.establecerEventos = function() {
	var self = this;

	this.habilitador.addEventListener("change", function(e) {
		if(this.checked)
			self.habilitar();

		else
			self.deshabilitar();
	});
};

PrototipoFormulario.habilitar = function() {
	this.datosFormulario.disabled = null;
	this.campos[0].focus();
};

PrototipoFormulario.deshabilitar = function() {
	this.datosFormulario.disabled = "disabled";
};