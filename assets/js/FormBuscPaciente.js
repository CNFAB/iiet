/**
 * Clase encargada de solcitar a través de AJAX los pacientes que coincidan
 * con el criterio de búsqueda proporcionado por el usuario. Dichos pacientes
 * son mostrados a través de una lista desplegable donde el usuario es capaz
 * de seleccionar uno.
 * 
 * @class FormBuscPaciente
 * @constructor
 * @param {HTMLFormElement} form elemento HTML form.
 */
function FormBuscPaciente(form) {
	/**
	 * @property {HTMLInputElement} input caja de búsqueda.
	 */
	this.input;

	/**
	 * @property {HTMLSpanElement} dniPaciente etiqueta ubicada en el lado derecho de
	 *                                         la caja de búsqueda que muestra el DNI
	 *                                         del paciente seleccionado.
	 */
	this.dniPaciente;

	/**
	 * @property {HTMLUListElement} listaPacientes lista de los pacientes que coinciden
	 *                                             con el criterio de búsqueda.
	 */
	this.listaPacientes;

	/**
	 * @property {HTMLLIElement} itemActivo ítem seleccionado de la lista de pacientes.
	 */
	this.itemActivo;

	/**
	 * @property {String} entradaActual texto de la caja de búsqueda correspondiente al
	 *                                  apellido y nombre del paciente seleccionado.
	 */
	this.entradaActual;

	/**
	 * @property {HTMLButtonElement} btnVerDatos botón que al ser presionado lanza el
	 *                                           evento 'buscpac.mostrar' con los datos
	 *                                           del paciente actual.
	 */
	this.btnVerDatos;

	/**
	 * @property {HTMLButtonElement} btnCrearPaciente botón que al ser presionado lanza
	 *                                                el evento 'buscpac.nuevo'. El botón
	 *                                                solo es visible cuando el criterio
	 *                                                de búsqueda no arroja resultados.
	 */
	this.btnCrearPaciente;

	/**
	 * @property {Object} paciente datos del paciente actual.
	 */
	this.paciente;

	this._iniciar(form);
}

/**
 * Establece los valores de las propiedades y los eventos necesarios para el correcto
 * funcionamiento del objeto.
 * 
 * @method _iniciar
 * @private
 * @param {HTMLFormElement} form elemento HTML form.
 */
