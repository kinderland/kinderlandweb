<?php

require_once APPPATH . 'core/CK_Model.php';

class campaign_model extends CK_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getYearsCampaign() {
        $sql = "SELECT EXTRACT(YEAR FROM date_start) as year_event FROM event;";
        $row = $this->executeRow($this->db, $sql);
        return $row;
    }

    public function getAssociatedCount($year) {
        $sql = "select 	count(donation_id), donation_status from donation_detailed
                where donation_type like 'associacao'and EXTRACT(YEAR FROM date_created) = ?
                group by donation_status";
        return $this->executeRows($this->db, $sql, array(intval($year)));
    }

}

?>