<form id="form_estudios" name="form_tratamiento" action="/iiet/intervenciones/cargar_tratamiento" class="mb-3 d-none">
	<div class="form-row justify-content-center">
		<div id="fecha-tratamiento" class="form-group col-3">
			<label for="ft-fecha" class="mr-2">Fecha</label>
			<input type="date" name="fecha" id="ft-fecha" class="form-control" required />
		</div>
		<fieldset id="check-recibio-tratamiento" class="form-group text-center">
			<legend class="col-form-legend">¿Recibi&oacute; tratamiento?</legend>
			<div class="custom-control custom-radio custom-control-inline">
				<input type="radio" name="fue_tratado" value="si" class="custom-control-input" id="ft-si" checked />
				<label for="ft-si" class="custom-control-label">S&iacute;</label>
			</div>
			<div class="custom-control custom-radio custom-control-inline">
				<input type="radio" name="fue_tratado" value="no" class="custom-control-input" id="ft-no" />
				<label for="ft-no" class="custom-control-label">No</label>
			</div>
		</fieldset>
	</div>
	<div id="div-tratado">
		<div class="form-row justify-content-center mt-4 contenedor-metodos">
			<div class="col-3 mr-3">
				<div class="accordion" id="medidas">
					<div class="card">
						<div class="card-header cabecera-metodo">
							<h5 class="mb-0">
								<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-medidas">MEDIDAS ANTROPOM&Eacute;TRICAS<div class="fa"></div></button>
							</h5>
						</div>
						<div id="result-medidas" class="collapse" data-parent="#medidas">
							<fieldset class="card-body cuerpo-metodo" disabled>
								<div class="form-row">
									<div class="col-12">
										<label for="ma-peso">Peso</label>
										<div class="grupo-control">
											<input type="text" id="ma-peso" class="numero form-control" name="medidas[peso]" pattern="^\d+(.\d{1,2})?$" autocomplete="off" />
											<span>kg&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12">
										<label for="ma-talla">Talla</label>
										<div class="grupo-control">
											<input type="text" id="ma-talla" class="numero form-control" name="medidas[talla]" pattern="^\d+(.\d{1,2})?$" autocomplete="off" />
											<span>mtrs</span>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12">
										<label for="ma-perim-cef">Per&iacute;metro Cef&aacute;lico</label>
										<div class="grupo-control">
											<input type="text" id="ma-perim-cef" class="numero form-control" name="medidas[perimetro_cefalico]" pattern="^\d*(\.\d{1,2})?$" autocomplete="off" />
											<span>cm&nbsp;&nbsp;</span>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div class="col-3 mr-3">
				<div class="accordion" id="previo">
					<div class="card">
						<div class="card-header cabecera-metodo">
							<h5 class="mb-0">
								<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-previo">TRATAMIENTO PREVIO<div class="fa"></div></button>
							</h5>
						</div>
						<div id="result-previo" class="collapse" data-parent="#previo">
							<fieldset class="card-body cuerpo-metodo" disabled>
								<div class="form-row">
									<div class="col-12">
										<label for="tp-fecha">Fecha</label>
										<div class="grupo-control">
											<input type="date" id="tp-fecha" class="form-control" name="tratamiento_previo[fecha]" required autocomplete="off" />
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12 custom-control custom-checkbox">
										<input type="checkbox" id="tp-mebendazol" class="custom-control-input" name="tratamiento_previo[mebendazol]" value="true" />
										<label for="tp-mebendazol" class="custom-control-label">Mebendazol</label>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12 custom-control custom-checkbox">
										<input type="checkbox" id="tp-albendazol" class="custom-control-input" name="tratamiento_previo[albendazol]" value="true" />
										<label for="tp-albendazol" class="custom-control-label">Albendazol</label>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12 custom-control custom-checkbox">
										<input type="checkbox" id="tp-ivermectina" class="custom-control-input" name="tratamiento_previo[ivermectina]" value="true" />
										<label for="tp-ivermectina" class="custom-control-label">Ivermectina</label>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12 custom-control custom-checkbox">
										<input type="checkbox" id="tp-metronidazol" class="custom-control-input" name="tratamiento_previo[metronidazol]" value="true" />
										<label for="tp-metronidazol" class="custom-control-label">Metronidazol</label>
									</div>
								</div>
								<div class="form-row">
									<div class="col-12">
										<label for="tp-otros">Otros</label>
										<div class="grupo-control">
											<input type="text" id="tp-otros" class="form-control" name="tratamiento_previo[otras]" autocomplete="off" />
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-row justify-content-center mt-4 contenedor-metodos">
			<div class="col-4 mr-3">
				<div class="card" id="actual">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button">TRATAMIENTO ACTUAL</button>
						</h5>
					</div>
					<fieldset class="card-body cuerpo-metodo">
						<div class="form-row">
							<div class="col-6">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" id="ta-mebendazol" class="custom-control-input" name="d" />
									<label for="ta-mebendazol" class="custom-control-label">Mebendazol</label>
								</div>
							</div>
							<fieldset class="col-6 d-none" disabled>
								<label for="ta-d-meb">Dosis</label>
								<div class="dosis">
									<input type="text" id="ta-d-meb" class="numero form-control" name="mebendazol[dosis]" autocomplete="off" />
									<span>mg</span>
								</div>
							</fieldset>
							<fieldset class="col-6">
								<label for="ta-me-meb">Motivo de Exclusi&oacute;n</label>
								<select id="ta-me-meb" class="custom-select" name="mebendazol[exclusion]">
									<option value="NO SUMINISTRADO">No suministrado</option>
									<option value="AUSENTE">Ausente</option>
									<option value="RECHAZO">Rechazo</option>
									<option value="EMBARAZO">Embarazo</option>
									<option value="LACTANCIA">Lactancia</option>
									<option value="MENOR A 12 MESES">Menor a 12 meses</option>
									<option value="MENOS DE 15 KG">Menos de 15kg</option>
								</select>
							</fieldset>
						</div>
						<div class="form-row">
							<div class="col-6">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" id="ta-albendazol" class="custom-control-input" name="d" />
									<label for="ta-albendazol" class="custom-control-label">Albendazol</label>
								</div>
							</div>
							<fieldset class="col-6 d-none" disabled>
								<label for="ta-d-alb">Dosis</label>
								<div class="dosis">
									<input type="number" id="ta-d-alb" class="numero form-control" name="albendazol[dosis]" autocomplete="off" />
									<span>mg</span>
								</div>
							</fieldset>
							<fieldset class="col-6">
								<label for="ta-me-alb">Motivo de Exclusi&oacute;n</label>
								<select id="ta-me-alb" class="custom-select" name="albendazol[exclusion]">
									<option value="NO SUMINISTRADO">No suministrado</option>
									<option value="AUSENTE">Ausente</option>
									<option value="RECHAZO">Rechazo</option>
									<option value="EMBARAZO">Embarazo</option>
									<option value="LACTANCIA">Lactancia</option>
									<option value="MENOR A 12 MESES">Menor a 12 meses</option>
									<option value="MENOS DE 15 KG">Menos de 15kg</option>
								</select>
							</fieldset>
						</div>
						<div class="form-row">
							<div class="col-6">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" id="ta-ivermectina" class="custom-control-input" />
									<label for="ta-ivermectina" class="custom-control-label">Ivermectina</label>
								</div>
							</div>
							<fieldset class="col-6 d-none" disabled>
								<label for="ta-d-iverm">Dosis</label>
								<div class="dosis">
									<input type="text" id="ta-d-iverm" class="numero form-control" name="ivermectina[dosis]" autocomplete="off" />
									<span>mg</span>
								</div>
							</fieldset>
							<fieldset class="col-6">
								<label for="ta-me-iverm">Motivo de Exclusi&oacute;n</label>
								<select id="ta-me-iverm" class="custom-select" name="ivermectina[exclusion]">
									<option value="NO SUMINISTRADO">No suministrado</option>
									<option value="AUSENTE">Ausente</option>
									<option value="RECHAZO">Rechazo</option>
									<option value="EMBARAZO">Embarazo</option>
									<option value="LACTANCIA">Lactancia</option>
									<option value="MENOR A 12 MESES">Menor a 12 meses</option>
									<option value="MENOS DE 15 KG">Menos de 15kg</option>
								</select>
							</fieldset>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
	<div id="div-no-tratado" class="form-row justify-content-center d-none">
		<div class="col-4 bg-primary">
			<label for="no_tratado">¿Por qu&eacute; no recibi&oacute; el tratamiento?</label>
			<select name="no_tratado" id="no_tratado" class="custom-select" disabled>
				<option value="AUSENTE">Por ausencia</option>
				<option value="ENFERMEDAD">Por enfermedad</option>
				<option value="MENOR A UN AÑO">Menor a un a&ntilde;o</option>
			</select>
		</div>
	</div>
</form>