FormBuscPaciente.prototype._iniciar = function(form) {
	var self = this;

	this.input = form.paciente;
	this.dniPaciente = form.querySelector('#dni-paciente');
	this.listaPacientes = form.querySelector('#lista-pacientes');
	this.itemActivo = undefined;
	this.entradaActual = '';
	this.btnVerDatos = form.querySelector('#btn-datos-paciente');
	this.btnCrearPaciente = form.querySelector('#btn-crear-paciente');
	this.paciente = null;

	const TECLA_ENTER = 13;
	const TECLA_ESC = 27;
	const TECLA_DIR_ARRIBA = 38;
	const TECLA_DIR_ABAJO = 40;

	this.input.addEventListener('keydown', function(e) {
		switch(e.keyCode) {
			case TECLA_DIR_ABAJO:
				self.listaPacientes.classList.remove('d-none');
				self._preselecItemInf();
			break;
			
			case TECLA_DIR_ARRIBA:
				self.listaPacientes.classList.remove('d-none');
				self._preselecItemSup();
			break;

			case TECLA_ENTER:
				self._efectivizarItemPreselec();
			break;

			case TECLA_ESC:
				self._ocultarLista();
			break;
		}
	});

	this.input.addEventListener('input', function(e) {
		var entrada = this.value;

		self.dniPaciente.textContent = '';

		entrada = entrada.replace(/^\s+/, '');
		entrada = entrada.replace(/\s+/g, ' ');
		entrada = entrada.replace(/\s,/g, ',');
		//entrada = entrada.replace(/(?<=,)\w/g, $1 => ' ' + $1);

		this.value = entrada;
		self.entradaActual = entrada;

		if(entrada === '') {
			self.btnCrearPaciente.classList.add('d-none');
			self._ocultarLista();

			return;
		}

		var datos = {
			start: 0,
			length: 80,
			search: { value: this.value },
			order: [{
				column: 0,
				dir: 'asc'
			}],
			columns: [{ data: 'apellido' }],
			draw: 1
		};

		$.ajax('/iiet/pacientes/listar', {
			dataType: 'json',
			method: 'POST',
			data: datos,
			success: function(resp) {
				if(resp.recordsFiltered > 0) {
					self.btnCrearPaciente.classList.add('d-none');
					self._listarPacientes(resp.data);
				}

				else {
					self.btnCrearPaciente.classList.remove('d-none');
					self._ocultarLista();
				}
			}
		});
	});

	form.querySelector('#limpiar-buscador').addEventListener('click', function(e) {
		self.input.value = '';
		self.itemActivo = undefined;
		self.entradaActual = '';
		self.paciente = null;

		self.dniPaciente.textContent = '';
		self.btnCrearPaciente.classList.add('d-none');
		self._ocultarLista();

		self.input.focus();

		self.input.dispatchEvent(new CustomEvent('buscpac.cambio', {
			view: window,
			bubbles: true,
			cancelable: true,
			detail: {
				paciente: null
			}
		}));
	});

	this.btnVerDatos.addEventListener('click', function(e) {
		this.dispatchEvent(new CustomEvent('buscpac.mostrar', {
			view: window,
			bubbles: true,
			cancelable: true,
			detail: {
				paciente: self.paciente
			}
		}));
	});

	this.btnCrearPaciente.addEventListener('click', function(e) {
		this.classList.add('d-none');

		var entrada  = self.input.value,
			posComa  = entrada.search(','),
			posPunto = entrada.search(':');

		var apellido, nombre, dni;

		if(posComa > -1) {
			apellido = entrada.substring(0, posComa);

			if(posPunto > -1) {
				nombre = entrada.substring(posComa + 1, posPunto);
				dni    = entrada.substring(posPunto + 1);
			}

			else {
				nombre = entrada.substring(posComa + 1);
				dni    = '';
			}
		}

		else {
			if(posPunto > -1) {
				apellido = entrada.substring(0, posPunto);
				nombre   = '';
				dni      = entrada.substring(posPunto + 1);
			}

			else {
				apellido = entrada;
				nombre   = '';
				dni      = '';
			}
		}

		self.input.dispatchEvent(new CustomEvent('buscpac.nuevo', {
			view: window,
			bubbles: true,
			cancelable: true,
			detail: {
				datosPaciente: {
					apellido: apellido.trim(),
					nombre:   nombre.trim(),
					dni:      dni.trim()
				}
			}
		}));
	});

	form.addEventListener('submit', e => e.preventDefault());
	
	var top = $(this.listaPacientes).offset().top;
	this.listaPacientes.style.maxHeight = (window.innerHeight - top - 20) + 'px';
	this.listaPacientes.classList.add('d-none');
};

/**
 * Recibe un array con datos de los pacientes y crea una lista desplegable donde cada ítem
 * de la misma se corresponde con un paciente.
 * 
 * @method _listarPacientes
 * @private
 * @param {Array} pacientes array con datos de los pacientes a mostrar.
 */
FormBuscPaciente.prototype._listarPacientes = function(pacientes) {
	this._vaciarLista();

	var i = 0;

	for(let paciente of pacientes) {
		let nombres = paciente.apellido + ', ' + paciente.nombre,
			item    = this._nuevoItem(nombres, paciente.dni, paciente.numero);

		item.indice = i++;
		this.listaPacientes.appendChild(item);
	}

	this._mostrarLista();
};

