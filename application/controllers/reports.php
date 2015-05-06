<?php

require_once APPPATH . 'core/CK_Controller.php';

class Reports extends CK_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> model('personuser_model');
		$this -> load -> model('cielotransaction_model');
		$this -> personuser_model -> setLogger($this -> Logger);
		$this -> cielotransaction_model -> setLogger($this -> Logger);
	}

	public function user_reports() {
		$this->loadView("reports/users/user_reports_container");
	}

	public function user_registered() {
		$data['users'] = $this -> personuser_model -> getAllUserRegistered();
		$this -> loadReportView("reports/users/user_registered", $data);
	}

	public function all_users() {
		$data['users'] = $this->personuser_model->getAllUsersDetailed();
		$this->loadReportView("reports/users/all_users", $data);
	}

	public function payments_bycard() {
		$type = $this -> input -> get('type', TRUE);
		$title_extra = "";
		$searchfor = FALSE;
		if ($type == "captured") {
			$searchfor = 6;
			$title_extra = " - Finalizados";
		} else if ($type == "canceled") {
			$searchfor = 9;
			$title_extra = " - Cancelados";
		}
		$results = $this -> cielotransaction_model -> statisticsPaymentsByCardFlag($searchfor);
		$data['result'] = $results;
		$creditos[1] = 0;
		$creditos[2] = 0;
		$creditos[3] = 0;
		foreach ($results["credito" ] as $credito) {
			if (isset($credito[1]))
				$creditos[1] += $credito[1];
			if (isset($credito[2]))
				$creditos[2] += $credito[2];
			if (isset($credito[3]))
				$creditos[3] += $credito[3];
		}
		$debito = 0;
		if (isset($results["debito"])) {
			foreach ($results["debito"] as $result) {
				$debito += $result;
			}
		}
		$data['credito'] = $creditos;
		$data['debito'] = $debito;
		$data['soma'] = $debito + $creditos[1] + $creditos[2] + $creditos[3];
		$data['title_extra'] = $title_extra;
		$this -> loadView("reports/finances/payments_bycard", $data);
	}

}
