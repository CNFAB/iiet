<form id="form_estudios" name="form_estudios" is="form-asinc" action="/iiet/estudios/cargar_tratamiento">
	<input type="hidden" id="paciente" name="intervencion[paciente]"/>
	<input type="hidden" id="campania" name="intervencion[campania]"/>
	<input type="hidden" id="tipo" name="intervencion[tipo]"/>
	<div id="form_part_1">
		<label>
			<span>Fecha</span>
			<input type="date" name="fecha" required="required" />
		</label>
	</div>
	<div id="form_part_2">
		<form-medidasantropometricas class="estudios"></form-medidasantropometricas>
		<form-tratamientoprevio class="estudios"></form-tratamientoprevio>
	</div>
	<div id="form_part_3">
		<form-mebendazol class="estudios"></form-mebendazol>
		<form-albendazol class="estudios"></form-albendazol>
		<form-ivermectina class="estudios"></form-ivermectina>
	</div>
	<input type="submit" value="" form="form_estudios" id="guardar_estudio" title="Guardar" />
</form>