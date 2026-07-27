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

	public function obtener_centros($lugar) {
		$this->db->select('numero, nombre');
		$this->db->from('centros_salud CS');

		if(isset($lugar['barrio'])) {
			$this->db->join('barrio_centro_salud BCS', 'CS.numero = BCS.centro_salud');
			$this->db->where('BCS.barrio = ' . $lugar['barrio']);
		}

		else {
			$this->db->join('paraje_centro_salud PCS', 'CS.numero = PCS.centro_salud');
			$this->db->where('PCS.paraje = ' . $lugar['paraje']);
		}

		$centros = $this->db->get();

		return $centros->result_array();
	}
}