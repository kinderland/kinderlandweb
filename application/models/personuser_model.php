<?php

class personuser_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}


	public function insertNewUser($personId, $cpf, $login, $password, $occupation){
		$sql = 'INSERT INTO person_user(person_id, cpf, login, password, occupation) VALUES (?,?,?,?,?)';
		$result = $this->db->query($sql, array($personId, $cpf, $login, $password, $occupation));

		if($result)
			return true;

		throw new Exception("User not inserted");
	}

	public function userLogin($login, $password){
		$sql = "SELECT person_id FROM person_user WHERE login = ? AND password = ?";
		$rows = $this->db->query($sql, array($login, $password));

		if($rows->num_rows() > 0){
			return $rows->row()->person_id;
		}
		else{
			return false;
		}
	}

	public function getUserById($person_id){
		$sql = "select 
				p.person_id, pu.cpf, pu.occupation, 
				p.fullname, p.gender, p.email, p.benemerit, a.street, 
				a.place_number, a.complement, a.city, a.cep, a.uf, 
				a.neighborhood 
				from person_user as pu 
				natural join person as p 
				natural join address as a 
				where p.person_id = ?";

		$rows = $this->db->query($sql, array($person_id));

		if($rows->num_rows() > 0){
			return $rows->row();
		}

		return null;

	}

}

?>