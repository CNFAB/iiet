<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Intervenciones extends CI_Controller {
	
	function __construct() {
		parent::__construct();

		$this->load->model('intervencion_model');
	}

	public function cargar() {
		$datos = $this->input->post();

		$id = $this->intervencion_model->nueva($datos);

		return $id;
	}
}