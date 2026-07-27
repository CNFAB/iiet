<?php

class Consulta_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function nueva($datos) {
		$datos_consulta = array(
			'nombre'         => $datos['nombre'],
			'fecha_creacion' => date('d/m/Y'),
			'hora_creacion'  => date('h:i'),
			'fecha_modif'    => date('d/m/Y'),
			'hora_modif'     => date('h:i'),
			'condiciones'    => $datos['condiciones'],
			'campos'         => $datos['campos']
		);

		return $this->db->insert('consultas', $datos_consulta);
	}

	public function obtener_lista() {
		$this->db->select('nombre, fecha_creacion, hora_creacion, fecha_modif, hora_modif');
		$consultas = $this->db->get('consultas');

		return $consultas->result_array();
	}

	public function obtener_una($nro_consulta) {
		$this->db->where('numero', $nro_consulta);
		$consulta = $this->db->get('consultas');

		return $consulta->num_rows() > 0 ? $consulta->row_array() : FALSE;
	}

	public function eliminar($numero) {
		$condicion = array('numero', $numero);

		return $this->db->delete('consultas', $condicion);
	}

	public function actualizar($datos) {
		$nuevo_datos = array(
			'nombre'      => $datos['nombre'],
			'fecha_modif' => date('d/m/Y'),
			'hora_modif'  => date('h:m'),
			'condiciones' => $datos['condiciones'],
			'campos'      => $datos['campos']
		);
	}
}