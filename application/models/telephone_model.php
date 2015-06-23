<?php

require_once APPPATH . 'core/CK_Model.php';
class telephone_model extends CK_Model{

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
	
	public function getTelephonesByPersonId($personId){
		$sql = 'Select * from telephone where person_id = ?';
		$result = $this->executeRows($this -> db,$sql, array(intval($personId)));
		$telephone = array();
		foreach($result as $row){
			$telephone[] = $row->phone_number;
		}
		
		return $telephone;
		
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