<!DOCTYPE html>

<html lang="es">
<head>
	<title>Exportar Campa&ntilde;a</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/mdb.css"/>
	<link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

	<style>

		.btn-circle {
			background-repeat: no-repeat;
			background-size: 50%;
			background-position: center;
			background-image: url('/iiet/assets/images/ic_excel.svg');
			background-color: #165a16;
		}

		.btn-circle:hover {
			background-size: 60%;
		}

		form  fieldset label {
			font-weight: 300 !important;
		}

	</style>
</head>
<body>

<header class="mb-4">
	<div class="navbar navbar-dark navbar-expand-lg">
		<div class="container-fluid">
				<h2 class="col-8 mb-0">Campa&ntilde;a: <span id="nombre-campania"></span></h2>
				<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#links">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="links" class="col-4 navbar-collapse collapse justify-content-end">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a id="ir-campanias" class="nav-link" href="/iiet/campanias"><span class="fa fa-arrow-circle-left mr-1"></span> Volver a Campa&ntilde;as</a>
						</li>
					</ul>
				</div>
		</div>
	</div>
</header>
<section class="container-fluid pr-4 pb-4 pl-4">
	<div class="row">
		<div class="col">
			<h2>Exportar</h2>
		</div>
	</div>
<form action="/iiet/campanias/exportar/" method="POST" name="formCampos">
<div class="row">
	<div class="col">
		<p>Seleccione los campos que desea exportar:</p>
	</div>
</div>
<div class="row">
<div class="col-3">
<fieldset class="card p-0 bg-dark">
<div class="card-header">
	<div class="custom-control custom-checkbox">
		<input type="checkbox" class="custom-control-input" id="copro" checked>
		<label class="custom-control-label font-weight-bold" for="copro">COPRO</label>
	</div>
