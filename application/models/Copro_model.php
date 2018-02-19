<?php

class Copro_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('intervencion_model');
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$id_interv = $this->intervencion_model->obtener_intervencion($datos['intervencion']);

		$datos_copro = array(
			'intervencion' => $id_interv,
			'fecha'        => $datos['fecha'],
			'peso_materia' => $datos['peso_materia'],
			'consistencia' => $datos['consistencia']
		);

		if($this->existe_copro($id_interv)) {
			$this->db->where('intervencion', $id_interv);
			$this->db->update('coproparasitologico', $datos_copro);
		}

		else
			$this->db->insert('coproparasitologico', $datos_copro);

		$datos_concentrado = isset($datos['concentrado']) ? $datos['concentrado'] : false;
		$datos_mcmaster    = isset($datos['mc_master']) ? $datos['mc_master'] : false;
		$datos_haradamori  = isset($datos['harada_mori']) ? $datos['harada_mori'] : false;
		$datos_baerman     = isset($datos['baerman']) ? $datos['baerman'] : false;
		$datos_placaagar   = isset($datos['placa_agar']) ? $datos['placa_agar'] : false;

		$this->cargar_concentrado($id_interv, $datos_concentrado);
		$this->cargar_mc_master($id_interv, $datos_mcmaster);
		$this->cargar_harada_mori($id_interv, $datos_haradamori);
		$this->cargar_baerman($id_interv, $datos_baerman);
		$this->cargar_placa_agar($id_interv, $datos_placaagar);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_interv;
		}
	}

	private function cargar_concentrado($id_copro, $datos) {
		$ya_existe = $this->existe_metodo('concentrado', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('concentrado');
		}

		elseif($datos !== false) {
			$datos_concentrado = array(
				'copro'         => $id_copro,
				'ascaris'       => isset($datos['ascaris']),
				'giardia'       => isset($datos['giardia']),
				'entamoebacoli' => isset($datos['entamoebacoli']),
				'uncinarias'    => isset($datos['uncinarias']),
				'strongyloides' => isset($datos['strongyloides']),
				'hymenolepis'   => isset($datos['hymenolepis']),
				'trichuris'     => isset($datos['trichuris']),
				'enterobius'    => isset($datos['enterobius']),
				'taenia'        => isset($datos['taenia'])
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('concentrado', $datos_concentrado);
			}

			else
				$this->db->insert('concentrado', $datos_concentrado);
		}
	}

	private function cargar_mc_master($id_copro, $datos) {
		$ya_existe = $this->existe_metodo('mc_master', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('mc_master');
		}

		elseif($datos !== false) {
			$datos_mc_master = array(
				'copro'       => $id_copro,
				'ascaris'     => $datos['ascaris'],
				'uncinarias'  => $datos['uncinarias'],
				'hymenolepis' => $datos['hymenolepis'],
				'trichuris'   => $datos['trichuris'],
				'enterobius'  => $datos['enterobius'],
				'taenia'      => $datos['taenia']
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('mc_master', $datos_mc_master);
			}

			else
				$this->db->insert('mc_master', $datos_mc_master);
		}
	}

	private function cargar_harada_mori($id_copro, $datos)	{
		$ya_existe = $this->existe_metodo('harada_mori', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('harada_mori');
		}

		elseif($datos !== false) {
			$datos_harada_mori = array(
				'copro'         => $id_copro,
				'strongyloides' => $datos['strongyloides'],
				'ancylostoma'   => $datos['ancylostoma'],
				'necator'       => $datos['necator'],
				'enterobius'    => $datos['enterobius']
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('harada_mori', $datos_harada_mori);
			}

			else
				$this->db->insert('harada_mori', $datos_harada_mori);
		}
	}

	private function cargar_baerman($id_copro, $datos)	{
		$ya_existe = $this->existe_metodo('baerman', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('baerman');
		}

		elseif($datos !== false) {
			$datos_baerman = array(
				'copro'         => $id_copro,
				'strongyloides' => $datos['strongyloides'],
				'ancylostoma'   => $datos['ancylostoma'],
				'necator'       => $datos['necator']
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('baerman', $datos_baerman);
			}

			else
				$this->db->insert('baerman', $datos_baerman);
		}
	}

	private function cargar_placa_agar($id_copro, $datos) {
		$ya_existe = $this->existe_metodo('placa_agar', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('placa_agar');
		}

		elseif($datos !== false) {
			$datos_placa_agar = array(
				'copro'         => $id_copro,
				'strongyloides' => $datos['strongyloides'],
				'ancylostoma'   => $datos['ancylostoma'],
				'necator'       => $datos['necator']
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('placa_agar', $datos_placa_agar);
			}

			else
				$this->db->insert('placa_agar', $datos_placa_agar);
		}
	}

	public function obtenerCoproCampania($paciente) {
		return $this->intervencion_model->obtenerIntervencionesCampania($paciente);
	}

	private function existe_copro($id_interv) {
		$this->db->where('intervencion', $id_interv);

		$consulta = $this->db->get('coproparasitologico');

		return $consulta->num_rows() > 0;
	}

	private function existe_metodo($nombre, $id_copro) {
		$this->db->where('copro', $id_copro);

		$consulta = $this->db->get($nombre);

		return $consulta->num_rows() > 0;
	}
}