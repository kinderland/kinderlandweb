<?php
require_once APPPATH . 'core/CK_Model.php';

class validation_model extends CK_Model {

	public function __construct() {
		parent::__construct();
	}

	public function updateColonistValidation($colonistId, $summerCampId, 
			$genderOk, $pictureOk, $identityOk, $birthdayOk, $parentsNameOk, $colonistNameOk,
			$msgGender, $msgPicture, $msgIdentity, $msgBirthdate, $msgParentsName, $msgColonistName){
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT * FROM validation WHERE colonist_id = ? AND summer_camp_id = ?";
		$result = $this->executeRow($this->db, $sql, array(intval($colonistId), intval($summerCampId)));

		if($result) {
			$updateSql = "UPDATE validation SET colonist_gender_ok = ?, colonist_picture_ok = ?, 
				colonist_identity_ok = ?, colonist_birthday_ok = ?, colonist_parents_name_ok = ?, 
				colonist_name_ok = ?, colonist_gender_msg = ?, colonist_picture_msg = ?, colonist_identity_msg = ?,
				colonist_birthday_msg = ?, colonist_parents_name_msg = ?, colonist_name_msg = ?
				WHERE colonist_id = ? AND summer_camp_id = ?";

			return $this->execute($this->db, $updateSql, array( $genderOk, $pictureOk, $identityOk, $birthdayOk, $parentsNameOk, $colonistNameOk,
																$msgGender, $msgPicture, $msgIdentity, $msgBirthdate, $msgParentsName, $msgColonistName,
																intval($colonistId), intval($summerCampId)));
		} else {
			$insertSql = "INSERT INTO validation (colonist_id, summer_camp_id, colonist_gender_ok, colonist_picture_ok, 
				colonist_identity_ok, colonist_birthday_ok, colonist_parents_name_ok, 
				colonist_name_ok, colonist_gender_msg, colonist_picture_msg, colonist_identity_msg,
				colonist_birthday_msg, colonist_parents_name_msg, colonist_name_msg) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

			return $this->execute($this->db, $insertSql, array( intval($colonistId), intval($summerCampId),
																$genderOk, $pictureOk, $identityOk, $birthdayOk, $parentsNameOk, $colonistNameOk,
																$msgGender, $msgPicture, $msgIdentity, $msgBirthdate, $msgParentsName, $msgColonistName));
		}

	}

	public function getColonistValidationInfo($colonistId, $summerCampId){
		$sql = "SELECT * FROM validation WHERE colonist_id = ? AND summer_camp_id = ?";
		$resultRow = $this->executeRow($this->db, $sql, array($colonistId, $summerCampId));

		if(!$resultRow)
			return null;

		return $resultRow;
	}
}

?>