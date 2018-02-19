<form id="form_estudios" name="form_estudios" is="form-asinc" action="/iiet/estudios/cargar_biologmolec">
	<input type="hidden" id="paciente" name="intervencion[paciente]"/>
	<input type="hidden" id="campania" name="intervencion[campania]"/>
	<input type="hidden" id="tipo" name="intervencion[tipo]"/>
	<div id="form_part_1">
		<label>
			<span>Fuente</span>
			<select name="fuente">
				<option value="MATERIA FECAL">MATERIA FECAL</option>
				<option value="ORINA">ORINA</option>
			</select>
		</label>
	</div>
	<div id="form_part_2">
		<form-pcr class="estudios"></form-pcr>
		<form-qpcr class="estudios"></form-qpcr>
	</div>
	<input type="submit" value="" form="form_estudios" id="guardar_estudio" title="Guardar"/>
</form>