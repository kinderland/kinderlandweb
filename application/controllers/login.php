<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('person_model');
		$this->load->model('address_model');
		$this->load->model('telephone_model');
		$this->load->model('personuser_model');
	}

	public function index(){
		$data['error'] = false;
		$this->load->view('include/header');
		$this->load->view('login/login', $data);
	}

	public function signup(){
		$this->load->view('include/header');
		$this->load->view('login/signup');
	}
	
	public function loginSuccessful(){
		$login = $_POST['login'];
		$password = $_POST['password'];
		$this->load->view('include/header');

		$result = $this->personuser_model->userLogin($login, $password);
		$data['login'] = $login;
		$data['password'] = $password;
		$data['error'] = false;

		 if ($result) {  
			$this->load->view('login/login_successful', $data);
		 }
		 else {
		 	$data['error'] = true;
		 	$this->load->view('login/login', $data);
		 }

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
		$password = $_POST['password'];


		try{
			//Inicia transação no banco
			$this->generic_model->startTransaction();

			//Faz todo o processo que tem que ser feito no banco
			$addressId = $this->address_model->insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf);
			$personId = $this->person_model->insertNewPerson($fullname, $gender, $email, $addressId);
			$userId = $this->personuser_model->insertNewUser($personId, $cpf, $email, $password, $occupation);

			$this->telephone_model->insertNewTelephone($phone1, $personId);
			if($phone2)
				$this->telephone_model->insertNewTelephone($phone2, $personId);

			//Caso tenha ocorrido tudo bem, salva as mudanças
			$this->generic_model->commitTransaction();

			$data['name'] = $fullname;

			$this->load->view('include/header');
			$this->load->view('login/signup_completed', $data);
		} catch (Exception $ex) {
			//Caso tenha capturado algum erro, volta atrás nas alterações feitas antes do erro acontecer
			$this->generic_model->rollbackTransaction();
			$data['error'] = true;
			$this->load->view('include/header');
			$this->load->view('login/signup', $data);
		}
	}
}

?>