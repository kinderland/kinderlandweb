<?php

class telephone_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertNewTelephone($number, $personId){
		$sql = 'INSERT INTO telephone(phone_number, person_id) VALUES (?,?)';
		$result = $this->db->query($sql, array($number, intval($personId)));

		if($result)
			return true;

		return false;
	}

	public function updatePhone($person_id, $phone1, $phone2) {
        $sqlDel = "DELETE FROM telephone WHERE person_id=?";
        $this->db->query($sqlDel, array(intval($person_id)));
        
        $this->telephone_model->insertNewTelephone($phone1, $person_id);
        if($phone2){
            $this->telephone_model->insertNewTelephone($phone2, $person_id);
        }

    }


}

?>