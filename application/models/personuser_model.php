<?php

require_once APPPATH . 'core/CK_Model.php';
class personuser_model extends CK_Model{

	public function __construct(){
		parent::__construct();
	}


	public function insertNewUser($personId, $cpf, $login, $password, $occupation){
		$this->Logger->info("Running: " . __METHOD__);
		$sql = 'INSERT INTO person_user(person_id, cpf, login, password, occupation) VALUES (?,?,?,?,?)';

		if($this->execute($this->db, $sql, array(intval($personId), $cpf, $login, $password, $occupation)))
			return true;

		throw new Exception("User not inserted");
	}

	public function userLogin($login, $password){
		$this->Logger->info("Running: ". __METHOD__);

		//No Logging, i'm hiding the user password from the log here
		$sql = "SELECT person_id FROM person_user WHERE login = ? AND password = ?";
		$rs = $this->executeRowsNoLog($this->db, $sql, array($login, $password));

		if(isset($rs[0])){
			return $rs[0]->person_id;
		} else {
			return false;
		}
	}

	public function getUserById($person_id){
		$this->Logger->info("Running: " . __METHOD__);

		$sql = "select 
				p.person_id, pu.user_type, pu.login, a.address_id, pu.cpf, pu.occupation, 
				p.fullname, p.gender, p.email, p.benemerit, a.street, 
				a.place_number, a.complement, a.city, a.cep, a.uf, 
				a.neighborhood 
				from person_user as pu 
				natural join person as p 
				natural join address as a 
				where p.person_id = ?";

		$rows = $this->executeRows($this->db, $sql, array(intval($person_id)));

		if(isset($rows[0])) {
			return PersonUser::createUserObject($rows[0], true);
		}

		return null;

	}

	public function updatePersonUser($email, $cpf, $occupation, $person_id) {
		$this->Logger->info("Running: " . __METHOD__);
        $sql = "UPDATE person_user SET login=?, cpf=?, occupation=? WHERE person_id=?";
        if ($this->execute($this->db, $sql, array($email, $cpf, $occupation, intval($person_id))))
            return true;
        return false;
    
    }

}

?>