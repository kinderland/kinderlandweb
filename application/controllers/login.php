<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('person_model');
		$this->load->model('address_model');
		$this->load->model('telephone_model');
	}

	public function index(){
		$this->load->view('login/login');
	}

	public function signup(){

		$this->load->view('login/signup');
	}

	public function completeSignup(){
		$fullname = $_POST['fullname'];
		$gender = $_POST['gender'];
		$email = $_POST['email'];
		$cpf = $_POST['cpf'];
		$street = $_POST['street'];
		$number = $_POST['number'];
		$city = $_POST['city'];
		$phone1 = $_POST['phone1'];
		$phone2 = $_POST['phone2'];
		$cep = $_POST['cep'];
		$occupation = $_POST['occupation'];
		$complement = $_POST['complement'];
		$neighborhood = $_POST['neighborhood'];
		$uf = $_POST['uf'];


		$addressId = $this->address_model->insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf);
		$personId = $this->person_model->insertNewPerson($fullname, $gender, $email, $addressId);
		
		$this->telephone_model->insertNewTelephone($phone1,$personId);

		if($phone2)
			$this->telephone_model->insertNewTelephone($phone2,$personId);

		print_r($personId);
	}
}

?>