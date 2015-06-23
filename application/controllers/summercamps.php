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
		$this -> load -> model('telephone_model');
		$this -> address_model -> setLogger($this -> Logger);
		$this -> colonist_model -> setLogger($this -> Logger);
		$this -> generic_model -> setLogger($this -> Logger);
		$this -> person_model -> setLogger($this -> Logger);
		$this -> summercamp_model -> setLogger($this -> Logger);
		$this -> telephone_model -> setLogger($this -> Logger);
	}

	public function index() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$data["summerCamps"] = $this -> summercamp_model -> getAvailableSummerCamps();
		$data["summerCampInscriptions"] = $this -> summercamp_model -> getSummerCampSubscriptionsOfUser($this -> session -> userdata("user_id"));
		$this -> loadView('summercamps/index', $data);
	}

	public function subscribeColonist() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$id = $this -> input -> get('id', TRUE);
		$data["summerCamp"] = $this -> summercamp_model -> getSummerCampById($id);
		$data["id"] = $id;
		$this -> loadView('summercamps/subscribeColonist', $data);
	}

	public function editSubscriptionColonist(){
		$this -> Logger -> info("Starting " . __METHOD__);
		$colonistId = $this -> input -> get('colonistId', TRUE);
		$summerCampId = $this -> input -> get('summerCampId', TRUE);
		$camper = $this -> summercamp_model -> getSummerCampSubscription($colonistId,$summerCampId);
		$data["summerCamp"] = $this -> summercamp_model -> getSummerCampById($summerCampId);
		$data["id"] = $summerCampId;
		$data["fullName"] = $camper->getFullName();
		$data["Gender"] = $camper->getGender();
		$data["birthdate"] = date("d-m-Y", strtotime($camper->getBirthDate()));
		$data["school"] = $camper->getSchool();
		$data["schoolYear"] = $camper->getSchoolYear();
		$data["documentNumber"] = $camper->getDocumentNumber();
		$data["documentType"] = $camper->getDocumentType();
		$data["phone1"] = $camper->getDocumentType();
		$data["phone2"] = $camper->getDocumentType();
		$data["street"] = $camper->getDocumentType();
		$data["number"] = $camper->getDocumentType();
		$data["city"] = $camper->getDocumentType();
		$data["cep"] = $camper->getDocumentType();
				
		$this -> loadView('summercamps/editSubscriptionColonist', $data);
		
	}

	public function completeSubscription() {
		$this -> Logger -> info("Starting " . __METHOD__);

		$fullname = $this -> input -> post('fullname', TRUE);
		$gender = $this -> input -> post('gender', TRUE);
		$street = $this -> input -> post('street', TRUE);
		$number = $this -> input -> post('number', TRUE);
		$city = $this -> input -> post('city', TRUE);
		$phone1 = $this -> input -> post('phone1', TRUE);
		$phone2 = $this -> input -> post('phone2', TRUE);
		$cep = $this -> input -> post('cep', TRUE);
		$occupation = $this -> input -> post('occupation', TRUE);
		$complement = $this -> input -> post('complement', TRUE);
		$neighborhood = $this -> input -> post('neighborhood', TRUE);
		$uf = $this -> input -> post('uf', TRUE);
		$birthdate = $this -> input -> post('birthdate', TRUE);
		$school = $this -> input -> post('school', TRUE);
		$schoolYear = $this -> input -> post('schoolYear', TRUE);
		$documentType = $this -> input -> post('documentType', TRUE);
		$documentNumber = $this -> input -> post('documentNumber', TRUE);
		$sameAddressResponsable = $this -> input -> post('sameAddressResponsable', TRUE);
		$summerCampId = $this -> input -> post('summerCampId', TRUE);
		$responsableDadMother = $this -> input -> post('responsableDadMother', TRUE);
		$dadDeclare = $this -> input -> post('dadDeclare', TRUE);
		$dadFullName = $this -> input -> post('dadFullName', TRUE);
		$dadPhone = $this -> input -> post('dadPhone', TRUE);
		$dadEmail = $this -> input -> post('dadEmail', TRUE);
		$motherDeclare = $this -> input -> post('motherDeclare', TRUE);
		$motherFullName = $this -> input -> post('motherFullName', TRUE);
		$motherPhone = $this -> input -> post('motherPhone', TRUE);
		$motherEmail = $this -> input -> post('motherEmail', TRUE);

		$responsableId = $this -> session -> userdata("user_id");

		try {
			$this -> Logger -> info("Inserting new colony subscription");
			//Inicia transação no banco
			$this -> generic_model -> startTransaction();

			//Faz todo o processo que tem que ser feito no banco
			if ($sameAddressResponsable === "s") {
				$addressId = $this -> address_model -> getAddressByPersonId($responsableId) -> getAddressId();
			} else
				$addressId = $this -> address_model -> insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf);
			$personId = $this -> person_model -> insertNewPerson($fullname, $gender, NULL, $addressId);
			$colonistId = $this -> colonist_model -> insertColonist($personId, $birthdate, $documentNumber, $documentType);
			$this -> summercamp_model -> subscribeColonist($summerCampId, $colonistId, $responsableId, SUBSCRIPTION_STATUS_PRE_SUBSCRIPTION_INCOMPLETE, $school, $schoolYear);

			if ($phone1)
				$this -> telephone_model -> insertNewTelephone($phone1, $personId);
			if ($phone2)
				$this -> telephone_model -> insertNewTelephone($phone2, $personId);

			$dadId = 0;
			$motherId = 0;

			if ($responsableDadMother === "dad") {
				$dadId = $responsableId;
			} else if ($responsableDadMother === "mother") {
				$motherId = $responsableId;
			}

			if ($dadId == 0 && !$dadDeclare && $dadFullName && $dadEmail && $dadPhone) {
				$this -> Logger -> info("Inserting dad for colonist $colonistId in summercamp $summerCampId");
				$dadId = $this -> person_model -> insertParent($dadFullName, "M", $dadEmail);
				$this -> telephone_model -> insertNewTelephone($dadPhone, $dadId);
			}

			if ($motherId == 0 && !$motherDeclare && $motherFullName && $motherEmail && $motherPhone) {
				$this -> Logger -> info("Inserting Mom for colonist $colonistId in summercamp $summerCampId");
				$motherId = $this -> person_model -> insertParent($motherFullName, "F", $motherEmail);
				$this -> telephone_model -> insertNewTelephone($motherPhone, $motherId);
			}

			if ($dadId != 0) {
				$this -> summercamp_model -> addParentToSummerCampSubscripted($summerCampId, $colonistId, $dadId, "Pai");
			}

			if ($motherId != 0) {
				$this -> summercamp_model -> addParentToSummerCampSubscripted($summerCampId, $colonistId, $motherId, "Mãe");
			}

			//Caso tenha ocorrido tudo bem, salva as mudanças
			$this -> generic_model -> commitTransaction();

			//            $this->Logger->info("New user successfully inserted");
			//            $this->Logger->info("Saving data in session");

			//            $this->sendSignupEmail($person);

			redirect("summercamps/index");
		} catch (Exception $ex) {
			$this -> Logger -> error("Failed to insert new user");
			$this -> generic_model -> rollbackTransaction();
			$data['error'] = true;
			$this -> loadView('login/signup', $data);
		}
	}

	public function uploadDocument() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$data["camp_id"] = $this -> input -> get('camp_id', TRUE);
		$data["colonist_id"] = $this -> input -> get('colonist_id', TRUE);
		$this -> loadView('summercamps/uploadDocument', $data);
	}

	public function verifyDocument() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$camp_id = $this -> input -> get('camp_id', TRUE);
		$colonist_id = $this -> input -> get('colonist_id', TRUE);
		$document_type = $this -> input -> get('document_type', TRUE);
		$document_type = "1";
		$document = $this -> summercamp_model -> getNewestDocument($camp_id, $colonist_id, $document_type);
		$this -> load -> helper('download');
		if ($document)
			force_download($document["name"], pg_unescape_bytea($document["data"]));
		else {
			//Adicionar tratamento de erro
			echo "<script>alert('erro');</script>";
			redirect("summercamps/index");
		}
	}

	public function saveDocument() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$camp_id = $this -> input -> post('camp_id', TRUE);
		$colonist_id = $this -> input -> post('colonist_id', TRUE);
		var_dump($_FILES);
		$fileName = $_FILES['uploadedfile']['name'];
		$file = file_get_contents($_FILES['uploadedfile']['tmp_name']);
		$userId = $this -> session -> userdata("user_id");
		if (!$this -> summercamp_model -> uploadDocument($camp_id, $colonist_id, $userId, $fileName, $file, 1))
			//Adicionar tratamento de erro
			echo "<script>alert('erro');</script>";
		redirect("summercamps/index");

	}

}
?>