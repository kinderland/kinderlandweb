<?php
	require_once APPPATH . 'core/address.php';
	class Person {
		public $personId;
		public $fullname;
		public $gender;
		public $email;
		//private $associate = false;
		public $benemerit = false;
		public $address;
		public $phone1;
		public $phone2;

		public function __construct($personId, $fullname, $gender, $email/*, $associate*/, $benemerit, $address, $phone1, $phone2){
			$this->personId = $personId;
			$this->fullname = $fullname;
			$this->gender = $gender;
			$this->email = $email;
			//$this->associate = $associate;
			$this->benemerit = $benemerit;
			$this->address = $address;
			$this->phone1 = $phone1;
			$this->phone2 = $phone2;
		}

		public static function createPersonObject($resultRow){
			return new Person(
				$resultRow->person_id, 
				$resultRow->fullname,
				$resultRow->gender, 
				$resultRow->email,
				//$resultRow->associate, 
				$resultRow->benemerit,
				$resultRow->phone1,
				$resultRow->phone2,
				null
			);
		}

		public static function createPersonObjectSimple($resultRow){
			return new Person(
				$resultRow->person_id, 
				$resultRow->fullname,
				$resultRow->gender, 
				$resultRow->email,
				//$resultRow->associate, 
				$resultRow->benemerit,
				null, null,	null
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

		public function setPhone1($phone1){
			$this->phone1 = $phone1;
		}
		public function getPhone1(){
			return $this->phone1;
		}

		public function setPhone2($phone2){
			$this->phone2 = $phone2;
		}
		public function getPhone2(){
			return $this->phone2;
		}

	}
?>