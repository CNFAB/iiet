<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campanias extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model('campania_model');
	}

	public function cargar() {
		$datos = $this->input->post();

		$id = $this->campania_model->nueva($datos);
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

	public function datos_campania() {
		$datos = $this->input->post();

		$campania = $this->campania_model->obtener_datos_campania($datos);
		$json = json_encode($campania);
		
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}
}