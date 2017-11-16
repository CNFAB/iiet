var Utils = {};

Utils.toNumber = function(strNumber) {
	if(strNumber.search(/^\d+(\.\d+)?\D*$/) !== -1)
		return strNumber.replace(/\D*$/, "") - 0;
	
	return NaN;
};

Utils.getWidth = function(el) {
	var widthPx = window.getComputedStyle(el, null)["width"];

	return Utils.toNumber(widthPx);
};

Utils.getHeight = function(el) {
	var heightPx = window.getComputedStyle(el, null)["height"];

	return Utils.toNumber(heightPx);
};

Utils.getEntireWidth = function(el) {
	var left = el.getBoundingClientRect()["left"];
	var right = el.getBoundingClientRect()["right"];

	return right - left;
};

Utils.getLeft = function(el) {
	return el.getBoundingClientRect()["left"];
};

Utils.getRight = function(el) {
	return el.getBoundingClientRect()["right"];
};

Utils.getZIndex = function(el) {
	var strIndex = getComputedStyle(el, null)["z-index"];

	return Utils.toNumber(strIndex);
};

Utils.ajax = function(url, data = null, success = null, error = null) {
	var xhr = new XMLHttpRequest();
	var fd = new FormData();

	for(let [campo, valor] of data)
		fd.append(campo, valor);

	xhr.open('POST', url, true);
	xhr.responseType = "json";
	xhr.addEventListener("load", success);
	xhr.addEventListener("error", error);

	xhr.send(fd);
};


Utils.obtenerDatosAJAX = function(selectOrg, selectDst, url) {
	var i = selectOrg.selectedIndex;

	if(i > 0) {
		let campoId,
			valorId,
			datos;

		campoId = selectOrg.name;
		valorId = selectOrg.item(i).value;
		datos = new Map([[campoId, valorId]]);
		
		Utils.ajax(url, datos, function(e) {
			Utils.listarDatosEnSelect(selectDst, e.target.response);
		});
	}

	else if(i == 0)
		selectDst.innerHTML = '';
};

Utils.listarDatosEnSelect = function(select, listado) {
	var vacio = new Option('');

	select.innerHTML = '';
	select.add(vacio);

	for(let item of listado) {
		let option = new Option(item['nombre'], item['numero']);
		select.add(option);
	}
};

Utils.toCamelCase = function(str) {
	str = str.toLowerCase();

	return str.replace(/(^\w|\s+\w)/g, $1 => $1.toUpperCase());
};