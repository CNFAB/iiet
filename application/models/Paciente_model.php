<?php

class Paciente_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$datos_paciente = array(
			'nro_cuaderno'     => $datos['nro_cuaderno'] ? $datos['nro_cuaderno'] : NULL,
			'dni'              => $datos['dni'],
			'apellido'         => $datos['apellido'],
			'nombre'           => $datos['nombre'],
			'sexo'             => $datos['sexo'],
			'fecha_nacimiento' => $datos['fecha_nacimiento'],
			'fecha_carga'      => date('d/m/Y'),
			'domicilio'        => $datos['domicilio'],
			'nro_familia'	   => $datos['nro_familia'] ? $datos['nro_familia'] : NULL,
			'nro_vivienda'	   => $datos['nro_vivienda'] ? $datos['nro_vivienda'] : NULL
		);

		$this->db->insert('pacientes', $datos_paciente);

		$id = $this->ultimo_id();
		$datos['paciente'] = $id;

		if($datos['lugar'] == 'paraje')
			$this->establecer_puesto($datos);

		else
			$this->establecer_barrio($datos);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id;
		}
	}

	public function establecer_barrio($datos) {
		$datos_barrio = array(
			'paciente'  => $datos['paciente'],
			'barrio'    => $datos['barrio']
		);

		$this->db->insert('barrio_paciente', $datos_barrio);
	}

	public function establecer_puesto($datos) {
		$datos_puesto = array(
			'paciente'  => $datos['paciente'],
			'puesto'    => $datos['puesto']
		);

		$this->db->insert('puesto_paciente', $datos_puesto);
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

	public function obtener_dtsparainterv($id) {
		$this->db->select('numero, domicilio, nro_familia, nro_vivienda');
		$this->db->where('numero', $id);

		return $this->db->get('pacientes')->row_array();
	}
}