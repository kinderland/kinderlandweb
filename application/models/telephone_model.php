
<?php

class telephone_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertNewTelephone($number, $personId){
		$sql = 'INSERT INTO telephone(phone_number, person_id) VALUES (?,?)';
		$result = $this->db->query($sql, array($number, $personId));

		if($result)
			return true;

		return false;
	}

}

?>