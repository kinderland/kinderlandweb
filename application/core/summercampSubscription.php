<?php
require_once APPPATH . 'core/colonist.php';

class SummerCampSubscription extends Colonist {
	private $summerCampId;
	private $personUserId;
	private $situation;
	private $school;
	private $schoolYear;

	public function __construct($personId, $fullname, $gender, $email,$address,
	$colonistId, $birthDate, $documentNumber, $documentType,$personUserId, 
	$phone1,
	$phone2, 
	$summerCampId, $personUserId, $situation, $school, $schoolYear) {
		parent::__construct($personId, $fullname, $gender, $email, $address, $colonistId, $birthDate, $documentNumber, $documentType, $phone1, $phone2);
		$this -> summerCampId = $summerCampId;
		$this -> personUserId = $personUserId;
		$this -> situation = $situation;
		$this -> school = $school;
		$this -> schoolYear = $schoolYear;
	}

	public static function createSummerCampSubscriptionObject($resultRow, $addressIncluded = false) {
		$summerCampSubscription = new SummerCampSubscription(
		$resultRow -> person_id, $resultRow -> fullname, $resultRow -> gender, $resultRow -> email, null, //address
		$resultRow -> colonist_id, $resultRow -> birth_date, $resultRow -> document_number, $resultRow -> document_type, $resultRow->person_user_id,
		null, //phone1
		null, //phone2
		$resultRow -> summer_camp_id, $resultRow -> person_user_id, $resultRow -> situation_description, $resultRow -> school_name, $resultRow -> school_year);
		if ($addressIncluded)
			$summerCampSubscription -> setAddress(Address::createAddressObject($resultRow));

		return $summerCampSubscription;
	}

	public function setSummerCampId($summerCampId) {
		$this -> summerCampId = $summerCampId;
	}

	public function getSummerCampId() {
		return $this -> summerCampId;
	}

	public function setPersonUserId($personUserId) {
		$this -> personUserId = $personUserId;
	}

	public function getPersonUserId() {
		return $this -> personUserId;
	}

	public function setSituation($situation) {
		$this -> situation = $situation;
	}

	public function getSituation() {
		return $this -> situation;
	}

	public function setSchool($school) {
		$this -> school = $school;
	}

	public function getSchool() {
		return $this -> school;
	}

	public function setSchoolYear($schoolYear) {
		$this -> schoolYear = $schoolYear;
	}

	public function getSchoolYear() {
		return $this -> schoolYear;
	}

}
?>