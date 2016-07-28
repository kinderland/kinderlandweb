<?php
require_once APPPATH . 'core/colonist.php';

class SummerCampSubscription extends Colonist {
	private $summerCampId;
	private $personUserId;
	private $situation;
	private $situationId;
	private $school;
	private $schoolYear;
	private $acceptedTerms;
	private $acceptedTravelTerms;
	private $roommate1;
	private $roommate2;
	private $roommate3;
	private $queueNumber;
	private $discount;
	private $datePaymentLimit;
	private $roomNumber;

	public function __construct($personId, $fullname, $gender, $email,$address,
	$colonistId, $birthDate, $documentNumber, $documentType,$personUserId, 
	$phone1,
	$phone2, 
	$summerCampId, $personUserId, $situation, $school, $schoolYear,$acceptedTerms,$acceptedTravelTerms,$situationId,$roommate1,$roommate2,$roommate3, $queueNumber=null, $discount=null, $datePaymentLimit=null, $roomNumber=null) {
		parent::__construct($personId, $fullname, $gender, $email, $address, $colonistId, $birthDate, $documentNumber, $documentType, $phone1, $phone2);
		$this -> summerCampId = $summerCampId;
		$this -> personUserId = $personUserId;
		$this -> situation = $situation;
		$this -> school = $school;
		$this -> schoolYear = $schoolYear;
		$this -> situationId = $situationId;
		$this -> acceptedTerms = $acceptedTerms;
		$this -> acceptedTravelTerms = $acceptedTravelTerms;
		$this -> roommate1 = $roommate1;
		$this -> roommate2 = $roommate2;
		$this -> roommate3 = $roommate3;
		$this -> queueNumber = $queueNumber;
		$this -> discount = $discount;
		$this -> datePaymentLimit = $datePaymentLimit;
		$this -> roomNumber = $roomNumber;
		$this -> colonistId = $colonistId;
	}

	public static function createSummerCampSubscriptionObject($resultRow, $addressIncluded = false) {
		$summerCampSubscription = new SummerCampSubscription(
		$resultRow -> person_id, $resultRow -> fullname, $resultRow -> gender, $resultRow -> email, null, //address
		$resultRow -> colonist_id, $resultRow -> birth_date, $resultRow -> document_number, $resultRow -> document_type, $resultRow->person_user_id,
		null, //phone1
		null, //phone2
		$resultRow -> summer_camp_id, $resultRow -> person_user_id, $resultRow -> situation_description, $resultRow -> school_name, $resultRow -> school_year,$resultRow -> accepted_terms, $resultRow -> accepted_travel_terms,$resultRow -> situation,
		$resultRow -> roommate1, $resultRow -> roommate2, $resultRow -> roommate3,
		$resultRow -> queue_number,$resultRow -> discount, $resultRow -> date_payment_limit, $resultRow -> room_number);
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
	
	public function setColonistId($colonistId) {
		$this -> colonistId = $colonistId;
	}
	
	public function getColonistId() {
		return $this -> colonistId;
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
	
	public function setAcceptedTerms($acceptedTerms) {
		$this -> acceptedTerms = $acceptedTerms;
	}
	
	public function getAcceptedTerms() {
		return $this -> acceptedTerms;
	}
	
	public function setAcceptedTravelTerms($acceptedTravelTerms) {
		$this -> acceptedTravelTerms = $acceptedTravelTerms;
	}
	
	public function getAcceptedTravelTerms() {
		return $this -> acceptedTravelTerms;
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

	public function setDatePaymentLimit($datePaymentLimit) {
		$this -> datePaymentLimit = $datePaymentLimit;
	}

	public function getDatePaymentLimit() {
		return $this -> datePaymentLimit;
	}
	
	public function duringPaymentLimit() {
		$dateLimit = strtotime($this -> datePaymentLimit);
		$diffTime = time() - $dateLimit;
		return $diffTime < 0;
	}
	
	public function getDatePaymentLimitFormatted(){
		return date("d/m/Y",strtotime($this->getDatePaymentLimit()));
	}

	public function setRoomNumber($roomNumber) {
		$this -> roomNumber = $roomNumber;
	}

	public function getRoomNumber() {
		return $this -> roomNumber;
	}
}
?>