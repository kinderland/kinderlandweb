<?php
	require_once APPPATH . 'core/person.php';

	class PersonUser extends Person{
		private $login;
		private $cpf;
		private $occupation;
		private $userTypes;

		public function __construct($personId, $fullname, 
			$gender, $email, /*$associate,*/ $benemerit, $address, $login,
			$cpf, $occupation, $phone1, $phone2, $userTypes){
			parent::__construct($personId, $fullname, 
			$gender, $email, $benemerit, $address, $phone1, $phone2);

			$this->login = $login;
			$this->cpf = $cpf;
			$this->occupation = $occupation;
			$this->userTypes = $userTypes;
		}

		public static function createUserObject($resultRow, $addressIncluded = false){
			$user = new PersonUser(
				$resultRow->person_id, 
				$resultRow->fullname,
				$resultRow->gender, 
				$resultRow->email,
				//$resultRow->associate, 
				$resultRow->benemerit,
				null,
				$resultRow->login,
				$resultRow->cpf,
				$resultRow->occupation,
				$resultRow->phone1,
				$resultRow->phone2,
				null
			);
			if($addressIncluded)
				$user->setAddress(Address::createAddressObject($resultRow));

			return $user;
		}

		public function setLogin($login){
			$this->login = $login;
		}
		public function getLogin(){
			return $this->login;
		}

		public function setCPF($cpf){
			$this->cpf = $cpf;
		}
		public function getCPF(){
			return $this->cpf;
		}

		public function setOccupation($occupation){
			$this->occupation = $occupation;
		}
		public function getOccupation(){
			return $this->occupation;
		}

		public function setUserTypes($userTypes){
			$this->userTypes = $userTypes;
		}
		public function getUserTypes(){
			return $this->userTypes;
		}

	}
?>