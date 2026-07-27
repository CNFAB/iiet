<!DOCTYPE html>

<html lang="es">
<head>
	<title>Consultas</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/datatables.min.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/consultas_campanias.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>
</head>
<body>
<header class="mb-5">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
			<h2 class="col-6">Consultas por Pacientes</h2>
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="links" class="navbar-collapse collapse justify-content-end">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="/iiet/inicio/consultor">Inicio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/iiet/consultas/campanias">Campa&ntilde;as</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/iiet/consultas/consult_ext">Consultorio Externo</a>
					</li>
					<li class="nav-item mr-3">
						<a class="nav-link active" href="#">Pacientes</a>
					</li>
					<li class="nav-item ml-5">
						<div id="perfil-usuario" class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-user-circle fa-lg"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right p-4">
								<h4 class="mb-3"><?= $usuario ?></h4>
								<div class="mb-4 text-center">
									<p class="mb-2 text-left">Rol:</p>
									<?php if($cant_rol === 1): ?>
										<p class="ml-4 text-left"><?= $rol ?></p>
									<?php else: ?>
									<div class="btn-group btn-group-sm">
										<?php if(isset($admin)): ?>
											<a href="/iiet/inicio/admin" class="conmutador btn" title="Cambiar al panel del Administrador">Admin</a>
										<?php endif; ?>
										<?php if(isset($operario)): ?>
											<a href="/iiet/inicio/operario" class="conmutador btn" title="Cambiar al panel del Operario">Operario</a>
										<?php endif; ?>
										<?php if(isset($consultor)): ?>
											<button type="button" class="conmutador btn disabled">Consultor</button>
										<?php endif; ?>
									</div>
									<?php endif; ?>
								</div>
								<a href="/iiet/usuarios/perfil">Ver perfil</a>
								<div class="text-center">
									<a href="/iiet/usuarios/logout" class="btn fa fa-power-off cerrar-sesion" title="Salir"></a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>
