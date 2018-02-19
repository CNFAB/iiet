create table departamentos ( -- *
	numero DOM_POSITIVO,
	nombre DOM_NOMBRE not null,
	latitud DOM_COORDENADAS,
	longitud DOM_COORDENADAS,

	constraint pk_departamento primary key (numero),

	constraint chk_departamento_coord_no_nulo check (
		(latitud is not null and longitud is not null)
		or
		(latitud is null and longitud is null)
	)
);

create table localidades ( -- *
	numero DOM_POSITIVO,
	departamento DOM_POSITIVO not null,
	nombre DOM_NOMBRE not null,
	latitud DOM_COORDENADAS,
	longitud DOM_COORDENADAS,

	constraint pk_localidad primary key (numero),

	constraint fk_localidad_departamento foreign key (departamento) references departamentos (numero)
		match full on delete restrict on update cascade,

	constraint chk_localidad_coord_no_nulo check (
		(latitud is not null and longitud is not null)
		or
		(latitud is null and longitud is null)
	)
);

create table barrios ( -- *
	numero DOM_POSITIVO,
	localidad DOM_POSITIVO not null,
	nombre DOM_NOMBRE not null,
	latitud DOM_COORDENADAS,
	longitud DOM_COORDENADAS,

	constraint pk_barrio primary key (numero),

	constraint fk_barrio_localidad foreign key (localidad) references localidades (numero)
		match full on delete restrict on update cascade,

	constraint chk_barrio_coord_no_nulo check (
		(latitud is not null and longitud is not null)
		or
		(latitud is null and longitud is null)
	)
);

create table parajes ( -- *
	numero DOM_POSITIVO,
	localidad DOM_POSITIVO not null,
	nombre DOM_NOMBRE not null,
	latitud DOM_COORDENADAS,
	longitud DOM_COORDENADAS,

	constraint pk_paraje primary key (numero),

	constraint fk_paraje_localidad foreign key (localidad) references localidades (numero)
		match full on delete restrict on update cascade,

	constraint chk_paraje_coord_no_nulo check (
		(latitud is not null and longitud is not null)
		or
		(latitud is null and longitud is null)
	)
);

create table puestos ( -- *
	numero DOM_POSITIVO,
	paraje DOM_POSITIVO not null,
	nombre DOM_NOMBRE not null,
	latitud DOM_COORDENADAS,
	longitud DOM_COORDENADAS,

	constraint pk_puesto primary key (numero),

	constraint fk_puesto_paraje foreign key (paraje) references parajes (numero)
		match full on delete restrict on update cascade,

	constraint chk_puesto_coord_no_nulo check (
		(latitud is not null and longitud is not null)
		or
		(latitud is null and longitud is null)
	)
);


----------------------------------------------------------------------------------------------
--------------------------------------- ESCUELAS ---------------------------------------------
----------------------------------------------------------------------------------------------

create table escuelas ( -- *
	numero DOM_POSITIVO,
	nombre DOM_NOMBRE not null,
	latitud DOM_COORDENADAS,
	longitud DOM_COORDENADAS,

	constraint pk_escuela primary key (numero),

	constraint chk_escuela_coord_no_nulo check (
		(latitud is not null and longitud is not null)
		or
		(latitud is null and longitud is null)
	)
);

create table barrio_escuela ( -- *
	escuela DOM_POSITIVO,
	barrio DOM_POSITIVO,

	constraint pk_barrioescuela primary key (escuela),

	constraint fk_barrio_escuela foreign key (escuela) references escuelas(numero)
		match full on delete restrict on update cascade,
	constraint fk_escuela_barrio foreign key (barrio) references barrios(numero)
		match full on delete restrict on update cascade
);

create table paraje_escuela ( -- *
	escuela DOM_POSITIVO,
	paraje DOM_POSITIVO,

	constraint pk_parajeescuela primary key (escuela),

	constraint fk_paraje_escuela foreign key (escuela) references escuelas (numero)
		match full on delete restrict on update cascade,
	constraint fk_escuela_paraje foreign key (paraje) references parajes (numero)
		match full on delete restrict on update cascade
);


----------------------------------------------------------------------------------------------
-------------------------------------- PACIENTES ---------------------------------------------
----------------------------------------------------------------------------------------------

create table pacientes ( -- *
	numero DOM_POSITIVO,
	nro_cuaderno DOM_POSITIVO,
	dni DOM_DNI,
	apellido DOM_NOMBRE not null,
	nombre DOM_NOMBRE not null,
	sexo DOM_SEXO not null,
	fecha_nacimiento date,
	fecha_carga date,
	domicilio text,
	nro_familia DOM_POSITIVO,
	nro_vivienda DOM_POSITIVO,

	constraint pk_paciente primary key (numero),

	constraint u_paciente_dni unique (dni)
);

