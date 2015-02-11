<?php
require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/personuser.php';
class Login extends CK_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('person_model');
		$this->load->model('address_model');
		$this->load->model('generic_model');
		$this->load->model('telephone_model');
		$this->load->model('personuser_model');
	}

	public function index(){

		if(isset($_GET['error']))
			$data['error'] = $_GET['error'];
		else
			$data['error'] = false;

		$this->loadView('login/login', $data);
	}

	public function signup(){
		$this->loadView('login/signup');
	}
	
	public function loginSuccessful(){
		$login = $_POST['login'];
		$password = $_POST['password'];

		$userId = $this->personuser_model->userLogin($login, $password);

		if ($userId) {  
		 	$user = $this->personuser_model->getUserById($userId);
		 	$this->session->set_userdata("user_id", $user->getPersonId());
		 	$this->session->set_userdata("fullname", $user->getFullname());

			//$this->load->view('system/menu', $data);
			redirect("user/edit");
		}else {
		 	redirect("login/index?error=true");
		}
	}

	public function logout(){
		if(!$this->checkSession())
			redirect("Login/index");
		$this->session->session_destroy();
		redirect("Login/index");
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

			$this->loadView('login/signup_completed', $data);
		} catch (Exception $ex) {
			//Caso tenha capturado algum erro, volta atrás nas alterações feitas antes do erro acontecer
			$this->generic_model->rollbackTransaction();
			$data['error'] = true;
			$this->loadView('login/signup', $data);
		}
	}
}

?>