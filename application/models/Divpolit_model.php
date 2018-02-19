<?php

class Divpolit_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function nueva($tabla, $datos) {
		$datos['latitud'] = $datos['latitud'] ? $datos['latitud'] : NULL;
		$datos['longitud'] = $datos['longitud'] ? $datos['longitud'] : NULL;
		
		if(isset($datos['numero'])) {
			$this->db->where('numero', $datos['numero']);
			
			return $this->db->update($tabla, $datos);
		}

		else {
			$estado = $this->db->insert($tabla, $datos);

			if($estado != FALSE) {
				$this->db->select_max('numero');
				$consulta = $this->db->get($tabla);

				return $consulta->row()->numero;
			}
			
			return FALSE;
		}
	}

	public function obtener_departamentos() {
		$this->db->select('D.numero, D.nombre, D.latitud, D.longitud, CL.cantidad AS cant_localidades');
		$this->db->from('departamentos D');
		$this->db->join('v_cant_localidades CL', 'D.numero = CL.departamento', 'LEFT');
		$this->db->order_by('nombre', 'ASC');

		$consulta = $this->db->get();

		return $consulta->result_array();
	}

	public function obtener_localidades($id_dpto) {
		$this->db->select('L.numero, L.departamento, L.nombre, L.latitud, L.longitud,'
			.'CB.cantidad AS cant_barrios, CP.cantidad as cant_parajes');
		$this->db->from('localidades L');
		$this->db->join('v_cant_barrios CB', 'L.numero = CB.localidad', 'LEFT');
		$this->db->join('v_cant_parajes CP', 'L.numero = CP.localidad', 'LEFT');
		$this->db->where('departamento', $id_dpto);
		$this->db->order_by('nombre', 'ASC');

		$consulta = $this->db->get();

		return $consulta->result_array();
	}

	public function obtener_barrios($id_loc) {
		$this->db->select('B.numero, B.localidad, B.nombre, B.latitud, B.longitud, CE.cantidad AS cant_escuelas');
		$this->db->from('barrios B');
		$this->db->join('v_cant_escuelas_barrio CE', 'B.numero = CE.barrio', 'LEFT');
		$this->db->where('B.localidad', $id_loc);
		$this->db->order_by('B.nombre', 'ASC');

		$consulta = $this->db->get();

		return $consulta->result_array();
	}

	public function obtener_parajes($id_loc) {
		$this->db->select('P.numero, P.nombre, P.latitud, P.longitud, CP.cantidad AS cant_puestos');
		$this->db->from('parajes P');
		$this->db->join('v_cant_puestos CP', 'P.numero = CP.paraje', 'LEFT');
		$this->db->where('localidad', $id_loc);
		$this->db->order_by('nombre', 'ASC');

		$consulta = $this->db->get();

		return $consulta->result_array();
	}

	public function obtener_puestos($id_pje) {
		$this->db->select('*');
		$this->db->where('paraje', $id_pje);

		$consulta = $this->db->get('puestos');

		return $consulta->result_array();
	}
}