<?php

class Sangre_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$id_interv = isset($datos['intervencion']) ?
						$datos['intervencion']
					:
						$this->intervencion_model->nueva($datos['paciente']);

		$datos_sangre = array(
			'intervencion' => $id_interv,
			'fecha'        => $datos['fecha'],
			'nro_tubo'     => $datos['nro_tubo']
		);

		$id_sangre = $this->ultimo_id();

		if(isset($datos['hemograma'])) {
			$datos['hemograma']['sangre'] = $id_sangre;

			$this->cargar_hemograma($datos['hemograma']);
		}

		if(isset($datos['serologia_strongyloides'])) {
			$datos['serologia_strongyloides']['sangre'] = $id_sangre;

			$this->cargar_serologia($datos['serologia_strongyloides']);
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

	private function cargar_hemograma($datos) {
		$datos_hemograma = array(
			'sangre'           => $datos['sangre'],
			'globulos_blancos' => $datos['globulos_blancos'],
			'hemoglobina'      => $datos['hemoglobina'],
			'eosinofilos'      => $datos['eosinofilos']
		);

		$this->db->insert('hemograma', $datos_hemograma);
	}

	private function cargar_serologia($datos) {
		$datos_serologia = array(
			'sangre'   => $datos['sangre'],
			'positivo' => $datos['positivo'],
			'titulo'   => $datos['titulo']
		);

		$this->db->insert('serologia_strongyloides', $datos_serologia);
	}

	public function ultimo_id() {
		$this->db->select_max('numero');
		$consulta = $this->db->get('sangre');

		return $consulta->row()->numero;
	}
}