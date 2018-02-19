var nav = document.getElementById('nav');

var listDpto = document.getElementById('lista_departamentos'),
	listLocalidades = document.getElementById('lista_localidades'),
	listBarrios = document.getElementById('lista_barrios'),
	listParajes = document.getElementById('lista_parajes'),
	listPuestos = document.getElementById('lista_puestos'),
	listEscuelas = document.getElementById('lista_escuelas');

var vm = document.getElementById('v_modales'),
	formDpto = formNuevoDepartamento(vm),
	formLocalidad = formNuevaLocalidad(vm),
	formBarrio = formNuevoBarrio(vm),
	formParaje = formNuevoParaje(vm),
	formPuesto = formNuevoPuesto(vm),
	formEscuela = formNuevaEscuela(vm);

var seccionLocalidades = document.getElementById('localidades'),
	seccionBarrios = document.getElementById('barrios'),
	seccionParajes = document.getElementById('parajes'),
	seccionPuestos = document.getElementById('puestos'),
	seccionEscuelas = document.getElementById('escuelas');

var nuevoDpto = document.getElementById('nuevo_dpto'),
	nuevaLocalidad = document.getElementById('nueva_localidad'),
	nuevoBarrio = document.getElementById('nuevo_barrio'),
	nuevoParaje = document.getElementById('nuevo_paraje'),
	nuevoPuesto = document.getElementById('nuevo_puesto'),
	nuevaEscuela = document.getElementById('nueva_escuela');

var dptoActual, localidadActual, barrioActual, parajeActual;

Utils.ajax('/iiet/entidades/listado_departamentos', [], listarDptos);

var inicio = nuevoEnlace('Inicio', 'departamentos');
inicio.indice = 0;
nav.appendChild(inicio);

function listarDptos(e) {
	var respuesta = e.target.response;

	listDpto.innerHTML = '';

	if(respuesta.length === 0) {
		let item = document.createElement('li');

		listDpto.appendChild(item);
		item.textContent = 'No se han creado departamentos.';
	}

	else {
		for(let datosDpto of respuesta) {
			let item = document.createElement('li');

			listDpto.appendChild(item);
			departamento(item, datosDpto);
		}

		var editarDpto = document.getElementsByClassName('editar_dpto'),
			irLocalidades = document.getElementsByClassName('ir_localidades');

		for(let enlace of editarDpto)
			enlace.addEventListener('click', e => prepararEdicionDivPolit(
				e.target.parentNode, formDpto, 'Editar Departamento'));

		for(let enlace of irLocalidades)
			enlace.addEventListener('click', verLocalidades);
	}

	nuevoDpto.addEventListener('click', e => prepararCreacionDivPolit(formDpto, 'Nuevo Departamento'));
}

function verLocalidades(e) {
	var padre, datos, titulo, item;

	padre = e.target.parentNode.parentNode;
	dptoActual = padre.children[0].children[1].textContent;
	nombreDepartamento = padre.children[1].children[1].textContent;
	formLocalidad.departamento.value = dptoActual;

	datos = new Map([ ['departamento', dptoActual] ]);

	Utils.ajax('/iiet/entidades/listado_localidades', datos, listarLocalidades);

	//titulo = seccionLocalidades.querySelector('header > h1');
	//titulo.textContent = 'Localidades de ' + nombreDepartamento;

	item = nuevoEnlace(nombreDepartamento, 'localidades');
	item.indice = 1;
	nav.appendChild(item);
}

function listarLocalidades(e) {
	var respuesta = e.target.response;

	listLocalidades.innerHTML = '';

	if(respuesta.length === 0) {
		let item = document.createElement('li'),
			boxMsj = document.createElement('span');

		boxMsj.textContent = 'No se han creado localidades.';
		item.appendChild(boxMsj);
		item.className = 'msj_vacio';

		listLocalidades.appendChild(item);
	}

	else {
		for(let datosLocalidad of respuesta) {
			let item = document.createElement('li');

			listLocalidades.appendChild(item);
			localidad(item, datosLocalidad);
		}

		var editarLocalidad = document.getElementsByClassName('editar_localidad'),
			irBarrios = document.getElementsByClassName('ir_barrios'),
			irParajes = document.getElementsByClassName('ir_parajes');

		for(let enlace of editarLocalidad)
			enlace.addEventListener('click', e => prepararEdicionDivPolit(
				e.target.parentNode, formLocalidad, 'Editar Localidad'));

		for(let enlace of irBarrios)
			enlace.addEventListener('click', verBarrios);

		for(let enlace of irParajes)
			enlace.addEventListener('click', verParajes);
	}

	nuevaLocalidad.addEventListener('click', e => prepararCreacionDivPolit(formLocalidad, 'Nueva Localidad'));
}

function verBarrios(e) {
	var padre, datos, titulo;

	padre = e.target.parentNode.parentNode;
	localidadActual = padre.children[0].children[1].textContent;
	nombreLocalidad = padre.children[1].children[1].textContent;
	formBarrio.localidad.value = localidadActual;

	datos = new Map([ ['localidad', localidadActual] ]);

	Utils.ajax('/iiet/entidades/listado_barrios', datos, listarBarrios);

	//titulo = seccionBarrios.querySelector('header > h1');
	//titulo.textContent = 'Barrios de ' + nombreLocalidad;

	item = nuevoEnlace(nombreLocalidad, 'barrios');
	item.indice = 2;
	nav.appendChild(item);
}

