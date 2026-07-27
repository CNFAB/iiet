window.location.hash = '';

var gMsjEstado = new ObjMensajeEstado();


function Item(template, datos, zoomMapa) {
	document.body.appendChild(document.importNode(template, true));

	this.elem       = document.body.lastElementChild;
	this.datos      = datos;
	this.mapa       = null;
	this.links      = this.elem.getElementsByClassName('links');
	this.linkActivo = -1;
	this.btnEditar  = this.elem.getElementsByClassName('editar')[0];

	this.nro = this.elem.getElementsByClassName('nro_divpolit')[0];
	this.nombre = this.elem.getElementsByClassName('nombre_divpolit')[0].firstElementChild;

	this.establecerNombre(datos.nombre);

	var divMapa = this.elem.getElementsByClassName('map')[0];

	if(datos.latitud) {
		var coord = [datos.longitud, datos.latitud];

		this.mapa  = new Mapa(divMapa, coord, zoomMapa);
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


function ListaDivPolit(contenedor, zoomMapa) {
	this.contenedor    = contenedor;
	this.elem          = contenedor.obtenerElemLista();
	this.templateItem  = contenedor.obtenerTemplateItem();
	this.arrItems      = new Array();
	this.accionesLinks = new Array();
	this.zoomMapa      = zoomMapa;
	this.posItemSelec  = -1;
}

ListaDivPolit.prototype.agregarItem = function(datos) {
	var item      = new Item(this.templateItem, datos, this.zoomMapa),
		posItem   = this.obtenerPos(item),
		itemDespl = this.obtenerItem(posItem),
		self      = this;

	if(itemDespl) {
		this.elem.insertBefore(item.elem, itemDespl.elem);
		this.arrItems.splice(posItem, 0, item);
	}

	else {
		this.elem.appendChild(item.elem);
		this.arrItems.push(item);
	}

	item.establecerNro(posItem + 1);

	item.btnEditar.addEventListener('click', e => {
		self.posItemSelec = posItem;
		self.contenedor.mostrarFormEditar(datos);
	});

	var cantItems = this.obtenerCantItems();

	for(let i = posItem + 1; i < cantItems; ++i)
		this.obtenerItem(i).establecerNro(i + 1);

	var ordInf = this.contenedor.contInf;

	for(let i = 0; i < ordInf.length; ++i)
		item.links[i].addEventListener('click', e => {
			self.posItemSelec = posItem;
			item.linkActivo   = i;
			
			self.contenedor.descenderNivel(i);
		});

	return item;
};

ListaDivPolit.prototype.obtenerItem = function(pos) {
	return this.arrItems[pos] || null;
};

ListaDivPolit.prototype.obtenerCantItems = function() {
	return this.arrItems.length;
};

ListaDivPolit.prototype.actualizarItem = function(pos, datos) {
	var item = this.obtenerItem(pos);

	item.establecerNro(datos.numero);
	item.establecerNombre(datos.nombre);

	if(datos.longitud)
		item.establecerCoordMapa([datos.longitud, datos.latitud]);
};

ListaDivPolit.prototype.removerItem = function(pos) {
	var item = this.obtenerItem(pos);

	this.elem.removeChild(item.elem);
	this.arrItems.splice(pos, 1);
	
	var cantItems = this.obtenerCantItems();

	for(let i = pos; i < cantItems; ++i)
		this.obtenerItem(i).establecerNro(i + 1);

	return item;
};

ListaDivPolit.prototype.obtenerPos = function(item) {
	var i    = 0,
		iAct = this.obtenerItem(i);

	while(iAct && item.obtenerNombre() > iAct.obtenerNombre()) {
		++i;
		iAct = this.obtenerItem(i);
	}

	return i;
};

ListaDivPolit.prototype.limpiar = function() {
	this.elem.innerHTML = '';
	this.arrItems = new Array();
};



function ContListaDivPolit(contenedor, form, zoomMapa) {
	this.elem            = contenedor;
	this.form            = form;
	this.btnNuevo        = contenedor.getElementsByClassName('nuevo')[0];
	this.btnAtras        = contenedor.getElementsByClassName('atras')[0];
	this.contSup         = null;
	this.contInf         = new Array();
	this.itemDivPolitSup = null;
	this.posItemSelec    = null;
	this.zoomMapa        = zoomMapa;
	this.lista           = new ListaDivPolit(this, zoomMapa);
	this.msjVacio        = contenedor.getElementsByClassName('divpolit_vacio')[0];
	this.scrollY         = 0;

	this.btnNuevo.addEventListener('click', e => this.mostrarFormNuevo());

	if(this.btnAtras)
		this.btnAtras.addEventListener('click', e => this.accionVolverAtras());

	form.fcExito = e => this.formExito(e.target.response);
}

ContListaDivPolit.prototype.mostrar = function() {
	this.elem.className = '';

	if(this.itemDivPolitSup)
		this.editarTitulo(this.itemDivPolitSup.obtenerNombre());

	window.scrollTo(window.scrollX, 0);
};

ContListaDivPolit.prototype.ocultar = function() {
	this.elem.className = 'oculto';
};

ContListaDivPolit.prototype.editarTitulo = function(nuevoTit) {
	this.elem.children[0].children[0].textContent = nuevoTit;
};

ContListaDivPolit.prototype.cargarLista = function() {
	var self = this,
		url  = this.obtenerUrlListado();

	if(this.itemDivPolitSup)
		url += this.itemDivPolitSup.obtenerId();

	Utils.ajax(
		url,
		[],
		function(e) {
			var departamentos = e.target.response;

			if(departamentos.length == 0)
				self.msjVacio.className = self.msjVacio.className.replace(/(?:^|\s)oculto(?!\S)/g , '');

			else {
				self.msjVacio.className += ' oculto';
				for(let dpto of departamentos) {
					dpto.zoomMapa = 12;
					self.lista.agregarItem(dpto);
				}
			}

			if(self.contSup)
				self.contSup.ocultar();

			self.mostrar();
		}
	);
};

ContListaDivPolit.prototype.obtenerBtnNuevo = function() {
	return this.btnNuevo;
};

ContListaDivPolit.prototype.accionVolverAtras = function() {
	if(this.contSup) {
		this.ocultar();
		this.lista.limpiar();
		this.contSup.mostrar();

		window.scrollTo(window.scrollX, this.contSup.scrollY);
	}
};

ContListaDivPolit.prototype.obtenerElemLista = function() {
	return this.elem.getElementsByClassName('lista')[0];
};

ContListaDivPolit.prototype.obtenerTemplateItem = function() {
	return this.elem.getElementsByClassName('t_divpolit')[0].content;
};

ContListaDivPolit.prototype.establecerContSup = function(contSup) {
	this.contSup = contSup;
};

ContListaDivPolit.prototype.agregarContInf = function(contenedor) {
	this.contInf.push(contenedor);
};

ContListaDivPolit.prototype.mostrarFormNuevo = function() {
	this.form.fijarModo(this.form.NUEVO);

	window.location.hash = this.form.vm.id;
};

ContListaDivPolit.prototype.mostrarFormEditar = function(datos) {
	this.form.fijarModo(this.form.ACTUALIZAR);
	this.form.cargarDatos(datos);

	window.location.hash = this.form.vm.id;
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

ContListaDivPolit.prototype.obtenerFiltro = function() {
	var contenedor = this,
		filtro = '';

	while(contenedor && contenedor.itemDivPolitSup) {
		filtro += contenedor.itemDivPolitSup.obtenerNombre() + ',';
		contenedor = contenedor.contSup;
	}

	return filtro == '' ? filtro : filtro.substring(0, filtro.length - 1);
};

ContListaDivPolit.prototype.formExito = function(respuesta) {
	var form = this.form;

	if(form.modo == form.NUEVO)
		gMsjEstado.establecerTexto1('Se han cargado correctamente los datos.');

	else if(form.modo == form.ACTUALIZAR) {
		gMsjEstado.establecerTexto1('Se han actualizado correctamente los datos.');
		this.lista.removerItem(this.lista.posItemSelec);
	}

	var self = this;

	Utils.ajax(
		this.obtenerUrlDatos() + respuesta.id,
		[],
		e => {
			var divPolit = e.target.response,
				nuevoItem = self.lista.agregarItem(divPolit);

			gMsjEstado.establecerTexto2('');
			gMsjEstado.mostrar(ObjMensajeEstado.EXITO);

			form.mapa.desmarcar();
			form.prepararMapa([-65.3818, -24.1573], self.zoomMapa);

			form.vm.close();

			window.setTimeout(function() {
				var topNuevoItem = nuevoItem.elem.getBoundingClientRect()['top'];
				
				window.scrollTo(0, topNuevoItem - 5);
			}, 80);
		}
	);
};

ContListaDivPolit.prototype.descenderNivel = function(i) {
	var contListaDestino = this.contInf[i];

	this.scrollY = window.scrollY;

	contListaDestino.preparar();
	contListaDestino.cargarLista();
};

ContListaDivPolit.prototype.preparar = function() {
	var listaSup = this.contSup.lista,
		item     = listaSup.obtenerItem(listaSup.posItemSelec);

	this.itemDivPolitSup = item;
	this.form.establecerFiltroBusqueda(this.obtenerFiltro());

	this.form.cargarIdDivPolitSup(item.obtenerId());

	if(item.datos.longitud) {
		var coord = [item.datos.longitud, item.datos.latitud];
		this.form.prepararMapa(coord, this.contSup.zoomMapa);
	}
};


var contenedorVM = document.getElementById('contenedor_vm');

var formDeparamento = formNuevoDepartamento(contenedorVM),
	formLocalidad   = formNuevaLocalidad(contenedorVM),
	formBarrio      = formNuevoBarrio(contenedorVM),
	formParaje      = formNuevoParaje(contenedorVM),
	formInstitucion = formNuevaEscuela(contenedorVM),
	formPuesto      = formNuevoPuesto(contenedorVM);

var departamentos = document.getElementById('departamentos'),
	localidades   = document.getElementById('localidades'),
	barrios       = document.getElementById('barrios'),
	parajes       = document.getElementById('parajes'),
	institBarrio  = document.getElementById('instit_barrios'),
	institParaje  = document.getElementById('instit_parajes'),
	puesto        = document.getElementById('puestos');

var contDepartamentos = new ContListaDivPolit(departamentos, formDeparamento, Mapa.ZOOM_PROVINCIA),
	contLocalidades   = new ContListaDivPolit(localidades, formLocalidad, Mapa.ZOOM_DEPARTAMENTO),
	contBarrios       = new ContListaDivPolit(barrios, formBarrio, Mapa.ZOOM_LOCALIDAD),
	contParajes       = new ContListaDivPolit(parajes, formParaje, Mapa.ZOOM_LOCALIDAD),
	contInstitBarrio  = new ContListaDivPolit(institBarrio, formInstitucion, Mapa.ZOOM_BARRIO),
	contInstitParaje  = new ContListaDivPolit(institParaje, formInstitucion, Mapa.ZOOM_PARAJE),
	contPuestos       = new ContListaDivPolit(puestos, formPuesto, Mapa.ZOOM_PARAJE);


contPuestos.establecerContSup(contParajes);

contInstitBarrio.establecerContSup(contBarrios);
contInstitParaje.establecerContSup(contParajes);

contParajes.establecerContSup(contLocalidades);
contParajes.agregarContInf(contPuestos);
contParajes.agregarContInf(contInstitParaje);

contBarrios.establecerContSup(contLocalidades);
contBarrios.agregarContInf(contInstitBarrio);

contLocalidades.establecerContSup(contDepartamentos);
contLocalidades.agregarContInf(contBarrios);
contLocalidades.agregarContInf(contParajes);

contDepartamentos.agregarContInf(contLocalidades);
contDepartamentos.cargarLista();