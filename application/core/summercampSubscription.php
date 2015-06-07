<?php
	require_once APPPATH . 'core/colonist.php';

	class SummerCampSubscription extends Colonist{
		private $summerCampId;
		private $personUserId;
		private $situation;

		public function __construct($personId, $fullname, $gender, $email, $address, $summerCampId,$personUserId, $situation, $documentType, $phone1, $phone2,$summerCampId,$personUserId,$situation){
			parent::__construct($personId, $fullname, $gender, $email, $address, $summerCampId,$personUserId, $situation, $documentType, $phone1, $phone2);

			$this->summerCampId = $summerCampId;
			$this->personUserId = $personUserId;
			$this->situation = $situation;
		}
		
		public static function createSummerCampSubscriptionObject($resultRow, $addressIncluded = false){
			$summerCampSubscription = new SummerCampSubscription(
				$resultRow->person_id, 
				$resultRow->fullname,
				$resultRow->gender, 
				$resultRow->email,
				null, //address
				$resultRow->colonist_id,
				$resultRow->birth_date,
				$resultRow->document_number,
				$resultRow->document_type,
				null, //phone1
				null, //phone2
				$resultRow->summer_camp_id,
				$resultRow->person_user_id,
				$resultRow->situation_description
			);
			if($addressIncluded)
				$summerCampSubscription->setAddress(Address::createAddressObject($resultRow));

			return $summerCampSubscription;
		}

		public function setSummerCampId($summerCampId){
			$this->summerCampId = $summerCampId;
		}
		public function getSummerCampId(){
			return $this->summerCampId;
		}

		public function setPersonUserId($personUserId){
			$this->personUserId = $personUserId;
		}
		public function getPersonUserId(){
			return $this->personUserId;
		}

		public function setSituation($situation){
			$this->situation = $situation;
		}
		public function getSituation(){
			return $this->situation;
		}
		
	}
?>