var contenedorVM = document.getElementById('contenedor_vm');

var tDpto = document.getElementById('t_dpto').content,
	tLocalidad = document.getElementById('t_localidad').content,
	tBarrio = document.getElementById('t_barrio').content,
	tParaje = document.getElementById('t_paraje').content,
	tInstitucion = document.getElementById('t_institucion').content,
	tPuesto = document.getElementById('t_puesto').content,
	tMsjNoDivPolit = document.getElementById('t_msj_no_divpolit').content;

var dptos = document.getElementById('departamentos'),
	localidades = document.getElementById('localidades'),
	barrios = document.getElementById('barrios'),
	parajes = document.getElementById('parajes'),
	instituciones = document.getElementById('instituciones'),
	puesto = document.getElementById('puestos');

var listaDptos = document.getElementById('lista_dptos'),
	listaLocalidades = document.getElementById('lista_localidades'),
	listaBarrios = document.getElementById('lista_barrios'),
	listaParajes = document.getElementById('lista_parajes'),
	listaInstituciones = document.getElementById('lista_instituciones'),
	listaPuestos = document.getElementById('lista_puestos');

var msjEstado = new ObjMensajeEstado();

var ObjDivPolit = function() {
	this.nombre     = null;
	this.lista      = null;
	this.template   = null;
	this.contenedor = null;
	this.idVMForm   = null;
	this.form       = null;
	this.arrDatos   = [];
	this.zoomMapa   = 0;
};

var gObjDptos         = new ObjDivPolit(),
	gObjLocalidades   = new ObjDivPolit(),
	gObjBarrios       = new ObjDivPolit(),
	gObjParajes       = new ObjDivPolit(),
	gObjPuestos       = new ObjDivPolit(),
	gObjInstituciones = new ObjDivPolit();

gObjDptos.nombre     = 'departamentos';
gObjDptos.idVMForm   = 'form_dpto';
gObjDptos.form       = formNuevoDepartamento(contenedorVM);
gObjDptos.template   = document.getElementById('t_dpto').content;
gObjDptos.contenedor = document.getElementById('departamentos');
gObjDptos.lista      = document.getElementById('lista_dptos');
gObjDptos.zoomMapa   = Mapa.ZOOM_PROVINCIA;

gObjLocalidades.nombre     = 'localidades';
gObjLocalidades.idVMForm   = 'form_localidad';
gObjLocalidades.form       = formNuevaLocalidad(contenedorVM);
gObjLocalidades.template   = document.getElementById('t_localidad').content;
gObjLocalidades.contenedor = document.getElementById('localidades');
gObjLocalidades.lista      = document.getElementById('lista_localidades');
gObjLocalidades.listar     = listarLocalidades;
gObjLocalidades.zoomMapa   = Mapa.ZOOM_DEPARTAMENTO;

gObjBarrios.nombre     = 'barrios';
gObjBarrios.idVMForm   = 'form_barrio';
gObjBarrios.form       = formNuevoBarrio(contenedorVM);
gObjBarrios.template   = document.getElementById('t_barrio').content;
gObjBarrios.contenedor = document.getElementById('barrios');
gObjBarrios.lista      = document.getElementById('lista_barrios');
gObjBarrios.listar     = listarBarrios;
gObjBarrios.zoomMapa   = Mapa.ZOOM_LOCALIDAD;

gObjParajes.nombre     = 'parajes';
gObjParajes.idVMForm   = 'form_paraje';
gObjParajes.form       = formNuevoParaje(contenedorVM);
gObjParajes.template   = document.getElementById('t_paraje').content;
gObjParajes.contenedor = document.getElementById('parajes');
gObjParajes.lista      = document.getElementById('lista_parajes');
gObjParajes.listar     = listarParajes;
gObjParajes.zoomMapa   = Mapa.ZOOM_LOCALIDAD;

gObjPuestos.nombre     = 'puestos';
gObjPuestos.idVMForm   = 'form_puesto';
gObjPuestos.form       = formNuevoPuesto(contenedorVM);
gObjPuestos.template   = document.getElementById('t_puesto').content;
gObjPuestos.contenedor = document.getElementById('puestos');
gObjPuestos.lista      = document.getElementById('lista_puestos');
gObjPuestos.listar     = listarPuestos;
gObjPuestos.zoomMapa   = Mapa.ZOOM_PARAJE;

