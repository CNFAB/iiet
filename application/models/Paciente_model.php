<?php

class Paciente_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$datos_paciente['dni'] = $datos['dni'];
		$datos_paciente['apellido'] = $datos['apellido'];
		$datos_paciente['nombre'] = $datos['nombre'];
		$datos_paciente['sexo'] = $datos['sexo'];
		$datos_paciente['fecha_nacimiento'] = $datos['fecha_nacimiento'];
		$datos_paciente['fecha_carga'] = date('d/m/Y');

		$this->db->insert('pacientes', $datos_paciente);

		$id = $this->ultimo_id();

		if($datos['lugar'] == 'paraje') {
			$datos_puesto['paciente'] = $id;
			$datos_puesto['puesto'] = $datos['puesto'];
			$datos_puesto['domicilio'] = $datos['domicilio'];

			$this->db->insert('puesto_paciente', $datos_puesto);
		}

		else {
			$datos_puesto['paciente'] = $id;
			$datos_puesto['barrio'] = $datos['barrio'];
			$datos_puesto['domicilio'] = $datos['domicilio'];

			$this->db->insert('barrio_paciente', $datos_puesto);
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

	public function actualizar($id, $datos_nuevos) {
		$this->db->where('codigo', $id);

		return $this->db->update('pacientes', $datos_nuevos);
	}

	public function existe($id) {
		$this->db->select('dni, apellido, nombre');
		$this->db->where('dni', $id);

		$consulta = $this->db->get('pacientes');

		return $consulta->row() ? $consulta->row() : FALSE;
	}

	public function lista() {
		$this->db->select('numero, apellido, nombre, dni');
		$this->db->order_by('apellido', 'ASC');
		$this->db->order_by('nombre', 'ASC');

		$consulta = $this->db->get('pacientes');

		return $consulta->result_array();
	}

	public function lista_filtro($campo_filtro, $valor_filtro) {
		$this->db->select('numero, apellido, nombre, dni');

		if($campo_filtro == 'apynomb') {
			$nombres = preg_split('/\s*,\s*/', $valor_filtro);

			$this->db->ilike('apellido', $nombres[0], 'after');

			if(count($nombres) > 1)
				$this->db->ilike('nombre', $nombres[1], 'after');

			$this->db->order_by('apellido', 'ASC');
			$this->db->order_by('nombre', 'ASC');
		}

		else {
			$this->db->ilike($campo_filtro, $valor_filtro, 'after');

			$this->db->order_by('dni', 'ASC');
		}

		$consulta = $this->db->get('pacientes');

		return $consulta->result_array();
	}

	public function ultimo_id() {
		$this->db->select_max('numero');
		$consulta = $this->db->get('pacientes');

		return $consulta->row()->numero;
	}
}