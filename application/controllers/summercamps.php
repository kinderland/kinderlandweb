<?php
require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/summercamp.php';
require_once APPPATH . 'core/summercampSubscription.php';
class SummerCamps extends CK_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> model('address_model');
		$this -> load -> model('colonist_model');
		$this -> load -> model('generic_model');
		$this -> load -> model('person_model');
		$this -> load -> model('summercamp_model');
		$this -> address_model -> setLogger($this -> Logger);
		$this -> colonist_model -> setLogger($this -> Logger);
		$this -> generic_model -> setLogger($this -> Logger);
		$this -> person_model -> setLogger($this -> Logger);
		$this -> summercamp_model -> setLogger($this -> Logger);
	}
	
	public function index(){
		$this -> Logger -> info("Starting " . __METHOD__);
		$data["summerCamps"] = $this->summercamp_model->getAvailableSummerCamps();
		$data["summerCampInscriptions"] = $this->summercamp_model->getSummerCampSubscriptionsOfUser($this -> session -> userdata("user_id"));
		$this -> loadView('summercamps/index', $data);	
	}
	
	public function subscribeColonist(){
		$this -> Logger -> info("Starting " . __METHOD__);
		$id = $this -> input -> get('id', TRUE);
		$data["summerCamp"] = $this->summercamp_model->getSummerCampById($id);
		$data["id"] = $id;
		$this -> loadView('summercamps/subscribeColonist', $data);	
	}
	
	public function completeSubscription(){
		$this->Logger->info("Starting " . __METHOD__);

        $fullname = $this -> input -> post('fullname',TRUE);;
        $gender = $this -> input -> post('gender',TRUE);
        $street = $this -> input -> post('street',TRUE);
        $number = $this -> input -> post('number',TRUE);
        $city = $this -> input -> post('city',TRUE);
        $phone1 = $this -> input -> post('phone1',TRUE);
        $phone2 = $this -> input -> post('phone2',TRUE);
        $cep = $this -> input -> post('cep',TRUE);
        $occupation = $this -> input -> post('occupation',TRUE);
        $complement = $this -> input -> post('complement',TRUE);
        $neighborhood = $this -> input -> post('neighborhood',TRUE);
        $uf = $this -> input -> post('uf',TRUE);
		$birthdate = $this -> input -> post('birthdate',TRUE);
		$school = $this -> input -> post('school',TRUE);
		$schoolYear = $this -> input -> post('schoolYear',TRUE);
		$documentType = $this -> input -> post('documentType',TRUE);
		$documentNumber = $this -> input -> post('documentNumber',TRUE);
		$sameAddressResponsable = $this -> input -> post('sameAddressResponsable',TRUE);
		$summerCampId = $this -> input -> post('summerCampId',TRUE);
		$responsableId = $this -> session -> userdata("user_id");

        try {
            $this->Logger->info("Inserting new colony subscription");
            //Inicia transação no banco
            $this->generic_model->startTransaction();

            //Faz todo o processo que tem que ser feito no banco
            if($sameAddressResponsable === "s"){
				$addressId = $this->address_model->getAddressByPersonId($responsableId)->getAddressId();
			}
			else
	            $addressId = $this->address_model->insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf);
	        $personId = $this->person_model->insertNewPerson($fullname, $gender, NULL, $addressId);
            $colonistId = $this->colonist_model->insertColonist($personId, $birthdate, $documentNumber, $documentType);
			$this->summercamp_model->subscribeColonist($summerCampId, $colonistId, $responsableId, SUBSCRIPTION_STATUS_PRE_SUBSCRIPTION_INCOMPLETE, $school, $schoolYear);
			
			if($phone1)
	            $this->telephone_model->insertNewTelephone($phone1, $personId);
            if ($phone2)
                $this->telephone_model->insertNewTelephone($phone2, $personId);

            //Caso tenha ocorrido tudo bem, salva as mudanças
            $this->generic_model->commitTransaction();

//            $this->Logger->info("New user successfully inserted");
//            $this->Logger->info("Saving data in session");

//            $this->sendSignupEmail($person);

            redirect("summercamps/index");
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new user");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            $this->loadView('login/signup', $data);
        }
	}
	
	

}
?>