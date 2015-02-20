<?php 
require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/cielotransaction.php';
class Payments extends CK_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
        $this->load->model('cielotransaction_model');
	}

	public function index(){
		$transactionList = $this->cielotransaction_model->getAllPayments();
		$data['transactions'] = $transactionList;

		$this->loadView("payments/home", $data);
	}

	public function info($tId){
		$transaction = $this->cielotransaction_model->getPaymentById($tId);
		$data['transaction'] = $transaction;

		$this->loadView('payments/info', $data);
	}

    public function test(){
        $data = "";
        $this->loadView("payments/test", $data);
    }


}

?>