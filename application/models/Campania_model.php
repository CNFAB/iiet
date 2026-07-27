<?php

class Campania_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function cargar($datos, $es_nuevo = TRUE, $campania = NULL) {
		$this->db->trans_begin();

		$datos_campania = array(
			'fecha_inicio'  => $datos['fecha_inicio'],
			'fecha_fin'     => $datos['fecha_fin'],
			'nombre'        => $datos['nombre'],
			'basal_control' => $datos['basal_control']
		);

		if($es_nuevo) {
			$this->db->insert('campanias', $datos_campania);

			$campania = $this->ultimo_id();

			$tipo_lugar = NULL;
		}

		else {
			$this->db->where('numero', $campania);
			$resultado = $this->db->get('v_campanias')->row();

			$tipo_lugar = $resultado->tipo;

			$this->db->where('numero', $campania);
			$this->db->update('campanias', $datos_campania);
		}

		/*if(isset($datos['en_escuela']))
			$this->establecer_escuela_campania($datos['escuela'], $es_nuevo, $campania, $tipo_lugar);

		else*/if(isset($datos['check-institucion']))
			$this->establecer_escuela_campania($datos['institucion'], $es_nuevo, $campania, $tipo_lugar);

		elseif($datos['lugar'] == 'paraje')
			$this->establecer_puesto_campania($datos['puesto'], $es_nuevo, $campania, $tipo_lugar);

