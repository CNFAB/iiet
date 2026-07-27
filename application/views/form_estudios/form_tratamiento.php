<form id="form_estudios" name="form_tratamiento" is="form-asinc" action="/iiet/intervenciones/cargar_tratamiento">
	<div id="form_part_1">
		<label>
			<span>Fecha</span>
			<input type="date" name="fecha" required="required" />
		</label>
		<div id="fue_tratado">
			<span>¿Recibi&oacute; tratamiento?</span>
			<div>
				<label>
					<span>S&iacute;</span>
					<input type="radio" name="fue_tratado" value="si" checked="checked" />
				</label>
				<label>
					<span>No</span>
					<input type="radio" name="fue_tratado" value="no" />
				</label>
			</div>
		</div>
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
	<div id="form_part_4" class="oculto">
		<label>
			<span>¿Por qu&eacute; no recibi&oacute; el tratamiento?</span>
			<select name="no_tratado" disabled="disabled">
				<option value="AUSENTE">Por ausencia</option>
				<option value="ENFERMEDAD">Por enfermedad</option>
				<option value="MENOR A UN AÑO">Menor a un a&ntilde;o</option>
			</select>
		</label>
	</div>
	<input type="submit" value="" form="form_estudios" id="guardar_estudio" title="Guardar" />
</form>