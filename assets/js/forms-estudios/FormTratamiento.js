import { FormBase } from './FormBase.js';
import { Medidas } from './estudios-tratamiento/Medidas.js';
import { TratamientoPrevio } from './estudios-tratamiento/TratamientoPrevio.js';
import { TratamientoActual } from './estudios-tratamiento/TratamientoActual.js';

export function FormTratamiento() {
	FormBase.call(this);

	this.medidas = new Medidas(document.getElementById('medidas'));
	this.previo = new TratamientoPrevio(document.getElementById('previo'));
	this.actual = new TratamientoActual(document.getElementById('actual'));

	this.contenedorTratado = document.getElementById('div-tratado');
	this.contenedorNoTratado = document.getElementById('div-no-tratado');

	this.elem.fue_tratado[0].addEventListener('change', e => this.mostrarTratado());
	this.elem.fue_tratado[1].addEventListener('change', e => this.mostrarNoTratado());
}

FormBase.heredar(FormTratamiento);

FormTratamiento.prototype.cargarDatosEstudios = function(estudios) {
	var tratamiento = estudios.tratamiento;

	if(!tratamiento)
		return false;

	this.elem.fecha.value = tratamiento.fecha;
	
	if(tratamiento.no_tratado) {
		this.elem.fue_tratado[1].checked = true;
		this.mostrarNoTratado();
		this.elem.no_tratado.value = tratamiento.no_tratado;
	}

	else {
		this.mostrarTratado();

		if(tratamiento.medidas) {
			this.medidas.cargarDatos(tratamiento.medidas);
			this.medidas.desplegar();
		}

		if(tratamiento.tratamiento_previo) {
			this.previo.cargarDatos(tratamiento.tratamiento_previo);
			this.previo.desplegar();
		}

		this.actual.cargarDatos(tratamiento);
	}

	return true;
};

FormTratamiento.prototype.mostrarTratado = function() {
	this.contenedorTratado.classList.remove('d-none');
	this.contenedorNoTratado.classList.add('d-none');

	this.elem.no_tratado.disabled = 'disabled';
};

FormTratamiento.prototype.mostrarNoTratado = function() {
	this.medidas.plegar();
	this.previo.plegar();
	this.actual.deshabilitar();

	this.contenedorTratado.classList.add('d-none');
	this.contenedorNoTratado.classList.remove('d-none');

	this.elem.no_tratado.disabled = null;
};

FormTratamiento.prototype.reset = function() {
	FormBase.prototype.reset.call(this);

	this.medidas.plegar();
	this.previo.plegar();
};