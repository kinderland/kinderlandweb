<?php

require_once APPPATH . 'core/CK_Model.php';

class person_model extends CK_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertNewPerson($fullname, $gender, $email, $addressId) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'INSERT INTO person (fullname, date_created, gender, email, address_id) VALUES (?, current_timestamp, ?, ?, ?)';
        $returnId = $this->executeReturningId($this->db, $sql, array($fullname, $gender, $email, $addressId));
        if ($returnId)
            return $returnId;

        return false;
    }

    public function insertPersonWithoutAddress($fullname, $gender, $email) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'INSERT INTO person (fullname, date_created, gender,email) VALUES (?, current_timestamp, ?,?)';
        $returnId = $this->executeReturningId($this->db, $sql, array($fullname, $gender, $email));
        if ($returnId)
            return $returnId;

        return false;
    }

    public function insertPersonSimple($fullname, $gender) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'INSERT INTO person (fullname, date_created, gender) VALUES (?, current_timestamp, ?)';
        $returnId = $this->executeReturningId($this->db, $sql, array($fullname, $gender));
        if ($returnId)
            return $returnId;

        return false;
    }

    public function updatePerson($fullname, $gender, $email, $person_id, $address_id) {
        $this->Logger->info("Running: " . __METHOD__);
        
        $arrayList = array();
        
        if (!empty($person_id)) {
            $sql = "UPDATE person SET";
            
            if(!empty($fullname)){
            	$sql = $sql." fullname=?";
            	$arrayList[] = $fullname;
            }
            if(!empty($gender)){
            	$sql = $sql.", gender=?";
            	$arrayList[] = $gender;
            }
            
            $sql = $sql.", email=?";
            $arrayList[] = $email;
            
            if(!empty($adress_id)){
            	$sql = $sql.", address_id=?";
            	$arrayList[] = $address_id;
            }
            	
            $sql = $sql." WHERE person_id=?";
            $arrayList[] = intval($person_id);
            
            if ($this->execute($this->db, $sql, $arrayList))
                return true;
        }
        return false;
    }

    public function getPersonById($personId) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT * FROM person WHERE person_id = ?";
        $result = $this->executeRow($this->db, $sql, array(intval($personId)));

        if ($result)
            return Person::createPersonObjectSimple($result);

        return null;
    }

    public function getPersonFullById($personId) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT *, (SELECT phone_number FROM telephone WHERE person_id = ? LIMIT 1) AS phone1,
                    (SELECT phone_number FROM telephone WHERE person_id = ? LIMIT 1 OFFSET 1) AS phone2
    			FROM person p
    			LEFT JOIN address a on a.address_id = p.address_id
    			LEFT JOIN person_user pu on pu.person_id = p.person_id
    			WHERE p.person_id = ?";
        $result = $this->executeRow($this->db, $sql, array(intval($personId), intval($personId), intval($personId)));

        if (!$result)
            return null;

        return $result;
    }

    public function emailExists($email) {
        $sql = "SELECT * FROM person WHERE email=?";
        $resultSet = $this->executeRow($this->db, $sql, array($email));

        if ($resultSet)
            return true;

        return false;
    }

    public function getUserPermissionsDetailed($letra) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT * FROM v_users_permissions WHERE lower(fullname) LIKE lower('$letra%')";

        $rows = $this->executeRows($this->db, $sql);

        return $rows;
    }

    public function updateUserPermissions($person_id, $arrNewPermissions) {
        $this->Logger->info("Running: " . __METHOD__);
        $deleteSql = "DELETE FROM person_user_type WHERE person_id = ?";
        if (!$this->execute($this->db, $deleteSql, array(intval($person_id))))
            throw new Exception("Failed to delete previous records");

        $insertSql = "INSERT INTO person_user_type(person_id, user_type) VALUES
					(" . $person_id . ", 1)";
        if ($arrNewPermissions['system_admin'])
            $insertSql .= ", (" . $person_id . ", 2)";

        if ($arrNewPermissions['director'])
            $insertSql .= ", (" . $person_id . ", 3)";

        if ($arrNewPermissions['secretary'])
            $insertSql .= ", (" . $person_id . ", 4)";

        if ($arrNewPermissions['coordinator'])
            $insertSql .= ", (" . $person_id . ", 5)";

        if ($arrNewPermissions['doctor'])
            $insertSql .= ", (" . $person_id . ", 6)";

        if ($arrNewPermissions['monitor'])
            $insertSql .= ", (" . $person_id . ", 7)";

        if (!$this->execute($this->db, $insertSql))
            throw new Exception("Failed to insert new records");

        return true;
    }
}

?>