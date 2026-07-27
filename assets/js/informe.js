var aux = window.location.href.split('/'),
	ult = aux.length - 1;

var id = parseInt(aux[ult]) || parseInt(aux[ult - 1]);

var tabla = document.getElementById('tabla_copro');

/* Gráficos */
var grafHelm = new Chart('g_helm', {
	type: 'bar',
	data: {
		labels: ['Ascaris', 'Uncinarias', 'Necator', 'Ancylostoma', 'Strongyloides', 'Trichuris'],
		datasets: [{
			label: 'N° de Casos',
			backgroundColor: [
				'rgba(255, 99, 132, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(250, 106, 49, 0.4)',
				'rgba(15, 150, 3, 0.4)',
				'rgba(153, 102, 255, 0.4)',
				'rgba(255, 201, 74, 0.4)'
			],
			borderColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(250, 106, 49, 1)',
				'rgba(15, 150, 3, 1)',
				'rgba(153, 102, 255, 1)',
				'rgba(255, 201, 74, 1)'
			],
			borderWidth: 2
		}]
	},
	options: {
		responsive: false,
		title: {
			display: true,
			fontSize: 18,
			text: 'Geohelmintos Positivos'
		},
		scales: {
			xAxes: [{
				gridLines: {
					display: false
				},
				scaleLabel: {
					display: true,
					labelString: "Geohelmintos"
				}
			}],
			yAxes: [{
				ticks: {
					min: 0
				},
				scaleLabel: {
					display: true,
					labelString: "N° de Casos"
				},
				gridLines: {
					zeroLineColor: "#303030",
					zeroLineWidth: 2
				}
			}]
		}
	}
});

var grafSexo = new Chart('g_sexo', {
    type: 'pie',
    data: {
	    labels: ['Masculino', 'Femenino'],
	    datasets: [{
			label: 'Cantidad',
			backgroundColor: [
				'rgba(54, 162, 235, 0.6)',
				'rgba(255, 99, 132, 0.6)'
			]
	    }]
	},
	options: {
		responsive: false,
		title: {
			display: true,
			fontSize: 18,
			text: 'Sexo'
		}
	}
});

/* Efectos de scroll */
var sr = ScrollReveal({reset: true});

sr.reveal('#tab_1', {
	beforeReveal: function(dom) {
		grafHelm.data.datasets[0].data = [0, 0, 0, 0, 0, 0];
		grafHelm.update();
	}
});

Utils.ajax(
	'/iiet/campanias/lista_resultados_copro/' + id,
	[],
	function(e) {
		var respuesta = e.target.response;

		var cantAscaris       = 0,
			cantUncinarias    = 0,
			cantNecator       = 0,
			cantAncylostoma   = 0,
			cantStrongyloides = 0,
			cantTrichuris     = 0;

		for(let copro of respuesta) {
			let fila = tabla.insertRow();

			fila.insertCell('td').textContent = copro['paciente'];
			fila.insertCell('td').textContent = copro['sexo'];
			fila.insertCell('td').textContent = copro['edad'];
			fila.insertCell('td').textContent = copro['ascaris'];
			fila.insertCell('td').textContent = copro['uncinarias'];
			fila.insertCell('td').textContent = copro['necator'];
			fila.insertCell('td').textContent = copro['ancylostoma'];
			fila.insertCell('td').textContent = copro['strongyloides'];
			fila.insertCell('td').textContent = copro['trichuris'];
			fila.insertCell('td').textContent = copro['geohelmintos'];

			cantAscaris       += copro['ascaris']       === 'POSITIVO';
			cantUncinarias    += copro['uncinarias']    === 'POSITIVO';
			cantNecator       += copro['necator']       === 'POSITIVO';
			cantAncylostoma   += copro['ancylostoma']   === 'POSITIVO';
			cantStrongyloides += copro['strongyloides'] === 'POSITIVO';
			cantTrichuris     += copro['trichuris']     === 'POSITIVO';
		}

		tabla.normalize()

		sr.reveal('#g_helm', {
			beforeReveal: function() {
				grafSexo.data.datasets[0].data = [0, 0];
				grafSexo.update();
			},
			afterReveal: function() {
				grafHelm.data.datasets[0].data = [
			      	cantAscaris,
			      	cantUncinarias,
			      	cantNecator,
			      	cantAncylostoma,
			      	cantStrongyloides,
			      	cantTrichuris
			    ];

			    grafHelm.update();
			}
		});
	}
);

