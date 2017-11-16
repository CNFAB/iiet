<?php


class Campania_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function nueva($datos) {
		$this->db->trans_begin();

		$datos_campania = array(
			'fecha_inicio' => $datos['fecha_inicio'],
			'fecha_fin' => $datos['fecha_fin'],
			'etiqueta' => $datos['etiqueta']
		);

		$this->db->insert('campanias', $datos_campania);

		$id_campania = $this->ultimo_id();
		$datos['campania'] = $id_campania;

		if(isset($datos['en_escuela']))
			$this->campania_escuela($datos);

		else
			$this->campania_comunidad($datos);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_campania;
		}
	}

	private function campania_escuela($datos) {
		$campania_escuela = array(
			'campania' => $datos['campania'],
			'escuela' => $datos['escuela']
		);

		$this->db->insert('campanias_escuelas', $campania_escuela);
	}

	private function campania_comunidad($datos) {
		$campania_comunidad = array(
			'campania' => $datos['campania']
		);

		$this->db->insert('campanias_comunidades', $datos_campania);

		if($datos['comunidad'] == 'paraje') {
			$campania_paraje = array(
				'campania' => $datos['campania'],
				'paraje' => $datos['paraje']
			);

			$this->db->insert('paraje_campania', $campania_paraje);
		}

		else {
			$campania_barrio = array(
				'campania' => $datos['campania'],
				'barrio' => $datos['barrio']
			);

			$this->db->insert('barrio_campania', $campania_barrio);
		}
	}

	public function ultimo_id() {
		$this->db->select_max('numero');
		$consulta = $this->db->get('campanias');

		return $consulta->row()->numero;
	}
}