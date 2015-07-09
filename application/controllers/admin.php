<?php

require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/summercamp.php';

class Admin extends CK_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> model('person_model');
		$this -> load -> model('personuser_model');
		$this -> load -> model('summercamp_model');
		$this -> load -> model('donation_model');
		$this -> load -> model('generic_model');
		$this -> load -> model('validation_model');
		$this -> person_model -> setLogger($this -> Logger);
		$this -> personuser_model -> setLogger($this -> Logger);
		$this -> summercamp_model -> setLogger($this -> Logger);
		$this -> donation_model -> setLogger($this -> Logger);
		$this -> generic_model -> setLogger($this -> Logger);
		$this -> validation_model -> setLogger($this -> Logger);
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

	public function insertNewCamp(){
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
						$_POST['capacity_female']
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
		$shownStatus =  SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION . "," . 
						SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN . "," . 
						SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED . "," .
						SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS;
		$data['colonists'] = $this->summercamp_model->getAllColonistsBySummerCamp($shownStatus);
		$this -> loadReportView("admin/camps/validate_colonists", $data);
	}

	public function updateColonistValidation() {
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
	
		$this->validateColonists();
	}

	public function confirmValidation(){
		$colonistId = $_POST['colonist_id'];
		$summerCampId = $_POST['summer_camp_id'];
		$gender = $_POST['gender'];
		$picture = $_POST['picture'];
		$identity = $_POST['identity'];
		$birthday = $_POST['birthday'];
		$parentsName = $_POST['parents_name'];
		$colonistName = $_POST['colonist_name'];


		if($gender == "true" && $picture == "true" && $identity == "true" && $birthday == "true" && $parentsName == "true" && $colonistName == "true")
			$this->summercamp_model->updateColonistStatus($colonistId, $summerCampId, SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED);
		else 
			$this->summercamp_model->updateColonistStatus($colonistId, $summerCampId, SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS);

		echo "true";
	}


	public function users () {
		$this->loadView("admin/users/user_admin_container");
	}
	
	public function userPermissions() {
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
}
