<?php

class Sangre_model extends CI_Model {
	
	function __construct() {
		parent::__construct();

		$this->load->model('intervencion_model');
		//$this->load->model('campania_model');
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$interv = $datos['intervencion'];

		// si existe la propiedad numero es porque la intervención es de tipo EXTERNO
		// de lo contrario es de tipo CAMPANIA
		if(isset($interv['numero'])) {
			$id_interv = $interv['numero'];
		}

		else {
			$id_interv = $this->campania_model->obtener_intervencion($interv['campania'], $interv['paciente']);
			
			if(!$id_interv)
				$id_interv = $this->intervencion_model->nueva($interv);
		}

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

	public function obtener_datos_sangre($intervencion) {
		$this->db->where('intervencion', $intervencion);
		$resultado = $this->db->get('sangre');

		if($resultado->num_rows() === 0)
			return FALSE;

		$sangre = $resultado->row();

		$datos_sangre['fecha']     = $sangre->fecha;
		$datos_sangre['nro_tubo']  = $sangre->nro_tubo;
		$datos_sangre['hemograma'] = $this->obtener_datos_metodo($intervencion, 'hemogramas');
		$datos_sangre['serologia'] = $this->obtener_datos_metodo($intervencion, 'serologia_strongyloides');

		return $datos_sangre;
	}

	public function obtener_datos_metodo($sangre, $metodo) {
		$this->db->where('sangre', $sangre);
		$resultado = $this->db->get($metodo);

		return $resultado->num_rows() > 0 ? $resultado->row_array() : FALSE;
	}

	public function eliminar($intervencion) {
		$this->eliminar_metodo($intervencion, 'hemogramas');
		$this->eliminar_metodo($intervencion, 'serologia_strongyloides');

		$this->db->where('intervencion', $intervencion);

		return $this->db->delete('sangre');
	}

	private function eliminar_metodo($sangre, $metodo) {
		$this->db->where('sangre', $sangre);

		return $this->db->delete($metodo);
	}
}