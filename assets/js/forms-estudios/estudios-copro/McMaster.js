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
	this.campos[0].value = mcMaster.ascaris;
	this.campos[1].value = mcMaster.uncinarias;
	this.campos[2].value = mcMaster.hymenolepis;
	this.campos[3].value = mcMaster.trichuris;
	this.campos[4].value = mcMaster.enterobius;
	this.campos[5].value = mcMaster.taenia;
	this.campos[6].value = mcMaster.isosporabelli;
};