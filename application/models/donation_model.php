<?php
require_once APPPATH . 'core/CK_Model.php';

class donation_model extends CK_Model{

	public function __construct(){
		parent::__construct();
	}
    
    public function getDonationById($donationId){
        $sql = "SELECT * FROM donation WHERE donation_id = ?";
        $resultSet = $this->executeRow($this->db, $sql, array(intval($donationId)));

        if($resultSet)
            return $resultSet;//Donation::createDonationObject($row);
            
        return null;
    }

    public function createDonation($userId, $totalPrice, $donationType){
        $this->Logger->info("Running: ". __METHOD__);
        $sql = "INSERT INTO donation(person_id, donated_value, donation_type, donation_status) 
                VALUES ($userId, $totalPrice, $donationType, 1)";
        $result = $this->executeReturningId($this->db, $sql);

        if($result){
            return $result;
        }
    }

    
}
?>