<?php
	require_once APPPATH . 'core/address.php';
	class Person {
		private $personId;
		private $fullname;
		private $gender;
		private $email;
		//private $associate = false;
		private $benemerit = false;
		private $address;

		public function __construct($personId, $fullname, $gender, $email/*, $associate*/, $benemerit, $address){
			$this->personId = $personId;
			$this->fullname = $fullname;
			$this->gender = $gender;
			$this->email = $email;
			//$this->associate = $associate;
			$this->benemerit = $benemerit;
			$this->address = $address;
		}

		public static function createPersonObject($resultRow){
			return new Person(
				$resultRow->person_id, 
				$resultRow->fullname,
				$resultRow->gender, 
				$resultRow->email,
				//$resultRow->associate, 
				$resultRow->benemerit,
				null
			);
		}

		public static function createPersonObjectWithAddress($resultRow){
			$person = $this->createPersonObject($resultRow);
			$person->setAddress(Address::createAddressObject($resultRow));

			return $person;
		}

		public function setPersonId($personId){
			$this->personId = $personId;
		}
		public function getPersonId(){
			return $this->personId;
		}

		public function setFullname($fullname){
			$this->fullname = $fullname;
		}
		public function getFullname(){
			return $this->fullname;
		}

		public function setGender($gender){
			$this->gender = $gender;
		}
		public function getGender(){
			return $this->gender;
		}

		public function setEmail($email){
			$this->email = $email;
		}
		public function getEmail(){
			return $this->email;
		}
/*
		public function setAssociate($associate){
			$this->associate = $associate;
		}
		public function isAssociate(){
			return $this->associate;
		}
*/
		public function setBenemerit($benemerit){
			$this->benemerit = $benemerit;
		}
		public function isBenemerit(){
			return $this->benemerit;
		}

		public function setAddress($address){
			$this->address = $address;
		}
		public function getAddress(){
			return $this->address;
		}

	}
?>