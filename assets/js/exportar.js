/**
 * Obtiene el número de campaña que viene explícito en la URL de la página
 * 
 * @function obtenerNroCampania
 * @returns {String} número de campaña
 */
function obtenerNroCampania() {
    // elimina los '/' y los '#' que pudieran existir al final de la URL
    var url = location.href.replace(/(\/|#)+$/, '')
    
    // tomando como separador al caracter '/' divide la URL en un array, por ejemplo:
    // url: 'http://localhost/iiet/campanias/config_exportar/24'
    // arrURL: ['http:', '', 'localhost', 'iiet', 'campania', 'config_exportar', '24']
    var arrURL = url.split('/');

    // siguiendo el ejemplo anterior retornaría '24' (número de campaña)
	return arrURL.pop();
}

/**
 * Obtiene los datos de la campaña actual y establece su nombre en la barra
 * de título de la página.
 * 
 * @function establecerNombreCampania
 * @param {String|Number} nroCampania número de la campaña actual
 */
function establecerNombreCampania(nroCampania) {
    fetch('/iiet/campanias/datos_campania/' + nroCampania)
    .then(respuesta => {
        if(respuesta.ok) {
            respuesta.json().then(campania => {
                var txtNombreCampania = document.getElementById('nombre-campania');
                txtNombreCampania.textContent = campania.nombre;
            });
        }
    });
}

/**
 * Configura los checkboxes de la cabecera de cada grupo (COPRO, SANGRE, BIOLOGÍA
 * MOLECULAR, TRATAMIENTO) de modo que cuando sean activados se activen también todos
 * los checkboxes pertenecientes al mismo grupo. Lo opuesto ocurrirá cuando sean
 * desactivados.
 * 
 * @function configCheckboxes
 */
function configCheckboxes() {
    var checkGral = document.querySelectorAll('.card .card-header .custom-control-input');

    checkGral.forEach(cbx => cbx.addEventListener('change', function(e) {
        var check = e.target,
            contenedor = check.parentNode.parentNode.parentNode,
            inputChecks = contenedor.querySelectorAll('.card-body .custom-control-input');

        inputChecks.forEach(c => c.checked = check.checked);
    }));
}

/**
 * Establece las configuraciones iniciales.
 * 
 * @function iniciar
 */
function iniciar() {
    var nroCampania = obtenerNroCampania();

    // establece el número de campaña como parámetro del método de exportación de la clase
    // controladora Campanias.php que se ejectua del lado del servidor
    document.formCampos.action += nroCampania;

    establecerNombreCampania(nroCampania);
    configCheckboxes();
}

iniciar();