function Paginacion(html) {
	this.contenedor = html;
	this.datos = new Array();
	this.i = -1;

	this.contenido = document.createElement('section');
	this.indice = document.createElement('ul');

	var nav = document.createElement('nav');

	this.indice.className = 'pagination';
	nav.appendChild(this.indice);

	this.contenedor.appendChild(this.contenido);
	this.contenedor.appendChild(nav);

	this.contenido.style.height = '300px';
	this.contenido.classList.add('bg-danger');

	var self = this;

	$(this.indice).on('click', '.page-link', function(e) {
		var link = e.target;
console.log("click");
		if(self.i > -1)
			self.indice.children[self.i].classList.remove('active');

		link.classList.add('active');
		self.i = link.dataset.i;
	});
}

Paginacion.prototype.establecerDatos = function(datos) {
	this.datos = datos;

	for(let i = 0; i < datos.length; ++i)
		this.indice.appendChild(nuevoItem(i));
};

function nuevoItem(i) {
	var li = document.createElement('li'),
		a  = document.createElement('a');

	li.className = 'page-item';

	a.className = 'page-link';
	a.href = '#';
	a.dataset.i = i;
	a.textContent = (i + 1);

	li.appendChild(a);

	return li;
}