var formPrevalencia = document.prevalencia,
	tablaPrevalencia = document.getElementById('prevalencia');

formPrevalencia['opciones[]'].addEventListener('change', function(e) {
	var fd = new FormData(formPrevalencia);

	obtener_prevalencia(fd);
});

obtener_prevalencia(null);

function obtener_prevalencia(opciones) {
	var xhr = new XMLHttpRequest();

	xhr.open('POST', '/iiet/campanias/prevalencia/' + id, true);
	xhr.responseType = 'json';
	xhr.addEventListener('load', function(e) {
		var respuesta = e.target.response,
			femenino  = respuesta.femenino,
			masculino = respuesta.masculino,
			total     = respuesta.total;

		var f0a5P = (femenino['0a5'].positivos / femenino['0a5'].total) * 100,
			f5a15P = (femenino['5a15'].positivos / femenino['5a15'].total) * 100,
			f15a45P = (femenino['15a45'].positivos / femenino['15a45'].total) * 100,
			f45a100P = (femenino['45a100'].positivos / femenino['45a100'].total) * 100;
			fIndetermP = (femenino['indeterm'].positivos / femenino['indeterm'].total) * 100;
			fTotalP = (femenino['total'].positivos / femenino['total'].total) * 100;

		var m0a5P = (masculino['0a5'].positivos / masculino['0a5'].total) * 100,
			m5a15P = (masculino['5a15'].positivos / masculino['5a15'].total) * 100,
			m15a45P = (masculino['15a45'].positivos / masculino['15a45'].total) * 100,
			m45a100P = (masculino['45a100'].positivos / masculino['45a100'].total) * 100;
			mIndetermP = (masculino['indeterm'].positivos / masculino['indeterm'].total) * 100;
			mTotalP = (masculino['total'].positivos / masculino['total'].total) * 100;

		var t0a5P = (total['0a5'].positivos / total['0a5'].total) * 100,
			t5a15P = (total['5a15'].positivos / total['5a15'].total) * 100,
			t15a45P = (total['15a45'].positivos / total['15a45'].total) * 100,
			t45a100P = (total['45a100'].positivos / total['45a100'].total) * 100;
			tIndetermP = (total['indeterm'].positivos / total['indeterm'].total) * 100;
			tTotalP = (total['total'].positivos / total['total'].total) * 100;


		var f0a5R = femenino['0a5'].positivos + '/' +  femenino['0a5'].total,
			f5a15R = femenino['5a15'].positivos + '/' +  femenino['5a15'].total,
			f15a45R = femenino['15a45'].positivos + '/' +  femenino['15a45'].total,
			f45a100R = femenino['45a100'].positivos + '/' +  femenino['45a100'].total;
			fIndetermR = femenino['indeterm'].positivos + '/' +  femenino['indeterm'].total;
			fTotalR = femenino['total'].positivos + '/' +  femenino['total'].total;

		var m0a5R = masculino['0a5'].positivos + '/' + masculino['0a5'].total,
			m5a15R = masculino['5a15'].positivos + '/' + masculino['5a15'].total,
			m15a45R = masculino['15a45'].positivos + '/' + masculino['15a45'].total,
			m45a100R = masculino['45a100'].positivos + '/' + masculino['45a100'].total;
			mIndetermR = masculino['indeterm'].positivos + '/' + masculino['indeterm'].total;
			mTotalR = masculino['total'].positivos + '/' + masculino['total'].total;

		var t0a5R = total['0a5'].positivos + '/' + total['0a5'].total,
			t5a15R = total['5a15'].positivos + '/' + total['5a15'].total,
			t15a45R = total['15a45'].positivos + '/' + total['15a45'].total,
			t45a100R = total['45a100'].positivos + '/' + total['45a100'].total;
			tIndetermR = total['indeterm'].positivos + '/' + total['indeterm'].total;
			tTotalR = total['total'].positivos + '/' + total['total'].total;


		cF0a5.children[0].textContent = isNaN(f0a5P) ? '--' : f0a5P.toFixed(2) + '%';
		cF0a5.children[1].textContent = '(' + f0a5R + ')';
		cF5a15.children[0].textContent = isNaN(f5a15P) ? '--' : f5a15P.toFixed(2) + '%';
		cF5a15.children[1].textContent = '(' + f5a15R + ')';
		cF15a45.children[0].textContent = isNaN(f15a45P) ? '--' : f15a45P.toFixed(2) + '%';
		cF15a45.children[1].textContent = '(' + f15a45R + ')';
		cF45a100.children[0].textContent = isNaN(f45a100P) ? '--' : f45a100P.toFixed(2) + '%';
		cF45a100.children[1].textContent = '(' + f45a100R + ')';
		cFIndeterm.children[0].textContent = isNaN(fIndetermP) ? '--' : fIndetermP.toFixed(2) + '%';
		cFIndeterm.children[1].textContent = '(' + fIndetermR + ')';
		cFTotal.children[0].textContent = isNaN(fTotalP) ? '--' : fTotalP.toFixed(2) + '%';
		cFTotal.children[1].textContent = '(' + fTotalR + ')';

		cM0a5.children[0].textContent = isNaN(m0a5P) ? '--' : m0a5P.toFixed(2) + '%';
		cM0a5.children[1].textContent = '(' + m0a5R + ')';
		cM5a15.children[0].textContent = isNaN(m5a15P) ? '--' : m5a15P.toFixed(2) + '%';
		cM5a15.children[1].textContent = '(' + m5a15R + ')';
		cM15a45.children[0].textContent = isNaN(m15a45P) ? '--' : m15a45P.toFixed(2) + '%';
		cM15a45.children[1].textContent = '(' + m15a45R + ')';
		cM45a100.children[0].textContent = isNaN(m45a100P) ? '--' : m45a100P.toFixed(2) + '%';
		cM45a100.children[1].textContent = '(' + m45a100R + ')';
		cMIndeterm.children[0].textContent = isNaN(mIndetermP) ? '--' : mIndetermP.toFixed(2) + '%';
		cMIndeterm.children[1].textContent = '(' + mIndetermR + ')';
		cMTotal.children[0].textContent = isNaN(mTotalP) ? '--' : mTotalP.toFixed(2) + '%';
		cMTotal.children[1].textContent = '(' + mTotalR + ')';

		cT0a5.children[0].textContent = isNaN(t0a5P) ? '--' : t0a5P.toFixed(2) + '%';
		cT0a5.children[1].textContent = '(' + t0a5R + ')';
		cT5a15.children[0].textContent = isNaN(t5a15P) ? '--' : t5a15P.toFixed(2) + '%';
		cT5a15.children[1].textContent = '(' + t5a15R + ')';
		cT15a45.children[0].textContent = isNaN(t15a45P) ? '--' : t15a45P.toFixed(2) + '%';
		cT15a45.children[1].textContent = '(' + t15a45R + ')';
		cT45a100.children[0].textContent = isNaN(t45a100P) ? '--' : t45a100P.toFixed(2) + '%';
		cT45a100.children[1].textContent = '(' + t45a100R + ')';
		cTIndeterm.children[0].textContent = isNaN(tIndetermP) ? '--' : tIndetermP.toFixed(2) + '%';
		cTIndeterm.children[1].textContent = '(' + tIndetermR + ')';
		cTTotal.children[0].textContent = isNaN(tTotalP) ? '--' : tTotalP.toFixed(2) + '%';
		cTTotal.children[1].textContent = '(' + tTotalR + ')';

		tablaPrevalencia.normalize();

		sr.reveal('#g_sexo', {
			beforeReveal: function() {
				grafHelm.data.datasets[0].data = [0, 0, 0, 0, 0, 0];
				grafHelm.update();
			},
			afterReveal: function() {
				grafSexo.data.datasets[0].data = [
			      	masculino['total'].total,
			      	femenino['total'].total
			    ];

			    grafSexo.update();
			}
		});	

		sr.reveal('#g_fem', {
			beforeReveal: function() {
				grafMasc.data.datasets[0].data = [0, 0, 0, 0, 0];
				grafMasc.data.datasets[1].data = [0, 0, 0, 0, 0];
				grafMasc.update();
			},
			afterReveal: function() {
				grafFem.data.datasets[0].data = [
			      	femenino['0a5'].total,
			      	femenino['5a15'].total,
			      	femenino['15a45'].total,
			      	femenino['45a100'].total,
			      	femenino['indeterm'].total
			    ];

			    grafFem.data.datasets[1].data = [
			      	femenino['0a5'].positivos,
			      	femenino['5a15'].positivos,
			      	femenino['15a45'].positivos,
			      	femenino['45a100'].positivos,
			      	femenino['indeterm'].positivos
			    ];

			    grafFem.update();
			}
		});

		sr.reveal('#g_masc', {
			beforeReveal: function() {
				grafFem.data.datasets[0].data = [0, 0, 0, 0, 0];
				grafFem.data.datasets[1].data = [0, 0, 0, 0, 0];
				grafFem.update();

				grafTotal.data.datasets[0].data = [0, 0, 0, 0, 0];
				grafTotal.data.datasets[1].data = [0, 0, 0, 0, 0];
				grafTotal.update();
			},
			afterReveal: function() {
				grafMasc.data.datasets[0].data = [
			      	masculino['0a5'].total,
			      	masculino['5a15'].total,
			      	masculino['15a45'].total,
			      	masculino['45a100'].total,
			      	masculino['indeterm'].total
			    ];

			    grafMasc.data.datasets[1].data = [
			      	masculino['0a5'].positivos,
			      	masculino['5a15'].positivos,
			      	masculino['15a45'].positivos,
			      	masculino['45a100'].positivos,
			      	masculino['indeterm'].positivos
			    ];

			    grafMasc.update();
			}
		});

		sr.reveal('#g_total', {
			beforeReveal: function() {
				grafMasc.data.datasets[0].data = [0, 0, 0, 0, 0];
				grafMasc.data.datasets[1].data = [0, 0, 0, 0, 0];
				grafMasc.update();
			},
			afterReveal: function() {
				grafTotal.data.datasets[0].data = [
			      	total['0a5'].total,
			      	total['5a15'].total,
			      	total['15a45'].total,
			      	total['45a100'].total,
			      	total['indeterm'].total
			    ];

			    grafTotal.data.datasets[1].data = [
			      	total['0a5'].positivos,
			      	total['5a15'].positivos,
			      	total['15a45'].positivos,
			      	total['45a100'].positivos,
			      	total['indeterm'].positivos
			    ];

			    grafTotal.update();
			}
		});
	});

	xhr.send(opciones);
}

