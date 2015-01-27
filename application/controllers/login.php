<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('person_model');
	}

	public function index(){
		$this->load->view('login/login');
	}

	public function signup(){
		$this->load->view('login/signup');
	}

	public function completeSignup(){
		$sqlResult = $this->person_model->insertNewPerson($_GET['fullname'], $_POST['gender'], $_POST['email']);
		print_r($sqlResult);
	}
}

?>