<?php

require_once APPPATH . 'core/CK_Controller.php';

class Reports extends CK_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('personuser_model');
        $this->personuser_model->setLogger($this->Logger);
    }

    public function user_registered() {
        $data['users'] = $this->personuser_model->getAllUserRegistered();
        $this->loadView("reports/user_registered", $data);
    }

}