create table barrio_paciente ( -- *
	paciente DOM_POSITIVO,
	barrio DOM_POSITIVO,

	constraint pk_barriopaciente primary key (paciente),

	constraint fk_barrio_paciente foreign key (paciente) references pacientes (numero)
		match full on delete restrict on update cascade,
	constraint fk_paciente_barrio foreign key (barrio) references barrios (numero)
		match full on delete restrict on update cascade
);

create table puesto_paciente ( -- *
	paciente DOM_POSITIVO,
	puesto DOM_POSITIVO,

	constraint pk_localidadparajepaciente primary key (paciente),

	constraint fk_puesto_paciente foreign key (paciente) references pacientes (numero)
		match full on delete restrict on update cascade,
	constraint fk_paciente_puesto foreign key (puesto) references puestos (numero)
		match full on delete restrict on update cascade
);


-----------------------------------------------------------------------------------------------
------------------------------------- INTERVENCIONES ------------------------------------------
-----------------------------------------------------------------------------------------------

create table intervenciones_geohelmintos ( -- *
	numero DOM_POSITIVO,
	paciente DOM_POSITIVO not null,

	constraint pk_intervenciongeohelmintos primary key (numero),

	constraint fk_intervenciongeohelmintos_paciente foreign key (paciente) references pacientes (numero)
		match full on delete restrict on update cascade
);


       ------------------------------- COPROPARASITOLOGICO ----------------------------------

create table coproparasitologico ( -- *
	intervencion DOM_POSITIVO,
	fecha date,
	peso_materia DOM_R_POSITIVO,
	consistencia DOM_CONSISTENCIA,

	constraint pk_copro primary key (intervencion),

	constraint fk_copro_intervencion foreign key (intervencion) references intervenciones_geohelmintos (numero)
		match full on delete restrict on update cascade
);

create table concentrado ( -- *
	copro DOM_POSITIVO,
	ascaris boolean default false not null,
	giardia boolean default false not null,
	entamoebacoli boolean default false not null,
	uncinarias boolean default false not null,
	strongyloides boolean default false not null,
	hymenolepis boolean default false not null,
	trichuris boolean default false not null,
	enterobius boolean default false not null,
	taenia boolean default false not null,

	constraint pk_concentrado primary key (copro),

	constraint fk_concentrado_copro foreign key (copro) references coproparasitologico (intervencion)
		match full on delete restrict on update cascade
);

create table harada_mori ( -- *
	copro DOM_POSITIVO,
	strongyloides DOM_CUALITATIVO not null,
	ancylostoma DOM_CUALITATIVO not null,
	necator DOM_CUALITATIVO not null,
	enterobius DOM_CUALITATIVO not null,

	constraint pk_haradamori primary key (copro),

	constraint fk_haradamori_copro foreign key (copro) references coproparasitologico (intervencion)
		match full on delete restrict on update cascade
);

create table baerman ( -- *
	copro DOM_POSITIVO,
	strongyloides DOM_CUALITATIVO not null,
	ancylostoma DOM_CUALITATIVO not null,
	necator DOM_CUALITATIVO not null,

	constraint pk_baerman primary key (copro),

	constraint fk_baerman_copro foreign key (copro) references coproparasitologico (intervencion)
		match full on delete restrict on update cascade
);

create table mc_master ( -- *
	copro DOM_POSITIVO,
	ascaris DOM_NO_NEGATIVO not null,
	uncinarias DOM_NO_NEGATIVO not null,
	hymenolepis DOM_NO_NEGATIVO not null,
	trichuris DOM_NO_NEGATIVO not null,
	enterobius DOM_NO_NEGATIVO not null,
	taenia DOM_NO_NEGATIVO not null,

	constraint pk_mcmaster primary key (copro),

	constraint fk_mcmaster_copro foreign key (copro) references coproparasitologico (intervencion)
		match full on delete restrict on update cascade
);

create table placa_agar ( -- *
	copro DOM_POSITIVO,
	strongyloides DOM_CUALITATIVO not null,
	ancylostoma DOM_CUALITATIVO not null,
	necator DOM_CUALITATIVO not null,

	constraint pk_placaagar primary key (copro),

	constraint fk_placaagar_copro foreign key (copro) references coproparasitologico (intervencion)
		match full on delete restrict on update cascade
);



