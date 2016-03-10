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

    public function getPastYearsCampaign() {
        $sql = "SELECT campaign_year FROM campaign WHERE EXTRACT(YEAR FROM date_start) <= EXTRACT(YEAR FROM NOW()) ORDER BY campaign_year DESC;";
        $row = $this->executeRows($this->db, $sql);
        return $row;
    }

    public function getAssociatedCount($year) {
        $sql = "SELECT count(distinct(d.person_id))
                FROM donation d
                WHERE d.donation_type = 2
                AND   d.donation_status = 2
                AND   d.date_created >= (SELECT c.date_start
                                         FROM campaign c
                                         WHERE campaign_year = '?')
                AND   d.date_created <= (SELECT cc.date_finish
                                         FROM campaign cc
                                         WHERE campaign_year = '?');";
        return $this->executeRows($this->db, $sql, array(intval($year), intval($year)));
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
        $sql = "INSERT INTO campaign(campaign_year,date_created,date_start,date_finish)
                VALUES (?,?,?,?)";
        $resultSet = $this->executeReturningId($this->db, $sql, array($year, $date_created, $date_start, $date_finish));
        if ($resultSet)
            return $resultSet;
        return false;
    }

    public function getCurrentYearCampaign() {
        $sql = "SELECT *
                FROM campaign
                WHERE EXTRACT(YEAR FROM date_start) = EXTRACT(YEAR FROM NOW())";
        $resultSet = $this->executeRows($this->db, $sql);
        if (count($resultSet) !== 1)
            return false;
        $campaign = Campaign::createCampaignObject($resultSet[0]);
        return $campaign;
    }

    public function getCampaignById($Id) {
        $sql = "SELECT * FROM campaign WHERE campaign_id = '?'";
        $resultSet = $this->executeRows($this->db, $sql, array(intval($Id)));
        if ($resultSet) {
            $campaign = Campaign::createCampaignObject($resultSet[0]);
            return $campaign;
        }
        return false;
    }

    public function CheckCampaignCurrency($campaign_id) {
        $sql = "SELECT * FROM campaign WHERE campaign_id = '?' AND date_start<=NOW()";
        $resultSet = $this->executeRows($this->db, $sql, array(intval($campaign_id)));
        if ($resultSet)
            return true;
        return false;
    }

    public function updateCampaign($campaign_id, $date_start, $date_finish) {
        $sql = "UPDATE campaign SET date_start = ?, date_finish=? WHERE campaign_id='?'";
        $resultSet = $this->execute($this->db, $sql, array($date_start, $date_finish, intval($campaign_id)));
        return $resultSet;
    }

    public function InsertNewPaymentPeriod($campaignId, $date_start, $date_finish, $price, $portions) {
        $sql = "INSERT INTO campaign_payment_period(campaign_id,date_start,date_finish,price,portions) VALUES (?,?,?,?,?)";
        $resultSet = $this->execute($this->db, $sql, array(intval($campaignId), $date_start, $date_finish, $price, intval($portions)));
        if ($resultSet)
            return $resultSet;
        return false;
    }

    public function GetCurrentPeriod($campaignId) {
        $sql = "SELECT * FROM campaign_payment_period WHERE campaign_id=? AND date_start<=NOW() AND date_finish>=NOW()";
        $result = $this->executeRow($this->db, $sql, array(intval($campaignId)));
        if ($result)
            return $result;
        return false;
    }

    public function GetCampaignPeriods($campaignId) {
        $sql = "SELECT * FROM campaign_payment_period WHERE campaign_id=?";
        $result = $this->executeRows($this->db, $sql, array(intval($campaignId)));
        if ($result)
            return $result;
        return false;
    }

    public function DeleteOldPeriods($campaign_id)
    {
       $sql = "DELETE FROM campaign_payment_period WHERE campaign_id=?";
       $result = $this->execute($this->db,$sql,array(intval($campaign_id)));
       return $result;
    }
    
    public function getContributorsByPeriod($year,$month){
        $sql="SELECT count(*)
              FROM donation d
              WHERE d.donation_status=2
              AND d.donation_type=2
              AND EXTRACT(YEAR FROM d.date_created)='?'
              AND EXTRACT(MONTH FROM d.date_created)='?'";
        
        $result=$this->executeRow($this->db,$sql,array(intval($year),intval($month)));
        return $result;
    }
}

