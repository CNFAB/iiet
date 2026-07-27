<?php

class ConsultorioExterno_model extends CI_Model {
	public function __construct() {
		parent::__construct();

		$this->load->model('intervencion_model');
	}

	public function nuevo($datos) {
		$this->db->trans_begin();
		$datos['tipo'] = 'externo';
		$id_interv = $this->intervencion_model->nueva($datos);

		$datos_externo = array(
			'intervencion' => $id_interv,
			'fecha'        => $datos['fecha'],
			'procedencia'  => $datos['institucion']
		);

		$this->db->insert('consultorio_externo', $datos_externo);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_interv;
		}
	}

	public function diagnostico_presuntivo($datos) {
		$datos_diagnost = array(
			'consultorio_externo' => $datos['intervencion']['numero'],
			'control'         => isset($datos['control'])         ? 'SI' : 'NO',
			'bajo_peso'       => isset($datos['bajo_peso'])       ? 'SI' : 'NO',
			'anemia'          => isset($datos['anemia'])          ? 'SI' : 'NO',
			'diarrea'         => isset($datos['diarrea'])         ? 'SI' : 'NO',
			'estrenimiento'   => isset($datos['estrenimiento'])   ? 'SI' : 'NO',
			'manchas_piel'    => isset($datos['manchas_piel'])    ? 'SI' : 'NO',
			'priurito_anal'   => isset($datos['priurito_anal'])   ? 'SI' : 'NO',
			'bruxismo'        => isset($datos['bruxismo'])        ? 'SI' : 'NO',
			'dolor_abdominal' => isset($datos['dolor_abdominal']) ? 'SI' : 'NO',
			'otros'           => isset($datos['otros']) ? $datos['otros'] : NULL,
		);

		return $this->db->insert('diagnostico_presuntivo', $datos_diagnost);
	}

	public function obtener_datos($intervencion) {
		/*$this->db->select('CE.intervencion, CE.fecha, INST.nombre AS procedencia');
		$this->db->from('consultorio_externo CE');
		$this->db->join('instituciones INST', 'CE.procedencia = INST.numero');
		$this->db->where('intervencion', $intervencion);

		$externo = $this->db->get();*/

		$this->db->where('intervencion', $intervencion);
		$externo = $this->db->get('v_consultorio_externo');

		return $externo->num_rows() > 0 ? $externo->row_array() : FALSE;
	}

	public function obtener_datos_diagpresunt($intervencion) {
		$this->db->where('consultorio_externo', $intervencion);
		$resultado = $this->db->get('diagnostico_presuntivo');

		return $resultado->num_rows() > 0 ? $resultado->row_array() : FALSE;
	}

	public function eliminar($intervencion) {
		//$this->eliminar_diagpresunt($intervencion);

		$this->db->where('intervencion', $intervencion);

		return $this->db->delete('consultorio_externo');
	}

	private function eliminar_diagpresunt($intervencion) {
		$this->db->where('consultorio_externo', $intervencion);

		return $this->db->delete('diagnostico_presuntivo');
	}
}