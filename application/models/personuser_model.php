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
		$sql = "SELECT * FROM person_user WHERE login = ? AND password = ?";
		$rows = $this->db->query($sql, array($login, $password));

		if($rows->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

}

?>