----------------------------------- BIOLOGIA MOLECULAR -----------------------------

create table biologia_molecular ( -- *
	intervencion DOM_POSITIVO,
	fuente DOM_FUENTE_BM,

	constraint pk_biologiamolecular primary key (intervencion),

	constraint fk_biologiamolecular_intervencion foreign key (intervencion) references intervenciones_geohelmintos (numero)
		match full on delete restrict on update cascade
);

create table pcr ( -- *
	bio_molec DOM_POSITIVO,
	strongyloides boolean,
	ancylostoma boolean,
	necator boolean,
	ascaris boolean,
	trichuris boolean,

	constraint pk_pcr primary key (bio_molec),

	constraint fk_pcr foreign key (bio_molec) references biologia_molecular (intervencion)
		match full on delete restrict on update cascade,

	constraint ck_pcr_nonulo check (
		strongyloides is not null or
		ancylostoma is not null or
		necator is not null or
		ascaris is not null or
		trichuris is not null
	)
);

create table qpcr ( -- *
	bio_molec DOM_POSITIVO,
	strongyloides boolean,
	ancylostoma boolean,
	necator boolean,
	ascaris boolean,
	trichuris boolean,

	constraint pk_qpcr primary key (bio_molec),

	constraint fk_qpcr foreign key (bio_molec) references biologia_molecular (intervencion)
		match full on delete restrict on update cascade,

	constraint ck_qpcr_nonulo check (
		strongyloides is not null or
		ancylostoma is not null or
		necator is not null or
		ascaris is not null or
		trichuris is not null
	)
);


       --------------------------------- SANGRE ------------------------------------

create table sangre ( -- *
	intervencion DOM_POSITIVO,
	fecha date,
	nro_tubo DOM_NRO_TUBO,

	constraint pk_sangre primary key (intervencion),

	constraint fk_sangre_intervencion foreign key (intervencion) references intervenciones_geohelmintos (numero)
		match full on delete restrict on update cascade
);

create table hemogramas ( -- *
	sangre DOM_POSITIVO,
	globulos_blancos DOM_R_POSITIVO not null,
	hemoglobina DOM_R_POSITIVO not null,
	eosinofilos DOM_R_POSITIVO not null,

	constraint pk_hemogramas primary key (sangre),

	constraint fk_hemograma_sangre foreign key (sangre) references sangre (intervencion)
		match full on delete restrict on update cascade
);

create table serologia_strongyloides ( -- *
	sangre DOM_POSITIVO,
	resultado DOM_RESULT_SEROLOGIA not null,
	titulo DOM_R_POSITIVO not null,

	constraint pk_serologia primary key (sangre),

	constraint fk_serologia_sangre foreign key (sangre) references sangre (intervencion)
		match full on delete restrict on update cascade
);


       ------------------------------------- TRATAMIENTOS ----------------------------------------
       
create table tratamientos ( -- *
	intervencion DOM_POSITIVO,
	fecha date,

	constraint pk_tratamiento primary key (intervencion),

	constraint fk_tratamiento_intervencion foreign key (intervencion) references intervenciones_geohelmintos (numero)
		match full on delete restrict on update cascade
);

create table medidas_antropometricas ( -- *
	tratamiento DOM_POSITIVO,
	peso DOM_R_POSITIVO,
	talla DOM_R_POSITIVO,
	perimetro_cefalico DOM_R_POSITIVO,

	constraint pk_medidasantropometricas primary key (tratamiento),

	constraint fk_medidasantropometricas_intervencion foreign key (tratamiento) references tratamientos (intervencion)
		match full on delete restrict on update cascade,

	constraint ck_medidasantropometricas_nonulo check (
		peso is not null or
		talla is not null or
		perimetro_cefalico is not null
	)
);

create table tratamientos_previos ( -- *
	tratamiento_actual DOM_POSITIVO,
	fecha date,
	mebendazol boolean not null,
	albendazol boolean not null,
	ivermectina boolean not null,
	metronidazol boolean not null,
	otras text,

	constraint pk_tratamientoprevio primary key (tratamiento_actual),

	constraint fk_tratamientoprevio_tratamiento foreign key (tratamiento_actual) references tratamientos (intervencion)
		match full on delete restrict on update cascade
);

create table dosis_drogas ( -- *
	tratamiento DOM_POSITIVO,
	droga DOM_DROGAS not null,
	dosis DOM_POSITIVO,
	exclusion DOM_EXCLUSION,

	constraint pk_dosisdroga primary key (tratamiento, droga),

	constraint fk_dosisdroga_tratamiento foreign key (tratamiento) references tratamientos (intervencion)
		match full on delete restrict on update cascade,

	constraint ck_exclusion_droga check (
		(dosis is null and exclusion is not null) or
		(dosis is not null and exclusion is null)
	)
);



