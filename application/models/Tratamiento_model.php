<?php

class Tratamiento_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	public function nuevo($datos) {
		$this->db->trans_begin();

		$datos_tratamiento = array(
			'intervencion' => $datos['intervencion'],
			'fecha'        => $datos['fecha'],
			'exclusion'    => $datos['exclusion']
		);

		$this->db->insert('tratamientos', $datos_tratamiento);
		
		if(isset($datos['tratamiento_previo'])) {
			$datos['tratamiento_previo']['tratamiento_actual'] = $datos['intervencion'];

			$this->cargar_tratamiento_previo($datos['tratamientos_previo']);
		}

		if(isset($datos['dosis_drogas'])) {
			$datos['dosis_drogas']['tratamiento'] = $datos['intervencion'];

			$this->cargar_tratamiento_previo($datos['dosis_drogas']);
		}

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $datos['intervencion'];
		}

	}

	private function cargar_tratamiento_previo($datos) {
		$datos_trat_prev = array(
			numero             => $datos['numero'],
			tratamiento_actual => $datos['tratamiento_actual'],
			fecha              => $datos['fecha'],
			mebendazol         => $datos['mebendazol'] 	 ? $datos['mebendazol']   : FALSE,
			albendazol         => $datos['albendazol'] 	 ? $datos['albendazol']   : FALSE,
			ivermectina        => $datos['ivermectina']  ? $datos['ivermectina']  : FALSE,
			metronidazol       => $datos['metronidazol'] ? $datos['metronidazol'] : FALSE,
			otras              => $datos['otras']
		);

		$this->db->insert('tratamientos_previo', $datos_trat_prev);
	}

	private function cargar_dosis($datos) {
		$datos_dosis = array(
			'tratamiento' => $datos['tratamiento'],
			'droga'       => $datos['droga'],
			'dosis'       => $datos['dosis']
		);

		$this->db->insert('dosis_drogas', $datos_dosis);
	}

	public function nuevas_medidas_antropometricas($datos) {
		$datos_medidas = array(
			'intervencion'       => $datos['intervencion'],
			'fecha'              => $datos['fecha'] 			 ? $datos['fecha'] 				: NULL,
			'peso'               => $datos['peso'] 				 ? $datos['peso'] 				: NULL,
			'talla'              => $datos['talla'] 			 ? $datos['talla'] 				: NULL,
			'perimetro_cefalico' => $datos['perimetro_cefalico'] ? $datos['perimetro_cefalico'] : NULL
		);

		$estado = $this->db->insert('medidas_antropometricas', $datos_medidas);

		if($estado === FALSE)
			return FALSE;

		else
			return $datos['intervencion'];
	}
}