gObjInstituciones.nombre     = 'instituciones';
gObjInstituciones.idVMForm   = 'form_institucion';
gObjInstituciones.form       = formNuevaEscuela(contenedorVM);
gObjInstituciones.template   = document.getElementById('t_institucion').content;
gObjInstituciones.contenedor = document.getElementById('instituciones');
gObjInstituciones.lista      = document.getElementById('lista_instituciones');
gObjInstituciones.listar     = listarInstituciones;
gObjInstituciones.zoomMapa   = Mapa.ZOOM_LOCALIDAD;


gObjDptos.form.fijarDivPolitOrdSup({});
gObjDptos.form.prepararMapa([-65.3818, -24.1573], Mapa.ZOOM_PROVINCIA);


gObjDptos.form.fcExito = e => fcExitoForm(e.target.response.id, gObjDptos);

function fcExitoForm(idNuevo, objDivPolit) {
	var form = objDivPolit.form;

	if(form.modo == form.NUEVO) {
		msjEstado.establecerTexto1('Se han cargado correctamente los datos.');

		Utils.ajax(
			'/iiet/entidades/obtener_datos/' + objDivPolit.nombre + '/' + idNuevo,
			[],
			e => agregarItem(e.target.response, objDivPolit)
		);
	}

	else if(form.modo == form.ACTUALIZAR) {
		msjEstado.establecerTexto1('Se han actualizado correctamente los datos.');

		var actualizado = {
			numero: form.numero,
			nombre: form.nombre,
			latitud: form.latitud,
			longitud: form.longitud
		};
	}

	msjEstado.establecerTexto2('');
	msjEstado.mostrar(ObjMensajeEstado.EXITO);

	form.mapa.desmarcar();
	form.prepararMapa([-65.3818, -24.1573], Mapa.ZOOM_PROVINCIA);

	form.vm.close();
}

function agregarItem(datosNuevo, objDivPolit) {
	var item = nuevoItem(objDivPolit.lista, objDivPolit.template, datosNuevo, objDivPolit.zoomMapa),
		item.links  = item.getElementsByClassName('links')[0].children,
		item.editar = item.getElementsByClassName('editar')[0];

	links[0].addEventListener('click', function(e) {
		localidades.className = 'oculto';

		divPolitOrdSup.localidad = localidad;
		listarBarrios(divPolitOrdSup);
	});

	links[1].addEventListener('click', function(e) {
		localidades.className = 'oculto';

		divPolitOrdSup.localidad = localidad;
		listarParajes(divPolitOrdSup);
	});

	item.editar.addEventListener('click', e => configEditar(objDivPolit));
}


var btnsAtras = document.getElementsByClassName('atras');

configBtnAtras(btnsAtras[0], localidades, dptos);
configBtnAtras(btnsAtras[1], barrios, localidades);
configBtnAtras(btnsAtras[2], parajes, localidades);
configBtnAtras(btnsAtras[4], puestos, parajes);

btnsAtras[3].addEventListener('click', function(e) {
	var listaAnterior = null;

	if(this.lugar == 'barrio')
		listaAnterior = barrios;
	
	else
		listaAnterior = parajes;

	instituciones.className = 'oculto';
	listaAnterior.className = '';

	instituciones.getElementsByClassName('lista')[0].innerHTML = '';
});


Utils.ajax(
	'/iiet/entidades/listado_departamentos',
	[],
	function(e) {
		gObjDptos.arrDatos = e.target.response;

		for(let dpto of gObjDptos.arrDatos) {
			let item   = nuevoItem(listaDptos, tDpto, dpto, Mapa.ZOOM_PROVINCIA),
				links  = item.getElementsByClassName('links')[0].children,
				editar = item.getElementsByClassName('editar')[0];

			links[0].addEventListener('click', function(e) {
				dptos.className = 'oculto';

				listarLocalidades({ dpto: dpto });
			});

			editar.addEventListener('click', e => configEditar(gObjDptos.form, dpto, 'form_dpto'));
		}
	}
);

