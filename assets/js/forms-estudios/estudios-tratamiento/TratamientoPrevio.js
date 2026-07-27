import { EstudioBase } from '../EstudioBase.js';

export function TratamientoPrevio(html) {
	EstudioBase.call(this, html);

	this.campos = this.cuerpo.getElementsByTagName('input');
}

EstudioBase.heredar(TratamientoPrevio);

TratamientoPrevio.prototype.deshabilitar = function() {
	EstudioBase.prototype.deshabilitar.call(this);

	for(let campo of this.campos)
		campo.value = null;
};

TratamientoPrevio.prototype.cargarDatos = function(tratamientoPrevio) {
	this.campos[0].value = tratamientoPrevio.fecha;

	this.campos[1].checked = tratamientoPrevio.mebendazol   == 'SI';
	this.campos[2].checked = tratamientoPrevio.albendazol   == 'SI';
	this.campos[3].checked = tratamientoPrevio.ivermectina  == 'SI';
	this.campos[4].checked = tratamientoPrevio.metronidazol == 'SI';

	this.campos[5].value = tratamientoPrevio.otras;
};