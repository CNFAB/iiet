var bloque1 = document.getElementsByClassName('bloque_1')[0];


/* ESTABLECE EL TAMAÑO DE LOS CONTENEDORES DE LOS FORMULARIOS */

var contenedores = document.querySelectorAll('.estudio > .contenido');

var main = document.querySelector("#main");

function redimencionar(e) {
	var limiteSuperior = main.getBoundingClientRect()['top'];
	var limiteInferior = window.innerHeight;
	
	main.style.height = (limiteInferior - limiteSuperior) + "px";
}

redimencionar();

window.addEventListener("resize", redimencionar);



/* PONE EN PRIMER PLANO EL FORMULARIO SELECCIONADO */

var estudios = document.getElementsByClassName('estudio');
var solapas = document.querySelectorAll('.solapa > button');


var primerPlano = document.getElementsByClassName('primer_plano')[0];

for(var i = 0; i < solapas.length; ++i)
	solapas[i].addEventListener("click", function(e) {
		primerPlano.className = "estudio";
		primerPlano.children[1].disabled = "disabled";

		primerPlano = this.parentNode.parentNode;
		primerPlano.className = "estudio primer_plano";
		primerPlano.children[1].disabled = null;
	});


var vms = document.getElementById("ventanas_modales");

vms.appendChild(document.importNode(templateNuevaCampania, true));
vms.appendChild(document.importNode(templateNuevoPaciente, true));

inicializarFormAsinc();

var t = document.getElementById('t_msj_no_estudio').content;

var paginacion = document.getElementsByTagName('wc-paginacion')[0];

paginacion.establecerCantPaginas(1);

paginacion.manejadorEventoPaginacion(function(i) {
	var clon = document.importNode(t, true);
console.log(clon);
	clon.querySelector("msj_no_estudio").innerHTML = "No se ha realizado copro para esta intervención";
	clon.querySelector("btn_agregar_estudio").innerHTML = "Agregar nuevo copro";

	return clon;
});





