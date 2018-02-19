<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudios extends CI_Controller {
	
	function __construct() {
		parent::__construct();

		$this->load->model('copro_model');
		$this->load->model('sangre_model');
		$this->load->model('biologMolec_model');
		$this->load->model('tratamiento_model');
	}

	public function index() {
		$this->load->view('menu_estudios');
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

		$this->load->view('carga_estudios_campania', $datos);
	}

	public function externo($estudio = NULL) {
		if($estudio === NULL) {
			$this->load->view('lista_estudios_externo');
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

		$this->load->view('carga_estudios_externo', $datos);
	}

	public function cargar_copro() {
		$datos = $this->input->post();

		$id = $this->copro_model->nuevo($datos);
		$json = json_encode($id);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function cargar_sangre() {
		$datos = $this->input->post();

		$id = $this->sangre_model->nuevo($datos);
		$json = json_encode($id);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function cargar_biologmolec() {
		$datos = $this->input->post();

		$id = $this->biologMolec_model->nueva($datos);
		$json = json_encode($id);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function cargar_tratamiento() {
		$datos = $this->input->post();

		$id = $this->tratamiento_model->nuevo($datos);
		$json = json_encode($id);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	/*public function obtenerCoproPaciente($paciente) {
		print_r($this->copro_model->obtenerCoproCampania($paciente));
	}*/
}