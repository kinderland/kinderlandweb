<?php

require_once APPPATH . 'core/CK_Controller.php';

class Reports extends CK_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('personuser_model');
        $this->load->model('summercamp_model');
        $this->load->model('cielotransaction_model');
        $this->load->model('donation_model');
        $this->load->model('campaign_model');
        $this->personuser_model->setLogger($this->Logger);
        $this->summercamp_model->setLogger($this->Logger);
        $this->cielotransaction_model->setLogger($this->Logger);
        $this->donation_model->setLogger($this->Logger);
        $this->campaign_model->setLogger($this->Logger);
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
        $data['users'] = $this->personuser_model->getAllUserRegistered();
        $this->loadReportView("reports/users/user_registered", $data);
    }

    public function all_users() {
        $data['users'] = $this->personuser_model->getAllUsersDetailed();
        $this->loadReportView("reports/users/all_users", $data);
    }

    public function toCSV() {
        $data = $this->input->post('data', TRUE);
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

    public function payments_bycard() {
        $type = $this->input->get('type', TRUE);
        $option = $this->input->get('option', TRUE);
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
        $results = $this->cielotransaction_model->statisticsPaymentsByCardFlag($searchfor, $option);
        $data['result'] = $results;
        if ($option == PAYMENT_REPORTBYCARD_VALUES) {
            $data['avulsas'] = $this->donation_model->sumFreeDonations();
            $sumAssociates = $this->donation_model->sumPayingAssociates();
            $data['associates'] = $sumAssociates;
        } else {
            $data['avulsas'] = $this->donation_model->countFreeDonations();
            $countAssociates = $this->donation_model->countPayingAssociates();
            $data['associates'] = $countAssociates;
        }
        $creditos[1] = 0;
        $creditos[2] = 0;
        $creditos[3] = 0;
        $creditos[4] = 0;
        $creditos[5] = 0;
        $creditos[6] = 0;

        if (isset($credito)) {
            if ($results["credito"] !== null) {

                foreach ($results["credito"] as $credito) {
                    for ($i = 1; $i <= 6; $i++)
                        if (isset($credito[$i]))
                            $creditos[$i] += $credito[$i];
                }
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
        $data['years'] = $this->campaign_model->getYearsCampaign();
        $this->loadView("reports/associated/associated_campaign", $data);
    }

    public function associated_year($year) {
        $data['summary'] = $this->campaign_model->getAssociatedCount($year);
        $data['users'] = $this->personuser_model->getAllContribuintsDetailed();
        $this->loadReportView("reports/associated/associated_year", $data);
    }

    public function all_transactions() {
        $this->Logger->info("Starting " . __METHOD__);

        $ano = $this->input->get('ano', TRUE);
        $data['payments'] = $this->cielotransaction_model->getPaymentsDetailed($ano);
        $data['years'] = $this->cielotransaction_model->getPaymentYears();
        if ($ano)
            $data['ano'] = $ano;
        else {
            $date = new DateTime('NOW');
            $data['ano'] = $date->format("Y");
        }
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
        
        $shownStatus = SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION . "," .
                SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN . "," .
                SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED . "," .
                SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED . "," .
                SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED . "," .
                SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP . "," .
                SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE . "," .
                SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT . "," .
                SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED . "," .
                SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS;
        
        $data['colonists'] = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year,$shownStatus);
        $this->loadReportView("reports/summercamps/colonist_registered", $data);
    }

    public function all_registrations() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
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
        
        $vacancy = 0;
        
        if($campChosenId != null) {
        	$camp = $this -> summercamp_model -> getSummerCampById($campChosenId);
        	$vacancy = $camp -> getCapacityMale() + $camp -> getCapacityFemale();
        }
        else {
        	foreach ($allCamps as $camp) {
        		$vacancy = $vacancy + $camp -> getCapacityMale() + $camp -> getCapacityFemale();
        	}
        }
        
        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;
        $data['vacancy'] = $vacancy;

        $action = null;

        if (isset($_GET['action']))
            $action = $_GET['action'];

        if ($action == 'Inscritos') {
            $colonists = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, 6, $campChosenId);
            $data['colonists'] = $colonists;
        }



        $genderM = 'M';
        $genderF = 'F';
        
        $countsAssociatedM = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,'TRUE',$campChosenId,$genderM);
        $countsNotAssociatedM = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,null,$campChosenId,$genderM);
        $countsAssociatedF = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,'TRUE',$campChosenId,$genderF);
        $countsNotAssociatedF = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,null,$campChosenId,$genderF);

        $countsAssociatedT = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,'TRUE',$campChosenId);
        $countsNotAssociatedT = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,null,$campChosenId);
        
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

    public function colonists_byschool() {

        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
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

        $schoolNames = $this->summercamp_model->getSchoolNamesByStatusSummerCampAndYear($year, $campChosenId);
        $countSchools = count($schoolNames);
        $start = 0;

        $schools = array();

        while ($start < $countSchools) {

            $school = $this->summercamp_model->getCountStatusSchoolBySchoolName($schoolNames[$start],$year,$campChosenId);

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

        $subscriptions = $this->summercamp_model->getCountSubscriptionsbyAssociated($year);

        $data['subscriptions'] = $subscriptions;
        $this->loadReportView("reports/summercamps/colonists_byassociated", $data);
    }

    public function subscriptions_bycamp() {
        $data = array();
        $years = array();
        $start = 2015;
        $date = date('Y');
        $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
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
	    	
	    	$countsAssociatedM[] = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,'TRUE',$campChosenId,$genderM);
	    	$countsNotAssociatedM[] = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,null,$campChosenId,$genderM);
	    	
	    	$countsAssociatedF[] = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,'TRUE',$campChosenId,$genderF);
	    	$countsNotAssociatedF[] = $this -> summercamp_model -> getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year,null,$campChosenId,$genderF);
	    	
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
        
        $genders = array(0 => "Feminino", 1 => "Masculino");
        
        $genderChosen = 'Masculino';
        if (isset($_GET['genero_f']))
        	$genderChosen = $_GET['genero_f'];
        
        $data['genero_escolhido'] = $genderChosen;
        $data['genders'] = $genders;
        
        if($campChosenId != null) {
        	if($genderChosen == 'Masculino') {
        		$colonists = $this -> summercamp_model -> getColonistsAgeAndSchoolYearBySummerCampAndGender($campChosenId,'M');
        	}
        	else {
        		$colonists = $this -> summercamp_model -> getColonistsAgeAndSchoolYearBySummerCampAndGender($campChosenId,'F');
        	}
        	
        	$data['colonists'] = $colonists;
        }
        
        $this -> loadReportView("reports/summercamps/colonist_byage", $data);
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
        $data['donations'] = $this->donation_model->getDonationsDetailed(DONATION_TYPE_ASSOCIATE, $month, $year);
        $this->loadReportView("reports/finances/donations", $data);
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
        $data['donations'] = $this->donation_model->getDonationsDetailed(DONATION_TYPE_FREEDONATION, $month, $year);
        $this->loadReportView("reports/finances/donations", $data);
    }

    public function failed_transactions() {
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
    	$date=date('Y');
    	$campsByYear = $this -> summercamp_model -> getAllSummerCampsByYear($date);
    	while($campsByYear!=null)
    	{
    		$end = $date;
    		$date++;
    		$campsByYear = $this -> summercamp_model -> getAllSummerCampsByYear($date);
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
    
    	$allCamps = $this -> summercamp_model -> getAllSummerCampsWithDiscountsByYear($year);
    	$campsQtd = count($allCamps);
    	$camps = array();
    	$start = $campsQtd;
    	$end = 1;
    
    	$campChosen = null;
    
    	if (isset($_GET['colonia_f']))
    		$campChosen = $_GET['colonia_f'];
    
    	$campChosenId = null;
    	foreach ($allCamps as $camp){
    		$camps[] = $camp->getCampName();
    		if($camp->getCampName() == $campChosen)
    			$campChosenId = $camp->getCampId();
    	}
    
    	$data['colonia_escolhida'] = $campChosen;
    	$data['camps'] = $camps;
    	
    	$discountsT=null;
    	$discountsI=null;
   		$colonists = $this -> summercamp_model -> getColonistsInformationWithDiscounts($year,$campChosenId);
   		
    	if($campChosen != null || $campChosen == "Todas") {
    		if($campChosen == "Todas") {
    			$discountsT = $this -> summercamp_model -> getCountDiscountsBySummerCamp($year);
    			$discountsI = $this -> summercamp_model -> getCountDiscountsBySummerCamp($year,null,"TRUE");
    		}
    		else {
    			$discountsT = $this -> summercamp_model -> getCountDiscountsBySummerCamp($year,$campChosenId);
    			$discountsI = $this -> summercamp_model -> getCountDiscountsBySummerCamp($year,$campChosenId,"TRUE");
    		}
    	
    	$data['discountsT'] = $discountsT;
    	$data['discountsI'] = $discountsI;
    	}
    	
    	$data['colonists'] = $colonists;
    	$this -> loadReportView("reports/summercamps/discounts", $data);
    }

}
