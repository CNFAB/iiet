export function EstudioBase(html) {
	this.elem = html;
	this.colapsable = $(html).find('.collapse');
	this.cuerpo = html.getElementsByTagName('fieldset')[0];
	this.campos = null;

	this.plegando = false;
	this.desplegado = false;

	this.desplegarPendiente = false;

	this.colapsable.on('show.bs.collapse', e => this.habilitar());
	this.colapsable.on('hide.bs.collapse', e => this.deshabilitar());
}

EstudioBase.prototype.desplegar = function() {
	var self = this;

	window.setTimeout(function() {
		self.colapsable.collapse('show');
	}, 400);
};

EstudioBase.prototype.plegar = function() {
	this.plegando = true;
	this.colapsable.collapse('hide');
};

EstudioBase.prototype.habilitar = function() {
	this.cuerpo.disabled = null;
};

EstudioBase.prototype.deshabilitar = function() {
	this.cuerpo.disabled = 'disabled';
};

EstudioBase.heredar = function(hijo) {
	var copiaPadre = Object.create(EstudioBase.prototype);

	copiaPadre.constructor = hijo;
	hijo.prototype = copiaPadre;
};