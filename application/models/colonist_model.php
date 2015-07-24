<?php
require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/colonist.php';
require_once APPPATH . 'core/person.php';
class colonist_model extends CK_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertColonist($personId, $birthdate,$documentNumber,$documentType){
		$this->Logger->info("Running: " . __METHOD__);
		$birthdate = CK_CONTROLLER::toYYYYMMDD($birthdate);

		$sql = 'INSERT INTO colonist (person_id, birth_date, document_number, document_type) VALUES (?, ?, ?, ?)';
		$returnId = $this->executeReturningId($this->db, $sql, array($personId, $birthdate, $documentNumber, $documentType));
		if($returnId)
			return $returnId;

		return false;
	}

	public function updateColonist($personId, $birthdate,$documentNumber,$documentType,$colonistId){
		$this->Logger->info("Running: " . __METHOD__);
		$birthdate = CK_CONTROLLER::toYYYYMMDD($birthdate);

		$sql = 'UPDATE colonist SET person_id=?, birth_date=?, document_number=?, document_type=? where colonist_id = ?';
		$returnId = $this->execute($this->db, $sql, array($personId, $birthdate, $documentNumber, $documentType,intval($colonistId)));
		if($returnId)
			return $returnId;

		return false;
	}

	public function getColonist($colonistId){
		$this->Logger->info("Running: " . __METHOD__);

		$sql = "SELECT * FROM colonist c JOIN person p on p.person_id = c.person_id WHERE colonist_id = ?";
		$resultRow = $this->executeRow($this->db, $sql, array($colonistId));

		if($resultRow)
			return Colonist::createColonistObject($resultRow);

		return null;
	}

	public function getColonistPersonUser($colonistId, $summerCampId) {
		$this->Logger->info("Running: " . __METHOD__);

		$sql = "SELECT p.* FROM summer_camp_subscription c 
				JOIN person p on c.person_user_id = p.person_id 
				WHERE c.colonist_id = ? AND c.summer_camp_id = ?";
		$resultRow = $this->executeRow($this->db, $sql, array($colonistId, $summerCampId));

		if($resultRow)
			return Person::createPersonObjectSimple($resultRow);

		return null;
	}

}
?>
