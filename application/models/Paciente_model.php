<?php

class Paciente_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function cargar($datos, $es_nuevo = TRUE, $paciente = NULL) {
		$this->db->trans_begin();

		$datos_paciente = array(
			'nro_cuaderno'     => $datos['nro_cuaderno'] ? $datos['nro_cuaderno'] : NULL,
			'dni'              => $datos['dni'],
			'apellido'         => $datos['apellido'],
			'nombre'           => $datos['nombre'],
			'sexo'             => $datos['sexo'],
			'fecha_nacimiento' => $datos['fecha_nacimiento'],
			'fecha_carga'      => date('Y-m-d'),
			'domicilio'        => $datos['domicilio'],
			'latitud'          => (isset($datos['latitud'])  && $datos['latitud']  !== '') ? $datos['latitud']  : NULL,
      	    'longitud'         => (isset($datos['longitud']) && $datos['longitud'] !== '') ? $datos['longitud'] : NULL
		);

		if($es_nuevo) {
			$this->db->insert('pacientes', $datos_paciente);

			$paciente = $this->ultimo_id();

			$tipo_lugar = NULL;
		}

		else {
			$this->db->where('numero', $paciente);
			$resultado = $this->db->get('v_pacientes')->row();

			$tipo_lugar = $resultado->barrio ? 'BARRIO' : 'PUESTO';

			$this->db->where('numero', $paciente);
			$this->db->update('pacientes', $datos_paciente);
		}

		if($datos['lugar'] == 'paraje')
			$this->establecer_puesto($datos['puesto'], $es_nuevo, $paciente, $tipo_lugar);

