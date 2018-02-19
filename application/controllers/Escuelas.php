<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Escuelas extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('escuela_model');
	}

	public function cargar_escuela() {
		$datos = $this->input->post();

		$id = $this->escuela_model->nueva($datos);
		$json = json_encode($id);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_escuelas() {
		$datos = $this->input->post();
		$result = $this->escuela_model->obtener_escuelas($datos);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}
}