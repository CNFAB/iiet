import { EstudioBase } from '../EstudioBase.js';

export function Hemograma(html) {
	EstudioBase.call(this, html);

	this.campos = this.cuerpo.getElementsByTagName('input');
}

EstudioBase.heredar(Hemograma);

Hemograma.prototype.deshabilitar = function() {
	EstudioBase.prototype.deshabilitar.call(this);

	for(let campo of this.campos)
		campo.value = null;
};

Hemograma.prototype.cargarDatos = function(hemograma) {
	this.campos[0].value = hemograma.globulos_blancos;
	this.campos[1].value = hemograma.hemoglobina;
	this.campos[2].value = hemograma.eosinofilos;
};