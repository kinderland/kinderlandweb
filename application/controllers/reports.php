<?php

require_once APPPATH . 'core/CK_Controller.php';

class Reports extends CK_Controller {

	public function __construct() {
		parent::__construct();
		$this -> load -> helper('url');
		$this -> load -> model('personuser_model');
		$this -> load -> model('cielotransaction_model');
		$this -> load -> model('donation_model');
		$this -> load -> model('campaign_model');
		$this -> personuser_model -> setLogger($this -> Logger);
		$this -> cielotransaction_model -> setLogger($this -> Logger);
		$this -> donation_model -> setLogger($this -> Logger);
		$this -> campaign_model -> setLogger($this -> Logger);
	}

	public function user_reports() {
		$this -> loadView("reports/users/user_reports_container");
	}

	public function finance_reports() {
		$this -> loadView("reports/finances/finance_reports_container");
	}

	public function user_registered() {
		$data['users'] = $this -> personuser_model -> getAllUserRegistered();
		$this -> loadReportView("reports/users/user_registered", $data);
	}

	public function all_users() {
		$data['users'] = $this -> personuser_model -> getAllUsersDetailed();
		$this -> loadReportView("reports/users/all_users", $data);
	}

	public function toCSV() {
		$data = $this -> input -> post('data', TRUE);
		$name = $this -> input -> post('name', TRUE);
		$columnNames = $this -> input -> post('columName', TRUE);
		$dataArray = json_decode($data);
		if($columnNames)
			$columnNamesArray = json_decode($columnNames);
		else
			$columnNamesArray = array();
		try {
			arrayToCSV($this -> Logger, $name, $dataArray,$columnNamesArray);
		} catch(Exception $e) {
			echo "<script>alert('Problema ao gerar csv, tente novamente mais tarde');</script>";
		}
	}

	public function payments_bycard() {
		$type = $this -> input -> get('type', TRUE);
		$option = $this -> input -> get('option', TRUE);
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
		$results = $this -> cielotransaction_model -> statisticsPaymentsByCardFlag($searchfor, $option);
		$data['result'] = $results;
		if ($option == PAYMENT_REPORTBYCARD_VALUES) {
			$data['avulsas'] = $this -> donation_model -> sumFreeDonations();
			$sumAssociates = $this -> donation_model -> sumPayingAssociates();
			$data['associates'] = $sumAssociates;
		} else {
			$data['avulsas'] = $this -> donation_model -> countFreeDonations();
			$countAssociates = $this -> donation_model -> countPayingAssociates();
			$data['associates'] = $countAssociates;
		}
		$creditos[1] = 0;
		$creditos[2] = 0;
		$creditos[3] = 0;
		$creditos[4] = 0;
		$creditos[5] = 0;
		$creditos[6] = 0;
		foreach ($results["credito"] as $credito) {
			for ($i = 1; $i <= 6; $i++)
				if (isset($credito[$i]))
					$creditos[$i] += $credito[$i];
		}
		$debito = 0;
		if (isset($results["debito"])) {
			foreach ($results["debito"] as $result) {
				foreach ($result as $valor)
					$debito += $valor;
			}
		}
		$data['credito'] = $creditos;
		$data['debito'] = $debito;
		$data['title_extra'] = $title_extra;
		$data['option'] = $option;
		$this -> loadReportView("reports/finances/payments_bycard", $data);
	}

	public function associated_campaign() {
		$data['years'] = $this -> campaign_model -> getYearsCampaign();
		$this -> loadView("reports/associated/associated_campaign", $data);
	}

	public function associated_year($year) {
		$data['summary'] = $this -> campaign_model -> getAssociatedCount($year);
		$data['users'] = $this -> personuser_model -> getAllContribuintsDetailed();
		$this -> loadReportView("reports/associated/associated_year", $data);
	}

	public function all_transactions() {
		$this -> Logger -> info("Starting " . __METHOD__);

		if (!$this -> checkPermition(array(SYSTEM_ADMIN))) {
			$this -> denyAcess(___METHOD___);
		}

		$ano = $this -> input -> get('ano', TRUE);
		$data['payments'] = $this -> cielotransaction_model -> getPaymentsDetailed($ano);
		$data['years'] = $this -> cielotransaction_model -> getPaymentYears();
		if ($ano)
			$data['ano'] = $ano;
		else{
			$date = new DateTime('NOW');
			$data['ano'] = $date->format("Y");
		}
		$this -> loadReportView("reports/finances/all_transactions", $data);
	}

	public function user_donation_history() {
		$data['users'] = $this -> personuser_model -> getAllUsersDetailed();
		$this -> loadReportView("reports/finances/donation_history", $data);
	}

	public function associate_campaign_donations() {
		$years = array();
		$start = 2015;
		$end = date('Y');
		while ($start <= $end) {
			$years[] = $start;
			$start++;
		}

		$month = null;
		$year = null;
		if (isset($_GET['mes']) && $_GET['mes'] != 0)
			$month = $_GET['mes'];
		if (isset($_GET['ano']) && $_GET['ano'] != 0)
			$year = $_GET['ano'];

		$data['year'] = $year;
		$data['years'] = $years;
		$data['month'] = $month;
		$data['donations'] = $this -> donation_model -> getDonationsDetailed(DONATION_TYPE_ASSOCIATE, $month, $year);
		$this -> loadReportView("reports/finances/donations", $data);
	}

	public function free_donations() {
		$years = array();
		$start = 2015;
		$end = date('Y');
		while ($start <= $end) {
			$years[] = $start;
			$start++;
		}

		$month = null;
		$year = null;
		if (isset($_GET['mes']) && $_GET['mes'] != 0)
			$month = $_GET['mes'];
		if (isset($_GET['ano']) && $_GET['ano'] != 0)
			$year = $_GET['ano'];

		$data['year'] = $year;
		$data['years'] = $years;
		$data['month'] = $month;
		$data['donations'] = $this -> donation_model -> getDonationsDetailed(DONATION_TYPE_FREEDONATION, $month, $year);
		$this -> loadReportView("reports/finances/donations", $data);
	}

}
