import { EstudioBase } from '../EstudioBase.js';

export function McMaster(html) {
	EstudioBase.call(this, html);

	this.campos = this.cuerpo.getElementsByTagName('input');
	this.btnNegativo = html.getElementsByClassName('btn-negativo')[0];
	this.btnNegativo.clicked = false;

	var self = this;

	this.btnNegativo.addEventListener('click', function(e) {
		if(!this.clicked) {
			for(let i = 0; i < self.campos.length; ++i)
				if(self.campos[i].value == '')
					self.campos[i].value = 0;

			this.textContent = 'Deshacer Negativos';
		}

		else {
			for(let i = 0; i < self.campos.length; ++i)
				if(self.campos[i].value == 0)
					self.campos[i].value = '';

			this.textContent = 'Completar con Negativos';
		}

		this.clicked = !this.clicked;
	});
}

EstudioBase.heredar(McMaster);

McMaster.prototype.deshabilitar = function() {
	EstudioBase.prototype.deshabilitar.call(this);

	for(var i = 0; i < this.campos.length; ++i)
		this.campos[i].value = null;

	this.btnNegativo.clicked = false;
	this.btnNegativo.textContent = 'Completar con Negativos';
};

McMaster.prototype.cargarDatos = function(mcMaster) {
	for(var i = 0; i < this.campos.length; ++i) {
		var input = this.campos[i];
		var match = input.name.match(/\[(\w+)\]/);

		if(!match) continue;

		var campo = match[1];

		if(mcMaster[campo] !== undefined && mcMaster[campo] !== null)
			input.value = mcMaster[campo];
	}
};