<?php

class BiologMolec_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function nueva($datos) {
		$this->db->trans_begin();

		$id_interv = $this->intervencion_model->obtener_intervencion($datos['intervencion']);
		
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

		$datos_pcr  = isset($datos['pcr'])  ? $datos['pcr'] : false;
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
				'strongyloides' => $datos['strongyloides'] !== '' ? $datos['strongyloides'] : NULL,
				'ancylostoma'   => $datos['ancylostoma']   !== '' ? $datos['ancylostoma']   : NULL,
				'necator'       => $datos['necator'] 	   !== '' ? $datos['necator']       : NULL,
				'ascaris'       => $datos['ascaris'] 	   !== '' ? $datos['ascaris']       : NULL,
				'trichuris'     => $datos['trichuris'] 	   !== '' ? $datos['trichuris']     : NULL
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
				'strongyloides' => $datos['strongyloides'] !== '' ? $datos['strongyloides'] : NULL,
				'ancylostoma'   => $datos['ancylostoma']   !== '' ? $datos['ancylostoma']   : NULL,
				'necator'       => $datos['necator'] 	   !== '' ? $datos['necator']       : NULL,
				'ascaris'       => $datos['ascaris'] 	   !== '' ? $datos['ascaris']       : NULL,
				'trichuris'     => $datos['trichuris'] 	   !== '' ? $datos['trichuris']     : NULL
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
}