</div>
<div class="card-body">
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="copro_fecha" class="custom-control-input"
			id="copro-fecha" checked>
		<label class="custom-control-label" for="copro-fecha">Fecha</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="copro_peso" class="custom-control-input"
			id="peso" checked>
		<label class="custom-control-label" for="peso">Peso</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="copro_consistencia" class="custom-control-input"
			id="consistencia" checked>
		<label class="custom-control-label" for="consistencia">Consistencia</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="copro_nro_muestra" class="custom-control-input"
			id="nro-muestra" checked>
		<label class="custom-control-label" for="nro-muestra">N° Muestra</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="cc_ascaris" class="custom-control-input"
			id="cc-ascaris" checked>
		<label class="custom-control-label" for="cc-ascaris">Ascaris (CC)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="cc_giardia" class="custom-control-input"
			id="cc-giardia" checked>
		<label class="custom-control-label" for="cc-giardia">Giardia (CC)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="cc_entamoebacoli" class="custom-control-input"
			id="cc-entamoeba" checked>
		<label class="custom-control-label" for="cc-entamoeba">Entamoeba Coli (CC)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="cc_uncinarias" class="custom-control-input"
			id="cc-uncinarias" checked>
		<label class="custom-control-label" for="cc-uncinarias">Uncinarias (CC)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="cc_strongyloides" class="custom-control-input"
			id="cc-strongyloides" checked>
		<label class="custom-control-label" for="cc-strongyloides">Strongyloides (CC)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="cc_hymenolepis" class="custom-control-input"
			id="cc-hymenolepis" checked>
		<label class="custom-control-label" for="cc-hymenolepis">Hymenolepis (CC)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="cc_trichuris" class="custom-control-input"
			id="cc-trichuris" checked>
		<label class="custom-control-label" for="cc-trichuris">Trichuris (CC)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="cc_enterobius" class="custom-control-input"
			id="cc-enterobius" checked>
		<label class="custom-control-label" for="cc-enterobius">Enterobius (CC)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="cc_taenia" class="custom-control-input"
			id="cc-taenia" checked>
		<label class="custom-control-label" for="cc-taenia">Taenia (CC)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="mm_ascaris" class="custom-control-input"
			id="mm-ascaris" checked>
		<label class="custom-control-label" for="mm-ascaris">Ascaris (MM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="mm_uncinarias" class="custom-control-input"
			id="mm-uncinarias" checked>
		<label class="custom-control-label" for="mm-uncinarias">Uncinarias (MM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="mm_hymenolepis" class="custom-control-input"
			id="mm-hymenolepis" checked>
		<label class="custom-control-label" for="mm-hymenolepis">Hymenolepis (MM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="mm_trichuris" class="custom-control-input"
			id="mm-trichuris" checked>
		<label class="custom-control-label" for="mm-trichuris">Trichuris (MM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="mm_enterobius" class="custom-control-input"
			id="mm-enterobius" checked>
		<label class="custom-control-label" for="mm-enterobius">Enterobius (MM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="mm_taenia" class="custom-control-input"
			id="mm-taenia" checked>
		<label class="custom-control-label" for="mm-taenia">Taenia (MM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="hm_strongyloides" class="custom-control-input"
			id="hm-strongyloides" checked>
		<label class="custom-control-label" for="hm-strongyloides">Strongyloides (HM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="hm_ancylostoma" class="custom-control-input"
			id="hm-ancylostoma" checked>
		<label class="custom-control-label" for="hm-ancylostoma">Ancylostoma (HM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="hm_necator" class="custom-control-input"
			id="hm-necator" checked>
		<label class="custom-control-label" for="hm-necator">Necator (HM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="hm_enterobius" class="custom-control-input"
			id="hm-enterobius" checked>
		<label class="custom-control-label" for="hm-enterobius">Enterobius (HM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="bm_strongyloides" class="custom-control-input"
			id="bm-strongyloides" checked>
		<label class="custom-control-label" for="bm-strongyloides">Strongyloides (BM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="bm_ancylostoma" class="custom-control-input"
			id="bm-ancylostoma" checked>
		<label class="custom-control-label" for="bm-ancylostoma">Ancylostoma (BM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="bm_necator" class="custom-control-input"
			id="bm-necator" checked>
		<label class="custom-control-label" for="bm-necator">Necator (BM)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="pa_strongyloides" class="custom-control-input"
			id="pa-strongyloides" checked>
		<label class="custom-control-label" for="pa-strongyloides">Strongyloides (PA)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="pa_ancylostoma" class="custom-control-input"
			id="pa-ancylostoma" checked>
		<label class="custom-control-label" for="pa-ancylostoma">Ancylostoma (PA)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="pa_necator" class="custom-control-input"
			id="pa-necator" checked>
		<label class="custom-control-label" for="pa-necator">Necator (PA)</label>
	</div>
</div>
</fieldset>
</div>
<div class="col-3">
<fieldset class="card p-0 bg-dark">
<div class="card-header">
	<div class="custom-control custom-checkbox">
		<input type="checkbox" class="custom-control-input" id="sangre" checked>
		<label class="custom-control-label font-weight-bold" for="sangre">SANGRE</label>
	</div>
</div>
<div class="card-body">
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="sangre_fecha" class="custom-control-input"
			id="sangre-fecha" checked>
		<label class="custom-control-label" for="sangre-fecha">Fecha</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="nro_tubo" class="custom-control-input"
			id="nro-tubo" checked>
		<label class="custom-control-label" for="nro-tubo">N° Tubo</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="globulos_blancos" class="custom-control-input"
			id="globulos-blancos" checked>
		<label class="custom-control-label" for="globulos-blancos">Gl&oacute;bulos Blancos</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="hemoglobina" class="custom-control-input"
			id="hemoglobina" checked>
		<label class="custom-control-label" for="hemoglobina">Hemoglobina</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="eosinofilos" class="custom-control-input"
			id="eosinofilos" checked>
		<label class="custom-control-label" for="eosinofilos">Eosinofilos</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="serolog_titulo" class="custom-control-input"
			id="titulo" checked>
		<label class="custom-control-label" for="titulo">T&iacute;tulo (Serolog&iacute;a)</label>
	</div>
</div>
</fieldset>
</div>
<div class="col-3">
<fieldset class="card p-0 bg-dark">
<div class="card-header">
	<div class="custom-control custom-checkbox">
		<input type="checkbox" class="custom-control-input" id="biolog-molec" checked>
		<label class="custom-control-label font-weight-bold" for="biolog-molec">
			BIOLOG&Iacute;A MOLECULAR
		</label>
	</div>
</div>
<div class="card-body">
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="biologmolec_fuente" class="custom-control-input"
			id="biologmolec-fuente" checked>
		<label class="custom-control-label" for="biologmolec-fuente">Fuente</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="pcr_strongyloides" class="custom-control-input"
			id="pcr-strongyloides" checked>
		<label class="custom-control-label" for="pcr-strongyloides">Strongyloides (PCR)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="pcr_ancylostoma" class="custom-control-input"
			id="pcr-ancylostoma" checked>
		<label class="custom-control-label" for="pcr-ancylostoma">Ancylostoma (PCR)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="pcr_necator" class="custom-control-input"
			id="pcr-necator" checked>
		<label class="custom-control-label" for="pcr-necator">Necator (PCR)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="pcr_ascaris" class="custom-control-input"
			id="pcr-ascaris" checked>
		<label class="custom-control-label" for="pcr-ascaris">Ascaris (PCR)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="pcr_trichuris" class="custom-control-input"
			id="pcr-trichuris" checked>
		<label class="custom-control-label" for="pcr-trichuris">Trichuris (PCR)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="qpcr_strongyloides" class="custom-control-input"
			id="qpcr-strongyloides" checked>
		<label class="custom-control-label" for="qpcr-strongyloides">Strongyloides (qPCR)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="qpcr_ancylostoma" class="custom-control-input"
			id="qpcr-ancylostoma" checked>
		<label class="custom-control-label" for="qpcr-ancylostoma">Ancylostoma (qPCR)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="qpcr_necator" class="custom-control-input"
			id="qpcr-necator" checked>
		<label class="custom-control-label" for="qpcr-necator">Necator (qPCR)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="qpcr_ascaris" class="custom-control-input"
			id="qpcr-ascaris" checked>
		<label class="custom-control-label" for="qpcr-ascaris">Ascaris (qPCR)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="qpcr_trichuris" class="custom-control-input"
			id="qpcr-trichuris" checked>
		<label class="custom-control-label" for="qpcr-trichuris">Trichuris (qPCR)</label>
	</div>
</div>
</fieldset>
</div>
<div class="col-3">
<fieldset class="card p-0 bg-dark">
<div class="card-header">
	<div class="custom-control custom-checkbox">
		<input type="checkbox" class="custom-control-input" id="tratamiento" checked>
		<label class="custom-control-label font-weight-bold" for="tratamiento">TRATAMIENTO</label>
	</div>
</div>
<div class="card-body">
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="trat_fecha" class="custom-control-input"
			id="trat-fecha" checked>
		<label class="custom-control-label" for="trat-fecha">Fecha</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="trat_no_tratado" class="custom-control-input"
			id="trat-no-tratado" checked>
		<label class="custom-control-label" for="trat-no-tratado">No Tratado</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="paciente_peso" class="custom-control-input"
			id="peso" checked>
		<label class="custom-control-label" for="peso">Peso</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="paciente_talla" class="custom-control-input"
			id="talla" checked>
		<label class="custom-control-label" for="talla">Talla</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="paciente_perimetro_cefalico" class="custom-control-input"
			id="perimetro-cefalico" checked>
		<label class="custom-control-label" for="perimetro-cefalico">
			Per&iacute;metro Cef&aacute;lico
		</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tprev_fecha" class="custom-control-input"
			id="tprev-fecha" checked>
		<label class="custom-control-label" for="tprev-fecha">Fecha (Trat. Prev)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tprev_mebendazol" class="custom-control-input"
			id="tprev-mebendazol" checked>
		<label class="custom-control-label" for="tprev-mebendazol">Mebendazol (Trat. Prev)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tprev_albendazol" class="custom-control-input"
			id="tprev-albendazol" checked>
		<label class="custom-control-label" for="tprev-albendazol">Albendazol (Trat. Prev)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tprev_ivermectina" class="custom-control-input"
			id="tprev-ivermectina" checked>
		<label class="custom-control-label" for="tprev-ivermectina">
			Ivermectina (Trat. Prev)
		</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tprev_metronidazol" class="custom-control-input"
			id="tprev-metronidazol" checked>
		<label class="custom-control-label" for="tprev-metronidazol">
			Metronidazol (Trat. Prev)
		</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tprev_otras" class="custom-control-input"
			id="tprev-otros" checked>
		<label class="custom-control-label" for="tprev-otros">Otras (Trat. Prev)</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tact_dosis_mebendazol" class="custom-control-input"
			id="trat-mebendazol" checked>
		<label class="custom-control-label" for="trat-mebendazol">
			Dosis Mebendazol (Trat. Act.)
		</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tact_exc_mebendazol" class="custom-control-input"
			id="trat-exc-mebendazol" checked>
		<label class="custom-control-label" for="trat-exc-mebendazol">
			Mot. Exc. Mebendazol (Trat. Act.)
		</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tact_dosis_albendazol" class="custom-control-input"
			id="trat-albendazol" checked>
		<label class="custom-control-label" for="trat-albendazol">
			Dosis Albendazol (Trat. Act.)
		</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tact_exc_albendazol" class="custom-control-input"
			id="trat-exc-albendazol" checked>
		<label class="custom-control-label" for="trat-exc-albendazol">
			Mot. Exc. Albendazol (Trat. Act.)
		</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tact_dosis_ivermectina" class="custom-control-input"
			id="trat-ivermectina" checked>
		<label class="custom-control-label" for="trat-ivermectina">
			Dosis Ivermectina (Trat. Act.)
		</label>
	</div>
	<div class="custom-control custom-checkbox">
		<input type="checkbox" name="tact_exc_ivermectina" class="custom-control-input"
			id="trat-exc-ivermectina" checked>
		<label class="custom-control-label" for="trat-exc-ivermectina">
			Mot. Exc. Ivermectina (Trat. Act.)
		</label>
	</div>
</div>
</fieldset>
</div>
</div>
<input type="submit" value="" class="btn btn-circle" title="Exportar" />
</form>
</section>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script src="/iiet/assets/js/exportar.js"></script>
</html>
