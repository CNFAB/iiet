<?php

class Copro_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->model('intervencion_model');
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$id_interv = isset($datos['intervencion']) ?
						$datos['intervencion']
					:
						$this->intervencion_model->nueva($datos['paciente']);

		$datos_copro = array(
			'intervencion' => $id_interv,
			'nro_cuaderno' => isset($datos['nro_cuaderno']) ? $datos['nro_cuaderno'] : NULL;
			'fecha'        => $datos['fecha'],
			'peso_materia' => $datos['peso_materia'],
			'consistencia' => $datos['consistencia']
		);

		$this->db->insert('coproparasitologico', $datos_copro);

		$id_copro = $this->ultimo_id();

		if(isset($datos['concentrado'])) {
			$datos['concentrado']['copro'] = $id_copro;

			$this->cargar_concentrado($datos['concentrado']);
		}

		if(isset($datos['mc_master'])) {
			$datos['mc_master']['copro'] = $id_copro;
			
			$this->cargar_mc_master($datos['mc_master']);
		}

		if(isset($datos['harada_mori'])) {
			$datos['harada_mori']['copro'] = $id_copro;
			
			$this->cargar_harada_mori($datos['harada_mori']);
		}

		if(isset($datos['baerman'])) {
			$datos['baerman']['copro'] = $id_copro;
			
			$this->cargar_baerman($datos['baerman']);
		}

		if(isset($datos['placa_agar'])) {
			$datos['placa_agar']['copro'] = $id_copro;
			
			$this->cargar_placa_agar($datos['placa_agar']);
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

	private function cargar_concentrado($datos) {
		$datos_concentrado = array(
			'copro'         => $datos['copro'],
			'ascaris'       => $datos['ascaris'] 		? $datos['ascaris'] 	  : FALSE,
			'giardia'       => $datos['giardia'] 		? $datos['giardia'] 	  : FALSE,
			'entamoebacoli' => $datos['entamoebacoli'] 	? $datos['entamoebacoli'] : FALSE,
			'uncinarias'    => $datos['uncinarias'] 	? $datos['uncinarias'] 	  : FALSE,
			'strongyloides' => $datos['strongyloides'] 	? $datos['strongyloides'] : FALSE,
			'hymenolepis'   => $datos['hymenolepis'] 	? $datos['hymenolepis']   : FALSE,
			'trichuris'     => $datos['trichuris'] 		? $datos['trichuris'] 	  : FALSE,
			'enterobius'    => $datos['enterobius'] 	? $datos['enterobius'] 	  : FALSE,
			'taenia'        => $datos['taenia'] 		? $datos['taenia'] 		  : FALSE
		);

		$this->db->insert('concentrado', $datos_concentrado);
	}

	private function cargar_mc_master($datos) {
		$datos_mc_master = array(
			'copro'       => $datos['copro'],
			'ascaris'     => $datos['ascaris'],
			'uncinarias'  => $datos['uncinarias'],
			'hymenolepis' => $datos['hymenolepis'],
			'trichuris'   => $datos['trichuris'],
			'enterobius'  => $datos['enterobius'],
			'taenia'      => $datos['taenia']
		);

		$this->db->insert('mc_master', $datos_mc_master);
	}

	private function cargar_harada_mori($datos)	{
		$datos_harada_mori = array(
			'copro'         => $datos['copro'],
			'strongyloides' => $datos['strongyloides'],
			'ancylostoma'   => $datos['ancylostoma'],
			'necator'       => $datos['necator'],
			'enterobius'    => $datos['enterobius']
		);

		$this->db->insert('harada_mori', $datos_harada_mori);
	}

	private function cargar_baerman($datos)	{
		$datos_baerman = array(
			'copro'         => $datos['copro'],
			'strongyloides' => $datos['strongyloides'],
			'ancylostoma'   => $datos['ancylostoma'],
			'necator'       => $datos['necator']
		);

		$this->db->insert('baerman', $datos_baerman);
	}

	private function cargar_placa_agar($datos) {
		$datos_placa_agar = array(
			'copro'         => $datos['copro'],
			'strongyloides' => $datos['strongyloides'],
			'ancylostoma'   => $datos['ancylostoma'],
			'necator'       => $datos['necator']
		);

		$this->db->insert('placa_agar', $datos_placa_agar);
	}

	public function ultimo_id() {
		$this->db->select_max('numero');
		$consulta = $this->db->get('coproparasitologico');

		return $consulta->row()->numero;
	}
}