var btnPrevalencia = document.getElementById('btn_prevalencia'),
	btnGeohelmintos = document.getElementById('btn_geohelmintos');

var estGeohelmintos = document.getElementById('result_helm'),
	estPrevalencia = document.getElementById('est_prevalencia');

btnPrevalencia.addEventListener('click', function(e) {
	estGeohelmintos.className = 'oculto';
	estPrevalencia.className = '';

	tablaPrevalencia.normalize();
});

btnGeohelmintos.addEventListener('click', function(e) {
	estPrevalencia.className = 'oculto';
	estGeohelmintos.className = '';

	tabla.normalize();
});

var cF0a5, cF5a15, cF15a45, cF45a100, cFIndeterm, cFTotal,
	cM0a5, cM5a15, cM15a45, cM45a100, cMIndeterm, cMTotal,
	cT0a5, cT5a15, cT15a45, cT45a100, cTIndeterm, cTTotal;

var cPP, cPN, cPT, cNP, cNN, cNT, cTP, cTN, cTT;

window.addEventListener('load', function(e) {
	var top = Utils.getTop(tabla);

	tabla.dataset.maxWidth  = (window.innerWidth - 60) + 'px';
	tabla.dataset.maxHeight = (window.innerHeight - top - 20) + 'px';

	// tabla prevalencia
	cF0a5 = tablaPrevalencia.cells[1][1];
	cF5a15 = tablaPrevalencia.cells[1][2];
	cF15a45 = tablaPrevalencia.cells[1][3];
	cF45a100 = tablaPrevalencia.cells[1][4];
	cFIndeterm = tablaPrevalencia.cells[1][5];
	cFTotal = tablaPrevalencia.cells[1][6];

	cM0a5 = tablaPrevalencia.cells[2][1];
	cM5a15 = tablaPrevalencia.cells[2][2];
	cM15a45 = tablaPrevalencia.cells[2][3];
	cM45a100 = tablaPrevalencia.cells[2][4];
	cMIndeterm = tablaPrevalencia.cells[2][5];
	cMTotal = tablaPrevalencia.cells[2][6];

	cT0a5 = tablaPrevalencia.cells[3][1];
	cT5a15 = tablaPrevalencia.cells[3][2];
	cT15a45 = tablaPrevalencia.cells[3][3];
	cT45a100 = tablaPrevalencia.cells[3][4];
	cTIndeterm = tablaPrevalencia.cells[3][5];
	cTTotal = tablaPrevalencia.cells[3][6];

	// tabla 2x2
	cPP = tabla2x2.cells[1][1];
	cPN = tabla2x2.cells[1][2];
	cPX = tabla2x2.cells[1][3];
	cPT = tabla2x2.cells[1][4];

	cNP = tabla2x2.cells[2][1];
	cNN = tabla2x2.cells[2][2];
	cNX = tabla2x2.cells[2][3];
	cNT = tabla2x2.cells[2][4];

	cXP = tabla2x2.cells[3][1];
	cXN = tabla2x2.cells[3][2];
	cXX = tabla2x2.cells[3][3];
	cXT = tabla2x2.cells[3][4];

	cTP = tabla2x2.cells[4][1];
	cTN = tabla2x2.cells[4][2];
	cTX = tabla2x2.cells[4][3];
	cTT = tabla2x2.cells[4][4];
});


