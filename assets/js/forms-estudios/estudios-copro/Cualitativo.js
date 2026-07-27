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
	this.campos[0].value = caulitativo.strongyloides;
	this.campos[1].value = caulitativo.ancylostoma;
	this.campos[2].value = caulitativo.necator;

	if(caulitativo.enterobius)
		this.campos[3].value = caulitativo.enterobius;
};