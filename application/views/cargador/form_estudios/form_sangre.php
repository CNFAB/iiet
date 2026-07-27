<form id="form_estudios" name="form_sangre" is="form-asinc" action="/iiet/intervenciones/cargar_sangre" class="d-none">
	<div class="form-row justify-content-center">
		<div class="form-group col-3">
			<label for="fs-fecha" class="mr-2">Fecha</label>
			<input type="date" name="fecha" id="fs-fecha" class="form-control" required="required" />
		</div>
		<div class="form-group col-3">
			<label for="fs-nro-tubo" class="mr-2">N° de Tubo</label>
			<input type="text" id="fs-nro-tubo" class="numero form-control" name="nro_tubo" required autocomplete="off" pattern="^\w{3,4}-\d{4}-\d{2}$" />
		</div>
	</div>
	<div class="form-row justify-content-center mt-4 contenedor-metodos">
		<div class="col-3 mr-3">
			<div class="accordion" id="hemograma">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-hemograma">HEMOGRAMA<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-hemograma" class="collapse" data-parent="#hemograma">
						<fieldset class="card-body cuerpo-metodo" disabled>
							<div class="form-row">
								<div class="col-12">
									<label for="globulos-blancos">Gl&oacute;bulos Blancos</label>
									<div class="grupo-control">
										<input type="text" id="globulos-blancos" class="numero form-control" name="hemograma[globulos_blancos]" pattern="^\d*(\.\d{1,2})?$" required autocomplete="off" />
										<span>mm&#179;</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="hemoglobina">Hemoglobina</label>
									<div class="grupo-control">
										<input type="text" id="hemoglobina" class="numero form-control" name="hemograma[hemoglobina]" pattern="^\d*(\.\d{1,2})?$" required autocomplete="off" />
										<span>gr&#47;dl</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="eosinofilos">Eosinofilos</label>
									<div class="grupo-control">
										<input type="text" id="eosinofilos" class="numero form-control" name="hemograma[eosinofilos]" pattern="^\d*(\.\d{1,2})?$" required autocomplete="off" />
										<span>&#37;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<div class="col-3 mr-3">
			<div class="accordion" id="serologia">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-serologia">SEROLOGIA STRONGYLOIDES<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-serologia" class="collapse" data-parent="#serologia">
						<fieldset class="card-body cuerpo-metodo" disabled>
							<div class="form-row">
								<div class="col-12">
									<label for="titulo">T&iacute;tulo</label>
									<div class="grupo-control">
										<input type="text" id="titulo" class="numero form-control" name="serologia[titulo]" pattern="^\d*(\.\d{1,2})?$" required autocomplete="off" />
										<span>U</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<input type="text" name="serologia[resultado]" class="form-control w-100"/>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>