var form2x2 = document.geo2x2,
	tabla2x2 = document.getElementById('tabla_2x2');

form2x2.helminto.addEventListener('change', function(e) {
	var metodo1 = form2x2.metodo1,
		metodo2 = form2x2.metodo2;

	switch(form2x2.helminto.value) {
		case 'ascaris':
		case 'trichuris':
		case 'uncinarias':
			metodo1.options[0].disabled = null;
			metodo1.options[1].disabled = null;
			metodo1.options[2].disabled = 'disabled';
			metodo1.options[3].disabled = 'disabled';
			metodo1.options[4].disabled = 'disabled';
			metodo1.options[0].selected = 'selected';

			metodo2.options[0].disabled = null;
			metodo2.options[1].disabled = null;
			metodo2.options[2].disabled = 'disabled';
			metodo2.options[3].disabled = 'disabled';
			metodo2.options[4].disabled = 'disabled';
			metodo2.options[1].selected = 'selected';
		break;

		case 'strongyloides':
			metodo1.options[0].disabled = null;
			metodo1.options[1].disabled = 'disabled';
			metodo1.options[2].disabled = null;
			metodo1.options[3].disabled = null;
			metodo1.options[4].disabled = null;
			metodo1.options[0].selected = 'selected';

			metodo2.options[0].disabled = null;
			metodo2.options[1].disabled = 'disabled';
			metodo2.options[2].disabled = null;
			metodo2.options[3].disabled = null;
			metodo2.options[4].disabled = null;
			metodo2.options[2].selected = 'selected';
		break;

		case 'necator':
		case 'ancylostoma':
			metodo1.options[0].disabled = 'disabled';
			metodo1.options[1].disabled = 'disabled';
			metodo1.options[2].disabled = null;
			metodo1.options[3].disabled = null;
			metodo1.options[4].disabled = null;
			metodo1.options[2].selected = 'selected';

			metodo2.options[0].disabled = 'disabled';
			metodo2.options[1].disabled = 'disabled';
			metodo2.options[2].disabled = null;
			metodo2.options[3].disabled = null;
			metodo2.options[4].disabled = null;
			metodo2.options[3].selected = 'selected';
		break;
	}

	obtenerTabla2x2();
});