<section class="container pb-5">
	<form name="formRestricciones">
		<fieldset class="form-group">
			<legend class="col-form-legend">Restricci&oacute;n por Lugar</legend>
			<div class="form-row">
				<div class="col-4">
					<fieldset class="form-group">
						<legend class="col-form-legend">Por Departamentos</legend>
						<div class="form-row">
							<div class="col">
								<ul id="list-dptos-datos-sel" class="lista-datos-sel list-group list-group-flush mb-2">
									<li class="item-vacio">
										<p>No hay datos seleccionados</p>
									</li>
								</ul>
								<div class="text-right">
									<button type="button" class="btn btn-primary fas fa-edit fa-1x" title="Editar" data-toggle="modal" data-target="#consult-selec-dptos" data-keyboard="false" data-backdrop="static"></button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="col-4">
					<fieldset class="form-group">
						<legend class="col-form-legend">Por Localidades</legend>
						<div class="form-row">
							<div class="col">
								<ul id="list-localidades-datos-sel" class="lista-datos-sel list-group list-group-flush mb-2">
									<li class="item-vacio">
										<p>No hay datos seleccionados</p>
									</li>
								</ul>
								<div class="text-right">
									<button type="button" class="btn btn-primary fas fa-edit fa-1x" title="Editar" data-toggle="modal" data-target="#consult-selec-localidades" data-keyboard="false" data-backdrop="static"></button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="col-4">
					<fieldset class="form-group">
						<legend class="col-form-legend">Por Barrios</legend>
						<div class="form-row">
							<div class="col">
								<ul id="list-barrios-datos-sel" class="lista-datos-sel list-group list-group-flush mb-2">
									<li class="item-vacio">
										<p>No hay datos seleccionados</p>
									</li>
								</ul>
								<div class="text-right">
									<button type="button" class="btn btn-primary fas fa-edit fa-1x" title="Editar" data-toggle="modal" data-target="#consult-selec-barrios" data-keyboard="false" data-backdrop="static"></button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="col-4">
					<fieldset class="form-group">
						<legend class="col-form-legend">Por Parajes</legend>
						<div class="form-row">
							<div class="col">
								<ul id="list-parajes-datos-sel" class="lista-datos-sel list-group list-group-flush mb-2">
									<li class="item-vacio">
										<p>No hay datos seleccionados</p>
									</li>
								</ul>
								<div class="text-right">
									<button type="button" class="btn btn-primary fas fa-edit fa-1x" title="Editar" data-toggle="modal" data-target="#consult-selec-parajes" data-keyboard="false" data-backdrop="static"></button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="col-4">
					<fieldset class="form-group">
						<legend class="col-form-legend">Por Puestos</legend>
						<div class="form-row">
							<div class="col">
								<ul id="list-puestos-datos-sel" class="lista-datos-sel list-group list-group-flush mb-2">
									<li class="item-vacio">
										<p>No hay datos seleccionados</p>
									</li>
								</ul>
								<div class="text-right">
									<button type="button" class="btn btn-primary fas fa-edit fa-1x" title="Editar" data-toggle="modal" data-target="#consult-selec-puestos" data-keyboard="false" data-backdrop="static"></button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="col-4">
					<fieldset class="form-group">
						<legend class="col-form-legend">Por Instituciones en Barrios</legend>
						<div class="form-row">
							<div class="col">
								<ul id="list-instit-barrios-datos-sel" class="lista-datos-sel list-group list-group-flush mb-2">
									<li class="item-vacio">
										<p>No hay datos seleccionados</p>
									</li>
								</ul>
								<div class="text-right">
									<button type="button" class="btn btn-primary fas fa-edit fa-1x" title="Editar" data-toggle="modal" data-target="#consult-selec-instit-barrios" data-keyboard="false" data-backdrop="static"></button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="col-4">
					<fieldset class="form-group">
						<legend class="col-form-legend">Por Instituciones en Parajes</legend>
						<div class="form-row">
							<div class="col">
								<ul id="list-instit-parajes-datos-sel" class="lista-datos-sel list-group list-group-flush mb-2">
									<li class="item-vacio">
										<p>No hay datos seleccionados</p>
									</li>
								</ul>
								<div class="text-right">
									<button type="button" class="btn btn-primary fas fa-edit fa-1x" title="Editar" data-toggle="modal" data-target="#consult-selec-instit-parajes" data-keyboard="false" data-backdrop="static"></button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</fieldset>
		<fieldset class="form-group">
			<legend class="col-form-legend">Restricci&oacute;n por Fecha de Realizaci&oacute;n</legend>
			<div class="form-row justify-content-center">
				<div class="col-6">
					<fieldset class="form-group">
						<legend class="col-form-legend">Fecha</legend>
						<div class="form-row">
							<div class="col">
								<ul id="list-fechas-datos-sel" class="lista-datos-sel list-group list-group-flush mb-2">
									<li class="item-vacio">
										<p>No hay datos seleccionados</p>
									</li>
								</ul>
								<div class="text-right">
									<button type="button" class="btn btn-primary fas fa-edit fa-1x" title="Editar" data-toggle="modal" data-target="#consult-selec-fechas" data-keyboard="false" data-backdrop="static"></button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</fieldset>
		<fieldset class="form-group">
			<legend class="col-form-legend">Restricci&oacute;n por Datos del Paciente</legend>
			<div class="form-row">
				<div class="col-4">
					<fieldset class="form-group">
						<legend class="col-form-legend">Sexo</legend>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" name="sexo" value="MASCULINO" class="custom-control-input" id="pac-sex-m" checked />
							<label for="pac-sex-m" class="custom-control-label">Masculino</label>
						</div>
						<div class="custom-control custom-checkbox custom-control-inline">
							<input type="checkbox" name="sexo" value="FEMENINO" class="custom-control-input" id="pac-sex-f" checked />
							<label for="pac-sex-f" class="custom-control-label">Femenino</label>
						</div>
					</fieldset>
				</div>
				<div class="col-4">
					<fieldset class="form-group">
						<legend class="col-form-legend">Edad</legend>
						<div class="form-row">
							<div class="col">
								<ul id="list-edades-datos-sel" class="lista-datos-sel list-group list-group-flush mb-2">
									<li class="item-vacio">
										<p>No hay datos seleccionados</p>
									</li>
								</ul>
								<div class="text-right">
									<button type="button" class="btn btn-primary fas fa-edit fa-1x" title="Editar" data-toggle="modal" data-target="#consult-selec-edades" data-keyboard="false" data-backdrop="static"></button>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</fieldset>
		<fieldset class="form-group">
			<legend class="col-form-legend">Se haya realizado</legend>
			<div class="form-row">
				<div class="col-3">
					<fieldset class="form-group">
						<legend class="col-form-legend">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="checkCopro" class="custom-control-input" id="check-copro">
								<label class="custom-control-label font-weight-bold" for="check-copro">Copro</label>
							</div>
						</legend>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkConcentrado" class="custom-control-input" id="met-concentrado">
							<label class="custom-control-label" for="met-concentrado">Concentrado</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkMcMaster" class="custom-control-input" id="met-mc-master">
							<label class="custom-control-label" for="met-mc-master">Mc Master</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkHaradaMori" class="custom-control-input" id="met-harada-mori">
							<label class="custom-control-label" for="met-harada-mori">Harada y Mori</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkBaerman" class="custom-control-input" id="met-baerman">
							<label class="custom-control-label" for="met-baerman">Baerman</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkPlacaAgar" class="custom-control-input" id="met-placa-agar">
							<label class="custom-control-label" for="met-placa-agar">Placa de Agar</label>
						</div>
					</fieldset>
				</div>
				<div class="col-3">
					<fieldset class="form-group">
						<legend class="col-form-legend">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="checkSangre" class="custom-control-input" id="check-sangre">
								<label class="custom-control-label font-weight-bold" for="check-sangre">Sangre</label>
							</div>
						</legend>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkHemograma" class="custom-control-input" id="est-hemograma">
							<label class="custom-control-label" for="est-hemograma">Hemograma</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkSerologia" class="custom-control-input" id="est-serologia">
							<label class="custom-control-label" for="est-serologia">Serolog&iacute;a Strongyloides</label>
						</div>
					</fieldset>
				</div>
				<div class="col-3">
					<fieldset class="form-group">
						<legend class="col-form-legend">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="checkBiologMolec" class="custom-control-input" id="check-biologmolec">
								<label class="custom-control-label font-weight-bold" for="check-biologmolec">Biolog&iacute;a Molecular</label>
							</div>
						</legend>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkPCR" class="custom-control-input" id="est-pcr">
							<label class="custom-control-label" for="est-pcr">PCR</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkQPCR" class="custom-control-input" id="est-qpcr">
							<label class="custom-control-label" for="est-qpcr">qPCR</label>
						</div>
					</fieldset>
				</div>
				<div class="col-3">
					<fieldset class="form-group">
						<legend class="col-form-legend">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="checkTratamiento" class="custom-control-input" id="check-tratamiento">
								<label class="custom-control-label font-weight-bold" for="check-tratamiento">Tratamiento</label>
							</div>
						</legend>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkMedidas" class="custom-control-input" id="med-antrop">
							<label class="custom-control-label" for="med-antrop">Medidas Antropom&eacute;tricas</label>
						</div>
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="checkTratPrevio" class="custom-control-input" id="real-trat-previo">
							<label class="custom-control-label" for="real-trat-previo">Tratamiento Previo</label>
						</div>
						<!-- <div class="custom-control custom-checkbox">
							<input type="checkbox" name="real_trat" class="custom-control-input" id="real-trat" checked>
							<label class="custom-control-label" for="real-trat">Tratamiento</label>
						</div> -->
					</fieldset>
				</div>
			</div>
		</fieldset>
	</form>
	<button type="button" id="btn-listo" class="btn btn-circle fas fa-chevron-right" title="Ir a selección de campos"></button>
