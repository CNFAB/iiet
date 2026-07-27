<?php

class BiologMolec_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function nueva($datos) {
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
		
		$datos_biomolec = array(
			'intervencion' => $id_interv,
			'fuente'       => $datos['fuente']
		);

		if($this->existe_biologmolec($id_interv)) {
			$this->db->where('intervencion', $id_interv);
			$this->db->update('biologia_molecular', $datos_biomolec);
		}

		else
			$this->db->insert('biologia_molecular', $datos_biomolec);

		$datos_pcr  = isset($datos['pcr'])  ? $datos['pcr']  : false;
		$datos_qpcr = isset($datos['qpcr']) ? $datos['qpcr'] : false;

		$this->cargar_pcr($id_interv, $datos_pcr);
		$this->cargar_qpcr($id_interv, $datos_qpcr);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_interv;
		}
	}

	private function cargar_pcr($id_biologmolec, $datos) {
		$ya_existe = $this->existe_metodo('pcr', $id_biologmolec);

		if(!$datos && $ya_existe) {
			$this->db->where('bio_molec', $id_biologmolec);
			$this->db->delete('pcr');
		}

		elseif($datos !== false) {
			$datos_pcr = array(
				'bio_molec'     => $id_biologmolec,
				'strongyloides' => $datos['strongyloides'],
				'ancylostoma'   => $datos['ancylostoma'],
				'necator'       => $datos['necator'],
				'ascaris'       => $datos['ascaris'],
				'trichuris'     => $datos['trichuris']
			);

			if($ya_existe) {
				$this->db->where('bio_molec', $id_biologmolec);
				$this->db->update('pcr', $datos_pcr);
			}

			else
				$this->db->insert('pcr', $datos_pcr);
		}
	}

	private function cargar_qpcr($id_biologmolec, $datos) {
		$ya_existe = $this->existe_metodo('qpcr', $id_biologmolec);

		if(!$datos && $ya_existe) {
			$this->db->where('bio_molec', $id_biologmolec);
			$this->db->delete('qpcr');
		}

		elseif($datos !== false) {
			$datos_qpcr = array(
				'bio_molec'     => $id_biologmolec,
				'strongyloides' => $datos['strongyloides'],
				'ancylostoma'   => $datos['ancylostoma'],
				'necator'       => $datos['necator'],
				'ascaris'       => $datos['ascaris'],
				'trichuris'     => $datos['trichuris']
			);

			if($ya_existe) {
				$this->db->where('bio_molec', $id_biologmolec);
				$this->db->update('qpcr', $datos_qpcr);
			}

			else
				$this->db->insert('qpcr', $datos_qpcr);
		}
	}

	private function existe_biologmolec($id_interv) {
		$this->db->where('intervencion', $id_interv);

		$consulta = $this->db->get('biologia_molecular');

		return $consulta->num_rows() > 0;
	}

	private function existe_metodo($nombre, $id_biologmolec) {
		$this->db->where('bio_molec', $id_biologmolec);

		$consulta = $this->db->get($nombre);

		return $consulta->num_rows() > 0;
	}

	public function obtener_datos_biologmolec($intervencion) {
		$this->db->where('intervencion', $intervencion);
		$resultado = $this->db->get('biologia_molecular');

		if($resultado->num_rows() === 0)
			return FALSE;

		$datos_biologmolec['fuente'] = $resultado->row()->fuente;
		$datos_biologmolec['pcr']    = $this->obtener_datos_metodo($intervencion, 'pcr');
		$datos_biologmolec['qpcr']   = $this->obtener_datos_metodo($intervencion, 'qpcr');

		return $datos_biologmolec;
	}

	public function obtener_datos_metodo($biologmolec, $metodo) {
		$this->db->where('bio_molec', $biologmolec);
		$resultado = $this->db->get($metodo);

		return $resultado->num_rows() > 0 ? $resultado->row_array() : FALSE;
	}

	public function eliminar($intervencion) {
		$this->eliminar_metodo($intervencion, 'pcr');
		$this->eliminar_metodo($intervencion, 'qpcr');

		$this->db->where('intervencion', $intervencion);

		return $this->db->delete('biologia_molecular');
	}

	private function eliminar_metodo($biologmolec, $metodo) {
		$this->db->where('bio_molec', $biologmolec);

		return $this->db->delete($metodo);
	}
}