form2x2.metodo1.addEventListener('change', obtenerTabla2x2);
form2x2.metodo2.addEventListener('change', obtenerTabla2x2);


obtenerTabla2x2();

function obtenerTabla2x2() {
	var fd = new FormData(form2x2);

	var xhr = new XMLHttpRequest();

	xhr.open('POST', '/iiet/campanias/tabla_contingencia/' + id, true);
	xhr.responseType = 'json';

	xhr.addEventListener('load', function(e) {
		var t2x2 = e.target.response;

		cPP.textContent = t2x2.pp;
		cPN.textContent = t2x2.pn;
		cPX.textContent = t2x2.px;
		cPT.textContent = t2x2.pt;

		cNP.textContent = t2x2.np;
		cNN.textContent = t2x2.nn;
		cNX.textContent = t2x2.nx;
		cNT.textContent = t2x2.nt;

		cXP.textContent = t2x2.xp;
		cXN.textContent = t2x2.xn;
		cXX.textContent = t2x2.xx;
		cXT.textContent = t2x2.xt;

		cTP.textContent = t2x2.tp;
		cTN.textContent = t2x2.tn;
		cTX.textContent = t2x2.tx;
		cTT.textContent = t2x2.tt;

		tabla2x2.normalize();
	});

	xhr.send(fd);
}