function listarBarrios(e) {
	var respuesta = e.target.response;

	listBarrios.innerHTML = '';

	if(respuesta.length === 0) {
		let item = document.createElement('li'),
			boxMsj = document.createElement('span');

		boxMsj.textContent = 'No se han creado barrios.';
		item.appendChild(boxMsj);
		item.className = 'msj_vacio';

		listBarrios.appendChild(item);
	}

	else {
		for(let datosBarrio of respuesta) {
			let item = document.createElement('li');

			listBarrios.appendChild(item);
			crearItemBarrio(item, datosBarrio);
		}

		var editarBarrio = document.getElementsByClassName('editar_barrio'),
			irEscuelas = document.getElementsByClassName('ir_escuelas');

		for(let enlace of editarBarrio)
			enlace.addEventListener('click', e => prepararEdicionDivPolit(
				e.target.parentNode, formBarrio, 'Editar Barrio'));

		for(let enlace of irEscuelas)
			enlace.addEventListener('click', e => verEscuelas(e, 'barrio'));
	}

	nuevoBarrio.addEventListener('click', e => prepararCreacionDivPolit(formBarrio, 'Nuevo Barrio'));
}

function verParajes(e) {
	var padre, datos, titulo;

	padre = e.target.parentNode.parentNode;
	localidadActual = padre.children[0].children[1].textContent;
	nombreLocalidad = padre.children[1].children[1].textContent;
	formParaje.localidad.value = localidadActual;

	datos = new Map([ ['localidad', localidadActual] ]);

	Utils.ajax('/iiet/entidades/listado_parajes', datos, listarParajes);

	//titulo = seccionParajes.querySelector('header > h1');
	//titulo.textContent = 'Parajes de ' + nombreLocalidad;

	item = nuevoEnlace(nombreLocalidad, 'parajes');
	item.indice = 2;
	nav.appendChild(item);
}

function listarParajes(e) {
	var respuesta = e.target.response;

	listParajes.innerHTML = '';

	if(respuesta.length === 0) {
		let item = document.createElement('li'),
			boxMsj = document.createElement('span');

		boxMsj.textContent = 'No se han creado parajes.';
		item.appendChild(boxMsj);
		item.className = 'msj_vacio';

		listParajes.appendChild(item);
	}

	else {
		for(let datosParaje of respuesta) {
			let item = document.createElement('li');

			listParajes.appendChild(item);
			crearItemParaje(item, datosParaje);
		}

		var editarParaje = document.getElementsByClassName('editar_paraje'),
			irPuestos = document.getElementsByClassName('ir_puestos'),
			irEscuelas = document.getElementsByClassName('ir_escuelas');

		for(let enlace of editarParaje)
			enlace.addEventListener('click', e => prepararEdicionDivPolit(
				e.target.parentNode, formParaje, 'Editar Paraje'));

		for(let enlace of irPuestos)
			enlace.addEventListener('click', verPuestos);

		for(let enlace of irEscuelas)
			enlace.addEventListener('click', e => verEscuelas(e, 'paraje'));
	}

	nuevoParaje.addEventListener('click', e => prepararCreacionDivPolit(formParaje, 'Nuevo Paraje'));
}

function verPuestos(e) {
	var padre, datos, titulo;

	padre = e.target.parentNode.parentNode;
	parajeActual = padre.children[0].children[1].textContent;
	nombreParaje = padre.children[1].children[1].textContent;
	formPuesto.paraje.value = parajeActual;

	datos = new Map([ ['paraje', parajeActual] ]);

	Utils.ajax('/iiet/entidades/listado_puestos', datos, listarPuestos);

	//titulo = seccionPuestos.querySelector('header > h1');
	//titulo.textContent = 'Puestos de ' + nombreParaje;

	item = nuevoEnlace(nombreParaje, 'parajes');
	item.indice = 3;
	nav.appendChild(item);
}

function listarPuestos(e) {
	var respuesta = e.target.response;

	listPuestos.innerHTML = '';

	if(respuesta.length === 0) {
		let item = document.createElement('li'),
			boxMsj = document.createElement('span');

		boxMsj.textContent = 'No se han creado puestos.';
		item.appendChild(boxMsj);
		item.className = 'msj_vacio';

		listPuestos.appendChild(item);
	}

	else {
		for(let datosPuesto of respuesta) {
			let item = document.createElement('li');

			listPuestos.appendChild(item);
			crearItemPuesto(item, datosPuesto);
		}

		var editarPuesto = document.getElementsByClassName('editar_puesto');

		for(let enlace of editarPuesto)
			enlace.addEventListener('click', e => prepararEdicionDivPolit(
				e.target.parentNode, formPuesto, 'Editar Puesto'));

		//for(let enlace of irBarrios)
		//	enlace.addEventListener('click', verBarrios);
	}

	nuevoPuesto.addEventListener('click', e => prepararCreacionDivPolit(formPuesto, 'Nuevo Puesto'));
}

