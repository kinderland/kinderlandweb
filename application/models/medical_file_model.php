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

/*
 	public function updateMedicalFile($fullname, $gender, $email, $person_id, $address_id) {
 		$this->Logger->info("Running: " . __METHOD__);
 		
        $sql = "UPDATE person SET fullname=?, gender=?, email=?, address_id=? WHERE person_id=?";
        if ($this->execute($this->db, $sql, array($fullname, $gender, $email, $address_id, intval($person_id))))
            return true;
        return false;
    } 
*/


    public function getMedicalFile($campId, $colonistId){
    	$this->Logger->info("Running: " . __METHOD__);
    	$sql = "SELECT * FROM medical_file WHERE summer_camp_id = ? and colonist_id = ?";
    	$result = $this->executeRow($this->db, $sql, array(intval($campId),intval($colonistId)));

    	if($result)
    		return MedicalFile::createMedicalFileObject($result);

    	return null;
    }

}
?>