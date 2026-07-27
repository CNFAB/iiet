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
		$this->load->view('inicio2');
	}

	public function pacientes() {
		$this->load->view('pacientes2');
	}

	public function campanias() {
		$this->load->view('campanias2');
	}

	public function divisiones_politicas_e_instituciones() {
		$this->load->view('divpolits');
	}

	public function copro() {
		$form = $this->load->view('cargador/form_estudios/form_copro', null, true);
		$this->load->view('cargador/intervenciones_campania', array(
			'titulo' => 'Copro',
			'form' => $form,
			'tipo_form' => 'copro'
		));
	}

	public function sangre() {
		$form = $this->load->view('cargador/form_estudios/form_sangre', null, true);
		$this->load->view('cargador/intervenciones_campania', array(
			'titulo' => 'Sangre',
			'form' => $form,
			'tipo_form' => 'sangre'
		));
	}

	public function biologia_molecular() {
		$form = $this->load->view('cargador/form_estudios/form_biologmolec', null, true);
		$this->load->view('cargador/intervenciones_campania', array(
			'titulo' => 'Biología M
			lecular', 'form' => $form,
			'tipo_form' => 'biologmolec'
		));
	}

	public function tratamiento() {
		$form = $this->load->view('cargador/form_estudios/form_tratamiento', null, true);
		$this->load->view('cargador/intervenciones_campania', array(
			'titulo' => 'Tratamiento',
			'form' => $form,
			'tipo_form' => 'tratamiento'
		));
	}

	public function historia_copro() {
		$form = $this->load->view('cargador/form_estudios/form_copro', null, true);
		$this->load->view('historia', array(
			'titulo' => 'Copro',
			'form' => $form,
			'tipo_form' => 'copro'
		));
	}

	public function historia_sangre() {
		$form = $this->load->view('cargador/form_estudios/form_sangre', null, true);
		$this->load->view('historia', array(
			'titulo' => 'Sangre',
			'form' => $form,
			'tipo_form' => 'sangre'
		));
	}

	public function historia_biologia_molecular() {
		$form = $this->load->view('cargador/form_estudios/form_biologmolec', null, true);
		$this->load->view('historia', array(
			'titulo' => 'Biología Molecular',
			'form' => $form,
			'tipo_form' => 'biologmolec'
		));
	}

	public function historia_tratamiento() {
		$form = $this->load->view('cargador/form_estudios/form_tratamiento', null, true);
		$this->load->view('historia', array(
			'titulo' => 'Tratamiento',
			'form' => $form,
			'tipo_form' => 'tratamiento'
		));
	}

	public function login()
	{
		$this->load->view('login');
	}

	public function inicio_campania() {
		$this->load->view('cargador/inicio_estudios_campania');
	}

	public function paginacion() {
		$this->load->view('historia');
	}

	public function busqueda()
	{
		$estudio_nombre = 'Coproparasitológico';
		$estudio_form = $this->load->view('form_estudios/form_copro', NULL, true);

		$this->load->view('historia', array('estudio_nombre' => $estudio_nombre, 'estudio_form' => $estudio_form));
	}

	public function grafico() {
		$this->load->view('mapa');
	}
}
