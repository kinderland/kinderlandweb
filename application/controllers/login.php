<?php

require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/personuser.php';
require_once APPPATH . 'core/donation.php';

class Login extends CK_Controller {

    public function __construct() {
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

    public function index() {
        $this->Logger->info("Starting " . __METHOD__);
        if ($this->checkSession())
            redirect("system/menu");
        $data = array();

        // Means the login credencials were incorrect
        if (isset($_GET['error']))
            $data['error'] = $_GET['error'];

        // Means the user returned from a successfull password reset procedure
        if (isset($_GET['rp']))
            $data['resetPassword'] = $_GET['rp'];

        $this->loadView('login/login', $data);
    }

    public function signup() {
        $this->Logger->info("Starting " . __METHOD__);
        $data = array();
        $this->loadView('login/signup', $data);
    }

 	public function loginSuccessful() {
        $this->Logger->info("Starting " . __METHOD__);
        $login = $_POST['login'];
        $password = $_POST['password'];

        $this->Logger->info("Login given: " . $login);

        $this->Logger->info("Authenticating user...");
        $userId = $this->personuser_model->userLogin($login, $password);
        $this->Logger->info("UserId found given the credentials: " . $userId);
        if ($userId) {
            $this->Logger->info("Found, retrieving data about personuser");
            $user = $this->personuser_model->getUserById($userId);

            $permissions = $user->getUserTypes();

            $this->Logger->info("User type: " . print_r($user->getUserTypes(), true));
            $this->Logger->info("Saving data in session");
            $this->session->set_userdata("user_id", $user->getPersonId());
            $this->session->set_userdata("fullname", $user->getFullname());
            $this->session->set_userdata("gender", $user->getGender());
            $this->session->set_userdata("user_types", $permissions);
            
            $rows = $this -> personuser_model -> checkAllPermissionsByUserType($permissions);
            
            $this->setPermissions($rows);
            
            if (count($permissions) == 1)
                $this->redirectToSystemScreen($permissions[0]);
            else
                redirect("system/menu"); //permissions are saved in session
        } else {
            $this->Logger->error("Nothing found, redirecting to login with error screen");
            redirect("login/index?error=true");
        }
    }

    private function redirectToSystemScreen($permission) {
        $this->Logger->info("Starting " . __METHOD__);
        switch ($permission) {
            case COMMON_USER:
                redirect("user/menu");
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
        return;
    }

    public function logout() {
        $this->Logger->info("Starting " . __METHOD__);

        if (!$this->checkSession())
            redirect("login/index");

        $this->Logger->info("Logging out user: " . $this->session->userdata("user_id") . " - " . $this->session->userdata("fullname"));
        $this->session->unset_userdata("fullname");
        $this->session->unset_userdata("user_id");
        $this->session->unset_userdata("user_types");
        $this->session->sess_destroy();

        redirect("login/index");
    }

    public function completeSignup() {
        $this->Logger->info("Starting " . __METHOD__);

        $fullname = $_POST['fullname'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
		$cpf =  str_replace(".", "", $cpf);
		$cpf =  str_replace("-", "", $cpf);		
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


        try {
            $this->Logger->info("Inserting new user");
            //Inicia transação no banco
            $this->generic_model->startTransaction();

            //Faz todo o processo que tem que ser feito no banco
            $addressId = $this->address_model->insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf);
            $personId = $this->person_model->insertNewPerson($fullname, $gender, $email, $addressId);
            $userId = $this->personuser_model->insertNewUser($personId, $cpf, $email, $password, $occupation);

            $this->telephone_model->insertNewTelephone($phone1, $personId);
            if ($phone2)
                $this->telephone_model->insertNewTelephone($phone2, $personId);

            //Caso tenha ocorrido tudo bem, salva as mudanças
            $this->generic_model->commitTransaction();

            $this->Logger->info("New user successfully inserted");
            $this->Logger->info("Saving data in session");

            $this->session->set_userdata("user_id", $personId);
            $this->session->set_userdata("fullname", $fullname);
            $this->session->set_userdata("gender", $gender);
            $this->session->set_userdata("user_types", array(COMMON_USER));

            $person = $this->personuser_model->getUserById($personId);
            $this->Logger->info("Sending sign up confirmation email to: " . $person->getEmail());
            $this->sendSignupEmail($person);

            redirect("user/menu");
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new user");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            $this->loadView('login/signup', $data);
        }
    }

    public function resetPassword($data=null){
        $this->loadView('login/reset_password', $data);
    }

    public function updateUserPassword(){
        $this->Logger->info("Starting " . __METHOD__);
        try{
            if(!isset($_POST['email']))
                throw new Exception("Invalid Post Parameters");

            $email = $_POST['email'];

            $personId = $this->personuser_model->getPersonIdByEmail($email);
            if($personId == null){
                $this->Logger->error("Email: " . $email . " does not exist inside the database");
                throw new Exception("Email does not exist");
            }
            
            $randomString = $this->rand_string(8);
            $this->Logger->debug("Random string generated: \"".$randomString."\"");

            $this->generic_model->startTransaction();
            if(! $this->personuser_model->updatePassword($randomString, $personId) ){
                $this->Logger->error("Email: " . $email . " does not exist inside the database");
                throw new Exception("Failed to update password");
            }
            $this->generic_model->commitTransaction();

            $person = $this->personuser_model->getUserById($personId);
            $this->sendNewPasswordEmail($person, $randomString);

            $data['reset_password'] = true;
            redirect('login/index?rp=true');
        } catch (Exception $ex) {
            $this->Logger->error("Failed to execute " . __METHOD__ . " function");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            $this->loadView('login/reset_password', $data);
        }
        
    }

    private function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = null;
        $size = strlen( $chars );

        for ( $i = 0; $i < $length; $i++) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }

    public function checkExistingCpf() {
        $cpf = $_GET['cpf'];
        if ($this->personuser_model->cpfExists($cpf))
            echo "true";
        else
            echo "false";
    }

    public function checkExistingEmail() {
        $email = $_GET['email'];
        if ($this->person_model->emailExists($email))
            echo "true";
        else
            echo "false";
    }

}

?>