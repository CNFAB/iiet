<form id="form_estudios" name="form_sangre" is="form-asinc" action="/iiet/intervenciones/cargar_sangre">
	<div id="form_part_1">
		<label>
			<span>Fecha</span>
			<input type="date" name="fecha" required="required" />
		</label>
		<label>
			<span>N° de Tubo</span>
			<input type="text" class="numero" required="required" name="nro_tubo" pattern="^[A-Z]{3,4}-\d{4}-\d{2}$" />
		</label>
	</div>
	<div id="form_part_2">
		<form-hemograma class="estudios"></form-hemograma>
		<form-serologia class="estudios"></form-serologia>
	</div>
	<input type="submit" value="" form="form_estudios" id="guardar_estudio" title="Guardar"/>
</form>