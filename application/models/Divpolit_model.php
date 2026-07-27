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
			$this->db->update($tabla, $datos);

			return $datos['numero'];
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

	public function departamento_tiene_dependencias($id_dpto) {
		$this->db->where('departamento', $id_dpto);
		$consulta = $this->db->get('localidades');

		return $consulta->num_rows() > 0;
	}

	public function eliminar_departamento($id_dpto) {
		$estado = FALSE;

		if(!$this->departamento_tiene_dependencias($id_dpto)) {
			$this->db->delete('departamentos', 'numero = '.$id_dpto);
			$estado = TRUE;
		}

		return $estado;
	}

	public function localidad_tiene_dependencias($id_localidad) {
		$this->db->where('localidad', $id_localidad);
		$consulta1 = $this->db->get('barrios');

		$this->db->where('localidad', $id_localidad);
		$consulta2 = $this->db->get('parajes');

		return $consulta1->num_rows() > 0 || $consulta2->num_rows() > 0;
	}

	public function eliminar_localidad($id_localidad) {
		$estado = FALSE;

		if(!$this->localidad_tiene_dependencias($id_localidad)) {
			$this->db->delete('localidades', 'numero = '.$id_localidad);
			$estado = TRUE;
		}

		return $estado;
	}

	public function barrio_tiene_dependencias($id_barrio) {
		$this->db->where('barrio', $id_barrio);
		$consulta1 = $this->db->get('barrio_institucion');

		$this->db->where('barrio', $id_barrio);
		$consulta2 = $this->db->get('barrios_intervenciones');

		return $consulta1->num_rows() > 0 || $consulta2->num_rows() > 0;
	}

	public function eliminar_barrio($id_barrio) {
		$estado = FALSE;

		if(!$this->barrio_tiene_dependencias($id_barrio)) {
			$this->db->delete('barrios', 'numero = '.$id_barrio);
			$estado = TRUE;
		}

		return $estado;
	}

	public function paraje_tiene_dependencias($id_paraje) {
		$this->db->where('paraje', $id_paraje);
		$consulta1 = $this->db->get('paraje_institucion');

		$this->db->where('paraje', $id_paraje);
		$consulta2 = $this->db->get('puestos');

		return $consulta1->num_rows() > 0 || $consulta2->num_rows() > 0;
	}

	public function eliminar_paraje($id_paraje) {
		$estado = FALSE;

		if(!$this->paraje_tiene_dependencias($id_paraje)) {
			$this->db->delete('parajes', 'numero = '.$id_paraje);
			$estado = TRUE;
		}

		return $estado;
	}

	public function puesto_tiene_dependencias($id_puesto) {
		$this->db->where('puesto', $id_puesto);
		$consulta1 = $this->db->get('puestos_intervenciones');

		return $consulta1->num_rows() > 0;
	}

	public function eliminar_puesto($id_puesto) {
		$estado = FALSE;

		if(!$this->puesto_tiene_dependencias($id_puesto)) {
			$this->db->delete('puestos', 'numero = '.$id_puesto);
			$estado = TRUE;
		}

		return $estado;
	}

	public function institucion_tiene_dependencias($id_institucion) {
		$this->db->where('institucion', $id_institucion);
		$consulta1 = $this->db->get('instituciones_campanias');

		$this->db->where('procedencia', $id_institucion);
		$consulta2 = $this->db->get('consultorio_externo');

		return $consulta1->num_rows() > 0 || $consulta2->num_rows() > 0;
	}

	public function eliminar_institucion($id_institucion) {
		$estado = FALSE;

		if(!$this->institucion_tiene_dependencias($id_institucion)) {
			$this->db->trans_begin();

			$this->db->delete('barrio_institucion', 'institucion = '.$id_institucion);
			$this->db->delete('paraje_institucion', 'institucion = '.$id_institucion);

			$this->db->delete('instituciones', 'numero = '.$id_institucion);

			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();

				$estado = FALSE;
			}

			else {
				$this->db->trans_commit();
				$estado = TRUE;
			}
		}

		return $estado;
	}
}