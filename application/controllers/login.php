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

		$this->person_model->setLogger($this->Logger);
		$this->address_model->setLogger($this->Logger);
		$this->generic_model->setLogger($this->Logger);
		$this->telephone_model->setLogger($this->Logger);
		$this->personuser_model->setLogger($this->Logger);
	}

	public function index(){
		$this->Logger->info("Starting " . __METHOD__);

		if($this->checkSession())
			redirect("system/menu");

		$data = array();
		if(isset($_GET['error']))
			$data['error'] = $_GET['error'];

		$this->loadView('login/login', $data);
	}

	public function signup(){
		$this->Logger->info("Starting " . __METHOD__);
		$data = array();
		$this->loadView('login/signup', $data);
	}
	
	public function loginSuccessful(){
		$this->Logger->info("Starting " . __METHOD__);
		$login = $_POST['login'];
		$password = $_POST['password'];

		$this->Logger->info("Login given: ". $login);

		$this->Logger->info("Authenticating user...");
		$userId = $this->personuser_model->userLogin($login, $password);
		$this->Logger->info("UserId found given the credentials: ". $userId);
		if ($userId) {  
			$this->Logger->info("Found, retrieving data about personuser");
		 	$user = $this->personuser_model->getUserById($userId);

		 	$this->Logger->info("User type: ". $user->getUserType());
		 	$this->Logger->info("Saving data in session");
		 	$this->session->set_userdata("user_id", $user->getPersonId());
		 	$this->session->set_userdata("fullname", $user->getFullname());
		 	$this->session->set_userdata("user_type", $user->getUserType());

			switch($user->getUserType()){
				case COMMON_USER:
					redirect("user/edit");
					break;
				case SYSTEM_ADMIN:
					//TO DO LATER
					break;
				case DIRECTOR:
					//TO DO LATER
					break;
				case SECRETARY:
					//TO DO LATER
					break;
				case COORDINATOR:
					//TO DO LATER
					break;
				default:
					redirect("login/index?error=true");
					break;
			}
			
		} else {
			$this->Logger->error("Nothing found, redirecting to login with error screen");
		 	redirect("login/index?error=true");
		}
	}

	public function logout(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$this->Logger->info("Logging out user: ".$this->session->userdata("user_id") . " - " . $this->session->userdata("fullname"));
		$this->session->unset_userdata("fullname");
		$this->session->unset_userdata("user_id");
		$this->session->unset_userdata("user_type");
		$this->session->sess_destroy();
		
		redirect("login/index");
	}

	public function completeSignup(){
		$this->Logger->info("Starting " . __METHOD__);

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
			$this->Logger->info("Inserting new user");
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

			$this->Logger->info("New user successfully inserted");
		 	$this->Logger->info("Saving data in session");

			$this->session->set_userdata("user_id", $personId);
			$this->session->set_userdata("fullname", $fullname);
			$this->session->set_userdata("user_type", COMMON_USER);
			redirect("system/menu");
		} catch (Exception $ex) {
			$this->Logger->error("Failed to insert new user");
			//Caso tenha capturado algum erro, volta atrás nas alterações feitas antes do erro acontecer
			$this->generic_model->rollbackTransaction();
			$data['error'] = true;
			$this->loadView('login/signup', $data);
		}
	}

	public function checkExistingCpf(){
		$cpf = $_GET['cpf'];
		if($this->personuser_model->cpfExists($cpf))
			echo "true";
		else
			echo "false";
	}
	
}

?>