		else
			$this->establecer_barrio_campania($datos['barrio'], $es_nuevo, $campania, $tipo_lugar);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $campania;
		}
	}

	private function establecer_escuela_campania($institucion, $es_nuevo, $campania, $lugar_ant) {
		if($es_nuevo) {
			$campania_institucion = array(
				'campania' => $campania,
				'institucion' => $institucion
			);

			$this->db->insert('instituciones_campanias', $campania_institucion);
		}

		else {
			$this->db->where('campania', $campania);

			switch($lugar_ant) {
				case 'ESCUELA':
				case 'CENTRO SALUD':
				case 'HOGAR':
				case 'CARCEL':
					$this->db->update('instituciones_campanias', array('institucion' => $institucion));
				break;

				case 'PUESTO':
					$this->db->delete('puestos_campanias');
					$this->establecer_escuela_campania($institucion, TRUE, $campania, NULL);
				break;

				case 'BARRIO':
					$this->db->delete('barrios_campanias');
					$this->establecer_escuela_campania($institucion, TRUE, $campania, NULL);
				break;
			}
		}
	}

	private function establecer_puesto_campania($puesto, $es_nuevo, $campania, $lugar_ant) {
		if($es_nuevo) {
			$campania_puesto = array(
				'campania' => $campania,
				'puesto' => $puesto
			);

			$this->db->insert('puestos_campanias', $campania_puesto);
		}

		else {
			$this->db->where('campania', $campania);

			switch($lugar_ant) {
				case 'PUESTO':
					$this->db->update('puestos_campanias', array('puesto' => $puesto));
				break;

				case 'BARRIO':
					$this->db->delete('barrios_campanias');
					$this->establecer_puesto_campania($puesto, TRUE, $campania, NULL);
				break;

				case 'ESCUELA':
				case 'CENTRO SALUD':
				case 'HOGAR':
				case 'CARCEL':
					$this->db->delete('instituciones_campanias');
					$this->establecer_puesto_campania($puesto, TRUE, $campania, NULL);
				break;
			}
		}
	}

	private function establecer_barrio_campania($barrio, $es_nuevo, $campania, $lugar_ant) {
		if($es_nuevo) {
			$campania_barrio = array(
				'campania' => $campania,
				'barrio' => $barrio
			);

			$this->db->insert('barrios_campanias', $campania_barrio);
		}

		else {
			$this->db->where('campania', $campania);

			switch($lugar_ant) {
				case 'BARRIO':
					$this->db->update('barrios_campanias', array('barrio' => $barrio));
				break;

				case 'PUESTO':
					$this->db->delete('puestos_campanias');
					$this->establecer_barrio_campania($barrio, TRUE, $campania, NULL);
				break;

				case 'ESCUELA':
				case 'CENTRO SALUD':
				case 'HOGAR':
				case 'CARCEL':
					$this->db->delete('instituciones_campanias');
					$this->establecer_barrio_campania($barrio, TRUE, $campania, NULL);
				break;
			}
		}
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
			$this->db->join('puestos_campanias CP', 'C.numero = CP.campania');
			$this->db->where('CP.puesto = ' . $datos['puesto']);
		}

		elseif(isset($datos['barrio'])) {
			$this->db->join('barrios_campanias CB', 'C.numero = CB.campania');
			$this->db->where('CB.barrio = ' . $datos['barrio']);
		}

		elseif(isset($datos['escuela'])) {
			$this->db->join('instituciones_campanias CE', 'C.numero = CE.campania');
			$this->db->where('CE.institucion = ' . $datos['escuela']);
		}

		$consulta = $this->db->get();

		return $consulta->result_array();
	}

	public function obtener_datos_campania($campania) {
		$this->db->select('numero, fecha_inicio, fecha_fin, nombre');
		$this->db->where('numero', $campania);

		$consulta = $this->db->get('campanias');

		if($consulta->num_rows() === 0)
			return FALSE;

		$datos_campania = $consulta->row_array();

		$this->db->select('E.nombre');
		$this->db->from('instituciones_campanias CE');
		$this->db->join('instituciones E', 'CE.institucion = E.numero');
		$this->db->where('campania', $campania);

		$consulta = $this->db->get();

		if($consulta->num_rows() > 0) {
			$datos_campania['tipo_lugar'] = 'escuela';
			$datos_campania['nombre_lugar'] = $consulta->row()->nombre;

			return $datos_campania;
		}

		$this->db->select('P.nombre');
		$this->db->from('puestos_campanias CP');
		$this->db->join('puestos P', 'CP.puesto = P.numero');
		$this->db->where('campania', $campania);

		$consulta = $this->db->get();

		if($consulta->num_rows() > 0) {
			$datos_campania['tipo_lugar'] = 'puesto';
			$datos_campania['nombre_lugar'] = $consulta->row()->nombre;

			return $datos_campania;
		}

		$this->db->select('B.nombre');
		$this->db->from('barrios_campanias CB');
		$this->db->join('barrios B', 'CB.barrio = B.numero');
		$this->db->where('campania', $campania);

		$consulta = $this->db->get();

		if($consulta->num_rows() > 0) {
			$datos_campania['tipo_lugar'] = 'barrio';
			$datos_campania['nombre_lugar'] = $consulta->row()->nombre;

			return $datos_campania;
		}

		return FALSE;
	}

	public function obtener_intervencion($campania, $paciente) {
		$this->db->select('IC.intervencion');
		$this->db->from('intervenciones_geohelmintos I');
		$this->db->join('intervenciones_campanias IC', 'I.numero = IC.intervencion');
		$this->db->where('IC.campania', $campania);
		$this->db->where('I.paciente', $paciente);

		$intervencion = $this->db->get();

		return $intervencion->num_rows() > 0 ? $intervencion->row()->intervencion : FALSE;
	}

	public function obtener_intervenciones($campania) {
		$this->db->where('campania', $campania);

		$resultado = $this->db->get('intervenciones_campanias')->result();

		$intervenciones = [];

		foreach($resultado as $registro)
			$intervenciones[] = $registro->intervencion;

		return $intervenciones;
	}

	public function eliminar($campania) {
		$this->load->model('intervencion_model');

		$intervenciones = $this->obtener_intervenciones($campania);

		$this->db->trans_begin();

		foreach($intervenciones as $intervencion)
			$this->intervencion_model->eliminar($intervencion);

		$this->eliminar_lugar_campania($campania, 'instituciones_campanias');
		$this->eliminar_lugar_campania($campania, 'puestos_campanias');
		$this->eliminar_lugar_campania($campania, 'barrios_campanias');

		$this->db->where('numero', $campania);

		$this->db->delete('campanias');

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return TRUE;
		}
	}

	private function eliminar_lugar_campania($campania, $lugar) {
		$this->db->where('campania', $campania);

		return $this->db->delete($lugar);
	}

	public function datos_completos($campania) {
		$this->db->where('numero', $campania);

		$resultado = $this->db->get('v_campanias');

		return $resultado->num_rows() > 0 ? $resultado->row_array() : FALSE;
	}

	public function cantidad_intervenciones($campania) {
		$this->db->where('campania', $campania);

		$resultado = $this->db->get('intervenciones_campanias');

		return $resultado->num_rows();
	}

	public function filtrar($campo, $valor, $offset) {
		if($campo && $valor)
			$this->db->ilike($campo, $valor, 'after');

		$this->db->order_by('fecha_inicio', 'ASC');
		$this->db->order_by('nombre', 'ASC');

		//$resultado = $this->db->get('v_campanias', 30, $offset);
		$resultado = $this->db->get('v_campanias');

		return $resultado->result_array();
	}

	public function obtener_nombre($campania) {
		$this->db->where('numero', $campania);

		$camp = $this->db->get('campanias')->row();

		return $camp->nombre;
	}


	public function obtener_listado($offset, $num_regs, $filtro, $ord_camp, $ord_dir) {
		if(!empty($filtro)) {
			$b = $this->dividir_filtro($filtro);

			if(!empty($b[0]))
				$this->db->ilike('nombre', $b[0], 'after');

			if(!empty($b[1]))
				$this->db->ilike('localidad', $b[1], 'after');

			if(!empty($b[2]))
				$this->db->ilike('tipo', $b[2], 'after');
		}


		$this->db->select('\'tc_\' || numero::text as DT_rowId, C.*');
		$this->db->order_by($ord_camp, $ord_dir);
		$regs = $this->db->get('v_campanias C', $num_regs, $offset);

		return $regs->num_rows() > 0 ? $regs->result_array() : array();
	}

	public function obtener_total($filtro = NULL) {
		if(!empty($filtro)) {
			$b = $this->dividir_filtro($filtro);

			if(!empty($b[0]))
				$this->db->ilike('nombre', $b[0], 'after');

			if(!empty($b[1]))
				$this->db->ilike('localidad', $b[1], 'after');

			if(!empty($b[2]))
				$this->db->ilike('tipo', $b[2], 'after');
		}
		
		$regs = $this->db->get('v_campanias');

		return $regs->num_rows();
	}

	private function dividir_filtro($str) {
		$posComa = strpos($str, ',');
		$posPunto = strpos($str, ':');

		if($posComa !== FALSE) {
			$nombre = trim(substr($str, 0, $posComa));

			if($posPunto !== FALSE) {
				$localidad = trim(substr($str, $posComa + 1, $posPunto - $posComa - 1));
				$tipo = trim(substr($str, $posPunto + 1));
			}

			else {
				$localidad = trim(substr($str, $posComa + 1));
				$tipo = '';
			}
		}

		else {
			$localidad = '';

			if($posPunto !== FALSE) {
				$nombre = trim(substr($str, 0, $posPunto));
				$tipo = trim(substr($str, $posPunto + 1));
			}

			else {
				$nombre = trim($str);
				$tipo = '';
			}
		}

		return array($nombre, $localidad, $tipo);
	}

	public function cantidad_masculinos($campania) {
		$this->db->from('intervenciones_geohelmintos I');
		$this->db->join('intervenciones_campanias C', 'I.numero = C.intervencion');
		$this->db->join('pacientes P', 'I.paciente = P.numero');
		$this->db->where('P.sexo', 'MASCULINO');
		$this->db->where('C.campania', $campania);

		return $this->db->get()->num_rows();
	}

	public function cantidad_femeninos($campania) {
		$this->db->from('intervenciones_geohelmintos I');
		$this->db->join('intervenciones_campanias C', 'I.numero = C.intervencion');
		$this->db->join('pacientes P', 'I.paciente = P.numero');
		$this->db->where('P.sexo', 'FEMENINO');
		$this->db->where('C.campania', $campania);

		return $this->db->get()->num_rows();
	}

	public function obtener_pacientes($campania) {
		$this->db->select('P.numero, P.dni, P.apellido, P.nombre');
		$this->db->from('campanias C');
		$this->db->join('intervenciones_campanias IC', 'C.numero = IC.campania');
		$this->db->join('intervenciones_geohelmintos I', 'IC.intervencion = I.numero');
		$this->db->join('pacientes P', 'I.paciente = P.numero');
		$this->db->where('C.numero', $campania);
		$this->db->order_by('P.apellido', 'ASC');
		$this->db->order_by('P.nombre', 'ASC');

		$consulta = $this->db->get();

		return $consulta->result_array();
	}
}