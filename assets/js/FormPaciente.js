function FormPaciente(modal) {
	this.modal = $(modal);
	this.elem  = modal.querySelector('form');
	this.modo  = 'nuevo';

	var form = this.elem,
		self = this;

	$('.dni-unico').on('blur', function(e) {
		if(this.validity.valid) {
			this.classList.remove('invalido');

			if(this.value != this.orig) {
				$.ajax('/iiet/pacientes/existe/' + this.value, {
					dataType: 'json',
					context: this,
					success: function(respuesta) {
						if(respuesta !== false) {
							var paciente = respuesta.apellido + ', ' + respuesta.nombre;

							this.classList.add('dni-duplicado');
							$(this).siblings('.msj-dni-duplicado')[0].children[0].textContent = paciente;

							this.select();
						}

						else {
							this.classList.remove('dni-duplicado');
							this.classList.add('valido');
						}
					}
				});
			}

			else {
				this.classList.remove('dni-duplicado');
				this.classList.add('valido');
			}
		}

		else {
			this.classList.remove('valido');
			this.classList.add('invalido');

			this.select();
		}
	});

	Forms.habilitarVerificacion(form);
	Forms.validarFecha(form.fecha_nacimiento);

	$.ajax('/iiet/entidades/listado_departamentos', {
		dataType: 'json',
		success: resp => Forms.cargarSelect(form.departamento, resp, 'nombre', 'numero')
	});

	// onChange departamento
	Forms.cambioSelect(
		form.departamento,
		form.localidad,
		'/iiet/entidades/listado_localidades/',
		'nombre',
		'numero'
	);
	// onChange localidad
	Forms.cambioSelect(
		form.localidad,
		form.barrio,
		'/iiet/entidades/listado_barrios/',
		'nombre',
		'numero'
	);
	Forms.cambioSelect(
		form.localidad,
		form.paraje,
		'/iiet/entidades/listado_parajes/',
		'nombre',
		'numero'
	);
	// onChange paraje
	Forms.cambioSelect(
		form.paraje,
		form.puesto,
		'/iiet/entidades/listado_puestos/',
		'nombre',
		'numero'
	);

	Forms.excluyentes(form.lugar);

	form.lugar[0].addEventListener('change', e => Forms.deshabilitarCampoPuesto(form));
	form.lugar[1].addEventListener('change', e => Forms.habilitarCampoPuesto(form));

	form.addEventListener('reset', function(e) {
		Forms.resetForm(form);
		form.querySelector('.dni-duplicado').classList.remove('dni-duplicado');

		Forms.excluir(form.lugar, form.lugar[0]);
		Forms.deshabilitarCampoPuesto(form);
		Forms.limpiarDependientes(form.departamento);

		$('#alert-np-error').html('');
	});

	form.addEventListener('submit', function(e) {
		e.preventDefault();

		this.classList.add('was-validated');

		if(this.checkValidity() === false) {
			e.preventDefault();
			e.stopPropagation();
		}

		else {
			$.ajax('/iiet/pacientes/' + self.modo, {
				method: 'POST',
				data: $(form).serialize(),
				success: self.exitoGuardar || null,
				error: self.errorGuardar || null
			});
		}
	});
}

FormPaciente.prototype.configModalNuevo = function(datos) {
	this.modo = 'nuevo';

	if(datos) {
		this.elem.dni.value = datos.dni;
		this.elem.apellido.value = datos.apellido;
		this.elem.nombre.value = datos.nombre;
	}

	this.modal.find('.modal-header h4').text('Nuevo Paciente');

	this.elem.enviar.value = 'Crear';
	this.elem.numero.disabled = 'disabled';
	this.elem.dni.orig = null;
};

FormPaciente.prototype.configModalEditar = function(datos) {
	this.modo = 'actualizar';

	this.modal.find('.modal-header h4').text('Actualizar Paciente');

	this.elem.enviar.value = 'Actualizar';
	this.elem.numero.disabled = null;
	this.elem.dni.orig = datos.dni;

	this.elem.numero.value = datos.numero;
	this.elem.dni.value = datos.dni;
	this.elem.nro_cuaderno.value = datos.nro_cuaderno;
	this.elem.apellido.value = datos.apellido;
	this.elem.nombre.value = datos.nombre;
	this.elem.fecha_nacimiento.value = datos.fecha_nacimiento;
	this.elem.sexo.value = datos.sexo.trim();

	Forms.cargarDivPolits(this.elem, datos);

	if(datos.nro_puesto)
		Forms.habilitarCampoPuesto(this.elem);

	this.elem.domicilio.value = datos.domicilio;
};

FormPaciente.prototype.exito = function(fc) {
	this.exitoGuardar = fc;
};

FormPaciente.prototype.error = function(fc) {
	this.errorGuardar = fc;
};