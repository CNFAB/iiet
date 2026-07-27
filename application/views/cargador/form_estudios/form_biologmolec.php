<form id="form_estudios" name="form_biologmolec" action="/iiet/intervenciones/cargar_biologmolec" class="mb-3 d-none">
	<div class="form-row justify-content-center">
		<div class="form-group col-3">
			<label for="fb-fuente" class="mr-2">Fuente</label>
			<select name="fuente" class="custom-select input-requerido" id="fb-fuente">
				<option value="MATERIA FECAL">MATERIA FECAL</option>
				<option value="ORINA">ORINA</option>
			</select>
		</div>
	</div>
	<div class="form-row justify-content-center mt-4 contenedor-metodos">
		<div class="col-3 mr-3">
			<div class="accordion" id="pcr">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-pcr">PCR<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-pcr" class="collapse" data-parent="#pcr">
						<fieldset class="card-body cuerpo-metodo" disabled>
							<div class="form-row">
								<div class="col-12">
									<label for="pcr-strongyloides">Strongyloides</label>
									<select id="pcr-strongyloides" class="custom-select grupo-control" name="pcr[strongyloides]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="pcr-ancylostoma">Ancylostoma</label>
									<select id="pcr-ancylostoma" class="custom-select grupo-control" name="pcr[ancylostoma]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="pcr-necator">Necator</label>
									<select id="pcr-necator" class="custom-select grupo-control" name="pcr[necator]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="pcr-ascaris">Ascaris</label>
									<select id="pcr-ascaris" class="custom-select grupo-control" name="pcr[ascaris]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="pcr-trichuris">Trichuris</label>
									<select id="pcr-trichuris" class="custom-select grupo-control" name="pcr[trichuris]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
						</fieldset>
						<div class="card-footer btn_negativo text-center">
							<button type="button" class="btn-negativo btn btn-link">Completar con Negativos</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 mr-3">
			<div class="accordion" id="qpcr">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-qpcr">QPCR<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-qpcr" class="collapse" data-parent="#qpcr">
						<fieldset class="card-body cuerpo-metodo" disabled>
							<div class="form-row">
								<div class="col-12">
									<label for="qpcr-strongyloides">Strongyloides</label>
									<select id="qpcr-strongyloides" class="custom-select grupo-control" name="qpcr[strongyloides]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="qpcr-ancylostoma">Ancylostoma</label>
									<select id="qpcr-ancylostoma" class="custom-select grupo-control" name="qpcr[ancylostoma]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="qpcr-necator">Necator</label>
									<select id="qpcr-necator" class="custom-select grupo-control" name="qpcr[necator]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="qpcr-ascaris">Ascaris</label>
									<select id="qpcr-ascaris" class="custom-select grupo-control" name="qpcr[ascaris]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="qpcr-trichuris">Trichuris</label>
									<select id="qpcr-trichuris" class="custom-select grupo-control" name="qpcr[trichuris]" required>
										<option value="SIN DATO">SIN DATO</option>
										<option value="NEGATIVO">NEGATIVO</option>
										<option value="POSITIVO">POSITIVO</option>
									</select>
								</div>
							</div>
						</fieldset>
						<div class="card-footer btn_negativo text-center">
							<button type="button" class="btn-negativo btn btn-link">Completar con Negativos</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>