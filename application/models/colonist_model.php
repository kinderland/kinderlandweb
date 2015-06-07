<?php
require_once APPPATH . 'core/CK_Model.php';
class colonist_model extends CK_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertColonist($personId, $birthdate,$documentNumber,$documentType){
		$this->Logger->info("Running: " . __METHOD__);


		$sql = 'INSERT INTO colonist (person_id, birth_date, document_number, document_type) VALUES (?, ?, ?, ?)';
		$returnId = $this->executeReturningId($this->db, $sql, array($personId, $birthdate, $documentNumber, $documentType));
		if($returnId)
			return $returnId;

		return false;
	}

}
?>