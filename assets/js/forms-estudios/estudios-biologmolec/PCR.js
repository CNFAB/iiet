import { EstudioBase } from '../EstudioBase.js';

export function PCR(html) {
	EstudioBase.call(this, html);

	this.campos = this.cuerpo.getElementsByTagName('select');
}

EstudioBase.heredar(PCR);

PCR.prototype.deshabilitar = function() {
	EstudioBase.prototype.deshabilitar.call(this);

	for(var i = 0; i < this.campos.length; ++i)
		this.campos[i].selectedIndex = 0;
};

PCR.prototype.cargarDatos = function(pcr) {
	this.campos[0].value = pcr.strongyloides;
	this.campos[1].value = pcr.ancylostoma;
	this.campos[2].value = pcr.necator;
	this.campos[3].value = pcr.ascaris;
	this.campos[4].value = pcr.trichuris;
};