</section>
<header class="mb-4 d-none">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
			<h2 class="col-9">Consultas por Pacientes</h2>
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="links" class="col-3 navbar-collapse collapse justify-content-end">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a id="btn-atras" class="nav-link" href="#" title="Volver a la restricci&oacute;n de datos"><span class="fa fa-arrow-circle-left mr-1"></span> Atras</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>
<section class="container-fluid pr-4 pb-4 pl-4 d-none">
	<div class="row">
		<div class="col">
			<h2>Exportar</h2>
		</div>
	</div>
	<form action="/iiet/consultas/exportar_consulta_pacientes/" method="POST" name="formCamposConsulta">
		<!-- <input type="hidden" name="campanias"/> -->
		<input type="hidden" name="departamentos"/>
		<input type="hidden" name="localidades"/>
		<input type="hidden" name="barrios"/>
		<input type="hidden" name="parajes"/>
		<input type="hidden" name="puestos"/>
		<input type="hidden" name="instituciones"/>
		<input type="hidden" name="fechas"/>
		<input type="hidden" name="edades"/>
		<input type="hidden" name="sexo"/>
		<input type="hidden" name="copro"/>
		<input type="hidden" name="sangre"/>
		<input type="hidden" name="biolog_molec"/>
		<input type="hidden" name="tratamiento"/>
		<div class="row">
			<div class="col">
				<p>Seleccione los campos que desea exportar:</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card-columns">
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-evento" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-evento">EVENTO</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="intervencion_fecha" class="custom-control-input" id="evento-fecha" checked>
								<label class="custom-control-label" for="evento-fecha">Fecha</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="intervencion_tipo" class="custom-control-input" id="evento-tipo" checked>
								<label class="custom-control-label" for="evento-tipo">Tipo</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="departamento" class="custom-control-input" id="evento-departamento" checked>
								<label class="custom-control-label" for="evento-departamento">Departamento</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="localidad" class="custom-control-input" id="evento-localidad" checked>
								<label class="custom-control-label" for="evento-localidad">Localidad</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="barrio" class="custom-control-input" id="evento-barrio" checked>
								<label class="custom-control-label" for="evento-barrio">Barrio</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="paraje" class="custom-control-input" id="evento-paraje" checked>
								<label class="custom-control-label" for="evento-paraje">Paraje</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="puesto" class="custom-control-input" id="evento-puesto" checked>
								<label class="custom-control-label" for="evento-puesto">Puesto</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="institucion" class="custom-control-input" id="evento-institucion" checked>
								<label class="custom-control-label" for="evento-institucion">Instituci&oacute;n</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-biolog-molec" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-biolog-molec">BIOLOG&Iacute;A MOLECULAR</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="biologmolec_fuente" class="custom-control-input" id="biologmolec-fuente" checked>
								<label class="custom-control-label" for="biologmolec-fuente">Fuente</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="pcr_strongyloides" class="custom-control-input" id="pcr-strongyloides" checked>
								<label class="custom-control-label" for="pcr-strongyloides">Strongyloides (PCR)</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="pcr_ancylostoma" class="custom-control-input" id="pcr-ancylostoma" checked>
								<label class="custom-control-label" for="pcr-ancylostoma">Ancylostoma (PCR)</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="pcr_necator" class="custom-control-input" id="pcr-necator" checked>
								<label class="custom-control-label" for="pcr-necator">Necator (PCR)</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="pcr_ascaris" class="custom-control-input" id="pcr-ascaris" checked>
								<label class="custom-control-label" for="pcr-ascaris">Ascaris (PCR)</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="pcr_trichuris" class="custom-control-input" id="pcr-trichuris" checked>
								<label class="custom-control-label" for="pcr-trichuris">Trichuris (PCR)</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="qpcr_strongyloides" class="custom-control-input" id="qpcr-strongyloides" checked>
								<label class="custom-control-label" for="qpcr-strongyloides">Strongyloides (qPCR)</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="qpcr_ancylostoma" class="custom-control-input" id="qpcr-ancylostoma" checked>
								<label class="custom-control-label" for="qpcr-ancylostoma">Ancylostoma (qPCR)</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="qpcr_necator" class="custom-control-input" id="qpcr-necator" checked>
								<label class="custom-control-label" for="qpcr-necator">Necator (qPCR)</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="qpcr_ascaris" class="custom-control-input" id="qpcr-ascaris" checked>
								<label class="custom-control-label" for="qpcr-ascaris">Ascaris (qPCR)</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="qpcr_trichuris" class="custom-control-input" id="qpcr-trichuris" checked>
								<label class="custom-control-label" for="qpcr-trichuris">Trichuris (qPCR)</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-copro" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-copro">COPRO</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="copro_fecha" class="custom-control-input" id="copro-fecha" checked>
								<label class="custom-control-label" for="copro-fecha">Fecha</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="copro_peso" class="custom-control-input" id="peso" checked>
								<label class="custom-control-label" for="peso">Peso</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="copro_consistencia" class="custom-control-input" id="consistencia" checked>
								<label class="custom-control-label" for="consistencia">Consistencia</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="copro_nro_muestra" class="custom-control-input" id="nro-muestra" checked>
								<label class="custom-control-label" for="nro-muestra">N° Muestra</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="ascaris" class="custom-control-input" id="ascaris" checked>
								<label class="custom-control-label" for="ascaris">Ascaris</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="uncinarias" class="custom-control-input" id="uncinarias" checked>
								<label class="custom-control-label" for="uncinarias">Uncinarias</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="necator" class="custom-control-input" id="necator" checked>
								<label class="custom-control-label" for="necator">Necator</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="ancylostoma" class="custom-control-input" id="ancylostoma" checked>
								<label class="custom-control-label" for="ancylostoma">Ancylostoma</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="strongyloides" class="custom-control-input" id="strongyloides" checked>
								<label class="custom-control-label" for="strongyloides">Strongyloides</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="trichuris" class="custom-control-input" id="trichuris" checked>
								<label class="custom-control-label" for="trichuris">Trichuris</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="helmintos" class="custom-control-input" id="helmintos" checked>
								<label class="custom-control-label" for="helmintos">Helmintos</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-cc" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-cc">CONCENTRADO (COPRO)</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="cc_ascaris" class="custom-control-input" id="cc-ascaris" checked>
								<label class="custom-control-label" for="cc-ascaris">Ascaris</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="cc_giardia" class="custom-control-input" id="cc-giardia" checked>
								<label class="custom-control-label" for="cc-giardia">Giardia</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="cc_entamoebacoli" class="custom-control-input" id="cc-entamoeba" checked>
								<label class="custom-control-label" for="cc-entamoeba">Entamoeba Coli</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="cc_uncinarias" class="custom-control-input" id="cc-uncinarias" checked>
								<label class="custom-control-label" for="cc-uncinarias">Uncinarias</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="cc_strongyloides" class="custom-control-input" id="cc-strongyloides" checked>
								<label class="custom-control-label" for="cc-strongyloides">Strongyloides</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="cc_hymenolepis" class="custom-control-input" id="cc-hymenolepis" checked>
								<label class="custom-control-label" for="cc-hymenolepis">Hymenolepis</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="cc_trichuris" class="custom-control-input" id="cc-trichuris" checked>
								<label class="custom-control-label" for="cc-trichuris">Trichuris</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="cc_enterobius" class="custom-control-input" id="cc-enterobius" checked>
								<label class="custom-control-label" for="cc-enterobius">Enterobius</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="cc_taenia" class="custom-control-input" id="cc-taenia" checked>
								<label class="custom-control-label" for="cc-taenia">Taenia</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-mm" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-mm">MC MASTER (COPRO)</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="mm_ascaris" class="custom-control-input" id="mm-ascaris" checked>
								<label class="custom-control-label" for="mm-ascaris">Ascaris</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="mm_uncinarias" class="custom-control-input" id="mm-uncinarias" checked>
								<label class="custom-control-label" for="mm-uncinarias">Uncinarias</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="mm_hymenolepis" class="custom-control-input" id="mm-hymenolepis" checked>
								<label class="custom-control-label" for="mm-hymenolepis">Hymenolepis</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="mm_trichuris" class="custom-control-input" id="mm-trichuris" checked>
								<label class="custom-control-label" for="mm-trichuris">Trichuris</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="mm_enterobius" class="custom-control-input" id="mm-enterobius" checked>
								<label class="custom-control-label" for="mm-enterobius">Enterobius</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="mm_taenia" class="custom-control-input" id="mm-taenia" checked>
								<label class="custom-control-label" for="mm-taenia">Taenia</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-hm" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-hm">HARADA Y MORI (COPRO)</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="hm_strongyloides" class="custom-control-input" id="hm-strongyloides" checked>
								<label class="custom-control-label" for="hm-strongyloides">Strongyloides</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="hm_ancylostoma" class="custom-control-input" id="hm-ancylostoma" checked>
								<label class="custom-control-label" for="hm-ancylostoma">Ancylostoma</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="hm_necator" class="custom-control-input" id="hm-necator" checked>
								<label class="custom-control-label" for="hm-necator">Necator</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="hm_enterobius" class="custom-control-input" id="hm-enterobius" checked>
								<label class="custom-control-label" for="hm-enterobius">Enterobius</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-bm" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-bm">BAERMAN (COPRO)</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="bm_strongyloides" class="custom-control-input" id="bm-strongyloides" checked>
								<label class="custom-control-label" for="bm-strongyloides">Strongyloides</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="bm_ancylostoma" class="custom-control-input" id="bm-ancylostoma" checked>
								<label class="custom-control-label" for="bm-ancylostoma">Ancylostoma</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="bm_necator" class="custom-control-input" id="bm-necator" checked>
								<label class="custom-control-label" for="bm-necator">Necator</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-pa" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-pa">PLACA DE AGAR (COPRO)</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="pa_strongyloides" class="custom-control-input" id="pa-strongyloides" checked>
								<label class="custom-control-label" for="pa-strongyloides">Strongyloides</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="pa_ancylostoma" class="custom-control-input" id="pa-ancylostoma" checked>
								<label class="custom-control-label" for="pa-ancylostoma">Ancylostoma</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="pa_necator" class="custom-control-input" id="pa-necator" checked>
								<label class="custom-control-label" for="pa-necator">Necator</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-sangre" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-sangre">SANGRE</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="sangre_fecha" class="custom-control-input" id="sangre-fecha" checked>
								<label class="custom-control-label" for="sangre-fecha">Fecha</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="nro_tubo" class="custom-control-input" id="nro-tubo" checked>
								<label class="custom-control-label" for="nro-tubo">N° Tubo</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="globulos_blancos" class="custom-control-input" id="globulos-blancos" checked>
								<label class="custom-control-label" for="globulos-blancos">Gl&oacute;bulos Blancos</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="hemoglobina" class="custom-control-input" id="hemoglobina" checked>
								<label class="custom-control-label" for="hemoglobina">Hemoglobina</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="eosinofilos" class="custom-control-input" id="eosinofilos" checked>
								<label class="custom-control-label" for="eosinofilos">Eosinofilos</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="serolog_titulo" class="custom-control-input" id="titulo" checked>
								<label class="custom-control-label" for="titulo">T&iacute;tulo (Serolog&iacute;a)</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-tratamiento" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-tratamiento">DATOS TRATAMIENTO</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="trat_fecha" class="custom-control-input" id="trat-fecha" checked>
								<label class="custom-control-label" for="trat-fecha">Fecha</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="trat_no_tratado" class="custom-control-input" id="trat-no-tratado" checked>
								<label class="custom-control-label" for="trat-no-tratado">No Tratado</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="paciente_peso" class="custom-control-input" id="paciente-peso" checked>
								<label class="custom-control-label" for="paciente-peso">Peso</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="paciente_talla" class="custom-control-input" id="talla" checked>
								<label class="custom-control-label" for="talla">Talla</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="paciente_perimetro_cefalico" class="custom-control-input" id="perimetro-cefalico" checked>
								<label class="custom-control-label" for="perimetro-cefalico">Per&iacute;metro Cef&aacute;lico</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-trat-prev" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-trat-prev">TRATAMIENTO PREVIO</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tprev_fecha" class="custom-control-input" id="tprev-fecha" checked>
								<label class="custom-control-label" for="tprev-fecha">Fecha</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tprev_mebendazol" class="custom-control-input" id="tprev-mebendazol" checked>
								<label class="custom-control-label" for="tprev-mebendazol">Mebendazol</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tprev_albendazol" class="custom-control-input" id="tprev-albendazol" checked>
								<label class="custom-control-label" for="tprev-albendazol">Albendazol</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tprev_ivermectina" class="custom-control-input" id="tprev-ivermectina" checked>
								<label class="custom-control-label" for="tprev-ivermectina">Ivermectina</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tprev_metronidazol" class="custom-control-input" id="tprev-metronidazol" checked>
								<label class="custom-control-label" for="tprev-metronidazol">Metronidazol</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tprev_otras" class="custom-control-input" id="tprev-otros" checked>
								<label class="custom-control-label" for="tprev-otros">Otras</label>
							</div>
						</div>
					</fieldset>
					<fieldset class="card p-0 bg-dark">
						<div class="card-header">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="checkbox-dosis" checked>
								<label class="custom-control-label font-weight-bold" for="checkbox-dosis">DOSIS DROGAS (TRAT. ACTUAL)</label>
							</div>
						</div>
						<div class="card-body">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tact_dosis_mebendazol" class="custom-control-input" id="trat-mebendazol" checked>
								<label class="custom-control-label" for="trat-mebendazol">Mebendazol</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tact_exc_mebendazol" class="custom-control-input" id="trat-exc-mebendazol" checked>
								<label class="custom-control-label" for="trat-exc-mebendazol">Motivo Exc. Mebendazol</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tact_dosis_albendazol" class="custom-control-input" id="trat-albendazol" checked>
								<label class="custom-control-label" for="trat-albendazol">Albendazol</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tact_exc_albendazol" class="custom-control-input" id="trat-exc-albendazol" checked>
								<label class="custom-control-label" for="trat-exc-albendazol">Motivo Exc. Albendazol</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tact_dosis_ivermectina" class="custom-control-input" id="trat-ivermectina" checked>
								<label class="custom-control-label" for="trat-ivermectina">Ivermectina</label>
							</div>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" name="tact_exc_ivermectina" class="custom-control-input" id="trat-exc-ivermectina" checked>
								<label class="custom-control-label" for="trat-exc-ivermectina">Motivo Exc. Ivermectina</label>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
		<input type="submit" id="btn-exportar" value="" class="btn btn-circle" title="Exportar" />
	</form>
