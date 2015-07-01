<?php
require_once APPPATH . 'core/CK_Model.php';

class validation_model extends CK_Model {

	public function __construct() {
		parent::__construct();
	}

	public function updateColonistValidation($colonistId, $summerCampId, $registerDataOk, $pictureOk, $identityOk,
			$msgRegisterData, $msgPicture, $msgIdentity){
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT * FROM validation WHERE colonist_id = ? AND summer_camp_id = ?";
		$result = $this->executeRow($this->db, $sql, array(intval($colonistId), intval($summerCampId)));

		if($result) {
			$updateSql = "UPDATE validation SET colonist_data_ok = ?, colonist_picture_ok = ?, 
				colonist_identity_ok = ?, colonist_data_msg = ?, colonist_picture_msg = ?, colonist_identity_msg = ?
				WHERE colonist_id = ? AND summer_camp_id = ?";

			return $this->execute($this->db, $updateSql, array( $registerDataOk, 
																$pictureOk,
																$identityOk,
																$msgRegisterData, $msgPicture, $msgIdentity,
																intval($colonistId), intval($summerCampId)));
		} else {
			$insertSql = "INSERT INTO validation (colonist_id, summer_camp_id, colonist_data_ok, 
				colonist_picture_ok, colonist_identity_ok, colonist_data_msg, colonist_picture_msg, 
				colonist_identity_msg) VALUES (?,?,?,?,?,?,?,?)";

			return $this->execute($this->db, $insertSql, array( intval($colonistId), intval($summerCampId),
																$registerDataOk, 
																$pictureOk,
																$identityOk,
																$msgRegisterData, $msgPicture, $msgIdentity));
		}

	}

}

?>