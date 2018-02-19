<!DOCTYPE html>

<html>
	<head>
		<title><?= $estudio_nombre ?></title>
		<meta charset="utf-8"/>

		<link rel="stylesheet" href="/iiet/assets/css/reset.css" />
		<link rel="stylesheet" href="/iiet/assets/css/variables.css" />
		<link rel="stylesheet" href="/iiet/assets/css/general.css"/>
		<link rel="stylesheet" href="/iiet/assets/css/forms_estudios.css"/>
		<link rel="stylesheet" href="/iiet/assets/css/t_form_asinc.css"/>
		<link rel="stylesheet" href="/iiet/assets/css/carga_estudios_campania.css"/>

		<script src="/iiet/assets/js/Utils.js"></script>
		<link rel="import" href="/iiet/assets/web-components/ventana-modal.html" />
		<link rel="import" href="/iiet/assets/web-components/form-asinc.html" />
		<link rel="import" href="/iiet/assets/web-components/templates/t_form-asinc.html" />

		<script src="/iiet/assets/js/PrototipoFormulario.js"></script>
		<link rel="import" href="/iiet/assets/web-components/formularios/form-concentrado.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-mcmaster.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-haradamori.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-baerman.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-placaagar.html" />

		<link rel="import" href="/iiet/assets/web-components/formularios/form-haradamori.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-hemograma.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-serologia.html" />

		<link rel="import" href="/iiet/assets/web-components/formularios/form-pcr.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-qpcr.html" />

		<link rel="import" href="/iiet/assets/web-components/formularios/form-tratamientoactual.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-medidasantropometricas.html" />
		<link rel="import" href="/iiet/assets/web-components/formularios/form-tratamientoprevio.html" />
	</head>
	<body>
		<header id="cabecera_principal">
			<h2>IIET</h2>
			<div>
				<span>Instituto de Investigaci&oacute;n de</span>
				<span>Enfermedades Tropicales</span>
			</div>
			<h1><?= $estudio_nombre ?> (Campa&ntilde;a)</h1>
		</header>
		<div id="cont_datos">
			<div id="datos_campania">
				<h2>Campa&ntilde;a</h2>
				<div>
					<p><span>Lugar:</span><span id="lugar_campania"></span></p>
					<p><span>Fecha de inicio:</span><span id="camp_f_ini"></span></p>
				</div>
				<div>
					<p><span>Nombre:</span><span id="nombre_campania"></span></p>
					<p><span>Fecha de fin:</span><span id="camp_f_fin"></span></p>
				</div>
			</div>
			<div id="datos_paciente">
				<h2>Paciente</h2>
				<div class="grp_campos">
					<div id="grp_busqueda">
						<div id="campo_busqueda">
							<span>Buscar por:</span>
							<select id="buscar_por">
								<option value="apynomb">Apellido y Nombre</option>
								<option value="dni">DNI</option>
							</select>
						</div>
						<div id="cont_input">
							<input type="text" id="valor_busqueda" list="lista_pacientes" />
							<ul class="datalist oculto"></ul>
						</div>
						<a href="#form_paciente" id="crear_paciente" class="oculto">
							<img src="/iiet/assets/images/ic_nuevo_paciente.png"/>Crear Paciente</a>
					</div>
				</div>
			</div>
		</div>
		<section>
			<?= $estudio_form ?>
		</section>
		<aside id="wrapper_msj_ini">
			<div>
				<p>Para continuar debe seleccionar la campa&ntilde;a que desea cargar.</p>
				<a href="#form_selec_campania" class="btn">Seleccionar Campa&ntilde;a</a>
			</div>
		</aside>
		<a href="/iiet" id="btn_salir" title="Salir a Inicio"></a>
		<aside id="otros_estudios">
			<a href="/iiet/estudios/campania/copro" title="Copro"></a>
			<a href="/iiet/estudios/campania/sangre" title="Sangre"></a>
			<a href="/iiet/estudios/campania/biologmolec" title="Biología Molecular"></a>
			<a href="/iiet/estudios/campania/tratamiento" title="Tratamiento"></a>
		</aside>
		<aside id="cont_vmform"></aside>
		<div id="estado_guardar">
			<span></span>
			<span></span>
		</div>
	</body>
	<script src="/iiet/assets/js/iniciar_carga_estudios.js"></script>
	<script>
		iniciarCargaEstudios(true);
	</script>
</html>