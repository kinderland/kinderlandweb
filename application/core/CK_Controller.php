<?php
include_once APPPATH.'core/personuser.php';

// Colonia Kinderland Controller -> CK_Controller
class CK_Controller extends CI_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function loadView($viewName, $data){
		$output  = $this->load->view('include/header', $data, true);
		$output .= $this->load->view($viewName, $data, true);
		$output .= $this->load->view('include/footer', $data, true);

		$this->output->set_output($output);
	}

	public function checkSession(){
		//print_r($this->session->userdata('operator'));
		if(!is_null($this->session->userdata('user_id')) && strlen($this->session->userdata('user_id')) > 0)
			return false;
		return true;
	}
}
?>