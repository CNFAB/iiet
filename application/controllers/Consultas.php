<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Consultas extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$datos = json_decode($this->input->raw_input_stream, true);

		$tabla = $datos['tabla'];
		$campos = $datos['campos'];
		$condiciones = $datos['condicion'];

		$str_sql = '';
		$str_campos = '';

		if(count($campos) === 0)
			$str_campos = '*';

		else {
			for($i = 0; $i < count($campos); ++$i)
				$str_campos .= $campos[$i] . ',';

			$str_campos = trim($str_campos, ',');
		}

		if(count($condiciones['cond']) === 0)
			$str_sql = 'SELECT ' . $str_campos . ' FROM ' . $tabla;

		else {
			$cond = $this->armar_condicion($condiciones);
			$str_sql = 'SELECT ' . $str_campos . ' FROM ' . $tabla . ' WHERE ' . $cond;
		}

		$consulta = $this->db->query($str_sql);
		$json = json_encode($consulta->result());

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}

	private function armar_condicion($condicion) {
		$tipo = $condicion['tipo'];
		$neg = $condicion['neg'];
		$cond = $condicion['cond'];

		$str_cond = '';

		if($tipo == 'simple') {
			switch($cond[1]) {
				case 'comience':
					$str_cond = $cond[0] . ' ilike \'' . $cond[2] . '%\'';
				break;
				
				case 'no_comience':
					$str_cond = $cond[0] . ' not ilike \'' . $cond[2] . '%\'';
				break;
				
				case 'termine':
					$str_cond = $cond[0] . ' ilike \'%' . $cond[2];
				break;
				
				case 'no_termine':
					$str_cond = $cond[0] . ' not ilike \'%' . $cond[2];
				break;
				
				case 'contenga':
					$str_cond = $cond[0] . ' ilike \'%' . $cond[2] . '%\'';
				break;
				
				case 'no_contenga':
					$str_cond = $cond[0] . ' not ilike \'%' . $cond[2] . '%\'';
				break;

				default:
					$str_cond = $cond[0] . ' ' . $cond[1] . ' ' . $this->db->escape($cond[2]);
				break;
			}
		}
		
		else {
			$str_cond = '(';

			$str_cond .= $this->armar_condicion($cond[0]);

			for($i = 2; $i < count($cond); $i += 2) {
				$str_cond .= ' ' . $cond[$i-1] . ' ';
				$str_cond .= $this->armar_condicion($cond[$i]);
			}

			$str_cond .= ')';
		}

		if($neg == 'true')
			$str_cond = 'NOT (' . $str_cond . ')';

		return $str_cond;
	}

	public function prueba() {
		$post = $this->input->post();

		$query = $this->db->get($post['tabla']);
		$json = json_encode($query->result());

		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}
}