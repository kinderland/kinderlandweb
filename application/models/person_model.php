<?php
require_once APPPATH . 'core/CK_Model.php';
class person_model extends CK_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertNewPerson($fullname, $gender, $email, $addressId){
		$this->Logger->info("Running: " . __METHOD__);

		$sql = 'INSERT INTO person (fullname, date_created, gender, email, address_id) VALUES (?, current_timestamp, ?, ?, ?)';
		$returnId = $this->executeReturningId($this->db, $sql, array($fullname, $gender, $email, intval($addressId)));
		if($returnId)
			return $returnId;

		return false;
	}

	public function insertPersonSimple($fullname, $gender){
		$this->Logger->info("Running: " . __METHOD__);

		$sql = 'INSERT INTO person (fullname, date_created, gender) VALUES (?, current_timestamp, ?)';
		$returnId = $this->executeReturningId($this->db, $sql, array($fullname, $gender));
		if($returnId)
			return $returnId;

		return false;
	}

 	public function updatePerson($fullname, $gender, $email, $person_id) {
 		$this->Logger->info("Running: " . __METHOD__);
 		
        $sql = "UPDATE person SET fullname=?, gender=?, email=? WHERE person_id=?";
        if ($this->execute($this->db, $sql, array($fullname, $gender, $email, intval($person_id))))
            return true;
        return false;
    } 
	
}
?>