</section>
<div id="consult-selec-campania" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Campa&ntilde;as</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col-5">
						<h5>Todas</h5>
						<ul id="list-camp-sel-org" class="list-group list-group-flush mb-2"></ul>
					</div>
					<div class="col-2">
						<button type="button" id="btn-sel-campania" class="btn btn-primary btn-block fas fa-angle-right"></button>
						<button type="button" id="btn-sel-campania-todo" class="btn btn-primary btn-block fas fa-angle-double-right"></button>
						<button type="button" id="btn-desel-campania-todo" class="btn btn-primary btn-block fas fa-angle-double-left"></button>
						<button type="button" id="btn-desel-campania" class="btn btn-primary btn-block fas fa-angle-left"></button>
					</div>
					<div class="col-5">
						<h5>Seleccionadas</h5>
						<ul id="list-camp-sel-dst" class="list-group list-group-flush mb-2">
							<li class="item-vacio">
								<p>No hay datos seleccionados</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-ok-sel-campanias" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div id="consult-selec-dptos" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Departamentos</h4>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col-5">
						<h5>Todos</h5>
						<ul id="list-dptos-sel-org" class="list-group list-group-flush mb-2"></ul>
					</div>
					<div class="col-2">
						<button type="button" id="btn-sel-dpto" class="btn btn-primary btn-block fas fa-angle-right"></button>
						<button type="button" id="btn-sel-dpto-todo" class="btn btn-primary btn-block fas fa-angle-double-right"></button>
						<button type="button" id="btn-desel-dpto-todo" class="btn btn-primary btn-block fas fa-angle-double-left"></button>
						<button type="button" id="btn-desel-dpto" class="btn btn-primary btn-block fas fa-angle-left"></button>
					</div>
					<div class="col-5">
						<h5>Seleccionados</h5>
						<ul id="list-dptos-sel-dst" class="list-group list-group-flush mb-2">
							<li class="item-vacio">
								<p>No hay datos seleccionados</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-ok-sel-dptos" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div id="consult-selec-localidades" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Localidades</h4>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col-5">
						<h5>Filtrar</h5>
						<form name="formSelLocalidad">
							<div class="form-row">
								<div class="form-group col">
									<label for="sl-dpto">Departamento</label>
									<select name="departamento" class="custom-select custom-select input-requerido" id="sl-dpto" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										El Departamento es obligatorio
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sl-localidad">Localidad</label>
									<select name="localidad" class="custom-select custom-select input-requerido" id="sl-localidad" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
						</form>
					</div>
					<div class="col-2">
						<button type="button" id="btn-sel-localidad" class="btn btn-primary btn-block fas fa-angle-right"></button>
						<button type="button" id="btn-desel-localidad-todo" class="btn btn-primary btn-block fas fa-angle-double-left"></button>
						<button type="button" id="btn-desel-localidad" class="btn btn-primary btn-block fas fa-angle-left"></button>
					</div>
					<div class="col-5">
						<h5>Seleccionadas</h5>
						<ul id="list-localidades-sel-dst" class="list-group list-group-flush mb-2">
							<li class="item-vacio">
								<p>No hay datos seleccionados</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-ok-sel-localidades" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div id="consult-selec-barrios" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Barrios</h4>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col-5">
						<h5>Filtrar</h5>
						<form name="formSelBarrio">
							<div class="form-row">
								<div class="form-group col">
									<label for="sb-dpto">Departamento</label>
									<select name="departamento" class="custom-select custom-select input-requerido" id="sb-dpto" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										El Departamento es obligatorio
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sb-localidad">Localidad</label>
									<select name="localidad" class="custom-select custom-select input-requerido" id="sb-localidad" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sb-barrio">Barrio</label>
									<select name="barrio" class="custom-select custom-select input-requerido" id="sb-barrio" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
						</form>
					</div>
					<div class="col-2">
						<button type="button" id="btn-sel-barrio" class="btn btn-primary btn-block fas fa-angle-right"></button>
						<button type="button" id="btn-desel-barrio-todo" class="btn btn-primary btn-block fas fa-angle-double-left"></button>
						<button type="button" id="btn-desel-barrio" class="btn btn-primary btn-block fas fa-angle-left"></button>
					</div>
					<div class="col-5">
						<h5>Seleccionadas</h5>
						<ul id="list-barrios-sel-dst" class="list-group list-group-flush mb-2">
							<li class="item-vacio">
								<p>No hay datos seleccionados</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-ok-sel-barrios" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div id="consult-selec-parajes" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Parajes</h4>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col-5">
						<h5>Filtrar</h5>
						<form name="formSelParaje">
							<div class="form-row">
								<div class="form-group col">
									<label for="sp-dpto">Departamento</label>
									<select name="departamento" class="custom-select custom-select input-requerido" id="sp-dpto" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										El Departamento es obligatorio
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sp-localidad">Localidad</label>
									<select name="localidad" class="custom-select custom-select input-requerido" id="sp-localidad" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sp-paraje">Paraje</label>
									<select name="paraje" class="custom-select custom-select input-requerido" id="sp-paraje" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
						</form>
					</div>
					<div class="col-2">
						<button type="button" id="btn-sel-paraje" class="btn btn-primary btn-block fas fa-angle-right"></button>
						<button type="button" id="btn-desel-paraje-todo" class="btn btn-primary btn-block fas fa-angle-double-left"></button>
						<button type="button" id="btn-desel-paraje" class="btn btn-primary btn-block fas fa-angle-left"></button>
					</div>
					<div class="col-5">
						<h5>Seleccionadas</h5>
						<ul id="list-parajes-sel-dst" class="list-group list-group-flush mb-2">
							<li class="item-vacio">
								<p>No hay datos seleccionados</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-ok-sel-parajes" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div id="consult-selec-puestos" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Puestos</h4>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col-5">
						<h5>Filtrar</h5>
						<form name="formSelPuesto">
							<div class="form-row">
								<div class="form-group col">
									<label for="spt-dpto">Departamento</label>
									<select name="departamento" class="custom-select custom-select input-requerido" id="spt-dpto" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										El Departamento es obligatorio
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="spt-localidad">Localidad</label>
									<select name="localidad" class="custom-select custom-select input-requerido" id="spt-localidad" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="spt-paraje">Paraje</label>
									<select name="paraje" class="custom-select custom-select input-requerido" id="spt-paraje" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="spt-puesto">Puesto</label>
									<select name="puesto" class="custom-select custom-select input-requerido" id="spt-puesto" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
						</form>
					</div>
					<div class="col-2">
						<button type="button" id="btn-sel-puesto" class="btn btn-primary btn-block fas fa-angle-right"></button>
						<button type="button" id="btn-desel-puesto-todo" class="btn btn-primary btn-block fas fa-angle-double-left"></button>
						<button type="button" id="btn-desel-puesto" class="btn btn-primary btn-block fas fa-angle-left"></button>
					</div>
					<div class="col-5">
						<h5>Seleccionadas</h5>
						<ul id="list-puestos-sel-dst" class="list-group list-group-flush mb-2">
							<li class="item-vacio">
								<p>No hay datos seleccionados</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-ok-sel-puestos" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div id="consult-selec-instit-barrios" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Instituciones en Barrios</h4>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col-5">
						<h5>Filtrar</h5>
						<form name="formSelInstitBarrio">
							<div class="form-row">
								<div class="form-group col">
									<label for="sib-dpto">Departamento</label>
									<select name="departamento" class="custom-select custom-select input-requerido" id="sib-dpto" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										El Departamento es obligatorio
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sib-localidad">Localidad</label>
									<select name="localidad" class="custom-select custom-select input-requerido" id="sib-localidad" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sib-barrio">Barrio</label>
									<select name="barrio" class="custom-select custom-select input-requerido" id="sib-barrio" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sib-institucion">Instituci&oacute;n</label>
									<select name="institucion" class="custom-select custom-select input-requerido" id="sib-institucion" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
						</form>
					</div>
					<div class="col-2">
						<button type="button" id="btn-sel-instit-barrio" class="btn btn-primary btn-block fas fa-angle-right"></button>
						<button type="button" id="btn-desel-instit-barrio-todo" class="btn btn-primary btn-block fas fa-angle-double-left"></button>
						<button type="button" id="btn-desel-instit-barrio" class="btn btn-primary btn-block fas fa-angle-left"></button>
					</div>
					<div class="col-5">
						<h5>Seleccionadas</h5>
						<ul id="list-instit-barrios-sel-dst" class="list-group list-group-flush mb-2">
							<li class="item-vacio">
								<p>No hay datos seleccionados</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-ok-sel-instit-barrios" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div id="consult-selec-instit-parajes" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Instituciones en Parajes</h4>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col-5">
						<h5>Filtrar</h5>
						<form name="formSelInstitParaje">
							<div class="form-row">
								<div class="form-group col">
									<label for="sip-dpto">Departamento</label>
									<select name="departamento" class="custom-select custom-select input-requerido" id="sip-dpto" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										El Departamento es obligatorio
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sip-localidad">Localidad</label>
									<select name="localidad" class="custom-select custom-select input-requerido" id="sip-localidad" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sip-paraje">Paraje</label>
									<select name="paraje" class="custom-select custom-select input-requerido" id="sip-paraje" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label for="sip-institucion">Instituci&oacute;n</label>
									<select name="institucion" class="custom-select custom-select input-requerido" id="sip-institucion" required></select>
									<!-- <div class="invalid-feedback msj-invalido">
										La Localidad es obligatoria
									</div> -->
								</div>
							</div>
						</form>
					</div>
					<div class="col-2">
						<button type="button" id="btn-sel-instit-paraje" class="btn btn-primary btn-block fas fa-angle-right"></button>
						<button type="button" id="btn-desel-instit-paraje-todo" class="btn btn-primary btn-block fas fa-angle-double-left"></button>
						<button type="button" id="btn-desel-instit-paraje" class="btn btn-primary btn-block fas fa-angle-left"></button>
					</div>
					<div class="col-5">
						<h5>Seleccionadas</h5>
						<ul id="list-instit-parajes-sel-dst" class="list-group list-group-flush mb-2">
							<li class="item-vacio">
								<p>No hay datos seleccionados</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-ok-sel-instit-parajes" class="btn btn-outline-primary">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div id="consult-selec-fechas" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Fechas</h4>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col">
						<form name="formFechas" id="form-restric-fecha" novalidate>
							<div class="item-vacio">
								<p class="pt-4 pb-4">No hay restricciones.</p>
							</div>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col text-right">
						<button type="button" id="btn-nueva-rest-fecha" class="btn btn-primary fas fa-plus fa-1x" title="Nueva restricci&oacute;n"></button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" id="btn-ok-sel-instit-parajes" class="btn btn-outline-primary" form="form-restric-fecha">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<div id="consult-selec-edades" class="modal fade">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="mb-0 w-100 text-center">Edades</h4>
			</div>
			<div class="modal-body pr-4 pl-4">
				<div class="row">
					<div class="col">
						<form name="formEdades" id="form-restric-edad" novalidate>
							<div class="item-vacio">
								<p class="pt-4 pb-4">No hay restricciones.</p>
							</div>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col text-right">
						<button type="button" id="btn-nueva-rest-edad" class="btn btn-primary fas fa-plus fa-1x" title="Nueva restricci&oacute;n"></button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-outline-primary" form="form-restric-edad">Aceptar</button>
			</div>
		</div>
	</div>
