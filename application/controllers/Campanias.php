<?php

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
}