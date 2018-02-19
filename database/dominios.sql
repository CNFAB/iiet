
                  --------------------------------------------------------------------------------------------
                  --------------------------------------------------------------------------------------------
                  --------------------------------                            --------------------------------
                  --------------------------------          DOMINIOS          --------------------------------
                  --------------------------------                            --------------------------------
                  --------------------------------------------------------------------------------------------
                  --------------------------------------------------------------------------------------------



drop domain DOM_NOMBRE cascade;
drop domain DOM_POSITIVO cascade;
drop domain DOM_NO_NEGATIVO cascade;
drop domain DOM_R_POSITIVO cascade;
drop domain DOM_R_NO_NEGATIVO cascade;
drop domain DOM_DNI cascade;
drop domain DOM_SEXO cascade;

drop domain DOM_CUALITATIVO cascade;
drop domain DOM_NRO_TUBO cascade;
drop domain DOM_DROGAS cascade;
drop domain DOM_EXCLUSION cascade;
drop domain DOM_TRAT_AGUA cascade;
drop domain DOM_DSE cascade;
drop domain DOM_TSB cascade;
drop domain DOM_PISO_VIVIENDA cascade;
drop domain DOM_COORDENADAS cascade;
drop domain DOM_CONSISTENCIA cascade;
drop domain DOM_NRO_ROMANO cascade;
drop domain DOM_FUENTE_BM cascade;




create domain DOM_NOMBRE as text;
create domain DOM_POSITIVO as integer check (value > 0);
create domain DOM_NO_NEGATIVO as integer check (value >= 0);
create domain DOM_R_POSITIVO as float(2) check (value > 0);
create domain DOM_R_NO_NEGATIVO as float(2) check (value >= 0);
create domain DOM_DNI as integer check (value > 1000000 and value < 100000000);
create domain DOM_SEXO as char(9) check (value in ('MASCULINO', 'FEMENINO'));

create domain DOM_CUALITATIVO as varchar(8) check (value in('+', '++', '+++', 'NEGATIVO'));
create domain DOM_NRO_TUBO as varchar(10) check (value ~ E'^[A-Z]{3}-\\d{3}-\\d{2}$');
create domain DOM_DROGAS as varchar(11) check (value in ('ALBENDAZOL', 'MEBENDAZOL', 'IVERMECTINA'));
create domain DOM_EXCLUSION as varchar(16) check (value in ('NO SUMINISTRADO', 'AUSENTE', 'RECHAZO', 'EMBARAZO', 'PUERPERIO', 'MENOR A 12 MESES', 'MENOS DE 15 KG'));
create domain DOM_TRAT_AGUA as varchar(2) check (value in ('CL', 'F', 'H', 'P', 'NO'));
create domain DOM_DSE as varchar(2) check (value in ('CP', 'L', 'RC', 'NO'));
create domain DOM_TSB as varchar(2) check (value in ('R', 'PB', 'NO'));
create domain DOM_PISO_VIVIENDA as varchar(17) check (value in ('MOSAICO / BALDOSA', 'CEMENTO', 'TIERRA', 'LOSA', 'OTROS'));
create domain DOM_COORDENADAS as float(4);
create domain DOM_CONSISTENCIA as varchar(7) check (value in ('SOLIDA', 'PASTOSA', 'LIQUIDA'));
create domain DOM_NRO_ROMANO as varchar(15) check (value ~ E'^M{0,3}(D?C{0,3}|CD|CM)(L?X{0,3}|XL|XC)(I{0,3}|IV|VI{0,3}|IX)$');
create domain DOM_FUENTE_BM as varchar(13) check (value in ('MATERIA FECAL', 'ORINA'));
create domain DOM_BASAL as text check (value ~ E'^(Basal \\d+|Control \\d+)$');
create domain DOM_RESULT_SEROLOGIA as text check (value in ('POSITIVO', 'NEGATIVO'));


create domain DOM_CLAVE as varchar(256);
create domain DOM_USUARIOS as integer check (value in (1, 2, 3, 4));


create domain DOM_SQL as text check (value ~ E'^SELECT (\\*|\\w+(_\\w+)*(,\\w+(_\\w+)*)*) FROM \\w+(_\\w+)*( WHERE \\w+(_\\w+)* ((=|<|<=|>=|>|<>) (\\w+(_\\w+)*|\\'\\w+(_\\w+)*\\')|IS (NOT )?NULL)( (AND|OR) \\w+(_\\w+)* ((=|<|<=|>=|>|<>) (\\w+(_\\w+)*|\\'\\w+(_\\w+)*\\')|IS (NOT )?NULL))*);$');