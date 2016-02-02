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

    public function insertNewCampaign($year, $date_created, $date_start, $date_finish) {
        $id = $this->getCampaignNextId();
        $sql = "INSERT INTO campaign(campaign_year,date_created,date_start,date_finish)
                VALUES (" . $year . ",'" . $date_created . "','" . $date_start . "','" . $date_finish . "')";
        $resultSet = $this->executeReturningId($this->db, $sql);
        if ($resultSet)
            return $resultSet;
        return false;
    }

    public function getCampaignNextId() {
        $sql = "SELECT max(campaign_id)+1 as 1
                FROM campaign";
        $resultSet = $this->executeRows($this->db, $sql);
        if (!$resultSet)
            return 1;
        return $resultSet;
    }

}

?>