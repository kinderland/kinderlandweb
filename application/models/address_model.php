
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

}

?>