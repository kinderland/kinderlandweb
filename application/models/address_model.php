<?php

require_once APPPATH . 'core/CK_Model.php';

class address_model extends CK_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf){
		$sql = 'INSERT INTO address(street, place_number, complement, city, cep, neighborhood, uf) VALUES (?,?,?,?,?,?,?)';
		$result = $this->executeReturningId($this->db, $sql, array($street, intval($number), $complement, $city, $cep, $neighborhood, $uf));

		if($result)
			return $result;

		return false;
	}

	public function getAddressByPersonId($person_id){
        $sql = "SELECT * FROM person p LEFT JOIN address a on a.address_id = p.address_id WHERE p.person_id=?";
        $row = $this->executeRow($this->db, $sql, array(intval($person_id)));
    
        if($row) {
            return Address::createAddressObject($row);
        }
        else {
            return false;
        }
    }

    public function updateAddress($street, $place_number, $complement, $city, $cep, $uf, $neighborhood, $address_id) {
        $sql = "UPDATE address SET street=?, place_number=?, complement=?, city=?, cep=?, uf=?, neighborhood=? WHERE address_id=?";
        if ($this->execute($this->db, $sql, array($street, $place_number, $complement, $city, $cep, $uf, $neighborhood, intval($address_id))))
            return true;
        return false;
    }


}

?>