<?php 
require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/personuser.php';
class User extends CK_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('person_model');
		$this->load->model('address_model');
		$this->load->model('generic_model');
		$this->load->model('telephone_model');
		$this->load->model('personuser_model');
	}

	public function edit(){
		$user = $this->personuser_model->getUserById($this->session->userdata("user_id"));
		
		$data['user'] = $user;
		$data['fullname'] = $this->session->userdata("fullname");
		$this->loadView('user/form_edit', $data);
	}

	public function save(){
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
		
		
	}

	public function update(){
        $person_id = $this->session->userdata("user_id");
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


        $address = $this->address_model->getAddressByPersonId($person_id);

        try{
            $this->generic_model->startTransaction();

            $this->person_model->updatePerson($fullname, $gender, $email, $person_id);
            $this->personuser_model->updatePersonUser($email, $cpf, $occupation, $person_id);
            $this->address_model->updateAddress($street, $number, $complement, $city, $cep, $uf, $neighborhood, $address->getAddressId());
            $this->telephone_model->updatePhone($person_id, $phone1, $phone2);

            $this->session->set_userdata("fullname", $fullname);
            
            $this->generic_model->commitTransaction();

           	redirect("system/menu");

        } catch(Exception $ex){

            $this->generic_model->rollbackTransaction();
        }

    } 

}

?>