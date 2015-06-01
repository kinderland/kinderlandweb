<?php
require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/summercamp.php';

class summercamp_model extends CK_Model{

	public function __construct(){
		parent::__construct();
	}
    
    public function getAllSummerCamps(){
        $sql = "SELECT * FROM summer_camp ORDER BY date_created DESC";
        $resultSet = $this->executeRows($this->db, $sql);

        $campArray = array();

        if($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);
            
        return $campArray;
    }

    public function insertNewCamp($camp){
        $sql = "INSERT INTO summer_camp (
                    camp_name, 
                    date_start, 
                    date_finish, 
                    date_start_pre_subscriptions, 
                    date_finish_pre_subscriptions,
                    date_start_pre_subscriptions_associate, 
                    date_finish_pre_subscriptions_associate, 
                    description, 
                    pre_subscriptions_enabled, 
                    capacity_male, 
                    capacity_female
                ) VALUES (
                    ?,?,?,?,?,?,?,?,".(($camp->isEnabled())?"true":"false").",?,?
                )";

        $paramArray = array(
                $camp->getCampName(),
                $camp->getDateStart(),
                $camp->getDateFinish(),
                $camp->getDateStartPre(),
                $camp->getDateFinishPre(),
                $camp->getDateStartPreAssociate(),
                $camp->getDateFinishPreAssociate(),
                $camp->getDescription(),
                intval($camp->getCapacityMale()),
                intval($camp->getCapacityFemale())
            );

        $campId = $this->executeReturningId($this->db, $sql, $paramArray);

        if($campId)
            return $campId;

        throw new ModelException("Insert object in the database");
        
    }

    public function updateCampPreEnabled($campId, $enabled){
        $sql = "UPDATE summer_camp SET pre_subscriptions_enabled = ".(($enabled)?"true":"false")." WHERE summer_camp_id = ?";
        $result = $this->execute($this->db, $sql, array(intval($campId)));

        return $result;
    }
}
?>