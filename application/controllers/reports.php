<?php

require_once APPPATH . 'core/CK_Controller.php';

class Reports extends CK_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> model('personuser_model');
		$this -> load -> model('cielotransaction_model');
		$this -> load -> model('donation_model');
		$this -> personuser_model -> setLogger($this -> Logger);
		$this -> cielotransaction_model -> setLogger($this -> Logger);
		$this -> donation_model -> setLogger($this -> Logger);
	}

	public function user_reports() {
		$this->loadView("reports/users/user_reports_container");
	}
	public function finance_reports() {
		$this->loadView("reports/finances/finance_reports_container");
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
		//Por enquanto só o tipo finalizado é pra ser mostrado.
		$type = "captured";
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
		$countAssociates = $this -> donation_model -> countPayingAssociates();
		$data['result'] = $results;
		$data['associates'] = $countAssociates;
		$creditos[1] = 0;
		$creditos[2] = 0;
		$creditos[3] = 0;
		$creditos[4] = 0;
		$creditos[5] = 0;
		$creditos[6] = 0;
		foreach ($results["credito"] as $credito) {
			for($i=1;$i<=6;$i++)
				if (isset($credito[$i]))
					$creditos[$i] += $credito[$i];
		}
		$debito = 0;
		if (isset($results["debito"])) {
			foreach ($results["debito"] as $result) {
				foreach($result as $valor)
					$debito += $valor;
			}
		}
		$data['credito'] = $creditos;
		$data['debito'] = $debito;
		$data['avulsas'] = $this->donation_model->countFreeDonations();
		$data['title_extra'] = $title_extra;
		$this -> loadReportView("reports/finances/payments_bycard", $data);
	}

}
