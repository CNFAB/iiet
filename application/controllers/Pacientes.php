<?php

class Pacientes extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model('paciente_model');
	}

	public function cargar() {
		$datos = $this->input->post();

		$id = $this->paciente_model->nuevo($datos);
		$json = json_encode(array('id' => $id));

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function existe_paciente() {
		$id = $this->input->post('dni');

		$estado = $this->paciente_model->existe($id);
		$json = json_encode($estado);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_pacientes() {
		$listado = $this->paciente_model->lista();

		$json = json_encode($listado);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function filtrar_pacientes() {
		$campo = $this->input->post('campo_filtro');
		$valor = $this->input->post('valor_filtro');

		$listado = $this->paciente_model->lista_filtro($campo, $valor);

		$json = json_encode($listado);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}
}