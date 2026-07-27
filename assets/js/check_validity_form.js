$('.dni-unico').on('blur', function(e) {
	if(this.validity.valid) {
		$(this).removeClass('invalido');

		if(this.value != this.orig) {
			$.ajax('/iiet/pacientes/existe/' + this.value, {
				dataType: 'json',
				context: this,
				success: function(respuesta) {
					if(respuesta !== false) {
						var paciente = respuesta.apellido + ', ' + respuesta.nombre;

						$(this).addClass('dni-duplicado');
						$(this).siblings('.msj-dni-duplicado')[0].children[0].textContent = paciente;

						this.select();
					}

					else {
						$(this).removeClass('dni-duplicado');
						$(this).addClass('valido');
					}
				}
			});
		}

		else {
			$(this).removeClass('dni-duplicado');
			$(this).addClass('valido');
		}
	}

	else {
		$(this).removeClass('valido');
		$(this).addClass('invalido');

		this.select();
	}
});

$('.input-requerido').on('blur', function(e) {
	if(this.reportValidity()) {
		$(this).removeClass('invalido');
		$(this).addClass('valido');
	}

	else {
		$(this).removeClass('valido');
		$(this).addClass('invalido');
	}
});

function validarFecha(input) {
	input.addEventListener('blur', function(e) {
		var arrFecha = input.value.split('-');
			fechaIng = new Date(
				parseInt(arrFecha[0]),
				parseInt(arrFecha[1]) - 1,
				parseInt(arrFecha[2])
			);
			fechaActual = new Date();

		if(fechaIng > fechaActual) {
			$(this).removeClass('valido');
			$(this).addClass('invalido');
		}

		else {
			$(this).removeClass('invalido');
			$(this).addClass('valido');
		}
	});
}

function cargarSelect(e, lista, campo, valor) {
	e.innerHTML = '';

	e.add(new Option());
	lista.forEach(o => e.add( new Option(o[campo], o[valor]) ));
}

function cambioSelect(sFuente, sDestino, url, campo, valor) {
	if(!sFuente.dependiente)
		sFuente.dependiente = new Array();

	sFuente.dependiente.push(sDestino);

	sFuente.addEventListener('change', function(e) {
		var i = sFuente.selectedIndex,
			v = sFuente.item(i).value;

		limpiarDependientes(sFuente);

		if(v !== '') {
			$.ajax(url + v, {
				dataType: 'json',
				success: resp => cargarSelect(sDestino, resp, campo, valor)
			});
		}
	});
}

function limpiarDependientes(select) {
	if(select.dependiente) {
		select.dependiente.forEach(function(dp) {
			dp.innerHTML = '';

			$(dp).removeClass('valido');
			$(dp).removeClass('invalido');

			limpiarDependientes(dp);
		});
	}
}

function excluyentes(elems) {
	$(elems).on('change', e => excluir(elems, e.target));
}

function excluir(elems, activo) {
	elems.forEach(function(elem) {
		var ref = elem.dataset.ref,
			inp = elem.value;

		if(elem === activo) {
			$(ref).removeClass('d-none');
			activo.form[inp].disabled = null;
		}

		else {
			$(ref).addClass('d-none');
			elem.form[inp].disabled = 'disabled';
		}
	});
}

function resetForm(form) {
	$(form).removeClass('was-validated');

	$(form).find('.invalido').removeClass('invalido');
	$(form).find('.valido').removeClass('valido');
	$(form).find('.dni-duplicado').removeClass('dni-duplicado');
}


function obtenerObjIdioma(obj, placeholderBuscar) {
	return {
		sProcessing:     'Procesando...',
		sLengthMenu:     'Mostrar _MENU_ ' + obj,
		sZeroRecords:    'No se encontraron ' + obj,
		sEmptyTable:     'Ningún dato disponible en esta tabla',
		sInfo:           'Mostrando ' + obj + ' del _START_ al _END_ de un total de _TOTAL_ ' + obj,
		sInfoEmpty:      'Mostrando ' + obj + ' del 0 al 0 de un total de 0 ' + obj,
		sInfoFiltered:   '(filtrado de un total de _MAX_ ' + obj + ')',
		sInfoPostFix:    '',
		sSearch:         'Buscar:',
		searchPlaceholder: placeholderBuscar,
		sUrl:            '',
		sInfoThousands:  '.',
		sLoadingRecords: 'Cargando...',
		oPaginate: {
			sFirst:    'Primero',
			sLast:     'Último',
			sNext:     'Siguiente',
			sPrevious: 'Anterior'
		},
		oAria: {
			sSortAscending:  ': Activar para ordenar la columna de manera ascendente',
			sSortDescending: ': Activar para ordenar la columna de manera descendente'
		}
	};
}


