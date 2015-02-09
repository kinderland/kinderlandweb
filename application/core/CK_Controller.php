<?php
include_once APPPATH.'core/personuser.php';

// Colonia Kinderland Controller -> CK_Controller
class CK_Controller extends CI_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function loadView($viewName, $data){
		$this->load->view('include/header', $data);
		$this->load->view($viewName, $data);
		//$this->load->view('include/footer');
	}

	public function checkSession(){
		//print_r($this->session->userdata('operator'));
		if(!is_object($this->session->userdata('user')))
			return false;
		return true;
	}
}
?>