-----------------------------------------------------------------------------------------------
----------------------------- CAMPAÑAS Y CONSULTORIO EXTERNO ----------------------------------
-----------------------------------------------------------------------------------------------


-- GRUPO DE CAMPAÑAS

create table campanias ( -- *
	numero DOM_POSITIVO,
	fecha_inicio date not null,
	fecha_fin date not null,
	nombre DOM_NOMBRE,
	basal_control DOM_BASAL not null,

	constraint pk_campania primary key (numero),

	constraint u_campania_nombre unique (nombre)
);

create table campanias_barrios ( -- *
	campania DOM_POSITIVO,
	barrio DOM_POSITIVO not null,

	constraint pk_barriocampania primary key (campania),

	constraint fk_barrio_campania foreign key (campania) references campanias (numero)
		match full on delete restrict on update cascade,
	constraint fk_campania_barrio foreign key (barrio) references barrios (numero)
		match full on delete restrict on update cascade
);

create table intervenciones_barrios (
	intervencion DOM_POSITIVO,
	campania_barrio DOM_POSITIVO,
	domicilio text,
	nro_familia DOM_POSITIVO,
	nro_vivienda DOM_POSITIVO,

	constraint pk_intervencionbarrio primary key (intervencion),

	constraint fk_intervencion_campaniabarrio foreign key (intervencion) references intervenciones_geohelmintos (numero)
		match full on delete restrict on update cascade,
	constraint fk_campaniabarrio_intervencion foreign key (campania_barrio) references campanias_barrios (campania)
		match full on delete restrict on update cascade
);

create table campanias_puestos ( -- *
	campania DOM_POSITIVO,
	puesto DOM_POSITIVO not null,

	constraint pk_puestocampania primary key (campania),

	constraint fk_puesto_campania foreign key (campania) references campanias (numero)
		match full on delete restrict on update cascade,
	constraint fk_campania_puesto foreign key (puesto) references puestos (numero)
		match full on delete restrict on update cascade
);

create table intervenciones_puestos ( -- *
	intervencion DOM_POSITIVO,
	campania_puesto DOM_POSITIVO,
	domicilio text,
	nro_familia DOM_POSITIVO,
	nro_vivienda DOM_POSITIVO,

	constraint pk_intervencionpuesto primary key (intervencion),

	constraint fk_intervencion_campaniapuesto foreign key (intervencion) references intervenciones_geohelmintos (numero)
		match full on delete restrict on update cascade,
	constraint fk_campaniapuesto_intervencion foreign key (campania_puesto) references campanias_puestos (campania)
		match full on delete restrict on update cascade
);

create table campanias_escuelas ( -- *
	campania DOM_POSITIVO,
	escuela DOM_POSITIVO not null,

	constraint pk_campaniaescuela primary key (campania),

	constraint fk_escuela_campania foreign key (campania) references campanias (numero)
		match full on delete restrict on update cascade,
	constraint fk_campania_escuela foreign key (escuela) references escuelas (numero)
		match full on delete restrict on update cascade
);

create table intervenciones_escuelas ( -- *
	intervencion DOM_POSITIVO,
	campania_escuela DOM_POSITIVO not null,

	constraint pk_intervencionescuela primary key (intervencion),

	constraint fk_escuela_intervencion foreign key (intervencion) references intervenciones_geohelmintos (numero)
		match full on delete restrict on update cascade,
	constraint fk_intervencion_campaniaescuela foreign key (campania_escuela) references campanias_escuelas (campania)
		match full on delete restrict on update cascade
);

/*create table factores_riesgo ( -- *
	intervencion DOM_POSITIVO,
	red_dom_y_cloaca boolean default false,
	tratamiento_agua DOM_TRAT_AGUA default false,
	dse DOM_DSE,
	tsb DOM_TSB,
	piso_vivienda DOM_PISO_VIVIENDA,
	desempl_ingr_econ_inest boolean default false,
	analfab_pers_cargo_menores boolean default false,
	familia_riesgo boolean default false,

	constraint pk_factoresriesgo primary key (intervencion),

	constraint fk_factoresriesgo_intervencion foreign key (intervencion) references intervencion_comunidad (intervencion)
		match full on delete restrict on update cascade,

	constraint ck_factoresriesgo_nonulo check ( -- REVISAR
		red_dom_y_cloaca is not null or
		tratamiento_agua is not null or
		dse is not null or
		tsb is not null or
		piso_vivienda is not null or
		desempl_ingr_econ_inest is not null
	)
);*/


