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
		$this -> load -> model('medical_file_model');
		$this -> load -> model('person_model');
		$this -> load -> model('personuser_model');
		$this -> load -> model('summercamp_model');
		$this -> load -> model('telephone_model');
		$this -> load -> model('validation_model');
		$this -> address_model -> setLogger($this -> Logger);
		$this -> colonist_model -> setLogger($this -> Logger);
		$this -> generic_model -> setLogger($this -> Logger);
		$this -> medical_file_model -> setLogger($this -> Logger);
		$this -> person_model -> setLogger($this -> Logger);
		$this -> personuser_model -> setLogger($this -> Logger);
		$this -> summercamp_model -> setLogger($this -> Logger);
		$this -> telephone_model -> setLogger($this -> Logger);
		$this -> validation_model -> setLogger($this -> Logger);
	}

	public function index() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$isAssociate = $this -> personuser_model -> isAssociate($this -> session -> userdata("user_id"));
		$data["summerCamps"] = $this -> summercamp_model -> getAvailableSummerCamps($isAssociate);
		$data["summerCampInscriptions"] = $this -> summercamp_model -> getSummerCampSubscriptionsOfUser($this -> session -> userdata("user_id"));
		$data["summercamp_model"] = $this -> summercamp_model;
		$rawStatusArray = $this -> summercamp_model -> getStatusArray();
		$statusArray = array();
		foreach ($rawStatusArray as $status) {
			switch($status["database_id"]) {
				case 0 :
				case 1 :
					$statusArray[$status["database_id"]] = $status;
					break;
				case 2 :
				case 3 :
				case 4 :
				case 5 :
					$statusArray[$status["database_id"] + 1] = $status;
					break;
				case 6 :
					$statusArray[2] = $status;
				case -1 :
				case -2 :
				case -3 :
					$statusArray[6 - $status["database_id"]] = $status;
					break;
			}
		}
		$data["statusArray"] = $statusArray;
		$this -> loadView('summercamps/index', $data);
	}

	public function subscribeColonist() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$id = $this -> input -> get('id', TRUE);
		$data["summerCamp"] = $this -> summercamp_model -> getSummerCampById($id);
		$data["id"] = $id;
		$this -> loadView('summercamps/subscribeColonist', $data);
	}

	public function editSubscriptionColonistForm() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$colonistId = $this -> input -> get('colonistId', TRUE);
		$summerCampId = $this -> input -> get('summerCampId', TRUE);
		$camper = $this -> summercamp_model -> getSummerCampSubscription($colonistId, $summerCampId);
		$address = $this -> address_model -> getAddressByPersonId($camper -> getPersonId());
		$responsableId = $this -> session -> userdata("user_id");
		$responsableAddress = $this -> address_model -> getAddressByPersonId($responsableId);
		$data["sameAddressResponsable"] = "n";
		if ($responsableAddress)
			if ($address -> getAddressId() == $responsableAddress -> getAddressId())
				$data["sameAddressResponsable"] = "s";
		$data["summerCamp"] = $this -> summercamp_model -> getSummerCampById($summerCampId);
		$data["summerCampId"] = $summerCampId;
		$data["colonistId"] = $colonistId;
		$data["personId"] = $camper -> getPersonId();
		$data["fullName"] = $camper -> getFullName();
		$data["Gender"] = $camper -> getGender();
		$data["birthdate"] = date("d-m-Y", strtotime($camper -> getBirthDate()));
		$data["school"] = $camper -> getSchool();
		$data["schoolYear"] = $camper -> getSchoolYear();
		$data["documentNumber"] = $camper -> getDocumentNumber();
		$data["documentType"] = $camper -> getDocumentType();
		$data["phone1"] = $camper -> getDocumentType();
		$data["phone2"] = $camper -> getDocumentType();
		$data["street"] = $address -> getStreet();
		$data["number"] = $address -> getPlaceNumber();
		$data["city"] = $address -> getCity();
		$data["cep"] = $address -> getCEP();
		$data["complement"] = $address -> getComplement();
		$data["neighborhood"] = $address -> getNeighborhood();
		$data["uf"] = $address -> getUf();
		$telephones = $this -> telephone_model -> getTelephonesByPersonId($camper -> getPersonId());
		$data["phone1"] = isset($telephones[0]) ? $telephones[0] : FALSE;
		$data["phone2"] = isset($telephones[1]) ? $telephones[1] : FALSE;
		$father = $this -> summercamp_model -> getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
		$mother = $this -> summercamp_model -> getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");
		$data["dad"] = "";
		if ($father) {
			$data["dad"] = $father;
			if ($father == $responsableId)
				$data["responsableDadMother"] = "dad";
			$father = $this -> person_model -> getPersonFullById($father);
			$data["dadFullName"] = $father -> fullname;
			$data["dadEmail"] = $father -> email;
			$data["dadPhone"] = $father -> phone1;
		}
		$data["mother"] = "";
		if ($mother) {
			$data["mother"] = $mother;
			if ($mother == $responsableId)
				$data["responsableDadMother"] = "mother";
			$mother = $this -> person_model -> getPersonFullById($mother);
			$data["motherFullName"] = $mother -> fullname;
			$data["motherEmail"] = $mother -> email;
			$data["motherPhone"] = $mother -> phone1;
		}
		$this -> loadView('summercamps/editSubscriptionColonistForm', $data);

	}

	public function editSubscriptionColonist() {
		$this -> Logger -> info("Starting " . __METHOD__);

		$colonistId = $this -> input -> post('colonistId', TRUE);
		$summerCampId = $this -> input -> post('summerCampId', TRUE);
		$personId = $this -> input -> post('personId', TRUE);
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
		$dad = $this -> input -> post('dad', TRUE);
		$dadDeclare = $this -> input -> post('dadDeclare', TRUE);
		$dadFullName = $this -> input -> post('dadFullName', TRUE);
		$dadPhone = $this -> input -> post('dadPhone', TRUE);
		$dadEmail = $this -> input -> post('dadEmail', TRUE);
		$mother = $this -> input -> post('mother', TRUE);
		$motherDeclare = $this -> input -> post('motherDeclare', TRUE);
		$motherFullName = $this -> input -> post('motherFullName', TRUE);
		$motherPhone = $this -> input -> post('motherPhone', TRUE);
		$motherEmail = $this -> input -> post('motherEmail', TRUE);
		$responsableId = $this -> session -> userdata("user_id");

		try {
			$this -> Logger -> info("Editing colonist $summerCampId");
			//Inicia transação no banco
			$this -> generic_model -> startTransaction();

			//Faz todo o processo que tem que ser feito no banco
			if ($sameAddressResponsable === "s") {
				$addressId = $this -> address_model -> getAddressByPersonId($responsableId) -> getAddressId();
			} else
				$addressId = $this -> address_model -> insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf);
			$this -> person_model -> updatePerson($fullname, $gender, NULL, $personId, $addressId);
			$this -> colonist_model -> updateColonist($personId, $birthdate, $documentNumber, $documentType, $colonistId);
			if ($school[0] == -1) {
				if ($school[1] != -1) {//So evitando que alguem tente inserir uma escola com nome -1 o que poderia quebrar o nosso sistema...
					$school = $school[1];
					$this -> summercamp_model -> insertSchool($school);
				}
			} else {
				$school = $school[0];
			}
			$this -> summercamp_model -> editColonistSubscription($summerCampId, $colonistId, $school, $schoolYear);

			if ($phone1 || $phone2)
				$this -> telephone_model -> updatePhone($personId, $phone1, $personId);

			$dadId = 0;
			$motherId = 0;

			if ($responsableDadMother === "dad") {
				$dadId = $responsableId;
			} else if ($responsableDadMother === "mother") {
				$motherId = $responsableId;
			}

			$this -> summercamp_model -> removeParentFromSummerCampSubscripted($summerCampId, $colonistId, "Pai");
			$this -> summercamp_model -> removeParentFromSummerCampSubscripted($summerCampId, $colonistId, "Mãe");

			if ($dadId == 0 && !$dadDeclare && $dadFullName && $dadEmail && $dadPhone) {
				$this -> Logger -> info("Inserting dad for colonist $colonistId in summercamp $summerCampId");
				$dadId = $this -> person_model -> insertPersonWithoutAddress($dadFullName, "M", $dadEmail);
				$this -> telephone_model -> insertNewTelephone($dadPhone, $dadId);
			}

			if ($motherId == 0 && !$motherDeclare && $motherFullName && $motherEmail && $motherPhone) {
				$this -> Logger -> info("Inserting Mom for colonist $colonistId in summercamp $summerCampId");
				$motherId = $this -> person_model -> insertPersonWithoutAddress($motherFullName, "F", $motherEmail);
				$this -> telephone_model -> insertNewTelephone($motherPhone, $motherId);
			}

			if ($dadId != 0) {
				$this -> summercamp_model -> addParentToSummerCampSubscripted($summerCampId, $colonistId, $dadId, "Pai");
			}

			if ($motherId != 0) {
				$this -> summercamp_model -> addParentToSummerCampSubscripted($summerCampId, $colonistId, $motherId, "Mãe");
			}

			$this -> validation_model -> sentNewSubscription($colonistId, $summerCampId);

			//Caso tenha ocorrido tudo bem, salva as mudanças
			$this -> generic_model -> commitTransaction();

			$this -> Logger -> info("Colonist sucessfully edited");

			redirect("summercamps/index");
		} catch (Exception $ex) {
			$this -> Logger -> error("Failed to edit colonist subscription");
			$this -> generic_model -> rollbackTransaction();
			$data['error'] = true;
			redirect("summercamps/editSubscriptionColonistForm?colonistId=$colonistId&summerCampId=$summerCampId");
		}
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
			if ($school[0] == -1) {
				if ($school[1] != -1) {//So evitando que alguem tente inserir uma escola com nome -1 o que poderia quebrar o nosso sistema...
					$school = $school[1];
					$this -> summercamp_model -> insertSchool($school);
				}
			} else {
				$school = $school[0];
			}
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
				$dadId = $this -> person_model -> insertPersonWithoutAddress($dadFullName, "M", $dadEmail);
				$this -> telephone_model -> insertNewTelephone($dadPhone, $dadId);
			}

			if ($motherId == 0 && !$motherDeclare && $motherFullName && $motherEmail && $motherPhone) {
				$this -> Logger -> info("Inserting Mom for colonist $colonistId in summercamp $summerCampId");
				$motherId = $this -> person_model -> insertPersonWithoutAddress($motherFullName, "F", $motherEmail);
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

			$this -> Logger -> info("New colonist successfully inserted");

			redirect("summercamps/index");
		} catch (Exception $ex) {
			$this -> Logger -> error("Failed to insert new colonist");
			$this -> generic_model -> rollbackTransaction();
			$data['error'] = true;
			redirect("summercamps/index");
		}
	}

	public function deleteColonist() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$campId = $this -> input -> get('camp_id', TRUE);
		$colonistId = $this -> input -> get('colonist_id', TRUE);
		$camper = $this -> summercamp_model -> getSummerCampSubscription($colonistId, $campId);
		$personUserId = $camper -> getPersonUserId();
		$responsableId = $this -> session -> userdata("user_id");

		if ($personUserId !== $responsableId) {
			$this -> Logger -> error("Responsavel de id $responsableId tentou deletar o colonista $colonistId da campanha $campId que pertence ao responsavel $personUserId");
			$this -> index();
		} else {
			$this -> summercamp_model -> updateColonistStatus($colonistId, $campId, SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP);
			$this -> index();
		}
	}

	public function uploadDocument() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$data["camp_id"] = $this -> input -> get('camp_id', TRUE);
		$data["colonist_id"] = $this -> input -> get('colonist_id', TRUE);
		$data["document_type"] = $this -> input -> get('document_type', TRUE);
		$camper = $this -> summercamp_model -> getSummerCampSubscription($data["colonist_id"], $data["camp_id"]);
		$validation = $this -> validation_model -> getColonistValidationInfoObject($data["colonist_id"], $data["camp_id"]);
		if ($camper -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN || ($camper -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS && $validation && !$validation -> verifyDocument($data["document_type"]))) {
			$data["editable"] = TRUE;
			if ($validation && !$validation -> verifyDocument($data["document_type"]))
				$data["extra"] = $validation -> getDocumentData($data["document_type"]);
		} else
			$data["editable"] = FALSE;
		$data["document_name"] = FALSE;
		if ($data["document_type"] == DOCUMENT_MEDICAL_FILE)
			$data["document_name"] = "Ficha médica";
		else if ($data["document_type"] == DOCUMENT_IDENTIFICATION_DOCUMENT)
			$data["document_name"] = "Documento de identificação";
		else if ($data["document_type"] == DOCUMENT_GENERAL_RULES)
			$data["document_name"] = "Normas gerais";
		else if ($data["document_type"] == DOCUMENT_PHOTO_3X4)
			$data["document_name"] = "Foto 3x4";
		else if ($data["document_type"] == DOCUMENT_TRIP_AUTHORIZATION)
			$data["document_name"] = "Autorização de viagem";
		$data["hasDocument"] = "";
		if (!$this -> summercamp_model -> hasDocument($data["camp_id"], $data["colonist_id"], $data["document_type"]))
			$data["hasDocument"] = "disabled";
		if ($data["document_type"] == DOCUMENT_MEDICAL_FILE)
			$this -> loadView('summercamps/medicalFile', $data);
		else if ($data["document_type"] == DOCUMENT_GENERAL_RULES) {
			$data["summercamp"] = $this -> summercamp_model -> getSummerCampById($data["camp_id"]);
			$this -> loadView('summercamps/generalRules', $data);
		} else if ($data["document_type"] == DOCUMENT_TRIP_AUTHORIZATION) {
			$data["day"] = date('d');
			$data["month"] = date('m');
			$data["year"] = date('Y');

			$this -> loadView('summercamps/tripAuthorization', $data);
		} else
			$this -> loadView('summercamps/uploadDocument', $data);
	}

	public function verifyDocument() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$camp_id = $this -> input -> get('camp_id', TRUE);
		$colonist_id = $this -> input -> get('colonist_id', TRUE);
		$document_type = $this -> input -> get('document_type', TRUE);
		$document = $this -> summercamp_model -> getNewestDocument($camp_id, $colonist_id, $document_type);
		$this -> load -> helper('download');
		if ($document)
			force_download($document["name"], pg_unescape_bytea($document["data"]));
		else {
			echo "<script>alert('Erro ao tentar fazer download do arquivo, verifique se o arquivo ja foi enviado e tente novamente mais tarde');
			window.location.replace('" . $this -> config -> item('url_link') . "summercamps/uploadDocument?camp_id=$camp_id&colonist_id=$colonist_id&document_type=$document_type');</script>";
		}
	}

	public function saveDocument() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$camp_id = $this -> input -> post('camp_id', TRUE);
		$colonist_id = $this -> input -> post('colonist_id', TRUE);
		$document_type = $this -> input -> post('document_type', TRUE);
		$fileName = $_FILES['uploadedfile']['name'];
		if (isset($_FILES['uploadedfile']['tmp_name']) && !empty($_FILES['uploadedfile']['tmp_name']))
			$file = file_get_contents($_FILES['uploadedfile']['tmp_name']);
		$userId = $this -> session -> userdata("user_id");
		if ($_FILES['uploadedfile']['error'] > 0 || !$this -> summercamp_model -> uploadDocument($camp_id, $colonist_id, $userId, $fileName, $file, $document_type)) {
			echo "<script>alert('Erro ao enviar documento, verifique se ele se adequa as regras de envio e tente novamente'); window.location.replace('" . $this -> config -> item('url_link') . "summercamps/uploadDocument?camp_id=$camp_id&colonist_id=$colonist_id&document_type=$document_type');</script>";
		} else {
			$this -> validation_model -> sentNewDocument($colonist_id, $camp_id, $document_type);
			echo "<script>alert('Documento enviado com sucesso.'); window.location.replace('" . $this -> config -> item('url_link') . "summercamps/index');</script>";
		}
	}

	public function sendPreSubscription() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$camp_id = $this -> input -> get('camp_id', TRUE);
		$colonist_id = $this -> input -> get('colonist_id', TRUE);
		$documents = $this -> input -> get('documents', TRUE);
		$summerCampSubscription = $this -> summercamp_model -> getSummerCampSubscription($colonist_id, $camp_id);
		if ($summerCampSubscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS || $summerCampSubscription -> getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN) {
			if ($documents == 6) {
				$this -> summercamp_model -> updateColonistStatus($colonist_id, $camp_id, SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION);
				echo "<script>alert('Envio realizado com sucesso'); window.location.replace('" . $this -> config -> item('url_link') . "summercamps/index');</script>";
			} else
				echo "<script>alert('O cadastro e os anexos devem ter o OK para poder enviar.'); window.location.replace('" . $this -> config -> item('url_link') . "summercamps/index');</script>";
		} else {
			echo "<script>alert('O status " . utf8_decode($summerCampSubscription -> getSituation()) . utf8_decode(" não") . " permite envio'); window.location.replace('" . $this -> config -> item('url_link') . "summercamps/index');</script>";
		}
	}

	public function acceptGeneralRules() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$camp_id = $this -> input -> post('camp_id', TRUE);
		$colonist_id = $this -> input -> post('colonist_id', TRUE);
		$this -> summercamp_model -> acceptGeneralRules($camp_id, $colonist_id);
		$this -> index();
	}

	public function acceptTripAuthorization() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$camp_id = $this -> input -> post('camp_id', TRUE);
		$colonist_id = $this -> input -> post('colonist_id', TRUE);
		$this -> summercamp_model -> updateTripAuthorization($camp_id, $colonist_id, 't');
		$this -> index();
	}

	public function rejectTripAuthorization() {
		$camp_id = $this -> input -> post('camp_id', TRUE);
		$colonist_id = $this -> input -> post('colonist_id', TRUE);
		$this -> summercamp_model -> updateTripAuthorization($camp_id, $colonist_id, 'f');
		$this -> index();
	}

	public function viewColonistInfo() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$colonistId = $this -> input -> get('colonistId', TRUE);
		$summerCampId = $this -> input -> get('summerCampId', TRUE);
		$camper = $this -> summercamp_model -> getSummerCampSubscription($colonistId, $summerCampId);
		$address = $this -> address_model -> getAddressByPersonId($camper -> getPersonId());
		$responsableId = $camper -> getPersonUserId();
		$responsableAddress = $this -> address_model -> getAddressByPersonId($responsableId);
		$data["sameAddressResponsable"] = "n";
		if ($responsableAddress)
			if ($address -> getAddressId() == $responsableAddress -> getAddressId())
				$data["sameAddressResponsable"] = "s";
		$data["summerCamp"] = $this -> summercamp_model -> getSummerCampById($summerCampId);
		$data["id"] = $summerCampId;
		$data["fullName"] = $camper -> getFullName();
		$data["Gender"] = $camper -> getGender();
		$data["birthdate"] = date("d-m-Y", strtotime($camper -> getBirthDate()));
		$data["school"] = $camper -> getSchool();
		$data["schoolYear"] = $camper -> getSchoolYear();
		$data["documentNumber"] = $camper -> getDocumentNumber();
		$data["documentType"] = $camper -> getDocumentType();
		$data["phone1"] = $camper -> getDocumentType();
		$data["phone2"] = $camper -> getDocumentType();
		$data["street"] = $address -> getStreet();
		$data["number"] = $address -> getPlaceNumber();
		$data["city"] = $address -> getCity();
		$data["cep"] = $address -> getCEP();
		$data["complement"] = $address -> getComplement();
		$data["neighborhood"] = $address -> getNeighborhood();
		$data["uf"] = $address -> getUf();
		$telephones = $this -> telephone_model -> getTelephonesByPersonId($camper -> getPersonId());
		$data["phone1"] = isset($telephones[0]) ? $telephones[0] : FALSE;
		$data["phone2"] = isset($telephones[1]) ? $telephones[1] : FALSE;
		$father = $this -> summercamp_model -> getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
		$mother = $this -> summercamp_model -> getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");
		if ($father) {
			if ($father == $responsableId)
				$data["responsableDadMother"] = "dad";
			$father = $this -> person_model -> getPersonFullById($father);
			$data["dadFullName"] = $father -> fullname;
			$data["dadEmail"] = $father -> email;
			$data["dadPhone"] = $father -> phone1;
		}
		if ($mother) {
			if ($mother == $responsableId)
				$data["responsableDadMother"] = "mother";
			$mother = $this -> person_model -> getPersonFullById($mother);
			$data["motherFullName"] = $mother -> fullname;
			$data["motherEmail"] = $mother -> email;
			$data["motherPhone"] = $mother -> phone1;
		}
		$this -> loadView('summercamps/viewColonistInfo', $data);

	}

	public function submitMedicalFile() {
		$responsability = $this -> input -> post('responsability', TRUE);
		if (!$responsability) {
			echo "<script>alert('Por favor valide a veracidade dos dados.');history.go(-1);</script>";
			return;
		}
		$campId = $this -> input -> post('camp_id', TRUE);
		$colonistId = $this -> input -> post('colonist_id', TRUE);
		$bloodType = $this -> input -> post('bloodType', TRUE);
		$rh = $this -> input -> post('rh', TRUE);
		$weight = $this -> input -> post('weight', TRUE);
		$height = $this -> input -> post('height', TRUE);

		if ($this -> input -> post('physicalrestrictions_radio', TRUE))
			$physicalActivityRestriction = $this -> input -> post('physicalrestrictions_text', TRUE);
		else
			$physicalActivityRestriction = NULL;

		if ($this -> input -> post('antecedents_radio', TRUE))
			$infectoContagiousAntecedents = $this -> input -> post('antecedents_text', TRUE);
		else
			$infectoContagiousAntecedents = NULL;

		if ($this -> input -> post('habitualmedicine_radio', TRUE))
			$regularUseMedicine = $this -> input -> post('habitualmedicine_text', TRUE);
		else
			$regularUseMedicine = NULL;

		if ($this -> input -> post('medicinerestrictions_radio', TRUE))
			$medicineRestrictions = $this -> input -> post('medicinerestrictions_text', TRUE);
		else
			$medicineRestrictions = NULL;

		if ($this -> input -> post('allergies_radio', TRUE))
			$allergies = $this -> input -> post('allergies_text', TRUE);
		else
			$allergies = NULL;

		if ($this -> input -> post('analgesicantipyretic_radio', TRUE))
			$analgesicAntipyretic = $this -> input -> post('analgesicantipyretic_text', TRUE);
		else
			$analgesicAntipyretic = NULL;

		$doctorName = $this -> input -> post('doctor_name', TRUE);
		$doctorMail = $this -> input -> post('doctor_email', TRUE);
		$doctorPhone1 = $this -> input -> post('doctor_phone1', TRUE);
		$doctorPhone2 = $this -> input -> post('doctor_phone2', TRUE);
		if ($doctorMail && $doctorMail === "")
			$doctorMail = NULL;

		$doctorId = $this -> person_model -> insertPersonWithoutAddress($doctorName, NULL, $doctorMail);
		$this -> telephone_model -> insertNewTelephone($doctorPhone1, $doctorId);

		if ($doctorPhone2 && $doctorPhone2 !== "")
			$this -> telephone_model -> insertNewTelephone($doctorPhone2, $doctorId);

		$vacineTetanus = $this -> input -> post('antiTetanus', TRUE);
		$vacineMMR = $this -> input -> post('MMR', TRUE);
		$vacineHepatitis = $this -> input -> post('vacineHepatitis', TRUE);

		if ($this -> medical_file_model -> insertNewMedicalFile($campId, $colonistId, $bloodType, $rh, $weight, $height, $physicalActivityRestriction, $vacineTetanus, $vacineMMR, $vacineHepatitis, $infectoContagiousAntecedents, $regularUseMedicine, $medicineRestrictions, $allergies, $analgesicAntipyretic, $doctorId))

			echo "<script>alert('Ficha medica enviada com sucesso.'); window.location.replace('" . $this -> config -> item('url_link') . "summercamps/index');</script>";

	}

}
?>
