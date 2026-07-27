export function Almacen(prefijo) {
	this.prefijo = prefijo;
}

Almacen.prototype.paciente = function(valor) {
	var clave = this.prefijo + '_paciente';

	if(typeof valor !== 'undefined')
		localStorage.setItem(clave, JSON.stringify(valor));

	else
		return JSON.parse(localStorage.getItem(clave));
};

Almacen.prototype.buscPaciente = function(valor) {
	var clave = this.prefijo + '_buscpac';

	if(typeof valor !== 'undefined')
		localStorage.setItem(clave, JSON.stringify(valor));

	else
		return JSON.parse(localStorage.getItem(clave));
};

Almacen.prototype.campania = function(valor) {
	var clave = this.prefijo + '_campania';

	if(typeof valor !== 'undefined')
		localStorage.setItem(clave, JSON.stringify(valor));

	else
		return JSON.parse(localStorage.getItem(clave));
};

Almacen.prototype.intervencion = function(valor) {
	var clave = this.prefijo + '_intervencion';

	if(typeof valor !== 'undefined')
		localStorage.setItem(clave, JSON.stringify(valor));

	else
		return JSON.parse(localStorage.getItem(clave));
};

Almacen.prototype.estudios = function(valor) {
	var clave = this.prefijo + '_estudios';

	if(typeof valor !== 'undefined')
		localStorage.setItem(clave, JSON.stringify(valor));

	else
		return JSON.parse(localStorage.getItem(clave));
};

Almacen.prototype.indicePag = function(valor) {
	var clave = this.prefijo + '_indicePag';

	if(typeof valor !== 'undefined')
		localStorage.setItem(clave, JSON.stringify(valor));

	else
		return JSON.parse(localStorage.getItem(clave));
};

Almacen.prototype.limpiar = function() {
	localStorage.removeItem(this.prefijo + '_paciente');
	localStorage.removeItem(this.prefijo + '_buscpac');
	localStorage.removeItem(this.prefijo + '_campania');
	localStorage.removeItem(this.prefijo + '_intervencion');
	localStorage.removeItem(this.prefijo + '_estudios');
	localStorage.removeItem(this.prefijo + '_indicePag');
};