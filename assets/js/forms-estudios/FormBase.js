export function FormBase() {
	this.elem = document.getElementById('form_estudios');

	this.preSubmit = null;

	this.exitoGuardar = null;
	this.errorGuardar = null;

	var self = this;

	this.elem.addEventListener('submit', function(e) {
		e.preventDefault();

		this.classList.add('was-validated');

		if(this.checkValidity() === false) {
			e.preventDefault();
			e.stopPropagation();
		}

		else {
			if(self.preSubmit)
				self.preSubmit();

			$.ajax(this.action, {
				method: 'POST',
				data: $(this).serialize(),
				success: self.exitoGuardar,
				error: self.errorGuardar
			});
		}
	});
}

FormBase.prototype.reset = function() {
	this.elem.reset();

	Forms.resetForm(this.elem);
};

FormBase.prototype.accionPreSubmit = function(fc) {
	this.preSubmit = fc;
};

FormBase.prototype.exito = function(fc) {
	this.exitoGuardar = fc;
};

FormBase.prototype.error = function(fc) {
	this.errorGuardar = fc;
};

FormBase.heredar = function(hijo) {
	var copiaPadre = Object.create(FormBase.prototype);

	copiaPadre.constructor = hijo;
	hijo.prototype = copiaPadre;
};