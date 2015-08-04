<?php
class Validation {
	private $campId;
	private $colonistId;
	private $colonistGenderOk;
	private $colonistPictureOk;
	private $colonistIdentityOk;
	private $colonistBirthdayOk;
	private $colonistParentsNameOk;
	private $colonistNameOk;
	private $colonistGenderMsg;
	private $colonistPictureMsg;
	private $colonistIdentityMsg;
	private $colonistBirthdayMsg;
	private $colonistParentsNameMsg;
	private $colonistNameMsg;

	public function __construct($campId, $colonistId, $colonistGenderOk, $colonistPictureOk, $colonistIdentityOk, $colonistBirthdayOk, $colonistParentsNameOk, $colonistNameOk, $colonistGenderMsg, $colonistPictureMsg, $colonistIdentityMsg, $colonistBirthdayMsg, $colonistParentsNameMsg, $colonistNameMsg) {
		$this -> campId = $campId;
		$this -> colonistId = $colonistId;
		$this -> colonistGenderOk = $colonistGenderOk;
		$this -> colonistPictureOk = $colonistPictureOk;
		$this -> colonistIdentityOk = $colonistIdentityOk;
		$this -> colonistBirthdayOk = $colonistBirthdayOk;
		$this -> colonistParentsNameOk = $colonistParentsNameOk;
		$this -> colonistNameOk = $colonistNameOk;
		$this -> colonistGenderMsg = $colonistGenderMsg;
		$this -> colonistPictureMsg = $colonistPictureMsg;
		$this -> colonistIdentityMsg = $colonistIdentityMsg;
		$this -> colonistBirthdayMsg = $colonistBirthdayMsg;
		$this -> colonistParentsNameMsg = $colonistParentsNameMsg;
		$this -> colonistNameMsg = $colonistNameMsg;
	}

	public static function createValidationObject($resultRow) {
		return new Validation($resultRow -> summer_camp_id, $resultRow -> colonist_id, $resultRow -> colonist_gender_ok, $resultRow -> colonist_picture_ok, $resultRow -> colonist_identity_ok, $resultRow -> colonist_birthday_ok, $resultRow -> colonist_parents_name_ok, $resultRow -> colonist_name_ok, $resultRow -> colonist_gender_msg, $resultRow -> colonist_picture_msg, $resultRow -> colonist_identity_msg, $resultRow -> colonist_birthday_msg, $resultRow -> colonist_parents_name_msg, $resultRow -> colonist_name_msg);
	}

	public function setCampId($campId) {
		$this -> campId = $campId;
	}

	public function getCampId() {
		return $this -> campId;
	}

	public function setColonistId($colonistId) {
		$this -> colonistId = $colonistId;
	}

	public function getColonistId() {
		return $this -> colonistId;
	}

	public function setColonistGenderOk($colonistGenderOk) {
		$this -> colonistGenderOk = $colonistGenderOk;
	}

	public function getColonistGenderOk() {
		return $this -> colonistGenderOk;
	}

	public function setColonistPictureOk($colonistPictureOk) {
		$this -> colonistPictureOk = $colonistPictureOk;
	}

	public function getColonistPictureOk() {
		return $this -> colonistPictureOk;
	}

	public function setColonistIdentityOk($colonistIdentityOk) {
		$this -> colonistIdentityOk = $colonistIdentityOk;
	}

	public function getColonistIdentityOk() {
		return $this -> colonistIdentityOk;
	}

	public function setColonistBirthdayOk($colonistBirthdayOk) {
		$this -> colonistBirthdayOk = $colonistBirthdayOk;
	}

	public function getColonistBirthdayOk() {
		return $this -> colonistBirthdayOk;
	}

	public function setColonistParentsNameOk($colonistParentsNameOk) {
		$this -> colonistParentsNameOk = $colonistParentsNameOk;
	}

	public function getColonistParentsNameOk() {
		return $this -> colonistParentsNameOk;
	}

