import { EstudioBase } from '../EstudioBase.js';

export function Concentrado(html) {
	EstudioBase.call(this, html);

	this.campos = this.cuerpo.querySelectorAll('input[type=checkbox]');
}

EstudioBase.heredar(Concentrado);

Concentrado.prototype.deshabilitar = function() {
	EstudioBase.prototype.deshabilitar.call(this);

	for(var i = 0; i < this.campos.length; ++i)
		this.campos[i].checked = false;
};

Concentrado.prototype.cargarDatos = function(concentrado) {
	this.campos[0].checked = concentrado.ascaris  	   == 'POSITIVO' ? true : false;
	this.campos[1].checked = concentrado.giardia 	   == 'POSITIVO' ? true : false;
	this.campos[2].checked = concentrado.entamoebacoli == 'POSITIVO' ? true : false;
	this.campos[3].checked = concentrado.uncinarias    == 'POSITIVO' ? true : false;
	this.campos[4].checked = concentrado.strongyloides == 'POSITIVO' ? true : false;
	this.campos[5].checked = concentrado.hymenolepis   == 'POSITIVO' ? true : false;
	this.campos[6].checked = concentrado.trichuris 	   == 'POSITIVO' ? true : false;
	this.campos[7].checked = concentrado.enterobius    == 'POSITIVO' ? true : false;
	this.campos[8].checked = concentrado.taenia	       == 'POSITIVO' ? true : false;
	this.campos[9].checked = concentrado.isosporabelli == 'POSITIVO' ? true : false;
};