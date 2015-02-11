<?php 
require_once APPPATH . 'core/CK_Controller.php';
class System extends CK_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('person_model');
		$this->load->model('address_model');
		$this->load->model('generic_model');
		$this->load->model('telephone_model');
		$this->load->model('personuser_model');
	}

	public function menu(){
		$data['fullname'] = $this->session->userdata("fullname");
		$this->loadView("system/menu", $data);
	}

}

?>