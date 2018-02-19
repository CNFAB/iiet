<?php

class Intervencion_model extends CI_Model {
	
	function __construct() {
		parent::__construct();

		$this->load->model('paciente_model');
	}

	public function nueva($datos) {
		$this->db->trans_begin();

		$datos_interv = array(
			'paciente' => $datos['paciente']
		);

		$this->db->insert('intervenciones_geohelmintos', $datos_interv);

		$id_interv = $this->ultimo_id();

		switch($datos['tipo']) {
			case 'escuela':
				$this->interv_escuela($id_interv, $datos);
			break;

			case 'barrio':
				$this->interv_barrio($id_interv, $datos);
			break;

			case 'puesto':
				$this->interv_puesto($id_interv, $datos);
			break;

			case 'externo':
				$this->interv_externo($id_interv, $datos);
			break;
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

	private function interv_puesto($intervencion, $datos) {
		$datos_paciente = $this->paciente_model->obtener_dtsparainterv($datos['paciente']);

		$interv_puesto = array(
			'intervencion'    => $intervencion,
			'campania_puesto' => $datos['campania'],
			'domicilio'       => $datos_paciente['domicilio'],
			'nro_familia'     => $datos_paciente['nro_familia'],
			'nro_vivienda'    => $datos_paciente['nro_vivienda']
		);

		$this->db->insert('intervenciones_puestos', $interv_puesto);
	}

	private function interv_barrio($intervencion, $datos) {
		$datos_paciente = $this->paciente_model->obtener_dtsparainterv($datos['paciente']);

		$interv_barrio = array(
			'intervencion'    => $intervencion,
			'campania_barrio' => $datos['campania'],
			'domicilio'       => $datos_paciente['domicilio'],
			'nro_familia'     => $datos_paciente['nro_familia'],
			'nro_vivienda'    => $datos_paciente['nro_vivienda']
		);

		$this->db->insert('intervenciones_barrios', $interv_barrio);
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

	private function interv_escuela($intervencion, $datos)	{
		$interv_escuela = array(
			'intervencion'     => $intervencion,
			'campania_escuela' => $datos['campania']
		);

		$this->db->insert('intervenciones_escuelas', $interv_escuela);
	}

	private function interv_externo($datos)	{
		$datos_paciente = $this->paciente_model->obtener_dtsparainterv($datos['paciente']);

		$datos_externo = array(
			'intervencion' => $datos['intervencion'],
			'domicilio'    => isset($datos_paciente['domicilio']) ? $datos_paciente['domicilio'] : NULL,
			'procedencia'  => $datos['procedencia']
		);

		$this->db->insert('consultorio_externo', $datos_externo);

		if($datos['lugar'] == 'paraje') {
			$datos_puesto = array(
				'intervencion' => $datos['intervencion'],
				'puesto'       => $datos['puesto']
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
			diagnostico_presuntivo($datos['diagnostico_presuntivo']);
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

	public function obtener_intervencion($datos) {
		$id = $this->intervencion_campania($datos);

		if($id === FALSE)
			$id = $this->nueva($datos);

		return $id;
	}

	private function intervencion_campania($datos) {
		$this->db->select('numero');
		$this->db->from('intervenciones_geohelmintos IG');

		if($datos['tipo'] == 'escuela')
			$this->db->join('intervenciones_escuelas IL', 'IG.numero = IL.intervencion');

		elseif($datos['tipo'] == 'puesto')
			$this->db->join('intervenciones_puestos IL', 'IG.numero = IL.intervencion');

		else
			$this->db->join('intervenciones_barrios IL', 'IG.numero = IL.intervencion');

		$this->db->where('IG.paciente', $datos['paciente']);
		$this->db->where('IL.campania_' . $datos['tipo'], $datos['campania']);

		$cons = $this->db->get();

		return $cons->num_rows() > 0 ? $cons->row()->numero : FALSE;
	}

	public function obtenerTipoIntervencion()
	{
		# code...
	}

	public function obtenerIntervencionesCampania($paciente) {
		$this->db->select('PAC.numero AS paciente, IG.numero AS intervencion,'
						. 'VC.tipo AS tipo_campania, VC.lugar AS lugar_campania,'
						. 'VC.nombre AS nombre_campania, VC.fecha_inicio AS inicio_campania,'
						. 'VC.fecha_fin AS fin_campania, VC.numero AS numero_campania');
		$this->db->from('pacientes PAC');
		$this->db->join('intervenciones_geohelmintos IG', 'PAC.numero = IG.paciente');
		$this->db->join('v_campanias VC', 'IG.numero = VC.intervencion');

		$consulta = $this->db->get();

		return $consulta->num_rows() > 0 ? $consulta->row()->numero : FALSE;
	}
}