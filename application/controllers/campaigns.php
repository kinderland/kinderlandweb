<?php

require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/campaign.php';

class Campaigns extends CK_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('campaign_model');
        $this->load->model('generic_model');
        $this->load->model('donation_model');

        $this->campaign_model->setLogger($this->Logger);
        $this->generic_model->setLogger($this->Logger);
        $this->donation_model->setLogger($this->Logger);
    }

    public function index() {
        $this->Logger->info("Starting " . __METHOD__);
        $data['fullname'] = $this->session->userdata("fullname");

        if (!$this->checkSession())
            redirect("login/index");

        $campaign = $this->campaign_model->getCurrentYearCampaign();
        if ($campaign) {
            $campaignId = $campaign->getCampaignId();
            $paymentPeriod = $this->campaign_model->GetCurrentPeriod($campaignId);
            $data['paymentPeriod'] = $paymentPeriod;


            $date_start = $campaign->getDateStart();
            $helper = explode(" ", $date_start);
            $date_start = explode("-", $helper[0]);
            $date_start = implode("-", array_reverse($date_start));
            $data["date_start"] = $date_start;

            $date_finish = $campaign->getDateFinish();
            $helper = explode(" ", $date_finish);
            $date_finish = explode("-", $helper[0]);
            $date_finish = implode("-", array_reverse($date_finish));
            $data["date_finish"] = $date_finish;

            $userId = $this->session->userdata("user_id");
            $associate = $this->donation_model->userIsAlreadyAssociate($userId);
            $data["associate"] = $associate;
        }

        $dataatual = date("d-m-Y");
        $year = date('Y');

        $data['dataatual'] = $dataatual;
        $data['year'] = $year;
        $data["campaign"] = $campaign;
        $this->loadView("campaign/index", $data);
    }

    public function startAssociation() {
        $this->Logger->info("Starting " . __METHOD__);
        $campaign = $this->campaign_model->getCurrentYearCampaign();
        $period = $this->campaign_model->GetCurrentPeriod($campaign->getCampaignId());
        $userId = $this->session->userdata("user_id");
        try {
            $this->generic_model->startTransaction();
            $this->Logger->info("Creating donation");
            $donationId = $this->donation_model->createDonation($userId, $period->price, DONATION_TYPE_ASSOCIATE);
            $this->Logger->info("Created donation with id: " . $donationId);

            $this->generic_model->commitTransaction();

            //Redirect to checkout
            redirect("payments/checkout/" . $donationId);
        } catch (Exception $ex) {
            $this->generic_model->rollbackTransaction();
            $this->Logger->error("Failed to proceed with checkout");
            $this->info($campaign->getCampaignId(), true);
        }
    }

}
