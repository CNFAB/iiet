<!DOCTYPE html>

<html lang="es">
	<head>
		<title>Selecci&oacute;n</title>
		<meta charset="utf-8"/>

		<link rel="stylesheet" href="/iiet/assets/css/reset.css" />
		<link rel="stylesheet" href="/iiet/assets/css/variables.css" />
		<link rel="stylesheet" href="/iiet/assets/css/estilos_index.css" />
		<link rel="stylesheet" href="/iiet/assets/css/general.css">
		<link rel="stylesheet" href="/iiet/assets/css/t_form_asinc.css">

		<script src="/iiet/assets/js/Utils.js"></script>

		<link rel="import" href="/iiet/assets/web-components/templates/t_form-asinc.html" />

		<link rel="import" href="/iiet/assets/web-components/ventana-modal.html" />
		<link rel="import" href="/iiet/assets/web-components/form-asinc.html" />

		<style>
		</style>
	</head>
	<body>
		<header>
			<h1>IIET</h1>
			<span>Instituto de Investigaci&oacute;n de Enfermedades Tropicales</span>
		</header>
		<section id="nuevo">
			<h2><span>Nuevo</span></h2>

			<div class="grp_btns">
				<a class="btn_nuevo" href="#nueva_campania">
					<p>Nueva</p>
					<p>Campa&ntilde;a</p>
				</a>
				<a class="btn_nuevo" href="#">
					<p>Nueva</p>
					<p>Intervenci&oacute;n</p>
				</a>
				<a class="btn_nuevo" href="#nuevo_paciente">
					<p>Nuevo</p>
					<p>Paciente</p>
				</a>
			</div>
		</section>
		<section id="agregar">
			<h2><span>Agregar &oacute; Actualizar Datos</span></h2>

			<div class="grp_campos">
				<div id="grp_busqueda">
					<div id="campo_busqueda">
						<span>Buscar por:</span>
						<select id="buscar_por">
							<option value="apynomb">Apellido y Nombre</option>
							<option value="dni">DNI</option>
						</select>
					</div>
					<input type="text" id="valor_busqueda" list="lista_pacientes" />
					<a href="#nuevo_paciente" id="crear_paciente" class="oculto">
						<img src="/iiet/assets/images/nuevo_paciente.png"/>Crear Paciente</a>
				</div>

				<datalist id="lista_pacientes"></datalist>
			</div>

			<div class="grp_btns">
				<a class="btn_nuevo" href="#nueva_campania">
					<p>Copro</p>
				</a>
				<a class="btn_nuevo" href="#">
					<p>Sangre</p>
				</a>
				<a class="btn_nuevo" href="#nuevo_paciente">
					<p>Biolog&iacute;a Molecular</p>
				</a>
				<a class="btn_nuevo" href="#nuevo_paciente">
					<p>Tratamiento</p>
				</a>
			</div>
		</section>
		<aside id="cont_vform"></aside>
	</body>
	<script>
		var input            = document.getElementById('valor_busqueda'),
			listaPacientes   = document.getElementById('lista_pacientes'),
			selectFiltro     = document.getElementById('buscar_por'),
			btnCrearPaciente = document.getElementById('crear_paciente'),
			contVMForm       = document.getElementById('cont_vform');

		var fNuevoPaciente     = formNuevoPaciente(contVMForm),
			fNuevoDepartamento = formNuevoDepartamento(contVMForm),
			fNuevaLocalidad    = formNuevaLocalidad(contVMForm),
			fNuevoBarrio       = formNuevoBarrio(contVMForm),
			fNuevoParaje       = formNuevoParaje(contVMForm),
			fNuevoParaje       = formNuevoParaje(contVMForm),
			fNuevoPuesto       = formNuevoPuesto(contVMForm),
			fNuevaEscuela      = formNuevaEscuela(contVMForm),
			fNuevaCampania     = formNuevaCampania(contVMForm);

		input.addEventListener('input', function(e) {
			var i, datos, campoFiltro, valorFiltro;

			valorFiltro = this.value;

			valorFiltro = valorFiltro.replace(/^(\s+|,)/, '');
			valorFiltro = valorFiltro.replace(/^([a-z])/, $1 => $1.toUpperCase());
			valorFiltro = valorFiltro.replace(/\s+/g, ' ');
			valorFiltro = valorFiltro.replace(/\s,/g, ',');
			valorFiltro = valorFiltro.replace(/(?<=,)\w/g, $1 => ' ' + $1);
			valorFiltro = valorFiltro.replace(/\s([a-z])/g, $1 => $1.toUpperCase());

			i = selectFiltro.selectedIndex;
			campoFiltro = selectFiltro.item(i).value;
			this.value = valorFiltro;

			if(valorFiltro === '') {
				listaPacientes.innerHTML = '';
				btnCrearPaciente.className = 'oculto';

				return;
			}

			datos = new Map([
				['campo_filtro', campoFiltro],
				['valor_filtro', valorFiltro]
			]);

			Utils.ajax('/iiet/pacientes/filtrar_pacientes', datos, function(e) {
				var respuesta = e.target.response;

				if(respuesta.length > 0)
					listarPacientes(respuesta, campoFiltro);

				else
					btnCrearPaciente.className = '';
			});
		});

		selectFiltro.addEventListener('change', function(e) {
			input.value = '';
			listaPacientes.innerHTML = '';
			btnCrearPaciente.className = 'oculto';
		});

		btnCrearPaciente.addEventListener('click', function(e) {
			var i = selectFiltro.selectedIndex;
			var filtro = selectFiltro.item(i).value;

			this.className = 'oculto';

			if(filtro == 'apynomb') {
				let nombres = input.value.split(/\s*,\s*/);

				fNuevoPaciente.apellido.value = nombres[0];
				fNuevoPaciente.nombre.value = nombres[1] || '';
			}

			else
				fNuevoPaciente.dni.value = input.value;

			input.value = '';
			btnCrearPaciente.className = 'oculto';
		});

		function listarPacientes(lista, campoFiltro) {
			listaPacientes.innerHTML = '';

			for(let item of lista) {
				let nombres, option;

				nombres = item['apellido'] + ', ' + item['nombre'];

				if(campoFiltro == 'apynomb')
					option = new Option(item['dni'], nombres);

				else
					option = new Option(nombres, item['dni']);

				option.dataset.numero = item['numero'];
				listaPacientes.appendChild(option);
			}

			btnCrearPaciente.className = 'oculto';
		}

		fNuevoPaciente.fcExito = function(e) {
			var respuesta = e.target.response;

			if(respuesta !== false) {
				let lista = [{
					numero: respuesta.id,
					dni: fNuevoPaciente.dni.value,
					apellido: fNuevoPaciente.apellido.value,
					nombre: fNuevoPaciente.nombre.value
				}];

				listarPacientes(lista, 'apynomb');

				selectFiltro.selectedIndex = 0;
				input.value = fNuevoPaciente.apellido.value + ', ' + fNuevoPaciente.nombre.value;
				
				fNuevoPaciente.reset();
			}
		};
		
	</script>
</html>