</div>
<template id="t-restric-fecha">
	<div class="alert">
		<div class="form-row">
			<div class="form-group col-6 mr-3">
				<label for="fn-fecha-ini-">Desde</label>
				<input type="date" name="fecha_inicio" id="fn-fecha-ini-" class="form-control fecha-ini" autocomplete="off" required />
				<div class="invalid-feedback">
					Por favor complete el campo con una fecha
				</div>
			</div>
			<div class="form-group col-5">
				<label for="fn-fecha-fin-">Hasta</label>
				<input type="date" name="fecha_fin" id="fn-fecha-fin-" class="form-control fecha-fin" autocomplete="off" required />
				<div class="invalid-feedback">
					Por favor complete el campo con una fecha
				</div>
			</div>
		</div>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</div>
</template>
<template id="t-restric-edad">
	<div class="alert">
		<div class="form-row">
			<div class="form-group col-5 mr-3">
				<label for="edad-min-">Edad Min.</label>
				<input type="number" name="edad_min" id="edad-min-" class="form-control edad-min autocomplete="off" required />
				<div class="invalid-feedback">
					Por favor complete el campo con una edad v&aacute;lida
				</div>
			</div>
			<div class="form-group col-5">
				<label for="edad-max">Edad Max.</label>
				<input type="number" name="edad_max" id="edad-max-" class="form-control edad-max" autocomplete="off" required />
				<div class="invalid-feedback">
					Por favor complete el campo con una edad v&aacute;lida
				</div>
			</div>
		</div>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</div>
</template>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/datatables.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script src="/iiet/assets/js/Forms.js"></script>
<script src="/iiet/assets/js/consultas_pacientes.js"></script>
</html>