<?php

class Intervencion_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function nueva($datos) {
		$this->db->trans_begin();

		$datos_interv = array(
			'paciente' => $datos['paciente'],
			'fecha' => $datos['fecha']
		);

		$this->db->insert('intervenciones_geohelmintos', $datos_interv);

		$id_interv = $this->ultimo_id();

		if(isset($datos['interv_comunidad'])) {
			$datos['interv_comunidad']['intervencion'] = $id_interv;

			interv_comunidad($datos['interv_comunidad']);
		}

		elseif(isset($datos['interv_escuela'])) {
			$datos['interv_escuela']['intervencion'] = $id_interv;

			interv_escuela($datos['interv_escuela']);
		}
		
		elseif(isset($datos['interv_externo'])) {
			$datos['interv_externo']['intervencion'] = $id_interv;

			interv_externo($datos['interv_externo']);
		}

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_interv;
		}
	}

	private function interv_comunidad($datos) {
		$datos_comunidad = array(
			'intervencion' => $datos['intervencion'],
			'campania' => $datos['campania'],
			'domicilio' => $datos['domicilio'],
			'nro_familia' => $datos['nro_familia'] ? $datos['nro_familia'] : NULL,
			'nro_vivienda' => $datos['nro_vivienda'] ? $datos['nro_vivienda'] : NULL
		);

		$this->db->insert('intervencion_comunidad', $datos_comunidad);

		if(isset($datos['puesto'])) {
			$datos_puesto = array(
				'intervencion' => $datos['intervencion'],
				'campania' => $datos['campania'],
				'puesto' => $datos['puesto']
			);

			$this->db->insert('puesto_intervencion', $datos_puesto);
		}

		if(isset($datos['factores_riesgo']))
			$this->factores_riesgo($datos['factores_riesgo']);
	}

	private function factores_riesgo($datos) {
		$datos_riesgos = array(
			'intervencion' => $datos['intervencion'],
			'red_dom_y_cloaca' =>
				isset($datos['red_dom_y_cloaca']) ? $datos['red_dom_y_cloaca'] : FALSE,
			'tratamiento_agua' =>
				isset($datos['tratamiento_agua']) ? $datos['tratamiento_agua'] : FALSE,
			'dse' => $datos['dse'],
			'tsb' => $datos['tsb'],
			'piso_vivienda' => $datos['piso_vivienda'],
			'desempl_ingr_econ_inest' =>
				isset($datos['desempl_ingr_econ_inest']) ? $datos['desempl_ingr_econ_inest'] : FALSE,
			'analfab_pers_cargo_menores' =>
				isset($datos['analfab_pers_cargo_menores']) ? $datos['analfab_pers_cargo_menores'] : FALSE,
			'familia_riesgo' =>
				isset($datos['familia_riesgo']) ? $datos['familia_riesgo'] : FALSE
		);

		$this->db->insert('factores_riesgo', $datos_riesgos);
	}

	private function interv_escuela($datos)	{
		$datos_escuela = array(
			'intervencion' => $datos['intervencion'],
			'campania' => $datos['campania'],
			'grado' => $datos['grado'] ? $datos['grado'] : NULL
		);

		$this->db->insert('intervencion_escuelas', $datos_escuela);
	}

	private function interv_externo($datos)	{
		$datos_externo = array(
			'intervencion' => $datos['intervencion'],
			'domicilio' => $datos['domicilio'],
			'procedencia' => $datos['procedencia']
		);

		$this->db->insert('consultorio_externo', $datos_externo);

		if($datos['lugar'] == 'paraje') {
			$datos_puesto = array(
				'intervencion' => $datos['intervencion'],
				'puesto' => $datos['puesto']
			);

			$this->db->insert('puesto_consultorio_externo', $datos_puesto);
		}

		else {
			$datos_barrio = array(
				'intervencion' => $datos['intervencion'],
				'barrio' => $datos['barrio']
			);

			$this->db->insert('barrio_consultorio_externo', $datos_barrio);
		}

		if(isset($datos['diagnostico_presuntivo']))
	}
	
	private function diagnostico_presuntivo($datos)	{
		$datos_diagnostico = array(
			'consultorio_externo' => $datos['consultorio_externo'],
			'control' 			  => $datos['control'] 		   ? $datos['control'] 		   : FALSE,
			'bajo_peso' 		  => $datos['bajo_peso'] 	   ? $datos['bajo_peso'] 	   : FALSE,
			'anemia' 			  => $datos['anemia'] 		   ? $datos['anemia'] 		   : FALSE,
			'diarrea' 			  => $datos['diarrea'] 		   ? $datos['diarrea'] 		   : FALSE,
			'estrenimiento' 	  => $datos['estrenimiento']   ? $datos['estrenimiento']   : FALSE,
			'manchas_piel' 		  => $datos['manchas_piel']    ? $datos['manchas_piel']    : FALSE,
			'priurito_anal' 	  => $datos['priurito_anal']   ? $datos['priurito_anal']   : FALSE,
			'bruxismo' 			  => $datos['bruxismo'] 	   ? $datos['bruxismo'] 	   : FALSE,
			'dolor_abdominal' 	  => $datos['dolor_abdominal'] ? $datos['dolor_abdominal'] : FALSE,
			'otros' 			  => $datos['otros']
		);

		$this->db->insert('diagnostico_presuntivo', $datos_diagnostico);
	}

	public function ultimo_id() {
		$this->db->select_max('numero');
		$consulta = $this->db->get('intervenciones_geohelmintos');

		return $consulta->row()->numero;
	}
}