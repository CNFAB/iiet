create view v_cant_localidades as
	select
		departamento,
		count(departamento) as cantidad
	from
		localidades 
	group by
		departamento;


create view v_cant_barrios as
	select
		localidad,
		count(localidad) as cantidad
	from
		barrios
	group by
		localidad;


create view v_cant_parajes as
	select
		localidad,
		count(localidad) as cantidad
	from
		parajes
	group by
		localidad;


create view v_cant_puestos as
	select
		paraje,
		count(paraje) as cantidad
	from
		puestos
	group by
		paraje;
		

create view v_cant_escuelas_barrio as
	select
		barrio,
		count(barrio) as cantidad
	from
		barrio_escuela
	group by
		barrio;
		

create view v_cant_escuelas_paraje as
	select
		paraje,
		count(paraje) as cantidad
	from
		paraje_escuela
	group by
		paraje;


create view v_campanias as
	select
		campanias.numero,
		campanias.nombre,
		fecha_inicio,
		fecha_fin,
		basal_control,
		'BARRIO' as tipo,
		barrios.nombre as lugar
	from
		campanias
	join
		barrio_campania
	on
		campanias.numero = barrio_campania.campania
	join
		barrios
	on
		barrio_campania.barrio = barrios.numero

	union

	select
		campanias.numero,
		campanias.nombre,
		fecha_inicio,
		fecha_fin,
		basal_control,
		'PARAJE' as tipo,
		parajes.nombre as lugar
	from
		campanias
	join
		paraje_campania
	on
		campanias.numero = paraje_campania.campania
	join
		parajes
	on
		paraje_campania.paraje = parajes.numero

	union

	select
		campanias.numero,
		campanias.nombre,
		fecha_inicio,
		fecha_fin,
		basal_control,
		'ESCUELA' as tipo,
		escuelas.nombre as lugar
	from
		campanias
	join
		campanias_escuelas
	on
		campanias.numero = campanias_escuelas.campania

	join
		escuelas
	on
		campanias_escuelas.escuela = escuelas.numero;