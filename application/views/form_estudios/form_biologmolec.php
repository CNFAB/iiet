<form id="form_estudios" name="form_biologmolec" is="form-asinc" action="/iiet/intervenciones/cargar_biologmolec">
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