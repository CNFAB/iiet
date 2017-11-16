<?php


class CentroSalud_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$datos_centro = array(
			'codigo' => $datos['codigo'],
			'nombre' => $datos['nombre'],
			'latitud' => $datos['latitud'] ? $datos['latitud'] : NULL,
			'longitud' => $datos['longitud'] ? $datos['longitud'] : NULL
		);

		$this->db->insert('centros_salud', $datos_centro);
		$id_centro = $this->ultimo_id();

		if($datos['lugar'] == 'paraje') {
			$datos_lugar = array(
				'centro_salud' => $id_centro,
				'paraje' => $datos['paraje']
			);

			$this->db->insert('paraje_centro_salud', $datos_lugar);
		}

		else {
			$datos_lugar = array(
				'centro_salud' => $id_centro,
				'barrio' => $datos['barrio']
			);

			$this->db->insert('barrio_centro_salud', $datos_lugar);
		}

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_centro;
		}
	}

	public function ultimo_id()	{
		$this->db->select_max('numero');
		$consulta = $this->db->get('centros_salud');

		return $consulta->row()->numero;
	}
}