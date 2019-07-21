<?php
require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/validation.php';

class validation_model extends CK_Model {

	public function __construct() {
		parent::__construct();
	}

	public function updateColonistValidation($colonistId, $summerCampId, $genderOk, $pictureOk, $medicalCardOk, $identityOk, $birthdayOk, $parentsNameOk, $colonistNameOk, $msgGender, $msgPicture, $msgMedicalCard, $msgIdentity, $msgBirthdate, $msgParentsName, $msgColonistName) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT * FROM validation WHERE colonist_id = ? AND summer_camp_id = ?";
		$result = $this -> executeRow($this -> db, $sql, array(intval($colonistId), intval($summerCampId)));

		if ($result) {
			$updateSql = "UPDATE validation SET colonist_gender_ok = ?, colonist_picture_ok = ?, colonist_medical_card_ok = ?, 
				colonist_identity_ok = ?, colonist_birthday_ok = ?, colonist_parents_name_ok = ?, 
				colonist_name_ok = ?, colonist_gender_msg = ?, colonist_picture_msg = ?, colonist_medical_card_msg = ?, colonist_identity_msg = ?,
				colonist_birthday_msg = ?, colonist_parents_name_msg = ?, colonist_name_msg = ? 
				WHERE colonist_id = ? AND summer_camp_id = ?";

			return $this -> execute($this -> db, $updateSql, array($genderOk, $pictureOk, $medicalCardOk,$identityOk, $birthdayOk, $parentsNameOk, $colonistNameOk, $msgGender, $msgPicture, $msgMedicalCard, $msgIdentity, $msgBirthdate, $msgParentsName, $msgColonistName, intval($colonistId), intval($summerCampId)));
		} else {
			$insertSql = "INSERT INTO validation (colonist_id, summer_camp_id, colonist_gender_ok, colonist_picture_ok, colonist_medical_card_ok, 
				colonist_identity_ok, colonist_birthday_ok, colonist_parents_name_ok, 
				colonist_name_ok, colonist_gender_msg, colonist_picture_msg, colonist_medical_card_msg, colonist_identity_msg,
				colonist_birthday_msg, colonist_parents_name_msg, colonist_name_msg) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

			return $this -> execute($this -> db, $insertSql, array(intval($colonistId), intval($summerCampId), $genderOk, $pictureOk, $medicalCardOk, $identityOk, $birthdayOk, $parentsNameOk, $colonistNameOk, $msgGender, $msgPicture, $msgMedicalCard, $msgIdentity, $msgBirthdate, $msgParentsName, $msgColonistName));
		}

	}

	public function getColonistValidationInfo($colonistId, $summerCampId) {
		$sql = "SELECT * FROM validation WHERE colonist_id = ? AND summer_camp_id = ?";
		$resultRow = $this -> executeRow($this -> db, $sql, array($colonistId, $summerCampId));

		if (!$resultRow)
			return null;

		return $resultRow;
	}

	public function sentNewDocument($colonistId, $summerCampId, $documentId) {
		if ($this -> getColonistValidationInfoObject($colonistId, $summerCampId)) {
			switch ($documentId) {
				case DOCUMENT_GENERAL_RULES :
				case DOCUMENT_TRIP_AUTHORIZATION :
				case DOCUMENT_MEDICAL_FILE :
					return true;
					break;

				case DOCUMENT_IDENTIFICATION_DOCUMENT :
					$updateSql = "UPDATE validation SET colonist_identity_ok = ? WHERE colonist_id = ? AND summer_camp_id = ?";
					return $this -> execute($this -> db, $updateSql, array("t", intval($colonistId), intval($summerCampId)));

				case DOCUMENT_PHOTO_3X4 :
					$updateSql = "UPDATE validation SET colonist_picture_ok = ? WHERE colonist_id = ? AND summer_camp_id = ?";
					return $this -> execute($this -> db, $updateSql, array("t", intval($colonistId), intval($summerCampId)));
					break;
				case DOCUMENT_MEDICAL_CARD :
					$updateSql = "UPDATE validation SET colonist_medical_card_ok = ? WHERE colonist_id = ? AND summer_camp_id = ?";
					return $this -> execute($this -> db, $updateSql, array("t", intval($colonistId), intval($summerCampId)));
					break;

				default :
					return true;
					break;
			}
		}

	}

	public function sentNewSubscription($colonistId, $summerCampId) {
		$updateSql = "UPDATE validation SET colonist_birthday_ok = ?, colonist_parents_name_ok = ?, 
				colonist_name_ok = ?, colonist_gender_ok = ? WHERE colonist_id = ? AND summer_camp_id = ?";
		if ($this -> getColonistValidationInfoObject($colonistId, $summerCampId))
			return $this -> execute($this -> db, $updateSql, array("t", "t", "t", "t", intval($colonistId), intval($summerCampId)));
	}

	public function getColonistValidationInfoObject($colonistId, $summerCampId) {
		$sql = "SELECT * FROM validation WHERE colonist_id = ? AND summer_camp_id = ?";
		$resultRow = $this -> executeRow($this -> db, $sql, array($colonistId, $summerCampId));

		if (!$resultRow)
			return null;

		return Validation::createValidationObject($resultRow);
	}

	public function deleteValidation($colonistId, $summerCampId) {
		$this->Logger->info("Running: ". __METHOD__);
		$deleteSql = "DELETE FROM validation WHERE colonist_id = ? AND summer_camp_id = ?";
		return $this->execute($this->db, $deleteSql, array($colonistId, $summerCampId));
	}

}
?>
