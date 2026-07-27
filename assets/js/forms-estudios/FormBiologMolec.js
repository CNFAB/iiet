import { PCR } from './estudios-biologmolec/PCR.js';

export function FormBiologMolec() {
	this.elem = document.getElementById('form_estudios');

	this.pcr = new PCR(document.getElementById('pcr'));
	this.qpcr = new PCR(document.getElementById('qpcr'));

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

FormBiologMolec.prototype.cargarDatosEstudios = function(estudios) {
	var biologMolec = estudios.biologmolec;

	if(!biologMolec)
		return false;

	this.elem.fuente.value = biologMolec.fuente;

	if(biologMolec.pcr) {
		this.pcr.cargarDatos(biologMolec.pcr);
		this.pcr.desplegar();
	}

	if(biologMolec.qpcr) {
		this.qpcr.cargarDatos(biologMolec.qpcr);
		this.qpcr.desplegar();
	}

	return true;
};

FormBiologMolec.prototype.reset = function() {
	this.elem.reset();

	Forms.resetForm(this.elem);

	this.pcr.plegar();
	this.qpcr.plegar();
};

FormBiologMolec.prototype.accionPreSubmit = function(fc) {
	this.preSubmit = fc;
};

FormBiologMolec.prototype.exito = function(fc) {
	this.exitoGuardar = fc;
};

FormBiologMolec.prototype.error = function(fc) {
	this.errorGuardar = fc;
};