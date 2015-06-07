<?php
	require_once APPPATH . 'core/person.php';

	class Colonist extends Person{
		private $colonistId;
		private $birthDate;
		private $documentNumber;
		private $documentType;

		public function __construct($personId, $fullname, $gender, $email, $address, $colonistId,$birthDate, $documentNumber, $documentType, $phone1, $phone2){
			parent::__construct($personId, $fullname,$gender, $email, $address, $phone1, $phone2);

			$this->colonistId = $colonistId;
			$this->birthDate = $birthDate;
			$this->documentNumber = $documentNumber;
			$this->documentType = $documentType;
		}
		
		public static function createColonistObject($resultRow, $addressIncluded = false){
			$colonist = new Colonist(
				$resultRow->person_id, 
				$resultRow->fullname,
				$resultRow->gender, 
				$resultRow->email,
				null,
				$resultRow->colonist_id,
				$resultRow->birth_date,
				$resultRow->document_number,
				$resultRow->document_type,
				$resultRow->phone1,
				$resultRow->phone2
			);
			if($addressIncluded)
				$colonist->setAddress(Address::createAddressObject($resultRow));

			return $colonist;
		}

		public function setColonistId($colonistId){
			$this->colonistId = $colonistId;
		}
		public function getColonistId(){
			return $this->colonistId;
		}

		public function setBirthDate($birthDate){
			$this->birthDate = $birthDate;
		}
		public function getBirthDate(){
			return $this->birthDate;
		}

		public function setDocumentNumber($documentNumber){
			$this->documentNumber = $documentNumber;
		}
		public function getDocumentNumber(){
			return $this->documentNumber;
		}

		public function setDocumentType($documentType){
			$this->documentType = $documentType;
		}
		public function getDocumentType(){
			return $this->documentType;
		}

	}
?>