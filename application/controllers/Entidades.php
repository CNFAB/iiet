<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entidades extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('divpolit_model');
	}

	public function index() {
		$this->load->view('entidades');
	}

	public function cargar_divpolit($tabla) {
		$datos = $this->input->post();

		switch($tabla) {
			case 'puestos':
				unset($datos['localidad']);

			case 'barrios':
			case 'parajes':
				unset($datos['departamento']);
			break;
		}
		
		$id = $this->divpolit_model->nueva($tabla, $datos);
		$json = json_encode(array('id' => $id));

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_departamentos() {
		$result = $this->divpolit_model->obtener_departamentos();
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_localidades() {
		$id_dpto = $this->input->post('departamento');
		$result = $this->divpolit_model->obtener_localidades($id_dpto);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_barrios() {
		$id_loc = $this->input->post("localidad");
		$result = $this->divpolit_model->obtener_barrios($id_loc);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_parajes() {
		$id_loc = $this->input->post("localidad");
		$result = $this->divpolit_model->obtener_parajes($id_loc);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_puestos() {
		$id_pje = $this->input->post("paraje");
		$result = $this->divpolit_model->obtener_puestos($id_pje);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}
}