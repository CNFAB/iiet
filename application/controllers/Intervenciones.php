<?php

class Intervenciones extends CI_Controller {
	
	function __construct() {
		parent::__construct();

		$this->load->model('intervencion_model');
	}

	public function cargar() {
		$datos = $this->input->post();

		$id = $this->intervencion_model->nueva($datos);
		$json = json_encode($id);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}
}