function listarLocalidades(divPolitOrdSup) {
	var datosDpto = divPolitOrdSup.dpto,
		coordDpto = datosDpto.longitud ? [datosDpto.longitud, datosDpto.latitud] : null;

	gObjLocalidades.form.departamento.value = datosDpto.numero;
	gObjLocalidades.form.fijarDivPolitOrdSup(divPolitOrdSup);
	gObjLocalidades.form.prepararMapa(coordDpto, Mapa.ZOOM_DEPARTAMENTO);

	Utils.ajax(
		'/iiet/entidades/listado_localidades/' + datosDpto.numero,
		[],
		function(e) {
			localidades.className = '';
			localidades.children[0].children[0].textContent = datosDpto.nombre;

			gObjLocalidades.arrDatos = e.target.response;

			if(gObjLocalidades.arrDatos.length > 0) {
				for(let localidad of gObjLocalidades.arrDatos) {
					
				}
			}

			else
				establecerMsjNoDivPolit(listaLocalidades, 'Localidades');
		}
	);
}

function listarBarrios(divPolitOrdSup) {
	var datosLocalidad = divPolitOrdSup.localidad,
		coordLocalidad = datosLocalidad.longitud ? [datosLocalidad.longitud, datosLocalidad.latitud] : null;

	gObjBarrios.form.localidad.value = datosLocalidad.numero;
	gObjBarrios.form.fijarDivPolitOrdSup(divPolitOrdSup);
	gObjBarrios.form.prepararMapa(coordLocalidad, Mapa.ZOOM_LOCALIDAD);

	Utils.ajax(
		'/iiet/entidades/listado_barrios/' + datosLocalidad.numero,
		[],
		function(e) {
			barrios.className = '';
			barrios.children[0].children[0].textContent = datosLocalidad.nombre;

			gObjBarrios.arrDatos = e.target.response;

			if(gObjBarrios.arrDatos.length > 0) {
				for(let barrio of gObjBarrios.arrDatos) {
					let item   = nuevoItem(listaBarrios, tBarrio, barrio, Mapa.ZOOM_LOCALIDAD),
						editar = item.getElementsByClassName('editar')[0],
						links  = item.getElementsByClassName('links')[0].children;

					links[0].addEventListener('click', function(e) {
						barrios.className = 'oculto';

						divPolitOrdSup.barrio = barrio;
						listarInstituciones('barrio', divPolitOrdSup);
					});

					editar.addEventListener('click', e => configEditar(gObjBarrios.form, barrio, 'form_barrio'));
				}
			}

			else
				establecerMsjNoDivPolit(listaBarrios, 'Barrios');
		}
	);
}

function listarParajes(divPolitOrdSup) {
	var datosLocalidad = divPolitOrdSup.localidad,
		coordLocalidad = datosLocalidad.longitud ? [datosLocalidad.longitud, datosLocalidad.latitud] : null;

	gObjParajes.form.localidad.value = datosLocalidad.numero;
	gObjParajes.form.fijarDivPolitOrdSup(divPolitOrdSup);
	gObjParajes.form.prepararMapa(coordLocalidad, Mapa.ZOOM_DEPARTAMENTO);

	Utils.ajax(
		'/iiet/entidades/listado_parajes/' + datosLocalidad.numero,
		[],
		function(e) {
			parajes.className = '';
			parajes.children[0].children[0].textContent = datosLocalidad.nombre;

			gObjParajes.arrDatos = e.target.response;

			if(gObjParajes.arrDatos.length > 0) {
				for(let paraje of gObjParajes.arrDatos) {
					let item   = nuevoItem(listaParajes, tParaje, paraje, Mapa.ZOOM_DEPARTAMENTO),
						links  = item.getElementsByClassName('links')[0].children,
						editar = item.getElementsByClassName('editar')[0];

					links[0].addEventListener('click', function(e) {
						parajes.className = 'oculto';

						divPolitOrdSup.paraje = paraje;
						listarPuestos(divPolitOrdSup);
					});

					links[1].addEventListener('click', function(e) {
						parajes.className = 'oculto';

						divPolitOrdSup.paraje = paraje;
						listarInstituciones('paraje', divPolitOrdSup);
					});

					editar.addEventListener('click', e => configEditar(gObjParajes.form, paraje, 'form_paraje'));
				}
			}

			else
				establecerMsjNoDivPolit(listaParajes, 'Parajes');
		}
	);
}