-- CONSULTORIO EXTERNO

create table centros_salud ( -- *
	numero DOM_POSITIVO,
	codigo DOM_NRO_ROMANO,
	nombre DOM_NOMBRE not null,
	latitud DOM_COORDENADAS,
	longitud DOM_COORDENADAS,

	constraint pk_centrosalud primary key (numero),

	constraint u_centrosalud_codigo unique (codigo),

	constraint chk_centrosalud_coord_no_nulo check (
		(latitud is not null and longitud is not null)
		or
		(latitud is null and longitud is null)
	)
);

create table barrio_centro_salud ( -- *
	centro_salud DOM_POSITIVO,
	barrio DOM_POSITIVO not null,

	constraint pk_barriocentrosalud primary key (centro_salud),

	constraint fk_barrio_centrosalud foreign key (centro_salud) references centros_salud (numero)
		match full on delete restrict on update cascade,
	constraint fk_centrosalud_barrio foreign key (barrio) references barrios (numero)
		match full on delete restrict on update cascade
);

create table paraje_centro_salud (-- *
	centro_salud DOM_POSITIVO,
	paraje DOM_POSITIVO not null,

	constraint pk_parajecentrosalud primary key (centro_salud),

	constraint fk_paraje_centrosalud foreign key (centro_salud) references centros_salud (numero)
		match full on delete restrict on update cascade,
	constraint fk_centrosalud_paraje foreign key (paraje) references parajes (numero)
		match full on delete restrict on update cascade
);

create table consultorio_externo ( -- *
	intervencion DOM_POSITIVO,
	domicilio text,
	procedencia DOM_POSITIVO,

	constraint pk_consultorioexterno primary key (intervencion),

	constraint fk_consultorioexterno_intervencion foreign key (intervencion) references intervenciones_geohelmintos (numero)
		match full on delete restrict on update cascade,

	constraint fk_consultorioexterno_procedencia foreign key (procedencia) references centros_salud (numero)
		match full on delete restrict on update cascade
);

create table barrio_consultorio_externo ( -- *
	intervencion DOM_POSITIVO,
	barrio DOM_POSITIVO not null,

	constraint pk_barrioconsultorioexterno primary key (intervencion),

	constraint fk_barrio_consultorioexterno foreign key (intervencion) references consultorio_externo (intervencion)
		match full on delete restrict on update cascade,
	constraint fk_consultorioexterno_barrio foreign key (barrio) references barrios (numero)
		match full on delete restrict on update cascade
);

create table puesto_consultorio_externo ( -- *
	intervencion DOM_POSITIVO,
	puesto DOM_POSITIVO not null,

	constraint pk_puestoconsultorioexterno primary key (intervencion),

	constraint fk_puesto_consultorioexterno foreign key (intervencion) references consultorio_externo (intervencion)
		match full on delete restrict on update cascade,
	constraint fk_consultorioexterno_puesto foreign key (puesto) references puestos (numero)
		match full on delete restrict on update cascade
);

create table diagnostico_presuntivo ( -- *
	consultorio_externo DOM_POSITIVO,
	control boolean default false not null,
	bajo_peso boolean default false not null,
	anemia boolean default false not null,
	diarrea boolean default false not null,
	estrenimiento boolean default false not null,
	manchas_piel boolean default false not null,
	priurito_anal boolean default false not null,
	bruxismo boolean default false not null,
	dolor_abdominal boolean default false not null,
	otros text,

	constraint pk_diagnosticopresuntivo primary key (consultorio_externo),

	constraint fk_diagnosticopresuntivo_consultorioexterno foreign key (consultorio_externo) references consultorio_externo (intervencion)
		match full on delete restrict on update cascade
);
/*
create table Usuarios ( -- desde PHP
	numero DOM_POSITIVO,
	tipo DOM_USUARIOS not null,
	nombre DOM_NOMBRE not null,
	apellido DOM_NOMBRE not null,
	clave DOM_CLAVE not null,

	constraint pk_usuario primary key (numero)
);



create table Consultas (
	numero DOM_POSITIVO,
	usuario DOM_POSITIVO not null,
	nombre DOM_NOMBRE not null,
	fecha date not null,
	hora time not null,
	texto_sql DOM_SQL not null,
	publico boolean not null,

	constraint pk_consulta primary key (numero),

	constraint fk_consulta_usuario foreign key (usuario) references Usuarios (numero)
		match full on delete restrict on update cascade
);
*/