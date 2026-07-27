import { EstudioBase } from '../EstudioBase.js';

export function Medidas(html) {
	EstudioBase.call(this, html);

	this.campos = this.cuerpo.getElementsByTagName('input');
}

EstudioBase.heredar(Medidas);

Medidas.prototype.deshabilitar = function() {
	EstudioBase.prototype.deshabilitar.call(this);

	for(let campo of this.campos)
		campo.value = null;
};

Medidas.prototype.cargarDatos = function(medidas) {
	this.campos[0].value = medidas.peso;
	this.campos[1].value = medidas.talla;
	this.campos[2].value = medidas.perimetro_cefalico;
};