(function() {

/***************************************************************/
/*                             Pila                            */
/***************************************************************/
function Pila() {
	this.self = new Array();
}

Pila.prototype.poner = function(e) {
	this.self.push(e);
};

Pila.prototype.sacar = function() {
	return this.self.pop();
};

Pila.prototype.obtener = function(i) {
	return this.self[i];
};

Pila.prototype.obtenerUltimo = function() {
	return this.self[this.self.length - 1];
};

Pila.prototype.tamanio = function() {
	return this.self.length;
};

Pila.prototype.estaVacia = function() {
	return this.self.length === 0;
};

function ConfigContenedor(contenedor) {
	this.contenedor = contenedor;
	this.scrollY = window.scrollY;
}


/***************************************************************/
/*                             Item                            */
/***************************************************************/
function Item(template, datos) {
	document.body.appendChild(document.importNode(template, true));

	this.elem  = document.body.lastElementChild;
	this.datos = datos;
	this.mapa  = null;

	this.nro = this.elem.getElementsByClassName('nro_divpolit')[0];
	this.nombre = this.elem.getElementsByClassName('nombre_divpolit')[0].firstElementChild;

	this.establecerNombre(datos.nombre);

	$(this.elem).on('click', '.btn-editar', e =>
		this.elem.dispatchEvent(new CustomEvent('divpolit.accion.editar', {
			view: window,
			bubbles: true,
			cancelable: true,
			detail: this
		}))
	);

	$(this.elem).on('click', '.btn-eliminar', e =>
		this.elem.dispatchEvent(new CustomEvent('divpolit.accion.eliminar', {
			view: window,
			bubbles: true,
			cancelable: true,
			detail: this
		}))
	);

	$(this.elem).on('click', '.links', e => 
		this.elem.dispatchEvent(new CustomEvent('divpolit.accion.descender', {
			view: window,
			bubbles: true,
			cancelable: true,
			detail: {
				posLink: e.target.dataset.pos,
				item: this
			}
		}))
	);

	var divMapa = this.elem.getElementsByClassName('map')[0];

	if(datos.latitud) {
		var coord = [datos.longitud, datos.latitud],
			zoom = parseInt(divMapa.dataset.zoom);

		this.mapa  = new Mapa(divMapa, coord, zoom);
		this.mapa.marcar(coord);
	}

	else
		divMapa.className += ' no_mapa';

	document.body.removeChild(this.elem);
}

Item.prototype.establecerNro = function(nro) {
	this.nro.textContent = nro;
};

Item.prototype.obtenerNro = function() {
	return this.nro.textContent;
};

Item.prototype.establecerNombre = function(nombre) {
	this.nombre.textContent = nombre;
};

Item.prototype.obtenerNombre = function() {
	return this.datos.nombre;
};

Item.prototype.establecerCoordMapa = function(coord) {
	this.mapa.marcar(coord);
};

Item.prototype.obtenerId = function() {
	return this.datos.numero;
};

Item.prototype.obtenerDatos = function() {
	return this.datos;
};


/***************************************************************/
/*                            Lista                            */
/***************************************************************/
function ListaDivPolit(lista, template) {
	this.elem          = lista;
	this.templateItem  = template;
	this.arrItems      = new Array();
	this.itemActual    = null;

	var self = this,
		modalElim = $('#modal-eliminar');

	lista.addEventListener('divpolit.accion.editar', e => this.itemActual = e.detail );
	lista.addEventListener('divpolit.accion.eliminar', function(e) {
		self.itemActual = e.detail;

		modalElim.find('.nombre-divpolit').text(self.itemActual.obtenerNombre());
		
		modalElim.modal({ backdrop: 'static', keyboard: false });
	});
}

ListaDivPolit.prototype.agregarItem = function(datos) {
	var item      = new Item(this.templateItem, datos),
		posItem   = this.obtenerPos(item),
		itemDespl = this.obtenerItem(posItem);

	if(itemDespl) {
		this.elem.insertBefore(item.elem, itemDespl.elem);
		this.arrItems.splice(posItem, 0, item);
	}

	else {
		this.elem.appendChild(item.elem);
		this.arrItems.push(item);
	}

	item.establecerNro(posItem + 1);

	var cantItems = this.obtenerCantItems();

	for(let i = posItem + 1; i < cantItems; ++i)
		this.obtenerItem(i).establecerNro(i + 1);

	return item;
};

ListaDivPolit.prototype.obtenerItem = function(pos) {
	return this.arrItems[pos] || null;
};

ListaDivPolit.prototype.obtenerCantItems = function() {
	return this.arrItems.length;
};

ListaDivPolit.prototype.removerItemActual = function() {
	var pos = this.obtenerPos(this.itemActual);

	this.elem.removeChild(this.itemActual.elem);
	this.arrItems.splice(pos, 1);
	
	var cantItems = this.obtenerCantItems();

	for(let i = pos; i < cantItems; ++i)
		this.obtenerItem(i).establecerNro(i + 1);

	return this.itemActual;
};

ListaDivPolit.prototype.obtenerPos = function(item1) {
	var i     = 0,
		item2 = this.obtenerItem(i);

	while(item2 && item1.obtenerNombre() > item2.obtenerNombre())
		item2 = this.obtenerItem(++i);

	return i;
};

ListaDivPolit.prototype.limpiar = function() {
	this.elem.innerHTML = '';
	this.arrItems = new Array();
};

ListaDivPolit.prototype.filtrar = function(txt) {
	var regexp = new RegExp('^' + txt, 'i');

	this.arrItems.forEach(i => regexp.test(i.obtenerNombre()) ? i.elem.classList.remove('d-none') : i.elem.classList.add('d-none'));
};

ListaDivPolit.prototype.cantidadItems = function() {
	return this.arrItems.length;
};


/***************************************************************/
/*                           Contenedor                        */
/***************************************************************/
function ContListaDivPolit(contenedor, tipo) {
	this.elem = contenedor;
	this.tipo = tipo;
	this.inputBusc = contenedor.querySelector('form input');
	
	this.contInf = new Array();
	this.itemSup = null;

	var elemLista = contenedor.getElementsByClassName('lista')[0],
		elemTemp  = contenedor.getElementsByClassName('t_divpolit')[0].content;

	this.lista = new ListaDivPolit(elemLista, elemTemp);
	
	this.msjVacio = contenedor.getElementsByClassName('divpolit_vacio')[0];

	$(contenedor).on('click', '.atras', e => this.accionVolverAtras() );
	$(contenedor).on('click', '.btn-nuevo', e => this.mostrarForm('nuevo') );

	contenedor.addEventListener('divpolit.accion.editar', e => this.mostrarForm('actualizar', e.detail) );
	contenedor.addEventListener('divpolit.accion.descender', e => this.descenderNivel(e.detail) );

	this.inputBusc.addEventListener('input', e => this.lista.filtrar(this.inputBusc.value));
}

ContListaDivPolit.prototype.mostrar = function() {
	$(this.elem).removeClass('d-none');

	_contexto.contenedorActual = this;

	if(this.itemSup)
		this.cambiarTitulo(this.itemSup.obtenerNombre());
};

ContListaDivPolit.prototype.ocultar = function() {
	$(this.elem).addClass('d-none');
};

ContListaDivPolit.prototype.cambiarTitulo = function(nuevoTitulo) {
	$(this.elem).find('header h3 span').text(nuevoTitulo);
};

ContListaDivPolit.prototype.cargarLista = function() {
	var self = this,
		url  = this.obtenerUrlListado();

	if(this.itemSup)
		url += this.itemSup.obtenerId();

	$.ajax(url, {
		success: function(divpolits) {
			if(divpolits.length == 0)
				self.msjVacio.classList.remove('d-none');

			else {
				self.msjVacio.classList.add('d-none');

				for(let divp of divpolits) {
					divp.zoomMapa = 12;
					self.lista.agregarItem(divp);
				}
			}

			if(!_contexto.pilaContenedores.estaVacia())
				_contexto.pilaContenedores.obtenerUltimo().contenedor.ocultar();

			self.mostrar();
		}
	});
};

ContListaDivPolit.prototype.accionVolverAtras = function() {
	if(!_contexto.pilaContenedores.estaVacia()) {
		var configSup = _contexto.pilaContenedores.sacar();

		this.ocultar();
		this.lista.limpiar();
		this.inputBusc.value = '';

		configSup.contenedor.mostrar();

		window.scrollTo(window.scrollX, configSup.scrollY);
	}
};

ContListaDivPolit.prototype.obtenerElemLista = function() {
	return this.elem.getElementsByClassName('lista')[0];
};

ContListaDivPolit.prototype.obtenerTemplateItem = function() {
	return this.elem.getElementsByClassName('t_divpolit')[0].content;
};

ContListaDivPolit.prototype.agregarContInf = function(contenedor) {
	this.contInf.push(contenedor);
};

ContListaDivPolit.prototype.obtenerTipo = function() {
	return this.elem.id;
};

ContListaDivPolit.prototype.obtenerUrlDatos = function() {
	var tipo = this.obtenerTipo(),
		url  = null;

	switch(tipo) {
		case 'departamentos':
		case 'localidades':
		case 'barrios':
		case 'parajes':
		case 'puestos':
			url = '/iiet/entidades/obtener_datos/' + tipo + '/';
		break;

		case 'instit_barrios':
		case 'instit_parajes':
			url = '/iiet/entidades/obtener_datos/instituciones/';
		break;
	}

	return url;
};

ContListaDivPolit.prototype.obtenerUrlListado = function() {
	var tipo = this.obtenerTipo(),
		url  = null;

	switch(tipo) {
		case 'departamentos':
		case 'localidades':
		case 'barrios':
		case 'parajes':
		case 'puestos':
			url = '/iiet/entidades/listado_' + tipo + '/';
		break;

		case 'instit_barrios':
			url = '/iiet/escuelas/listado_escuelas/barrio/';
		break;

		case 'instit_parajes':
			url = '/iiet/escuelas/listado_escuelas/paraje/';
		break;
	}

	return url;
};

ContListaDivPolit.prototype.formExito = function(respuesta) {
	var form = _contexto.formulario,
		p    = document.createElement('p'),
		btn  = document.createElement('button');

	p.className = 'alert alert-success alert-exito';

	btn.type = 'button';
	btn.className = 'close';
	btn.dataset.dismiss = 'alert';
	btn.textContent = '\xd7';

	if(form.modo == 'nuevo')
		p.appendChild(document.createTextNode('Se han cargado correctamente los datos.'));

	else if(form.modo == 'actualizar') {
		p.appendChild(document.createTextNode('Se han actualizado correctamente los datos.'));
		this.lista.removerItemActual();
	}

	p.appendChild(btn);

	$(this.msjVacio).addClass('d-none');

	var self = this;

	$.ajax(this.obtenerUrlDatos() + respuesta.id, {
		dataType: 'json',
		success: function(divpolit) {
			var nuevoItem = self.lista.agregarItem(divpolit);

			document.body.appendChild(p);

			form.reset();

			$('#form-divpolit').modal('hide');

			$('html, body').animate({ scrollTop: $(nuevoItem.elem).offset().top - 5 }, 800);
		}
	});
};

ContListaDivPolit.prototype.descenderNivel = function(datos) {
	var contenedorDestino = this.contInf[datos.posLink];

	_contexto.pilaContenedores.poner(new ConfigContenedor(this));

	contenedorDestino.itemSup = datos.item;
	contenedorDestino.cargarLista();

	window.scrollTo(window.scrollX, 0);
};

ContListaDivPolit.prototype.mostrarForm = function(modo, item) {
	_contexto.formulario.reset();
	_contexto.formulario.cambiarModo(modo);

	if(modo == 'actualizar')
		configModalEditarDivPolit(this.tipo, item.obtenerDatos());

	else
		configModalNuevoDivPolit(this.tipo);

	$('#form-divpolit').modal({
		keyboard: false,
		backdrop: 'static'
	});
};


var departamentos = document.getElementById('departamentos'),
	localidades   = document.getElementById('localidades'),
	barrios       = document.getElementById('barrios'),
	parajes       = document.getElementById('parajes'),
	institBarrio  = document.getElementById('instit_barrios'),
	institParaje  = document.getElementById('instit_parajes'),
	puesto        = document.getElementById('puestos');

var contDepartamentos = new ContListaDivPolit(departamentos, 'departamento'),
	contLocalidades   = new ContListaDivPolit(localidades, 'localidad'),
	contBarrios       = new ContListaDivPolit(barrios, 'barrio'),
	contParajes       = new ContListaDivPolit(parajes, 'paraje'),
	contInstitBarrio  = new ContListaDivPolit(institBarrio, 'instit-barrio'),
	contInstitParaje  = new ContListaDivPolit(institParaje, 'instit-paraje'),
	contPuestos       = new ContListaDivPolit(puestos, 'puesto');


contParajes.agregarContInf(contPuestos);
contParajes.agregarContInf(contInstitParaje);

contBarrios.agregarContInf(contInstitBarrio);

contLocalidades.agregarContInf(contBarrios);
contLocalidades.agregarContInf(contParajes);

contDepartamentos.agregarContInf(contLocalidades);
contDepartamentos.cargarLista();


$('#form-divpolit').on('shown.bs.modal', function(e) {
	var tipo = _contexto.contenedorActual.tipo;

	if(tipo == 'instit-paraje' || tipo == 'instit-barrio')
		_contexto.formulario.activarTipoInstit();

	else
		_contexto.formulario.desactivarTipoInstit();

	_contexto.formulario.enfocar();
	_contexto.formulario.mostrarMapa();
});

function configModalNuevoDivPolit(divpolit) {
	if(divpolit == 'instit-barrio' || divpolit == 'instit-paraje')
		divpolit = 'institucion';

	var capitDivpolit = divpolit.charAt(0).toUpperCase() + divpolit.substring(1);

	switch(divpolit) {
		case 'departamento':
		case 'barrio':
		case 'paraje':
		case 'puesto':
			$('#form-divpolit .modal-header h4').text('Nuevo ' + capitDivpolit);
		break;
		
		case 'localidad':
		case 'institucion':
			$('#form-divpolit .modal-header h4').text('Nueva ' + capitDivpolit);
		break;
	}

	var divSup = null,
		idSup  = null;

	if(_contexto.contenedorActual.itemSup) {
		divSup = _contexto.pilaContenedores.obtenerUltimo().contenedor.tipo;
		idSup  = _contexto.contenedorActual.itemSup.obtenerId();
	}

	_contexto.formulario.cargarIdSup(divSup, idSup);
}

function configModalEditarDivPolit(divpolit, datos) {
	if(divpolit == 'instit-barrio' || divpolit == 'instit-paraje')
		divpolit = 'institucion';

	var capitDivpolit = divpolit.charAt(0).toUpperCase() + divpolit.substring(1);

	$('#form-divpolit .modal-header h4').text('Actualizar ' + capitDivpolit);

	var divSup = null;

	if(!_contexto.pilaContenedores.estaVacia())
		divSup = _contexto.pilaContenedores.obtenerUltimo().contenedor.tipo;

	_contexto.formulario.cargarDatos(divSup, datos);
}


/***************************************************************/
/*                          Formulario                         */
/***************************************************************/
function FormDivPolit() {
	this.elem = document.querySelector('#form-divpolit form');
	this.modo = 'nuevo';
	this.inputIdSup = document.getElementById('input-id-sup');
	this.mapa = null;
	this.txtNoResult = document.getElementById('txt-no-result-busq');
	this.coordMapa = null;

	this.filtroBusqueda = 'salta,argentina';

	$(this.elem).on('click', '.btn-buscar', e => this.buscarLugar() );

	var self = this;

	this.elem.addEventListener('submit', function(e) {
		e.preventDefault();

		$.ajax('/iiet/entidades/cargar_divpolit/' + _contexto.contenedorActual.obtenerTipo(), {
			dataType: 'json',
			method: 'POST',
			data: $(self.elem).serialize(),
			success: resp => _contexto.contenedorActual.formExito(resp)
		});
	});
}

FormDivPolit.prototype.cambiarModo = function(nuevoModo) {
	this.modo = nuevoModo;

	if(nuevoModo == 'actualizar') {
		this.elem.enviar.value = 'Actualizar';
		this.elem.numero.disabled = null;
	}

	else {
		this.elem.enviar.value = 'Crear';
		this.elem.numero.disabled = 'disabled';
	}
};

FormDivPolit.prototype.enfocar = function() {
	this.elem.nombre.focus();
};

FormDivPolit.prototype.activarTipoInstit = function() {
	var cont = this.elem.querySelector('#g-tipo-instit'),
		select = cont.children[0].children[1];

	cont.classList.remove('d-none');
	select.disabled = null;
};

FormDivPolit.prototype.desactivarTipoInstit = function() {
	var cont = this.elem.querySelector('#g-tipo-instit'),
		select = cont.children[0].children[1];

	cont.classList.add('d-none');
	select.disabled = 'disabled';
};

FormDivPolit.prototype.buscarLugar = function() {
	var self   = this,
		nombre = this.elem.nombre.value,
		filtro = _contexto.generarJerarquia() + this.filtroBusqueda;

	$.ajax('https://nominatim.openstreetmap.org/search?q=' + nombre + ',' + filtro + '&format=json', {
		dataType: 'json',
		success: function(respuesta) {
			var ciudad = FormDivPolit.obtenerCiudad(respuesta);

			if(ciudad) 
				self.mostrarMapa([ciudad.lon, ciudad.lat]);

			else {
				$(self.txtNoResult).removeClass('d-none');
				self.mapa.desmarcar();

				window.setTimeout(() => $(self.txtNoResult).addClass('d-none'), 5000);
			}
		}
	});
};

FormDivPolit.prototype.marcarMapa = function(coord) {
	if(coord) {
		this.mapa.desmarcar();
		this.mapa.marcar(coord);

		this.elem.longitud.value = coord[0];
		this.elem.latitud.value  = coord[1];
	}
};

FormDivPolit.prototype.cargarIdSup = function(divSup, id) {
	if(divSup) {
		this.inputIdSup.name = divSup;
		this.inputIdSup.value = id;
	}

	else {
		this.inputIdSup.name = '';
		this.inputIdSup.value = null;
	}
};

FormDivPolit.prototype.cargarDatos = function(divSup, datos) {
	this.elem.numero.value   = datos.numero;
	this.elem.nombre.value   = datos.nombre;
	this.elem.latitud.value  = datos.latitud || '';
	this.elem.longitud.value = datos.longitud || '';

	if(datos.tipo)
		this.elem.tipo.value = datos.tipo;

	this.cargarIdSup(divSup, datos[divSup]);

	this.coordMapa = datos.latitud ? [datos.longitud, datos.latitud] : null;
};

FormDivPolit.prototype.mostrarMapa = function(coord) {
	var tipo = _contexto.contenedorActual.tipo,
		zoom = _contexto.zoomMapaForm[tipo],
		coordAux = coord || this.coordMapa;

	if(!coordAux) {
		let datosMapa = obtenerDatosMapa();

		coordAux = datosMapa.coord;
		zoom = datosMapa.zoom;
	}

	if(this.mapa === null) {
		this.mapa = new Mapa(document.getElementById('form-mapa'), coordAux, zoom);
		this.mapa.on('singleclick', e => this.marcarMapa(e.coordinate));
	}

	else {
		this.mapa.desmarcar();
		this.mapa.centrarEn(coordAux);
		this.mapa.zoom(zoom);
	}

	if(coord || this.coordMapa)
		this.marcarMapa(coordAux);
};

FormDivPolit.prototype.reset = function() {
	this.elem.reset();
	this.coordMapa = null;

	if(this.mapa)
		this.mapa.desmarcar();
};

FormDivPolit.obtenerCiudad = function(lista) {
	for(let i = 0; i < lista.length; ++i)
		if(lista[i].osm_type === 'node')
			return lista[i];

	return null;
};

function obtenerDatosMapa() {
	var tam = _contexto.pilaContenedores.tamanio(),
		datosMapa = null;

	if(_contexto.contenedorActual.itemSup) {
		var contenActual = _contexto.contenedorActual,
			datos = contenActual.itemSup.obtenerDatos();

		if(datos.latitud) {
			datosMapa = {
				coord: [datos.longitud, datos.latitud],
				zoom: _contexto.zoomMapaForm[contenActual.tipo]
			};
		}

		else {
			for(let i = tam - 1; i > 0; --i) {
				let contenedor = _contexto.pilaContenedores.obtener(i).contenedor,
					datos = contenedor.itemSup.obtenerDatos();

				if(datos.latitud) {
					datosMapa = {
						coord: [datos.longitud, datos.latitud],
						zoom: _contexto.zoomMapaForm[contenedor.tipo]
					};
				}
			}
		}
	}

	return datosMapa || { coord: [-65.3818, -24.1573], zoom: 7 };
}


var _contexto = {
	pilaContenedores: new Pila(),
	formulario: new FormDivPolit(),
	contenedorActual: null,
	zoomMapaForm: {
		'departamento': 7,
		'localidad': 9,
		'barrio': 14,
		'paraje': 14,
		'puesto': 16,
		'instit-barrio': 16,
		'instit-paraje': 16
	},
	elimDivPolit: {
		modal: $('#modal-eliminar'),
		alertExito: document.getElementById('alerta-exito'),
		tAlertExito: document.getElementById('t-alerta-exito').content,
		alertError: document.getElementById('alerta-error'),
		tAlert: document.getElementById('t-alerta-error').content
	},
	generarJerarquia: function() {
		var str1 = new Array(),
			str2 = '';

		if(this.contenedorActual.itemSup) {
			str2 = this.contenedorActual.itemSup.obtenerNombre();

			var tam = this.pilaContenedores.tamanio();

			for(let i = 1; i < tam; ++i) {
				let contenedor = this.pilaContenedores.obtener(i).contenedor;

				str1.push(contenedor.itemSup.obtenerNombre());
			}

			str1.push(str2);

			return encodeURIComponent(str1.reverse().join(',') + ',');
		}

		return '';
	}
};

_contexto.elimDivPolit.modal.on('click', '#btn-eliminar-divpolit', function(e) {
	var tipo = _contexto.contenedorActual.tipo,
		lista = _contexto.contenedorActual.lista,
		id   = lista.itemActual.obtenerId();

	if(tipo == 'instit-barrio' || tipo == 'instit-paraje')
		tipo = 'institucion';

	$.ajax('/iiet/entidades/tiene_dependencias/' + tipo + '/' + id, {
		dataType: 'json',
		success: function(resp) {
			if(resp === false)
				$.ajax('/iiet/entidades/eliminar/' + tipo + '/' + id, {
					success: function(e) {
						_contexto.elimDivPolit.modal.modal('hide');
						_contexto.elimDivPolit.alertExito.appendChild(document.importNode(_contexto.elimDivPolit.tAlertExito, true));

						lista.removerItemActual();

						if(lista.cantidadItems() === 0)
							_contexto.contenedorActual.msjVacio.classList.remove('d-none');
					}
				});

			else
				_contexto.elimDivPolit.alertError.appendChild(document.importNode(_contexto.elimDivPolit.tAlert, true));
		}
	});
});


var listDptos = departamentos.querySelector('.lista');
$('.divpolit_vacio').height(window.innerHeight - $(listDptos).offset().top - 60);

})();