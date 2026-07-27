<?php

class Institucion_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function nueva($datos) {
		$datos_escuela = array(
			'nombre'   => $datos['nombre'],
			'tipo'     => $datos['tipo'],
			'latitud'  => $datos['latitud'] ? $datos['latitud'] : NULL,
			'longitud' => $datos['longitud'] ? $datos['longitud'] : NULL
		);

		$this->db->trans_begin();

		if(isset($datos['numero'])) {
			$this->db->where('numero', $datos['numero']);
			$this->db->update('instituciones', $datos_escuela);

			$id = $datos['numero'];
		}

		else {
			$estado = $this->db->insert('instituciones', $datos_escuela);

			$id = $this->ultimo_id();

			$datos_lugar = array();

			if($datos['lugar'] == 'paraje') {
				$datos_lugar['institucion'] = $id;
				$datos_lugar['paraje'] = $datos['paraje'];

				$this->db->insert('paraje_institucion', $datos_lugar);
			}

			else {
				$datos_lugar['institucion'] = $id;
				$datos_lugar['barrio'] = $datos['barrio'];

				$this->db->insert('barrio_institucion', $datos_lugar);
			}
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
		$consulta = $this->db->get('instituciones');

		return $consulta->row()->numero;
	}

	public function obtener_escuelas($lugar) {
		$this->db->select('numero, nombre, latitud, longitud, tipo');
		$this->db->from('instituciones I');

		if(isset($lugar['barrio'])) {
			$this->db->join('barrio_institucion BI', 'I.numero = BI.institucion');
			$this->db->where('BI.barrio = ' . $lugar['barrio']);
		}

		else {
			$this->db->join('paraje_institucion PI', 'I.numero = PI.institucion');
			$this->db->where('PI.paraje = ' . $lugar['paraje']);
		}

		$consulta = $this->db->get();

		return $consulta->result_array();
	}
}