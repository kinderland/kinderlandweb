<?php

require_once APPPATH . 'core/CK_Model.php';

class campaign_model extends CK_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getYearsCampaign() {
        $sql = "SELECT distinct EXTRACT(YEAR FROM date_created) as year_event FROM donation WHERE donation_type = 2;";
        $row = $this->executeRows($this->db, $sql);
        return $row;
    }

    public function getAssociatedCount($year) {
        $sql = "select 	count(donation_id), donation_status from donation_detailed
                where donation_type like 'associação'and EXTRACT(YEAR FROM date_created) = ?
                group by donation_status";
        return $this->executeRows($this->db, $sql, array(intval($year)));
    }

    public function getAllCampaigns() {
        $sql = "SELECT *
                FROM campaign
                ORDER BY date_finish DESC";
        $resultSet = $this->executeRows($this->db, $sql);

        $campaignArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campaignArray[] = Campaign::createCampaignObject($row);

        return $campaignArray;
    }

    public function insertNewCampaign($year, $date_created, $date_start, $date_finish, $price) {
        $sql = "INSERT INTO campaign(campaign_year,date_created,date_start,date_finish,price)
                VALUES (?,?,?,?,?)";
        $resultSet = $this->executeReturningId($this->db, $sql, array($year, $date_created, $date_start, $date_finish, $price));
        if ($resultSet)
            return $resultSet;
        return false;
    }

    public function getCurrentCampaign() {
        $sql = "SELECT * FROM campaign WHERE date_start<=NOW() AND date_finish>=NOW()";
        $resultSet = $this->executeRows($this->db, $sql);
        if (count($resultSet) !== 1)
            return false;
        $campaign = Campaign::createCampaignObject($resultSet[0]);
        return $campaign;
    }

}

?>