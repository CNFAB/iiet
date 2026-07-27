import { EstudioBase } from '../EstudioBase.js';

export function TratamientoActual(html) {
	EstudioBase.call(this, html);

	this.checkMebendazol = html.querySelector('#ta-mebendazol');
	this.checkAlbendazol = html.querySelector('#ta-albendazol');
	this.checkIvermectina = html.querySelector('#ta-ivermectina');

	this.checkMebendazol.addEventListener('change', e => checkDrogas(e.target));
	this.checkAlbendazol.addEventListener('change', e => checkDrogas(e.target));
	this.checkIvermectina.addEventListener('change', e => checkDrogas(e.target));
}

EstudioBase.heredar(TratamientoActual);

TratamientoActual.prototype.deshabilitar = function() {
	this.checkMebendazol.checked = false;
	this.checkAlbendazol.checked = false;
	this.checkIvermectina.checked = false;

	checkDrogas(this.checkMebendazol);
	checkDrogas(this.checkAlbendazol);
	checkDrogas(this.checkIvermectina);

};

TratamientoActual.prototype.cargarDatos = function(tratamientoActual) {
	cargarDosis(this.checkMebendazol, tratamientoActual.mebendazol);
	cargarDosis(this.checkAlbendazol, tratamientoActual.albendazol);
	cargarDosis(this.checkIvermectina, tratamientoActual.ivermectina);
};

function checkDrogas(elem) {
	var padre = elem.parentNode.parentNode.parentNode;

	if(elem.checked) {
		habilitarDroga(padre);

		padre.children[2].children[1].selectedIndex = 0;
		padre.children[1].children[1].children[0].focus();
	}

	else {
		deshabilitarDroga(padre);
		padre.children[1].children[1].children[0].value = null;
	}
}

function habilitarDroga(padre) {
	padre.children[1].classList.remove('d-none');
	padre.children[2].classList.add('d-none');

	padre.children[1].disabled = null;
	padre.children[2].disabled = 'disabled';
}

function deshabilitarDroga(padre) {
	padre.children[1].classList.add('d-none');
	padre.children[2].classList.remove('d-none');

	padre.children[1].disabled = 'disabled';
	padre.children[2].disabled = null;
}

function cargarDosis(droga, datos) {
	var padre = droga.parentNode.parentNode.parentNode,
		input = padre.children[1].children[1].children[0],
		select = padre.children[2].children[1];

	if(datos.dosis) {
		droga.checked = true;
		habilitarDroga(padre);

		input.value = datos.dosis;
	}

	else {
		droga.checked = false;
		deshabilitarDroga(padre);

		select.value = datos.exclusion;
	}
}