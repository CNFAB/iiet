<form id="form_estudios" name="form_copro" action="/iiet/intervenciones/cargar_copro" class="mb-3 d-none">
	<div class="form-row justify-content-center">
		<div class="form-group mr-4" style="position: relative;">
			<label for="fc-fecha">Fecha</label>
			<input type="date" name="fecha" id="fc-fecha" class="form-control validar" required="required" />
			<div class="invalid-tooltip msj-invalido">La <span class="font-weight-bold">fecha</span> es obligatoria y no debe ser posterior a la fecha actual</div>
		</div>
		<div class="form-group mr-5" style="position: relative;">
			<label for="fc-peso">Peso</label>
			<input type="text" id="fc-peso" class="numero form-control validar" required="required" name="peso_materia" pattern="^\d+(.\d+)?$" autocomplete="off" />
			<span>g</span>
			<div class="invalid-tooltip msj-invalido">El <span class="font-weight-bold">peso</span> es obligatorio y debe contener sólo números</div>
		</div>
		<div class="form-group mr-5">
			<label for="fc-consistencia">Consistencia</label>
			<select name="consistencia" class="custom-select input-requerido" id="fc-consistencia">
				<option value="SOLIDA">SOLIDA</option>
				<option value="PASTOSA">PASTOSA</option>
				<option value="LIQUIDA">LIQUIDA</option>
			</select>
		</div>
		<div class="form-group mr-5">
			<label for="fc-nro-muestra">N° de Muestra</label>
			<input type="number" id="fc-nro-muestra" name="nro_muestra" class="numero form-control" autocomplete="off" />
		</div>
		<div class="form-group">
			<label for="fc-seriado">Seriado</label>
			<input type="number" id="fc-seriado" name="seriado" class="numero form-control" autocomplete="off" />
		</div>
	</div>
	<div class="form-row justify-content-center mt-4 contenedor-metodos">
		<div class="col-3 mr-3">
			<div class="accordion" id="metodo-cc">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-cc">CONCENTRADO<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-cc" class="collapse" data-parent="#metodo-cc">
    <fieldset class="card-body cuerpo-metodo" disabled>
        <input type="hidden" name="concentrado"/><!-- campo auxiliar -->
        
        <!-- Ascaris -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-ascaris" class="custom-control-input" name="concentrado[ascaris]" value="true" />
                    <label for="cc-ascaris" class="custom-control-label">Ascaris lumbricoides</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-ascaris-cantidad" 
                        name="concentrado_cantidad[ascaris]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
        <!-- Giardia -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-giardia" class="custom-control-input" name="concentrado[giardia]" value="true" />
                    <label for="cc-giardia" class="custom-control-label">Giardia lamblia</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-giardia-cantidad" 
                        name="concentrado_cantidad[giardia]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
        <!-- Entamoeba Coli -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-coli" class="custom-control-input" name="concentrado[entamoebacoli]" value="true" />
                    <label for="cc-coli" class="custom-control-label">Entamoeba Coli</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-coli-cantidad" 
                        name="concentrado_cantidad[entamoebacoli]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
        <!-- Uncinarias -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-uncinarias" class="custom-control-input" name="concentrado[uncinarias]" value="true" />
                    <label for="cc-uncinarias" class="custom-control-label">Uncinarias</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-uncinarias-cantidad" 
                        name="concentrado_cantidad[uncinarias]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
        <!-- Strongyloides -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-strongyloides" class="custom-control-input" name="concentrado[strongyloides]" value="true" />
                    <label for="cc-strongyloides" class="custom-control-label">Strongyloides stercolaris</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-strongyloides-cantidad" 
                        name="concentrado_cantidad[strongyloides]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
        <!-- Hymenolepis -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-hymenolepis" class="custom-control-input" name="concentrado[hymenolepis]" value="true" />
                    <label for="cc-hymenolepis" class="custom-control-label">Hymenolepis nana</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-hymenolepis-cantidad" 
                        name="concentrado_cantidad[hymenolepis]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
        <!-- Trichuris -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-trichuris" class="custom-control-input" name="concentrado[trichuris]" value="true" />
                    <label for="cc-trichuris" class="custom-control-label">Trichuris trichiura</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-trichuris-cantidad" 
                        name="concentrado_cantidad[trichuris]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
        <!-- Enterobius -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-enterobius" class="custom-control-input" name="concentrado[enterobius]" value="true" />
                    <label for="cc-enterobius" class="custom-control-label">Enterobius vermicu.</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-enterobius-cantidad" 
                        name="concentrado_cantidad[enterobius]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
        <!-- Taenia -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-taenia" class="custom-control-input" name="concentrado[taenia]" value="true" />
                    <label for="cc-taenia" class="custom-control-label">Taenia</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-taenia-cantidad" 
                        name="concentrado_cantidad[taenia]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
        <!-- Isospora belli -->
        <div class="form-row align-items-center mb-2">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="cc-isosporabelli" class="custom-control-input" name="concentrado[isosporabelli]" value="true" />
                    <label for="cc-isosporabelli" class="custom-control-label">Isospora belli</label>
                </div>
            </div>
            <div class="col-6">
                <select class="custom-select custom-select-sm" 
                        id="cc-isosporabelli-cantidad" 
                        name="concentrado_cantidad[isosporabelli]" 
                        disabled>
                    <option value="">Cantidad</option>
                    <option value="ESCASO">ESCASO</option>
                    <option value="FRECUENTE">FRECUENTE</option>
                    <option value="ABUNDANTE">ABUNDANTE</option>
                </select>
            </div>
        </div>
        
    </fieldset>
