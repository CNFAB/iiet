<?php

class BiologMolec_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function nueva($datos) {
		$this->db->trans_begin();

		$id_interv = isset($datos['intervencion']) ?
						$datos['intervencion']
					:
						$this->intervencion_model->nueva($datos['paciente']);
		
		$datos_biomolec = array(
			'intervencion' => $id_interv,
			'fuente'       => $datos['fuente']
		);

		$this->db->insert('biologia_molecular', $datos_biomolec);
		$id_biomolec = $this->ultimo_id();

		if(isset($datos['pcr'])) {
			$datos['pcr']['bio_molec'] = $id_biomolec;

			$this->cargar_pcr($datos['pcr']);
		}

		if(isset($datos['qpcr'])) {
			$datos['qpcr']['bio_molec'] = $id_biomolec;

			$this->cargar_qpcr($datos['qpcr']);
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

	private function cargar_pcr($datos)	{
		$datos_pcr = array(
			'bio_molec'     => $datos['bio_molec'],
			'strongyloides' => $datos['strongyloides'] 	? $datos['strongyloides'] : FALSE,
			'ancylostoma'   => $datos['ancylostoma'] 	? $datos['ancylostoma']   : FALSE,
			'necator'       => $datos['necator'] 		? $datos['necator']       : FALSE,
			'ascaris'       => $datos['ascaris'] 		? $datos['ascaris']       : FALSE,
			'trichuris'     => $datos['trichuris'] 		? $datos['trichuris']     : FALSE
		);

		$this->db->insert('pcr', $datos_pcr);
	}

	private function cargar_qpcr($datos) {
		$datos_qpcr = array(
			'bio_molec'     => $datos['bio_molec'],
			'strongyloides' => $datos['strongyloides'] 	? $datos['strongyloides'] : FALSE,
			'ancylostoma'   => $datos['ancylostoma'] 	? $datos['ancylostoma']   : FALSE,
			'necator'       => $datos['necator'] 		? $datos['necator']       : FALSE,
			'ascaris'       => $datos['ascaris'] 		? $datos['ascaris']       : FALSE,
			'trichuris'     => $datos['trichuris'] 		? $datos['trichuris']     : FALSE
		);

		$this->db->insert('qpcr', $datos_pcr);
	}

	public function ultimo_id() {
		$this->db->select_max('numero');
		$consulta = $this->db->get('biologia_molecular');

		return $consulta->row()->numero;
	}
}