/**
 * Crea un ítem nuevo con los datos de un paciente.
 * 
 * @method _nuevoItem
 * @private
 * @param {String} nombre  nombre del paciente.
 * @param {String} dni     DNI del paciente.
 * @param {String} valor   ID del paciente.
 * 
 * @return {HTMLLIElement} nuevo ítem.
 */
FormBuscPaciente.prototype._nuevoItem = function(nombre, dni, valor) {
	var item       = document.createElement('li');
		spanNombre = document.createElement('span');
		spanDNI    = document.createElement('span');

	item.className = 'list-group-item list-group-item-light';

	spanNombre.textContent = nombre;
	spanDNI.textContent = dni;

	item.appendChild(spanNombre);
	item.appendChild(spanDNI);

	item.dataset.id = valor;
	item.dataset.dni = dni;

	item.addEventListener('click', () => this._efectivizarItemPreselec.call(this));
	item.addEventListener('mouseover', () => this._preselecItem(item));
	item.addEventListener('mouseout', () => this._quitarPreselecItem());
	//item.addEventListener('mouseout', () => item.classList.remove('active'));

	return item;
};

/**
 * Marca el ítem como activo esperando la efectiva selección del mismo. Esto
 * provoca que el ítem sea resaltado y su contenido volcado en la caja de
 * búsqueda.
 * 
 * @method _preselecItem
 * @private
 * @param {HTMLLIElement} item ítem que se marcará como activo.
 */
FormBuscPaciente.prototype._preselecItem = function(item) {
	if(typeof item === 'undefined')
		return;

	if(typeof this.itemActivo !== 'undefined')
		this.itemActivo.classList.remove('active');

	this.itemActivo = item;
	this.itemActivo.classList.add('active');
	
	this._cambiarValorCajaBusq(this.itemActivo);
	this._gestionarScroll();
};

/**
 * Desmarca el ítem como activo. Esto provoca que el ítem deje de ser resaltado
 * y el contenido de la caja de búsqueda se reinicie con el valor del ítem
 * que posee la selección efectiva.
 * 
 * @method _quitarPreselecItem
 * @private
 */
FormBuscPaciente.prototype._quitarPreselecItem = function() {
	if(typeof this.itemActivo === 'undefined')
		return;

	this.itemActivo.classList.remove('active');
	this.itemActivo = undefined;

	this._cambiarValorCajaBusq();
};

/**
 * Marca como activo el ítem que se encuentra inmediatamente debajo del ítem
 * actualmente activo. En caso de no existir uno activo se marcará el primer
 * ítem de la lista y si es el último de la lista no se marcará ninguno.
 * 
 * @method _preselecItemInf
 * @private
 */
FormBuscPaciente.prototype._preselecItemInf = function() {
	var indiceSig;
	var item;

	if(typeof this.itemActivo === 'undefined')
		item = this.listaPacientes.children[0];
	
	else {
		indiceSig = this.itemActivo.indice + 1;
		item = this.listaPacientes.children[indiceSig];
	}

	item ? this._preselecItem(item) : this._quitarPreselecItem();
};

/**
 * Marca como activo el ítem que se encuentra inmediatamente encima del ítem
 * actualmente activo. En caso de no existir uno activo se marcará el último
 * ítem de la lista y si es el primero de la lista no se marcará ninguno.
 * 
 * @method _preselecItemSup
 * @private
 */
FormBuscPaciente.prototype._preselecItemSup = function() {
	var indiceAnt;
	var ultItem;
	var item;

	if(typeof this.itemActivo === 'undefined') {
		ultItem = this.listaPacientes.children.length - 1;
		item = this.listaPacientes.children[ultItem];
	}
	
	else {
		indiceAnt = this.itemActivo.indice - 1;
		item = this.listaPacientes.children[indiceAnt];
	}

	item ? this._preselecItem(item) : this._quitarPreselecItem();
};

/**
 * Comprueba que el ítem seleccionado esté dentro del área visible de
 * la lista y en caso de que no lo esté realiza un scroll para ubicarlo
 * dentro del área visible.
 * 
 * @method _gestionarScroll
 * @private
 */
