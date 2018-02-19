<?php

class Escuela_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function nueva($datos) {
		$this->db->trans_begin();
		
		$datos_escuela = array();
		$datos_escuela['nombre'] = $datos['nombre'];
		$datos_escuela['latitud'] = $datos['latitud'] ? $datos['latitud'] : NULL;
		$datos_escuela['longitud'] = $datos['longitud'] ? $datos['longitud'] : NULL;

		$this->db->insert('escuelas', $datos_escuela);
		$id = $this->ultimo_id();

		$datos_lugar = array();

		if($datos['lugar'] == 'paraje') {
			$datos_lugar['escuela'] = $id;
			$datos_lugar['paraje'] = $datos['paraje'];

			$this->db->insert('paraje_escuela', $datos_lugar);
		}

		else {
			$datos_lugar['escuela'] = $id;
			$datos_lugar['barrio'] = $datos['barrio'];

			$this->db->insert('barrio_escuela', $datos_lugar);
		}

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id;
		}
	}

	public function ultimo_id() {
		$this->db->select_max('numero');
		$consulta = $this->db->get('escuelas');

		return $consulta->row()->numero;
	}

	public function obtener_escuelas($lugar) {
		$this->db->select('numero, nombre');
		$this->db->from('escuelas E');

		if(isset($lugar['barrio'])) {
			$this->db->join('barrio_escuela BE', 'E.numero = BE.escuela');
			$this->db->where('BE.barrio = ' . $lugar['barrio']);
		}

		else {
			$this->db->join('paraje_escuela PE', 'E.numero = PE.escuela');
			$this->db->where('PE.paraje = ' . $lugar['paraje']);
		}

		$consulta = $this->db->get();

		return $consulta->result_array();
	}
}