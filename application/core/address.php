<?php
	class Address {
		private $addressId;
		private $street;
		private $placeNumber;
		private $complement;
		private $cep;
		private $city;
		private $neighborhood;
		private $uf;

		public function __construct($addressId, $street, $placeNumber, 
			$complement, $cep, $city, $neighborhood, $uf){
			$this->addressId = $addressId;
			$this->street = $street;
			$this->placeNumber = $placeNumber;
			$this->complement = $complement;
			$this->cep = $cep;
			$this->city = $city;
			$this->neighborhood = $neighborhood;
			$this->uf = $uf;
		}

		public static function createAddressObject($resultRow){
			return new Address(
				$resultRow->addressId,
				$resultRow->street,
				$resultRow->placeNumber,
				$resultRow->complement,
				$resultRow->cep,
				$resultRow->city,
				$resultRow->neighborhood,
				$resultRow->uf
			);
		}

		public function setAddressId($addressId){
			$this->addressId = $addressId;
		}
		public function getAddressId(){
			return $this->addressId;
		}

		public function setStreet($street){
			$this->street = $street;
		}
		public function getStreet(){
			return $this->street;
		}

		public function setPlaceNumber($placeNumber){
			$this->placeNumber = $placeNumber;
		}
		public function getPlaceNumber(){
			return $this->placeNumber;
		}

		public function setComplement($complement){
			$this->complement = $complement;
		}
		public function getComplement(){
			return $this->complement;
		}

		public function setCEP($cep){
			$this->cep = $cep;
		}
		public function getCEP(){
			return $this->cep;
		}

		public function setCity($city){
			$this->city = $city;
		}
		public function getCity(){
			return $this->city;
		}

		public function setNeighborhood($neighborhood){
			$this->neighborhood = $neighborhood;
		}
		public function getNeighborhood(){
			return $this->neighborhood;
		}

		public function setUF($uf){
			$this->uf = $uf;
		}
		public function getUF(){
			return $this->uf;
		}

	}
?>