	public function setColonistNameOk($colonistNameOk) {
		$this -> colonistNameOk = $colonistNameOk;
	}

	public function getColonistNameOk() {
		return $this -> colonistNameOk;
	}

	public function setColonistGenderMsg($colonistGenderMsg) {
		$this -> colonistGenderMsg = $colonistGenderMsg;
	}

	public function getColonistGenderMsg() {
		return $this -> colonistGenderMsg;
	}

	public function setColonistPictureMsg($colonistPictureMsg) {
		$this -> colonistPictureMsg = $colonistPictureMsg;
	}

	public function getColonistPictureMsg() {
		return $this -> colonistPictureMsg;
	}

	public function setColonistIdentityMsg($colonistIdentityMsg) {
		$this -> colonistIdentityMsg = $colonistIdentityMsg;
	}

	public function getColonistIdentityMsg() {
		return $this -> colonistIdentityMsg;
	}

	public function setColonistBirthdayMsg($colonistBirthdayMsg) {
		$this -> colonistBirthdayMsg = $colonistBirthdayMsg;
	}

	public function getColonistBirthdayMsg() {
		return $this -> colonistBirthdayMsg;
	}

	public function setColonistParentsNameMsg($colonistParentsNameMsg) {
		$this -> colonistParentsNameMsg = $colonistParentsNameMsg;
	}

	public function getColonistParentsNameMsg() {
		return $this -> colonistParentsNameMsg;
	}

	public function setColonistNameMsg($colonistNameMsg) {
		$this -> colonistNameMsg = $colonistNameMsg;
	}

	public function getColonistNameMsg() {
		return $this -> colonistNameMsg;
	}

	public function describeValidation() {
		$text = "<b>Motivos:</b>";
		if ($this -> colonistBirthdayOk === "f")
			$text .= "<br><b>Data de nascimento:</b> " . $this -> colonistBirthdayMsg;
		if ($this -> colonistGenderOk === "f")
			$text .= "<br><b>Genero:</b> " . $this -> colonistGenderMsg;
		if ($this -> colonistNameOk === "f")
			$text .= "<br><b>Nome completo do colonista:</b> " . $this -> colonistNameMsg;
		if ($this -> colonistParentsNameOk === "f")
			$text .= "<br><b>Nome completo dos pais:</b> " . $this -> colonistParentsNameMsg;
		if ($this -> colonistIdentityOk === "f")
			$text .= "<br><b>Documento de identificação:</b> " . $this -> colonistIdentityMsg;
		if ($this -> colonistPictureOk === "f")
			$text .= "<br><b>Foto 3x4:</b> " . $this -> colonistPictureMsg;
		return $text;
	}
	
	public function verifySubscription(){
		return $this -> colonistBirthdayOk === "t" && $this -> colonistGenderOk === "t" && $this -> colonistNameOk === "t" && $this -> colonistParentsNameOk === "t";
	}

	public function verifyDocument($documentId) {
		switch ($documentId) {
			case DOCUMENT_GENERAL_RULES :
			case DOCUMENT_TRIP_AUTHORIZATION :
			case DOCUMENT_MEDICAL_FILE :
				return true;
				break;

			case DOCUMENT_IDENTIFICATION_DOCUMENT :
				return $this -> colonistIdentityOk === "t";
				break;

			case DOCUMENT_PHOTO_3X4 :
				return $this -> colonistPictureOk === "t";
				break;

			default :
				return false;
				break;
		}
	}

	public function getDocumentData($documentId) {
		switch ($documentId) {
			case DOCUMENT_GENERAL_RULES :
			case DOCUMENT_TRIP_AUTHORIZATION :
			case DOCUMENT_MEDICAL_FILE :
				return true;
				break;

			case DOCUMENT_IDENTIFICATION_DOCUMENT :
				return $this -> colonistIdentityMsg;
				break;

			case DOCUMENT_PHOTO_3X4 :
				return $this -> colonistPictureMsg;
				break;

			default :
				return false;
				break;
		}
	}


}
?>