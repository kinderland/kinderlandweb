<?php

class SummerCamp {

    private $campId;
    private $campName;
    private $dateCreated;
    private $dateStart;
    private $dateFinish;
    private $dateStartPre;
    private $dateFinishPre;
    private $dateStartPreAssociate;
    private $dateFinishPreAssociate;
    private $description;
    private $preEnabled;
    private $capacityMale;
    private $capacityFemale;
    private $miniCamp;
    private $daysToPay;

    public function __construct($campId, $campName, $dateCreated, $dateStart, $dateFinish, $dateStartPre, $dateFinishPre, $dateStartPreAssociate, $dateFinishPreAssociate, $description, $preEnabled, $capacityMale, $capacityFemale, $miniCamp = false, $daysToPay = 5) {
        $this->campId = $campId;
        $this->campName = $campName;
        $this->dateCreated = $dateCreated;
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
        $this->dateStartPre = $dateStartPre;
        $this->dateFinishPre = $dateFinishPre;
        $this->dateStartPreAssociate = $dateStartPreAssociate;
        $this->dateFinishPreAssociate = $dateFinishPreAssociate;
        $this->description = $description;
        $this->preEnabled = $preEnabled;
        $this->capacityMale = $capacityMale;
        $this->capacityFemale = $capacityFemale;
        $this->miniCamp = $miniCamp;
        $this->daysToPay = $daysToPay;
    }

    public static function createCampObject($resultRow) {
        return new SummerCamp(
                $resultRow->summer_camp_id, 
                $resultRow->camp_name, 
                $resultRow->date_created, 
                $resultRow->date_start, 
                $resultRow->date_finish, 
                $resultRow->date_start_pre_subscriptions, 
                $resultRow->date_finish_pre_subscriptions, 
                $resultRow->date_start_pre_subscriptions_associate, 
                $resultRow->date_finish_pre_subscriptions_associate, 
                $resultRow->description, 
                $resultRow->pre_subscriptions_enabled, 
                $resultRow->capacity_male, 
                $resultRow->capacity_female, 
                $resultRow->mini_camp, 
                $resultRow->days_to_pay
        );
    }

    public function setCampId($campId) {
        $this->campId = $campId;
    }

    public function getCampId() {
        return $this->campId;
    }

    public function setCampName($campName) {
        $this->campName = $campName;
    }

    public function getCampName() {
        return $this->campName;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
    }

    public function getDateCreated() {
        return $this->dateCreated;
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

    public function setDateStartPre($dateStartPre) {
        $this->dateStartPre = $dateStartPre;
    }

    public function getDateStartPre() {
        return $this->dateStartPre;
    }

    public function setDateFinishPre($dateFinishPre) {
        $this->dateFinishPre = $dateFinishPre;
    }

    public function getDateFinishPre() {
        return $this->dateFinishPre;
    }

    public function setDateStartPreAssociate($dateStartPreAssociate) {
        $this->dateStartPreAssociate = $dateStartPreAssociate;
    }

    public function getDateStartPreAssociate() {
        return $this->dateStartPreAssociate;
    }

    public function setDateFinishPreAssociate($dateFinishPreAssociate) {
        $this->dateFinishPreAssociate = $dateFinishPreAssociate;
    }

    public function getDateFinishPreAssociate() {
        return $this->dateFinishPreAssociate;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setEnabled($preEnabled) {
        $this->preEnabled = $preEnabled;
    }

    public function isEnabled() {
        if ($this->preEnabled == "t")
            return TRUE;
        return FALSE;
    }

    public function setCapacityMale($capacityMale) {
        $this->capacityMale = $capacityMale;
    }

    public function getCapacityMale() {
        return $this->capacityMale;
    }

    public function setCapacityFemale($capacityFemale) {
        $this->capacityFemale = $capacityFemale;
    }

    public function getCapacityFemale() {
        return $this->capacityFemale;
    }

    public function setMiniCamp($miniCamp) {
        $this->miniCamp = $miniCamp;
    }

    public function isMiniCamp() {
        if ($this->miniCamp == "t" || $this->miniCamp == "true")
            return TRUE;
        return FALSE;
    }

    public function setDaysToPay($daysToPay) {
        $this->daysToPay = $daysToPay;
    }

    public function getDaysToPay() {
        return $this->daysToPay;
    }
}

?>