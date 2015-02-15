<?php

class person_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertNewPerson($fullname, $gender, $email, $addressId){
		$sql = 'INSERT INTO person (fullname, date_created, gender, email, address_id) VALUES (?, current_timestamp, ?, ?, ?)';
		$result = $this->db->query($sql, array($fullname, $gender, $email, intval($addressId)));

		if($result)
			return $this->db->insert_id();

		return false;
	}

 	public function updatePerson($fullname, $gender, $email, $person_id) {
        $sql = "UPDATE person SET fullname=?, gender=?, email=? WHERE person_id=?";
        if ($this->db->query($sql, array($fullname, $gender, $email, intval($person_id))))
            return true;
        return false;
    } 
	
}
?>