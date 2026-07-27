<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        
        if ($this->ion_auth->logged_in()) {
            $this->usuario = $this->ion_auth->user()->row();
        }
    }

    public function perfil() {
        $this->load->view('auth/perfil');
    }

    public function login($por_ajax = FALSE) {
        // Si está logueado, redirigir al inicio
        if ($this->ion_auth->logged_in()) {
            redirect('inicio');
        }
        
        // Si es una petición AJAX
        if ($por_ajax) {
            $this->form_validation->set_rules('identity', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Contraseña', 'required');

            if ($this->form_validation->run() === TRUE) {
                $remember = FALSE;
                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                    $json = json_encode(TRUE);
                } else {
                    $json = json_encode(FALSE);
                }
                $this->output->set_content_type('application/json');
                $this->output->set_output($json);
            }
            return;
        }
        
        // Si NO es AJAX, mostrar la vista de login
        $this->load->view('auth/login');
    }

    public function logout($por_ajax = FALSE) {
        $this->ion_auth->logout();
        if(!$por_ajax) {
            redirect('usuarios/login', 'refresh');
        }
    }

    public function datos() {
        if (!$this->ion_auth->logged_in()) {
            show_error('Usuario no autenticado', 401);
        }
        
        $consulta = $this->ion_auth->get_users_groups($this->usuario->id)->result();

        $datos_usuario = array(
            'apellido' => $this->usuario->last_name,
            'nombre'   => $this->usuario->first_name,
            'email'    => $this->usuario->email,
            'grupos'   => array_map(function($g) { return $g->description; }, $consulta)
        );

        $json = json_encode($datos_usuario);
        $this->output->set_content_type('application/json');
        $this->output->set_output($json);
    }

    public function cambiar_clave() {
        if (!$this->ion_auth->logged_in()) {
            show_error('Usuario no autenticado', 401);
        }
        
        $this->form_validation->set_rules('old', 'Contraseña actual', 'required');
        $this->form_validation->set_rules('new', 'Nueva contraseña', 'required|min_length[6]|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', 'Confirmar contraseña', 'required');

        if ($this->form_validation->run() === FALSE) {
            $estado = FALSE;
        } else {
            $identity = $this->session->userdata('identity');
            $cambio = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($cambio) {
                $this->logout(TRUE);
                $estado = TRUE;
            } else {
                $estado = FALSE;
            }
        }

        $json = json_encode($estado);
        $this->output->set_content_type('application/json');
        $this->output->set_output($json);
    }
}
?>