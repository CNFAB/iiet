<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {
	
	function __construct() {
		parent::__construct();

		if ($this->ion_auth->logged_in()) {
			//$this->load->library('form_validation');
			$this->usuario = $this->ion_auth->user()->row();
		}

		else
			redirect('usuarios/login', 'refresh');
			//$this->load->view('auth/login');
	}

	public function index() {
		redirect('inicio/seleccion_modo');
	}

	public function seleccion_modo() {
		$grupos = $this->ion_auth->get_users_groups($this->usuario->id)->result();

		if(count($grupos) == 1) {
			$grupo = $grupos[0]->name;

			switch($grupo) {
				case 'admin':
					redirect('inicio/admin');
				break;

				case 'operario':
					redirect('inicio/operario');
				break;

				case 'consultor':
					redirect(base_url('inicio/consultor'), 'refresh');
				break;
			}
		}

		else {
			$nombre_grupos = [];

			foreach($grupos as $grupo)
				$nombre_grupos[$grupo->name] = TRUE;

			$consulta = $this->ion_auth->get_users_groups($this->usuario->id)->result();

			$datos_usuario = array(
				'usuario' => $this->usuario->last_name.', '.$this->usuario->first_name,
				'grupos' => array_map(function($g) { return $g->description; }, $consulta)
			);

			$this->load->view('inicio-usuario', array_merge($nombre_grupos, $datos_usuario));
		}
	}

	public function admin() {
		if($this->ion_auth->is_admin($this->usuario->id)) {
			$grupos = $this->ion_auth->get_users_groups($this->usuario->id)->result();
			$datos = [];

			foreach($grupos as $grupo)
				$datos[$grupo->name] = TRUE;

			$datos['usuario'] = $this->usuario->last_name.', '.$this->usuario->first_name;
			$datos['cant_rol'] = count($grupos);

			if($datos['cant_rol'] === 1)
				$datos['rol'] = $grupos[0]->description;

			$this->load->view('auth/index', $datos);
		}

		else
			redirect('');
	}

	public function operario() {
		if($this->ion_auth->in_group('operario', $this->usuario->id)) {
			$grupos = $this->ion_auth->get_users_groups($this->usuario->id)->result();
			$datos = [];

			foreach($grupos as $grupo)
				$datos[$grupo->name] = TRUE;

			$datos['usuario'] = $this->usuario->last_name.', '.$this->usuario->first_name;
			$datos['cant_rol'] = count($grupos);

			if($datos['cant_rol'] === 1)
				$datos['rol'] = $grupos[0]->description;

			$this->load->view('inicio2', $datos);
		}

		else
			redirect('');
	}

	public function consultor() {
		if($this->ion_auth->in_group('consultor', $this->usuario->id)) {
			$grupos = $this->ion_auth->get_users_groups($this->usuario->id)->result();
			$datos = [];

			foreach($grupos as $grupo)
				$datos[$grupo->name] = TRUE;

			$datos['usuario'] = $this->usuario->last_name.', '.$this->usuario->first_name;
			$datos['cant_rol'] = count($grupos);

			if($datos['cant_rol'] === 1)
				$datos['rol'] = $grupos[0]->description;

			$this->load->view('consultor/inicio', $datos);
		}

		else
			redirect('');
	}
}