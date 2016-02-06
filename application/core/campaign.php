<?php

class Campaign {

    private $campaignId;
    private $campaignYear;
    private $dateStart;
    private $dateFinish;

    public function __construct($campaignId, $campaignYear, $dateStart, $dateFinish) {
        $this->campaignId = $campaignId;
        $this->campaignYear = $campaignYear;
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
    }

    public static function createCampaignObject($resultRow) {
        return new Campaign($resultRow->campaign_id, $resultRow->campaign_year, $resultRow->date_start, $resultRow->date_finish);
    }

    public function setCampaignId($campaignId) {
        $this->campaignId = $campaignId;
    }

    public function getCampaignId() {
        return $this->campaignId;
    }

    public function setCampaignYear($campaignYear) {
        $this->campaignYear = $campaignYear;
    }

    public function getCampaignYear() {
        return $this->campaignYear;
    }

    public function setDateStart($dateStart) {
        $this->dateStart = $dateStart;
    }

    public function getDateStart() {
        return $this->dateStart;
    }

    public function setDateFinish($dateFinish) {
        $this->dateFinish = $dateFinish;
    }

    public function getDateFinish() {
        return $this->dateFinish;
    }

}
