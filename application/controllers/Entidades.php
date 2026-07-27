<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entidades extends CI_Controller {
	public function __construct() {
		parent::__construct();

		if ($this->ion_auth->logged_in()) {
			$this->load->model('divpolit_model');
			$this->load->model('centroSalud_model');

			$this->usuario = $this->ion_auth->user()->row();
		}

		else
			redirect('usuarios/login', 'refresh');
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

		$this->load->view('divpolits', $datos);
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

			case 'instit_barrios':
				$datos['lugar'] = 'barrio';
			break;

			case 'instit_parajes':
				$datos['lugar'] = 'paraje';
			break;
		}

		if($tabla == 'instit_barrios' || $tabla == 'instit_parajes') {
			$this->load->model('institucion_model');
			$id = $this->institucion_model->nueva($datos);
		}

		else
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

	public function listado_localidades($departamento = NULL) {
		if(!isset($departamento))
			$departamento = $this->input->post('departamento');

		$result = $this->divpolit_model->obtener_localidades($departamento);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_barrios($localidad = NULL) {
		if(!isset($localidad))
			$localidad = $this->input->post("localidad");

		$result = $this->divpolit_model->obtener_barrios($localidad);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_parajes($localidad = NULL) {
		if(!isset($localidad))
			$localidad = $this->input->post("localidad");

		$result = $this->divpolit_model->obtener_parajes($localidad);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_puestos($puesto = NULL) {
		if(!isset($puesto))
			$puesto = $this->input->post("paraje");
		
		$result = $this->divpolit_model->obtener_puestos($puesto);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function listado_centros_salud() {
		$datos = $this->input->post();
		$result = $this->centroSalud_model->obtener_centros($datos);
		$json = json_encode($result);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_datos($divPolit, $id) {
		$this->db->where('numero', $id);
		$resultado = $this->db->get($divPolit);

		$json = json_encode($resultado->row());

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function tiene_dependencias($divpolit, $id) {
		$func = $divpolit.'_tiene_dependencias';

		$estado = $this->divpolit_model->$func($id);
		$json = json_encode($estado);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function eliminar($divpolit, $id) {
		$func = 'eliminar_'.$divpolit;

		$this->divpolit_model->$func($id);
	}
}