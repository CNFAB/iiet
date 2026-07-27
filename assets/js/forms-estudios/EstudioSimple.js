import { EstudioBase } from './EstudioBase.js';

export function EstudioSimple(html) {
	EstudioBase.call(this, html);

	this.campos = this.cuerpo.getElementsByTagName('input');
}

EstudioBase.heredar(EstudioSimple);

EstudioSimple.prototype.deshabilitar = function() {
	EstudioBase.prototype.deshabilitar.call(this);

	for(let campo of this.campos)
		campo.value = null;
};

EstudioSimple.heredar = function(hijo) {
	var copiaPadre = Object.create(EstudioSimple.prototype);

	copiaPadre.constructor = hijo;
	hijo.prototype = copiaPadre;
};