<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Consultas extends CI_Controller {
	
	function __construct() {
		parent::__construct();

		if ($this->ion_auth->logged_in()) {
			$this->usuario = $this->ion_auth->user()->row();
		}

		else
			redirect('usuarios/login', 'refresh');
		//ini_set('memory_limit', '-1');
		//ini_set('max_execution_time', '120');
		$this->nombres_campos = array(
			'intervencion_tipo'           => 'Tipo (Intervención)',
			'intervencion_fecha'          => 'Fecha (Evento)',
			'campania_nombre'             => 'Campaña',
			'campania_fecha'              => 'Fecha (Campaña)',
			'departamento'                => 'Departamento',
			'localidad'                   => 'Localidad',
			'barrio'                      => 'Barrio',
			'paraje'                      => 'Paraje',
			'puesto'                      => 'Puesto',
			'institucion'                 => 'Institución',
			'paciente_numero'             => 'N° Paciente',
			'paciente_apellido'           => 'Apellido',
			'paciente_nombre'             => 'Nombre',
			'paciente_edad'               => 'Edad',
			'paciente_sexo'               => 'Sexo',
			'domicilio_paciente'          => 'Domicilio',
			'copro_fecha'                 => 'Fecha (Copro)',
			'copro_peso'                  => 'Peso (Copro)',
			'copro_consistencia'          => 'Consistencia (Copro)',
			'copro_nro_muestra'           => 'N° Muestra (Copro)',
			'ascaris'                     => 'Ascaris',
			'uncinarias'                  => 'Uncinarias',
			'necator'                     => 'Necator',
			'ancylostoma'                 => 'Ancylostoma',
			'strongyloides'               => 'Strongyloides',
			'trichuris'                   => 'Trichuris',
			'helmintos'                   => 'Helmintos',
			'cc_ascaris'                  => 'Ascaris (CC)',
			'cc_giardia'                  => 'Giardia (CC)',
			'cc_entamoebacoli'            => 'Entamoeba Coli (CC)',
			'cc_uncinarias'               => 'Uncinarias (CC)',
			'cc_strongyloides'            => 'Strongyloides (CC)',
			'cc_hymenolepis'              => 'Hymenolepis (CC)',
			'cc_trichuris'                => 'Trichuris (CC)',
			'cc_enterobius'               => 'Enterobius (CC)',
			'cc_taenia'                   => 'Taenia (CC)',
			'mm_ascaris'                  => 'Ascaris (MM)',
			'mm_uncinarias'               => 'Uncinarias (MM)',
			'mm_hymenolepis'              => 'Hymenolepis (MM)',
			'mm_trichuris'                => 'Trichuris (MM)',
			'mm_enterobius'               => 'Enterobius (MM)',
			'mm_taenia'                   => 'Taenia (MM)',
			'hm_strongyloides'            => 'Strongyloides (HM)',
			'hm_ancylostoma'              => 'Ancylostoma (HM)',
			'hm_necator'                  => 'Necator (HM)',
			'hm_enterobius'               => 'Enterobius (HM)',
			'bm_strongyloides'            => 'Strongyloides (BM)',
			'bm_ancylostoma'              => 'Ancylostoma (BM)',
			'bm_necator'                  => 'Necator (BM)',
			'pa_strongyloides'            => 'Strongyloides (PA)',
			'pa_ancylostoma'              => 'Ancylostoma (PA)',
			'pa_necator'                  => 'Necator (PA)',
			'sangre_fecha'                => 'Fecha (Sangre)',
			'nro_tubo'                    => 'N° Tubo',
			'globulos_blancos'            => 'Glóbulos Blancos',
			'hemoglobina'                 => 'Hemoglobina',
			'eosinofilos'                 => 'Eosinofilos',
			'serolog_titulo'              => 'Título (Serología)',
			'biologmolec_fuente'          => 'Fuente (Biolog. Molec.)',
			'pcr_strongyloides'           => 'Strongyloides (PCR)',
			'pcr_ancylostoma'             => 'Ancylostoma (PCR)',
			'pcr_necator'                 => 'Necator (PCR)',
			'pcr_ascaris'                 => 'Ascaris (PCR)',
			'pcr_trichuris'               => 'Trichuris (PCR)',
			'qpcr_strongyloides'          => 'Strongyloides (QPCR)',
			'qpcr_ancylostoma'            => 'Ancylostoma (QPCR)',
			'qpcr_necator'                => 'Necator (QPCR)',
			'qpcr_ascaris'                => 'Ascaris (QPCR)',
			'qpcr_trichuris'              => 'Trichuris (QPCR)',
			'trat_fecha'                  => 'Fecha (Trat.)',
			'trat_no_tratado'             => 'No Tratado',
			'paciente_peso'               => 'Peso (Paciente)',
			'paciente_talla'              => 'Talla (Paciente)',
			'paciente_perimetro_cefalico' => 'Perímetro Cefálico (Paciente)',
			'tprev_fecha'                 => 'Fecha (Trat. Prev.)',
			'tprev_mebendazol'            => 'Mebendazol (Trat. Prev.)',
			'tprev_albendazol'            => 'Albendazol (Trat. Prev.)',
			'tprev_ivermectina'           => 'Ivermectina (Trat. Prev.)',
			'tprev_metronidazol'          => 'Metronidazol (Trat. Prev.)',
			'tprev_otras'                 => 'Otras (Trat. Prev.)',
			'tact_dosis_albendazol'       => 'Dosis Albendazol',
			'tact_exc_albendazol'         => 'Motiv. Exc. Albendazol',
			'tact_dosis_mebendazol'       => 'Dosis Mebendazol',
			'tact_exc_mebendazol'         => 'Motiv. Exc. Mebendazol',
			'tact_dosis_ivermectina'      => 'Dosis Ivermectina',
			'tact_exc_ivermectina'        => 'Motiv. Exc. Ivermectina'
		);
	}

	public function index() {
		$this->load->view('consultor/inicio');
	}

	public function campanias() {
		$grupos = $this->ion_auth->get_users_groups($this->usuario->id)->result();
		$datos = [];

		foreach($grupos as $grupo)
			$datos[$grupo->name] = TRUE;

		$datos['usuario'] = $this->usuario->last_name.', '.$this->usuario->first_name;
		$datos['cant_rol'] = count($grupos);

		if($datos['cant_rol'] === 1)
			$datos['rol'] = $grupos[0]->description;

		$this->load->view('consultor/consultas_campanias', $datos);
	}

	public function consult_ext() {
		$grupos = $this->ion_auth->get_users_groups($this->usuario->id)->result();
		$datos = [];

		foreach($grupos as $grupo)
			$datos[$grupo->name] = TRUE;

		$datos['usuario'] = $this->usuario->last_name.', '.$this->usuario->first_name;
		$datos['cant_rol'] = count($grupos);

		if($datos['cant_rol'] === 1)
			$datos['rol'] = $grupos[0]->description;

		$this->load->view('consultor/consultas_consult_ext', $datos);
	}

	public function pacientes() {
		$grupos = $this->ion_auth->get_users_groups($this->usuario->id)->result();
		$datos = [];

		foreach($grupos as $grupo)
			$datos[$grupo->name] = TRUE;

		$datos['usuario'] = $this->usuario->last_name.', '.$this->usuario->first_name;
		$datos['cant_rol'] = count($grupos);

		if($datos['cant_rol'] === 1)
			$datos['rol'] = $grupos[0]->description;

		$this->load->view('consultor/consultas_pacientes', $datos);
	}

	private function procesar_restric_campanias($restricciones) {
		if(
			count($restricciones['campanias']) > 0 ||
			count($restricciones['departamentos']) > 0 ||
			count($restricciones['localidades']) > 0 ||
			count($restricciones['barrios']) > 0 ||
			count($restricciones['parajes']) > 0 ||
			count($restricciones['puestos']) > 0 ||
			count($restricciones['instituciones']) > 0
		) {
			$this->db->group_start();

			if(count($restricciones['campanias']) > 0)
				$this->db->where_in('campania', $restricciones['campanias']);

			if(count($restricciones['departamentos']) > 0)
				$this->db->or_where_in('nro_departamento', $restricciones['departamentos']);

			if(count($restricciones['localidades']) > 0)
				$this->db->or_where_in('nro_localidad', $restricciones['localidades']);

			if(count($restricciones['barrios']) > 0)
				$this->db->or_where_in('nro_barrio', $restricciones['barrios']);

			if(count($restricciones['parajes']) > 0)
				$this->db->or_where_in('nro_paraje', $restricciones['parajes']);

			if(count($restricciones['puestos']) > 0)
				$this->db->or_where_in('nro_puesto', $restricciones['puestos']);

			if(count($restricciones['instituciones']) > 0)
				$this->db->or_where_in('nro_institucion', $restricciones['instituciones']);

			$this->db->group_end();
		}

		if(count($restricciones['fechas']) > 0) {
			$this->db->group_start();

			foreach($restricciones['fechas'] as $fecha) {
				$this->db->or_group_start();

				$this->db->where('campania_fecha >= \''.$fecha->cota_inf.'\'');
				$this->db->where('campania_fecha <= \''.$fecha->cota_sup.'\'');

				$this->db->group_end();
			}

			$this->db->group_end();
		}
	}

	private function examinar_estudios($estudios) {
		$copro = $estudios['copro'];
		$sangre = $estudios['sangre'];
		$biolog_molec = $estudios['biolog_molec'];
		$tratamiento = $estudios['tratamiento'];

		return $copro->concentrado
				|| $copro->mc_master
				|| $copro->harada_mori
				|| $copro->baerman
				|| $copro->placa_agar
				|| $sangre->hemograma
				|| $sangre->serologia
				|| $biolog_molec->pcr
				|| $biolog_molec->qpcr
				|| $tratamiento->trat_medidas
				|| $tratamiento->trat_previo;
	}

	private function restringir_campania($campanias) {
		if(count($campanias) === 0)
			return;

		$this->db->where_in('campania', $campanias);
	}

	private function restringir_divpolit($divpolits) {
		if(!$this->hay_datos($divpolits))
			return;

		$this->db->or_group_start();

		if(count($divpolits['departamentos']) > 0)
			$this->db->where_in('nro_departamento', $divpolits['departamentos']);

		if(count($divpolits['localidades']) > 0)
			$this->db->or_where_in('nro_localidad', $divpolits['localidades']);

		if(count($divpolits['barrios']) > 0)
			$this->db->or_where_in('nro_barrio', $divpolits['barrios']);

		if(count($divpolits['parajes']) > 0)
			$this->db->or_where_in('nro_paraje', $divpolits['parajes']);

		if(count($divpolits['puestos']) > 0)
			$this->db->or_where_in('nro_puesto', $divpolits['puestos']);

		if(count($divpolits['instituciones']) > 0)
			$this->db->or_where_in('nro_institucion', $divpolits['instituciones']);

		$this->db->group_end();
	}

	private function restringir_fecha($fechas, $prefijo) {
		if(count($fechas) === 0)
			return;

		$this->db->group_start();

		foreach($fechas as $fecha) {
			$this->db->or_group_start();

			$this->db->where($prefijo.'_fecha >= \''.$fecha->cota_inf.'\'');
			$this->db->where($prefijo.'_fecha <= \''.$fecha->cota_sup.'\'');

			$this->db->group_end();
		}

		$this->db->group_end();
	}

	private function restringir_sexo($sexo) {
		if(count($sexo) === 0)
			return;

		$this->db->group_start();

		if($sexo['masculino'])
			$this->db->where('paciente_sexo', 'MASCULINO');

		if($sexo['femenino']) {
			if($sexo['masculino'])
				$this->db->or_where('paciente_sexo', 'FEMENINO');
			else
				$this->db->where('paciente_sexo', 'FEMENINO');
		}

		$this->db->group_end();
	}

	private function restringir_edad($edades) {
		if(count($edades) === 0)
			return;

		$this->db->group_start();

		foreach($edades as $edad) {
			$this->db->or_group_start();

			$this->db->where('paciente_edad >= \''.$edad->cota_inf.'\'');
			$this->db->where('paciente_edad <= \''.$edad->cota_sup.'\'');

			$this->db->group_end();
		}

		$this->db->group_end();
	}

	private function restringir_estudios($restricciones) {
		$copro = $restricciones['copro'];
		$sangre = $restricciones['sangre'];
		$biolog_molec = $restricciones['biolog_molec'];
		$tratamiento = $restricciones['tratamiento'];

		if(!$this->examinar_estudios($restricciones))
			return;

		$this->db->group_start();

		if($copro->concentrado)
			$this->db->or_where('cc_ascaris IS NOT NULL');

		if($copro->mc_master)
			$this->db->or_where('mm_ascaris IS NOT NULL');

		if($copro->harada_mori)
			$this->db->or_where('hm_strongyloides IS NOT NULL');

		if($copro->baerman)
			$this->db->or_where('bm_strongyloides IS NOT NULL');

		if($copro->placa_agar)
			$this->db->or_where('pa_strongyloides IS NOT NULL');


		if($sangre->hemograma)
			$this->db->or_where('hemoglobina IS NOT NULL');

		if($sangre->serologia)
			$this->db->or_where('serolog_titulo IS NOT NULL');


		if($biolog_molec->pcr)
			$this->db->or_where('pcr_strongyloides IS NOT NULL');

		if($biolog_molec->qpcr)
			$this->db->or_where('qpcr_strongyloides IS NOT NULL');


		if($tratamiento->trat_medidas)
			$this->db->or_where('paciente_peso IS NOT NULL');

		if($tratamiento->trat_medidas)
			$this->db->or_where('paciente_talla IS NOT NULL');

		if($tratamiento->trat_medidas)
			$this->db->or_where('paciente_perimetro_cefalico IS NOT NULL');

		if($tratamiento->trat_previo)
			$this->db->or_where('tprev_fecha IS NOT NULL');

		$this->db->group_end();
	}

	public function exportar_consulta_campanias() {
		$datos_consulta = $this->input->post();

		$campanias = json_decode($datos_consulta['campanias']);
		unset($datos_consulta['campanias']);
		//print_r($datos_consulta);
		$divpolits = array(
			'departamentos' => json_decode($datos_consulta['departamentos']),
			'localidades'   => json_decode($datos_consulta['localidades']),
			'barrios'       => json_decode($datos_consulta['barrios']),
			'parajes'       => json_decode($datos_consulta['parajes']),
			'puestos'       => json_decode($datos_consulta['puestos']),
			'instituciones' => json_decode($datos_consulta['instituciones'])
		);

		unset($datos_consulta['departamentos']);
		unset($datos_consulta['localidades']);
		unset($datos_consulta['barrios']);
		unset($datos_consulta['parajes']);
		unset($datos_consulta['puestos']);
		unset($datos_consulta['instituciones']);

		$estudios = array(
			'copro'        => json_decode($datos_consulta['copro']),
			'sangre'       => json_decode($datos_consulta['sangre']),
			'biolog_molec' => json_decode($datos_consulta['biolog_molec']),
			'tratamiento'  => json_decode($datos_consulta['tratamiento'])
		);

		unset($datos_consulta['copro']);
		unset($datos_consulta['sangre']);
		unset($datos_consulta['biolog_molec']);
		unset($datos_consulta['tratamiento']);

		$fechas = json_decode($datos_consulta['fechas']);
		unset($datos_consulta['fechas']);

		$datos = $datos_consulta;

		$campos_select = array_keys($datos);
		array_push($campos_select, 'paciente_numero', 'paciente_apellido', 'paciente_nombre', 'paciente_edad', 'paciente_sexo');

		$this->db->from('v_intervenciones_campanias I');
		$this->db->join('v_campanias C', 'I.campania = C.numero');

		$this->restringir_campania($campanias);
		$this->restringir_divpolit($divpolits);
		$this->restringir_fecha($fechas, 'campania');
		$this->restringir_estudios($estudios);

		$resultado = $this->db->get();

		$datos = $resultado->result_array();
		$this->exportar_datos($datos, $campos_select);
	}

	public function exportar_consulta_ambulatorio() {
		$datos_consulta = $this->input->post();

		$divpolits = array(
			'departamentos' => json_decode($datos_consulta['departamentos']),
			'localidades'   => json_decode($datos_consulta['localidades']),
			'barrios'       => json_decode($datos_consulta['barrios']),
			'parajes'       => json_decode($datos_consulta['parajes']),
			'puestos'       => json_decode($datos_consulta['puestos']),
			'instituciones' => json_decode($datos_consulta['instituciones'])
		);

		unset($datos_consulta['departamentos']);
		unset($datos_consulta['localidades']);
		unset($datos_consulta['barrios']);
		unset($datos_consulta['parajes']);
		unset($datos_consulta['puestos']);

		$restric_estudios = array(
			'copro'        => json_decode($datos_consulta['copro']),
			'sangre'       => json_decode($datos_consulta['sangre']),
			'biolog_molec' => json_decode($datos_consulta['biolog_molec']),
			'tratamiento'  => json_decode($datos_consulta['tratamiento'])
		);

		unset($datos_consulta['copro']);
		unset($datos_consulta['sangre']);
		unset($datos_consulta['biolog_molec']);
		unset($datos_consulta['tratamiento']);

		$fechas = json_decode($datos_consulta['fechas']);
		unset($datos_consulta['fechas']);

		$edades = json_decode($datos_consulta['edades']);
		unset($datos_consulta['edades']);

		$sexo = json_decode($datos_consulta['sexo'], true);
		unset($datos_consulta['sexo']);

		$datos = $datos_consulta;

		$campos_select = array_keys($datos);
		array_push($campos_select, 'paciente_numero', 'paciente_edad', 'paciente_sexo', 'paciente_domicilio');

		$this->db->from('v_intervenciones_consult_ext I');
		$this->db->join('v_intervenciones_ambulatorio A', 'I.intervencion = A.numero');
		
		$this->restringir_divpolit($divpolits);
		$this->restringir_fecha($fechas, 'intervencion');
		$this->restringir_sexo($sexo);
		$this->restringir_edad($edades);
		$this->restringir_estudios($restric_estudios);

		$resultado = $this->db->get();

		$datos = $resultado->result_array();
		$this->exportar_datos($datos, $campos_select);
	}

	public function exportar_consulta_pacientes() {
		$datos_consulta = $this->input->post();

		$divpolits = array(
			'departamentos' => json_decode($datos_consulta['departamentos']),
			'localidades'   => json_decode($datos_consulta['localidades']),
			'barrios'       => json_decode($datos_consulta['barrios']),
			'parajes'       => json_decode($datos_consulta['parajes']),
			'puestos'       => json_decode($datos_consulta['puestos']),
			'instituciones' => json_decode($datos_consulta['instituciones'])
		);

		unset($datos_consulta['departamentos']);
		unset($datos_consulta['localidades']);
		unset($datos_consulta['barrios']);
		unset($datos_consulta['parajes']);
		unset($datos_consulta['puestos']);

		$restric_estudios = array(
			'copro'        => json_decode($datos_consulta['copro']),
			'sangre'       => json_decode($datos_consulta['sangre']),
			'biolog_molec' => json_decode($datos_consulta['biolog_molec']),
			'tratamiento'  => json_decode($datos_consulta['tratamiento'])
		);

		unset($datos_consulta['copro']);
		unset($datos_consulta['sangre']);
		unset($datos_consulta['biolog_molec']);
		unset($datos_consulta['tratamiento']);

		$fechas = json_decode($datos_consulta['fechas']);
		unset($datos_consulta['fechas']);

		$edades = json_decode($datos_consulta['edades']);
		unset($datos_consulta['edades']);

		$sexo = json_decode($datos_consulta['sexo'], true);
		unset($datos_consulta['sexo']);

		$datos = $datos_consulta;

		$campos_select = array_keys($datos);
		array_push($campos_select, 'paciente_numero', 'paciente_apellido', 'paciente_nombre', 'paciente_edad', 'paciente_sexo', 'domicilio_paciente');
		# array_push($campos_select, 'paciente_numero', 'paciente_edad', 'paciente_sexo');

		$this->db->from('v_intervenciones_pacientes I');
		$this->db->join('v_intervenciones_ambulatorio A', 'I.intervencion = A.numero');
		
		$this->restringir_divpolit($divpolits);
		$this->restringir_fecha($fechas, 'intervencion');
		$this->restringir_sexo($sexo);
		$this->restringir_edad($edades);
		$this->restringir_estudios($restric_estudios);

		$resultado = $this->db->get();

		$datos = $resultado->result_array();
		$this->exportar_datos($datos, $campos_select);
	}

	private function exportar_datos($datos, $campos_select) {
		$campos_select = $this->ordenar_campos_selec($campos_select);

		$this->load->library('PHPExcel.php');

		$this->phpexcel->getProperties()->setCreator("IIET")
		                                 ->setLastModifiedBy("IIET")
		                                 ->setTitle("Consultas")
		                                 ->setSubject("Consultas")
		                                 ->setKeywords("Consultas");

		$sheet = $this->phpexcel->setActiveSheetIndex(0);
		$estilo_centrado_hv = array(
			'alignment' => array(
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			)
		);
		$style = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

		$c = 'A';

		foreach($campos_select as $campo) {
			$sheet->getColumnDimension($c)->setAutoSize(true);
			$sheet->getStyle($c.'1')->applyFromArray($estilo_centrado_hv);
			$sheet->setCellValue($c.'1', $this->nombres_campos[$campo]);

			++$c;
		}

		$f = 2;

		foreach($datos as $interv) {
			$c = 'A';

			foreach($campos_select as $campo) {
				switch($campo) {
					case 'paciente_edad':
						$interv[$campo] = $interv[$campo] < 100 ? round($interv[$campo]) : NULL;
					break;

					case 'ascaris':
						$interv[$campo] = $this->positividad_ascaris($interv);
					break;

					case 'uncinarias':
						$interv[$campo] = $this->positividad_uncinarias($interv);
					break;

					case 'necator':
						$interv[$campo] = $this->positividad_necator($interv);
					break;

					case 'ancylostoma':
						$interv[$campo] = $this->positividad_ancylostoma($interv);
					break;

					case 'strongyloides':
						$interv[$campo] = $this->positividad_strongyloides($interv);
					break;

					case 'trichuris':
						$interv[$campo] = $this->positividad_trichuris($interv);
					break;

					case 'helmintos':
						$interv[$campo] = $this->positividad_helmintos($interv);
					break;
				}

				if($interv[$campo] != NULL) {
					$sheet->getStyle($c.$f)->applyFromArray($style);
					$sheet->setCellValue($c.$f, $interv[$campo]);
				}

				else {
					$sheet->getStyle($c.$f)->applyFromArray($estilo_centrado_hv);
					$sheet->setCellValue($c.$f, '-');
				}

				++$c;
			}

			++$f;
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="consulta_geohelmintos.xls"');
		header('Cache-Control: max-age=0');
		 
		$objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
		$objWriter->save('php://output');
	}

	private function hay_datos($lista) {
		$band = FALSE;

		foreach($lista as $campo => $valor) {
			if(count($lista[$campo]) > 0) {
				$band = TRUE;
				break;
			}
		}

		return $band;
	}

	private function ordenar_campos_selec($campos_select) {
		$campos_ord = [];
		
		foreach($this->nombres_campos as $nombre_campo => $_) {
			if(count($campos_select) === 0)
				break;

			$i = array_search($nombre_campo, $campos_select);

			if($i !== FALSE) {
				$campos_ord[] = $nombre_campo;
				unset($campos_select[$i]);
			}
		}

		return $campos_ord;
	}

	private function positividad_helmintos($datos) {
		$ascaris       = $this->positividad_ascaris($datos);
		$trichuris     = $this->positividad_trichuris($datos);
		$strongyloides = $this->positividad_strongyloides($datos);
		$uncinarias    = $this->positividad_uncinarias($datos);

		if(
			$ascaris === 'POSITIVO'
			|| $trichuris === 'POSITIVO'
			|| $strongyloides === 'POSITIVO'
			|| $uncinarias === 'POSITIVO'
		)
			return 'POSITIVO';

		if(
			$ascaris === 'NEGATIVO'
			|| $trichuris === 'NEGATIVO'
			|| $strongyloides === 'NEGATIVO'
			|| $uncinarias === 'NEGATIVO'
		)
			return 'NEGATIVO';

		return NULL;
	}

	private function positividad_ascaris($evento) {
		if($evento['cc_ascaris'] === 'POSITIVO' || $evento['mm_ascaris'] > 0)
			return 'POSITIVO';

		if($evento['cc_ascaris'] === 'NEGATIVO' || $evento['mm_ascaris'] === 0)
			return 'NEGATIVO';

		return NULL;
	}

	private function positividad_trichuris($evento) {
		if($evento['cc_trichuris'] === 'POSITIVO' || $evento['mm_trichuris'] > 0)
			return 'POSITIVO';

		if($evento['cc_trichuris'] === 'NEGATIVO' || $evento['mm_trichuris'] === 0)
			return 'NEGATIVO';

		return NULL;
	}

	private function positividad_strongyloides($evento) {
		if(
			$evento['cc_strongyloides'] === 'POSITIVO'
			|| $evento['hm_strongyloides'] === '+'
			|| $evento['hm_strongyloides'] === '++'
			|| $evento['hm_strongyloides'] === '+++'
			|| $evento['bm_strongyloides'] === '+'
			|| $evento['bm_strongyloides'] === '++'
			|| $evento['bm_strongyloides'] === '+++'
		)
			return 'POSITIVO';

		if(
			$evento['cc_strongyloides'] === 'NEGATIVO'
			|| $evento['hm_strongyloides'] === 'NEGATIVO'
			|| $evento['bm_strongyloides'] === 'NEGATIVO'
		)
			return 'NEGATIVO';

		return NULL;
	}

	private function positividad_necator($evento) {
		if(
			$evento['hm_necator'] === '+'
			|| $evento['hm_necator'] === '++'
			|| $evento['hm_necator'] === '+++'
			|| $evento['bm_necator'] === '+'
			|| $evento['bm_necator'] === '++'
			|| $evento['bm_necator'] === '+++'
		)
			return 'POSITIVO';

		if(
			$evento['hm_necator'] === 'NEGATIVO'
			|| $evento['bm_necator'] === 'NEGATIVO'
		)
			return 'NEGATIVO';

		return NULL;
	}

	private function positividad_ancylostoma($evento) {
		if(
			$evento['hm_ancylostoma'] === '+'
			|| $evento['hm_ancylostoma'] === '++'
			|| $evento['hm_ancylostoma'] === '+++'
			|| $evento['bm_ancylostoma'] === '+'
			|| $evento['bm_ancylostoma'] === '++'
			|| $evento['bm_ancylostoma'] === '+++'
		)
			return 'POSITIVO';

		if(
			$evento['hm_ancylostoma'] === 'NEGATIVO'
			|| $evento['bm_ancylostoma'] === 'NEGATIVO'
		)
			return 'NEGATIVO';

		return NULL;
	}

	private function positividad_uncinarias($evento) {
		$p_necator = $this->positividad_necator($evento);
		$p_ancylostoma = $this->positividad_ancylostoma($evento);

		if(
			$evento['cc_uncinarias'] === 'POSITIVO'
			|| $evento['mm_uncinarias'] > 0
			|| $p_necator === 'POSITIVO'
			|| $p_ancylostoma === 'POSITIVO'
		)
			return 'POSITIVO';

		if(
			$evento['cc_uncinarias'] === 'NEGATIVO'
			|| $evento['mm_uncinarias'] === 0
			|| $p_necator === 'NEGATIVO'
			|| $p_ancylostoma === 'NEGATIVO'
		)
			return 'NEGATIVO';

		return NULL;
	}
}