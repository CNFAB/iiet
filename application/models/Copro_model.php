<?php

class Copro_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('intervencion_model');
		$this->load->model('campania_model');
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

		$datos_copro = array(
			'intervencion' => $id_interv,
			'fecha'        => $datos['fecha'],
			'peso_materia' => $datos['peso_materia'],
			'consistencia' => $datos['consistencia'],
			'nro_muestra'  => $datos['nro_muestra'] ? $datos['nro_muestra'] : NULL,
			'seriado'      => $datos['seriado'] ? $datos['seriado'] : NULL
		);

		if($this->existe_copro($id_interv)) {
			$this->db->where('intervencion', $id_interv);
			$this->db->update('coproparasitologico', $datos_copro);
		}

		else
			$this->db->insert('coproparasitologico', $datos_copro);

		$datos_concentrado = isset($datos['concentrado']) ? $datos['concentrado'] : false;
		$datos_mcmaster    = isset($datos['mc_master'])   ? $datos['mc_master']   : false;
		$datos_katokatz    = isset($datos['kato_katz'])   ? $datos['kato_katz']   : false;
		$datos_haradamori  = isset($datos['harada_mori']) ? $datos['harada_mori'] : false;
		$datos_baerman     = isset($datos['baerman'])     ? $datos['baerman']     : false;
		$datos_placaagar   = isset($datos['placa_agar'])  ? $datos['placa_agar']  : false;

		$datos_cantidad    = isset($datos['concentrado_cantidad']) ? $datos['concentrado_cantidad'] : false;

		$this->cargar_concentrado($id_interv, $datos_concentrado);
		$this->cargar_mc_master($id_interv, $datos_mcmaster);
		$this->cargar_kato_katz($id_interv, $datos_katokatz);
		$this->cargar_harada_mori($id_interv, $datos_haradamori);
		$this->cargar_baerman($id_interv, $datos_baerman);
		$this->cargar_placa_agar($id_interv, $datos_placaagar);

		$this->cargar_concentrado_cantidad($id_interv, $datos_cantidad);
		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();

			return FALSE;
		}

		else {
			$this->db->trans_commit();

			return $id_interv;
		}
	}

	private function cargar_concentrado($id_copro, $datos) {
		$ya_existe = $this->existe_metodo('concentrado', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('concentrado');
		}

		elseif($datos !== false) {
			$datos_concentrado = array(
				'copro'         => $id_copro,
				'ascaris'       => isset($datos['ascaris'])       ? 'POSITIVO' : 'NEGATIVO',
				'giardia'       => isset($datos['giardia'])       ? 'POSITIVO' : 'NEGATIVO',
				'entamoebacoli' => isset($datos['entamoebacoli']) ? 'POSITIVO' : 'NEGATIVO',
				'uncinarias'    => isset($datos['uncinarias'])    ? 'POSITIVO' : 'NEGATIVO',
				'strongyloides' => isset($datos['strongyloides']) ? 'POSITIVO' : 'NEGATIVO',
				'hymenolepis'   => isset($datos['hymenolepis'])   ? 'POSITIVO' : 'NEGATIVO',
				'trichuris'     => isset($datos['trichuris'])     ? 'POSITIVO' : 'NEGATIVO',
				'enterobius'    => isset($datos['enterobius'])    ? 'POSITIVO' : 'NEGATIVO',
				'taenia'        => isset($datos['taenia'])        ? 'POSITIVO' : 'NEGATIVO',
				'isosporabelli' => isset($datos['isosporabelli']) ? 'POSITIVO' : 'NEGATIVO'
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('concentrado', $datos_concentrado);
			}

			else
				$this->db->insert('concentrado', $datos_concentrado);
		}
	}

	private function cargar_mc_master($id_copro, $datos) {
		$ya_existe = $this->existe_metodo('mc_master', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('mc_master');
		}

		elseif($datos !== false) {
			$datos_mc_master = array(
				'copro'         => $id_copro,
				'ascaris'       => $datos['ascaris'],
				'uncinarias'    => $datos['uncinarias'],
				'hymenolepis'   => $datos['hymenolepis'],
				'trichuris'     => $datos['trichuris'],
				'enterobius'    => $datos['enterobius'],
				'taenia'        => $datos['taenia'],
				'isosporabelli' => isset($datos['isosporabelli']) ? $datos['isosporabelli'] : 0   
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('mc_master', $datos_mc_master);
			}

			else
				$this->db->insert('mc_master', $datos_mc_master);
		}
	}

	/**
	 * Cargar/Actualizar cantidad del concentrado (ESCASO/FRECUENTE/ABUNDANTE)
	 * @param int $id_copro - ID del coproparasitologico
	 * @param array|false $datos - Datos de cantidad o false si no hay
	 */
	private function cargar_concentrado_cantidad($id_copro, $datos) {
		$ya_existe = $this->existe_metodo('concentrado_cantidad', $id_copro);

		// Si no hay datos y ya existe, eliminar
		if (!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('concentrado_cantidad');
			return;
		}

		// Si hay datos, guardar o actualizar
		if ($datos !== false && !empty($datos)) {
			$datos_cantidad = array(
				'copro' => $id_copro,
				'ascaris' => isset($datos['ascaris']) && !empty($datos['ascaris']) ? $datos['ascaris'] : null,
				'giardia' => isset($datos['giardia']) && !empty($datos['giardia']) ? $datos['giardia'] : null,
				'entamoebacoli' => isset($datos['entamoebacoli']) && !empty($datos['entamoebacoli']) ? $datos['entamoebacoli'] : null,
				'uncinarias' => isset($datos['uncinarias']) && !empty($datos['uncinarias']) ? $datos['uncinarias'] : null,
				'strongyloides' => isset($datos['strongyloides']) && !empty($datos['strongyloides']) ? $datos['strongyloides'] : null,
				'hymenolepis' => isset($datos['hymenolepis']) && !empty($datos['hymenolepis']) ? $datos['hymenolepis'] : null,
				'trichuris' => isset($datos['trichuris']) && !empty($datos['trichuris']) ? $datos['trichuris'] : null,
				'enterobius' => isset($datos['enterobius']) && !empty($datos['enterobius']) ? $datos['enterobius'] : null,
				'taenia' => isset($datos['taenia']) && !empty($datos['taenia']) ? $datos['taenia'] : null,
				'isosporabelli' => isset($datos['isosporabelli']) && !empty($datos['isosporabelli']) ? $datos['isosporabelli'] : null
			);

			if ($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('concentrado_cantidad', $datos_cantidad);
			} else {
				$this->db->insert('concentrado_cantidad', $datos_cantidad);
			}
		}
	}

	private function cargar_kato_katz($id_copro, $datos) {
		$ya_existe = $this->existe_metodo('kato_katz', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('kato_katz');
		}

		elseif($datos !== false) {
			$datos_kato_katz = array(
				'copro'         => $id_copro,
				'ascaris'       => $datos['ascaris'],
				'uncinarias'    => $datos['uncinarias'],
				'hymenolepis'   => $datos['hymenolepis'],
				'trichuris'     => $datos['trichuris'],
				'enterobius'    => $datos['enterobius'],
				'taenia'        => $datos['taenia'],
				'isosporabelli' => isset($datos['isosporabelli']) ? $datos['isosporabelli'] : 0 
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('kato_katz', $datos_kato_katz);
			}

			else
				$this->db->insert('kato_katz', $datos_kato_katz);
		}
	}

	private function cargar_harada_mori($id_copro, $datos)	{
		$ya_existe = $this->existe_metodo('harada_mori', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('harada_mori');
		}

		elseif($datos !== false) {
			$datos_harada_mori = array(
				'copro'         => $id_copro,
				'strongyloides' => $datos['strongyloides'],
				'ancylostoma'   => $datos['ancylostoma'],
				'necator'       => $datos['necator'],
				'enterobius'    => $datos['enterobius']
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('harada_mori', $datos_harada_mori);
			}

			else
				$this->db->insert('harada_mori', $datos_harada_mori);
		}
	}

		private function cargar_baerman($id_copro, $datos)	{
		$ya_existe = $this->existe_metodo('baerman', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('baerman');
		}

		elseif($datos !== false) {
			$datos_baerman = array(
				'copro'         => $id_copro,
				'strongyloides' => $datos['strongyloides'],
				'ancylostoma'   => isset($datos['ancylostoma']) ? $datos['ancylostoma'] : 'NEGATIVO',
				'necator'       => isset($datos['necator'])     ? $datos['necator']     : 'NEGATIVO',
				'uncinarias'    => isset($datos['uncinarias'])  ? $datos['uncinarias']  : 'NEGATIVO'
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('baerman', $datos_baerman);
			}

			else
				$this->db->insert('baerman', $datos_baerman);
		}
	}

	private function cargar_placa_agar($id_copro, $datos) {
		$ya_existe = $this->existe_metodo('placa_agar', $id_copro);

		if(!$datos && $ya_existe) {
			$this->db->where('copro', $id_copro);
			$this->db->delete('placa_agar');
		}

		elseif($datos !== false) {
			$datos_placa_agar = array(
				'copro'         => $id_copro,
				'strongyloides' => $datos['strongyloides'],
				'ancylostoma'   => $datos['ancylostoma'],
				'necator'       => $datos['necator']
			);

			if($ya_existe) {
				$this->db->where('copro', $id_copro);
				$this->db->update('placa_agar', $datos_placa_agar);
			}

			else
				$this->db->insert('placa_agar', $datos_placa_agar);
		}
	}

	public function copro($intervencion) {
		$this->db->where('intervencion', $intervencion);

		$r_copro = $this->db->get('v_copro');
	}

	private function existe_copro($id_interv) {
		$this->db->where('intervencion', $id_interv);

		$consulta = $this->db->get('coproparasitologico');

		return $consulta->num_rows() > 0;
	}

	private function existe_metodo($nombre, $id_copro) {
		$this->db->where('copro', $id_copro);

		$consulta = $this->db->get($nombre);

		return $consulta->num_rows() > 0;
	}

	public function obtener_datos_copro($intervencion) {
		$this->db->where('intervencion', $intervencion);
		$resultado = $this->db->get('coproparasitologico');

		if($resultado->num_rows() === 0)
			return FALSE;

		$copro = $resultado->row();

		$datos_copro['fecha']        = $copro->fecha;
		$datos_copro['peso_materia'] = $copro->peso_materia;
		$datos_copro['consistencia'] = $copro->consistencia;
		$datos_copro['nro_muestra']  = $copro->nro_muestra;
		$datos_copro['seriado']      = $copro->seriado;
		$datos_copro['concentrado']  = $this->obtener_datos_metodo($intervencion, 'concentrado');
		$datos_copro['mc_master']    = $this->obtener_datos_metodo($intervencion, 'mc_master');
		$datos_copro['kato_katz']    = $this->obtener_datos_metodo($intervencion, 'kato_katz');
		$datos_copro['harada_mori']  = $this->obtener_datos_metodo($intervencion, 'harada_mori');
		$datos_copro['baerman']      = $this->obtener_datos_metodo($intervencion, 'baerman');
		$datos_copro['placa_agar']   = $this->obtener_datos_metodo($intervencion, 'placa_agar');

		$datos_copro['concentrado_cantidad'] = $this->obtener_datos_metodo($intervencion, 'concentrado_cantidad');
		
		//$datos_copro['concentrado_cantidad'] = $this->obtener_datos_metodo($intervencion, 'concentrado_cantidad');
		 if ($datos_copro['concentrado_cantidad'] === FALSE) {
        $datos_copro['concentrado_cantidad'] = [];
        error_log("concentrado_cantidad: vacío (no hay datos)");
    } else {
        error_log("concentrado_cantidad: " . print_r($datos_copro['concentrado_cantidad'], true));
    }
		return $datos_copro;
	}

	public function obtener_datos_metodo($copro, $metodo) {
		$this->db->where('copro', $copro);
		$resultado = $this->db->get($metodo);

		return $resultado->num_rows() > 0 ? $resultado->row_array() : FALSE;
	}

	public function eliminar($intervencion) {
		$this->eliminar_metodo($intervencion, 'concentrado');
		$this->eliminar_metodo($intervencion, 'concentrado_cantidad');
		$this->eliminar_metodo($intervencion, 'mc_master');
		$this->eliminar_metodo($intervencion, 'kato_katz');
		$this->eliminar_metodo($intervencion, 'harada_mori');
		$this->eliminar_metodo($intervencion, 'baerman');
		$this->eliminar_metodo($intervencion, 'placa_agar');

		$this->db->where('intervencion', $intervencion);

		return $this->db->delete('coproparasitologico');
	}

	private function eliminar_metodo($copro, $metodo) {
		$this->db->where('copro', $copro);

		return $this->db->delete($metodo);
	}

	public function lista_resultados($campania, $e_i = NULL, $e_f = NULL, $sexo = NULL) {
		if($e_i == NULL)
			$e_i = 0;

		if($e_f == NULL)
			$e_f = 100000;

		$this->db->select('
			P.numero AS paciente,
			P.sexo,
			trunc((fecha_inicio - fecha_nacimiento)::decimal / 365, 0) AS edad,
			CP.*
		');
		$this->db->from('v_campanias C');
		$this->db->join('v_intervenciones I', 'C.numero = I.campania');
		$this->db->join('v_pacientes P', 'I.paciente = P.numero');
		$this->db->join('v_copro CP', 'I.numero = CP.intervencion');
		$this->db->where('C.numero', $campania);
		$this->db->where('trunc((fecha_inicio - fecha_nacimiento)::decimal / 365, 0) >=', $e_i);
		$this->db->where('trunc((fecha_inicio - fecha_nacimiento)::decimal / 365, 0) <', $e_f);

		if($sexo != NULL)
			$this->db->where('sexo', $sexo);

		$this->db->order_by('P.numero', 'ASC');

		$resultado = $this->db->get()->result();

		$lista = [];

		foreach($resultado as $fila) {
			$paciente = [];

			$paciente['paciente']      = $fila->paciente;
			$paciente['sexo']          = $fila->sexo;
			$paciente['edad']          = $fila->edad;
			$paciente['ascaris']       = $this->resultado_ascaris($fila);
			$paciente['necator']       = $this->resultado_necator($fila);
			$paciente['ancylostoma']   = $this->resultado_ancylostoma($fila);
			$paciente['uncinarias']    = $this->resultado_uncinarias($fila, $paciente['necator'], $paciente['ancylostoma']);
			$paciente['strongyloides'] = $this->resultado_strongyloides($fila);
			$paciente['trichuris']     = $this->resultado_trichuris($fila);
			$paciente['geohelmintos']  = $this->resultado_geohelmintos($paciente);

			$lista[] = $paciente;
		}

		return $lista;
	}

	private function resultado_ascaris($reg) {
		$cc = $this->resultado_es($reg->conc_ascaris);
		$bm = $this->resultado_es($reg->mm_ascaris);

		if($cc === 'POSITIVO' || $bm === 'POSITIVO')
			return 'POSITIVO';

		elseif($cc === 'NEGATIVO' || $bm === 'NEGATIVO')
			return 'NEGATIVO';

		else
			return 'NO REALIZADO';
	}

	private function resultado_uncinarias($reg, $necator, $ancylostoma) {
		$cc = $this->resultado_es($reg->conc_uncinarias);
		$bm = $this->resultado_es($reg->mm_uncinarias);

		if($cc === 'POSITIVO' || $bm === 'POSITIVO' || $necator === 'POSITIVO' || $ancylostoma === 'POSITIVO')
			return 'POSITIVO';

		elseif($cc === 'NEGATIVO' || $bm === 'NEGATIVO' || $necator === 'NEGATIVO' || $ancylostoma === 'NEGATIVO')
			return 'NEGATIVO';

		else
			return 'NO REALIZADO';
	}

	private function resultado_necator($reg) {
		$hm = $this->resultado_es($reg->hm_necator);
		$bm = $this->resultado_es($reg->bm_necator);
		$pa = $this->resultado_es($reg->pa_necator);

		if($hm === 'POSITIVO' || $bm === 'POSITIVO' || $pa === 'POSITIVO')
			return 'POSITIVO';

		elseif($hm === 'NEGATIVO' || $bm === 'NEGATIVO' || $pa === 'NEGATIVO')
			return 'NEGATIVO';

		else
			return 'NO REALIZADO';
	}

	private function resultado_ancylostoma($reg) {
		/*if($reg->hm_ancylostoma === 'POSITIVO' || $reg->bm_ancylostoma === 'POSITIVO' || $reg->pa_ancylostoma === 'POSITIVO')
			return 'POSITIVO';
		
		elseif($reg->hm_ancylostoma === 'NEGATIVO' || $reg->bm_ancylostoma === 'NEGATIVO' || $reg->pa_ancylostoma === 'NEGATIVO')
			return 'NEGATIVO';

		else
			return 'NO REALIZADO';*/


		$hm = $this->resultado_es($reg->hm_ancylostoma);
		$bm = $this->resultado_es($reg->bm_ancylostoma);
		$pa = $this->resultado_es($reg->pa_ancylostoma);

		if($hm === 'POSITIVO' || $bm === 'POSITIVO' || $pa === 'POSITIVO')
			return 'POSITIVO';

		elseif($hm === 'NEGATIVO' || $bm === 'NEGATIVO' || $pa === 'NEGATIVO')
			return 'NEGATIVO';

		else
			return 'NO REALIZADO';
	}

	private function resultado_strongyloides($reg) {
		/*if($reg->conc_strongyloides === 'POSITIVO' || $reg->hm_strongyloides === 'POSITIVO' || $reg->bm_strongyloides === 'POSITIVO' || $reg->pa_strongyloides === 'POSITIVO')
			return 'POSITIVO';
		
		elseif($reg->conc_strongyloides === 'NEGATIVO' || $reg->hm_strongyloides === 'NEGATIVO' || $reg->bm_strongyloides === 'NEGATIVO' || $reg->pa_strongyloides === 'NEGATIVO')
			return 'NEGATIVO';

		else
			return 'NO REALIZADO';*/

		$cc = $this->resultado_es($reg->conc_strongyloides);
		$hm = $this->resultado_es($reg->hm_strongyloides);
		$bm = $this->resultado_es($reg->bm_strongyloides);
		$pa = $this->resultado_es($reg->pa_strongyloides);

		if($cc === 'POSITIVO' || $hm === 'POSITIVO' || $bm === 'POSITIVO' || $pa === 'POSITIVO')
			return 'POSITIVO';

		elseif($cc === 'NEGATIVO' || $hm === 'NEGATIVO' || $bm === 'NEGATIVO' || $pa === 'NEGATIVO')
			return 'NEGATIVO';

		else
			return 'NO REALIZADO';
	}

	private function resultado_trichuris($reg) {
		$cc = $this->resultado_es($reg->conc_trichuris);
		$bm = $this->resultado_es($reg->mm_trichuris);

		if($cc === 'POSITIVO' || $bm === 'POSITIVO')
			return 'POSITIVO';

		elseif($cc === 'NEGATIVO' || $bm === 'NEGATIVO')
			return 'NEGATIVO';

		else
			return 'NO REALIZADO';
	}

	private function resultado_geohelmintos($pac) {
		if(
			$pac['ascaris']       == 'POSITIVO' ||
			$pac['uncinarias']    == 'POSITIVO' ||
			$pac['necator']       == 'POSITIVO' ||
			$pac['ancylostoma']   == 'POSITIVO' ||
			$pac['strongyloides'] == 'POSITIVO' ||
			$pac['trichuris']     == 'POSITIVO'
		) return 'POSITIVO';

		elseif(
			$pac['ascaris']       == 'NEGATIVO' ||
			$pac['uncinarias']    == 'NEGATIVO' ||
			$pac['necator']       == 'NEGATIVO' ||
			$pac['ancylostoma']   == 'NEGATIVO' ||
			$pac['strongyloides'] == 'NEGATIVO' ||
			$pac['trichuris']     == 'NEGATIVO'
		) return 'NEGATIVO';

		else
			return 'NO REALIZADO';
	}

	public function tabla_prevalencia($campania, $opciones) {
		$f_0a5    = $this->lista_resultados($campania, 0, 5, 'FEMENINO');
		$f_5a15   = $this->lista_resultados($campania, 5, 15, 'FEMENINO');
		$f_15a45  = $this->lista_resultados($campania, 15, 45, 'FEMENINO');
		$f_45a100 = $this->lista_resultados($campania, 45, 100, 'FEMENINO');
		$f_indeterm = $this->lista_resultados($campania, 100, NULL, 'FEMENINO');

		$m_0a5    = $this->lista_resultados($campania, 0, 5, 'MASCULINO');
		$m_5a15   = $this->lista_resultados($campania, 5, 15, 'MASCULINO');
		$m_15a45  = $this->lista_resultados($campania, 15, 45, 'MASCULINO');
		$m_45a100 = $this->lista_resultados($campania, 45, 100, 'MASCULINO');
		$m_indeterm = $this->lista_resultados($campania, 100, NULL, 'MASCULINO');


		$femenino  = [];
		$masculino = [];
		$todos     = [];

		$femenino['0a5'] = [];
		$femenino['0a5']['total'] = count($f_0a5);
		$femenino['0a5']['positivos'] = $this->contar_positivos($f_0a5, $opciones);

		$femenino['5a15'] = [];
		$femenino['5a15']['total'] = count($f_5a15);
		$femenino['5a15']['positivos'] = $this->contar_positivos($f_5a15, $opciones);

		$femenino['15a45'] = [];
		$femenino['15a45']['total'] = count($f_15a45);
		$femenino['15a45']['positivos'] = $this->contar_positivos($f_15a45, $opciones);

		$femenino['45a100'] = [];
		$femenino['45a100']['total'] = count($f_45a100);
		$femenino['45a100']['positivos'] = $this->contar_positivos($f_45a100, $opciones);

		$femenino['indeterm'] = [];
		$femenino['indeterm']['total'] = count($f_indeterm);
		$femenino['indeterm']['positivos'] = $this->contar_positivos($f_indeterm, $opciones);

		$femenino['total'] = [];
		$femenino['total']['total'] = $femenino['0a5']['total'] + $femenino['5a15']['total'] + $femenino['15a45']['total']
										+ $femenino['45a100']['total'] + $femenino['indeterm']['total'];
		$femenino['total']['positivos'] = $femenino['0a5']['positivos'] + $femenino['5a15']['positivos'] + $femenino['15a45']['positivos']
											+ $femenino['45a100']['positivos'] + $femenino['indeterm']['positivos'];


		$masculino['0a5'] = [];
		$masculino['0a5']['total'] = count($m_0a5);
		$masculino['0a5']['positivos'] = $this->contar_positivos($m_0a5, $opciones);

		$masculino['5a15'] = [];
		$masculino['5a15']['total'] = count($m_5a15);
		$masculino['5a15']['positivos'] = $this->contar_positivos($m_5a15, $opciones);

		$masculino['15a45'] = [];
		$masculino['15a45']['total'] = count($m_15a45);
		$masculino['15a45']['positivos'] = $this->contar_positivos($m_15a45, $opciones);

		$masculino['45a100'] = [];
		$masculino['45a100']['total'] = count($m_45a100);
		$masculino['45a100']['positivos'] = $this->contar_positivos($m_45a100, $opciones);

		$masculino['indeterm'] = [];
		$masculino['indeterm']['total'] = count($m_indeterm);
		$masculino['indeterm']['positivos'] = $this->contar_positivos($m_indeterm, $opciones);

		$masculino['total'] = [];
		$masculino['total']['total'] = $masculino['0a5']['total'] + $masculino['5a15']['total'] + $masculino['15a45']['total']
										+ $masculino['45a100']['total'] + $masculino['indeterm']['total'];
		$masculino['total']['positivos'] = $masculino['0a5']['positivos'] + $masculino['5a15']['positivos'] + $masculino['15a45']['positivos']
											+ $masculino['45a100']['positivos'] + $masculino['indeterm']['positivos'];


		$total['0a5'] = [];
		$total['0a5']['total'] = $femenino['0a5']['total'] + $masculino['0a5']['total'];
		$total['0a5']['positivos'] = $femenino['0a5']['positivos'] + $masculino['0a5']['positivos'];

		$total['5a15'] = [];
		$total['5a15']['total'] = $femenino['5a15']['total'] + $masculino['5a15']['total'];
		$total['5a15']['positivos'] = $femenino['5a15']['positivos'] + $masculino['5a15']['positivos'];

		$total['15a45'] = [];
		$total['15a45']['total'] = $femenino['15a45']['total'] + $masculino['15a45']['total'];
		$total['15a45']['positivos'] = $femenino['15a45']['positivos'] + $masculino['15a45']['positivos'];

		$total['45a100'] = [];
		$total['45a100']['total'] = $femenino['45a100']['total'] + $masculino['45a100']['total'];
		$total['45a100']['positivos'] = $femenino['45a100']['positivos'] + $masculino['45a100']['positivos'];

		$total['indeterm'] = [];
		$total['indeterm']['total'] = $femenino['indeterm']['total'] + $masculino['indeterm']['total'];
		$total['indeterm']['positivos'] = $femenino['indeterm']['positivos'] + $masculino['indeterm']['positivos'];

		$total['total'] = [];
		$total['total']['total'] = $total['0a5']['total'] + $total['5a15']['total'] + $total['15a45']['total']
										+ $total['45a100']['total'] + $total['indeterm']['total'];
		$total['total']['positivos'] = $total['0a5']['positivos'] + $total['5a15']['positivos'] + $total['15a45']['positivos']
											+ $total['45a100']['positivos'] + $total['indeterm']['positivos'];


		return array('femenino' => $femenino, 'masculino' => $masculino, 'total' => $total);
	}

	private function contar_positivos($estudios, $ghelmintos) {
		$c = 0;

		foreach($estudios as $estudio)
			foreach($ghelmintos as $geoh)
				if($estudio[$geoh] == 'POSITIVO') {
					++$c;
					break;
				}

		return $c;
	}

	public function tabla_contingencia($campania, $helminto, $metodo_1, $metodo_2) {
		$pp = $this->fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, 'POSITIVO', 'POSITIVO');
		$pn = $this->fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, 'POSITIVO', 'NEGATIVO');
		$px = $this->fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, 'POSITIVO', NULL);
		
		$np = $this->fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, 'NEGATIVO', 'POSITIVO');
		$nn = $this->fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, 'NEGATIVO', 'NEGATIVO');
		$nx = $this->fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, 'NEGATIVO', NULL);

		$xp = $this->fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, NULL, 'POSITIVO');
		$xn = $this->fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, NULL, 'NEGATIVO');
		$xx = $this->fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, NULL, NULL);

		return array(
			'pp' => $pp,
			'pn' => $pn,
			'px' => $px,
			'pt' => $pp + $pn + $px,

			'np' => $np,
			'nn' => $nn,
			'nx' => $nx,
			'nt' => $np + $nn + $nx,

			'xp' => $xp,
			'xn' => $xn,
			'xx' => $xx,
			'xt' => $xp + $xn + $xx,

			'tp' => $pp + $np + $xp,
			'tn' => $pn + $nn + $xn,
			'tx' => $px + $nx + $xx,
			'tt' => $pp + $pn + $px + $np + $nn + $nx + $xp + $xn + $xx
		);
	}

	public function fc_contingencia($campania, $helminto, $metodo_1, $metodo_2, $result_1, $result_2) {
		$this->db->select('I.*');
		$this->db->from('v_intervenciones I');
		$this->db->join('v_copro C', 'I.numero = C.intervencion');
		$this->cond_helminto($helminto, $metodo_1, $result_1);
		$this->cond_helminto($helminto, $metodo_2, $result_2);
		$this->db->where('I.campania', $campania);

		return $this->db->get()->num_rows();
	}

	private function cond_helminto($helminto, $metodo, $result) {
		if($result === NULL)
			$this->db->where($metodo.'_'.$helminto, $result);
		
		else
			switch($metodo) {
				case 'conc':
					$this->db->where($metodo.'_'.$helminto, $result);
				break;

				case 'mm':
					$this->db->where($metodo.'_'.$helminto.($result === 'POSITIVO' ? '> 0' : '= 0'));
				break;

				case 'hm':
				case 'bm':
				case 'pa':
					if($result === 'POSITIVO') {
						$this->db->group_start();
						$this->db->where($metodo.'_'.$helminto, '+');
						$this->db->or_where($metodo.'_'.$helminto, '++');
						$this->db->or_where($metodo.'_'.$helminto, '+++');
						$this->db->group_end();
					}

					else
						$this->db->where($metodo.'_'.$helminto, 'NEGATIVO');
				break;
			}
	}

	private function resultado_es($helminto) {
		if($helminto === 'POSITIVO' || $helminto === '+' || $helminto === '++' || $helminto === '+++')
			return 'POSITIVO';
		
		elseif($helminto === 'NEGATIVO')
			return 'NEGATIVO';

		elseif($helminto === NULL)
			return 'NO REALIZADO';

		elseif($helminto > 0)
			return 'POSITIVO';

		else
			return 'NEGATIVO';
	}

	public function total_ascaris($campania) {
		$this->db->from('intervenciones_geohelmintos I');
		$this->db->join('intervenciones_campanias IC', 'I.numero = IC.intervencion');
		$this->db->join('concentrado CC', 'I.numero = CC.copro', 'LEFT');
		$this->db->join('mc_master MM', 'I.numero = MM.copro', 'LEFT');
		$this->db->where('IC.campania', $campania);
		$this->db->group_start();
		$this->db->where('CC.ascaris', 'POSITIVO');
		$this->db->or_where('MM.ascaris > 0');
		$this->db->group_end();

		return $this->db->get()->num_rows();
	}

	public function total_strongyloides($campania) {
		$this->db->from('intervenciones_geohelmintos I');
		$this->db->join('intervenciones_campanias IC', 'I.numero = IC.intervencion');
		$this->db->join('concentrado CC', 'I.numero = CC.copro', 'LEFT');
		$this->db->join('harada_mori HM', 'I.numero = HM.copro', 'LEFT');
		$this->db->join('baerman BM', 'I.numero = BM.copro', 'LEFT');
		$this->db->join('placa_agar PA', 'I.numero = PA.copro', 'LEFT');
		$this->db->where('IC.campania', $campania);
		$this->db->group_start();
		$this->db->where('CC.strongyloides', 'POSITIVO');
		$this->db->or_where('HM.strongyloides <> \'NEGATIVO\'');
		$this->db->or_where('BM.strongyloides <> \'NEGATIVO\'');
		$this->db->or_where('PA.strongyloides <> \'NEGATIVO\'');
		$this->db->group_end();

		return $this->db->get()->num_rows();
	}

	public function total_uncinarias($campania) {
		$this->db->from('intervenciones_geohelmintos I');
		$this->db->join('intervenciones_campanias IC', 'I.numero = IC.intervencion');
		$this->db->join('concentrado CC', 'I.numero = CC.copro', 'LEFT');
		$this->db->join('mc_master MM', 'I.numero = MM.copro', 'LEFT');
		$this->db->join('harada_mori HM', 'I.numero = HM.copro', 'LEFT');
		$this->db->join('baerman BM', 'I.numero = BM.copro', 'LEFT');
		$this->db->join('placa_agar PA', 'I.numero = PA.copro', 'LEFT');
		$this->db->where('IC.campania', $campania);
		$this->db->group_start();
		$this->db->where('CC.uncinarias', 'POSITIVO');
		$this->db->or_where('MM.uncinarias > 0');
		$this->db->or_where('HM.ancylostoma <> \'NEGATIVO\'');
		$this->db->or_where('HM.necator <> \'NEGATIVO\'');
		$this->db->or_where('BM.ancylostoma <> \'NEGATIVO\'');
		$this->db->or_where('BM.necator <> \'NEGATIVO\'');
		$this->db->or_where('PA.ancylostoma <> \'NEGATIVO\'');
		$this->db->or_where('PA.necator <> \'NEGATIVO\'');
		$this->db->group_end();

		return $this->db->get()->num_rows();
	}

	public function total_trichuris($campania) {
		$this->db->from('intervenciones_geohelmintos I');
		$this->db->join('intervenciones_campanias IC', 'I.numero = IC.intervencion');
		$this->db->join('concentrado CC', 'I.numero = CC.copro', 'LEFT');
		$this->db->join('mc_master MM', 'I.numero = MM.copro', 'LEFT');
		$this->db->where('IC.campania', $campania);
		$this->db->group_start();
		$this->db->where('CC.trichuris', 'POSITIVO');
		$this->db->or_where('MM.trichuris > 0');
		$this->db->group_end();

		return $this->db->get()->num_rows();
	}
}