FormBuscPaciente.prototype._gestionarScroll = function() {
	if(typeof this.itemActivo === 'undefined')
		return;

	var topItem 	= $(this.itemActivo).offset().top,
		bottomItem  = $(this.itemActivo).height() + topItem,
		topLista    = $(this.listaPacientes).offset().top,
		bottomLista = $(this.listaPacientes).height() + topLista;

	// el ítem está por debajo de la parte inferior del área visible
	// de la lista entonces realiza un scroll hacia abajo
	if(bottomItem > bottomLista)
		this.listaPacientes.scrollTop += bottomItem - bottomLista + 25;

	// el ítem está por encima de la parte superior del área visible
	// de la lista entonces realiza un scroll hacia arriba
	else if(topItem < topLista)
		this.listaPacientes.scrollTop -= topLista - topItem;
};

/**
 * Hace efectiva la selección del ítem preseleccionado y sus datos pasan
 * a ser los que el objeto toma como los datos activos.
 * 
 * @method _efectivizarItemPreselec
 * @private
 */
FormBuscPaciente.prototype._efectivizarItemPreselec = function() {
	this.entradaActual = this.input.value;
	this.paciente = {
		id: this.itemActivo.dataset.id,
		dni: this.itemActivo.dataset.dni,
		str: this.entradaActual
	};
	this.dniPaciente.textContent = this.paciente.dni;

	this._ocultarLista();

	// lanza un evento indicando que se produzco un cambio de paciente
	this.input.dispatchEvent(new CustomEvent('buscpac.cambio', {
		view: window,
		bubbles: true,
		cancelable: true,
		detail: {
			paciente: this.paciente
		}
	}));
};

/**
 * Hace visible la lista de pacientes.
 * 
 * @method _mostrarLista
 * @private
 */
FormBuscPaciente.prototype._mostrarLista = function() {
	this.listaPacientes.classList.remove('d-none');
	this.listaPacientes.scrollTo(0, 0);
};

/**
 * Oculta la lista de pacientes pero antes desmarca, si es que existe,
 * el ítem preseleccionado actualmente.
 * 
 * @method _ocultarLista
 * @private
 */
FormBuscPaciente.prototype._ocultarLista = function() {
	this._quitarPreselecItem();
	this._vaciarLista();
	this.listaPacientes.classList.add('d-none');
};

/**
 * Vacía la lista de pacientes.
 * 
 * @method _vaciarLista
 * @private
 */
FormBuscPaciente.prototype._vaciarLista = function() {
	this.listaPacientes.innerHTML = '';
};

/**
 * Establece un nuevo valor para la caja de búsqueda a partir de los
 * datos de un ítem. Si no se proporciona un ítem el valor que adquiere
 * es el de la propiedad this.entradaActual.
 * 
 * @method _cambiarValorCajaBusq
 * @private
 * @property {HTMLLIElement} item ítem de la lista de pacientes.
 */
FormBuscPaciente.prototype._cambiarValorCajaBusq = function(item) {
	if(typeof item === 'undefined')
		this.input.value = this.entradaActual;

	else
		this.input.value = item.children[0].textContent;
};

/**
 * Establece la configuración del objeto con los datos proporcionados.
 * 
 * @method establecerValores
 * @param {Object} datos objeto con las propiedades str (apellido y
 *                       nombre del paciente) y dni.
 */
FormBuscPaciente.prototype.establecerValores = function(datos) {
	this._preselecItem();

	this._vaciarLista();

	this.paciente = datos;
	this.input.value = datos.str;
	this.dniPaciente.textContent = datos.dni;
};

/**
 * Establece el foco de la aplicación a la caja de búsqueda.
 * 
 * @method enfocar
 */
FormBuscPaciente.prototype.enfocar = function() {
	this.input.focus();
};