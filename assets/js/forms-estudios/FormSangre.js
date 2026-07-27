import { FormBase } from './FormBase.js';
import { Hemograma } from './estudios-sangre/Hemograma.js';
import { Serologia } from './estudios-sangre/Serologia.js';

export function FormSangre() {
	FormBase.call(this);

	this.hemograma = new Hemograma(document.getElementById('hemograma'));
	this.serologia = new Serologia(document.getElementById('serologia'));
}

FormBase.heredar(FormSangre);

FormSangre.prototype.cargarDatosEstudios = function(estudios) {
	var sangre = estudios.sangre;

	if(!sangre)
		return false;

	this.elem.fecha.value    = sangre.fecha;
	this.elem.nro_tubo.value = sangre.nro_tubo;

	if(sangre.hemograma) {
		this.hemograma.cargarDatos(sangre.hemograma);
		this.hemograma.desplegar();
	}

	if(sangre.serologia) {
		this.serologia.cargarDatos(sangre.serologia);
		this.serologia.desplegar();
	}

	return true;
};

FormSangre.prototype.reset = function() {
	FormBase.prototype.reset.call(this);

	this.hemograma.plegar();
	this.serologia.plegar();
};