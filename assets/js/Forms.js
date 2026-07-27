var Forms = {};

Forms.habilitarVerificacion = function(form) {
	$(form).find('.validar').on('blur', function(e) {
		if(this.reportValidity()) {
			this.classList.remove('invalido');
			this.classList.add('valido');
		}

		else {
			this.classList.remove('valido');
			this.classList.add('invalido');
		}
	});
};

Forms.validarFecha = function(input) {
	input.addEventListener('blur', function(e) {
		var arrFecha = input.value.split('-'),
			fechaIng = new Date(
				parseInt(arrFecha[0]),
				parseInt(arrFecha[1]) - 1,
				parseInt(arrFecha[2])
			),
			fechaActual = new Date();

		if(fechaIng > fechaActual) {
			this.classList.remove('valido');
			this.classList.add('invalido');
		}

		else {
			this.classList.remove('invalido');
			this.classList.add('valido');
		}
	});
};

Forms.cargarSelect = function(select, lista, campo, valor) {
	select.innerHTML = '';

	select.add(new Option());
	lista.forEach(o => select.add( new Option(o[campo], o[valor]) ));
};

Forms.cambioSelect = function(sFuente, sDestino, url, campo, valor) {
	if(!sFuente.dependiente)
		sFuente.dependiente = new Array();

	sFuente.dependiente.push(sDestino);

	sFuente.addEventListener('change', function(e) {
		var i = sFuente.selectedIndex,
			v = sFuente.item(i).value;

		Forms.limpiarDependientes(sFuente);

		if(v !== '') {
			$.ajax(url + v, {
				dataType: 'json',
				success: resp => Forms.cargarSelect(sDestino, resp, campo, valor)
			});
		}
	});
};

Forms.limpiarDependientes = function(select) {
	if(select.dependiente) {
		select.dependiente.forEach(function(dp) {
			dp.innerHTML = '';

			dp.classList.remove('valido');
			dp.classList.remove('invalido');

			Forms.limpiarDependientes(dp);
		});
	}
};

Forms.cargarDivPolits = function(form, datos) {
	form.departamento.value = datos.nro_departamento;

	$.ajax('/iiet/entidades/listado_localidades/' + datos.nro_departamento, {
		dataType: 'json',
		success: function(respL) {
			Forms.cargarSelect(form.localidad, respL, 'nombre', 'numero');
			form.localidad.value = datos.nro_localidad;

			$.ajax('/iiet/entidades/listado_barrios/' + datos.nro_localidad, {
				dataType: 'json',
				success: function(respB) {
					Forms.cargarSelect(form.barrio, respB, 'nombre', 'numero');
					form.barrio.value = datos.nro_barrio;
				}
			});

			$.ajax('/iiet/entidades/listado_parajes/' + datos.nro_localidad, {
				dataType: 'json',
				success: function(respP) {
					Forms.cargarSelect(form.paraje, respP, 'nombre', 'numero');
					form.paraje.value = datos.nro_paraje;
				}
			});

			if(datos.nro_barrio) {
				Forms.deshabilitarCampoPuesto(form);

				$.ajax('/iiet/escuelas/listado_escuelas/barrio/' + datos.nro_barrio, {
					dataType: 'json',
					success: function(respI) {
						Forms.cargarSelect(form.institucion, respI, 'nombre', 'numero');
						form.institucion.value = datos.nro_institucion;
					}
				});
			}

			else {
				form.lugar.value = 'paraje';
				Forms.excluir(form.lugar, form.lugar[1]);

				$.ajax('/iiet/entidades/listado_puestos/' + datos.nro_paraje, {
					dataType: 'json',
					success: function(respPt) {
						Forms.cargarSelect(form.puesto, respPt, 'nombre', 'numero');
						form.puesto.value = datos.nro_puesto;
					}
				});
				$.ajax('/iiet/escuelas/listado_escuelas/paraje/' + datos.nro_paraje, {
					dataType: 'json',
					success: function(respI) {
						Forms.cargarSelect(form.institucion, respI, 'nombre', 'numero');
						form.institucion.value = datos.nro_institucion;
					}
				});
			}
		}
	});
};

Forms.habilitarCampoPuesto = function(form) {
	$(form).find('#grupo-puesto').removeClass('d-none');
	$(form).find('#grupo-puesto').find('select')[0].disabled = null;
};

Forms.deshabilitarCampoPuesto = function(form) {
	$(form).find('#grupo-puesto').addClass('d-none');
	$(form).find('#grupo-puesto').find('select')[0].disabled = 'disabled';
};

Forms.excluyentes = function(elems) {
	$(elems).on('change', e => Forms.excluir(elems, e.target));
};

Forms.excluir = function(elems, activo) {
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
};

Forms.habilitarCampoInstitucion = function(form) {
	var grupoInstitucion = form.querySelector('.grupo-institucion');

	grupoInstitucion.classList.remove('d-none');
	grupoInstitucion.querySelector('select').disabled = null;
};

Forms.deshabilitarCampoInstitucion = function(form) {
	var grupoInstitucion = form.querySelector('.grupo-institucion');
	
	grupoInstitucion.classList.add('d-none');
	grupoInstitucion.querySelector('select').disabled = 'disabled';
};

Forms.resetForm = function(form) {
	form.classList.remove('was-validated');

	$(form).find('.invalido').removeClass('invalido');
	$(form).find('.valido').removeClass('valido');
};