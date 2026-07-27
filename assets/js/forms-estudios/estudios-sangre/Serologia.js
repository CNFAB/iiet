import { EstudioBase } from '../EstudioBase.js';

export function Serologia(html) {
	EstudioBase.call(this, html);

	this.campos = this.cuerpo.getElementsByTagName('input');

	var self = this;

	this.campos[0].addEventListener('input', function(e) {
		if(this.value === '')
			self.campos[1].value = '';

		else {
			let valor = this.value - 0;

			self.campos[1].value = valor >= 120 ? 'POSITIVO' : 'NEGATIVO';
		}
	});
}

EstudioBase.heredar(Serologia);

Serologia.prototype.deshabilitar = function() {
	EstudioBase.prototype.deshabilitar.call(this);

	for(let campo of this.campos)
		campo.value = null;
};

Serologia.prototype.cargarDatos = function(serologia) {
	this.campo.value = serologia.titulo;
};