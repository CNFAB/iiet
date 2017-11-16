<!DOCTYPE html>

<html lang="es">
	<head>
		<title>Intervenciones</title>
		<meta charset="utf-8" />

		<link rel="stylesheet" href="/iiet/assets/css/reset.css" />
		<link rel="stylesheet" href="/iiet/assets/css/variables.css" />
		<link rel="stylesheet" href="/iiet/assets/css/general.css" />
		<link rel="stylesheet" href="/iiet/assets/css/intervenciones.css" />
		<link rel="stylesheet" href="/iiet/assets/css/estilos_copro.css" />
		<link rel="stylesheet" href="/iiet/assets/css/form_asinc.css" />

		<script src="/iiet/assets/js/objetos/PrototipoFormulario.js"></script>
		<link rel="import" href="/iiet/assets/web-components/formularios/form-concentrado.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-mcmaster.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-haradamori.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-baerman.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-placaagar.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-hemograma.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-serologia.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-pcr.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-qpcr.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-medidasantropometricas.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-tratamientoprevio.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-tratamientoactual.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-diagnosticopresuntivo.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-factoresriesgo.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/vm-form-asinc.html" />

		<link rel="import" href="/iiet/assets/web-components/ventana-modal.html" />
		<link rel="import" href="/iiet/assets/web-components/form-asinc.html" />
		<link rel="import" href="/iiet/assets/web-components/wc-paginacion.html" />

		<style>
			wc-paginacion {
				display: block;
			}
		</style>
	</head>
	<body>
		<header>
			<h1>IIET</h1>
			<p>Instituto de Investigaci&oacute;n de Enfermedades Tropicales</p>
		</header>
		<nav id="nav">
			<ul>
				<li>
					<a href="#nueva_campania">Nueva Campa&ntilde;a</a>
				</li>
				<li>
					<a href="#nuevo_paciente">Nuevo Paciente</a>
				</li>
				<li>
					<button type="button" id="buscar_paciente">Buscar Paciente</button>
				</li>
				<li>
					<a href="#">Salir</a>
				</li>
			</ul>
		</nav>
		<aside id="busca_paciente">
			<form is="form-asinc" name="busca_paciente">
				<fieldset disabled="disabled">
					<span>Buscar paciente por</span>
					<select name="filtro">
						<option value="dni">DNI</option>
						<option value="paciente">N° de Paciente</option>
						<option value="apynomb">Apellido y Nombre</option>
						<option value="cuaderno">N° de Cuaderno</option>
					</select>

					<input type="text" id="campo_busqueda" name="busqueda" required="required" />
					<input type="submit" value="Aceptar" />
					<button type="button" id="no_buscar_paciente">Cancelar</button>
				</fieldset>
			</form-asinc>
		</aside>
		<section id="main">
			<form id="form_principal">
				<fieldset class="bloque_1" name="bloque_1">
					<label>Intervenci&oacute;n
						<input type="number" name="intervencion" min="1" />
					</label>
					<label>Tipo de Intervenci&oacute;n
						<select name="tipo_intervencion">
							<option value="CONSULTORIO_EXTERNO">Consultorio Externo</option>
							<option value="CAMPANIA">Campa&ntilde;a en Barrios o Parajes</option>
							<option value="ESCUELAS">Campa&ntilde;a en Escuelas</option>
						</select>
					</label>
					<label>Campa&ntilde;a
						<select name="campania">
							<option>Pichanal 2012</option>
							<option>Solazuty 2012</option>
							<option>Media Luna 2013</option>
							<option>Pichanal 2015</option>
							<option>Solazuty 2017</option>
						</select>
					</label>
				</fieldset>
				<section class="estudio">
					<h2 class="solapa">
						<button type="button">Datos Personales</button>
					</h2>
					<fieldset name="datos_personales" class="contenido" disabled="disabled">
						<div class="bloque_2">
							<label>N° de Paciente
								<input type="number" name="nro_paciente" />
							</label>
							<label>Fecha de Carga
								<input type="date" name="fecha_carga" required="required" />
							</label>
						</div>
						<div class="bloque_3">
							<div class="formulario">
								<span class="etiqueta">Datos del Paciente</span>
								<fieldset class="datos_formulario">
									<label>DNI
										<input type="text" class="numero" name="dni" required="required" />
									</label>
									<label>Apellido
										<input type="text" name="apellido" required="required" />
									</label>
									<label>Nombre
										<input type="text" name="nombre" required="required" />
									</label>
									<label>Fecha de Nacimiento
										<input type="date" name="fecha_nacimiento" required="required" />
									</label>
									<fieldset>
										<legend>Sexo</legend>

										<label>Masculino
											<input type="radio" name="sexo" value="M" />
										</label>
										<label>Femenino
											<input type="radio" name="sexo" value="F" />
										</label>
									</fieldset>
								</fieldset>
							</div>
						</div>
					</fieldset>
				</section>
				<section class="estudio">
					<h2 class="solapa">
						<button type="button">Intervenci&oacute;n</button>
					</h2>
					<fieldset name="intervenciones" class="contenido" disabled="disabled">
						<div class="bloque_2">
							<label>Localidad dentro del Paraje
								<select name="localidad_paraje">
									<option></option>
									<option>Localidad 1</option>
									<option>Localidad 2</option>
									<option>Localidad 3</option>
								</select>
							</label>
							<label>Domicilio
								<input type="text" name="domicilio" />
							</label>
						</div>
						<div class="bloque_3">
							<form-diagnosticopresuntivo class="formulario">
							</form-diagnosticopresuntivo>
							<form-factoresriesgo class="formulario" id="factores_riesgo">
							</form-factoresriesgo>
						</div>
					</fieldset>
				</section>
				<section class="estudio primer_plano">
					<h2 class="solapa">
						<button type="button">Copro</button>
					</h2>
					<wc-paginacion name="copro" class="contenido"></wc-paginacion>
					<!--<fieldset name="copro" class="contenido">
						<div class="bloque_2">
							<label>Fecha
								<input type="date" name="fecha" required="required" />
							</label>
							<label>N° de Cuaderno
								<input type="number" name="nro_cuaderno" min="1" />
							</label>
							<label>Peso de la Muestra
								<input type="text" name="peso_materia" pattern="^\d*(\.\d{1,2})?$" />
							</label>
							<label id="consistencia_materia">Consistencia
								<select name="consistencia_materia">
									<option></option>
									<option value="SOLIDA">S&oacute;lida</option>
									<option value="PASTOSA">Pastosa</option>
									<option value="LIQUIDA">L&iacute;quida</option>
								</select>
							</label>
						</div>
						<div class="bloque_3">
							<form-concentrado class="formulario"></form-concentrado>
							<form-mcmaster class="formulario" id="mc_master"></form-mcmaster>
						</div>
						<div class="bloque_4">
							<form-haradamori class="formulario" id="harada_mori"></form-haradamori>
							<form-baerman class="formulario" id="baerman"></form-baerman>
							<form-placaagar class="formulario" id="placa_agar"></form-placaagar>
						</div>
					</fieldset>-->
					<div class="no_planilla" style="display: none;">
						<div>
							<p>No se cre&oacute; un coproparasitol&oacute;gico para esta intervenci&oacute;n</p>
							<button type="button">Crear nuevo coproparasitol&oacute;gico</button>
						</div>
					</div>
				</section>
				<section class="estudio">
					<h2 class="solapa">
						<button type="button">Sangre</button>
					</h2>
					<fieldset name="sangre" class="contenido" disabled="disabled">
						<div class="bloque_2">
							<label>Fecha
								<input type="date" name="fecha" required="required" />
							</label>
							<label>N° de Tubo
								<input type="text" name="nro_tubo" pattern="^[A-Z]{2,4}-\d{1,5}-\d{2}$" required="required" />
							</label>
						</div>
						<div class="bloque_3">
							<form-hemograma class="formulario" id="hemograma">
							</form-hemograma>
							<form-serologia class="formulario" id="serologia">
							</form-serologia>
						</div>
					</fieldset>
					<div class="no_planilla" style="display: none;">
						<div>
							<p>No se realiz&oacute; an&aacute;lisis de sangre para esta intervenci&oacute;n</p>
							<button type="button">Crear nuevo an&aacute;lisis de sangre</button>
						</div>
					</div>
				</section>
				<section class="estudio">
					<h2 class="solapa">
						<button type="button">Biolog&iacute;a Molecular</button>
					</h2>
					<fieldset name="biologia_molecular" class="contenido" disabled="disabled">
						<div class="bloque_2">
							<label>Fecha
								<input type="date" name="fecha" required="required" />
							</label>
							<label>Fuente
								<select name="fuente" required="required">
									<option value="materia_fecal">Materia Fecal</option>
									<option value="orina">Orina</option>
								</select>
							</label>
						</div>
						<div class="bloque_3">
							<form-pcr class="formulario" id="pcr">
							</form-pcr>
							<form-qpcr class="formulario" id="qpcr">
							</form-qpcr>
						</div>
					</fieldset>
				</section>
				<section class="estudio">
					<h2 class="solapa">
						<button type="button">Medidas Antropom&eacute;tricas</button>
					</h2>
					<fieldset name="medidas_antropometricas" class="contenido" disabled="disabled">
						<div class="bloque_2">
							<label>Fecha
								<input type="date" name="fecha" required="required" />
							</label>
						</div>
						<div class="bloque_3">
							<form-medidasantropometricas class="formulario" id="medidas_antropometricas">
							</form-medidasantropometricas>
						</div>
					</fieldset>
					<!--<div class="no_planilla">
						<div>
							<p>No se realiz&oacute; medidas antropom&eacute;tricas para esta intervenci&oacute;n</p>
							<button type="button">Crear nuevas medidas antropom&eacute;tricas</button>
						</div>-->
					</div>
				</section>
				<section class="estudio">
					<h2 class="solapa">
						<button type="button">Tratamientos</button>
					</h2>
					<fieldset name="tratamientos" class="contenido" disabled="disabled">
						<div class="bloque_2">
							<label>Fecha
								<input type="date" name="fecha" required="required" />
							</label>
						</div>
						<div class="bloque_3">
							<form-tratamientoprevio class="formulario" id="tratamiento_previo">
							</form-tratamientoprevio>
							<form-tratamientoactual class="formulario" id="tratamiento_actual">
							</form-tratamientoactual>
						</div>
					</fieldset>
					<div class="no_planilla">
						<div>
							<p>No se realiz&oacute; tratamiento para esta intervenci&oacute;n</p>
							<button type="button">Crear nuevo tratamiento</button>
						</div>
					</div>
				</section>
			</form>
		</section>
		<aside id="reg_operaciones">
			<button type="button" id="btn_nuevo" title="Nuevo"></button>
			<button type="button" id="btn_editar" title="Editar"></button>
			<button type="button" id="btn_deshacer" title="Deshacer"></button>
			<button type="button" id="btn_eliminar" title="Eliminar"></button>
			<button type="submit" id="btn_guardar" title="Guardar"></button>
		</aside>
		<aside id="ventanas_modales"></aside>

		<template id="t_msj_no_estudio">
			<div class="cont1_msj_no_estudio">
				<div class="cont2_msj_no_estudio">
					<p class="msj_no_estudio"></p>
					<button type="button" class="btn_agregar_estudio"></button>
				</div>
			</div>
		</template>
	</body>
	<script src="/iiet/assets/js/intervenciones.js"></script>
	<script>
		var buscaPaciente = document.getElementById("busca_paciente").children[0];
		var btnBuscPaciente = document.getElementById("buscar_paciente");
		var btnNoBuscPaciente = document.getElementById("no_buscar_paciente");

		btnBuscPaciente.addEventListener("click", function(e) {
			buscaPaciente.className = "desplegar";
			buscaPaciente.children[0].disabled = null;
		});

		btnNoBuscPaciente.addEventListener("click", function(e) {
			buscaPaciente.className = "ocultar";
			buscaPaciente.children[0].disabled = "disabled";
		});
	</script>
</html>