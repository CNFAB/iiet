<?php

class Tratamiento_model extends CI_Model {
	
	function __construct() {
		parent::__construct();

		$this->load->model('intervencion_model');
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$id_interv = $this->intervencion_model->obtener_intervencion($datos['intervencion']);

		$datos_tratamiento = array(
			'intervencion' => $id_interv,
			'fecha'        => $datos['fecha']
		);

		if($this->existe_tratamiento($id_interv)) {
			$this->db->where('intervencion', $id_interv);
			$this->db->update('tratamientos', $datos_tratamiento);
		}

		else
			$this->db->insert('tratamientos', $datos_tratamiento);

		$datos_medidas  = isset($datos['medidas']) ? $datos['medidas'] : false;
		$datos_tratprev = isset($datos['tratamiento_previo']) ? $datos['tratamiento_previo'] : false;

		$this->cargar_medidas($id_interv, $datos_medidas);
		$this->cargar_tratamiento_previo($id_interv, $datos_tratprev);
		$this->cargar_dosis_mebendazol($id_interv, $datos['mebendazol']);
		$this->cargar_dosis_albendazol($id_interv, $datos['albendazol']);
		$this->cargar_dosis_ivermectina($id_interv, $datos['ivermectina']);

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
				'tratamiento_actual' => $id_tratamiento,
				'fecha'              => $datos['fecha'],
				'mebendazol'         => isset($datos['mebendazol'])   ? $datos['mebendazol']   : FALSE,
				'albendazol'         => isset($datos['albendazol'])   ? $datos['albendazol']   : FALSE,
				'ivermectina'        => isset($datos['ivermectina'])  ? $datos['ivermectina']  : FALSE,
				'metronidazol'       => isset($datos['metronidazol']) ? $datos['metronidazol'] : FALSE,
				'otras'              => $datos['otras'] !== '' 		  ? $datos['otras'] 	   : NULL
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
		$datos_dosis = array(
			'tratamiento' => $id_tratamiento,
			'droga'       => 'MEBENDAZOL',
			'dosis'       => isset($datos['dosis']) 	? $datos['dosis'] 	  : NULL,
			'exclusion'   => isset($datos['exclusion']) ? $datos['exclusion'] : NULL
		);

		$this->db->insert('dosis_drogas', $datos_dosis);
	}

	private function cargar_dosis_albendazol($id_tratamiento, $datos) {
		$datos_dosis = array(
			'tratamiento' => $id_tratamiento,
			'droga'       => 'ALBENDAZOL',
			'dosis'       => isset($datos['dosis']) 	? $datos['dosis'] 	  : NULL,
			'exclusion'   => isset($datos['exclusion']) ? $datos['exclusion'] : NULL
		);

		$this->db->insert('dosis_drogas', $datos_dosis);
	}

	private function cargar_dosis_ivermectina($id_tratamiento, $datos) {
		$datos_dosis = array(
			'tratamiento' => $id_tratamiento,
			'droga'       => 'IVERMECTINA',
			'dosis'       => isset($datos['dosis']) 	? $datos['dosis'] 	  : NULL,
			'exclusion'   => isset($datos['exclusion']) ? $datos['exclusion'] : NULL
		);

		$this->db->insert('dosis_drogas', $datos_dosis);
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
}