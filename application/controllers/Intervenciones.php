<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intervenciones extends CI_Controller {
	
	function __construct() {
		parent::__construct();

		$this->load->model('intervencion_model');
		$this->load->model('campania_model');
		$this->load->model('consultorioExterno_model');
		$this->load->model('copro_model');
		$this->load->model('sangre_model');
		$this->load->model('biologMolec_model');
		$this->load->model('tratamiento_model');
	}

	public function index() {
		$this->load->view('cargador/inicio_eventos');
	}

	public function campania($estudio = NULL) {
		if($estudio === NULL) {
			$this->load->view('lista_estudios_campania');
			return;
		}

		switch($estudio) {
			case 'copro':
				$estudio_nombre = 'Coproparasitológico';
				$estudio_form = $this->load->view('form_estudios/form_copro', NULL, true);
			break;

			case 'sangre':
				$estudio_nombre = 'Sangre';
				$estudio_form = $this->load->view('form_estudios/form_sangre', NULL, true);
			break;

			case 'biologmolec':
				$estudio_nombre = 'Biología Molecular';
				$estudio_form = $this->load->view('form_estudios/form_biologmolec', NULL, true);
			break;

			case 'tratamiento':
				$estudio_nombre = 'Tratamiento';
				$estudio_form = $this->load->view('form_estudios/form_tratamiento', NULL, true);
			break;
			
			default:

			break;
		}

		$datos = array(
			'estudio_nombre' => $estudio_nombre,
			'estudio_form' => $estudio_form
		);

		$this->load->view('estudios_campania', $datos);
	}

	public function historial($estudio = NULL) {
		if($estudio === NULL) {
			$this->load->view('lista_estudios_historial');
			return;
		}

		switch($estudio) {
			case 'diagpresunt':
				$estudio_nombre = 'Diagnóstico Presuntivo';
				$estudio_form   = $this->load->view('form_estudios/form_diagpresunt', NULL, true);
			break;

			case 'copro':
				$estudio_nombre = 'Coproparasitológico';
				$estudio_form   = $this->load->view('form_estudios/form_copro', NULL, true);
			break;

			case 'sangre':
				$estudio_nombre = 'Sangre';
				$estudio_form   = $this->load->view('form_estudios/form_sangre', NULL, true);
			break;

			case 'biologmolec':
				$estudio_nombre = 'Biología Molecular';
				$estudio_form   = $this->load->view('form_estudios/form_biologmolec', NULL, true);
			break;

			case 'tratamiento':
				$estudio_nombre = 'Tratamiento';
				$estudio_form   = $this->load->view('form_estudios/form_tratamiento', NULL, true);
			break;
			
			default:

			break;
		}

		$datos = array(
			'estudio_nombre' => $estudio_nombre,
			'estudio_form' => $estudio_form
		);

		$this->load->view('historial', $datos);
	}

	public function cargar_copro() {
		$datos = $this->input->post();

		$nro_interv = $this->copro_model->nuevo($datos);

		$datos_interv = $this->datos_intervencion($nro_interv);
		$json = json_encode($datos_interv);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function cargar_sangre() {
		$datos = $this->input->post();

		$nro_interv = $this->sangre_model->nuevo($datos);

		$datos_interv = $this->datos_intervencion($nro_interv);
		$json = json_encode($datos_interv);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function cargar_biologmolec() {
		$datos = $this->input->post();

		$nro_interv = $this->biologMolec_model->nueva($datos);

		$datos_interv = $this->datos_intervencion($nro_interv);
		$json = json_encode($datos_interv);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function cargar_tratamiento() {
		$datos = $this->input->post();

		$nro_interv = $this->tratamiento_model->nuevo($datos);

		$datos_interv = $this->datos_intervencion($nro_interv);
		$json = json_encode($datos_interv);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function cargar_diagpresunt() {
		$datos = $this->input->post();

		$estado = $this->consultorioExterno_model->diagnostico_presuntivo($datos);
		$json = json_encode($estado);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function eliminar_copro($intervencion) {
		$this->copro_model->eliminar($intervencion);

		$tiene_estudios = $this->intervencion_model->tiene_estudios($intervencion);

		if(!$tiene_estudios)
			$this->eliminar($intervencion);

		$json = json_encode($tiene_estudios);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function eliminar_sangre($intervencion) {
		$this->sangre_model->eliminar($intervencion);

		$tiene_estudios = $this->intervencion_model->tiene_estudios($intervencion);

		if(!$tiene_estudios)
			$this->eliminar($intervencion);

		$json = json_encode($tiene_estudios);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function eliminar_biologmolec($intervencion) {
		$this->biologMolec_model->eliminar($intervencion);

		$tiene_estudios = $this->intervencion_model->tiene_estudios($intervencion);

		if(!$tiene_estudios)
			$this->eliminar($intervencion);

		$json = json_encode($tiene_estudios);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function eliminar_tratamiento($intervencion) {
		$this->tratamiento_model->eliminar($intervencion);

		$tiene_estudios = $this->intervencion_model->tiene_estudios($intervencion);

		if(!$tiene_estudios)
			$this->eliminar($intervencion);

		$json = json_encode($tiene_estudios);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_copro($intervencion) {
		$copro = $this->copro_model->obtener_datos_copro($intervencion);
		$json  = json_encode($copro);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_sangre($intervencion) {
		$sangre = $this->sangre_model->obtener_datos_sangre($intervencion);
		$json   = json_encode($sangre);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_biologmolec($intervencion) {
		$biologmolec = $this->biologMolec_model->obtener_datos_biologmolec($intervencion);
		$json        = json_encode($biologmolec);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_tratamiento($intervencion) {
		$tratamiento = $this->tratamiento_model->obtener_datos_tratamiento($intervencion);
		$json = json_encode($tratamiento);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_diagpresunt($intervencion) {
		$diagpresunt = $this->consultorioExterno_model->obtener_datos_diagpresunt($intervencion);
		$json = json_encode($diagpresunt);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function intervenciones_paciente($paciente) {
		$intervenciones = $this->intervencion_model->obtener_intervenciones_paciente($paciente);

		$intervs = [];

		foreach($intervenciones as $intervencion)
			$intervs[] = $this->datos_intervencion($intervencion);

		$json = json_encode($intervs);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function estudios_paciente($tipo, $id, $paciente = NULL) {
		if($tipo == 'CAMPANIA') {
			$nro_campania = $id;
			//$nro_campania = $this->intervencion_model->obtener_campania($intervencion);
			$intervencion = $this->campania_model->obtener_intervencion($nro_campania, $paciente);
			//$intervencion = $ext_camp;
			$datos['campania'] = $this->campania_model->obtener_datos_campania($nro_campania);
		}

		else {
			$intervencion = $id;
			$datos['externo'] = $this->consultorioExterno_model->obtener_datos($intervencion);
		}

		$datos['intervencion'] = $intervencion;
		$datos['estudios'] = $intervencion ? $this->intervencion_model->obtener_estudios($intervencion) : null;

		$json = json_encode($datos);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function nuevo_consult_ext() {
		$datos = $this->input->post();

		$nro_interv = $this->consultorioExterno_model->nuevo($datos);

		$datos_interv = $this->datos_intervencion($nro_interv);
		$json = json_encode($datos_interv);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function eliminar($intervencion) {
		$estado = $this->intervencion_model->eliminar($intervencion);

		$json = json_encode($estado);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}


	private function datos_intervencion($nro_interv) {
		$interv = [];

		$intervencion = $this->intervencion_model->datos($nro_interv);

		$interv['numero'] = $nro_interv;
		$interv['tipo'] = $intervencion['tipo'];

		if($intervencion['tipo'] == 'CAMPANIA') {
			$nro_campania = $this->intervencion_model->obtener_campania($nro_interv);
			$datos_campania = $this->campania_model->datos_completos($nro_campania);

			$campania              = [];
			$campania['numero']    = $datos_campania['numero'];
			$campania['nombre']    = $datos_campania['nombre'];
			$campania['fecha']     = $datos_campania['fecha_inicio'];
			$campania['tipo']      = $datos_campania['tipo'];
			$campania['localidad'] = $datos_campania['localidad'];

			$interv['datos_tipo'] = $campania;
		}

		else {
			$datos_externo = $this->consultorioExterno_model->obtener_datos($nro_interv);

			$externo                = [];
			$externo['fecha']       = $datos_externo['fecha'];
			$externo['procedencia'] = $datos_externo['procedencia'];
			$externo['localidad']   = $datos_externo['localidad'];

			$interv['datos_tipo'] = $externo;
		}

		return $interv;
	}




	public function copro() {
		$form = $this->load->view('cargador/form_estudios/form_copro', null, true);
		$this->load->view('cargador/eventos_paciente', array(
			'titulo' => 'Copro',
			'form' => $form,
			'tipo_form' => 'copro'
		));
	}

	public function sangre() {
		$form = $this->load->view('cargador/form_estudios/form_sangre', null, true);
		$this->load->view('cargador/eventos_paciente', array(
			'titulo' => 'Sangre',
			'form' => $form,
			'tipo_form' => 'sangre'
		));
	}

	public function biologia_molecular() {
		$form = $this->load->view('cargador/form_estudios/form_biologmolec', null, true);
		$this->load->view('cargador/eventos_paciente', array(
			'titulo' => 'Biología Molecular',
			'form' => $form,
			'tipo_form' => 'biologmolec'
		));
	}

	public function tratamiento() {
		$form = $this->load->view('cargador/form_estudios/form_tratamiento', null, true);
		$this->load->view('cargador/eventos_paciente', array(
			'titulo' => 'Tratamiento',
			'form' => $form,
			'tipo_form' => 'tratamiento'
		));
	}
}