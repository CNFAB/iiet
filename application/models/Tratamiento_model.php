<?php

class Tratamiento_model extends CI_Model {
	
	function __construct() {
		parent::__construct();

		$this->load->model('intervencion_model');
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$interv = $datos['intervencion'];

		// si existe la propiedad numero es porque la intervención es de tipo EXTERNO
		// de lo contrario es de tipo CAMPANIA
		if(isset($interv['numero'])) {
			$id_interv = $interv['numero'];
		}

		else {
			$id_interv = $this->campania_model->obtener_intervencion($interv['campania'], $interv['paciente']);
			
			if(!$id_interv)
				$id_interv = $this->intervencion_model->nueva($interv);
		}

		$no_tratado = isset($datos['no_tratado']) ? $datos['no_tratado'] : NULL;

		$datos_tratamiento = array(
			'intervencion' => $id_interv,
			'fecha'        => $datos['fecha'],
			'no_tratado'   => $no_tratado
		);

		if($this->existe_tratamiento($id_interv)) {
			$this->db->where('intervencion', $id_interv);
			$this->db->update('tratamientos', $datos_tratamiento);
		}

		else
			$this->db->insert('tratamientos', $datos_tratamiento);

		$datos_medidas     = isset($datos['medidas'])            ? $datos['medidas']            : FALSE;
		$datos_tratprev    = isset($datos['tratamiento_previo']) ? $datos['tratamiento_previo'] : FALSE;
		$datos_mebendazol  = $no_tratado ? FALSE : $datos['mebendazol'];
		$datos_albendazol  = $no_tratado ? FALSE : $datos['albendazol'];
		$datos_ivermectina = $no_tratado ? FALSE : $datos['ivermectina'];

		$this->cargar_medidas($id_interv, $datos_medidas);
		$this->cargar_tratamiento_previo($id_interv, $datos_tratprev);
		$this->cargar_dosis_mebendazol($id_interv, $datos_mebendazol);
		$this->cargar_dosis_albendazol($id_interv, $datos_albendazol);
		$this->cargar_dosis_ivermectina($id_interv, $datos_ivermectina);

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_interv;
		}
	}

	private function cargar_medidas($id_tratamiento, $datos) {
		$ya_existe = $this->existe_metodo('medidas_antropometricas', $id_tratamiento);

		if(!$datos && $ya_existe) {
			$this->db->where('tratamiento', $id_tratamiento);
			$this->db->delete('medidas_antropometricas');
		}

		elseif($datos !== false) {
			$datos_medidas = array(
				'tratamiento'        => $id_tratamiento,
				'peso'               => $datos['peso'] 				 !== '' ? $datos['peso'] 			   : NULL,
				'talla'              => $datos['talla'] 			 !== '' ? $datos['talla'] 			   : NULL,
				'perimetro_cefalico' => $datos['perimetro_cefalico'] !== '' ? $datos['perimetro_cefalico'] : NULL
			);

			if($ya_existe) {
				$this->db->where('tratamiento', $id_tratamiento);
				$this->db->update('medidas_antropometricas', $datos_medidas);
			}

			else
				$this->db->insert('medidas_antropometricas', $datos_medidas);
		}
	}

	private function cargar_tratamiento_previo($id_tratamiento, $datos) {
		$ya_existe = $this->existe_metodo('tratamientos_previos', $id_tratamiento);

		if(!$datos && $ya_existe) {
			$this->db->where('tratamiento', $id_tratamiento);
			$this->db->delete('tratamientos_previos');
		}

		elseif($datos !== false) {
			$datos_trat_prev = array(
				'tratamiento' => $id_tratamiento,
				'fecha'              => $datos['fecha'],
				'mebendazol'         => isset($datos['mebendazol'])   ? 'SI' : 'NO',
				'albendazol'         => isset($datos['albendazol'])   ? 'SI' : 'NO',
				'ivermectina'        => isset($datos['ivermectina'])  ? 'SI' : 'NO',
				'metronidazol'       => isset($datos['metronidazol']) ? 'SI' : 'NO',
				'otras'              => $datos['otras'] !== '' ? $datos['otras'] : NULL
			);

			if($ya_existe) {
				$this->db->where('tratamiento', $id_tratamiento);
				$this->db->update('tratamientos_previos', $datos_trat_prev);
			}

			else
				$this->db->insert('tratamientos_previos', $datos_trat_prev);
		}
	}

	private function cargar_dosis_mebendazol($id_tratamiento, $datos) {
		$ya_existe = $this->existe_dosis_droga('MEBENDAZOL', $id_tratamiento);

		if(!$datos && $ya_existe) {
			$this->db->where('tratamiento', $id_tratamiento);
			$this->db->where('droga', 'MEBENDAZOL');
			$this->db->delete('dosis_drogas');
		}

		elseif($datos !== false) {
			$datos_dosis = array(
				'tratamiento' => $id_tratamiento,
				'droga'       => 'MEBENDAZOL',
				'dosis'       => isset($datos['dosis']) 	? $datos['dosis'] 	  : NULL,
				'exclusion'   => isset($datos['exclusion']) ? $datos['exclusion'] : NULL
			);

			if($ya_existe) {
				$this->db->where('tratamiento', $id_tratamiento);
				$this->db->where('droga', 'MEBENDAZOL');
				$this->db->update('dosis_drogas', $datos_dosis);
			}

			else
				$this->db->insert('dosis_drogas', $datos_dosis);
		}
	}

	private function cargar_dosis_albendazol($id_tratamiento, $datos) {
		$ya_existe = $this->existe_dosis_droga('ALBENDAZOL', $id_tratamiento);

		if(!$datos && $ya_existe) {
			$this->db->where('tratamiento', $id_tratamiento);
			$this->db->where('droga', 'ALBENDAZOL');
			$this->db->delete('dosis_drogas');
		}

		elseif($datos !== false) {
			$datos_dosis = array(
				'tratamiento' => $id_tratamiento,
				'droga'       => 'ALBENDAZOL',
				'dosis'       => isset($datos['dosis']) 	? $datos['dosis'] 	  : NULL,
				'exclusion'   => isset($datos['exclusion']) ? $datos['exclusion'] : NULL
			);

			if($ya_existe) {
				$this->db->where('tratamiento', $id_tratamiento);
				$this->db->where('droga', 'ALBENDAZOL');
				$this->db->update('dosis_drogas', $datos_dosis);
			}

			else
				$this->db->insert('dosis_drogas', $datos_dosis);
		}
	}

	private function cargar_dosis_ivermectina($id_tratamiento, $datos) {
		$ya_existe = $this->existe_dosis_droga('IVERMECTINA', $id_tratamiento);

		if(!$datos && $ya_existe) {
			$this->db->where('tratamiento', $id_tratamiento);
			$this->db->where('droga', 'IVERMECTINA');
			$this->db->delete('dosis_drogas');
		}

		elseif($datos !== false) {
			$datos_dosis = array(
				'tratamiento' => $id_tratamiento,
				'droga'       => 'IVERMECTINA',
				'dosis'       => isset($datos['dosis']) 	? $datos['dosis'] 	  : NULL,
				'exclusion'   => isset($datos['exclusion']) ? $datos['exclusion'] : NULL
			);

			if($ya_existe) {
				$this->db->where('tratamiento', $id_tratamiento);
				$this->db->where('droga', 'IVERMECTINA');
				$this->db->update('dosis_drogas', $datos_dosis);
			}

			else
				$this->db->insert('dosis_drogas', $datos_dosis);
		}
	}

	private function existe_tratamiento($id_interv) {
		$this->db->where('intervencion', $id_interv);

		$consulta = $this->db->get('tratamientos');

		return $consulta->num_rows() > 0;
	}

	private function existe_metodo($nombre, $id_tratamiento) {
		$this->db->where('tratamiento', $id_tratamiento);

		$consulta = $this->db->get($nombre);

		return $consulta->num_rows() > 0;
	}

	private function existe_dosis_droga($droga, $id_tratamiento) {
		$this->db->where('tratamiento', $id_tratamiento);
		$this->db->where('droga', $droga);

		$consulta = $this->db->get('dosis_drogas');

		return $consulta->num_rows() > 0;
	}

	public function obtener_datos_tratamiento($intervencion) {
		$this->db->where('intervencion', $intervencion);
		$resultado = $this->db->get('tratamientos');

		if($resultado->num_rows() === 0)
			return FALSE;

		$datos_tratamiento['fecha']              = $resultado->row()->fecha;
		$datos_tratamiento['no_tratado']         = $resultado->row()->no_tratado;
		$datos_tratamiento['medidas']            = $this->obtener_datos_metodo($intervencion, 'medidas_antropometricas');
		$datos_tratamiento['tratamiento_previo'] = $this->obtener_datos_metodo($intervencion, 'tratamientos_previos');
		$datos_tratamiento['mebendazol']         = $this->obtener_datos_dosis($intervencion, 'MEBENDAZOL');
		$datos_tratamiento['albendazol']         = $this->obtener_datos_dosis($intervencion, 'ALBENDAZOL');
		$datos_tratamiento['ivermectina']        = $this->obtener_datos_dosis($intervencion, 'IVERMECTINA');

		return $datos_tratamiento;
	}

	public function obtener_datos_metodo($tratamiento, $metodo) {
		$this->db->where('tratamiento', $tratamiento);
		$resultado = $this->db->get($metodo);

		return $resultado->num_rows() > 0 ? $resultado->row_array() : FALSE;
	}

	private function obtener_datos_dosis($tratamiento, $droga) {
		$this->db->where('tratamiento', $tratamiento);
		$this->db->where('droga', $droga);
		$resultado = $this->db->get('dosis_drogas');

		return $resultado->num_rows() > 0 ? $resultado->row_array() : FALSE;
	}

	public function eliminar($intervencion) {
		$this->eliminar_metodo($intervencion, 'medidas_antropometricas');
		$this->eliminar_metodo($intervencion, 'tratamientos_previos');
		$this->eliminar_dosis_drogas($intervencion, 'ALBENDAZOL');
		$this->eliminar_dosis_drogas($intervencion, 'MEBENDAZOL');
		$this->eliminar_dosis_drogas($intervencion, 'IVERMECTINA');

		$this->db->where('intervencion', $intervencion);

		return $this->db->delete('tratamientos');
	}

	private function eliminar_metodo($tratamiento, $metodo) {
		$this->db->where('tratamiento', $tratamiento);

		return $this->db->delete($metodo);
	}

	private function eliminar_dosis_drogas($tratamiento, $droga) {
		$this->db->where('tratamiento', $tratamiento);
		$this->db->where('droga', $droga);

		return $this->db->delete('dosis_drogas');
	}
}