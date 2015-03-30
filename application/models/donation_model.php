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

    public function getDonationPortionsMax($donation){
        $sql = "select * from payment_period where event_id in (select event_id from event_subscription where donation_id = ?) 
                and date_start <= ? and date_finish >= ?";
        $result = $this->executeRow($this->db, $sql, array($donation->donation_id, $donation->date_created, $donation->date_created));

        return $result->portions;
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