function listarInstituciones(lugar, divPolitOrdSup) {
	var datosLugar = divPolitOrdSup[lugar],
		coordBarrio = datosLugar.longitud ? [datosLugar.longitud, datosLugar.latitud] : null;

	gObjInstituciones.form.lugar.value = lugar;
	gObjInstituciones.form[lugar].value = datosLugar.numero;
	gObjInstituciones.form.fijarDivPolitOrdSup(divPolitOrdSup);
	gObjInstituciones.form.prepararMapa(coordBarrio, lugar == 'barrio' ? Mapa.ZOOM_BARRIO : Mapa.ZOOM_LOCALIDAD);

	Utils.ajax(
		'/iiet/escuelas/listado_escuelas/' + lugar + '/' + datosLugar.numero,
		[],
		function(e) {
			instituciones.className = '';
			instituciones.children[0].children[0].textContent = Utils.toCamelCase(lugar) + ' ' + datosLugar.nombre;

			gObjInstituciones.arrDatos = e.target.response;

			if(gObjInstituciones.arrDatos.length > 0) {
				for(let institucion of gObjInstituciones.arrDatos) {
					let item   = nuevoItem(listaInstituciones, tInstitucion, institucion, Mapa.ZOOM_LOCALIDAD),
						editar = item.getElementsByClassName('editar')[0];

					editar.addEventListener('click', e => configEditar(gObjInstituciones.form, institucion, 'form_institucion'));
				}
			}

			else
				establecerMsjNoDivPolit(listaInstituciones, 'Instituciones');

			btnsAtras[3].lugar = lugar;
			btnsAtras[3].title = 'Volver al listado de ' + lugar + 's';
		}
	);
}

function listarPuestos(divPolitOrdSup) {
	var datosParaje = divPolitOrdSup.paraje,
		coordParaje = datosParaje.longitud ? [datosParaje.longitud, datosParaje.latitud] : null;

	gObjPuestos.form.paraje.value = datosParaje.numero;
	gObjPuestos.form.fijarDivPolitOrdSup(divPolitOrdSup);
	gObjPuestos.form.prepararMapa(coordParaje, Mapa.ZOOM_LOCALIDAD);

	Utils.ajax(
		'/iiet/entidades/listado_puestos/' + datosParaje.numero,
		[],
		function(e) {
			puestos.className = '';
			puestos.children[0].children[0].textContent = 'Paraje ' + datosParaje.nombre;

			gObjPuestos.arrDatos = e.target.response;

			if(gObjPuestos.arrDatos.length > 0) {
				for(let puesto of gObjPuestos.arrDatos) {
					let item   = nuevoItem(listaPuestos, tPuesto, puesto, Mapa.ZOOM_LOCALIDAD),
						editar = item.getElementsByClassName('editar')[0];

					editar.addEventListener('click', e => configEditar(gObjPuestos.form, puesto, 'form_puesto'));
				}
			}

			else
				establecerMsjNoDivPolit(listaPuestos, 'Puestos');
		}
	);
}

function nuevoItem(lista, template, divPolit, zoomMapa) {
	lista.appendChild(document.importNode(template, true));

	var ultIndice = lista.children.length - 1,
		ultElem   = lista.children[ultIndice];

	var nroDivPolit    = ultElem.getElementsByClassName('nro_divpolit')[0],
		nombreDivPolit = ultElem.getElementsByClassName('nombre_divpolit')[0],
		mapDiv         = ultElem.getElementsByClassName('map')[0];

	nroDivPolit.textContent    = ultIndice + 1;
	nombreDivPolit.children[0].textContent = divPolit.nombre;

	if(divPolit.latitud) {
		var coord = [divPolit.longitud, divPolit.latitud],
			mapa  = new Mapa(mapDiv, coord, zoomMapa);

		mapa.marcar(coord);
	}

	else
		mapDiv.className += ' no_mapa';

	return ultElem;
}

function configEditar(form, datos, urlVM) {
	form.fijarModo(form.ACTUALIZAR);
	form.cargarDatos(datos);

	window.location.hash = '#' + urlVM;
}

function establecerMsjNoDivPolit(lista, divPolit) {
	lista.appendChild(document.importNode(tMsjNoDivPolit, true));

	var msj = lista.getElementsByClassName('msj_no_divpolit')[0];

	msj.textContent = 'No se han creado ' + divPolit;
}

function configBtnAtras(btnAtras, listaActual, listaAnterior) {
	btnAtras.addEventListener('click', e => {
		listaActual.className = 'oculto';
		listaAnterior.className = '';

		listaActual.getElementsByClassName('lista')[0].innerHTML = '';
	});
}