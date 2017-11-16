<!DOCTYPE html>

<html lang="es">
	<head>
		<title>Prueba</title>
		<meta charset="utf-8"/>

		<link rel="stylesheet" href="/iiet/assets/css/reset.css" />
		<link rel="stylesheet" href="/iiet/assets/css/variables.css" />
		<script src="/iiet/assets/js/Utils.js"></script>
		<link rel="import" href="/iiet/assets/web-components/ventana-modal.html"/>
		<link rel="import" href="/iiet/assets/web-components/form-asinc.html"/>

		<style>
			@import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600');
			@import url('https://fonts.googleapis.com/css?family=Montserrat');

			* {
				font-family: 'Source Sans Pro', 'Sans Serif';
				font-size: 1em;
			}

			ventana-modal .modal {
				min-width: 300px;
				padding: 20px;
			}

			ventana-modal header {
				font-size: 1.3em;
				text-align: center;
				margin-bottom: 30px;
			}

			ventana-modal label {
				display: block;
				position: relative;
				width: 390px;
				margin-bottom: 10px;
			}

			ventana-modal label span {
				display: inline-block;
				padding: 4px 5px;
			}

			ventana-modal form input:not([type='submit']),
			select {
				position: absolute;
				right: 0;
				border: 1px solid var(--clrbtnform);
				padding: 2px 10px;
				width: 195px;
			}

			select {
				width: 217px;
			}

			ventana-modal form input.nro_real {
				width: 100px;
				text-align: right;
			}

			ventana-modal .btn_submit {
				text-align: center;
				margin-top: 40px;
			}

			ventana-modal .btn_submit * {
				background: white;
				padding: var(--padsupinfbtn) var(--padlatbtn);
				border: 1px solid black;
				margin: 0 10px;
				cursor: pointer;
			}


			.grupo_radio label input[type=radio] {
			    position: relative;

			    width: auto;
			    visibility: hidden;
			    cursor: pointer;
			    margin-left: 20px;
			}

			.grupo_radio {
				width: 390px;
			    margin-top: 10px;
			}

			.grupo_radio label {
			    display: inline-block;
			    width: 125px;
			    margin-top: 0;
			    margin-right: 40px;
			    cursor: pointer;
			}

			.grupo_radio label input[type=radio]:before {
			    position: absolute;
			    top: -15%;
			    right: -15%;

			    display: block;
			    border: 2px solid rgba(0,0,0,.44);
			    border-radius: 50%;
			    width: 14px;
			    height: 14px;

			    content: '';
			    visibility: visible;
			}

			.grupo_radio label:first-of-type [type=radio]:checked:before {
			    border-color: #5E8FB9;
			}

			.grupo_radio label:last-of-type [type=radio]:checked:before {
			    border-color: #E3335D;
			}

			.grupo_radio label input[type=radio]:after {
			    position: absolute;
			    top: 5%;
			    right: 5%;

			    display: block;
			    border-radius: 50%;
			    width: 12px;
			    height: 12px;
			    visibility: hidden;

			    content: '';

			    transition: all .25s ease-in-out;
			    transform: scale(0);
			}

			.grupo_radio label:first-of-type input[type=radio]:after {
			    background: #5E8FB9;
			}

			.grupo_radio label:last-of-type input[type=radio]:after {
			    background: #E3335D;
			}

			.grupo_radio input[type=radio]:checked:after,
			.grupo_radio label:hover input[type=radio]:after {
			    visibility: visible;
			    transform: scale(1);
			}

			.grupo_radio label:hover input[type=radio]:not(:checked):after {
			    transform: scale(.8);
			}

			.select_lugar {
				position: relative;

				width: 390px;
				height: 30px;
				margin-bottom: 4px;
			}

			.select_lugar > select {
				left: 30px;
			}

			ventana-modal form > fieldset fieldset {
				padding-left: 5px;
				width: 383px !important;
				margin-top: 10px;
				border: 1px solid var(--clrbtnform);
				padding-top: 5px;

			}

			.domicilio > label, .domicilio .select_lugar {
				width: 370px;
			}

			.domicilio > .grupo_radio {
				width: 380px;
			}

			select[disabled] {
				display: none;
			}

			#en_escuela {
				position: relative;
				width: auto;
				margin-left: 10px;
			}
		</style>
	</head>
	<body>
		<div>
			<a href="#nuevo_departamento">Nuevo Departamento</a>
			<a href="#nueva_localidad">Nueva Localidad</a>
			<a href="#nuevo_barrio">Nuevo Barrio</a>
			<a href="#nuevo_paraje">Nuevo Paraje</a>
			<a href="#nuevo_puesto">Nuevo Puesto</a>
		</div>
		<div>
			<a href="#nueva_escuela">Nueva Escuela</a>
			<a href="#nuevo_paciente">Nuevo Paciente</a>
			<a href="#nueva_campania">Nueva Campa&ntilde;a</a>
		</div>

		<ventana-modal id="nuevo_departamento" class="vm_nuevo_divpolit">
			<header>
				<h1>Nuevo Departamento</h1>
			</header>
			<section>
				<form is="form-asinc" class="form_divpolit" action="/iiet/division_politica/cargar_divpolit/departamentos" method="POST">
					<label>
						<span>Nombre</span>
						<input type="text" name="nombre" required="required" />
					</label>
					<label>
						<span>Latitud</span>
						<input type="text" name="latitud" class="nro_real" pattern="^-?\d+(.\d+)?$" />
					</label>
					<label>
						<span>Longitud</span>
						<input type="text" name="longitud" class="nro_real" pattern="^-?\d+(\.\d+)?$" />
					</label>
					<div class="btn_submit">
						<input type="submit" value="Guardar"/>
						<button type="button" class="btn_cancelar">Cancelar</button>
					</div>
				</form>
			</section>
		</ventana-modal>
		<ventana-modal id="nueva_localidad" class="vm_nuevo_divpolit">
			<header>
				<h1>Nueva Localidad</h1>
			</header>
			<section>
				<form is="form-asinc" class="form_divpolit" action="/iiet/division_politica/cargar_divpolit/localidades" method="POST">
					<label>
						<span>Nombre</span>
						<input type="text" name="nombre" required="required" />
					</label>
					<label>
						<span>Departamento</span>
						<select name="departamento"></select>
					</label>
					<label>
						<span>Latitud</span>
						<input type="text" name="latitud" class="nro_real" pattern="^-?\d+(.\d+)?$" />
					</label>
					<label>
						<span>Longitud</span>
						<input type="text" name="longitud" class="nro_real" pattern="^-?\d+(\.\d+)?$" />
					</label>
					<div class="btn_submit">
						<input type="submit" value="Guardar"/>
						<button type="button" class="btn_cancelar">Cancelar</button>
					</div>
				</form>
			</section>
		</ventana-modal>
		<ventana-modal id="nuevo_barrio" class="vm_nuevo_divpolit">
			<header>
				<h1>Nuevo Barrio</h1>
			</header>
			<section>
				<form is="form-asinc" class="form_divpolit" action="/iiet/division_politica/cargar_divpolit/barrios" method="POST">
					<label>
						<span>Nombre</span>
						<input type="text" name="nombre" required="required" />
					</label>
					<label>
						<span>Departamento</span>
						<select name="departamento"></select>
					</label>
					<label>
						<span>Localidad</span>
						<select name="localidad"></select>
					</label>
					<label>
						<span>Latitud</span>
						<input type="text" name="latitud" class="nro_real" pattern="^-?\d+(.\d+)?$" />
					</label>
					<label>
						<span>Longitud</span>
						<input type="text" name="longitud" class="nro_real" pattern="^-?\d+(\.\d+)?$" />
					</label>
					<div class="btn_submit">
						<input type="submit" value="Guardar"/>
						<button type="button" class="btn_cancelar">Cancelar</button>
					</div>
				</form>
			</section>
		</ventana-modal>
		<ventana-modal id="nuevo_paraje" class="vm_nuevo_divpolit">
			<header>
				<h1>Nuevo Paraje</h1>
			</header>
			<section>
				<form is="form-asinc" class="form_divpolit" action="/iiet/division_politica/cargar_divpolit/parajes" method="POST">
					<label>
						<span>Nombre</span>
						<input type="text" name="nombre" required="required" />
					</label>
					<label>
						<span>Departamento</span>
						<select name="departamento"></select>
					</label>
					<label>
						<span>Localidad</span>
						<select name="localidad"></select>
					</label>
					<label>
						<span>Latitud</span>
						<input type="text" name="latitud" class="nro_real" pattern="^-?\d+(.\d+)?$" />
					</label>
					<label>
						<span>Longitud</span>
						<input type="text" name="longitud" class="nro_real" pattern="^-?\d+(\.\d+)?$" />
					</label>
					<div class="btn_submit">
						<input type="submit" value="Guardar"/>
						<button type="button" class="btn_cancelar">Cancelar</button>
					</div>
				</form>
			</section>
		</ventana-modal>
		<ventana-modal id="nuevo_puesto" class="vm_nuevo_divpolit">
			<header>
				<h1>Nuevo Puesto</h1>
			</header>
			<section>
				<form is="form-asinc" class="form_divpolit" action="/iiet/division_politica/cargar_divpolit/puestos" method="POST">
					<label>
						<span>Nombre</span>
						<input type="text" name="nombre" required="required" />
					</label>
					<label>
						<span>Departamento</span>
						<select name="departamento"></select>
					</label>
					<label>
						<span>Localidad</span>
						<select name="localidad"></select>
					</label>
					<label>
						<span>Paraje</span>
						<select name="paraje"></select>
					</label>
					<div class="btn_submit">
						<input type="submit" value="Guardar"/>
						<button type="button" class="btn_cancelar">Cancelar</button>
					</div>
				</form>
			</section>
		</ventana-modal>
		<ventana-modal id="nueva_escuela" class="vm_nuevo_divpolit">
			<header>
				<h1>Nueva Escuela</h1>
			</header>
			<section>
				<form is="form-asinc" class="form_divpolit" name="nueva_escuela" action="/iiet/escuelas/cargar_escuela">
					<label>
						<span>Nombre</span>
						<input type="text" name="nombre" required="required"/>
					</label>
					<label>
						<span>Departamento</span>
						<select name="departamento"></select>
					</label>
					<label>
						<span>Localidad</span>
						<select name="localidad"></select>
					</label>
					<div class="grupo_radio">
						<label>
							<span>Paraje</span>
							<input type="radio" name="lugar" value="paraje" checked="checked" />
						</label>
						<label>
							<span>Barrio</span>
							<input type="radio" name="lugar" value="barrio" />
						</label>
					</div>
					<div class="select_lugar">
						<select name="paraje" required="required"></select>
						<select name="barrio" required="required" disabled="disabled"></select>
					</div>
					<label>
						<span>Latitud</span>
						<input type="text" name="latitud" class="nro_real" pattern="^-?\d+(.\d+)?$" />
					</label>
					<label>
						<span>Longitud</span>
						<input type="text" name="longitud" class="nro_real" pattern="^-?\d+(\.\d+)?$" />
					</label>
					<div class="btn_submit">
						<input type="submit" value="Guardar"/>
						<button type="button" class="btn_cancelar">Cancelar</button>
					</div>
				</form>
			</section>
		</ventana-modal>
		<ventana-modal id="nuevo_paciente" class="vm_nuevo_divpolit">
			<header>
				<h1>Nuevo Paciente</h1>
			</header>
			<section>
				<form is="form-asinc" class="form_divpolit" name="nuevo_paciente" action="pacientes/cargar">
					<fieldset class="datos_paciente">
						<label>
							<span>DNI</span>
							<input type="number" name="dni" required="required" />
						</label>
						<label>
							<span>Apellidos</span>
							<input type="text" name="apellido" required="required" />
						</label>
						<label>
							<span>Nombres</span>
							<input type="text" name="nombre" required="required" />
						</label>
						<label>
							<span>Fecha de Nacimiento</span>
							<input type="date" name="fecha_nacimiento" required="required" />
						</label>
						<fieldset class="grupo_radio">
							<legend>Sexo</legend>

							<label>
								<span>Masculino</span>
								<input type="radio" name="sexo" value="M" />
							</label>
							<label>
								<span>Femenino</span>
								<input type="radio" name="sexo" value="F" />
							</label>
						</fieldset>
						<fieldset class="domicilio">
							<legend>Domicilio</legend>

							<label>
								<span>Departamento</span>
								<select name="departamento"></select>
							</label>
							<label>
								<span>Localidad</span>
								<select name="localidad"></select>
							</label>
							<div class="grupo_radio">
								<label>
									<span>Paraje</span>
									<input type="radio" name="lugar" value="paraje" checked="checked" />
								</label>
								<label>
									<span>Barrio</span>
									<input type="radio" name="lugar" value="barrio" />
								</label>
							</div>
							<div class="select_lugar">
								<select name="paraje" required="required"></select>
								<select name="barrio" required="required" disabled="disabled"></select>
							</div>
							<label>
								<span>Puesto</span>
								<select name="puesto"></select>
							</label>
							<label>
								<span>Direcci&oacute;n</span>
								<input type="text" name="domicilio" />
							</label>
						</fieldset>
						<div class="btn_submit">
							<input type="submit" value="Guardar"/>
							<button type="button" class="btn_cancelar">Cancelar</button>
						</div>
					</fieldset>
				</form>
			</section>
		</ventana-modal>
		<ventana-modal id="nueva_campania" class="vm_nuevo_divpolit">
			<header>
				<h1>Nueva Campa&ntilde;a</h1>
			</header>
			<section>
				<form is="form-asinc" class="form_divpolit" name="nueva_campania" action="/iiet/campanias/cargar">
					<fieldset>
						<label>
							<span>Nombre</span>
							<input type="text" name="etiqueta" required="required" />
						</label>
						<label>
							<span>Fecha de inicio</span>
							<input type="date" name="fecha_inicio" required="required" />
						</label>
						<label>
							<span>Fecha de finalizaci&oacute;n</span>
							<input type="date" name="fecha_fin" required="required" />
						</label>
						<label>
							<span>Departamento</span>
							<select name="departamento"></select>
						</label>
						<label>
							<span>Localidad</span>
							<select name="localidad"></select>
						</label>
						<div class="grupo_radio">
							<label>
								<span>Paraje</span>
								<input type="radio" name="lugar" value="paraje" checked="checked" />
							</label>
							<label>
								<span>Barrio</span>
								<input type="radio" name="lugar" value="barrio" />
							</label>
						</div>
						<div class="select_lugar">
							<select name="paraje" required="required"></select>
							<select name="barrio" required="required" disabled="disabled"></select>
						</div>
						<label>
							<span>
								Escuela
								<input type="checkbox" id="en_escuela" name="en_escuela"/>
							</span>
							<select name="escuela" disabled="disabled"></select>
						</label>
						<div class="btn_submit">
							<input type="submit" value="Guardar"/>
							<button type="button" class="btn_cancelar">Cancelar</button>
						</div>
					</fieldset>
				</form>
			</section>
		</ventana-modal>
	</body>
	<script>

		var vmNuevoDivPolit = document.getElementsByClassName('vm_nuevo_divpolit');
		var formDivPolit = document.getElementsByClassName('form_divpolit');
		var urlListado = '/iiet/division_politica/listado_';

		// formulario NUEVO DEPARTAMENTO
		formDivPolit[0].fcExito = function(e) {
			console.log(e.target.response);
			if(e.target.response.id != null)
				Utils.ajax(urlListado + 'departamentos', [], function(e) {
					for(let i = 1; i < formDivPolit.length; ++i)
						Utils.listarDatosEnSelect(formDivPolit[i].departamento, e.target.response);
				});

			formDivPolit[0].vm.close();
		};

		Utils.ajax(urlListado + 'departamentos', [], function(e) {
			for(let i = 1; i < formDivPolit.length; ++i)
				Utils.listarDatosEnSelect(formDivPolit[i].departamento, e.target.response);
		});

		// listener para el campo DEPARTAMENTO
		for(let i = 2; i < formDivPolit.length; ++i) {
			formDivPolit[i].departamento.addEventListener('change', function(e) {
				var selectDepartamento = e.target,
					selectLocalidad = e.target.form.localidad;

				Utils.obtenerDatosAJAX(selectDepartamento, selectLocalidad, urlListado + 'localidades');
			});
		}

		// listener para el campo LOCALIDAD
		formDivPolit[4].localidad.addEventListener('change', function(e) {
			Utils.obtenerDatosAJAX(e.target, e.target.form.paraje, urlListado + 'parajes');
		});

		/*
			Configuración de formularios asíncronos:
			  - agrega funcionalidad al boton CANCELAR
			  - agrega un listener para cuando la conexión se realizó con éxito
		 */
		for(let i = 0; i < formDivPolit.length; ++i) {
			formDivPolit[i].vm = vmNuevoDivPolit[i];

			let btnCancelar = formDivPolit[i].getElementsByClassName('btn_cancelar')[0];

			(function(form) {
				btnCancelar.addEventListener('click', function(e) {
					form.vm.close();
				});
			})(formDivPolit[i]);

			if(i == 0) continue;

			formDivPolit[i].fcExito = (function(form) {
				return function(e) {
					procesarRespuesta(form, e.target.response);
				}
			})(formDivPolit[i]);
		}

		vmNuevoDivPolit = null;

		function procesarRespuesta(form, respuesta) {
			console.log(respuesta);
			if(respuesta.id != false) {
				form.vm.close();
			}
		}

		var formNuevoPaciente = document.nuevo_paciente,
			formNuevaEscuela = document.nueva_escuela,
			formNuevaCampania = document.nueva_campania,
			fNPLugar = formNuevoPaciente.lugar,
			fNELugar = formNuevaEscuela.lugar,
			fNCLugar = formNuevaCampania.lugar;

		function onChange(e) {
			var radio = e.target,
				opuesto = radio.opuesto;
				form = radio.form,
				select = form[radio.value];

				select.disabled = null;
				form[opuesto.value].disabled = 'disabled';
		}

		formNuevoPaciente.localidad.addEventListener('change', function(e) {
			Utils.obtenerDatosAJAX(e.target, e.target.form.paraje, urlListado + 'parajes');
			Utils.obtenerDatosAJAX(e.target, e.target.form.barrio, urlListado + 'barrios');
		});
		
		fNPLugar[0].addEventListener('change', onChange);
		fNPLugar[0].opuesto = fNPLugar[1];

		fNPLugar[1].addEventListener('change', onChange);
		fNPLugar[1].opuesto = fNPLugar[0];

		formNuevoPaciente.paraje.addEventListener('change', function(e) {
			Utils.obtenerDatosAJAX(e.target, e.target.form.puesto, urlListado + 'puestos');
		});


		formNuevaEscuela.localidad.addEventListener('change', function(e) {
			Utils.obtenerDatosAJAX(e.target, e.target.form.paraje, urlListado + 'parajes');
			Utils.obtenerDatosAJAX(e.target, e.target.form.barrio, urlListado + 'barrios');
		});

		fNELugar[0].addEventListener('change', onChange);
		fNELugar[0].opuesto = fNELugar[1];

		fNELugar[1].addEventListener('change', onChange);
		fNELugar[1].opuesto = fNELugar[0];


		formNuevaCampania.localidad.addEventListener('change', function(e) {
			Utils.obtenerDatosAJAX(e.target, e.target.form.paraje, urlListado + 'parajes');
			Utils.obtenerDatosAJAX(e.target, e.target.form.barrio, urlListado + 'barrios');
		});

		fNCLugar[0].addEventListener('change', onChange);
		fNCLugar[0].opuesto = fNCLugar[1];

		fNCLugar[1].addEventListener('change', onChange);
		fNCLugar[1].opuesto = fNCLugar[0];

		formNuevaCampania.paraje.addEventListener('change', function(e) {
			Utils.obtenerDatosAJAX(e.target, e.target.form.escuela, '/iiet/escuelas/listado_escuelas/paraje');
		});

		formNuevaCampania.barrio.addEventListener('change', function(e) {
			Utils.obtenerDatosAJAX(e.target, e.target.form.escuela, '/iiet/escuelas/listado_escuelas/barrio');
		});


		var enEscuela = document.getElementById('en_escuela');
		enEscuela.addEventListener('change', function(e) {
			this.form.escuela.disabled = this.checked ? null : "disabled";
		});
	</script>
</html>