/*
var barChart = new Chart(grafico, {
  type: 'bar',
  data: {
    labels: ["China", "India", "United States", "Indonesia", "Brazil", "Pakistan", "Nigeria", "Bangladesh", "Russia", "Japan"],
    datasets: [{
      label: 'Population',
      data: [1379302771, 1281935911, 326625791, 260580739, 207353391, 204924861, 190632261, 157826578, 142257519, 126451398],
      backgroundColor: [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)',
        'rgba(255, 159, 64, 0.6)',
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)'
      ]
    }]
  }
});*/



/*function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

function autoScroll(selector) {
    var scrollAttempts = 0;
    var incrementScrollAttempts = debounce(function() {
        scrollAttempts++;
    }, 50000);

    window.addEventListener('scroll', incrementScrollAttempts);

    var el = document.querySelector(selector);
    var chkReadyState = setInterval(function() {
        if (el) {
            window.scrollTo(0, el.offsetTop);
        }
        if (document.readyState == 'complete' || scrollAttempts > 1) {
            clearInterval(chkReadyState);
            window.removeEventListener('scroll', incrementScrollAttempts, false);
        }
    }, 100);
};

autoScroll('#gh');*/

autoScroll('.i');

var CORRECTION = 0;  // height of the navbar 
// don't forget to setup the data-offset attribute of the <body> tag

var DELAY_READING = 4000; // 4 seconds = 4000; 10 seconds = 10000
var DELAY_SCROLLING = 1000;

function autoScroll(selector) {
	var elems = document.querySelectorAll(selector);

	for(let link of elems)
		link.addEventListener('click', function(e) {
			e.preventDefault();
			scrollToLink(e.target.hash);
		});
}

/*$('#ir_abajo').click(function(e) {
	e.preventDefault();
	scrollToLink('#slider');
});*/

function scrollToLink( link ) {
  selectLink = document.querySelector(link);
  console.log(selectLink);

  if ( selectLink ) {
    //var top = selectLink.offset().top - CORRECTION;
    var top = selectLink.getBoundingClientRect()['top'];
    console.log(top);
    scrolling(top, DELAY_SCROLLING);

    //$('body,html').stop().animate({scrollTop: top}, DELAY_SCROLLING);
  } else {
    console.log('The link is not found: ' + link);
  }
}

