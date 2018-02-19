<?php


class Campania_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function nueva($datos) {
		$this->db->trans_begin();

		$datos_campania = array(
			'fecha_inicio'  => $datos['fecha_inicio'],
			'fecha_fin'     => $datos['fecha_fin'],
			'nombre'        => $datos['nombre'],
			'basal_control' => $datos['basal_control']
		);

		$this->db->insert('campanias', $datos_campania);

		$id_campania = $this->ultimo_id();

		if(isset($datos['en_escuela']))
			$this->campania_escuela($id_campania, $datos['escuela']);

		elseif($datos['lugar'] == 'paraje')
			$this->campania_puesto($id_campania, $datos['puesto']);

		else
			$this->campania_barrio($id_campania, $datos['barrio']);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_campania;
		}
	}

	private function campania_escuela($campania, $escuela) {
		$campania_escuela = array(
			'campania' => $campania,
			'escuela' => $escuela
		);

		$this->db->insert('campanias_escuelas', $campania_escuela);
	}

	private function campania_puesto($campania, $puesto) {
		$campania_puesto = array(
			'campania' => $campania,
			'puesto' => $puesto
		);

		$this->db->insert('campanias_puestos', $campania_puesto);
	}

	private function campania_barrio($campania, $barrio) {
		$campania_barrio = array(
			'campania' => $campania,
			'barrio' => $barrio
		);

		$this->db->insert('campanias_barrios', $campania_barrio);
	}

	public function ultimo_id() {
		$this->db->select_max('numero');
		$consulta = $this->db->get('campanias');

		return $consulta->row()->numero;
	}

	public function obtener_lista_campanias($datos) {
		$this->db->select('numero, nombre');
		$this->db->from('campanias C');

		if(isset($datos['puesto'])) {
			$this->db->join('campanias_puestos CP', 'C.numero = CP.campania');
			$this->db->where('CP.puesto = ' . $datos['puesto']);
		}

		elseif(isset($datos['barrio'])) {
			$this->db->join('campanias_barrios CB', 'C.numero = CB.campania');
			$this->db->where('CB.barrio = ' . $datos['barrio']);
		}

		elseif(isset($datos['escuela'])) {
			$this->db->join('campanias_escuelas CE', 'C.numero = CE.campania');
			$this->db->where('CE.escuela = ' . $datos['escuela']);
		}

		$consulta = $this->db->get();

		return $consulta->result_array();
	}

	public function obtener_datos_campania($datos) {
		$this->db->select('numero, fecha_inicio, fecha_fin, nombre');
		$this->db->where('numero', $datos['campania']);

		$consulta = $this->db->get('campanias');

		if($consulta->num_rows() === 0)
			return FALSE;

		$datos_campania = $consulta->row_array();

		$this->db->select('E.nombre');
		$this->db->from('campanias_escuelas CE');
		$this->db->join('escuelas E', 'CE.escuela = E.numero');
		$this->db->where('campania', $datos['campania']);

		$consulta = $this->db->get();

		if($consulta->num_rows() > 0) {
			$datos_campania['tipo_lugar'] = 'escuela';
			$datos_campania['nombre_lugar'] = $consulta->row()->nombre;

			return $datos_campania;
		}

		$this->db->select('P.nombre');
		$this->db->from('campanias_puestos CP');
		$this->db->join('puestos P', 'CP.puesto = P.numero');
		$this->db->where('campania', $datos['campania']);

		$consulta = $this->db->get();

		if($consulta->num_rows() > 0) {
			$datos_campania['tipo_lugar'] = 'puesto';
			$datos_campania['nombre_lugar'] = $consulta->row()->nombre;

			return $datos_campania;
		}

		$this->db->select('B.nombre');
		$this->db->from('campanias_barrios CB');
		$this->db->join('barrios B', 'CB.barrio = B.numero');
		$this->db->where('campania', $datos['campania']);

		$consulta = $this->db->get();

		if($consulta->num_rows() > 0) {
			$datos_campania['tipo_lugar'] = 'barrio';
			$datos_campania['nombre_lugar'] = $consulta->row()->nombre;

			return $datos_campania;
		}

		return FALSE;
	}
}