		else
			$this->establecer_barrio($datos['barrio'], $es_nuevo, $paciente, $tipo_lugar);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $paciente;
		}
	}

	public function establecer_barrio($barrio, $es_nuevo, $paciente, $lugar_ant) {
		if($es_nuevo) {
			$datos_barrio = array(
				'paciente'  => $paciente,
				'barrio'    => $barrio
			);

			$this->db->insert('barrio_paciente', $datos_barrio);
		}

		else {
			if($lugar_ant == 'BARRIO') {
				$this->db->where('paciente', $paciente);
				$this->db->update('barrio_paciente', array('barrio' => $barrio));
			}

			else {
				$this->db->where('paciente', $paciente);
				$this->db->delete('puesto_paciente');

				$this->establecer_barrio($barrio, TRUE, $paciente, NULL);
			}
		}
	}

	public function establecer_puesto($puesto, $es_nuevo, $paciente, $lugar_ant) {
		if($es_nuevo) {
			$datos_puesto = array(
				'paciente'  => $paciente,
				'puesto'    => $puesto
			);

			$this->db->insert('puesto_paciente', $datos_puesto);
		}

		else {
			if($lugar_ant == 'PUESTO') {
				$this->db->where('paciente', $paciente);
				$this->db->update('puesto_paciente', array('puesto' => $puesto));
			}

			else {
				$this->db->where('paciente', $paciente);
				$this->db->delete('barrio_paciente');

				$this->establecer_puesto($puesto, TRUE, $paciente, NULL);
			}
		}
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

	public function datos_para_intervencion($id) {
		$this->db->select('P.numero, BP.barrio, PP.puesto, P.domicilio, P.nro_familia, P.nro_vivienda');
		$this->db->from('pacientes P');
		$this->db->join('barrio_paciente BP', 'P.numero = BP.paciente', 'LEFT');
		$this->db->join('puesto_paciente PP', 'P.numero = PP.paciente', 'LEFT');
		$this->db->where('numero', $id);

		return $this->db->get()->row_array();
	}

	public function obtener_datos_todos($offset) {
		$this->db->order_by('numero', 'DESC');
		$resultado = $this->db->get('v_pacientes', 30, $offset);

		return $resultado->result_array();
	}

	public function obtener_datos($paciente) {
		$this->db->where('numero', $paciente);

		$paciente = $this->db->get('v_pacientes');

		return $paciente->num_rows() > 0 ? $paciente->row_array() : NULL;
	}

	public function filtrar($campo, $valor, $offset) {
		if($campo == 'apynomb') {
			$nombres = preg_split('/\s*,\s*/', $valor);
			$this->db->ilike('apellido', $nombres[0], 'after');

			if(count($nombres) > 1)
				$this->db->ilike('nombre', $nombres[1], 'after');
		}

		elseif($campo == 'dni')
			$this->db->ilike($campo, $valor, 'after');

		$this->db->order_by('numero', 'DESC');
		//$consulta = $this->db->get('v_pacientes', 30, $offset);
		$consulta = $this->db->get('v_pacientes');

		return $consulta->result_array();
	}

	public function eliminar($paciente) {
		$this->load->model('intervencion_model');

		$intervenciones = $this->intervencion_model->obtener_intervenciones_paciente($paciente);

		$this->db->trans_begin();

		for($i = 0; $i < count($intervenciones); ++$i)
			$this->intervencion_model->eliminar($intervenciones[$i]['numero']);

		$this->eliminar_datos_paciente($paciente, 'barrio_paciente');
		$this->eliminar_datos_paciente($paciente, 'puesto_paciente');

		$this->db->where('numero', $paciente);

		$this->db->delete('pacientes');

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return TRUE;
		}
	}

	private function eliminar_datos_paciente($paciente, $dato) {
		$this->db->where('paciente', $paciente);

		return $this->db->delete($dato);
	}

	public function obtener_listado($offset, $num_regs, $filtro, $ord_camp, $ord_dir) {
		if(!empty($filtro)) {
			$b = $this->dividir_filtro($filtro);

			if(!empty($b[0]))
				$this->db->ilike('apellido', $b[0], 'after');

			if(!empty($b[1]))
				$this->db->ilike('nombre', $b[1], 'after');

			if(!empty($b[2]))
				$this->db->ilike('dni', $b[2], 'after');
		}

		$this->db->select('\'tp_\' || numero::text as DT_rowId, P.*');
		$this->db->order_by($ord_camp, $ord_dir);
		$regs = $this->db->get('v_pacientes P', $num_regs, $offset);

		return $regs->num_rows() > 0 ? $regs->result_array() : array();
	}

	public function obtener_total($filtro = NULL) {
		if(!empty($filtro)) {
			$b = $this->dividir_filtro($filtro);

			if(!empty($b[0]))
				$this->db->ilike('apellido', $b[0], 'after');

			if(!empty($b[1]))
				$this->db->ilike('nombre', $b[1], 'after');

			if(!empty($b[2]))
				$this->db->ilike('dni', $b[2], 'after');
		}

		$regs = $this->db->get('pacientes');

		return $regs->num_rows();
	}

	private function dividir_filtro($str) {
		$posComa = strpos($str, ',');
		$posPunto = strpos($str, ':');

		if($posComa !== FALSE) {
			$apellido = trim(substr($str, 0, $posComa));

			if($posPunto !== FALSE) {
				$nombre = trim(substr($str, $posComa + 1, $posPunto - $posComa - 1));
				$dni = trim(substr($str, $posPunto + 1));
			}

			else {
				$nombre = trim(substr($str, $posComa + 1));
				$dni = '';
			}
		}

		else {
			$nombre = '';

			if($posPunto !== FALSE) {
				$apellido = trim(substr($str, 0, $posPunto));
				$dni = trim(substr($str, $posPunto + 1));
			}

			else {
				$apellido = trim($str);
				$dni = '';
			}
		}

		return array($apellido, $nombre, $dni);
	}

	/*public function obtener_domicilio($id_paciente) {
		$this->db->select('\'barrio\' tipo, null::integer as puesto, null::integer as paraje, B.numero barrio, L.numero localidad, L.departamento');
		$this->db->from('pacientes P');
		$this->db->join('barrio_paciente BP', 'P.numero = BP.paciente');
		$this->db->join('barrios B', 'BP.barrio = B.numero');
		$this->db->join('localidades L', 'B.localidad = L.numero');
		$this->db->where('P.numero', $id_paciente);
		$query1 = $this->db->get_compiled_select();

		$this->db->select('\'puesto\' tipo, PT.numero puesto, PJ.numero paraje, null::integer as barrio, L.numero localidad, L.departamento');
		$this->db->from('pacientes P');
		$this->db->join('puesto_paciente PP', 'P.numero = PP.paciente');
		$this->db->join('puestos PT', 'PP.puesto = PT.numero');
		$this->db->join('parajes PJ', 'P.paraje = PJ.numero');
		$this->db->join('localidades L', 'PJ.localidad = L.numero');
		$this->db->where('P.numero', $id_paciente);
		$query2 = $this->db->get_compiled_select();

		$result = $this->db->query($query1 . ' UNION ' . $query2);

		return $result->row();
	}*/






	public function obtener_listado_pacientes() {
		$this->db->select('numero, apellido, nombre, dni, sexo, fecha_nacimiento, fecha_carga, domicilio');
		$this->db->where('domicilio <> \'\'');
		$this->db->order_by('apellido', 'ASC');
		$this->db->order_by('nombre', 'ASC');

		$consulta = $this->db->get('pacientes', 50);

		return $consulta->result_array();
	}
}