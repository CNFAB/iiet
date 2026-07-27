<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campanias extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		if ($this->ion_auth->logged_in()) {
			$this->load->model('campania_model');
			$this->load->model('intervencion_model');

			$this->usuario = $this->ion_auth->user()->row();
		}

		else
			$this->load->view('auth/login');
	}

	public function index() {
		$grupos = $this->ion_auth->get_users_groups($this->usuario->id)->result();
		$datos = [];

		foreach($grupos as $grupo)
			$datos[$grupo->name] = TRUE;

		$datos['usuario'] = $this->usuario->last_name.', '.$this->usuario->first_name;
		$datos['cant_rol'] = count($grupos);

		if($datos['cant_rol'] === 1)
			$datos['rol'] = $grupos[0]->description;

		/*$datos_usuario = array(
			'usuario' => $this->usuario->last_name.', '.$this->usuario->first_name,
			'grupos' => array_map(function($g) { return $g->description; }, $consulta)
		);*/

		$this->load->view('campanias2', $datos);
	}

	public function obtener_estudios_paciente($campania, $paciente) {
		$intervencion = $this->campania_model->obtener_intervencion($campania, $paciente);

		if($intervencion) {
			$datos['estudios'] = $this->intervencion_model->obtener_estudios($intervencion);
			$datos['campania'] = $this->campania_model->obtener_datos_campania($campania);
		}

		else
			$datos = false;

		$json = json_encode($datos);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function nueva() {
		$datos = $this->input->post();

		$id = $this->campania_model->cargar($datos);
		$json = json_encode($id);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function actualizar($campania = NULL) {
		$datos = $this->input->post();

		$campania = $campania === NULL ? $datos['numero'] : $campania;

		$id = $this->campania_model->cargar($datos, FALSE, $campania);
		$json = json_encode($id);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_campanias() {
		$datos = $this->input->post();

		$result = $this->campania_model->obtener_lista_campanias($datos);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function datos_campania($campania = NULL) {
		if(!$campania)
			$campania = $this->input->post('campania');

		$datos_campania = $this->campania_model->obtener_datos_campania($campania);
		$json = json_encode($datos_campania);
		
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_intervencion($campania, $paciente) {
		$interv = $this->campania_model->obtener_intervencion($campania, $paciente);

		echo $interv;
	}

	public function listado($offset = 0) {
		$campo = $this->input->post('campo_filtro');
		$valor = $this->input->post('valor_filtro');

		$lista = $this->campania_model->filtrar($campo, $valor, $offset);

		$json = json_encode($lista);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function datos_completos($campania) {
		$campania = $this->campania_model->datos_completos($campania);
		$json = json_encode($campania);
		
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function tiene_intervenciones($campania) {
		$cantidad = $this->campania_model->cantidad_intervenciones($campania);
		$json = json_encode($cantidad > 0);
		
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function eliminar($campania) {
		$estado = $this->campania_model->eliminar($campania);
		$json = json_encode($estado);
		
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function informe($campania) {
		$nombre = $this->campania_model->obtener_nombre($campania);
		$this->load->view('informe', array('campania' => $nombre));
	}

	public function lista_resultados_copro($campania) {
		$this->load->model('copro_model');

		$lista = $this->copro_model->lista_resultados($campania);
		$json = json_encode($lista);
		
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function prevalencia($campania, $geoh = 'geohelmintos') {
		$this->load->model('copro_model');

		$opciones = $this->input->post('opciones');

		$geoh = $opciones != NULL ? $opciones : array($geoh);

		$tabla = $this->copro_model->tabla_prevalencia($campania, $geoh);
		$json = json_encode($tabla);
		
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function tabla_contingencia($campania) {
		$this->load->model('copro_model');

		$helminto = $this->input->post('helminto');
		$metodo_1 = $this->input->post('metodo1');
		$metodo_2 = $this->input->post('metodo2');

		$tabla = $this->copro_model->tabla_contingencia($campania, $helminto, $metodo_1, $metodo_2);
		$json = json_encode($tabla);
		
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	

	public function datos($nro_campania) {
		$datos = $this->campania_model->datos_completos($nro_campania);
		$json = json_encode($datos);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listar() {
		$offset   = $this->input->post('start');
		$num_regs = $this->input->post('length');
		$filtro   = $this->input->post('search')['value'];
		$orden    = $this->input->post('order')[0];
		$ord_col  = $orden['column'];
		$ord_dir  = $orden['dir'];
		$ord_camp = $this->input->post('columns')[$ord_col]['data'];
		$draw     = $this->input->post('draw');

		$c_lista = $this->campania_model->obtener_listado($offset, $num_regs, $filtro, $ord_camp, $ord_dir);
		$c_total = $this->campania_model->obtener_total();
		$c_filt  = $this->campania_model->obtener_total($filtro);

		$json = json_encode(array(
			'data' => $c_lista,
			'recordsTotal' => $c_total,
			'recordsFiltered' => $c_filt,
			'draw' => $draw
		));

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}


	public function eventos() {
		$this->load->view('cargador/inicio_campania');
	}

	public function copro() {
		$form = $this->load->view('cargador/form_estudios/form_copro', null, true);
		$this->load->view('cargador/eventos_campania', array(
			'titulo' => 'Copro',
			'form' => $form,
			'tipo_form' => 'copro'
		));
	}

	public function sangre() {
		$form = $this->load->view('cargador/form_estudios/form_sangre', null, true);
		$this->load->view('cargador/eventos_campania', array(
			'titulo' => 'Sangre',
			'form' => $form,
			'tipo_form' => 'sangre'
		));
	}

	public function biologia_molecular() {
		$form = $this->load->view('cargador/form_estudios/form_biologmolec', null, true);
		$this->load->view('cargador/eventos_campania', array(
			'titulo' => 'Biología M
			lecular', 'form' => $form,
			'tipo_form' => 'biologmolec'
		));
	}

	public function tratamiento() {
		$form = $this->load->view('cargador/form_estudios/form_tratamiento', null, true);
		$this->load->view('cargador/eventos_campania', array(
			'titulo' => 'Tratamiento',
			'form' => $form,
			'tipo_form' => 'tratamiento'
		));
	}

	public function detalle($campania = 0) {
		$this->load->view('detalle_campania');
	}

	public function cantidad_por_sexos($campania) {
		$json = json_encode(array(
			'masculinos' => $this->campania_model->cantidad_masculinos($campania),
			'femeninos' => $this->campania_model->cantidad_femeninos($campania)
		));

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function cantidad_por_helmintos($campania) {
		$this->load->model('copro_model');

		$json = json_encode(array(
			'ascaris'       => $this->copro_model->total_ascaris($campania),
			'uncinarias'    => $this->copro_model->total_uncinarias($campania),
			'strongyloides' => $this->copro_model->total_strongyloides($campania),
			'trichuris'     => $this->copro_model->total_trichuris($campania)
		));

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function helmintos_por_edad($campania) {
		
	}

	public function detalles($campania) {
		$filename = 'assets/R/tmp/boxplot.js';

		// revisar los permisos de la carpeta tmp
		shell_exec('assets/R/query.R --campania='.$campania.' --archivo=boxplot');
		$fp = fopen($filename, 'r');
		$json = fread($fp, filesize($filename));
		fclose($fp);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function config_exportar($campania) {
		$this->load->view('exportar');
	}

	public function exportar($campania) {
		$datos = $this->input->post();

		$campos_select = array_keys($datos);
		array_unshift($campos_select, 'paciente_numero', 'paciente_edad', 'paciente_sexo');

		$this->db->select(implode(',', $campos_select));
		$this->db->where('campania', $campania);
		$resultado = $this->db->get('v_intervenciones_campanias');

		$datos = $resultado->result_array();

		$nombres_campos = array(
			'paciente_numero' => 'N° Paciente',
			'paciente_edad' => 'Edad',
			'paciente_sexo' => 'Sexo',
			'copro_fecha' => 'Fecha (Copro)',
			'copro_peso' => 'Peso (Copro)',
			'copro_consistencia' => 'Consistencia (Copro)',
			'copro_nro_muestra' => 'N° Muestra (Copro)',
			'cc_ascaris' => 'Ascaris (CC)',
			'cc_giardia' => 'Giardia (CC)',
			'cc_entamoebacoli' => 'Entamoeba Coli (CC)',
			'cc_uncinarias' => 'Uncinarias (CC)',
			'cc_strongyloides' => 'Strongyloides (CC)',
			'cc_hymenolepis' => 'Hymenolepis (CC)',
			'cc_trichuris' => 'Trichuris (CC)',
			'cc_enterobius' => 'Enterobius (CC)',
			'cc_taenia' => 'Taenia (CC)',
			'mm_ascaris' => 'Ascaris (MM)',
			'mm_uncinarias' => 'Uncinarias (MM)',
			'mm_hymenolepis' => 'Hymenolepis (MM)',
			'mm_trichuris' => 'Trichuris (MM)',
			'mm_enterobius' => 'Enterobius (MM)',
			'mm_taenia' => 'Taenia (MM)',
			'hm_strongyloides' => 'Strongyloides (HM)',
			'hm_ancylostoma' => 'Ancylostoma (HM)',
			'hm_necator' => 'Necator (HM)',
			'hm_enterobius' => 'Enterobius (HM)',
			'bm_strongyloides' => 'Strongyloides (BM)',
			'bm_ancylostoma' => 'Ancylostoma (BM)',
			'bm_necator' => 'Necator (BM)',
			'pa_strongyloides' => 'Strongyloides (PA)',
			'pa_ancylostoma' => 'Ancylostoma (PA)',
			'pa_necator' => 'Necator (PA)',
			'sangre_fecha' => 'Fecha (Sangre)',
			'nro_tubo' => 'N° Tubo',
			'globulos_blancos' => 'Glóbulos Blancos',
			'hemoglobina' => 'Hemoglobina',
			'eosinofilos' => 'Eosinofilos',
			'serolog_titulo' => 'Título (Serología)',
			'biologmolec_fuente' => 'Fuente (Biolog. Molec.)',
			'pcr_strongyloides' => 'Strongyloides (PCR)',
			'pcr_ancylostoma' => 'Ancylostoma (PCR)',
			'pcr_necator' => 'Necator (PCR)',
			'pcr_ascaris' => 'Ascaris (PCR)',
			'pcr_trichuris' => 'Trichuris (PCR)',
			'qpcr_strongyloides' => 'Strongyloides (QPCR)',
			'qpcr_ancylostoma' => 'Ancylostoma (QPCR)',
			'qpcr_necator' => 'Necator (QPCR)',
			'qpcr_ascaris' => 'Ascaris (QPCR)',
			'qpcr_trichuris' => 'Trichuris (QPCR)',
			'trat_fecha' => 'Fecha (Trat.)',
			'trat_no_tratado' => 'No Tratado',
			'paciente_peso' => 'Peso (Paciente)',
			'paciente_talla' => 'Talla (Paciente)',
			'paciente_perimetro_cefalico' => 'Perímetro Cefálico (Paciente)',
			'tprev_fecha' => 'Fecha (Trat. Prev.)',
			'tprev_mebendazol' => 'Mebendazol (Trat. Prev.)',
			'tprev_albendazol' => 'Albendazol (Trat. Prev.)',
			'tprev_ivermectina' => 'Ivermectina (Trat. Prev.)',
			'tprev_metronidazol' => 'Metronidazol (Trat. Prev.)',
			'tprev_otras' => 'Otras (Trat. Prev.)',
			'tact_dosis_albendazol' => 'Dosis Albendazol',
			'tact_exc_albendazol' => 'Motiv. Exc. Albendazol',
			'tact_dosis_mebendazol' => 'Dosis Mebendazol',
			'tact_exc_mebendazol' => 'Motiv. Exc. Mebendazol',
			'tact_dosis_ivermectina' => 'Dosis Ivermectina',
			'tact_exc_ivermectina' => 'Motiv. Exc. Ivermectina'
		);

		$this->load->library('PHPExcel.php');

		$this->phpexcel->getProperties()->setCreator("IIET")
		                                 ->setLastModifiedBy("IIET")
		                                 ->setTitle("Consultas")
		                                 ->setSubject("Consultas")
		                                 ->setKeywords("Consultas");

		$sheet = $this->phpexcel->setActiveSheetIndex(0);
		$estilo_centrado_hv = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			)
		);
		$style = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

		$c = 'A';

		foreach($campos_select as $campo) {
			$sheet->getColumnDimension($c)->setAutoSize(true);
			$sheet->getStyle($c.'1')->applyFromArray($estilo_centrado_hv);
			$sheet->setCellValue($c.'1', $nombres_campos[$campo]);

			++$c;
		}

		$f = 2;

		foreach($datos as $interv) {
			$c = 'A';

			foreach($campos_select as $campo) {

				if($interv[$campo] != NULL) {
					$sheet->getStyle($c.$f)->applyFromArray($style);

					if($campo == 'paciente_edad')
						$interv[$campo] = round($interv[$campo]);

					$sheet->setCellValue($c.$f, $interv[$campo]);
				}

				else {
					$sheet->getStyle($c.$f)->applyFromArray($estilo_centrado_hv);
					$sheet->setCellValue($c.$f, '-');
				}

				++$c;
			}

			++$f;
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="consulta_geohelmintos.xls"');
		header('Cache-Control: max-age=0');
		 
		$objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function pacientes($campania) {
		$pacientes = $this->campania_model->obtener_pacientes($campania);
		$json = json_encode($pacientes);
		
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

}