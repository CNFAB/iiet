import { EstudioBase } from '../EstudioBase.js';

export function Cualitativo(html) {
	EstudioBase.call(this, html);

	this.campos = html.getElementsByTagName('select');
	this.btnNegativo = html.getElementsByClassName('btn-negativo')[0];
	this.btnNegativo.clicked = false;

	var self = this;

	this.btnNegativo.addEventListener('click', function(e) {
		if(!this.clicked) {
			for(let i = 0; i < self.campos.length; ++i)
				if(self.campos[i].value == '')
					self.campos[i].value = 'NEGATIVO';

			this.textContent = 'Deshacer Negativos';
		}

		else {
			for(let i = 0; i < self.campos.length; ++i)
				if(self.campos[i].value == 'NEGATIVO')
					self.campos[i].value = '';

			this.textContent = 'Completar con Negativos';
		}

		this.clicked = !this.clicked;
	});
}

EstudioBase.heredar(Cualitativo);

Cualitativo.prototype.deshabilitar = function() {
	EstudioBase.prototype.deshabilitar.call(this);

	for(var i = 0; i < this.campos.length; ++i)
		this.campos[i].selectedIndex = 0;

	this.btnNegativo.clicked = false;
	this.btnNegativo.textContent = 'Completar con Negativos';
};

Cualitativo.prototype.cargarDatos = function(caulitativo) {
	for(var i = 0; i < this.campos.length; ++i) {
		var select = this.campos[i];
		var match = select.name.match(/\[(\w+)\]/);

		if(!match) continue;

		var campo = match[1];

		if(caulitativo[campo] !== undefined && caulitativo[campo] !== null)
			select.value = caulitativo[campo];
	}
};