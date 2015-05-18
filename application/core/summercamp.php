<?php
	class SummerCamp {
		private $campId;
		private $campName;
		private $dateCreated;
		private $dateStart;
		private $dateFinish;
		private $dateStartPre;
		private $dateFinishPre;
		private $description;
		private $preEnabled;
		private $capacityMale;
		private $capacityFemale;

		public function __construct($campId, $campName, $dateCreated, $dateStart, 
			$dateFinish, $dateStartPre, $dateFinishPre, $description, $preEnabled,
			$capacityMale, $capacityFemale){
			$this->campId = $campId;
			$this->campName = $campName;
			$this->dateCreated = $dateCreated;
			$this->dateStart = $dateStart;
			$this->dateFinish = $dateFinish;
			$this->dateStartPre = $dateStartPre;
			$this->dateFinishPre = $dateFinishPre;
			$this->description = $description;
			$this->preEnabled = $preEnabled;
			$this->capacityMale = $capacityMale;
			$this->capacityFemale = $capacityFemale;
		}

		public static function createCampObject($resultRow){
			return new SummerCamp(
				$resultRow->summer_camp_id,
				$resultRow->camp_name,
				$resultRow->date_created,
				$resultRow->date_start,
				$resultRow->date_finish,
				//$resultRow->price,
				$resultRow->date_start_pre_subscriptions,
				$resultRow->date_finish_pre_subscriptions,
				$resultRow->description,
				$resultRow->pre_subscriptions_enabled,
				$resultRow->capacity_male,
				$resultRow->capacity_female
			);
		}

		public function setCampId($campId){
			$this->campId = $campId;
		}
		public function getCampId(){
			return $this->campId;
		}

		public function setCampName($campName){
			$this->campName = $campName;
		}
		public function getCampName(){
			return $this->campName;
		}

		public function setDateCreated($dateCreated){
			$this->dateCreated = $dateCreated;
		}
		public function getDateCreated(){
			return $this->dateCreated;
		}

		public function setDateStart($dateStart){
			$this->dateStart = $dateStart;
		}
		public function getDateStart(){
			return $this->dateStart;
		}

		public function setDateFinish($dateFinish){
			$this->dateFinish = $dateFinish;
		}
		public function getDateFinish(){
			return $this->dateFinish;
		}

		public function setDateStartPre($dateStartPre){
			$this->dateStartPre = $dateStartPre;
		}
		public function getDateStartPre(){
			return $this->dateStartPre;
		}

		public function setDateFinishPre($dateFinishPre){
			$this->dateFinishPre = $dateFinishPre;
		}
		public function getDateFinishPre(){
			return $this->dateFinishPre;
		}

		public function setDescription($description){
			$this->description = $description;
		}
		public function getDescription(){
			return $this->description;
		}

		public function setEnabled($preEnabled){
			$this->preEnabled = $preEnabled;
		}
		public function isEnabled(){
			if($this->preEnabled == "t")
				return TRUE;
			return FALSE;
		}

		public function setCapacityMale($capacityMale){
			$this->capacityMale = $capacityMale;
		}
		public function getCapacityMale(){
			return $this->capacityMale;
		}

		public function setCapacityFemale($capacityFemale){
			$this->capacityFemale = $capacityFemale;
		}
		public function getCapacityFemale(){
			return $this->capacityFemale;
		}

	}
?>