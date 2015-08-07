<?php

require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/summercamp.php';
require_once APPPATH . 'core/summercampSubscription.php';
require_once APPPATH . 'core/colonist.php';

class Admin extends CK_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> model('person_model');
		$this -> load -> model('personuser_model');
		$this -> load -> model('summercamp_model');
		$this -> load -> model('colonist_model');
		$this -> load -> model('address_model');
		$this -> load -> model('telephone_model');
		$this -> load -> model('donation_model');
		$this -> load -> model('generic_model');
		$this -> load -> model('validation_model');
		$this -> load -> model('email_model');
		$this -> person_model -> setLogger($this -> Logger);
		$this -> personuser_model -> setLogger($this -> Logger);
		$this -> summercamp_model -> setLogger($this -> Logger);
		$this -> colonist_model -> setLogger($this -> Logger);
		$this -> address_model -> setLogger($this -> Logger);
		$this -> telephone_model -> setLogger($this -> Logger);
		$this -> donation_model -> setLogger($this -> Logger);
		$this -> generic_model -> setLogger($this -> Logger);
		$this -> validation_model -> setLogger($this -> Logger);
		$this -> email_model -> setLogger($this -> Logger);
	}

	public function camp() {
		$this->loadView("admin/camps/camp_admin_container");
	}

	public function manageCamps() {
		$data['camps'] = $this -> summercamp_model -> getAllSummerCamps();
		$this -> loadReportView("admin/camps/manage_camps", $data);
	}

	public function createCamp() {
		$this -> loadView("admin/camps/insert_camp");
	}
	
	public function queue() {
		$data = array();
		$years = array();
		$start = 2015;
		$date=date('Y');
		$campsByYear = $this -> summercamp_model -> getAllSummerCampsByYear($date);
		while($campsByYear!=null)
		{
			$end = $date;
			$date++;
			$campsByYear = $this -> summercamp_model -> getAllSummerCampsByYear($date);
		}
		while ($start <= $end) {
			$years[] = $start;
			$start++;
		}
		$year = null;
	
		if (isset($_GET['ano_f']))
			$year = $_GET['ano_f'];
		else {
			$year = date('Y');
		}
	
		$data['ano_escolhido'] = $year;
		$data['years'] = $years;
	
		$campChosen = 0;
		$camps = array(0 => "Colônia Verão", 1 => "Mini Kinderland");
	
		if (isset($_GET['colonia_f']))
			$campChosen = $_GET['colonia_f'];
	
		$data['colonia_escolhida'] = $campChosen;
		$data['camps'] = $camps;
	
		$miniCamp = $campChosen;
	
		$statusCamps = $this -> summercamp_model -> getMiniCampsOrNotByYear($year,$miniCamp);
	
		$campsId = array();
	
		if($statusCamps!=null) {
			foreach($statusCamps as $statusCamp) {
				$campsId[] = $statusCamp -> getCampId();
			}
		}
	
		$selected = 0;
		$opcoes = array(0 => "Sócios", 1 => "Não Sócios", 2 => "Todos");
			
		if (isset($_GET['opcao_f']))
			$selected = $_GET['opcao_f'];
	
		$data['selecionado'] = $selected;
		$data['opcoes'] = $opcoes;
	
		$people = array();
		$peopleId = array();
		$peopleFinal = array();
		$campsIdStr = "";
		if($campsId != null && count($campsId) > 0){
			$campsIdStr = $campsId[0];
			for($i = 1; $i < count($campsId); $i++)
				$campsIdStr .= "," . $campsId[$i];
		}
		$people = $this -> summercamp_model -> getAssociatedOrNotByStatusAndSummerCamp($campsIdStr, $selected);
			
		$data['people'] = $people;
		$this -> loadReportView("admin/camps/queue", $data);
	}

	public function insertNewCamp(){
		$this->Logger->info("Running: ". __METHOD__);
		$camp = new SummerCamp(null, 
						$_POST['camp_name'],
						null,
						$_POST['date_start'],
						$_POST['date_finish'],
						$_POST['date_start_pre'],
						$_POST['date_finish_pre'],
						$_POST['date_start_pre_associate'],
						$_POST['date_finish_pre_associate'],
						null, //description
						true, //preEnabled
						$_POST['capacity_male'],
						$_POST['capacity_female'],
						$_POST['mini_camp']
					);

		try{
			$this->Logger->info("Inserting new summer camp");
			$this->generic_model->startTransaction();
			
			$campId = $this->summercamp_model->insertNewCamp($camp);
			/* inserir payment periods */
			
			$this->generic_model->commitTransaction();
			$this->Logger->info("New summer camp successfully inserted");
			redirect("admin/camp");

		} catch (Exception $ex) {
			$this->Logger->error("Failed to insert new camp");
			$this->generic_model->rollbackTransaction();
			$data['error'] = true;
			$this->loadView('admin/camps/create_error', $data);
		}
	}

	public function changeCampEnabledStatus(){
		$this->Logger->info("Running: ". __METHOD__);
		$campId = $_POST['camp_id'];
		$enabled = ($_POST['status'] == "t") ? true : false;

		try{
			$this->Logger->info("Updating enabled pre-subscriptions");
			$this->generic_model->startTransaction();
			
			$campId = $this->summercamp_model->updateCampPreEnabled($campId, $enabled);
			/* inserir payment periods */
			
			$this->generic_model->commitTransaction();
			$this->Logger->info("Updated enabled pre-subscriptions");
			echo "true";

		} catch (Exception $ex) {
			$this->Logger->error("Failed to update enabled pre-subscriptions");
			$this->generic_model->rollbackTransaction();
			echo "false";
		}
	}

	public function validateColonists() {
		$this->Logger->info("Running: ". __METHOD__);
		$shownStatus =  SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION . "," . 
						SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED . "," .
						SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS;
		$data['colonists'] = $this->summercamp_model->getAllColonistsBySummerCampAndYearForValidation(date("Y"), $shownStatus);
		$this -> loadReportView("admin/camps/validate_colonists", $data);
	}

	public function updateColonistValidation() {
		$this->Logger->info("Running: ". __METHOD__);
		$colonistId = $_POST['colonist_id'];
		$summerCampId = $_POST['summer_camp_id'];

		$genderOk = (isset($_POST['gender'])) ? $_POST['gender'] : null;
		$pictureOk = (isset($_POST['picture'])) ? $_POST['picture'] : null;
		$identityOk = (isset($_POST['identity'])) ? $_POST['identity'] : null;
		$birthdayOk = (isset($_POST['birthday'])) ? $_POST['birthday'] : null;
		$parentsNameOk = (isset($_POST['parents_name'])) ? $_POST['parents_name'] : null;
		$colonistNameOk = (isset($_POST['colonist_name'])) ? $_POST['colonist_name'] : null;

		$msgGender = ($genderOk == "false") ? $_POST['msg_gender'] : "";
		$msgPicture = ($pictureOk == "false") ? $_POST['msg_picture'] : "";
		$msgIdentity = ($identityOk == "false") ? $_POST['msg_identity'] : "";
		$msgBirthdate = ($birthdayOk == "false") ? $_POST['msg_birthday'] : "";
		$msgParentsName = ($parentsNameOk == "false") ? $_POST['msg_parents_name'] : "";
		$msgColonistName = ($colonistNameOk == "false") ? $_POST['msg_colonist_name'] : "";

		$validationReturn = $this->validation_model->updateColonistValidation($colonistId, $summerCampId, 
			$genderOk, $pictureOk, $identityOk, $birthdayOk, $parentsNameOk, $colonistNameOk,
			$msgGender, $msgPicture, $msgIdentity, $msgBirthdate, $msgParentsName, $msgColonistName);
	
		if($validationReturn)
			echo "true";
		else
			echo "false";
	}

	public function confirmValidation(){
		$this->Logger->info("Running: ". __METHOD__);
		$colonistId = $_POST['colonist_id'];
		$summerCampId = $_POST['summer_camp_id'];
		$gender = $_POST['gender'];
		$picture = $_POST['picture'];
		$identity = $_POST['identity'];
		$birthday = $_POST['birthday'];
		$parentsName = $_POST['parents_name'];
		$colonistName = $_POST['colonist_name'];

		$this->Logger->info("User validating this colonist[id: ". $colonistId ."] -> User: " . $this->session->userdata("fullname") . "[user id: " . $this->session->userdata("user_id") . "]");
		$summerCampSubscription = $this->summercamp_model->getSummerCampSubscription($colonistId, $summerCampId);
        if ($summerCampSubscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN) {
        	$this->Logger->error("Cannot validate because the colonist returned to filling in status");
        	return;
        }

		$status = 0;
		if($gender == "true" && $picture == "true" && $identity == "true" && $birthday == "true" && $parentsName == "true" && $colonistName == "true")
			$status = SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED;
		else
			$status = SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS;

		$this->summercamp_model->updateColonistStatus($colonistId, $summerCampId, $status);
		if($status == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED)
			$this->sendValidatedEmail($colonistId, $summerCampId);
		else
			$this->sendNotValidatedEmail($colonistId, $summerCampId);
		echo $this->summercamp_model->getStatusDescription($status);
	}

	public function sendNotValidatedEmail($colonistId, $summerCampId){
		$this->Logger->info("Running: ". __METHOD__);

		$summercamp = $this->summercamp_model->getSummerCampById($summerCampId);
		if(!$summercamp){
			$this->Logger->error("Camp not found, cannot send an email");
			return;
		}

		$colonist = $this->colonist_model->getColonist($colonistId);
		if(!$colonist){
			$this->Logger->error("Colonist not found");
			return;
		}

		$personuser = $this->colonist_model->getColonistPersonUser($colonistId, $summerCampId);
		if(!$personuser){
			$this->Logger->error("PersonUser related to colonist not found");
			return;
		}

		$this->Logger->info("Sending email");
		
		$responsableId = $personuser->getPersonId();
		
		$father = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
        $mother = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");
		
		$emailArray = array();
		if($father && $responsableId != $father){
			$father = $this->person_model->getPersonFullById($father);
			$emailArray[] = $father->email;		
		}
		if($mother && $mother != $responsableId){
			$mother = $this->person_model->getPersonFullById($mother);
			$emailArray[] = $mother->email;
		}
		
		
		$this->sendValidationWithErrorsEmail($personuser, $colonist, $summercamp->getCampName(),$emailArray);
	}

	public function sendValidatedEmail($colonistId, $summerCampId){
		$this->Logger->info("Running: ". __METHOD__);

		$summercamp = $this->summercamp_model->getSummerCampById($summerCampId);
		if(!$summercamp){
			$this->Logger->error("Camp not found, cannot send an email");
			return;
		}

		$colonist = $this->colonist_model->getColonist($colonistId);
		if(!$colonist){
			$this->Logger->error("Colonist not found");
			return;
		}

		$personuser = $this->colonist_model->getColonistPersonUser($colonistId, $summerCampId);
		if(!$personuser){
			$this->Logger->error("PersonUser related to colonist not found");
			return;
		}

		$this->Logger->info("Sending email");
		
		$responsableId = $personuser->getPersonId();

		$father = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
        $mother = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");
		
		$emailArray = array();
		if($father && $responsableId != $father){
			$father = $this->person_model->getPersonFullById($father);
			$emailArray[] = $father->email;		
		}
		if($mother && $mother != $responsableId){
			$mother = $this->person_model->getPersonFullById($mother);
			$emailArray[] = $mother->email;
		}
		
		
		$this->sendValidationOkEmail($personuser, $colonist, $summercamp->getCampName(),$emailArray);
	}

	public function users () {
		$this->Logger->info("Running: ". __METHOD__);
		$this->loadView("admin/users/user_admin_container");
	}
	
	public function userPermissions() {
		$this->Logger->info("Running: ". __METHOD__);
		$data['users'] = $this -> person_model -> getUserPermissionsDetailed();
		$this -> loadReportView("admin/users/user_permissions", $data);
	}

	public function updatePersonPermissions() {
		$this->Logger->info("Running: ". __METHOD__);

		$this->Logger->info("Array POST: " . print_r($_POST, true));
		$personId = $_POST['person_id'];

		$arrNewPermissions = array(
				'system_admin' => isset($_POST['system_admin']),
				'director' => isset($_POST['director']),
				'secretary' => isset($_POST['secretary']),
				'coordinator' => isset($_POST['coordinator']),
				'doctor' => isset($_POST['doctor']),
				'monitor' => isset($_POST['monitor'])
			);

		$this->Logger->info("Array New Permissions: " . print_r($arrNewPermissions, true));
		try{
			$this->Logger->info("Updating user's permissions");
			$this->generic_model->startTransaction();
			
			$this->person_model->updateUserPermissions($personId, $arrNewPermissions);
			
			$this->generic_model->commitTransaction();
			$this->Logger->info("Updated user's permissions");

		} catch (Exception $ex) {
			$this->Logger->error("Failed to update user's permissions");
			$this->generic_model->rollbackTransaction();
		}	

		redirect("admin/userPermissions");
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
		if($responsableAddress)
			if($address->getAddressId() == $responsableAddress->getAddressId())
				$data["sameAddressResponsable"] = "s";
		$data["colonistId"] = $colonistId;
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
		$father = $this->summercamp_model -> getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
		$mother = $this->summercamp_model -> getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");
		if($father){
			if($father == $responsableId)
				$data["responsableDadMother"] = "dad";
			$father = $this->person_model -> getPersonFullById($father);  
			$data["dadFullName"] = $father->fullname ;
			$data["dadEmail"] = $father->email;
			$data["dadPhone"] = $father->phone1;
		}
		if($mother){
			if($mother == $responsableId)
				$data["responsableDadMother"] = "mother";
			$mother = $this->person_model -> getPersonFullById($mother);  
			$data["motherFullName"] = $mother->fullname ;
			$data["motherEmail"] = $mother->email;
			$data["motherPhone"] = $mother->phone1;
		}
		$this -> loadView('summercamps/viewColonistInfo', $data);

	}

	public function verifyDocument() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$camp_id = $this -> input -> get('camp_id', TRUE);
		$colonist_id = $this -> input -> get('colonist_id', TRUE);
		$document_type = $this -> input -> get('document_type', TRUE);
		$document = $this -> summercamp_model -> getNewestDocument($camp_id, $colonist_id, $document_type);
		if ($document){
			if($document["extension"] == "pdf")
				header("Content-type: application/pdf");
			else 
				header("Content-type: image/jpeg");
			echo pg_unescape_bytea($document["data"]);
		} else {
			$this->loadView ("admin/users/documentNotFound");
		}
			
		
	}

	public function viewEmails($userId) {
		$this -> Logger -> info("Starting " . __METHOD__);
		$person = $this -> person_model -> getPersonById($userId);
		$emails = $this -> email_model -> getEmailsSentToUserById($userId);

		$data['emails'] = $emails;
		$data['person'] = $person;

		$this->loadView("admin/users/emailsSent", $data);
	}

	public function writeEmail($userId) {
		$this -> Logger -> info("Starting " . __METHOD__);
		$person = $this -> person_model -> getPersonById($userId);

		$data['person'] = $person;

		$this->loadView("admin/users/writeEmail", $data);
	}

	public function sendEmail() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$userId = $this -> input -> post('user_id', TRUE);
		$userEmail = $this -> input -> post('user_email', TRUE);
		$subject = $this -> input -> post('subject', TRUE);
		$message = $this -> input -> post('message', TRUE);

		$person = $this -> person_model -> getPersonById($userId);

		if($this -> sendMail($subject, $message, $person)){
			echo "<script>alert('Envio realizado com sucesso'); window.location.replace('" . $this->config->item('url_link') . "admin/viewEmails/".$userId."');</script>";
		} else {
			echo "<script>alert('Houve um problema ao enviar o email. Por favor, tente novamente.'); window.history.back(-1);</script>";
		}

	}

	public function updateQueueNumber() {
		$this -> Logger -> info("Starting " . __METHOD__);
		$userId = $this -> input -> post('user_id', TRUE);
		$summerCampType = $this -> input -> post('summer_camp_type', TRUE);
		$yearSelected = $this -> input -> post('year', TRUE);
		$position = $this -> input -> post('position', TRUE);

		try{
			$this->Logger->info("Getting summer camps id");
			$summerCamps = $this->summercamp_model->getMiniCampsOrNotByYear($yearSelected, $summerCampType);
			$campsIdStr = "";
			if($summerCamps != null && count($summerCamps) > 0){
				$campsIdStr = $summerCamps[0]->getCampId();
				for($i = 1; $i < count($summerCamps); $i++)
				$campsIdStr .= "," . $summerCamps[$i]->getCampId();
			}
			$this->Logger->debug("Summer Camp Ids: ". $campsIdStr);
			if(strlen($campsIdStr) == 0)
				throw new Exception("Nenhuma colonia encontrada com os parametros dados.");
			
			$this->Logger->info("Checking if the given position is already occupied by another person");
			if(!$this->summercamp_model->checkQueueNumberAvailability($userId, $campsIdStr, $position))
				throw new Exception("Falha ao atualizar fila de espera, verifique se outra pessoa possui o mesmo valor");

			$this->Logger->info("Updating queue number in database");
			$this->generic_model->startTransaction();
			if(!$this->summercamp_model->updateQueueNumber($userId, $campsIdStr, $position))
				throw new Exception("Falha ao atualizar o banco de dados");
			$this->generic_model->commitTransaction();
            
            echo "true";
		} catch (Exception $ex) {
			$this->Logger->error("Failed to insert new user");
            $this->generic_model->rollbackTransaction();
			echo utf8_decode($ex->getMessage());
		}
	}
}
