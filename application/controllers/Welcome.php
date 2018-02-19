<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('inicio');
	}

	public function consultas2() {
		$this->load->view('consultas2');
	}

	public function consultas() {
		$this->load->view('consultas');
	}

	public function copro() {
		$this->load->view('carga_copro_campania');
	}

	public function anterior() {
		$this->load->view('html/registro_de_estudios.php');
	}

	public function biologmolec()
	{
		$this->load->view('carga_biologmolec_campania');
	}

	public function tratamiento()
	{
		$this->load->view('carga_tratamiento_campania');
	}
}
