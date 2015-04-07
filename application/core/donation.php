<?php
	class Donation {
		public $donationId;
		public $personId;
		public $donationType;
		public $dateCreated;
		public $dateUpdated;
		public $donatedValue;
		public $donationStatus;

		public function __construct($donationId, $personId, $donationType, $dateCreated, $dateUpdated, $donatedValue, $donationStatus){
			$this->donationId = $donationId;
			$this->personId = $personId;
			$this->donationType = $donationType;
			$this->dateCreated = $dateCreated;
			$this->dateUpdated = $dateUpdated;
			$this->donatedValue = $donatedValue;
			$this->donationStatus = $donationStatus;
			
		}

		public static function createDonationObject($resultRow){
			return new Donation(
				$resultRow->donation_id, 
				$resultRow->person_id,
				$resultRow->donation_type, 
				$resultRow->date_created,
				$resultRow->date_updated,
				$resultRow->donated_value,
				$resultRow->donation_status);
		}
		
		public function setPersonId($personId){
			$this->personId = $personId;
		}
		public function getPersonId(){
			return $this->personId;
		}

		public function setDonationId($donationId){
			$this->donationId = $donationId;
		}
		public function getDonationId(){
			return $this->donationId;
		}

		public function setDateCreated($dateCreated){
			$this->dateCreated = $dateCreated;
		}
		public function getDateCreated(){
			return $this->dateCreated;
		}

		public function setDateUpdated($dateUpdated){
			$this->dateUpdated = $dateUpdated;
		}

		public function getDateUpdated(){
			return $this->dateUpdated;
		}

		public function setDonatedValue($donatedValue){
			$this->donatedValue = $donatedValue;
		}
		public function getDonatedValue(){
			return $this->donatedValue;
		}

		public function setDonationStatus($donationStatus){
			$this->donationStatus = $donationStatus;
		}
		public function getDonationStatus(){
			return $this->donationStatus;
		}

		public function setDonationType($donationType){
			$this->donationType = $donationType;
		}
		public function getDonationType(){
			return $this->donationType;
		}

	}
?>