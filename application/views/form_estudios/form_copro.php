<form id="form_estudios" name="form_copro" is="form-asinc" action="/iiet/intervenciones/cargar_copro">
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
		<label>
			<span>N° de Muestra</span>
			<input type="number" name="nro_muestra" class="numero" />
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
	<button type="button" id="positividad"></button>
	<div id="datos_positividad" class="oculto">
		<h1>Positividad</h1>
		<div>
			<p><span class="result_positivo"></span><span>Ascaris</span></p>
			<p><span class="result_negativo"></span><span>Uncinarias</span></p>
			<p><span class="result_negativo"></span><span>Ancylostoma</span></p>
			<p><span class="result_negativo"></span><span>Necator</span></p>
			<p><span class="no_realizado"></span><span>Strongyloides</span></p>
			<p><span class="result_positivo"></span><span>Trichuris</span></p>
		</div>
	</div>
</form>