</div>
				</div>
			</div>
		</div>
		<div class="col-3 mr-3">
			<div class="accordion" id="metodo-mm">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-mm">MC MASTER<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-mm" class="collapse" data-parent="#metodo-mm">
						<fieldset class="card-body cuerpo-metodo" disabled>
							<div class="form-row">
								<div class="col-12">
									<label for="mm-ascaris">Ascaris lumbricoides</label>
									<div class="grupo-control">
										<input type="number" id="mm-ascaris" class="form-control" name="mc_master[ascaris]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="mm-uncinarias">Uncinarias</label>
									<div class="grupo-control">
										<input type="number" id="mm-uncinarias" class="form-control" name="mc_master[uncinarias]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="mm-hymenolepis">Hymenolepis nana</label>
									<div class="grupo-control">
										<input type="number" id="mm-hymenolepis" class="form-control" name="mc_master[hymenolepis]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="mm-trichuris">Trichuris trichiura</label>
									<div class="grupo-control">
										<input type="number" id="mm-trichuris" class="form-control" name="mc_master[trichuris]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="mm-enterobius">Enterobius vermicularis</label>
									<div class="grupo-control">
										<input type="number" id="mm-enterobius" class="form-control" name="mc_master[enterobius]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="mm-taenia">Taenia</label>
									<div class="grupo-control">
										<input type="number" id="mm-taenia" class="form-control" name="mc_master[taenia]" required="required" min="0" />
										<span>hpg</span>
									</div>
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
			<div class="accordion" id="metodo-kk">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-kk">KATO-KATZ<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-kk" class="collapse" data-parent="#metodo-kk">
						<fieldset class="card-body cuerpo-metodo" disabled>
							<div class="form-row">
								<div class="col-12">
									<label for="kk-ascaris">Ascaris lumbricoides</label>
									<div class="grupo-control">
										<input type="number" id="kk-ascaris" class="form-control" name="kato_katz[ascaris]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="kk-uncinarias">Uncinarias</label>
									<div class="grupo-control">
										<input type="number" id="kk-uncinarias" class="form-control" name="kato_katz[uncinarias]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="kk-hymenolepis">Hymenolepis nana</label>
									<div class="grupo-control">
										<input type="number" id="kk-hymenolepis" class="form-control" name="kato_katz[hymenolepis]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="kk-trichuris">Trichuris trichiura</label>
									<div class="grupo-control">
										<input type="number" id="kk-trichuris" class="form-control" name="kato_katz[trichuris]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="kk-enterobius">Enterobius vermicularis</label>
									<div class="grupo-control">
										<input type="number" id="kk-enterobius" class="form-control" name="kato_katz[enterobius]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="kk-taenia">Taenia</label>
									<div class="grupo-control">
										<input type="number" id="kk-taenia" class="form-control" name="kato_katz[taenia]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div>
							<!-- <div class="form-row">
								<div class="col-12">
									<label for="kk-isosporabelli">Isospora belli</label>
									<div class="grupo-control">
										<input type="number" id="kk-isosporabelli" class="form-control" name="kato_katz[isosporabelli]" required="required" min="0" />
										<span>hpg</span>
									</div>
								</div>
							</div> -->
						</fieldset>
						<div class="card-footer btn_negativo text-center">
							<button type="button" class="btn-negativo btn btn-link">Completar con Negativos</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-row justify-content-center mt-5 contenedor-metodos">
		<div class="col-3 mr-3">
			<div class="accordion" id="metodo-hm">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-hm">HARADA Y MORI<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-hm" class="collapse" data-parent="#metodo-hm">
						<fieldset class="card-body cuerpo-metodo" disabled>
							<div class="form-row">
								<div class="col-12">
									<label for="hm-strongyloides">Strongyloides stercolaris</label>
									<select id="hm-strongyloides" class="custom-select grupo-control" name="harada_mori[strongyloides]" required="required">
										<option></option>
										<option value="+">+</option>
										<option value="++">++</option>
										<option value="+++">+++</option>
										<option value="NEGATIVO">NEGATIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="hm-ancylostoma">Ancylostoma duodenale</label>
									<select id="hm-ancylostoma" class="custom-select grupo-control" name="harada_mori[ancylostoma]" required="required">
										<option></option>
										<option value="+">+</option>
										<option value="++">++</option>
										<option value="+++">+++</option>
										<option value="NEGATIVO">NEGATIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="hm-necator">Necator</label>
									<select id="hm-necator" class="custom-select grupo-control" name="harada_mori[necator]" required="required">
										<option></option>
										<option value="+">+</option>
										<option value="++">++</option>
										<option value="+++">+++</option>
										<option value="NEGATIVO">NEGATIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="hm-enterobius">Enterobius</label>
									<select id="hm-enterobius" class="custom-select grupo-control" name="harada_mori[enterobius]" required="required">
										<option></option>
										<option value="+">+</option>
										<option value="++">++</option>
										<option value="+++">+++</option>
										<option value="NEGATIVO">NEGATIVO</option>
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
			<div class="accordion" id="metodo-bm">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-bm">BAERMAN<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-bm" class="collapse" data-parent="#metodo-bm">
						<fieldset class="card-body cuerpo-metodo" disabled>
							<div class="form-row">
								<div class="col-12">
									<label for="bm-strongyloides">Strongyloides stercolaris</label>
									<select id="bm-strongyloides" class="custom-select grupo-control" name="baerman[strongyloides]" required="required">
										<option></option>
										<option value="+">+</option>
										<option value="++">++</option>
										<option value="+++">+++</option>
										<option value="NEGATIVO">NEGATIVO</option>
									</select>
								</div>
							</div>
							
							<div class="form-row">
								<div class="col-12">
									<label for="bm-uncinarias">uncinarias</label>
									<select id="bm-uncinarias" class="custom-select grupo-control" name="baerman[uncinarias]" required="required">
										<option></option>
										<option value="+">+</option>
										<option value="++">++</option>
										<option value="+++">+++</option>
										<option value="NEGATIVO">NEGATIVO</option>
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
			<div class="accordion" id="metodo-pa">
				<div class="card">
					<div class="card-header cabecera-metodo">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#result-pa">PLACA DE AGAR<div class="fa"></div></button>
						</h5>
					</div>
					<div id="result-pa" class="collapse" data-parent="#metodo-pa">
						<fieldset class="card-body cuerpo-metodo" disabled>
							<div class="form-row">
								<div class="col-12">
									<label for="pa-strongyloides">Strongyloides stercolaris</label>
									<select id="pa-strongyloides" class="custom-select grupo-control" name="placa_agar[strongyloides]" required="required">
										<option></option>
										<option value="+">+</option>
										<option value="++">++</option>
										<option value="+++">+++</option>
										<option value="NEGATIVO">NEGATIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
									<label for="pa-ancylostoma">Ancylostoma duodenale</label>
									<select id="pa-ancylostoma" class="custom-select grupo-control" name="placa_agar[ancylostoma]" required="required">
										<option></option>
										<option value="+">+</option>
										<option value="++">++</option>
										<option value="+++">+++</option>
										<option value="NEGATIVO">NEGATIVO</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-12">
								<label for="pa-necator">Necator</label>
									<select id="pa-necator" class="custom-select grupo-control" name="placa_agar[necator]" required="required">
										<option></option>
										<option value="+">+</option>
										<option value="++">++</option>
										<option value="+++">+++</option>
										<option value="NEGATIVO">NEGATIVO</option>
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