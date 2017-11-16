<!DOCTYPE html>

<html lang="es">
	<head>
		<title>Intervenciones</title>
		<meta charset="utf-8" />

		<link rel="stylesheet" href="assets/css/reset.css" />
		<link rel="stylesheet" href="assets/css/variables.css" />
		<link rel="stylesheet" href="assets/css/general.css" />
		<link rel="stylesheet" href="assets/css/intervenciones.css" />
		<link rel="stylesheet" href="assets/css/estilos_copro.css" />
		<link rel="stylesheet" href="assets/css/form_asinc.css" />

		<script src="assets/js/PrototipoFormulario.js"></script>
		<link rel="import" href="assets/web-components/formularios/form-concentrado.php" />
		<link rel="import" href="assets/web-components/formularios/form-mcmaster.html" />
		<link rel="import" href="assets/web-components/formularios/form-haradamori.html" />
		<link rel="import" href="assets/web-components/formularios/form-baerman.html" />
		<link rel="import" href="assets/web-components/formularios/form-placaagar.html" />
		<link rel="import" href="assets/web-components/formularios/form-hemograma.html" />
		<link rel="import" href="assets/web-components/formularios/form-serologia.html" />
		<link rel="import" href="assets/web-components/formularios/form-pcr.html" />
		<link rel="import" href="assets/web-components/formularios/form-qpcr.html" />
		<link rel="import" href="assets/web-components/formularios/form-medidasantropometricas.html" />
		<link rel="import" href="assets/web-components/formularios/form-tratamientoprevio.html" />
		<link rel="import" href="assets/web-components/formularios/form-tratamientoactual.html" />
		<link rel="import" href="assets/web-components/formularios/form-diagnosticopresuntivo.html" />
		<link rel="import" href="assets/web-components/formularios/form-factoresriesgo.html" />

		<link rel="import" href="assets/web-components/ventana-modal.html" />
		<link rel="import" href="assets/web-components/form-asinc.html" />
		<link rel="import" href="assets/web-components/wc-paginacion.html" />
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
			<form is="form-asinc" method="POST" name="busca_paciente">
				<fieldset disabled="disabled" name="f1">
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
			</form>
		</aside>
		<aside>
			<ventana-modal id="nueva_campania">
				<header class="vm_titulo">
					<h1>Nueva Campa&ntilde;a</h1>
				</header>
				<section>
					<form is="form-asinc" name="nueva_campania">
						<fieldset class="campania">
							<label>Etiqueta
								<input type="text" name="etiqueta" required="required" />
							</label>
							<label>Fecha de Inicio
								<input type="date" name="fecha_inicio" required="required" />
							</label>
							<label>Fecha de Finalizaci&oacute;n
								<input type="date" name="fecha_fin" required="required" />
							</label>
							<label>Departamento
								<select name="departamento">
									<option>Or&aacute;n</option>
									<option>San Mart&iacute;n</option>
								</select>
							</label>
							<label>Localidad
								<select name="localidad">
									<option>San Ram&oacute;n de la Nueva Or&aacute;n</option>
									<option>Pichanal</option>
									<option>Colonia Santa Rosa</option>
									<option>Urundel</option>
								</select>
							</label>
							<div class="grupo_radio">
								<label>Paraje
									<input type="radio" id="r_paraje" name="lugar" value="PARAJE" checked="checked" />
								</label>
								<label>Barrio
									<input type="radio" name="lugar" value="BARRIO" />
								</label>
							</div>
							<div class="select_lugar">
								<select name="paraje" required="required">
									<option>Solazuty</option>
									<option>Media Luna</option>
									<option>Otro Paraje</option>
								</select>
								<select name="barrio" required="required" disabled="disabled">
									<option>Barrio 1</option>
									<option>Barrio 2</option>
									<option>Barrio 3</option>
								</select>
							</div>
							<label id="chk_escuela">Escuela
								<input type="checkbox" name="en_escuela" />
							</label>
							<select name="escuela" required="required" disabled="disabled">
								<option>Escuela N° 1</option>
								<option>Escuela N° 2</option>
								<option>Escuela N° 3</option>
							</select>
							<div class="submit">
								<input type="submit" value="Guardar" />
								<input type="reset" value="Cancelar" />
							</div>
						</fieldset>
					</form>
				</section>
			</ventana-modal>
			<ventana-modal id="nuevo_paciente">
				<header class="vm_titulo">
					<h1>Nuevo Paciente</h1>
				</header>
				<section>
					<form is="form-asinc" name="nuevo_paciente">
						<fieldset class="datos_paciente">
							<label>DNI
								<input type="number" name="dni" required="required" />
							</label>
							<label>Apellidos
								<input type="text" name="apellido" required="required" />
							</label>
							<label>Nombres
								<input type="text" name="nombre" required="required" />
							</label>
							<label>Fecha de Nacimiento
								<input type="date" name="fecha_nacimiento" required="required" />
							</label>
							<fieldset class="grupo_radio">
								<legend>Sexo</legend>

								<label>Masculino
									<input type="radio" name="sexo" value="MASCULINO" />
								</label>
								<label>Femenino
									<input type="radio" name="sexo" value="FEMENINO" />
								</label>
							</fieldset>
							<fieldset>
								<legend>Domicilio</legend>

								<label>Departamento
									<select name="departamento">
										<option>Or&aacute;n</option>
										<option>San Mart&iacute;n</option>
									</select>
								</label>
								<label>Localidad
									<select name="localidad">
										<option>San Ram&oacute;n de la Nueva Or&aacute;n</option>
										<option>Pichanal</option>
										<option>Colonia Santa Rosa</option>
										<option>Urundel</option>
									</select>
								</label>
								<div class="grupo_radio">
									<label>Paraje
										<input type="radio" id="r_paraje" name="lugar" value="PARAJE" checked="checked" />
									</label>
									<label>Barrio
										<input type="radio" name="lugar" value="BARRIO" />
									</label>
								</div>
								<div class="select_lugar">
									<select name="paraje" required="required">
										<option>Solazuty</option>
										<option>Media Luna</option>
										<option>Otro Paraje</option>
									</select>
									<select name="barrio" required="required" disabled="disabled">
										<option>Barrio 1</option>
										<option>Barrio 2</option>
										<option>Barrio 3</option>
									</select>
								</div>
								<label>Direcci&oacute;n
									<input type="text" name="domicilio" />
								</label>
							</fieldset>
							<div class="submit">
								<input type="submit" value="Guardar" />
								<input type="reset" value="Cancelar" />
							</div>
						</fieldset>
					</form>
				</section>
			</ventana-modal>
		</aside>
	</body>
	<script src="assets/js/intervenciones.js"></script>
	<script src="assets/js/ini_view_estudios.js"></script>
</html>