// Pipelining function for DataTables. To be used to the `ajax` option of DataTables
$.fn.dataTable.pipeline = function ( opts ) {
    // Configuration options
    var conf = $.extend({
        pages: 5,     // number of pages to cache
        url: '',      // script url
        data: null,   // function or object with parameters to send to the server
                      // matching how `ajax.data` works in DataTables
        method: 'GET' // Ajax HTTP method
    }, opts );
 
    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;
 
    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;
         
        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
         
        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );
 
        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));
 
                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }
             
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);
 
            request.start = requestStart;
            request.length = requestLength*conf.pages;
 
            // Provide the same `data` options as DataTables.
            if ( typeof conf.data === 'function' ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }
 
            settings.jqXHR = $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);
 
                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    if ( requestLength >= -1 ) {
                        json.data.splice( requestLength, json.data.length );
                    }
                     
                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );
 
            drawCallback(json);
        }
    }
};

// Register an API method that will empty the pipelined data, forcing an Ajax
// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
$.fn.dataTable.Api.register( 'clearPipeline()', function () {
    return this.iterator( 'table', function ( settings ) {
        settings.clearCache = true;
    } );
} );

function cargarDivPolits(form, datos) {
	form.departamento.value = datos.nro_departamento;

	$.ajax('/iiet/entidades/listado_localidades/' + datos.nro_departamento, {
		dataType: 'json',
		success: function(respL) {
			cargarSelect(form.localidad, respL, 'nombre', 'numero');
			form.localidad.value = datos.nro_localidad;

			if(datos.nro_barrio) {
				$.ajax('/iiet/entidades/listado_barrios/' + datos.nro_localidad, {
					dataType: 'json',
					success: function(respB) {
						cargarSelect(form.barrio, respB, 'nombre', 'numero');
						form.barrio.value = datos.nro_barrio;

						if(form.institucion) {
							$.ajax('/iiet/escuelas/listado_escuelas/barrio/' + datos.nro_barrio, {
								dataType: 'json',
								success: function(respI) {
									cargarSelect(form.institucion, respI, 'nombre', 'numero');
									form.institucion.value = datos.nro_institucion;
								}
							});
						}
					}
				});
			}

			else {
				form.lugar.value = 'paraje';
				excluir(form.lugar, form.lugar[1]);

				$.ajax('/iiet/entidades/listado_parajes/' + datos.nro_localidad, {
					dataType: 'json',
					success: function(respP) {
						cargarSelect(form.paraje, respP, 'nombre', 'numero');
						form.paraje.value = datos.nro_paraje;

						$.ajax('/iiet/entidades/listado_puestos/' + datos.nro_paraje, {
							dataType: 'json',
							success: function(respPt) {
								cargarSelect(form.puesto, respPt, 'nombre', 'numero');
								form.puesto.value = datos.nro_puesto;
							}
						});

						if(form.institucion) {
							$.ajax('/iiet/escuelas/listado_escuelas/paraje/' + datos.nro_paraje, {
								dataType: 'json',
								success: function(respI) {
									cargarSelect(form.institucion, respI, 'nombre', 'numero');
									form.institucion.value = datos.nro_institucion;
								}
							});
						}
					}
				});
			}
		}
	});
}

function habilitarCampoPuesto() {
	$('#grupo-puesto').removeClass('d-none');
	$('#grupo-puesto').find('select')[0].disabled = null;
}

function deshabilitarCampoPuesto() {
	$('#grupo-puesto').addClass('d-none');
	$('#grupo-puesto').find('select')[0].disabled = 'disabled';
}