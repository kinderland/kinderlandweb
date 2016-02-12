<?php

require_once APPPATH . 'core/CK_Model.php';

class campaign_model extends CK_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getYearsCampaign() {
        $sql = "SELECT campaign_year FROM campaign ORDER BY campaign_year DESC;";
        $row = $this->executeRows($this->db, $sql);
        return $row;
    }

    public function getAssociatedCount($year) {
        $sql = "SELECT count(*)
                FROM donation d
                WHERE d.donation_type = 2
                AND   d.donation_status = 2
                AND   d.date_created >= (SELECT c.date_start
                                         FROM campaign c
                                         WHERE campaign_year ='2015')
                AND   d.date_created <= (SELECT cc.date_finish
                                         FROM campaign cc
                                         WHERE campaign_year = '2015');";
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