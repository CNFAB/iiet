var palabrasClave = {
	campos: ["biologiaMolecular", "copro", "sangre", "tratamiento"],

	copro: {
		campos: ["baerman", "concentrado", "consistencia", "fecha", "haradaMori", "mcMaster", "peso", "placaAgar"],

		baerman: {
			ancylostoma: [],
			necator: [],
			strongyloides: []
		},
		concentrado: {
			ascaris: [],
			entamoebaColi: [],
			enterobius: [],
			giardia: [],
			hymenolepis: [],
			strongyloides: [],
			taenia: [],
			trichuris: [],
			uncinarias: []
		},
		haradaMori: {
			ancylostoma: [],
			enterobius: [],
			necator: [],
			strongyloides: []
		},
		mcMaster: {
			ascaris: [],
			enterobius: [],
			hymenolepis: [],
			taenia: [],
			trichuris: [],
			uncinarias: []
		},
		placaAgar: {
			ancylostoma: [],
			necator: [],
			strongyloides: []
		},

		ASCARIS: [],
		ENTAMOEBA_COLI: [],
		ENTEROBIUS: [],
		GIARDIA: [],
		HYMENOLEPIS: [],
		STRONGYLOIDES: [],
		TAENIA: [],
		TRICHURIS: [],
		UNCINARIAS: []
	},
	sangre: {},
	biologiaMolecular: {},
	tratamiento: {}
};

var datos = palabrasClave.copro.campos;
var lista = document.getElementById('lista');

document.editor.codigo.addEventListener('input', function(e) {
	var entrada = this.value;

	limpiarLista();

	if(entrada != '') {
		for(let palabra of datos) {
			let expReg = new RegExp('^' + entrada);

			if(palabra.search(expReg) != -1)
				nuevoItem(palabra);
		}
	}
});

function nuevoItem(text) {
	var item = document.createElement('li');

	item.textContent = text;

	item.addEventListener('click', function(e) {
		document.editor.codigo.value = item.textContent;
		limpiarLista();
	});

	lista.appendChild(item);
}

function limpiarLista() {
	lista.innerHTML = '';
}