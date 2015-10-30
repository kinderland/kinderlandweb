<?php
require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/medical_file.php';
class medical_file_model extends CK_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertNewMedicalFile($summerCampId, $colonistId, $bloodType, $rh, $weight, $height, $physicalActivityRestriction,
		$vacineTetanus, $vacineMMR, $vacineHepatitis, $infectoContagiousAntecedents, $regularUseMedicine, 
		$medicineRestrictions, $allergies, $analgesicAntipyretic, $doctorId){
		$this->Logger->info("Running: " . __METHOD__);

		$sql = 'INSERT INTO medical_file (summer_camp_id, colonist_id, blood_type, rh, weight, height, physical_activity_restriction,
		vacine_tetanus, vacine_mmr, vacine_hepatitis, infecto_contagious_antecedents, regular_use_medicine, 
		medicine_restrictions, allergies, analgesic_antipyretic, doctor_id) VALUES (?, ?, ?, ?,?, ?, ?, ?,?, ?, ?, ?,?, ?, ?, ?)';
		$returnId = $this->executeReturningId($this->db, $sql, array(intval($summerCampId), intval($colonistId), intval($bloodType), $rh, $weight, $height, $physicalActivityRestriction,
		$vacineTetanus, $vacineMMR, $vacineHepatitis, $infectoContagiousAntecedents, $regularUseMedicine, 
		$medicineRestrictions, $allergies, $analgesicAntipyretic, intval($doctorId)));
		if($returnId)
			return $returnId;

		return false;
	}


	public function updateMedicalFile($summerCampId, $colonistId, $bloodType, $rh, $weight, $height, $physicalActivityRestriction,
		$vacineTetanus, $vacineMMR, $vacineHepatitis, $infectoContagiousAntecedents, $regularUseMedicine, 
		$medicineRestrictions, $allergies, $analgesicAntipyretic, $doctorId){
 		$this->Logger->info("Running: " . __METHOD__);
 		
		$sql = 'UPDATE medical_file SET blood_type = ?, rh = ?, weight = ?, height = ?, physical_activity_restriction = ?,
		vacine_tetanus = ?, vacine_mmr = ?, vacine_hepatitis = ?, infecto_contagious_antecedents = ?, regular_use_medicine = ?, 
		medicine_restrictions = ?, allergies = ?, analgesic_antipyretic = ?, doctor_id =? where summer_camp_id = ? and colonist_id = ?';
		$result = $this->execute($this->db, $sql, array(intval($bloodType), $rh, $weight, $height, $physicalActivityRestriction,
		$vacineTetanus, $vacineMMR, $vacineHepatitis, $infectoContagiousAntecedents, $regularUseMedicine, 
		$medicineRestrictions, $allergies, $analgesicAntipyretic, intval($doctorId),intval($summerCampId), intval($colonistId)));

        if ($result)
            return true;
        return false;
    } 



    public function getMedicalFile($campId, $colonistId){
    	$this->Logger->info("Running: " . __METHOD__);
    	$sql = "SELECT * FROM medical_file WHERE summer_camp_id = ? and colonist_id = ?";
    	$result = $this->executeRow($this->db, $sql, array(intval($campId),intval($colonistId)));

    	if($result)
    		return MedicalFile::createMedicalFileObject($result);

    	return null;
    }


    public function insertNewStaffMedicalFile($summerCampId, $personId, $bloodType, $rh, $weight, $height, $physicalActivityRestriction,
		$vacineTetanus, $vacineMMR, $vacineHepatitis, $infectoContagiousAntecedents, $regularUseMedicine, 
		$medicineRestrictions, $allergies, $analgesicAntipyretic, $doctorId){
		$this->Logger->info("Running: " . __METHOD__);

		$sql = 'INSERT INTO medical_file_staff (summer_camp_id, person_id, blood_type, rh, weight, height, physical_activity_restriction,
		vacine_tetanus, vacine_mmr, vacine_hepatitis, infecto_contagious_antecedents, regular_use_medicine, 
		medicine_restrictions, allergies, analgesic_antipyretic, doctor_id) VALUES (?, ?, ?, ?,?, ?, ?, ?,?, ?, ?, ?,?, ?, ?, ?)';
		$returnId = $this->executeReturningId($this->db, $sql, array(intval($summerCampId), intval($personId), intval($bloodType), $rh, $weight, $height, $physicalActivityRestriction,
		$vacineTetanus, $vacineMMR, $vacineHepatitis, $infectoContagiousAntecedents, $regularUseMedicine, 
		$medicineRestrictions, $allergies, $analgesicAntipyretic, intval($doctorId)));
		if($returnId)
			return $returnId;

		return false;
	}


	public function updateStaffMedicalFile($summerCampId, $personId, $bloodType, $rh, $weight, $height, $physicalActivityRestriction,
		$vacineTetanus, $vacineMMR, $vacineHepatitis, $infectoContagiousAntecedents, $regularUseMedicine, 
		$medicineRestrictions, $allergies, $analgesicAntipyretic, $doctorId){
 		$this->Logger->info("Running: " . __METHOD__);
 		
		$sql = 'UPDATE medical_file_staff SET blood_type = ?, rh = ?, weight = ?, height = ?, physical_activity_restriction = ?,
		vacine_tetanus = ?, vacine_mmr = ?, vacine_hepatitis = ?, infecto_contagious_antecedents = ?, regular_use_medicine = ?, 
		medicine_restrictions = ?, allergies = ?, analgesic_antipyretic = ?, doctor_id =? where summer_camp_id = ? and person_id = ?';
		$result = $this->execute($this->db, $sql, array(intval($bloodType), $rh, $weight, $height, $physicalActivityRestriction,
		$vacineTetanus, $vacineMMR, $vacineHepatitis, $infectoContagiousAntecedents, $regularUseMedicine, 
		$medicineRestrictions, $allergies, $analgesicAntipyretic, intval($doctorId),intval($summerCampId), intval($personId)));

        if ($result)
            return true;
        return false;
    } 



    public function getStaffMedicalFile($campId, $personId){
    	$this->Logger->info("Running: " . __METHOD__);
    	$sql = "SELECT summer_camp_id, person_id as colonist_id, blood_type, rh, weight, height, physical_activity_restriction, vacine_tetanus, vacine_mmr, vacine_hepatitis, infecto_contagious_antecedents, regular_use_medicine, medicine_restrictions, allergies, analgesic_antipyretic, doctor_id, date, doctor_observations FROM medical_file_staff WHERE summer_camp_id = ? and person_id = ?";
    	$result = $this->executeRow($this->db, $sql, array(intval($campId),intval($personId)));

    	if($result)
    		return MedicalFile::createMedicalFileObject($result);

    	return null;
    }


    public function updateDoctorObservations($colonistId, $summerCampId, $observations){
		$sql = "UPDATE medical_file SET doctor_observations = ? WHERE summer_camp_id = ? AND colonist_id = ?";
        $result = $this->execute($this->db, $sql, array($observations, intval($summerCampId), intval($colonistId)));

        return $result;
    }

}
?>