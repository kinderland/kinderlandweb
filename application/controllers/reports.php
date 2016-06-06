<?php

require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/campaign.php';

class Reports extends CK_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('person_model');
        $this->load->model('personuser_model');
        $this->load->model('summercamp_model');
        $this->load->model('cielotransaction_model');
        $this->load->model('donation_model');
        $this->load->model('campaign_model');
        $this->load->model('telephone_model');
        $this->load->model('event_model');
        $this->load->model('eventsubscription_model');
        $this->load->model('finance_model');
        $this->person_model->setLogger($this->Logger);
        $this->personuser_model->setLogger($this->Logger);
        $this->summercamp_model->setLogger($this->Logger);
        $this->cielotransaction_model->setLogger($this->Logger);
        $this->donation_model->setLogger($this->Logger);
        $this->campaign_model->setLogger($this->Logger);
        $this->telephone_model->setLogger($this->Logger);
        $this->event_model->setLogger($this->Logger);
        $this->eventsubscription_model->setLogger($this->Logger);
        $this->finance_model->setLogger($this->Logger);
    }

    public function user_reports() {
        $this->loadView("reports/users/user_reports_container");
    }

    public function finance_reports() {
        $this->loadView("reports/finances/finance_reports_container");
    }

    public function camp_reports() {
        $this->loadView("reports/summercamps/summercamp_reports_container");
    }

    public function user_registered() {
        $data['users'] = $this->personuser_model->getAllUserRegisteredUpdated();
        $this->loadReportView("reports/users/user_registered", $data);
    }

    public function all_users() {
        $data['users'] = $this->personuser_model->getAllUsersDetailed();
        $this->loadReportView("reports/users/all_users", $data);
    }

    public function event_reports() {
        $this->loadView("reports/events/event_reports_container");
    }
    
    public function secretaryOperation() {
    	$option = $this->input->get('option', TRUE);
    	$year = $this->input->get('year', TRUE);
    	$month = $this->input->get('month', TRUE);
    	$years = array();
    	$end = 2015;
    	$start = date('Y');
    	while ($start >= $end) {
    		$years[] = $start;
    		$start--;
    	}
    	
    	if ($year === FALSE) {
    		$year = date("Y");
    	} else if ($month == 0) {
    		$month = FALSE;
    	}
    	$data["year"] = $year;
    	$data["month"] = $month;
    	$data["years"] = $years;
    	$data["option"] = $option;
    	
    	
    	if($this -> personuser_model -> checkIfUserIsAdmin($this->session->userdata("user_id"))){
    		$secretary = $this->input->get('secretary', TRUE);
    		$data["secretaries"] = $this -> personuser_model -> getAllSecretariesWithBalances();
    		
    		if ($secretary == 0) {
    			$secretary = FALSE;
    			$balance = FALSE;
    		}else{
    			$data["secretary"] = $secretary;
    			$balance = $this ->personuser_model -> getBalanceBySecretaryIdAndDate($secretary,$year,$month);
    		}
    		
    		$data["admin"] = true;
    	}else{
    		$balance = $this ->personuser_model -> getBalanceBySecretaryIdAndDate($this->session->userdata("user_id"),$year,$month);
    	}
    	
    	$balances = array();
    	
    	if($balance){
	    	foreach($balance as $b){
	    		$obj = new StdClass();
	    		
	    		$r = explode(" ",$b->date_created);
	    		$r = explode("-", $r[0]);
	    		$obj->date_created = $r[2]."/".$r[1]."/".$r[0];
	    		
	    		if($b->person_id != $b->document_id)
	    		{
	    			$document = $this -> finance_model -> getDocumentInformationsById($b->document_id);
	    			$obj->description = $document->description;
	    		}
	    		
	    		$obj->operation_value = $b->operation_value;
	    		
	    		$balances[] = $obj;
	    	}
    	}
    	
    	$data['balance'] = $balances;
    	$this->loadReportView("reports/finances/secretaryOperation", $data);
    }
    
    public function postingExpenses(){
    	$option = $this->input->get('option', TRUE);
    	$year = $this->input->get('year', TRUE);
    	$month = $this->input->get('month', TRUE);
    	$years = array();
    	$end = 2015;
    	$start = date('Y');
    	while ($start >= $end) {
    		$years[] = $start;
    		$start--;
    	}
    	 
    	if ($year === FALSE) {
    		$year = date("Y");
    	} 
    	
    	if($month == null){
    		$month = date("m");    		
    	}else if ($month == 0) {
    		$month = FALSE;
    	}
    	$data["year"] = $year;
    	$data["month"] = $month;
    	$data["years"] = $years;
    	$data["option"] = $option;
    	
    	$postingExpenses = $this -> finance_model -> getPostingsExpensesByBankSlipDate($year,$month);
    	$postingExpensesWithoutDate = $this -> finance_model -> getPostingsExpensesWithoutDate();
    	
    	$info = array();
    	$portions = array();
    	$qtdpayed = 0;
    	
    	if($postingExpenses){
	    	foreach($postingExpenses as $pe){
	    		$obj = new StdClass();
	    		$obj = $pe;
	    		if($pe->payed == true){
	    			$qtdpayed++;
	    		}
	    		
	    			if(array_key_exists($pe->document_expense_id,$portions)){
	    				$portions[$pe->document_expense_id]++;
	    			}else{
	    				$portions[$pe->document_expense_id] = 1;
	    			}
	    		
	    		$r = explode("-", $pe->posting_date);
	    		$obj->posting_date = $r[1]."/".$r[2]."/".$r[0];
	    		
	    		$info[] = $obj;
	    	}
    	}
    	
    	if($postingExpensesWithoutDate){
    		foreach($postingExpensesWithoutDate as $pe){
    			$obj = new StdClass();
    			$obj = $pe;
    			if($pe->payed == 't'){
    				$qtdpayed++;
    			}
    			 
    			if(array_key_exists($pe->document_expense_id,$portions)){
    				$portions[$pe->document_expense_id]++;
    			}else{
    				$portions[$pe->document_expense_id] = 1;
    			}
    			$info[] = $obj;
    		}
    	}
    	
    	$accountNames = $this->finance_model->getAllAccountNames();
    	$answer = "";
    	 
    	foreach ($accountNames as $an) {
    		$answer = $answer . "/" . $an->account_name;
    	}
    	$data['accountNames'] = $answer;    	
    	$data["info"] = $info;
    	$data["qtdpayed"] = $qtdpayed;
    	$data["portions"] = $portions;
    	
    	$this->loadReportView("reports/finances/postingExpenses", $data);
    }

    public function reportPanel() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $eventsByDate = $this->event_model->getAllEventsByYear($date);
        $end = $date;
        while ($eventsByDate != null) {
            $end = $date;
            $date++;
            $eventsByDate = $this->event_model->getAllEventsByYear($date);
        }
        $years = $this->event_model->getAllEventsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        if ($year == date('Y')) {
            $today = date('Y') . "-" . date("m") . "-" . date("d");
            $allEvents = $this->event_model->getAllEventsPostDate($today);
        } else {
            $allEvents = $this->event_model->getAllEventsByYear($year);
        }

        $eventsQtd = count($allEvents);
        $events = array();
        $start = $eventsQtd;
        $end = 1;

        $eventChosen = $allEvents[0]->event_name;

        if (isset($_GET['evento_f']))
            $eventChosen = $_GET['evento_f'];

        $eventChosenId = null;
        foreach ($allEvents as $event) {
            $events[] = $event->event_name;
            if ($event->event_name == $eventChosen)
                $eventChosenId = $event->event_id;
        }

        if ($eventChosenId === null) {
            $events = null;
            $eventChosen = $allEvents[0]->event_name;
            foreach ($allEvents as $event) {
                $events[] = $event->event_name;
                if ($event->event_name == $eventChosen)
                    $eventChosenId = $event->event_id;
            }
        }

        $gender = null;
        $age = null;
        $type = array("fem" => 0, "mas" => 0, "non" => 0);
        $subscriptions = $this->eventsubscription_model->getSubscriptionsByEventId($eventChosenId);

        foreach ($subscriptions as $subs) {
            if ($subs->subscription_status == 3 && $subs->nonsleeper == 'f') {
                if ($subs->gender == 'M') {
                    $type["mas"] ++;
                } else if ($subs->gender == 'F') {
                    $type["fem"] ++;
                }
            } else if ($subs->subscription_status == 3 && $subs->nonsleeper == 't') {
                $type["non"] ++;
            }
        }

        $event = null;

        if ($eventChosenId !== null) {
            $event = $this->event_model->getEventById($eventChosenId);
            $this->Logger->info("ID DO EVENTO: " . $event->getEventId());
            $data['dispFem'] = $event->getCapacityFemale();
            $data['dispMas'] = $event->getCapacityMale();
            $data['dispNon'] = $event->getCapacityNonSleeper();
        }

        $data['event_id'] = $eventChosenId;
        $data['evento_escolhido'] = $eventChosen;
        $data['events'] = $events;
        $data['event'] = $event;
        $data['info'] = $type;

        $this->loadReportView('reports/events/report_panel', $data);
    }

    public function report_panel_byage() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $eventsByDate = $this->event_model->getAllEventsByYear($date);
        $end = $date;
        while ($eventsByDate != null) {
            $end = $date;
            $date++;
            $eventsByDate = $this->event_model->getAllEventsByYear($date);
        }
        $years = $this->event_model->getAllEventsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        if ($year == date('Y')) {
            $today = date('Y') . "-" . date("m") . "-" . date("d");
            $allEvents = $this->event_model->getAllEventsPostDate($today);
        } else {
            $allEvents = $this->event_model->getAllEventsByYear($year);
        }

        $eventsQtd = count($allEvents);
        $events = array();
        $start = $eventsQtd;
        $end = 1;

        $eventChosen = $allEvents[0]->event_name;

        if (isset($_GET['evento_f']))
            $eventChosen = $_GET['evento_f'];

        $eventChosenId = null;
        foreach ($allEvents as $event) {
            $events[] = $event->event_name;
            if ($event->event_name == $eventChosen)
                $eventChosenId = $event->event_id;
        }

        $gender = null;
        $age = null;
        $type = array("fem18" => 0, "fem717" => 0, "fem06" => 0, "mas18" => 0, "mas717" => 0, "mas06" => 0);
        $subscriptions = $this->eventsubscription_model->getSubscriptionsByEventId($eventChosenId);

        foreach ($subscriptions as $subs) {
            if ($subs->subscription_status == 3 && $subs->nonsleeper == 'f') {
                if ($subs->gender == 'M') {
                    if ($subs->age_group_id == 1)
                        $type["mas06"] ++;
                    else if ($subs->age_group_id == 2)
                        $type["mas717"] ++;
                    else if ($subs->age_group_id == 3)
                        $type["mas18"] ++;
                }
                else if ($subs->gender == 'F') {
                    if ($subs->age_group_id == 1)
                        $type["fem06"] ++;
                    else if ($subs->age_group_id == 2)
                        $type["fem717"] ++;
                    else if ($subs->age_group_id == 3)
                        $type["fem18"] ++;
                }
            }
        }

        $data['event_id'] = $eventChosenId;
        $data['evento_escolhido'] = $eventChosen;
        $data['events'] = $events;
        $data['info'] = $type;

        $this->loadReportView('reports/events/report_panel_byage', $data);
    }

    /*
      public function loadReportPanel(){
      $this->Logger->info("Starting " . __METHOD__);

      $eventId = $_POST['event_id'];
      $reportType = $_POST['report_type'];

      $data = array();

      if(!$this->checkSession())
      redirect("login/index");

      try {
      $this->Logger->info("Retrieving information about event with id: ". $eventId);

      $event = $this->event_model->getEventById($eventId);
      $subscriptions = $this->eventsubscription_model->getSubscriptionsByEventId($eventId);
      $price = $this->eventsubscription_model->getEventPrices($eventId);
      $age_groups = $this->eventsubscription_model->getAgeGroups();

      $data['event'] = $event;
      $data['subscriptions'] = $subscriptions;
      $data['price'] = $price;
      $data['age_groups'] = $age_groups;

      if($error)
      $data['error'] = $error;

      $this->loadView('event/report_panel', $data);

      } catch (Exception $ex) {
      $this->Logger->error("Unable to load information about event with id: ". $eventId);
      $this->index();
      }

      } */

    public function toCSV() {
        $data = $this->input->post('data', TRUE);
        $this -> Logger -> info($data);
        $name = $this->input->post('name', TRUE);
        $columnNames = $this->input->post('columName', TRUE);
        $dataArray = json_decode($data);
        if ($columnNames)
            $columnNamesArray = json_decode($columnNames);
        else
            $columnNamesArray = array();
        try {
            arrayToCSV($this->Logger, $name, $dataArray, $columnNamesArray);
        } catch (Exception $e) {
            echo "<script>alert('Problema ao gerar csv, tente novamente mais tarde');</script>";
        }
    }

    public function toTXT() {
        $data = $this->input->post('data', TRUE);
        $name = $this->input->post('name', TRUE);
        $columnNames = $this->input->post('columName', TRUE);
        $dataArray = json_decode($data);
        if ($columnNames)
            $columnNamesArray = json_decode($columnNames);
        else
            $columnNamesArray = array();
        try {
            arrayToTXT($this->Logger, $name, $dataArray, $columnNamesArray);
        } catch (Exception $e) {
            echo "<script>alert('Problema ao gerar csv, tente novamente mais tarde');</script>";
        }
    }

    public function donation_panel() {
        $error = "";
        $end = 2015;
        $start = date('Y');
        while ($start >= $end) {
            $years[] = $start;
            $start--;
        }
        $selected_years = array();
        $selected_months = array();
        $campaign = array();
        $summercamp = array();
        $mini = array();
        $free = array();
        $total_per_period = array();


        $year_start = $this->input->get('year_start', TRUE);
        $month_start = $this->input->get('month_start', TRUE);
        $year_finish = $this->input->get('year_finish', TRUE);
        $month_finish = $this->input->get('month_finish', TRUE);
        if (!isset($year_start) || empty($year_start))
            $year_start = intval(date('Y'));
        if (!isset($year_finish) || empty($year_finish))
            $year_finish = intval(date('Y'));
        if (!isset($month_start) || empty($month_start))
            $month_start = intval(date('m'));
        if (!isset($month_finish) || empty($month_finish))
            $month_finish = intval(date('m'));

        if ($year_start > $year_finish || ($year_start == $year_finish && $month_start > $month_finish)) {
            $error = 'A data de término deve vir depois da data de início\n';
            $year_start = intval(date('Y'));
            $year_finish = intval(date('Y'));
            $month_start = intval(date('m'));
            $month_finish = intval(date('m'));
        }
        if ($year_finish > $year_start) { //O ano de término é exclusivamente maior que o ano de começo.
            for ($j = $month_start; $j <= 12; $j++) {
                $selected_years[] = $year_start;
                $selected_months[] = $j;
            }
            for ($i = $year_start + 1; $i < $year_finish; $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $selected_years[] = $i;
                    $selected_months[] = $j;
                }
            }
            for ($j = 1; $j <= $month_finish; $j++) {
                $selected_years[] = $year_finish;
                $selected_months[] = $j;
            }
        } elseif ($year_start === $year_finish) { //Os anos são iguais, o que deixa mais fácil.
            for ($j = $month_start; $j <= $month_finish; $j++) {
                $selected_years[] = $year_start;
                $selected_months[] = $j;
            }
        }


        $total_campaign = 0.0;
        $total_summercamp = 0.0;
        $total_mini = 0.0;
        $total_free = 0.0;
        $total = 0.0;
        for ($i = 0; $i < count($selected_years); $i++) {
            $total_per_period[$i] = 0.0;
            $campaign[$i] = $this->campaign_model->getContributorsByPeriod($selected_years[$i], $selected_months[$i]);
            $total_campaign+=$campaign[$i];
           /*
            $summercamp[$i] = $this->summercamp_model->getSubscribersByPeriod($selected_years[$i], $selected_months[$i]);
            $total_summercamp+=$summercamp[$i];
            $mini[$i] = $this->summercamp_model->getMiniSubsByPeriod($selected_years[$i], $selected_months[$i]);
            $total_mini+=$mini[$i]; */
            $summercamp[$i]=$this->summercamp_model->getSummerCampDonationsSum($selected_years[$i], $selected_months[$i]);
            $total_summercamp+=$summercamp[$i];
            $free[$i] = $this->donation_model->getFreeDonationsByPeriod($selected_years[$i], $selected_months[$i]);
            $total_free+=$free[$i];

            $total_per_period[$i]+=$campaign[$i] + $summercamp[$i] /*+ $mini[$i]*/ + $free[$i];
            $total+=$total_per_period[$i];
        }
        $data['error'] = $error;
        $data['year_start'] = $year_start;
        $data['year_finish'] = $year_finish;
        $data['month_start'] = $month_start;
        $data['month_finish'] = $month_finish;
        $data['years'] = $years;
        $data['selected_years'] = $selected_years;
        $data['selected_months'] = $selected_months;
        $data['campaign'] = $campaign;
        $data['summercamp'] = $summercamp;
        $data['mini'] = $mini;
        $data['free'] = $free;
        $data['total_campaign'] = $total_campaign;
        $data['total_summercamp'] = $total_summercamp;
        $data['total_mini'] = $total_mini;
        $data['total_free'] = $total_free;
        $data['total_per_period'] = $total_per_period;
        $data['total'] = $total;
        $this->loadReportView("reports/finances/donation_panel", $data);
    }

    public function payments_bycard() {
        $type = $this->input->get('type', TRUE);
        $option = $this->input->get('option', TRUE);
        $year = $this->input->get('year', TRUE);
        $month = $this->input->get('month', TRUE);
        $years = array();
        $end = 2015;
        $start = date('Y');
        while ($start >= $end) {
            $years[] = $start;
            $start--;
        }

        if ($year === FALSE) {
            $year = date("Y");
        } else if ($month == 0) {
            $month = FALSE;
        }
        $data["year"] = $year;
        $data["month"] = $month;
        $data["years"] = $years;
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
        // echo $year . "oie" . $month;
        $results = $this->cielotransaction_model->statisticsPaymentsByCardFlag($searchfor, $option, $year, $month);
        $data['result'] = $results;
        if ($option == PAYMENT_REPORTBYCARD_VALUES) {
            $data['avulsas'] = $this->donation_model->sumFreeDonations($year, $month);
            $data['associates'] = $this->donation_model->sumPayingAssociates($year, $month);
            $data['colonies'] = $this->donation_model->sumDonationsColony($year, $month);
        } else {
            $data['avulsas'] = $this->donation_model->countFreeDonations($year, $month);
            $data['associates'] = $this->donation_model->countPayingAssociates($year, $month);
            $data['colonies'] = $this->donation_model->countDonationsColony($year, $month);
        }
        $creditos[1] = 0;
        $creditos[2] = 0;
        $creditos[3] = 0;
        $creditos[4] = 0;
        $creditos[5] = 0;
        $creditos[6] = 0;
        $creditos[7] = 0;
        $creditos[8] = 0;

        if (isset($results["credito"])) {

            foreach ($results["credito"] as $credito) {
                for ($i = 1; $i <= 8; $i++)
                    if (isset($credito[$i]))
                        $creditos[$i] += $credito[$i];
            }
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
        $this->loadReportView("reports/finances/payments_bycard", $data);
    }

    public function associated_campaign() {
        $data['years'] = $this->campaign_model->getPastYearsCampaign();
        $this->loadView("reports/associated/associated_campaign", $data);
    }

    public function associated_year($year) {
        $data['summary'] = $this->campaign_model->getAssociatedCount($year);
        $data['users'] = $this->personuser_model->getAllContributorsByYearDetailed($year);
        $this->loadReportView("reports/associated/associated_year", $data);
    }

    public function all_transactions() {
        $this->Logger->info("Starting " . __METHOD__);

        $ano = $this->input->get('ano', TRUE);
        $mes = $this->input->get('mes', TRUE);
        $data['payments'] = $this->cielotransaction_model->getPaymentsDetailed($ano, $mes);
        $data['years'] = $this->cielotransaction_model->getPaymentYears();
        if ($ano)
            $data['ano'] = $ano;
        else {
            $date = new DateTime('NOW');
            $data['ano'] = $date->format("Y");
            $ano = date('Y');
        }
        if ($mes)
            $data['mes'] = $mes;
        $data['payments'] = $this->cielotransaction_model->getPaymentsDetailed($ano, $mes);
        $this->loadReportView("reports/finances/all_transactions", $data);
    }

    public function user_donation_history() {
        $data['users'] = $this->personuser_model->getAllUsersDetailed();
        $this->loadReportView("reports/finances/donation_history", $data);
    }

    public function colonist_registered() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = intval(date('Y'));
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $shownStatus = SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS;

        $data['colonists'] = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, $shownStatus);
        $this->loadReportView("reports/summercamps/colonist_registered", $data);
    }

    public function all_registrations() {
        $data = array();
        $years = array();

        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();

        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $vacancyMale = 0;
        $vacancyFemale = 0;

        if ($campChosenId != null) {
            $camp = $this->summercamp_model->getSummerCampById($campChosenId);
            $vacancyMale = $camp->getCapacityMale();
            $vacancyFemale = $camp->getCapacityFemale();
        } else {
            foreach ($allCamps as $camp) {
                $vacancyMale = $vacancyMale + $camp->getCapacityMale();
                $vacancyFemale = $vacancyFemale + $camp->getCapacityFemale();
            }
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;
        $data['vacancyMale'] = $vacancyMale;
        $data['vacancyFemale'] = $vacancyFemale;

        $action = null;

        if (isset($_GET['action']))
            $action = $_GET['action'];

        if ($action == 'Inscritos') {
            $colonists = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, 6, $campChosenId);
            $data['colonists'] = $colonists;
        }

        $genderM = 'M';
        $genderF = 'F';

        $countsAssociatedM = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, 'TRUE', $campChosenId, $genderM);
        $countsNotAssociatedM = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, null, $campChosenId, $genderM);
        $countsAssociatedF = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, 'TRUE', $campChosenId, $genderF);
        $countsNotAssociatedF = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, null, $campChosenId, $genderF);

        $countsAssociatedT = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, 'TRUE', $campChosenId);
        $countsNotAssociatedT = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, null, $campChosenId);

        $countsT = $this->summercamp_model->getCountStatusColonistBySummerCampYearAndGender($year, $campChosenId);
        $data['countsAssociatedM'] = $countsAssociatedM;
        $data['countsNotAssociatedM'] = $countsNotAssociatedM;
        $data['countsAssociatedF'] = $countsAssociatedF;
        $data['countsNotAssociatedF'] = $countsNotAssociatedF;
        $data['countsAssociatedT'] = $countsAssociatedT;
        $data['countsNotAssociatedT'] = $countsNotAssociatedT;
        $data['countsT'] = $countsT;

        $this->loadReportView("reports/summercamps/all_registrations", $data);
    }

    public function registrations_deleted() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;

        $genderM = 'M';
        $genderF = 'F';

        $countsAssociatedM = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, 'TRUE', $campChosenId, $genderM);
        $countsNotAssociatedM = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, null, $campChosenId, $genderM);
        $countsAssociatedF = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, 'TRUE', $campChosenId, $genderF);
        $countsNotAssociatedF = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, null, $campChosenId, $genderF);

        $countsT = $this->summercamp_model->getCountStatusColonistBySummerCampYearAndGender($year, $campChosenId);
        $data['countsAssociatedM'] = $countsAssociatedM;
        $data['countsNotAssociatedM'] = $countsNotAssociatedM;
        $data['countsAssociatedF'] = $countsAssociatedF;
        $data['countsNotAssociatedF'] = $countsNotAssociatedF;

        $this->loadReportView("reports/summercamps/registrations_deleted", $data);
    }

    public function colonists_byschool() {

        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;

        $schoolNames = $this->summercamp_model->getSchoolNamesByStatusSummerCampAndYear($year, $campChosenId);
        $countSchools = count($schoolNames);
        $start = 0;

        $schools = array();

        while ($start < $countSchools) {

            $school = $this->summercamp_model->getCountStatusSchoolBySchoolName($schoolNames[$start], $year, $campChosenId);

            if ($school != null) {
                $schools[] = $school;
            }

            $start++;
        }

        $data['schools'] = $schools;
        $this->loadReportView("reports/summercamps/colonists_byschool", $data);
    }

    public function colonists_byassociated() {

        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $subscriptions = $this->summercamp_model->getCountSubscriptionsbyAssociated($year);

        $benemerits = $this->personuser_model->getPersonIdsBenemerits();

        $qtdBenemerits = 0;
        $qtdAssoc = 0;

        foreach ($subscriptions as $subs) {
            $equal = false;
            if ($subs->total_inscritos > 0) {
                foreach ($benemerits as $b) {
                    if ($b == $subs->person_id) {
                        $equal = true;
                        break;
                    }
                }

                if ($equal == false) {
                    $qtdAssoc++;
                } else {
                    $qtdBenemerits++;
                }
            }
        }

        $data['subscriptions'] = $subscriptions;
        $data['qtdBenemerits'] = $qtdBenemerits;
        $data['qtdAssoc'] = $qtdAssoc;
        $this->loadReportView("reports/summercamps/colonists_byassociated", $data);
    }

    public function subscriptions_bycamp() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        while ($start <= $end) {
            $years[] = $start;
            $start++;
        }
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = date('Y');
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;

        $selected = "Todos";
        $opcoes = array(0 => "Todos", 1 => "Sócios", 2 => "Não Sócios");

        if (isset($_GET['opcao_f']))
            $selected = $_GET['opcao_f'];

        $data['selecionado'] = $selected;
        $data['opcoes'] = $opcoes;

        if ($selected == "Todos") {

            $countsF = $this->summercamp_model->getCountStatusColonistBySummerCampYearAndGender($year, $campChosenId, 'F');
            $countsM = $this->summercamp_model->getCountStatusColonistBySummerCampYearAndGender($year, $campChosenId, 'M');
            $countsT = $this->summercamp_model->getCountStatusColonistBySummerCampYearAndGender($year, $campChosenId);
        } else {

            $associated = null;

            if ($selected == "Sócios") {

                $associated = 1;
            }

            $countsF = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, $associated, $campChosenId, 'F');
            $countsM = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, $associated, $campChosenId, 'M');
            $countsT = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, $associated, $campChosenId, null);
        }

        $data['countsF'] = $countsF;
        $data['countsM'] = $countsM;
        $data['countsT'] = $countsT;

        $this->loadReportView("reports/summercamps/subscriptions_bycamp", $data);
    }

    public function parents_notregistered() {

        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $camps = $this->summercamp_model->getAllSummerCampsByYear($year);

        $campsIdStr = "";
        if ($camps != null && count($camps) > 0) {
            $campsIdStr = $camps[0]->getCampId();
            for ($i = 1; $i < count($camps); $i++)
                $campsIdStr .= "," . $camps[$i]->getCampId();
        }

        $colonists = $this->summercamp_model->getColonistRelationDetailedBySummerCamp($campsIdStr);

        $data['colonists'] = $colonists;
        $this->loadReportView("reports/summercamps/parents_notregistered", $data);
    }

    public function responsables_notparents() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $colonists = $this->summercamp_model->getColonistsResponsableNotParentsByYear($year);

        $data['colonists'] = $colonists;
        $this->loadReportView("reports/summercamps/responsables_notparents", $data);
    }

    public function same_parents() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $colonists = $this->summercamp_model->getColonistDetailedSameParentsByYearAndSummerCamp($year);

        $data['colonists'] = $colonists;
        $this->loadReportView("reports/summercamps/same_parents", $data);
    }

    public function subscriptions_notsubmitted() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;

        $colonists = $this->summercamp_model->getColonistsDatailedSubscriptionsNotSubmitted($year, $campChosenId);

        $data['colonists'] = $colonists;
        $this->loadReportView("reports/summercamps/subscriptions_notsubmitted", $data);
    }

    public function multiples_subscriptions() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $colonists = $this->summercamp_model->getColonistsDetailedMultiplesSubscriptions($year);

        $data['colonists'] = $colonists;
        $this->loadReportView("reports/summercamps/multiples_subscriptions", $data);
    }

    public function statistics_bycamp() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $campsNames = array();

        $countsAssociatedM = array();
        $countsNotAssociatedM = array();

        $countsAssociatedF = array();
        $countsNotAssociatedF = array();

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $campChosenId = $camp->getCampId();

            $genderM = 'M';
            $genderF = 'F';

            $countsAssociatedM[] = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, 'TRUE', $campChosenId, $genderM);
            $countsNotAssociatedM[] = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, null, $campChosenId, $genderM);

            $countsAssociatedF[] = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, 'TRUE', $campChosenId, $genderF);
            $countsNotAssociatedF[] = $this->summercamp_model->getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, null, $campChosenId, $genderF);

            $campsNames[] = $camp->getCampName();
        }

        $data['countsAssociatedM'] = $countsAssociatedM;
        $data['countsNotAssociatedM'] = $countsNotAssociatedM;
        $data['countsAssociatedF'] = $countsAssociatedF;
        $data['countsNotAssociatedF'] = $countsNotAssociatedF;
        $data['campsNames'] = $campsNames;
        $data['campsQtd'] = $campsQtd;

        $this->loadReportView("reports/summercamps/statistics_bycamp", $data);
    }

    public function colonist_byage() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;

        $genders = array(0 => "Feminino", 1 => "Masculino");

        $genderChosen = 'Masculino';
        if (isset($_GET['genero_f']))
            $genderChosen = $_GET['genero_f'];

        $data['genero_escolhido'] = $genderChosen;
        $data['genders'] = $genders;

        if ($campChosenId != null) {
            if ($genderChosen == 'Masculino') {
                $colonists = $this->summercamp_model->getColonistsAgeAndSchoolYearBySummerCampAndGender($campChosenId, 'M');
            } else {
                $colonists = $this->summercamp_model->getColonistsAgeAndSchoolYearBySummerCampAndGender($campChosenId, 'F');
            }

            $data['colonists'] = $colonists;
        }

        $this->loadReportView("reports/summercamps/colonist_byage", $data);
    }

    public function queue() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;

        $genders = array(0 => "Feminino", 1 => "Masculino");

        $genderChosen = 'Masculino';
        if (isset($_GET['genero_f']))
            $genderChosen = $_GET['genero_f'];

        $data['genero_escolhido'] = $genderChosen;
        $data['genders'] = $genders;

        if ($campChosenId != null) {

            if ($genderChosen == 'Masculino') {
                $colonists = $this->summercamp_model->getAllColonistsWithQueueNumberBySummerCamp($campChosenId, 'M');
            } else {
                $colonists = $this->summercamp_model->getAllColonistsWithQueueNumberBySummerCamp($campChosenId, 'F');
            }

            $data['colonists'] = $colonists;
        }

        $this->loadReportView("reports/summercamps/queue", $data);
    }

    public function associate_campaign_donations() {
        $years = array();
        $end = 2015;
        $start = date('Y');
        while ($start >= $end) {
            $years[] = $start;
            $start--;
        }

        $month = null;
        $year = null;
        if (isset($_GET['mes']) && $_GET['mes'] != 0)
            $month = $_GET['mes'];
        if (isset($_GET['ano']) && $_GET['ano'] != 0)
            $year = $_GET['ano'];
        else {
            $year = date('Y');
        }
        $data['year'] = $year;
        $data['years'] = $years;
        $data['month'] = $month;
        $data['type'] = 'campaign_donations';
        $data['donations'] = $this->donation_model->getDonationsDetailed(DONATION_TYPE_ASSOCIATE, $month, $year);
        $this->loadReportView("reports/finances/donations", $data);
    }

    public function free_donations() {
        $years = array();
        $end = 2015;
        $start = date('Y');
        while ($start >= $end) {
            $years[] = $start;
            $start--;
        }

        $month = null;
        $year = null;
        if (isset($_GET['mes']) && $_GET['mes'] != 0)
            $month = $_GET['mes'];
        if (isset($_GET['ano']) && $_GET['ano'] != 0)
            $year = $_GET['ano'];
        else
            $year = date('Y');

        $data['year'] = $year;
        $data['years'] = $years;
        $data['month'] = $month;
        $data['type'] = 'free_donations';
        $data['donations'] = $this->donation_model->getDonationsDetailed(DONATION_TYPE_FREEDONATION, $month, $year);
        $this->loadReportView("reports/finances/donations", $data);
    }

    public function failed_transactions() {
        $years = array();
        $end = 2015;
        $start = date('Y');
        while ($start >= $end) {
            $years[] = $start;
            $start--;
        }

        $month = null;
        $year = null;
        if (isset($_GET['mes']) && $_GET['mes'] != 0)
            $month = $_GET['mes'];
        if (isset($_GET['ano']) && $_GET['ano'] != 0)
            $year = $_GET['ano'];
        else
            $year = date('Y');

        $data['year'] = $year;
        $data['years'] = $years;
        $data['month'] = $month;
        $data['donations'] = $this->donation_model->getTransactionAttemptFails($month, $year);
        $this->loadReportView("reports/finances/failed_transactions", $data);
    }

    public function logs() {
        $data['permissions'] = $this->session->userdata("user_types");
        $data['path'] = $this->config->item('log_path', 'logger');
        $data['files'] = scandir($data['path']);
        $this->loadView("reports/system/logs", $data);
    }

    public function openLog($file) {
        $data['path'] = $this->config->item('log_path', 'logger') . "/" . $file;
        $this->loadReportView("reports/system/openlog", $data);
    }

    public function discounts() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsWithDiscountsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;

        $discountsT = null;
        $discountsI = null;
        $colonists = $this->summercamp_model->getColonistsInformationWithDiscounts($year, $campChosenId);

        if ($campChosen != null || $campChosen == "Todas") {
            if ($campChosen == "Todas") {
                $discountsT = $this->summercamp_model->getCountDiscountsBySummerCamp($year);
                $discountsI = $this->summercamp_model->getCountDiscountsBySummerCamp($year, null, "TRUE");
            } else {
                $discountsT = $this->summercamp_model->getCountDiscountsBySummerCamp($year, $campChosenId);
                $discountsI = $this->summercamp_model->getCountDiscountsBySummerCamp($year, $campChosenId, "TRUE");
            }

            $data['discountsT'] = $discountsT;
            $data['discountsI'] = $discountsI;
        }

        $data['colonists'] = $colonists;
        $this->loadReportView("reports/summercamps/discounts", $data);
    }

    public function transactions_expected() {
        $anoAtual = date('Y');

        $donations = array(0 => "Todas", 1 => "Inscrição Colônia", 2 => "Avulsa", 3 => "Campanha de Sócios");

        $donationChosen = 'Todas';
        if (isset($_GET['doacao_f']))
            $donationChosen = $_GET['doacao_f'];

        $data['doacao_escolhida'] = $donationChosen;
        $data['donations'] = $donations;

        $type = null;

        if ($donationChosen == "Inscrição Colônia")
            $type = 4;
        else if ($donationChosen == "Avulsa")
            $type = 1;
        else if ($donationChosen == "Campanha de Sócios")
            $type = 2;

        $allTransactions = null;
        $transactions = new stdClass();
        $transactions->valueDay = array();
        $transactions->day = array();
        $transactions->qtdDays = 0;

        $dayArr = array();
        $valueDay = array();

        $allTransactions = $this->cielotransaction_model->getCapturedTransactionsByDonationType($type);
        $days = $this->cielotransaction_model->countTotalDaysCapturedTransaction();

        $start = strval($days[0]->year) . "-" . strval($days[0]->month) . "-" . strval($days[0]->day);
        $numDays = count($days);

        $end = strval($days[$numDays - 1]->year + 1) . "-" . strval($days[$numDays - 1]->month) . "-" . strval($days[$numDays - 1]->day);
        
        $end = strtotime($end);
        $start = strtotime($start);
        $transactions->qtdDays = (($end - $start) / (1 * 24 * 60 * 60))*10;

        for ($i = 0; $i <= $transactions->qtdDays; $i++) {
            $transactions->day[$i] = date("Y-m-d", $start);
            $transactions->valueDay[$i] = 0.00;
            $start = $start + (1 * 24 * 60 * 60);
        }
        
        $s = 0;

        foreach ($allTransactions as $trans) {
        	$s++;
        	
        	$j = 0;

            foreach ($transactions->day as $day) {
            	$day = explode("-", $day);
            	
                if (($trans->day != $day[2]) || ($trans->month != $day[1]) || ($trans->year != $day[0])) {
                    $j++;
                } else
                    break;
            }
            
            if ($trans->type == "debito") {
                $transactions->valueDay[$j + 1] += $trans->value - (3.4 * ($trans->value) / 100.0);
                $p = $trans->value - (3.4 * ($trans->value) / 100.0);
                $this -> Logger -> info("VALOR TOTAL: ". $p);
            } else if ($trans->type == "credito") {
                if ($trans->portions == 1) {
                    $transactions->valueDay[$j + 30] += $trans->value - (3.8 * ($trans->value) / 100.0);
                    $p = $trans->value - (3.8 * ($trans->value) / 100.0);
                    $this -> Logger -> info("VALOR TOTAL: ". $p);
                } else {

                    $portions = $trans->portions;

                    if ($portions == 2 || $portions == 3)
                        $value = $trans->value - (4.55 * ($trans->value) / 100.0);
                    else if ($portions == 4 || $portions == 5 || $portions == 6)
                        $value = $trans->value - (4.80 * ($trans->value) / 100.0);
                    else
                        $value = $trans->value - (4.90 * ($trans->value) / 100.0);
                    
                    $this -> Logger -> info("VALOR TOTAL: ". $value);

                    $i = 1;

                    while ($i <= $portions) {
                        $transactions->valueDay[$j + 30 * $i] += $value / $portions;
                        $p = $value / $portions;
                        $i++;
                    }
                }
            }
        }

        $periods = array(0 => "Específico", 1 => $anoAtual, 2 => "Janeiro", 3 => "Fevereiro", 4 => "Março",
            5 => "Abril", 6 => "Maio", 7 => "Junho", 8 => "Julho", 9 => "Agosto", 10 => "Setembro",
            11 => "Outubro", 12 => "Novembro", 13 => "Dezembro");

        $periodChosen = "Específico";
        if (isset($_GET['periodo_f']))
            $periodChosen = $_GET['periodo_f'];

        $data['periodo_escolhido'] = $periodChosen;
        $data['periods'] = $periods;

        $initialPeriodChosen = null;
        $finalPeriodChosen = null;


        if (isset($_GET['periodo_f'])) {


            if ($periodChosen == "Específico") {
                if (isset($_GET['periodo_inicial_f']) && isset($_GET['periodo_final_f'])) {
                    $initialPeriodChosen = $_GET['periodo_inicial_f'];
                    $finalPeriodChosen = $_GET['periodo_final_f'];

                    $data['periodo_inicial_escolhido'] = $initialPeriodChosen;
                    $data['periodo_final_escolhido'] = $finalPeriodChosen;

                    $dataInicial = explode("/", $initialPeriodChosen);
                    $dataFinal = explode("/", $finalPeriodChosen);

                    $initialPeriodChosen = $dataInicial[2] . "-" . $dataInicial[1] . "-" . $dataInicial[0];
                    $finalPeriodChosen = $dataFinal[2] . "-" . $dataFinal[1] . "-" . $dataFinal[0];
                }
            } else if ($periodChosen == $anoAtual) {
                $initialPeriodChosen = $anoAtual . "-01-01";
                $finalPeriodChosen = $anoAtual . "-12-31";
            } else {
                $mesAtual = null;

                if ($periodChosen == "Janeiro") {
                    $mesAtual = "01";
                    $diaFinal = "31";
                } else if ($periodChosen == "Fevereiro") {
                    $mesAtual = "02";
                    $diaFinal = "29";
                } else if ($periodChosen == "Março") {
                    $mesAtual = "03";
                    $diaFinal = "31";
                } else if ($periodChosen == "Abril") {
                    $mesAtual = "04";
                    $diaFinal = "30";
                } else if ($periodChosen == "Maio") {
                    $mesAtual = "05";
                    $diaFinal = "31";
                } else if ($periodChosen == "Junho") {
                    $mesAtual = "06";
                    $diaFinal = "30";
                } else if ($periodChosen == "Julho") {
                    $mesAtual = "07";
                    $diaFinal = "31";
                } else if ($periodChosen == "Agosto") {
                    $mesAtual = "08";
                    $diaFinal = "31";
                } else if ($periodChosen == "Setembro") {
                    $mesAtual = "09";
                    $diaFinal = "30";
                } else if ($periodChosen == "Outubro") {
                    $mesAtual = "10";
                    $diaFinal = "31";
                } else if ($periodChosen == "Novembro") {
                    $mesAtual = "11";
                    $diaFinal = "30";
                } else if ($periodChosen == "Dezembro") {
                    $mesAtual = "12";
                    $diaFinal = "31";
                }

                $initialPeriodChosen = $anoAtual . "-" . $mesAtual . "-01";
                $finalPeriodChosen = $anoAtual . "-" . $mesAtual . "-" . $diaFinal;
            }

            $start = strtotime($initialPeriodChosen);
            $end = strtotime($finalPeriodChosen);

            $firstDay = strtotime($transactions->day[0]);
            $lastDay = strtotime($transactions->day[($transactions->qtdDays) - 1]);

            if (($end < $firstDay) || ($start > $end) || ($start > $lastDay)) {
                $dayArr = null;
                $valueDay = null;
                $info = array();
                $data['transactions'] = $info;
            } else {
                if ($start < $firstDay) {
                    $initialPeriodChosen = date("Y-m-d", $firstDay);
                }

                if ($end > $lastDay) {
                    $finalPeriodChosen = date("Y-m-d", $lastDay);
                }
                for ($i = 0; $i < $transactions->qtdDays; $i++) {
                    if ($initialPeriodChosen == $transactions->day[$i])
                        break;
                }

                for ($j = $i; $j < $transactions->qtdDays; $j++) {
                    if ($finalPeriodChosen == $transactions->day[$j])
                        break;
                }

                $l = 0;


                for ($k = $i; $k <= $j; $k++) {
                    $date = explode("-", $transactions->day[$k]);
                    $date = $date[2] . "/" . $date[1] . "/" . $date[0];

                    $dayArr[$l] = $date;
                    $valueDay[$l] = $transactions->valueDay[$k];
                    $l++;
                }

                $info = array();

                $m = 0;

                for ($i = 0; $i < $l; $i++) {
                    $obj = new stdClass();
                    $obj->day = $dayArr[$i];
                    $obj->valueDay = $valueDay[$i];
                    $info[$m] = $obj;
                    $m++;
                }

                $data['transactions'] = $info;
            }
        }


        $this->loadReportView("reports/finances/transactions_expected", $data);
    }

    public function camps_donations() {
        $years = array();
        $end = 2015;
        $start = date('Y');
        while ($start >= $end) {
            $years[] = $start;
            $start--;
        }

        $month = null;
        $year = null;
        if (isset($_GET['mes']) && $_GET['mes'] != 0)
            $month = $_GET['mes'];
        if (isset($_GET['ano']) && $_GET['ano'] != 0)
            $year = $_GET['ano'];
        else {
            $year = date('Y');
        }

        $data['year'] = $year;
        $data['years'] = $years;
        $data['month'] = $month;
        $data['type'] = 'camps_donations';
        $data['donations'] = $this->donation_model->getDonationsDetailed(DONATION_TYPE_SUMMERCAMP_SUBSCRIPTION, $month, $year);
        $this->loadReportView("reports/finances/donations", $data);
    }

    public function subscriptions() {
        $camp = $this->input->get('camp', TRUE);
        $year = $this->input->get('year', TRUE);
        $status = $this->input->get('status', TRUE);
        $gender = $this->input->get('gender', TRUE);

        if (($this->input->get('associated', TRUE)) !== null) {
            $associated = $this->input->get('associated', TRUE);
        } else {
            $associated = null;
        }

        if (($this->input->get('type', TRUE)) !== null) {
            $type = $this->input->get('type', TRUE);
        } else {
            $type = null;
        }

        $data['camp'] = $camp;
        $data['type'] = $type;

        if ($gender == 'F')
            $data['pavilhao'] = 'Feminino';
        else
            $data['pavilhao'] = 'Masculino';

        $summercamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campId = null;

        foreach ($summercamps as $summercamp) {
            if ($summercamp->getCampName() == $camp) {
                $campId = $summercamp->getCampId();
                break;
            }
        }

        $colonists = $this->summercamp_model->getColonistsDetailedByYearSummerCampAssociationStatusAndGender($year, $status, $gender, $associated, $campId);

        if ($status == '0')
            $status = 'Pré-inscrição em elaboração';
        else if ($status == '1')
            $status = 'Pré-inscrição aguardando validação';
        else if ($status == '2')
            $status = 'Pré-inscrição validada';
        else if ($status == '3')
            $status = 'Pré-inscrição na fila de espera';
        else if ($status == '4')
            $status = 'Pré-inscrição aguardando doação';
        else if ($status == '5')
            $status = 'Inscrito';
        else if ($status == '6')
            $status = 'Pré-inscrição não validada';
        else if ($status == '-3')
            $status = 'Cancelado';
        else if ($status == '-2')
            $status = 'Excluído';
        else if ($status == '-1')
            $status = 'Desistente';

        $data['status'] = $status;
        $data['colonists'] = $colonists;
        $this->loadView("reports/summercamps/subscriptions", $data);
    }

    private function filterColonists($colonists, $room, $gender) {
        $resultArray = array();

        foreach ($colonists as $colonist) {
            if ($colonist->colonist_gender == $gender) {
                if ($room < 0)
                    $resultArray[] = $colonist;
                else if ($room == 0 && ($colonist->room_number == null ||
                        $colonist->room_number == 0 || $colonist->room_number == ''))
                    $resultArray[] = $colonist;
                else if ($colonist->room_number == $room)
                    $resultArray[] = $colonist;
            }
        }

        return $resultArray;
    }

    public function rooms() {
        $data = array();

        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        while ($start <= $end) {
            $years[] = $start;
            $start++;
        }
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = date('Y');
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['summer_camp_id'] = $campChosenId;
        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;


        if ($campChosenId != null && isset($_GET['quarto']) && isset($_GET["pavilhao"])) {
            $quarto = $_GET['quarto'];
            $data["quarto"] = $quarto;
            $pavilhao = $_GET['pavilhao'];
            $data["pavilhao"] = $pavilhao;
            $colonists = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED, $campChosenId, $pavilhao);

            $colonistsSelected = $this->filterColonists($colonists, $quarto, $pavilhao);


            $roomOccupation = [0, 0, 0, 0, 0, 0, 0];
            for ($i = 0; $i < count($roomOccupation); $i++) {
                $roomColonists = $this->filterColonists($colonists, $i, $pavilhao);
                $roomOccupation[$i] = count($roomColonists);
            }

            $data["room_occupation"] = $roomOccupation;
            $data["colonists"] = $colonistsSelected;
        }

        $this->loadReportView('reports/summercamps/rooms', $data);
    }

    public function staff() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        $end = $date;
        while ($campsByYear != null) {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        }
        $years = $this->summercamp_model->getAllSummerCampsYears();
        $year = null;

        if (isset($_GET['ano_f']))
            $year = $_GET['ano_f'];
        else {
            $year = $years[0];
        }

        $data['ano_escolhido'] = $year;
        $data['years'] = $years;

        $allCamps = $this->summercamp_model->getAllSummerCampsByYear($year);
        $campsQtd = count($allCamps);
        $camps = array();
        $start = $campsQtd;
        $end = 1;

        $campChosen = null;

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $camps[] = $camp->getCampName();
            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['summer_camp_id'] = $campChosenId;
        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;


        $staff = null;

        if ($campChosenId != null) {
            $staff = $this->summercamp_model->getCampStaff($campChosenId);
            $data['staff'] = $staff;
        }

        $this->loadReportView('reports/summercamps/staff', $data);
    }

}
