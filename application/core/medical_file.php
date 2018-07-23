<?php
	class MedicalFile {
		private $campId;
		private $colonistId;
		private $bloodType;
		private $rh;
		private $weight;
		private $height;
		private $physicalActivityRestriction;
		private $vacineTetanus;
		private $vacineMMR;
		private $vacineHepatitis;
		private $vacineYellowFever;
		private $infectoContagiousAntecedents;
		private $regularUseMedicine;
		private $medicineRestrictions;
		private $allergies;
		private $analgesicAntipyretic;
		private $doctorId;
		private $date;
		private $doctorObservations;
		private $specialCareMedical;


		public function __construct($campId, $colonistId, $bloodType, $rh, 
			$weight, $height, $physicalActivityRestriction, $vacineTetanus, $vacineMMR, 
			$vacineHepatitis, $vacineYellowFever, $infectoContagiousAntecedents,
			$regularUseMedicine, $medicineRestrictions,
			$allergies, $analgesicAntipyretic,$doctorId, $date, $doctorObservations=null, $specialCareMedical){
			$this->campId = $campId;
			$this->colonistId = $colonistId;
			$this->bloodType = $bloodType;
			$this->rh = $rh;
			$this->weight = $weight;
			$this->height = $height;
			$this->physicalActivityRestriction = $physicalActivityRestriction;
			$this->vacineTetanus = $vacineTetanus;
			$this->vacineMMR = $vacineMMR;
			$this->vacineHepatitis = $vacineHepatitis;
			$this->vacineYellowFever = $vacineYellowFever;
			$this->infectoContagiousAntecedents = $infectoContagiousAntecedents;
			$this->regularUseMedicine = $regularUseMedicine;
			$this->medicineRestrictions = $medicineRestrictions;
			$this->allergies = $allergies;
			$this->analgesicAntipyretic = $analgesicAntipyretic;
			$this->doctorId = $doctorId;
			$this->date = $date;
			$this->doctorObservations = $doctorObservations;
			$this->specialCareMedical = $specialCareMedical;
		}

		public static function createMedicalFileObject($resultRow){
			return new MedicalFile(
				$resultRow->summer_camp_id,
				$resultRow->colonist_id,
				$resultRow->blood_type,
				$resultRow->rh,
				$resultRow->weight,
				$resultRow->height,
				$resultRow->physical_activity_restriction,
				$resultRow->vacine_tetanus,
				$resultRow->vacine_mmr,
				$resultRow->vacine_hepatitis,
				$resultRow->vacine_yellow_fever,
				$resultRow->infecto_contagious_antecedents,
				$resultRow->regular_use_medicine,
				$resultRow->medicine_restrictions,
				$resultRow->allergies,
				$resultRow->analgesic_antipyretic,
				$resultRow->doctor_id,
				$resultRow->date,
				$resultRow->doctor_observations,		
				$resultRow->special_care
			);
		}

		public function setCampId($campId){
			$this->campId = $campId;
		}
		public function getCampId(){
			return $this->campId;
		}

		public function setColonistId($colonistId){
			$this->colonistId = $colonistId;
		}
		
		public function getColonistId(){
			return $this->colonistId;
		}

		public function setBloodType($bloodType){
			$this->bloodType = $bloodType;
		}
		public function getBloodType(){
			return $this->bloodType;
		}

		public function getBloodTypeName(){
			switch($this->bloodType){
				case BLOOD_TYPE_A:
					return "A";
				case BLOOD_TYPE_B:
					return "B";
				case BLOOD_TYPE_AB:
					return "AB";
				case BLOOD_TYPE_O:
					return "O";
			}
			return $this->bloodType;
		}

		public function setRH($rh){
			$this->rh = $rh;
		}
		public function getRH(){
			return $this->rh;
		}

		public function setWeight($weight){
			$this->weight = $weight;
		}
		public function getWeight(){
			return $this->weight;
		}

		public function setHeight($height){
			$this->height = $height;
		}
		public function getHeight(){
			return $this->height;
		}

		public function setPhysicalActivityRestriction($physicalActivityRestriction){
			$this->physicalActivityRestriction = $physicalActivityRestriction;
		}
		public function getPhysicalActivityRestriction(){
			return $this->physicalActivityRestriction;
		}

		public function setVacineTetanus($vacineTetanus){
			$this->vacineTetanus = $vacineTetanus;
		}
		public function getVacineTetanus(){
			return $this->vacineTetanus;
		}

		public function setVacineMMR($vacineMMR){
			$this->vacineMMR = $vacineMMR;
		}
		public function getVacineMMR(){
			return $this->vacineMMR;
		}

		public function setVacineHepatitis($vacineHepatitis){
			$this->vacineHepatitis = $vacineHepatitis;
		}
		public function getVacineHepatitis(){
			return $this->vacineHepatitis;
		}

		public function setVacineYellowFever($vacineYellowFever){
			$this->vacineYellowFever = $vacineYellowFever;
		}
		public function getVacineYellowFever(){
			return $this->vacineYellowFever;
		}

		public function setInfectoContagiousAntecedents($infectoContagiousAntecedents){
			$this->infectoContagiousAntecedents = $infectoContagiousAntecedents;
		}
		public function getInfectoContagiousAntecedents(){
			return $this->infectoContagiousAntecedents;
		}

		public function setRegularUseMedicine($regularUseMedicine){
			$this->regularUseMedicine = $regularUseMedicine;
		}
		public function getRegularUseMedicine(){
			return $this->regularUseMedicine;
		}

		public function setMedicineRestrictions($medicineRestrictions){
			$this->medicineRestrictions = $medicineRestrictions;
		}
		public function getMedicineRestrictions(){
			return $this->medicineRestrictions;
		}

		public function setAllergies($allergies){
			$this->allergies = $allergies;
		}
		public function getAllergies(){
			return $this->allergies;
		}

		public function setAnalgesicAntipyretic($analgesicAntipyretic){
			$this->analgesicAntipyretic = $analgesicAntipyretic;
		}
		public function getAnalgesicAntipyretic(){
			return $this->analgesicAntipyretic;
		}

		public function setDoctorId($doctorId){
			$this->doctorId = $doctorId;
		}
		public function getDoctorId(){
			return $this->doctorId;
		}

		public function setDate($date){
			$this->date = $date;
		}
		public function getDate(){
			return $this->date;
		}

		public function setDoctorObservations($doctorObservations){
			$this->doctorObservations = $doctorObservations;
		}
		public function getDoctorObservations(){
			return $this->doctorObservations;
		}

		public function setSpecialCareMedical($specialCareMedical){
			$this->specialCareMedical = $specialCareMedical;
		}
		public function getSpecialCareMedical(){
			return $this->specialCareMedical;
		}

	}
?>
