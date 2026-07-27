<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacientes extends CI_Controller {
	public function __construct() {
		parent::__construct();

		if ($this->ion_auth->logged_in()) {
			$this->usuario = $this->ion_auth->user()->row();

			if($this->ion_auth->in_group('operario', $this->usuario->id)) {
				$this->load->model('paciente_model');
				$this->load->model('intervencion_model');
			}

			else
				redirect('inicio/seleccion_modo');
		}

		else
			$this->load->view('auth/login');
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

		$this->load->view('pacientes2', $datos);
	}

	public function nuevo() {
		$datos = $this->input->post();
	    $datos['latitud'] = $this->input->post('latitud') ?: NULL;
  	    $datos['longitud'] = $this->input->post('longitud') ?: NULL;

		$id = $this->paciente_model->cargar($datos);
		$json = json_encode(array('id' => $id));

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function actualizar($paciente = NULL) {
		$datos = $this->input->post();
		$datos['latitud'] = $this->input->post('latitud') ?: NULL;
    	$datos['longitud'] = $this->input->post('longitud') ?: NULL;
		$paciente = $paciente === NULL ? $datos['numero'] : $paciente;

		$estado = $this->paciente_model->cargar($datos, FALSE, $paciente);
		$json = json_encode($estado);

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

	public function listado($offset = 0) {
		$campo = $this->input->post('campo_filtro');
		$valor = $this->input->post('valor_filtro');

		$lista = $this->paciente_model->filtrar($campo, $valor, $offset);

		$json = json_encode($lista);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function todos($offset = 0) {
		$resultado = $this->paciente_model->obtener_datos_todos($offset);

		$json = json_encode($resultado);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_datos($paciente) {
		$paciente = $this->paciente_model->obtener_datos($paciente);

		$json = json_encode($paciente);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function fue_intervenido($paciente) {
		$estado = $this->intervencion_model->existen_intervenciones($paciente);

		$json = json_encode($estado);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function eliminar($paciente) {
		$this->paciente_model->eliminar($paciente);

		$json = json_encode(TRUE);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);


	}

	public function listar() {
		$offset   = $this->input->post('start');
		$num_regs = $this->input->post('length');
		$filtro   = $this->input->post('search')['value'];
		$orden    = $this->input->post('order')[0];
		$ord_col  = $orden['column'];
		$ord_dir  = $orden['dir'];
		$ord_camp = $this->input->post('columns')[$ord_col]['data'];
		$draw     = $this->input->post('draw');

		$p_lista = $this->paciente_model->obtener_listado($offset, $num_regs, $filtro, $ord_camp, $ord_dir);
		$p_total = $this->paciente_model->obtener_total();
		$p_filt  = $this->paciente_model->obtener_total($filtro);

		$json = json_encode(array(
			'data' => $p_lista,
			'recordsTotal' => $p_total,
			'recordsFiltered' => $p_filt,
			'draw' => $draw
		));

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function existe($dni) {
		$resp = $this->paciente_model->existe($dni);
		$json = json_encode($resp);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	public function obtener_domicilio($paciente) {
		$dom = $this->paciente_model->obtener_domicilio($paciente);
		$json = json_encode($dom);

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}





	public function obtener_listado_pacientes() {
		$listado = $this->paciente_model->obtener_listado_pacientes();

		$json = json_encode(array(
			'estado' => 1,
			'mensaje' => 'exito',
			'pacientes' => $listado
		));
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}
}