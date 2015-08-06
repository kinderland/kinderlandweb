<?php
require_once APPPATH . 'core/colonist.php';

class SummerCampSubscription extends Colonist {
	private $summerCampId;
	private $personUserId;
	private $situation;
	private $situationId;
	private $school;
	private $schoolYear;
	private $roommate1;
	private $roommate2;
	private $roommate3;
	private $queueNumber;
	private $discount;
	

	public function __construct($personId, $fullname, $gender, $email,$address,
	$colonistId, $birthDate, $documentNumber, $documentType,$personUserId, 
	$phone1,
	$phone2, 
	$summerCampId, $personUserId, $situation, $school, $schoolYear,$situationId,$roommate1,$roommate2,$roommate3, $queueNumber=null, $discount=null) {
		parent::__construct($personId, $fullname, $gender, $email, $address, $colonistId, $birthDate, $documentNumber, $documentType, $phone1, $phone2);
		$this -> summerCampId = $summerCampId;
		$this -> personUserId = $personUserId;
		$this -> situation = $situation;
		$this -> school = $school;
		$this -> schoolYear = $schoolYear;
		$this -> situationId = $situationId;
		$this -> roommate1 = $roommate1;
		$this -> roommate2 = $roommate2;
		$this -> roommate3 = $roommate3;
		$this -> queueNumber = $queueNumber;
		$this -> discount = $discount;
		
	}

	public static function createSummerCampSubscriptionObject($resultRow, $addressIncluded = false) {
		$summerCampSubscription = new SummerCampSubscription(
		$resultRow -> person_id, $resultRow -> fullname, $resultRow -> gender, $resultRow -> email, null, //address
		$resultRow -> colonist_id, $resultRow -> birth_date, $resultRow -> document_number, $resultRow -> document_type, $resultRow->person_user_id,
		null, //phone1
		null, //phone2
		$resultRow -> summer_camp_id, $resultRow -> person_user_id, $resultRow -> situation_description, $resultRow -> school_name, $resultRow -> school_year,$resultRow -> situation,
		$resultRow -> roommate1, $resultRow -> roommate2, $resultRow -> roommate3,
		$resultRow -> queue_number,$resultRow -> discount);
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

	public function setSituationId($situationId) {
		$this -> situationId = $situationId;
	}

	public function getSituationId() {
		return $this -> situationId;
	}

	public function setRoommate1($roommate1) {
		$this -> roommate1 = $roommate1;
	}

	public function getRoommate1() {
		return $this -> roommate1;
	}

	public function setRoommate2($roommate2) {
		$this -> roommate2 = $roommate2;
	}

	public function getRoommate2() {
		return $this -> roommate2;
	}

	public function setRoommate3($roommate3) {
		$this -> roommate3 = $roommate3;
	}

	public function getRoommate3() {
		return $this -> roommate3;
	}

	public function setQueueNumber($queueNumber) {
		$this -> queueNumber = $queueNumber;
	}

	public function getQueueNumber() {
		return $this -> queueNumber;
	}

	public function setDiscount($discount) {
		$this -> discount = $discount;
	}

	public function getDiscount() {
		return $this -> discount;
	}

}
?>