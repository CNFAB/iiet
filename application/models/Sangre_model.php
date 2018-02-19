<?php

class Sangre_model extends CI_Model {
	
	function __construct() {
		parent::__construct();

		$this->load->model('intervencion_model');
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$id_interv = $this->intervencion_model->obtener_intervencion($datos['intervencion']);

		$datos_sangre = array(
			'intervencion' => $id_interv,
			'fecha'        => $datos['fecha'],
			'nro_tubo'     => $datos['nro_tubo']
		);

		if($this->existe_sangre($id_interv)) {
			$this->db->where('intervencion', $id_interv);
			$this->db->update('sangre', $datos_sangre);
		}

		else
			$this->db->insert('sangre', $datos_sangre);

		$datos_hemograma = isset($datos['hemograma']) ? $datos['hemograma'] : false;
		$datos_serologia = isset($datos['serologia']) ? $datos['serologia'] : false;

		$this->cargar_hemograma($id_interv, $datos_hemograma);
		$this->cargar_serologia($id_interv, $datos_serologia);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_interv;
		}
	}

	private function cargar_hemograma($id_sangre, $datos) {
		$ya_existe = $this->existe_metodo('hemogramas', $id_sangre);

		if(!$datos && $ya_existe) {
			$this->db->where('sangre', $id_sangre);
			$this->db->delete('hemogramas');
		}

		elseif($datos !== false) {
			$datos_hemograma = array(
				'sangre'           => $id_sangre,
				'globulos_blancos' => $datos['globulos_blancos'],
				'hemoglobina'      => $datos['hemoglobina'],
				'eosinofilos'      => $datos['eosinofilos']
			);

			if($ya_existe) {
				$this->db->where('sangre', $id_sangre);
				$this->db->update('hemogramas', $datos_hemograma);
			}

			else
				$this->db->insert('hemogramas', $datos_hemograma);
		}
	}

	private function cargar_serologia($id_sangre, $datos) {
		$ya_existe = $this->existe_metodo('serologia_strongyloides', $id_sangre);

		if(!$datos && $ya_existe) {
			$this->db->where('sangre', $id_sangre);
			$this->db->delete('serologia_strongyloides');
		}

		elseif($datos !== false) {
			$datos_serologia = array(
				'sangre'    => $id_sangre,
				'resultado' => $datos['resultado'],
				'titulo'    => $datos['titulo']
			);

			if($ya_existe) {
				$this->db->where('sangre', $id_sangre);
				$this->db->update('serologia_strongyloides', $datos_serologia);
			}

			else
				$this->db->insert('serologia_strongyloides', $datos_serologia);
		}
	}

	private function existe_sangre($id_interv) {
		$this->db->where('intervencion', $id_interv);

		$consulta = $this->db->get('sangre');

		return $consulta->num_rows() > 0;
	}

	private function existe_metodo($nombre, $id_sangre) {
		$this->db->where('sangre', $id_sangre);

		$consulta = $this->db->get($nombre);

		return $consulta->num_rows() > 0;
	}
}