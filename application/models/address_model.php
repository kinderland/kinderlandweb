
<?php

class address_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function insertNewAddress($street, $number, $complement, $cep, $neighborhood, $city, $uf){
		$sql = 'INSERT INTO address(street, place_number, complement, city, cep, neighborhood, uf) VALUES (?,?,?,?,?,?,?)';
		$result = $this->db->query($sql, array($street, $number, $complement, $city, $cep, $neighborhood, $uf));

		if($result)
			return $this->db->insert_id();

		return false;
	}

	public function getAddressByPersonId($person_id){
        $sql = "SELECT * FROM person WHERE person_id=".$person_id;
        $rows = $this->db->query($sql);
    
        if($rows->num_rows() > 0) {
            return Address::createAddressObject($rows->row());
        }
        else {
            return false;
        }
    }

    public function updateAddress($street, $place_number, $complement, $city, $cep, $uf, $neighborhood, $address_id) {
        $sql = "UPDATE address SET street=?, place_number=?, complement=?, city=?, cep=?, uf=?, neighborhood=? WHERE address_id=?";
        if ($this->db->query($sql, array($street, $place_number, $complement, $city, $cep, $uf, $neighborhood, $address_id)))
            return true;
        return false;
    }


}

?>