function scrolling(pos, delay) {
	var x = window.scrollX,
		y = window.scrollY;

	if(pos > 0)
		var handler = window.setInterval(function() {
			if(pos > 0)
				window.scrollTo(x, y += 10);

			else
				window.clearInterval(handler);

			pos -= 10;
		}, 1);

	else
		var handler = window.setInterval(function() {
			if(pos < 0)
				window.scrollTo(x, y -= 10);

			else
				window.clearInterval(handler);

			pos += 10;
		}, 1);
}

var grafFem = new Chart('g_fem', {
	type: 'bar',
	data: {
		labels: ['0 a 5', '5 a 14', '15 a 44', '45 a ...', 'inf'],
		datasets: [{
			label: 'N° de Femeninos',
			backgroundColor: [
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
			],
			borderColor: [
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
			],
			borderWidth: 2
		},
		{
			label: 'N° de Casos Positivos',
			backgroundColor: [
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
			],
			borderColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
			],
			borderWidth: 2
		}]
	},
	options: {
		responsive: false,
		title: {
			display: true,
			fontSize: 18,
			text: 'Femenino'
		},
		scales: {
			xAxes: [{
				gridLines: {
					display: false
				},
				scaleLabel: {
					display: true,
					labelString: "Edad"
				}
			}],
			yAxes: [{
				ticks: {
					min: 0
				},
				scaleLabel: {
					display: true,
					labelString: "N° de Casos"
				},
				gridLines: {
					zeroLineColor: "#303030",
					zeroLineWidth: 2
				}
			}]
		}
	}
});

var grafMasc = new Chart('g_masc', {
	type: 'bar',
	data: {
		labels: ['0 a 5', '5 a 14', '15 a 44', '45 a ...', 'inf'],
		datasets: [{
			label: 'N° de Masculinos',
			backgroundColor: [
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
			],
			borderColor: [
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
			],
			borderWidth: 2
		},
		{
			label: 'N° de Casos Positivos',
			backgroundColor: [
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
			],
			borderColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
			],
			borderWidth: 2
		}]
	},
	options: {
		responsive: false,
		title: {
			display: true,
			fontSize: 18,
			text: 'Masculino'
		},
		scales: {
			xAxes: [{
				gridLines: {
					display: false
				},
				scaleLabel: {
					display: true,
					labelString: "Edad"
				}
			}],
			yAxes: [{
				ticks: {
					min: 0
				},
				scaleLabel: {
					display: true,
					labelString: "N° de Casos"
				},
				gridLines: {
					zeroLineColor: "#303030",
					zeroLineWidth: 2
				}
			}]
		}
	}
});

var grafTotal = new Chart('g_total', {
	type: 'bar',
	data: {
		labels: ['0 a 5', '5 a 14', '15 a 44', '45 a ...', 'inf'],
		datasets: [{
			label: 'N° Total',
			backgroundColor: [
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
				'rgba(54, 162, 235, 0.4)',
			],
			borderColor: [
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(54, 162, 235, 1)',
			],
			borderWidth: 2
		},
		{
			label: 'N° de Casos Positivos',
			backgroundColor: [
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
				'rgba(255, 99, 132, 0.4)',
			],
			borderColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(255, 99, 132, 1)',
			],
			borderWidth: 2
		}]
	},
	options: {
		responsive: false,
		title: {
			display: true,
			fontSize: 18,
			text: 'Total'
		},
		scales: {
			xAxes: [{
				gridLines: {
					display: false
				},
				scaleLabel: {
					display: true,
					labelString: "Edad"
				}
			}],
			yAxes: [{
				ticks: {
					min: 0
				},
				scaleLabel: {
					display: true,
					labelString: "N° de Casos"
				},
				gridLines: {
					zeroLineColor: "#303030",
					zeroLineWidth: 2
				}
			}]
		}
	}
});

estPrevalencia.className = 'oculto';