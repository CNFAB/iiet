<?php

class Divpolit_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function nueva($tabla, $datos) {
		$datos['latitud'] = $datos['latitud'] ? $datos['latitud'] : NULL;
		$datos['longitud'] = $datos['longitud'] ? $datos['longitud'] : NULL;
		
		$estado = $this->db->insert($tabla, $datos);

		if($estado != FALSE) {
			$this->db->select_max('numero');
			$consulta = $this->db->get($tabla);

			return $consulta->row()->numero;
		}
		
		return FALSE;
	}

	public function obtener_departamentos() {
		$consulta = $this->db->get('departamentos');

		return $consulta->result_array();
	}

	public function obtener_localidades($id_dpto) {
		$this->db->select('*');
		$this->db->where('departamento', $id_dpto);

		$consulta = $this->db->get('localidades');

		return $consulta->result_array();
	}

	public function obtener_barrios($id_loc) {
		$this->db->select('*');
		$this->db->where('localidad', $id_loc);

		$consulta = $this->db->get('barrios');

		return $consulta->result_array();
	}

	public function obtener_parajes($id_loc) {
		$this->db->select('*');
		$this->db->where('localidad', $id_loc);

		$consulta = $this->db->get('parajes');

		return $consulta->result_array();
	}

	public function obtener_puestos($id_pje) {
		$this->db->select('*');
		$this->db->where('paraje', $id_pje);

		$consulta = $this->db->get('puestos');

		return $consulta->result_array();
	}
}