function verEscuelas(e, pertenece) {
	var padre, datos, titulo, entidadSup, nombreEntidadSup;

	padre = e.target.parentNode.parentNode;
	entidadSup = padre.children[0].children[1].textContent;
	nombreEntidadSup = padre.children[1].children[1].textContent;

	if(pertenece == 'paraje') {
		parajeActual = entidadSup;
		formEscuela.barrio.disabled = 'disabled';
	}

	else {
		barrioActual = entidadSup;
		formEscuela.paraje.disabled = 'disabled';
	}

	formEscuela.lugar.value = pertenece;
	formEscuela[pertenece].value = entidadSup;
	formEscuela[pertenece].disabled = '';

	datos = new Map([ [pertenece, entidadSup] ]);

	Utils.ajax('/iiet/escuelas/listado_escuelas', datos, listarEscuelas);

	//titulo = seccionPuestos.querySelector('header > h1');
	//titulo.textContent = 'Escuelas de ' + nombreEntidadSup;

	item = nuevoEnlace(nombreEntidadSup, pertenece + 's');
	item.indice = 3;
	nav.appendChild(item);
}

function listarEscuelas(e) {
	var respuesta = e.target.response;

	listEscuelas.innerHTML = '';

	if(respuesta.length === 0) {
		let item = document.createElement('li'),
			boxMsj = document.createElement('span');

		boxMsj.textContent = 'No se han creado escuelas.';
		item.appendChild(boxMsj);
		item.className = 'msj_vacio';

		listEscuelas.appendChild(item);
	}

	else {
		for(let datosEscuelas of respuesta) {
			let item = document.createElement('li');

			listEscuelas.appendChild(item);
			crearItemEscuela(item, datosEscuelas);
		}

		var editarEscuela = document.getElementsByClassName('editar_escuela');

		for(let enlace of editarEscuela)
			enlace.addEventListener('click', e => prepararEdicionDivPolit(
				e.target.parentNode, formEscuela, 'Editar Escuela'));
	}

	nuevaEscuela.addEventListener('click', e => prepararCreacionDivPolit(formEscuela, 'Nueva Escuela'));
}

function prepararEdicionDivPolit(contenedor, form, titulo) {
	form.vm.establecerTitulo(titulo);

	form.numero.value = contenedor.children[0].children[1].textContent;
	form.numero.disabled = '';
	form.nombre.value = contenedor.children[1].children[1].textContent;
	form.latitud.value = Utils.soloNumeros(contenedor.children[2].children[1].textContent);
	form.longitud.value = Utils.soloNumeros(contenedor.children[3].children[1].textContent);
}

function prepararCreacionDivPolit(form, titulo) {
	form.vm.establecerTitulo(titulo);
	form.numero.disabled = 'disabled';
}

function nuevoEnlace(texto, direccion) {
	var item = document.createElement('li'),
		span = document.createElement('span'),
		link = document.createElement('a');

	span.textContent = '>';
	link.textContent = texto;
	link.href = '#' + direccion;

	item.appendChild(span);
	item.appendChild(link);

	link.addEventListener('click', e => {
		var padre, cantidad;

		padre = e.target.parentNode;
		cantidad = nav.children.length;

		for(let i = cantidad - 1; i > padre.indice; --i)
			nav.removeChild(nav.children[i]);

		primerPlanoEntidad(e);
	});

	return item;
}

formDpto.fcExito = e => {
	Utils.ajax('/iiet/entidades/listado_departamentos', [], listarDptos);
	respFormDepartamento(e);
};

formLocalidad.fcExito = e => {
	var datos = new Map([ ['departamento', dptoActual] ]);

	Utils.ajax('/iiet/entidades/listado_localidades', datos, listarLocalidades);
	respFormLocalidad(e);
};

formBarrio.fcExito = function(e) {
	var datos = new Map([ ['localidad', localidadActual] ]);

	Utils.ajax('/iiet/entidades/listado_barrios', datos, listarBarrios);
	respFormBarrio(e);
};

formParaje.fcExito = function(e) {
	var datos = new Map([ ['localidad', localidadActual] ]);

	Utils.ajax('/iiet/entidades/listado_parajes', datos, listarParajes);
	respFormParaje(e);
};

formPuesto.fcExito = function(e) {
	var datos = new Map([ ['paraje', parajeActual] ]);

	Utils.ajax('/iiet/entidades/listado_puestos', datos, listarPuestos);
	respFormPuesto(e);
};

formEscuela.fcExito = function(e) {
	var lugar = formEscuela.lugar.value,
		datos;

	if(lugar == 'barrio') {
		datos = new Map([ ['barrio', barrioActual] ]);
		Utils.ajax('/iiet/escuelas/listado_escuelas', datos, listarEscuelas);
	}

	else {
		datos = new Map([ ['paraje', parajeActual] ]);
		Utils.ajax('/iiet/escuelas/listado_escuelas', datos, listarEscuelas);
	}

	respFormEscuela(e);
};