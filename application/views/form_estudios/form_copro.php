<form id="form_estudios" name="form_estudios" is="form-asinc" action="/iiet/estudios/cargar_copro">
	<input type="hidden" id="paciente" name="intervencion[paciente]"/>
	<input type="hidden" id="campania" name="intervencion[campania]"/>
	<input type="hidden" id="tipo" name="intervencion[tipo]"/>
	<div id="form_part_1">
		<label>
			<span>Fecha</span>
			<input type="date" name="fecha" required="required" />
		</label>
		<label>
			<span>Peso</span>
			<input type="text" class="numero" required="required" name="peso_materia" pattern="^\d+(.\d+)?$" />
			<span>g</span>
		</label>
		<label>
			<span>Consistencia</span>
			<select name="consistencia">
				<option value="SOLIDA">SOLIDA</option>
				<option value="PASTOSA">PASTOSA</option>
				<option value="LIQUIDA">LIQUIDA</option>
			</select>
		</label>
	</div>
	<div id="form_part_2">
		<form-concentrado class="estudios"></form-concentrado>
		<form-mcmaster class="estudios"></form-mcmaster>
	</div>
	<div id="form_part_3">
		<form-haradamori class="estudios"></form-haradamori>
		<form-baerman class="estudios"></form-baerman>
		<form-placaagar class="estudios"></form-placaagar>
	</div>
	<input type="submit" value="" form="form_estudios" id="guardar_estudio" title="Guardar"/>
</form>