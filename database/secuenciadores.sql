/** secuenciador para la tabla Departamentos */
create or replace function secuenciador_departamentos() returns trigger as
$$

declare 
	consulta_departamentos cursor for
		select max(numero) from Departamentos;
	ultimo_departamento DOM_NO_NEGATIVO;

begin
	OPEN consulta_departamentos;
	fetch consulta_departamentos into ultimo_departamento;
	close consulta_departamentos;

	if ultimo_departamento is null then
		ultimo_departamento := 0;
	end if;

	NEW.numero := ultimo_departamento + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_departamentos before insert on Departamentos for each row execute procedure secuenciador_departamentos();



/** secuenciador para la tabla Localidades */
create or replace function secuenciador_localidades() returns trigger as
$$

declare 
	consulta_localidades cursor for
		select max(numero) from Localidades;
	ultima_localidad DOM_NO_NEGATIVO;

begin
	OPEN consulta_localidades;
	fetch consulta_localidades into ultima_localidad;
	close consulta_localidades;

	if ultima_localidad is null then
		ultima_localidad := 0;
	end if;

	NEW.numero := ultima_localidad + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_localidades before insert on Localidades for each row execute procedure secuenciador_localidades();



/** secuenciador para la tabla Barrios */
create or replace function secuenciador_barrios() returns trigger as
$$

declare 
	consulta_barrios cursor for
		select max(numero) from Barrios;
	ultimo_barrio DOM_NO_NEGATIVO;

begin
	OPEN consulta_barrios;
	fetch consulta_barrios into ultimo_barrio;
	close consulta_barrios;

	if ultimo_barrio is null then
		ultimo_barrio := 0;
	end if;

	NEW.numero := ultimo_barrio + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_barrios before insert on Barrios for each row execute procedure secuenciador_barrios();



/** secuenciador para la tabla Parajes */
create or replace function secuenciador_parajes() returns trigger as
$$

declare 
	consulta_parajes cursor for
		select max(numero) from Parajes;
	ultimo_paraje DOM_NO_NEGATIVO;

begin
	OPEN consulta_parajes;
	fetch consulta_parajes into ultimo_paraje;
	close consulta_parajes;

	if ultimo_paraje is null then
		ultimo_paraje := 0;
	end if;

	NEW.numero := ultimo_paraje + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_parajes before insert on Parajes for each row execute procedure secuenciador_parajes();



/** secuenciador para la tabla Puestos */
create or replace function secuenciador_puestos() returns trigger as
$$

declare
	consulta_puestos cursor for
		select max(numero) from Puestos;
	ultimo_puesto DOM_NO_NEGATIVO;

begin
	OPEN consulta_puestos;
	fetch consulta_puestos into ultimo_puesto;
	close consulta_puestos;

	if ultimo_puesto is null then
		ultimo_puesto := 0;
	end if;

	NEW.numero := ultimo_puesto + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_puestos before insert on Puestos for each row execute procedure secuenciador_puestos();



/** secuenciador para la tabla Escuelas */
create or replace function secuenciador_escuelas() returns trigger as
$$

declare
	consulta_escuelas cursor for
		select max(numero) from Escuelas;
	ultima_escuela DOM_NO_NEGATIVO;

begin
	OPEN consulta_escuelas;
	fetch consulta_escuelas into ultima_escuela;
	close consulta_escuelas;

	if ultima_escuela is null then
		ultima_escuela := 0;
	end if;

	NEW.numero := ultima_escuela + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_escuelas before insert on escuelas for each row execute procedure secuenciador_escuelas();



/** secuenciador para la tabla Pacientes */
create or replace function secuenciador_pacientes() returns trigger as
$$

declare 
	consulta_pacientes cursor for
		select max(numero) from Pacientes;
	ultimo_paciente DOM_NO_NEGATIVO;

begin
	OPEN consulta_pacientes;
	fetch consulta_pacientes into ultimo_paciente;
	close consulta_pacientes;

	if ultimo_paciente is null then
		ultimo_paciente := 0;
	end if;

	NEW.numero := ultimo_paciente + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_pacientes before insert on Pacientes for each row execute procedure secuenciador_pacientes();



/** secuenciador para la tabla IntervencionesGeohelmintos */
create or replace function secuenciador_intervencionesgeo() returns trigger as
$$

declare
	consulta_intervenciones cursor for
		select max(numero) from Intervenciones_geohelmintos;
	ultima_intervencion DOM_NO_NEGATIVO;

begin
	OPEN consulta_intervenciones;
	fetch consulta_intervenciones into ultima_intervencion;
	close consulta_intervenciones;

	if ultima_intervencion is null then
		ultima_intervencion := 0;
	end if;

	NEW.numero := ultima_intervencion + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_intervencionesgeo before insert on Intervenciones_geohelmintos for each row execute procedure secuenciador_intervencionesgeo();



/** secuenciador para la tabla Campanias */
create or replace function secuenciador_campanias() returns trigger as
$$

declare
	consulta_campanias cursor for
		select max(numero) from Campanias;
	ultima_campania DOM_NO_NEGATIVO;

begin
	OPEN consulta_campanias;
	fetch consulta_campanias into ultima_campania;
	close consulta_campanias;

	if ultima_campania is null then
		ultima_campania := 0;
	end if;

	NEW.numero :=  ultima_campania + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_campanias before insert on campanias for each row execute procedure secuenciador_campanias();



/** secuenciador para la tabla CentrosSalud */
create or replace function secuenciador_centrossalud() returns trigger as
$$

declare
	consulta_centrossalud cursor for
		select max(numero) from Centros_salud;
	ultimo_centrosalud DOM_NO_NEGATIVO;

begin
	OPEN consulta_centrossalud;
	fetch consulta_centrossalud into ultimo_centrosalud;
	close consulta_centrossalud;

	if ultimo_centrosalud is null then
		ultimo_centrosalud := 0;
	end if;

	NEW.numero := ultimo_centrosalud + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_centrossalud before insert on Centros_salud for each row execute procedure secuenciador_centrossalud();







/** secuenciador para la tabla Usuarios */
create or replace function secuenciador_usuarios() returns trigger as
$$

declare
	consulta_usuarios cursor for
		select max(numero) from Usuarios;
	ultimo_usuario DOM_NO_NEGATIVO;

begin
	OPEN consulta_usuarios;
	fetch consulta_usuarios into ultimo_usuario;
	close consulta_usuarios;

	if ultimo_usuario is null then
		ultimo_usuario := 0;
	end if;

	NEW.numero := ultimo_usuario + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_usuarios before insert on Usuarios for each row execute procedure secuenciador_usuarios();







/** secuenciador para la tabla Consultas */
create or replace function secuenciador_consultas() returns trigger as
$$

declare
	consulta_consultas cursor for
		select max(numero) from Consultas;
	ultima_consulta DOM_NO_NEGATIVO;

begin
	OPEN consulta_consultas;
	fetch consulta_consultas into ultima_consulta;
	close consulta_consultas;

	if ultima_consulta is null then
		ultima_consulta := 0;
	end if;

	NEW.numero := ultima_consulta + 1;

	return NEW;
end;

$$
language plpgsql;

create trigger t_secuenciador_consultas before insert on Consultas for each row execute procedure secuenciador_consultas();