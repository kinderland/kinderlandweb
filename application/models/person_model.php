<?php
class person_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertNewPerson($fullname, $gender, $email, $addressId){
		$sql = 'INSERT INTO person (fullname, date_created, gender, email, address_id) VALUES (?, current_timestamp, ?, ?, ?)';
		$result = $this->db->query($sql, array($fullname, $gender, $email, $addressId));

		if($result)
			return $this->db->insert_id();

		return false;
	}

}
?>