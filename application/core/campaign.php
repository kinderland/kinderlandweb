<?php

class Campaign {

    private $campaignId;
    private $campaignYear;
    private $dateStart;
    private $dateFinish;
    private $price;

    public function __construct($campaignId, $campaignYear = NULL, $dateStart = NULL, $dateFinish = NULL, $price = NULL) {
        $this->campaignId = $campaignId;
        $this->campaignYear = $campaignYear;
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
        $this->price = $price;
    }

    public static function createCampaignObject($resultRow) {
        return new Campaign($resultRow->campaign_id, $resultRow->campaign_year, $resultRow->date_start, $resultRow->date_finish, $resultRow->price);
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

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

}
