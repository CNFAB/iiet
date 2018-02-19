
var tools = {};

function fcErrorDefault(e) {
	console.log("Se ha producido un error");
}

tools.httpRequest = function(p) {
	if(p.data) {
		var field = null;

		if(p.method == "GET") {
			var get = "?";

			for(field in p.data)
				get += encodeURIComponent(field) + "=" + encodeURIComponent(p.data[field]) + "&";

			p.url += get.replace(/&$/, "");
			p.data = null;
		}

		else {
			var fd = new FormData();

			for(field in p.data)
				fd.append(field, p.data[field]);

			p.data = fd;
		}
	}

	var xhr = new XMLHttpRequest();

	xhr.open(p.method, p.url, p.async);
	xhr.responseType = p.responseType;
	xhr.addEventListener("load", p.fcSuccess);
	xhr.addEventListener("error", p.fcError || fcErrorDefault);

	xhr.send(p.data);
};

tools.getNumber = function(str) {
	if(str.search(/^\d+(\.?\d+)?\D+$/) !== -1)
		return str.replace(/\D+$/, "") - 0;
	
	return NaN;
};


tools.calcularPorcentaje = function(elementoHTML, propiedad, valor) {
	var padre = elementoHTML.parentNode;
	var propPadre = null;

	valor = this.getNumber(valor) / 100;

	if(propiedad.search(/(W|w)idth|(L|l)eft|(R|r)ight/) !== -1)
		propPadre = this.getPropertyOf(padre, "width");

	else if(propiedad.search(/(H|h)eight|(T|t)op|(B|b)ottom/) !== -1)
		propPadre = this.getPropertyOf(padre, "height");

	return propPadre * valor;
};

tools.getPropertyOf = function(element, property) {
	var value = 0;

	switch(property) {
		// alto del elemento considerando el relleno y el borde
		case "outerHeight":
			value = element.getBoundingClientRect().height;
		break;

		// ancho del elemento considerando el relleno y el borde
		case "outerWidth":
			//value = element.getBoundingClientRect().width;
			var border = this.getPropertyOf(element, "borderLeftWidth") +
						 this.getPropertyOf(element, "borderRightWidth");

			var padding = this.getPropertyOf(element, "paddingLeft") +
						  this.getPropertyOf(element, "paddingRight");

			value = border + padding;
		break;

		// alto del elemento considerando el relleno, el borde y el margen
		case "entireHeight":
			value = this.getPropertyOf(element, "outerHeight") +
					this.getPropertyOf(element, "marginTop") +
					this.getPropertyOf(element, "marginBottom");
		break;

		// ancho del elemento considerando el relleno, el borde y el margen
		case "entireWidth":
			value = this.getPropertyOf(element, "outerWidth") +
					this.getPropertyOf(element, "marginLeft") +
					this.getPropertyOf(element, "marginRight");
		break;

		case "top":
		case "right":
		case "bottom":
		case "left":
			value = element.getBoundingClientRect()[property];
		break;

		default:
			value = window.getComputedStyle(element, null)[property];

			if(value[value.length - 1] === "%")
				value = this.calcularPorcentaje(element, property, value);

			else
				value = this.getNumber(value);
		break;
	}

	return value;
};
