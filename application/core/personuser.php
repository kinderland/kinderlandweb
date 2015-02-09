<?php
	require_once APPPATH . 'core/person.php';

	class PersonUser extends Person{
		private $login;
		private $cpf;
		private $occupation;

		public function __construct($personId, $fullname, 
			$gender, $email, $associate, $benemerit, $address, $login,
			$cpf, $occupation){
			parent::__construct($personId, $fullname, 
			$gender, $email, $benemerit, $address);

			$this->login = $login;
			$this->cpf = $cpf;
			$this->occupation = $occupation;
		}

		public static function createUserObject($resultRow, $addressIncluded = false){
			$user = new PersonUser(
				$resultRow->person_id, 
				$resultRow->fullname,
				$resultRow->gender, 
				$resultRow->email,
				$resultRow->associate, 
				$resultRow->benemerit,
				null,
				$resultRow->login,
				$resultRow->cpf,
				$resultRow->occupation
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


	}
?>