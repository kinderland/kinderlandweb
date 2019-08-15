<?php

require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/summercamp.php';
require_once APPPATH . 'core/summercampSubscription.php';
require_once APPPATH . 'core/colonist.php';
require_once APPPATH . 'core/event.php';
require_once APPPATH . 'controllers/events.php';
require_once APPPATH . 'core/campaign.php';
require_once APPPATH . 'core/summerCampPaymentPeriod.php';
require_once APPPATH . 'core/document_expense.php';
require_once APPPATH . 'core/bankdata.php';

class Admin extends CK_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('person_model');
        $this->load->model('personuser_model');
        $this->load->model('summercamp_model');
        $this->load->model('colonist_model');
        $this->load->model('address_model');
        $this->load->model('telephone_model');
        $this->load->model('donation_model');
        $this->load->model('generic_model');
        $this->load->model('validation_model');
        $this->load->model('email_model');
        $this->load->model('event_model');
        $this->load->model('eventsubscription_model');
        $this->load->model('campaign_model');
        $this->load->model('documentexpense_model');
        $this->load->model('finance_model');

        $this->person_model->setLogger($this->Logger);
        $this->personuser_model->setLogger($this->Logger);
        $this->summercamp_model->setLogger($this->Logger);
        $this->colonist_model->setLogger($this->Logger);
        $this->address_model->setLogger($this->Logger);
        $this->telephone_model->setLogger($this->Logger);
        $this->donation_model->setLogger($this->Logger);
        $this->generic_model->setLogger($this->Logger);
        $this->validation_model->setLogger($this->Logger);
        $this->email_model->setLogger($this->Logger);
        $this->event_model->setLogger($this->Logger);
        $this->eventsubscription_model->setLogger($this->Logger);

        $this->campaign_model->setLogger($this->Logger);
        $this->documentexpense_model->setLogger($this->Logger);
        $this->finance_model->setLogger($this->Logger);
    }

    public function campaign_admin() {
        $this->loadView("admin/campaigns/campaign_admin_container");
    }

    public function manageCampaigns() {
        $this->Logger->info("Starting " . __METHOD__);

        if (!$this->checkSession())
            redirect("login/index");

        if (!$this->checkPermition(array(SYSTEM_ADMIN))) {
            $this->denyAcess(___METHOD___);
        }
        $data["campaigns"] = $this->campaign_model->getAllCampaigns();

        $this->loadReportView("admin/campaigns/manageCampaigns", $data);
    }

    public function credit_operation() {
        $secretaries = $this->personuser_model->getUsersByUserType('4');
        $secretariesWithBalance = $this->personuser_model->getAllSecretariesWithBalances();

        $balances = $this->personuser_model->getSecretariesBalances();

        $data['secretaries'] = $secretaries;
        $data['secretariesWithBalance'] = $secretariesWithBalance;
        $data['balances'] = $balances;

        $this->loadReportView("admin/finances/credit_operation", $data);
    }

    public function newOperation() {
        $secretary_id = $this->input->post("secretary_id", true);
        $value = $this->input->post("value", true);

        if ($this->personuser_model->newOperation($secretary_id, $value)) {
            echo "true";
            return;
        } else {
            echo "false";
            return;
        }
    }
    
    public function createTemporaryAssociate() {
    	$temporaryAssociate = $this -> personuser_model -> getTemporaryAssociateByPersonIdAndYear($this->session->userdata("user_id"),date("Y"));
    	
    	if($temporaryAssociate !== FALSE){
    		$data['temporaryAssociate'] = $temporaryAssociate;
    	}else{
    		$data['temporaryAssociate'] = null;
    	}
    	
    	$people = $this->personuser_model ->getAllUserAndPersonInfo();
    	$name = array();
    	
    	foreach($people as $p){
    		$name[$p->cpf] = $p->fullname;
    	}
    	
    	$data['name'] = $name;
    	
    	$this->loadView("admin/users/temporary_associates", $data);
    }
    
    public function checkCPF(){
    	$cpf = $this->input->post("cpf", true);
    	
    	if($this->personuser_model->cpfExists($cpf)){
    		if(!$this->personuser_model->isCPFAssociate($cpf)){
	    		echo "true";
	    		return;
    		}else{
    			echo "false";
    			return;
    		}
    	}else{
    		echo "false";
    		return;
    	}
    }
    
    public function checkTemporarySubscription(){
    	$associate_id = $this->input->post("associate_id", true);
    	 
    	if(!$this->summercamp_model->temporaryHasSubscription($associate_id)){
    		echo "true";
    		return;
    	}else{
    		echo "false";
    		return;
    	}
    }
    
    public function checkSubscription(){
    	$associate_id = $this->input->post("associate_id", true);
    	
    		if(!$this->summercamp_model->hasValidSubscription($associate_id)){
    			echo "true";
    			return;
    		}else{
    			echo "false";
    			return;
    		}
    }
    
    public function updateTemporaryAssociate(){
    	$cpf = $this->input->post("cpf", true);
    	$associate_id = $this->input->post("associate_id", true);
    	$type = $this->input->post("type", true);
    	
    	$temporary_associate = $this->personuser_model->getPersonByCpf($cpf);
    	
    	if($type == 'atualizar'){
	    	if(!$this->personuser_model->isPersonTemporaryAssociatedThisYear($associate_id,$temporary_associate->person_id,date("Y"))){
	    		if($this->personuser_model->deleteTemporary($associate_id,date("Y"))){
	    			if($this -> personuser_model ->insertNewTemporary($associate_id,$temporary_associate->person_id,date("Y"))){
	    				echo "true";
	    				return;
	    			}else {
	    				echo "false";
	    				return;
	    			}
	    		}else {
	    			echo "false";
	    			return;
	    		}
	    	}else{
	    		echo "true";
	    		return;
	    	}
    	}else if($type == 'salvar'){
    		if($this->personuser_model->insertNewTemporary($associate_id,$temporary_associate->person_id,date("Y"))){
    			echo "true";
    			return;
    		}else {
    			echo "false";
    			return;
    		}
    	}   	
    	
    }
    
    public function updateFriend(){
    	$camp_id = $this->input->post("camp_id", true);
    	$colonist_id = $this->input->post("colonist_id", true);
    	$number = $this->input->post("number", true);
    	$name1 = $this->input->post("name1", true);
    	$name2 = $this->input->post("name2", true);
    	$name3 = $this->input->post("name3", true);
    		
    	 
    		if($this->summercamp_model->updateRoomates($colonist_id,$camp_id,$name1,$name2,$name3)){
    			echo "true";
    			return;
    		}else {
    			echo "false";
    			return;
    		}
    	 
    }
    
    public function deleteTemporaryAssociate(){
    	$associate_id = $this->input->post("associate_id", true);
    	
    	if($this->personuser_model->deleteTemporary($associate_id,date("Y"))){
    		echo "true";
    		return;
    	}else {
    		echo "false";
    		return;
    	}
    }

    public function manage_accounts() {
        $accounts = $this->finance_model->getAllAccountsInformations();

        $accountTypes = $this->finance_model->getAllAccountTypes();

        $typeAccounts = "";

        foreach ($accountTypes as $a) {
            $typeAccounts = $typeAccounts . $a->name . "/";
        }

        $data['accounts'] = $accounts;
        $data['account_name'] = "";
        $data['account_description'] = "";
        $data['accountTypes'] = $typeAccounts;
        $this->loadReportView("admin/finances/manage_accounts", $data);
    }

    public function manage_account_types() {
        $accountTypes = $this->finance_model->getAllAccountTypes();

        $data['account_type_name'] = "";
        $data['accountTypes'] = $accountTypes;
        $this->loadReportView("admin/finances/manage_account_type", $data);
    }

    public function checkIfAccountNameExists() {
        $account_name = $this->input->post("account_name", true);

        $accounts = $this->finance_model->getAllAccountsInformations();

        foreach ($accounts as $account) {
            if (strcmp(mb_strtoupper($account->account_name, 'UTF-8'), mb_strtoupper($account_name, 'UTF-8')) == 0) {
                echo false;
                return;
            }
        }

        echo true;
        return;
    }

    public function checkIfAccountTypeNameExists() {
        $account_type_name = $this->input->post("account_type_name", true);

        $accounts = $this->finance_model->getAllAccountTypes();

        foreach ($accounts as $account) {
            if (strcmp(mb_strtoupper($account->name, 'UTF-8'), mb_strtoupper($account_type_name, 'UTF-8')) == 0) {
                echo false;
                return;
            }
        }

        echo true;
        return;
    }

    public function checkIfAccountNameIsInUse() {
        $account_name = $this->input->post("account_name", true);

        $postingExpenses = $this->finance_model->getAllPostingExpenses();

        foreach ($postingExpenses as $pe) {
            if (strcmp(mb_strtoupper($pe->account_name, 'UTF-8'), mb_strtoupper($account_name, 'UTF-8')) == 0) {
                echo false;
                return;
            }
        }

        echo true;
        return;
    }

    public function checkIfAccountTypeNameIsInUse() {
        $account_type_id = $this->input->post("account_type_id", true);

        $accounts = $this->finance_model->getAllAccountsInformations();

        foreach ($accounts as $a) {
            if ($a->account_type_id == $account_type_id) {
                echo false;
                return;
            }
        }

        echo true;
        return;
    }

    public function newAccountName() {
        $account_name = $this->input->post("account_name", true);
        $account_type = $this->input->post("account_type", true);
        $account_description = $this->input->post("account_description", true);
        $this->Logger->info("TIPO DE CONTA: " . $account_type);
        $accounts = $this->finance_model->getAllAccountTypes();

        foreach ($accounts as $account) {
            if (strcmp(mb_strtoupper($account->name, 'UTF-8'), mb_strtoupper($account_type, 'UTF-8')) == 0) {
                $account_type_id = $account->account_type_id;
            }
        }

        if ($this->finance_model->insertNewAccount($account_name, $account_type_id, $account_description)) {
            echo true;
            return;
        } else {
            echo false;
            return;
        }
    }

    public function newAccountTypeName() {
        $account_type_name = $this->input->post("account_type_name", true);

        if ($this->finance_model->insertNewAccountType($account_type_name)) {
            echo true;
            return;
        } else {
            echo false;
            return;
        }
    }

    public function deleteAccountName() {
        $account_name = $this->input->post("account_name", true);

        if ($this->finance_model->deleteAccount($account_name)) {
            echo true;
            return;
        } else {
            echo false;
            return;
        }
    }

    public function deleteAccountTypeName() {
        $account_type_id = $this->input->post("account_type_id", true);

        if ($this->finance_model->deleteAccountType($account_type_id)) {
            echo true;
            return;
        } else {
            echo false;
            return;
        }
    }

    public function campaignCreate($errors = array(), $date_start = NULL, $date_finish = NULL, $payments = array()) {
        $this->Logger->info("Starting " . __METHOD__);
        $data = array();
        $data["errors"] = $errors;
        $data["date_start"] = $date_start;
        $data["date_finish"] = $date_finish;
        $data["payments"] = $payments;

        $this->loadReportView("admin/campaigns/campaignCreate", $data);
    }

    public function completeCampaign() {
        $this->Logger->info("Starting " . __METHOD__);
        $date_start = $this->input->post('date_start', TRUE);
        $date_finish = $this->input->post('date_finish', TRUE);
        $price = $this->input->post('price', TRUE);
        $prep_payment_start = $this->input->post('payment_date_start', TRUE);
        $prep_payment_end = $this->input->post('payment_date_end', TRUE);
        $portions = $this->input->post('portions', TRUE);
        $date_created = date("Y-m-d H:i:s");
        $errors = array();
        $payments = array();
        $payments_error = array();
        $periods_count = count($prep_payment_start);
        if (!isset($date_start) || empty($date_start))
            $errors[] = 'Campo Início é obrigatório.\n';
        if (!isset($date_finish) || empty($date_finish))
            $errors[] = 'Campo Fim é obrigatório.\n';
        if (count($errors) === 0) {
            $new_date_start = explode("/", $date_start);
            $year = $new_date_start[2];
            $new_date_start = strval($new_date_start[2]) . "-" . strval($new_date_start[1]) . "-" . strval($new_date_start[0] . " 00:00:00");
            $new_date_finish = explode("/", $date_finish);
            $new_date_finish = strval($new_date_finish[2]) . "-" . strval($new_date_finish[1]) . "-" . strval($new_date_finish[0] . " 23:59:59");
            $campaigns = $this->campaign_model->getAllCampaigns();
            foreach ($campaigns as $campaign) {
                if ($campaign->getCampaignYear() === $year) {
                    $errors[] = 'Já existe uma outra campanha que começou nesse ano.\n';
                    break;
                }
            }

            if (!Events::verifyAntecedence($date_start, $date_finish)) {
                $errors[] = 'Data de início deve proceder a data de fim.\n';
            }
        }
        if (is_array($price)) {
            for ($i = 0; $i < $periods_count; $i++) {

                if (!$prep_payment_start[$i])
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " não tem data de inicio\\n";
                if (!$prep_payment_end[$i])
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " não tem data de fim\\n";
                if (!isset($price[$i]))
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " não tem valor\\n";
                if (!isset($portions[$i]))
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " não tem número de parcelas\\n";
                if ($price && intval($price[$i]) <= 0)
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " precisa de um valor maior que zero\\n";
                if ($portions && intval($price) <= 0)
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " precisa de número de parcelas maior que zero\\n";
                if ($i === 0) {
                    if ($prep_payment_start[$i] && $prep_payment_start[$i] !== $date_start)
                        $errors[] = "O primeiro período de pagamento deve começar no mesmo dia de início da campanha\\n";
                }
                if ($i === ($periods_count - 1)) {
                    if ($prep_payment_end[$i] && $prep_payment_end[$i] !== $date_finish)
                        $errors[] = "O último período de pagamento deve terminar no mesmo dia de término da campanha\\n";
                }
                else if ($prep_payment_end[$i] && $prep_payment_start[$i + 1]) {
                    $helper_finish = DateTime::CreateFromFormat('Y-m-d', implode("-", array_reverse(explode("/", $prep_payment_end[$i]))));
                    $helper_start = DateTime::CreateFromFormat('Y-m-d', implode("-", array_reverse(explode("/", $prep_payment_start[$i + 1]))));
                    $diff = $helper_finish->diff($helper_start)->days;
                    if ($diff !== 1)
                        $errors[] = "O periodo de pagamento de número " . ($i + 2) . " deve começar 1 dia após o término do período de pagamento de número " . ($i + 1) . "\\n";
                }

                if ($prep_payment_start[$i] && $prep_payment_end[$i] && !Events::verifyAntecedence($prep_payment_start[$i], $prep_payment_end[$i])) {
                    $errors[] = "O pagamento de número " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
                }
                if ($prep_payment_start[$i] && $prep_payment_end[$i] && (
                        !Events::verifyAntecedence($prep_payment_start[$i], $date_finish) ||
                        !Events::verifyAntecedence($prep_payment_end[$i], $date_finish) ||
                        !Events::verifyAntecedence($date_start, $prep_payment_start[$i]) )
                )
                    $errors[] = "O pagamento de numero " . ($i + 1) . " está fora do periodo de inscrições\\n";
                /* for ($j = $i + 1; $j < $periods_count; $j++) {
                  if
                  (
                  (
                  Events::verifyAntecedence($prep_payment_start[$i], $prep_payment_start[$j]) && Events::verifyAntecedence($prep_payment_start[$j], $prep_payment_end[$i])
                  ) ||
                  (
                  Events::verifyAntecedence($prep_payment_start[$j], $prep_payment_start[$i]) && Events::verifyAntecedence($prep_payment_start[$i], $prep_payment_end[$j])
                  )
                  )
                  $errors[] = "Os pagamentos de numero" . ($i + 1) . " e " . ($j + 1) . " se sobrepoem\\n";
                  } */
            }
            if (count($errors) === 0) {
                for ($i = 0; $i < $periods_count; $i++) {

                    $payments_error[] = array(
                        "payment_date_start" => $prep_payment_start[$i],
                        "payment_date_end" => $prep_payment_end[$i],
                        "price" => $price[$i],
                        "portions" => $portions[$i]
                    );

                    $helper = explode("/", $prep_payment_start[$i]);
                    $p_start = strval($helper[2]) . "-" . strval($helper[1]) . "-" . strval($helper[0] . " 00:00:00");
                    $helper = explode("/", $prep_payment_end[$i]);
                    $p_end = strval($helper[2]) . "-" . strval($helper[1]) . "-" . strval($helper[0] . " 23:59:59");

                    $payments[] = array(
                        "payment_date_start" => $p_start,
                        "payment_date_finish" => $p_end,
                        "price" => $price[$i],
                        "portions" => $portions[$i]
                    );
                }
            }
        }//Fecha os erros dos pagamentos. Deixar isso aqui por enquanto.

        if (count($errors) > 0) {
            return $this->campaignCreate($errors, $date_start, $date_finish, $payments_error);
        }
        try {
            $this->Logger->info("Inserting new campaign");
            $this->generic_model->startTransaction();
            $campaignId = $this->campaign_model->insertNewCampaign($year, $date_created, $new_date_start, $new_date_finish);
            if ($campaignId) {
                foreach ($payments as $payment) {
                    $paymentId = $this->campaign_model->InsertNewPaymentPeriod($campaignId, $payment["payment_date_start"], $payment["payment_date_finish"], $payment["price"], $payment["portions"]);
                }
                $this->generic_model->commitTransaction();
                $this->Logger->info("New campaign successfully inserted");
                echo "<script>alert('Campanha criada com sucesso!');opener.location.reload(); window.close();</script>";
            } else
                echo "<script>alert('Ocorreu um erro ao criar a campanha. Tente novamente.');window.history.back();</script>";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new campaign");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            $this->loadReportView('admin/ecampaigns/campaignCreate', $data);
        }
    }

    public function editCampaign($campaign_id = NULL, $errors = array()) {

        $campaign = $this->campaign_model->getCampaignById($campaign_id);
        $date_start = $campaign->getDateStart();
        $date_finish = $campaign->getDateFinish();
        $current = $this->campaign_model->CheckCampaignCurrency($campaign_id);
        $date_start = explode(" ", $date_start);
        $date_start = explode("-", $date_start[0]);
        $date_start = implode("/", array_reverse($date_start));
        $date_finish = explode(" ", $date_finish);
        $date_finish = explode("-", $date_finish[0]);
        $date_finish = implode("/", array_reverse($date_finish));
        $all_payments = $this->campaign_model->GetCampaignPeriods($campaign_id);
        $payments = array();
        if ($all_payments) {
            foreach ($all_payments as $payment) {
                $helper = explode(" ", $payment->date_start);
                $helper = explode("-", $helper[0]);
                $p_start = implode("/", array_reverse($helper));
                $helper = explode(" ", $payment->date_finish);
                $helper = explode("-", $helper[0]);
                $p_finish = implode("/", array_reverse($helper));

                $payments[] = array(
                    "payment_date_start" => $p_start,
                    "payment_date_finish" => $p_finish,
                    "price" => $payment->price,
                    "portions" => $payment->portions
                );
            }
        }
        $data['date_start'] = $date_start;
        $data['date_finish'] = $date_finish;
        $data['current'] = $current;
        $data['campaign_id'] = $campaign_id;
        $data['errors'] = $errors;
        $data['payments'] = $payments;
        $this->loadReportView("admin/campaigns/editCampaign", $data);
    }

    public function updateCampaign() {
        $this->Logger->info("Starting " . __METHOD__);
        $date_start = $this->input->post('date_start', TRUE);
        $date_finish = $this->input->post('date_finish', TRUE);
        $price = $this->input->post('price', TRUE);
        $prep_payment_start = $this->input->post('payment_date_start', TRUE);
        $prep_payment_end = $this->input->post('payment_date_end', TRUE);
        $portions = $this->input->post('portions', TRUE);
        $campaign_id = $this->input->post('id', TRUE);
        $current = $this->input->post('current', TRUE);
        $errors = array();
        $periods_count = count($price);
        $payments = count($price);
        
        $this->Logger->info("DATE START CAMPAIGN: ". $date_start);
        $this->Logger->info("DATE FINISH CAMPAIGN: ". $date_finish);
        if (!isset($date_start) || empty($date_start))
            $errors[] = 'Campo Início é obrigatório.\n';
        if (!isset($date_finish) || empty($date_finish))
            $errors[] = 'Campo Fim é obrigatório.\n';
        if (count($errors) === 0) {
            $new_date_start = explode("/", $date_start);
            $year = $new_date_start[2];
            $new_date_start = strval($new_date_start[2]) . "-" . strval($new_date_start[1]) . "-" . strval($new_date_start[0] . " 00:00:00");
            $new_date_finish = explode("/", $date_finish);
            $new_date_finish = strval($new_date_finish[2]) . "-" . strval($new_date_finish[1]) . "-" . strval($new_date_finish[0] . " 23:59:59");
            /*   $campaigns = $this->campaign_model->getAllCampaigns();
              foreach ($campaigns as $campaign) {
              if ($campaign->getCampaignYear() === $year) {
              $errors[] = 'Já existe uma outra campanha que começou nesse ano.\n';
              break;
              }
              } */

            if (!Events::verifyAntecedence($date_start, $date_finish)) {
                $errors[] = 'Data de início deve anteceder a data de fim.\n';
            }
            if ($current) {
                $current_campaign = $this->campaign_model->getCampaignById($campaign_id);
                $current_date_finish = $current_campaign->getDateFinish();
                $current_date_finish = explode(" ", $current_date_finish);

                $current_date_finish = implode("/", array_reverse(explode("-", $current_date_finish[0])));

                if (!Events::verifyAntecedence($current_date_finish, $date_finish))
                    $errors[] = "Campanhas em andamento ou finalizadas não podem ser encurtadas\\n";
            }
        }

        if (is_array($price)) {
            for ($i = 0; $i < $periods_count; $i++) {
                if (!$prep_payment_start[$i])
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " não tem data de inicio\\n";
                if (!$prep_payment_end[$i])
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " não tem data de fim\\n";
                if (!isset($price[$i]))
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " não tem valor\\n";
                if (!isset($portions[$i]))
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " não tem número de parcelas\\n";
                if ($price && intval($price[$i]) <= 0)
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " precisa de um valor maior que zero\\n";
                if ($portions && intval($price) <= 0)
                    $errors[] = "O periodo de pagamento de número " . ($i + 1) . " precisa de número de parcelas maior que zero\\n";
                if ($i === 0) {
                    if ($prep_payment_start[$i] && $prep_payment_start[$i] !== $date_start)
                        $errors[] = "O primeiro período de pagamento deve começar no mesmo dia de início da campanha\\n";
                }
                if ($i === ($periods_count - 1)) {
                    if ($prep_payment_end[$i] && $prep_payment_end[$i] !== $date_finish)
                        $errors[] = "O último período de pagamento deve terminar no mesmo dia de término da campanha\\n";
                }
                else if ($prep_payment_end[$i] && $prep_payment_start[$i + 1]) {
                    $helper_finish = DateTime::CreateFromFormat('Y-m-d', implode("-", array_reverse(explode("/", $prep_payment_end[$i]))));
                    $helper_start = DateTime::CreateFromFormat('Y-m-d', implode("-", array_reverse(explode("/", $prep_payment_start[$i + 1]))));
                    $diff = $helper_finish->diff($helper_start)->days;
                    if ($diff !== 1)
                        $errors[] = "O periodo de pagamento de número " . ($i + 2) . " deve começar 1 dia após o término do período de pagamento de número " . ($i + 1) . "\\n";
                }

                if ($prep_payment_start[$i] && $prep_payment_end[$i] && !Events::verifyAntecedence($prep_payment_start[$i], $prep_payment_end[$i])) {
                    $errors[] = "O pagamento de número " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
                }
                if ($prep_payment_start[$i] && $prep_payment_end[$i] && (
                        !Events::verifyAntecedence($prep_payment_start[$i], $date_finish) ||
                        !Events::verifyAntecedence($prep_payment_end[$i], $date_finish) ||
                        !Events::verifyAntecedence($date_start, $prep_payment_start[$i]) )
                )
                    $errors[] = "O pagamento de numero " . ($i + 1) . " está fora do periodo de inscrições\\n";
                /* for ($j = $i + 1; $j < $periods_count; $j++) {
                  if
                  (
                  (
                  Events::verifyAntecedence($prep_payment_start[$i], $prep_payment_start[$j]) && Events::verifyAntecedence($prep_payment_start[$j], $prep_payment_end[$i])
                  ) ||
                  (
                  Events::verifyAntecedence($prep_payment_start[$j], $prep_payment_start[$i]) && Events::verifyAntecedence($prep_payment_start[$i], $prep_payment_end[$j])
                  )
                  )
                  $errors[] = "Os pagamentos de numero" . ($i + 1) . " e " . ($j + 1) . " se sobrepoem\\n";
                  } */
            }
        }  //Fecha os erros dos pagamentos. Deixar isso aqui por enquanto.
        if (count($errors) > 0) {
            return $this->editCampaign($campaign_id, $errors);
        }

        try {
            $this->Logger->info("Updating campaign " . $campaign_id);
            $this->generic_model->startTransaction();

            $campaignId = $this->campaign_model->updateCampaign($campaign_id, $new_date_start, $new_date_finish);

            if ($campaignId) {
                $result = $this->campaign_model->DeleteOldPeriods($campaign_id);
                for ($i = 0; $i < $periods_count; $i++) {
                    $helper = explode("/", $prep_payment_start[$i]);
                    $p_start = strval($helper[2]) . "-" . strval($helper[1]) . "-" . strval($helper[0] . " 00:00:00");
                    $helper = explode("/", $prep_payment_end[$i]);
                    $p_finish = strval($helper[2]) . "-" . strval($helper[1]) . "-" . strval($helper[0] . " 23:59:59");
                    $paymentId = $this->campaign_model->InsertNewPaymentPeriod($campaign_id, $p_start, $p_finish, $price[$i], $portions[$i]);
                }
                $this->generic_model->commitTransaction();
                $this->Logger->info("New campaign successfully inserted");
                echo "<script>alert('Campanha atualizada com sucesso!');opener.location.reload(); window.close();</script>";
//redirect("events/manageEvents");
            } else
                echo "<script>alert('Ocorreu um erro ao atualizar a campanha. tente novamente.');window.history.back();</script>";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new campaign");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;

            echo "<script>alert('Ocorreu um erro ao atualizar a campanha. Tente novamente.');window.history.back();</script>";

//$this->loadReportView('admin/campaigns/editCampaign', $data);
        }
    }

    public function event_admin() {
        $this->loadView("admin/events/event_admin_container");
    }

    public function completeEvent() {
        $this->Logger->info("Starting " . __METHOD__);

        $event_name = $this->input->post('event_name', TRUE);
        $description = $this->input->post('description', TRUE);
        $date_start = $this->input->post('date_start', TRUE);
        $date_finish = $this->input->post('date_finish', TRUE);
        $date_start_show = $this->input->post('date_start_show', TRUE);
        $date_finish_show = $this->input->post('date_finish_show', TRUE);
        $capacity_male = $this->input->post('capacity_male', TRUE);
        $capacity_female = $this->input->post('capacity_female', TRUE);
        $capacity_nonsleeper = $this->input->post('capacity_nonsleeper', TRUE);
        $payments = array();
        $payment_date_end = $this->input->post("payment_date_end", TRUE);
        $payment_date_start = $this->input->post("payment_date_start", TRUE);
        $full_price = $this->input->post("full_price", TRUE);
        $children_price = $this->input->post("children_price", TRUE);
        $middle_price = $this->input->post("middle_price", TRUE);
        $payment_portions = $this->input->post("payment_portions", TRUE);
        $associated_discount = $this->input->post("associated_discount", TRUE);
        $enabled = $this->input->post("enabled", TRUE);
        $error = $this->input->post("error", TRUE);
        $type = $this->input->post("type", TRUE);
        if ($type == "")
            $type = null;
        $errors = array();


        if ($event_name === "")
            $errors[] = "O campo nome é obrigatório\n";
        if (!$date_start)
            $date_start = NULL;
        if (!$date_start_show)
            $date_start_show = NULL;
        if (!$date_finish)
            $date_finish = NULL;
        if (!$date_finish_show)
            $date_finish_show = NULL;
        if (!$enabled)
            $enabled = "false";
        else if ($enabled === "1")
            $enabled = "true";

        if ($date_start && $date_finish && !Events::verifyAntecedence($date_start, $date_finish))
            $errors[] = "A data do inicio do período do evento antecede a data de fim do evento\\n";

        if ($date_start_show && $date_finish_show && !Events::verifyAntecedence($date_start_show, $date_finish_show))
            $errors[] = "A data do inicio do período de inscrições antecede a data de fim do periodo de inscrições\\n";
        
        if ($date_start_show && $date_finish_show && !Events::verifyAntecedence($date_finish_show, $date_finish))
        	$errors[] = "A data de fim do evento antecede a data do fim do período de inscrições\\n";


        if ($capacity_male === "")
            $capacity_male = 0;
        if ($capacity_female === "")
            $capacity_female = 0;
        if ($capacity_nonsleeper === "")
            $capacity_nonsleeper = 0;

        if (is_array($full_price)) {
            for ($i = 0; $i < count($full_price); $i++) {

                if (!$payment_date_start[$i])
                    $errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem data de inicio\\n";
                if (!$payment_date_end[$i])
                    $errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem data de fim\\n";
                if (!$full_price[$i])
                    $errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem valor\\n";
                if (!$middle_price[$i])
                    $middle_price[$i] = 0;
                if (!$children_price[$i])
                    $children_price[$i] = 0;
                if ($payment_date_start[$i] && $payment_date_end[$i] && !Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$i])) {
                    $errors[] = "O pagamento de numero " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
                }
                if ($payment_date_start[$i] && $payment_date_end[$i] && (
                        !Events::verifyAntecedence($payment_date_start[$i], $date_finish_show) ||
                        !Events::verifyAntecedence($payment_date_end[$i], $date_finish_show) ||
                        !Events::verifyAntecedence($date_start_show, $payment_date_start[$i]) )
                )
                    $errors[] = "O pagamento de numero " . ($i + 1) . " está fora do periodo de inscrições\\n";
                for ($j = $i + 1; $j < count($full_price); $j++) {
                    if
                    (
                            (
                            Events::verifyAntecedence($payment_date_start[$i], $payment_date_start[$j]) && Events::verifyAntecedence($payment_date_start[$j], $payment_date_end[$i])
                            ) ||
                            (
                            Events::verifyAntecedence($payment_date_start[$j], $payment_date_start[$i]) && Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$j])
                            )
                    )
                        $errors[] = "Os pagamentos de numero" . ($i + 1) . " e " . ($j + 1) . " se sobrepoem\\n";
                }

                if ($payment_date_start[$i]) {

                    $payment_date_start[$i] = explode("/", $payment_date_start[$i]);
                    $payment_date_start[$i] = strval($payment_date_start[$i][2]) . "-" . strval($payment_date_start[$i][1]) . "-" . strval($payment_date_start[$i][0]);
                }

                if ($payment_date_end[$i]) {
                    $payment_date_end[$i] = explode("/", $payment_date_end[$i]);
                    $payment_date_end[$i] = strval($payment_date_end[$i][2]) . "-" . strval($payment_date_end[$i][1]) . "-" . strval($payment_date_end[$i][0] . " 23:59:59");
                }

                $payments[] = array(
                    "payment_date_start" => $payment_date_start[$i],
                    "payment_date_end" => $payment_date_end[$i],
                    "full_price" => $full_price[$i],
                    "children_price" => $children_price[$i],
                    "middle_price" => $middle_price[$i],
                    "payment_portions" => $payment_portions[$i],
                    "associated_discount" => $associated_discount[$i] / 100,
                );
            }
        } else if ($full_price !== FALSE) {
            if (!$payment_date_start)
                $errors[] = "O pagamento não tem data de inicio\\n";
            if (!$payment_date_end)
                $errors[] = "O pagamento não tem data de fim\\n";
            if (!$full_price)
                $errors[] = "O pagamento não tem valor\\n";
            if (!$middle_price)
                $middle_price = 0;
            if (!$children_price)
                $children_price = 0;
            if ($payment_date_start[$i] && $payment_date_end[$i] && !Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$i])) {
                $errors[] = "O pagamento de numero " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
            }

            for ($i = 0; $i < count($full_price); $i++) {

                if ($payment_date_start[$i]) {
                    $payment_date_start[$i] = explode("/", $payment_date_start[$i]);
                    $payment_date_start[$i] = strval($payment_date_start[$i][2]) . "-" . strval($payment_date_start[$i][1]) . "-" . strval($payment_date_start[$i][0]);
                }

                if ($payment_date_end[$i]) {
                    $payment_date_end[$i] = explode("/", $payment_date_end[$i]);
                    $payment_date_end[$i] = strval($payment_date_end[$i][2]) . "-" . strval($payment_date_end[$i][1]) . "-" . strval($payment_date_end[$i][0] . " 23:59:59");
                }
            }

            $payments[] = array(
                "payment_date_start" => $payment_date_start,
                "payment_date_end" => $payment_date_end,
                "full_price" => $full_price,
                "children_price" => $children_price,
                "middle_price" => $middle_price,
                "payment_portions" => $payment_portions,
                "associated_discount" => $associated_discount / 100,
            );
        }

        if ($date_start) {
            $date_start = explode("/", $date_start);
            $date_start = strval($date_start[2]) . "-" . strval($date_start[1]) . "-" . strval($date_start[0]);
        }

        if ($date_finish) {
            $date_finish = explode("/", $date_finish);
            $date_finish = strval($date_finish[2]) . "-" . strval($date_finish[1]) . "-" . strval($date_finish[0] . " 23:59:59");
        }

        if ($date_start_show) {
            $date_start_show = explode("/", $date_start_show);
            $date_start_show = strval($date_start_show[2]) . "-" . strval($date_start_show[1]) . "-" . strval($date_start_show[0]);
        }

        if ($date_finish_show) {
            $date_finish_show = explode("/", $date_finish_show);
            $date_finish_show = strval($date_finish_show[2]) . "-" . strval($date_finish_show[1]) . "-" . strval($date_finish_show[0] . " 23:59:59");
        }

        $events = $this->event_model->getAllEvents();

        foreach ($events as $event) {

            if ($date_start && $date_finish && ((Events::verifyAntecedence($event->getDateStart(), $date_start) && Events::verifyAntecedence($date_start, $event->getDateFinish())) || (Events::verifyAntecedence($event->getDateStart(), $date_finish) && Events::verifyAntecedence($date_finish, $event->getDateFinish())))) {
                $errors[] = "Há um evento nesse período\\n";
                break;
            }
        }

        if (count($errors) > 0 || $error != "") {

            $paymentsError = array();

            foreach ($payments as $payment) {

                $datePayment = null;
                $datePaymentEnd = null;

                if ($payment['payment_date_start']) {
                    $datePayment = explode("-", $payment['payment_date_start']);
                    $dateDay = explode(" ", $datePayment[2]);
                    $datePayment = $dateDay[0] . "/" . $datePayment[1] . "/" . $datePayment[0];
                }

                if ($payment['payment_date_end']) {
                    $datePaymentEnd = explode("-", $payment['payment_date_end']);
                    $dateDay = explode(" ", $datePaymentEnd[2]);
                    $datePaymentEnd = $dateDay[0] . "/" . $datePaymentEnd[1] . "/" . $datePaymentEnd[0];
                }

                $paymentsError[] = array(
                    "payment_date_start" => $datePayment,
                    "payment_date_end" => $datePaymentEnd,
                    "full_price" => $payment['full_price'],
                    "children_price" => $payment['children_price'],
                    "middle_price" => $payment['middle_price'],
                    "payment_portions" => $payment['payment_portions'],
                    "associated_discount" => $payment['associated_discount'],
                );
            }

            if ($date_start) {
                $date = explode("-", $date_start);
                $dateDay = explode(" ", $date[2]);
                $date = $date[1] . "/" . $dateDay[0] . "/" . $date[0];
                $date_start = $date;
            }

            if ($date_finish) {
                $date = explode("-", $date_finish);
                $dateDay = explode(" ", $date[2]);
                $date = $date[1] . "/" . $dateDay[0] . "/" . $date[0];
                $date_finish = $date;
            }

            if ($date_start_show) {
                $date = explode("-", $date_start_show);
                $dateDay = explode(" ", $date[2]);
                $date = $date[1] . "/" . $dateDay[0] . "/" . $date[0];
                $date_start_show = $date;
            }

            if ($date_finish_show) {
                $date = explode("-", $date_finish_show);
                $dateDay = explode(" ", $date[2]);
                $date = $date[1] . "/" . $dateDay[0] . "/" . $date[0];
                $date_finish_show = $date;
            }

            if ($error != "") {
                $errors[] = $error;
            }

            foreach ($errors as $e) {
                $this->Logger->info("Error: " . $e);
            }

            return $this->eventCreate($errors, $event_name, $description, $date_start, $date_finish, $date_start_show, $date_finish_show, $capacity_male, $capacity_female, $capacity_nonsleeper, $paymentsError, $type);
        }


        try {
            $this->Logger->info("Inserting new event");
            $this->generic_model->startTransaction();

            $eventId = $this->event_model->insertNewEvent($event_name, $description, $date_start, $date_finish, $date_start_show, $date_finish_show, $enabled, $capacity_male, $capacity_female, $capacity_nonsleeper, $type);

            if ($eventId) {
                foreach ($payments as $payment) {
                    $this->event_model->insertNewPaymentPeriod($eventId, $payment["payment_date_start"], $payment["payment_date_end"], $payment["full_price"], $payment["middle_price"], $payment["children_price"], $payment["associated_discount"], $payment["payment_portions"]);
                }

                $this->generic_model->commitTransaction();
                $this->Logger->info("New event successfully inserted");
                return $this->manageEvents('Evento criado com sucesso!');
            } else
                return $this->manageEvents('Ocorreu um erro ao criar o evento. Tente novamente.');
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new event");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;

            $this->loadReportView('admin/events/event_create', $data);
        }
    }

    public function finance_admin() {
        $this->loadView("admin/finances/finance_admin_container");
    }

    public function createDocument($errors = array(), $name = NULL, $date = NULL, $description = NULL, $value = NULL, $number = NULL) {
        $selected_option = $this->input->post("document_type", TRUE);
        $userId = $this->session->userdata("user_id");
        $user = $this->person_model->getPersonById($userId);
        if (empty($selected_option) || !isset($selected_option))
            $data['selected'] = "no_select";
        else
            $data['selected'] = $selected_option;
        $data['errors'] = $errors;
        $data['name'] = $name;
        $data['date'] = $date;
        $data['description'] = $description;
        $data['value'] = $value;
        $data['number'] = $number;
        $data['user_name'] = $user->fullname;
        $this->loadReportView("admin/finances/createDocument", $data);
    }

    public function completeDocument() {
        $name = $this->input->post("document_name", TRUE);
        $date = $this->input->post("document_date", TRUE);
        $number = $this->input->post("document_number", TRUE);
        $description = $this->input->post("description", TRUE);
        $type = $this->input->post("document_type", TRUE);
        $value = $this->input->post("document_value", TRUE);
        $operation = "create";
        $fileName = $_FILES['uploadedfile']['name'];
        if (isset($_FILES['uploadedfile']['tmp_name']) && !empty($_FILES['uploadedfile']['tmp_name'])) {
            $file = file_get_contents($_FILES['uploadedfile']['tmp_name']);
        }
        $errors = array();
        if (empty($description) || !isset($description)) {
            $errors[] = 'Campo descrição é de preenchimento obrigatório.\n';
        }
        if (count($errors) > 0) {
            return $this->createDocument($errors, $name, $date, $description, $value, $number);
        }
        $userId = $this->session->userdata("user_id");
        $value = str_replace(",", ".", $value);
        $date = explode("/", $date);
        $db_date = implode("-", array_reverse($date));
        try {
            $this->generic_model->startTransaction();
            $documentId = $this->documentexpense_model->InsertNewDocument($db_date, $number, $description, $type, $value, $name);
            if ($fileName) {
                $uploadId = $this->documentexpense_model->uploadDocument($fileName, $file, $operation);
                if ($_FILES['uploadedfile'] ['error'] > 0 || !$uploadId) {
                    echo "<script>alert('Erro ao enviar documento, verifique se ele se adequa as regras de envio e tente novamente. Lembramos que somente aceitamos arquivos até 2MB.');
            window.location.replace('" . $this->config->item('url_link') . "admin/finances/manageDocuments');</script>";
                }
                $new_id = $this->documentexpense_model->getNewUpload();
                $result = $this->documentexpense_model->attatchUploadId($documentId, $new_id);
            }

            $logId = $this->documentexpense_model->InsertDocumentLog($userId, $documentId, $db_date, $value, "criacao");
            if ($type === "boleto") {
                $this->documentexpense_model->insertNewPostingExpense($documentId, $db_date, $value, "Boleto", 1);
                $this->documentexpense_model->switchPaidStatusOffToOn($documentId, 1);
            }
            $this->generic_model->commitTransaction();
            $this->Logger->info("New document successfully inserted");
            $url = $this->config->item('url_link');
            if ($documentId) {
                echo "<SCRIPT LANGUAGE='JavaScript'>
           		window.alert('Documento criado com sucesso')
            	window.location.href='" . $url . "admin/manageDocuments'</SCRIPT>";
            } else
                echo "<SCRIPT LANGUAGE='JavaScript'>
          			window.alert('Ocorreu um erro ao criar o documento. Tente novamente mais tarde')
           			 window.location.href='" . $url . "admin/createDocument'</SCRIPT>";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new document");
            $this->generic_model->rollbackTransaction();
            $data['selected'] = "no_select";
            $this->loadReportView('admin/finances/createDocument', $data);
        }
    }

    public function editDocument($document_id = NULL, $errors = array()) {
        $document = $this->documentexpense_model->getDocumentById($document_id);
        $date = $document->getDocumentExpenseDate();
        $number = $document->getDocumentExpenseNumber();
        $description = $document->getDocumentExpenseDescription();
        $value = $document->getDocumentExpenseValue();
        $type = $document->getDocumentExpenseType();
        $name = $document->getDocumentExpenseName();
        $date = explode("-", $date);
        $date = implode("/", array_reverse($date));
        $upload = $this->documentexpense_model->getUploadId($document_id);
        $creator = $this->documentexpense_model->getDocumentCreationLog($document_id);
        if ($creator) {
            $creatorId = $this->person_model->getPersonById($creator);
            $data['creator'] = $creatorId->fullname;
        } else {
            $data['creator'] = FALSE;
        }
        $lastEdit = $this->documentexpense_model->getDocumentEditLog($document_id);
        if ($lastEdit) {
            $lastEditId = $this->person_model->getPersonById($lastEdit);
            $data['lastEdit'] = $lastEditId->fullname;
        } else {
            $data['lastEdit'] = FALSE;
        }
        $data['id'] = $document_id;
        $data['date'] = $date;
        $data['number'] = $number;
        $data['description'] = $description;
        $data['value'] = $value;
        $data['type'] = $type;
        $data['name'] = $name;
        $data['errors'] = $errors;
        $data['upload_id'] = $upload->document_expense_upload_id;
        $data['paid'] = $this->documentexpense_model->getPaymentStatus($document_id);
        $this->loadReportView("admin/finances/editDocument", $data);
    }

    public function viewDocument($document_id = NULL, $errors = array()) {
        $document = $this->documentexpense_model->getDocumentById($document_id);
        $date = $document->getDocumentExpenseDate();
        $number = $document->getDocumentExpenseNumber();
        $description = $document->getDocumentExpenseDescription();
        $value = $document->getDocumentExpenseValue();
        $type = $document->getDocumentExpenseType();
        $name = $document->getDocumentExpenseName();
        $date = explode("-", $date);
        $date = implode("/", array_reverse($date));
        $upload = $this->documentexpense_model->getUploadId($document_id);
        $data['id'] = $document_id;
        $data['date'] = $date;
        $data['number'] = $number;
        $data['description'] = $description;
        $data['value'] = $value;
        $data['type'] = $type;
        $data['name'] = $name;
        $data['errors'] = $errors;
        $data['upload_id'] = $upload->document_expense_upload_id;
        $this->loadReportView("admin/finances/viewDocument", $data);
    }

    public function updateDocument($document_id = NULL) {
        $name = $this->input->post("document_name", TRUE);
        $date = $this->input->post("document_date", TRUE);
        $number = $this->input->post("document_number", TRUE);
        $description = $this->input->post("description", TRUE);
        $type = $this->input->post("document_type", TRUE);
        $value = $this->input->post("document_value", TRUE);
        $errors = array();
        $userId = $this->session->userdata("user_id");
        $operation = "create";
        $fileName = $_FILES['uploadedfile']['name'];
        if (isset($_FILES['uploadedfile']['tmp_name']) && !empty($_FILES['uploadedfile']['tmp_name'])) {
            $file = file_get_contents($_FILES['uploadedfile']['tmp_name']);
        }
        $errors = array();
        if (empty($description) || !isset($description)) {
            $errors[] = 'Campo descrição é de preenchimento obrigatório.\n';
        }
        if (count($errors) > 0) {
            return $this->editDocument($document_id, $errors);
        }
        $value = str_replace(",", ".", $value);
        $date = explode("/", $date);
        $db_date = implode("-", array_reverse($date));
        $upload = $this->documentexpense_model->getUploadId($document_id);
        try {
            $this->generic_model->startTransaction();
            $documentId = $this->documentexpense_model->updateDocument($document_id, $db_date, $number, $description, $value, $name);
            if (!empty($file) && isset($file)) {
                if ($upload->document_expense_upload_id > 0) {
                    $uploadId = $this->documentexpense_model->updateUploadDocument($upload->document_expense_upload_id, $fileName, $file, $operation);
                } else {
                    $uploadId = $this->documentexpense_model->uploadDocument($fileName, $file, $operation);
                    $new_id = $this->documentexpense_model->getNewUpload();
                    $result = $this->documentexpense_model->attatchUploadId($document_id, $new_id);
                }
            }
            $logId = $this->documentexpense_model->InsertDocumentLog($userId, $document_id, $db_date, $value, "edicao");
            $this->generic_model->commitTransaction();
            $this->Logger->info("Document successfully updated");
            $url = $this->config->item('url_link') . "admin/manageDocuments";
            if ($documentId) {
                echo "<SCRIPT LANGUAGE='JavaScript'>
                     window.alert('Documento alterado com sucesso')
                     window.location.href='" . $url . "'</SCRIPT>";
            } else
                echo "<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('Ocorreu um erro ao alterar o documento. Tente novamente mais tarde')
                    window.location.href='" . $url . "'</SCRIPT>";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to update document" . $document_id);
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            $this->loadReportView('admin/finances/editDocument', $data);
        }
    }

    public function deleteDocument($document_id = NULL) {
        try {
            $url = $this->config->item('url_link') . "admin/manageDocuments";
            if ($document_id) {
                $this->generic_model->startTransaction();
                $this->documentexpense_model->deleteAllExpenses($document_id);
                $upload_id = $this->documentexpense_model->getUploadId($document_id);
                $id = $upload_id->document_expense_upload_id;
                $this->documentexpense_model->deleteDocument($document_id);
                $this->documentexpense_model->deleteUpload($id);
                $this->generic_model->commitTransaction();
                echo "<SCRIPT LANGUAGE='JavaScript'>
                     window.alert('Documento excluído com sucesso')
                     window.location.href='" . $url . "'</SCRIPT>";
            } else {
                echo "<SCRIPT LANGUAGE='JavaScript'>
                     window.alert('Ocorreu um erro ao excluir o documento. Tente novamente mais tarde')
                     window.location.href='" . $url . "'</SCRIPT>";
            }
        } catch (Exception $ex) {
            $this->Logger->error("Failed to delete document" . $document_id);
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            $this->loadReportView('admin/finances/editDocument', $data);
        }
    }

    public function postingExpense() {

        $this->Logger->info("Running: " . __METHOD__);
        $documentexpenseId = $_POST['documentexpenseId'];
        $postingValue = $_POST['postingValue'];
        $postingType = $_POST['postingType'];
        $status = $_POST['status'];
        
        if($status == 'edit'){
        	$oldPostingType = $this -> finance_model -> getPostingTypeByDocumentId($documentexpenseId);
        	
        		if($oldPostingType -> posting_type == "Boleto"){
        			if(!$this-> finance_model -> deleteBankSlips($documentexpenseId)){
        				echo "false";
        				return;
        			}
        		}else if($oldPostingType -> posting_type == "Transferência"){
        			if(!$this-> finance_model -> deleteBankTransfers($documentexpenseId)){
        				echo "false";
        				return;
        			}
        		}else if($oldPostingType -> posting_type == "Cheque"){
        			if(!$this-> finance_model -> deleteBankChecks($documentexpenseId)){
        				echo "false";
        				return;
        			}
        		} 
        		
        	if(!$this -> finance_model -> deletePostingExpenses($documentexpenseId)){
        		echo "false";
        		return;
        	}
        }
        
        if ($postingType == "Dinheiro") {
        	$payment_type = $_POST['payment_type'];
            $postingPortion = 1;
            $postingDate = $_POST['postingDate'];
            
            if($postingDate){
	            $postingDatePortion = explode("/", $postingDate);
	            $dia = $postingDatePortion[0];
	            $mês = $postingDatePortion[1];
	            $ano = $postingDatePortion[2];
	            $postingDate = $ano."-".$mês."-".$dia;
            }else {
            	$postingDate = null;
            }
            
            $result = $this->documentexpense_model->insertNewPostingExpense($documentexpenseId, $postingDate, $postingValue, $postingType, $postingPortion, $payment_type,$status);
                        
            if($result) {
            	echo "true";
	            return;
            } else {
                echo "false";
                return;
            }
        } else if ($postingType == "Crédito") {
            $paymentStatus = "a pagar";
            $portions = $_POST['portions'];
            $postingDate = $_POST['postingDate'];
            $meses = 1;
            $postingValue = $postingValue / $portions;
            $postingDatePortion = explode("/", $postingDate);
            $dia = $postingDatePortion[0];
            $mês = $postingDatePortion[1];
            $ano = $postingDatePortion[2];
            for ($i = 0; $i < $portions; $i++) {
                $postingPortion = $i + 1;
                $postingDate = date("Y-m-d", mktime(0, 0, 0, $mês + $i, $dia, $ano));
                
               $result = $this->documentexpense_model->insertNewPostingExpense($documentexpenseId, $postingDate, $postingValue, $postingType, $postingPortion, $paymentStatus,$status);               
            }
            if ($result != null) {
            	echo "true";
	            return;
            } else {
                echo "false";
                return;
            }                
        } else if ($postingType == "Cheque") {
            $numberCheque = $_POST['numberCheque'];
            $postingPortion = 1;
            $paymentStatus = "a pagar";
            
            $result = $this->documentexpense_model->insertNewPostingExpense($documentexpenseId, null, $postingValue, $postingType, $postingPortion, $paymentStatus,$status);
                        
            if ($result) {
                
                if ($this->documentexpense_model->inserNewBankCheckPayment($numberCheque, $documentexpenseId, $postingPortion)) {
	                echo "true";
		            return;
                } else {
                    echo "false";
                    return;
                }
            }else {
                    echo "false";
                    return;
            }
        } else if ($postingType == "Transferência") {
            $postingPortion = 1;
            $paymentStatus = "a pagar";
            
            $result = $this->documentexpense_model->insertNewPostingExpense($documentexpenseId, null, $postingValue, $postingType, $postingPortion, $paymentStatus,$status);
                        
            if ($result) {
                $bankNumber = $_POST['bankNumber'];
                $bankAgency = $_POST['bankAgency'];
                $accountNumber = $_POST['accountNumber'];
                $bankDataId = $this->documentexpense_model->insertNewBankData($bankNumber, $bankAgency, $accountNumber); //$_POST['bank_data_id'];
                
                if ($this->documentexpense_model->insertNewBankTransferPayment($bankDataId, $documentexpenseId, $postingPortion)) {
	                echo "true";
		            return;
                } else {
                    echo "false";
                    return;
                }
            }else {
                    echo "false";
                    return;
             }
        } else if ($postingType == "Boleto") {
            $portions = $_POST['portions'];
            $postingDate = $_POST['postingDate'];
            $paymentStatus = "a pagar";
            $j = 0;
            $k = 0;
            $postingValuePortion = explode("/", $postingValue);
            $this->Logger->info("DATAS: ".$postingDate);
            $postingDatePortion = explode("/", $postingDate);
            for ($i = 1; $i <= $portions; $i++) {
                $postingPortion = $i;
                $postingValue = $postingValuePortion[$k];
                $dia = $postingDatePortion[$j];
                $mês = $postingDatePortion[$j+1];
                $ano = $postingDatePortion[$j+2];
                $postingDate = $ano."-".$mês."-".$dia;
                
                if($this->documentexpense_model->insertNewPostingExpense($documentexpenseId, $postingDate, $postingValue, $postingType, $postingPortion, $paymentStatus,$status)){
                   $result = $this->documentexpense_model->insertNewBankSlip($postingDate, $documentexpenseId, $postingPortion);
                }
                
                $j=$j+3;
                $k++;
            }
            if ($result != null) {
	            echo "true";
	            return;
            } else {
                echo "false";
                return;
            }
        }
    }

    public function togglePostingExpensePayed($documentId_portions, $day, $month, $year) {

        $r = explode("_", $documentId_portions);
        $documentId = $r[0];
        $posting_portions = $r[1];

        if ($day != null) {
            $posting_date = $year . "-" . $month . "-" . $day;
        } else {
            $posting_date = "";
        }

        $document = $this->finance_model->getPostingExpenseById($documentId, $posting_portions);

        echo $this->finance_model->togglePostingExpensePayed($documentId, $posting_portions, $posting_date);
    }

    public function manageDocuments($date = NULL) {
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

        if ($month == null) {
            $month = date("m");
        } else if ($month == 0) {
            $month = FALSE;
        }
        $data["year"] = $year;
        $data["month"] = $month;
        $data["years"] = $years;
        $data["option"] = $option;

        $documents = $this->finance_model->getDocumentsByDate($year, $month);
        $info = array();
        $boleto = array();
        $posting_portions_credito = array();
        $payment_status = array();
        
        if($documents){        
	        foreach($documents as $d){
	        	$obj = new StdClass();
	        	$obj = $d;
	        	if($d->posting_date){
		        	$postingDate = explode("-",$d->posting_date);
		        	$obj -> posting_date = $postingDate[2]."/".$postingDate[1]."/".$postingDate[0];
	        	}
	        	
	        	if($d->posting_type == 'Crédito'){
	        		$max = $this-> finance_model -> getMaxPostingPortionByDocumentId($d->document_expense_id);
	        		$posting_portions_credito[$d->document_expense_id] = $max;
	        	}
	        	
	        	if(isset($payment_status[$d->document_expense_id])){
	        		if(!($payment_status[$d->document_expense_id] == ("pago" || "caixinha" || "deb auto"))){
	        			$payment_status[$d->document_expense_id] = $d->payment_status;
	        		}
	        	}else {
	        		$payment_status[$d->document_expense_id] = $d->payment_status;
	        	}
	        	
	        	if($d->posting_type == 'Boleto'){
	        		$bol = $this -> finance_model -> getPostingExpenseByDocumentId($d->document_expense_id);
	        		$objd = new StdClass();
	        		$objd->posting_date = "";
	        		$objd -> posting_value = "";
	        		
	        		foreach($bol as $b){
		        		$bankSlipDate = explode("-",$b -> bank_slip_date);
		        		$objd->posting_date = $objd->posting_date.$bankSlipDate[2]."/".$bankSlipDate[1]."/".$bankSlipDate[0]."-";
		        		$objd -> posting_value = $objd -> posting_value.$b->posting_value."-";
	        		}
	        		
	        		$boleto[$d->document_expense_id] = $objd;
	        		
	        	}
	        	$info[] = $obj;
	        }
        }
        
        $data['payment_status'] = $payment_status;
        $data['date'] = $date;
        $data['documents'] = $info;
        $data['boleto'] = $boleto;
        $data['posting_portions_credito'] = $posting_portions_credito;

        $this->loadReportView("admin/finances/manage_documents", $data);
    }

    public function updateAccountName() {
        $id = $this->input->post("id", TRUE);
        $portions = $this->input->post("portions", TRUE);
        $account_name = $this->input->post("account_name", TRUE);

        if ($this->finance_model->updateAccountName($id, $portions, $account_name)) {
            echo "true";
            return;
        } else {
            echo "false";
            return;
        }
    }

    public function finance_cashoutflows() {
        $this->loadView("finances/finance_cashoutflows_container");
    }

    public function eventCreate($errors = array(), $event_name = NULL, $description = NULL, $date_start = NULL, $date_finish = NULL, $date_start_show = NULL, $date_finish_show = NULL, $capacity_male = NULL, $capacity_female = NULL, $capacity_nonsleeper = NULL, $payments = array(), $type = null) {
        $this->Logger->info("Starting " . __METHOD__);
        $data = array();
        $data["errors"] = $errors;
        $data["event_name"] = $event_name;
        $data["description"] = $description;
        $data["date_start"] = Events::toMMDDYYYY($date_start);
        $data["date_finish"] = Events::toMMDDYYYY($date_finish);
        $data["date_start_show"] = Events::toMMDDYYYY($date_start_show);
        $data["date_finish_show"] = Events::toMMDDYYYY($date_finish_show);
        $data["capacity_male"] = $capacity_male;
        $data["capacity_female"] = $capacity_female;
        $data["capacity_nonsleeper"] = $capacity_nonsleeper;
        $data["type"] = $type;
        $data["payments"] = $payments;

        foreach ($errors as $e) {
            $this->Logger->info("Error: " . $e);
        }

        $this->loadReportView('admin/events/event_create', $data);
    }

    public function editEvent($event_id = NULL, $errors = array(), $event_name = NULL, $description = NULL, $date_start = NULL, $date_finish = NULL, $date_start_show = NULL, $date_finish_show = NULL, $capacity_male = NULL, $capacity_female = NULL, $capacity_nonsleeper = NULL, $payments = array(), $type = NULL) {
        $eventId = $event_id;

        $event = $this->event_model->getEventById($eventId);
        $paymentPeriods = $this->event_model->getEventPaymentPeriods($eventId);
        $token = $this->event_model->getEventTokenById($eventId);

        if ($token)
            $data['token'] = $token->token;
        else
            $data['token'] = null;

        $data['event_id'] = $eventId;
        $data['event_name'] = $event->getEventName();
        $data['description'] = $event->getDescription();
        $data["errors"] = $errors;

        $date = explode("-", $event->getDateStart());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_start'] = $date;

        $date = explode("-", $event->getDateFinish());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_finish'] = $date;

        $date = explode("-", $event->getDateStartShow());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_start_show'] = $date;

        $date = explode("-", $event->getDateFinishShow());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_finish_show'] = $date;

        $data['enabled'] = $event->isEnabled();
        $data['type'] = $event->getType();
        $data['capacity_male'] = $event->getCapacityMale();
        $this->Logger->info("Capacity Male: " . $event->getCapacityMale());
        $data['capacity_female'] = $event->getCapacityFemale();
        $this->Logger->info("Capacity Female: " . $event->getCapacityFemale());
        $data['capacity_nonsleeper'] = $event->getCapacityNonSleeper();
        $this->Logger->info("Capacity nonsleeper: " . $event->getCapacityNonSleeper());
        $data['male_eventSubscribed'] = count($this->eventsubscription_model->getSubscriptionsByEventId($eventId, "capacity_male", 'ocupados'));
        $this->Logger->info("male eventSubscribed: " . count($this->eventsubscription_model->getSubscriptionsByEventId($eventId, "capacity_male", 'ocupados')));
        $data['female_eventSubscribed'] = count($this->eventsubscription_model->getSubscriptionsByEventId($eventId, "capacity_female", 'ocupados'));
        $this->Logger->info("female eventSubscribed: " . count($this->eventsubscription_model->getSubscriptionsByEventId($eventId, "capacity_female", 'ocupados')));
        $data['nonsleeper_eventSubscribed'] = count($this->eventsubscription_model->getSubscriptionsByEventId($eventId, "nonsleeper", 'ocupados'));
        $this->Logger->info("nonsleeper eventSubscribed: " . count($this->eventsubscription_model->getSubscriptionsByEventId($eventId, "nonsleeper", 'ocupados')));
        $data['male_paid'] = count($this->eventsubscription_model->getSubscriptionsByEventId($eventId, "capacity_male", 3));
        $data['female_paid'] = count($this->eventsubscription_model->getSubscriptionsByEventId($eventId, "capacity_female", 3));
        $data['nonsleeper_paid'] = count($this->eventsubscription_model->getSubscriptionsByEventId($eventId, "nonsleeper", 3));

        if ($payments == null) {
            foreach ($paymentPeriods as $payment) {
                $datePayment = explode("-", $payment->getDateStart());
                $dateDay = explode(" ", $datePayment[2]);
                $datePayment = $dateDay[0] . "/" . $datePayment[1] . "/" . $datePayment[0];
                $datePaymentEnd = explode("-", $payment->getDateFinish());
                $dateDay = explode(" ", $datePaymentEnd[2]);
                $datePaymentEnd = $dateDay[0] . "/" . $datePaymentEnd[1] . "/" . $datePaymentEnd[0];

                $payments[] = array(
                    "payment_date_start" => $datePayment,
                    "payment_date_end" => $datePaymentEnd,
                    "full_price" => $payment->getFullPrice(),
                    "children_price" => $payment->getChildrenPrice(),
                    "middle_price" => $payment->getMiddlePrice(),
                    "payment_portions" => $payment->getPortions(),
                    "associated_discount" => $payment->getAssociateDiscount(),
                );
            }
        }

        $data['payments'] = $payments;

        $this->loadReportView('admin/events/event_edit', $data);
    }

    public function updateEvent($event_id) {

        $this->Logger->info("Starting " . __METHOD__);

        $event_name = $this->input->post('event_name', TRUE);
        $description = $this->input->post('description', TRUE);
        $date_start = $this->input->post('date_start', TRUE);
        $date_finish = $this->input->post('date_finish', TRUE);
        $date_start_show = $this->input->post('date_start_show', TRUE);
        $date_finish_show = $this->input->post('date_finish_show', TRUE);
        $capacity_male = $this->input->post('capacity_male', TRUE);
        $capacity_female = $this->input->post('capacity_female', TRUE);
        $capacity_nonsleeper = $this->input->post('capacity_nonsleeper', TRUE);
        $payments = array();
        $payment_date_end = $this->input->post("payment_date_end", TRUE);
        $payment_date_start = $this->input->post("payment_date_start", TRUE);
        $full_price = $this->input->post("full_price", TRUE);
        $children_price = $this->input->post("children_price", TRUE);
        $middle_price = $this->input->post("middle_price", TRUE);
        $payment_portions = $this->input->post("payment_portions", TRUE);
        $associated_discount = $this->input->post("associated_discount", TRUE);
        $enabled = $this->input->post("enabled", TRUE);
        $error = $this->input->post("error", TRUE);
        $type = $this->input->post("type", TRUE);
        $errors = array();


        if ($event_name === "")
            $errors[] = "O campo nome é obrigatório\n";
        if (!$date_start)
            $date_start = NULL;
        if (!$date_start_show)
            $date_start_show = NULL;
        if (!$date_finish)
            $date_finish = NULL;
        if (!$date_finish_show)
            $date_finish_show = NULL;
        if (!$enabled)
            $enabled = "false";
        else if ($enabled === "1")
            $enabled = "true";

        if ($date_start && $date_finish && !Events::verifyAntecedence($date_start, $date_finish))
            $errors[] = "A data do ínicio do período do evento antecede a data de fim do evento\\n";

        if ($date_start_show && $date_finish_show && !Events::verifyAntecedence($date_start_show, $date_finish_show))
            $errors[] = "A data do ínicio do período de inscrições antecede a data de fim do periodo de inscrições\\n";

        if ($date_start_show && $date_finish_show && !Events::verifyAntecedence($date_finish_show, $date_finish))
        	$errors[] = "A data de fim do evento antecede a data do fim do período de inscrições\\n";
        
        if ($capacity_male === "")
            $capacity_male = 0;
        if ($capacity_female === "")
            $capacity_female = 0;
        if ($capacity_nonsleeper === "")
            $capacity_nonsleeper = 0;

        if (is_array($full_price)) {
            for ($i = 0; $i < count($full_price); $i++) {
                if (!$payment_date_start[$i])
                    $errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem data de inicio\\n";
                if (!$payment_date_end[$i])
                    $errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem data de fim\\n";
                if (!$full_price[$i])
                    $errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem valor\\n";
                if (!$middle_price[$i])
                    $middle_price[$i] = 0;
                if (!$children_price[$i])
                    $children_price[$i] = 0;
                if ($payment_date_start[$i] && $payment_date_end[$i] && !Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$i])) {
                    $errors[] = "O pagamento de numero " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
                }
                if ($payment_date_start[$i] && $payment_date_end[$i] && (
                        !Events::verifyAntecedence($payment_date_start[$i], $date_finish_show) ||
                        !Events::verifyAntecedence($payment_date_end[$i], $date_finish_show) ||
                        !Events::verifyAntecedence($date_start_show, $payment_date_start[$i]) )
                )
                    $errors[] = "O pagamento de numero " . ($i + 1) . " está fora do periodo de inscrições\\n";
                for ($j = $i + 1; $j < count($full_price); $j++) {
                    if
                    (
                            (
                            Events::verifyAntecedence($payment_date_start[$i], $payment_date_start[$j]) && Events::verifyAntecedence($payment_date_start[$j], $payment_date_end[$i])
                            ) ||
                            (
                            Events::verifyAntecedence($payment_date_start[$j], $payment_date_start[$i]) && Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$j])
                            )
                    )
                        $errors[] = "Os pagamentos de numero" . ($i + 1) . " e " . ($j + 1) . " se sobrepoem\\n";
                }

                if ($payment_date_start[$i]) {

                    $payment_date_start[$i] = explode("/", $payment_date_start[$i]);
                    $payment_date_start[$i] = strval($payment_date_start[$i][2]) . "-" . strval($payment_date_start[$i][1]) . "-" . strval($payment_date_start[$i][0]);
                }

                if ($payment_date_end[$i]) {
                    $payment_date_end[$i] = explode("/", $payment_date_end[$i]);
                    $payment_date_end[$i] = strval($payment_date_end[$i][2]) . "-" . strval($payment_date_end[$i][1]) . "-" . strval($payment_date_end[$i][0] . " 23:59:59");
                }

                $payments[] = array(
                    "payment_date_start" => $payment_date_start[$i],
                    "payment_date_end" => $payment_date_end[$i],
                    "full_price" => $full_price[$i],
                    "children_price" => $children_price[$i],
                    "middle_price" => $middle_price[$i],
                    "payment_portions" => $payment_portions[$i],
                    "associated_discount" => $associated_discount[$i] / 100,
                );
            }
        } else if ($full_price !== FALSE) {
            if (!$payment_date_start)
                $errors[] = "O pagamento não tem data de inicio\\n";
            if (!$payment_date_end)
                $errors[] = "O pagamento não tem data de fim\\n";
            if (!$full_price)
                $errors[] = "O pagamento não tem valor\\n";
            if (!$middle_price)
                $middle_price = 0;
            if (!$children_price)
                $children_price = 0;
            if ($payment_date_start[$i] && $payment_date_end[$i] && !Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$i])) {
                $errors[] = "O pagamento de numero " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
            }

            for ($i = 0; $i < count($full_price); $i++) {

                if ($payment_date_start[$i]) {
                    $payment_date_start[$i] = explode("/", $payment_date_start[$i]);
                    $payment_date_start[$i] = strval($payment_date_start[$i][2]) . "-" . strval($payment_date_start[$i][1]) . "-" . strval($payment_date_start[$i][0]);
                }

                if ($payment_date_end[$i]) {
                    $payment_date_end[$i] = explode("/", $payment_date_end[$i]);
                    $payment_date_end[$i] = strval($payment_date_end[$i][2]) . "-" . strval($payment_date_end[$i][1]) . "-" . strval($payment_date_end[$i][0] . " 23:59:59");
                }
            }

            $payments[] = array(
                "payment_date_start" => $payment_date_start,
                "payment_date_end" => $payment_date_end,
                "full_price" => $full_price,
                "children_price" => $children_price,
                "middle_price" => $middle_price,
                "payment_portions" => $payment_portions,
                "associated_discount" => $associated_discount / 100,
            );
        }

        if ($date_start) {
            $date_start = explode("/", $date_start);
            $date_start = strval($date_start[2]) . "-" . strval($date_start[1]) . "-" . strval($date_start[0]);
        }

        if ($date_finish) {
            $date_finish = explode("/", $date_finish);
            $date_finish = strval($date_finish[2]) . "-" . strval($date_finish[1]) . "-" . strval($date_finish[0] . " 23:59:59");
        }

        if ($date_start_show) {
            $date_start_show = explode("/", $date_start_show);
            $date_start_show = strval($date_start_show[2]) . "-" . strval($date_start_show[1]) . "-" . strval($date_start_show[0]);
        }

        if ($date_finish_show) {
            $date_finish_show = explode("/", $date_finish_show);
            $date_finish_show = strval($date_finish_show[2]) . "-" . strval($date_finish_show[1]) . "-" . strval($date_finish_show[0] . " 23:59:59");
        }

        $events = $this->event_model->getAllEvents();

        foreach ($events as $event) {

            if ($event->getEventId() != $event_id && $date_start && $date_finish && ((Events::verifyAntecedence($event->getDateStart(), $date_start) && Events::verifyAntecedence($date_start, $event->getDateFinish())) || (Events::verifyAntecedence($event->getDateStart(), $date_finish) && Events::verifyAntecedence($date_finish, $event->getDateFinish())))) {
                $errors[] = "Há um evento nesse período\\n";
                break;
            }
        }

        if (count($errors) > 0 || $error != "") {

            $paymentsError = array();

            foreach ($payments as $payment) {

                $datePayment = null;
                $datePaymentEnd = null;

                if ($payment['payment_date_start']) {
                    $datePayment = explode("-", $payment['payment_date_start']);
                    $dateDay = explode(" ", $datePayment[2]);
                    $datePayment = $dateDay[0] . "/" . $datePayment[1] . "/" . $datePayment[0];
                }

                if ($payment['payment_date_end']) {
                    $datePaymentEnd = explode("-", $payment['payment_date_end']);
                    $dateDay = explode(" ", $datePaymentEnd[2]);
                    $datePaymentEnd = $dateDay[0] . "/" . $datePaymentEnd[1] . "/" . $datePaymentEnd[0];
                }

                $paymentsError[] = array(
                    "payment_date_start" => $datePayment,
                    "payment_date_end" => $datePaymentEnd,
                    "full_price" => $payment['full_price'],
                    "children_price" => $payment['children_price'],
                    "middle_price" => $payment['middle_price'],
                    "payment_portions" => $payment['payment_portions'],
                    "associated_discount" => $payment['associated_discount'],
                );
            }

            if ($date_start) {
                $date = explode("-", $date_start);
                $dateDay = explode(" ", $date[2]);
                $date = $date[1] . "/" . $dateDay[0] . "/" . $date[0];
                $date_start = $date;
            }

            if ($date_finish) {
                $date = explode("-", $date_finish);
                $dateDay = explode(" ", $date[2]);
                $date = $date[1] . "/" . $dateDay[0] . "/" . $date[0];
                $date_finish = $date;
            }

            if ($date_start_show) {
                $date = explode("-", $date_start_show);
                $dateDay = explode(" ", $date[2]);
                $date = $date[1] . "/" . $dateDay[0] . "/" . $date[0];
                $date_start_show = $date;
            }

            if ($date_finish_show) {
                $date = explode("-", $date_finish_show);
                $dateDay = explode(" ", $date[2]);
                $date = $date[1] . "/" . $dateDay[0] . "/" . $date[0];
                $date_finish_show = $date;
            }

            if ($error != "") {
                $errors[] = $error;
            }

            foreach ($errors as $e) {
                $this->Logger->info("Error: " . $e);
            }

            return $this->editEvent($event_id, $errors, $event_name, $description, $date_start, $date_finish, $date_start_show, $date_finish_show, $capacity_male, $capacity_female, $capacity_nonsleeper, $paymentsError, $type);
        }

        try {
            $this->Logger->info("Updating event " . $event_name);
            $this->generic_model->startTransaction();

            $eventId = $this->event_model->updateEvent($event_id, $event_name, $description, $date_start, $date_finish, $date_start_show, $date_finish_show, $enabled, $capacity_male, $capacity_female, $capacity_nonsleeper, $type);

            if ($eventId) {
                $this->event_model->deleteEventPaymentPeriods($event_id);

                foreach ($payments as $payment) {
                    $this->event_model->insertNewPaymentPeriod($event_id, $payment["payment_date_start"], $payment["payment_date_end"], $payment["full_price"], $payment["middle_price"], $payment["children_price"], $payment["associated_discount"], $payment["payment_portions"]);
                }

                $this->generic_model->commitTransaction();
                $this->Logger->info("New event successfully inserted");
                return $this->manageEvents('Evento atualizado com sucesso!');
//redirect("events/manageEvents");
            } else
                return $this->manageEvents('Ocorreu um erro ao atualizar o evento. Tente novamente.');
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new event");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;

            return $this->manageEvents('Ocorreu um erro ao atualizar o evento. Tente novamente.');

//$this->loadReportView('admin/events/event_edit', $data);
        }
    }

    private function rand_string($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = null;
        $size = strlen($chars);

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }

        return $str;
    }

    public function token_generate() {
        $this->Logger->info("TOKEN");
        $event_id = $this->input->post('event_id', TRUE);
        $type = $this->input->post('type', TRUE);

        $token = $this->rand_string(8);

        $events_token = $this->event_model->getAllEventsTokens();

        $same = 1;

        foreach ($events_token as $et) {
            while (strcmp($et->token, $token) == 0) {
                $token = $this->rand_string(8);
            }
        }

        try {
            $this->Logger->info("Updating token of event_id: " . $event_id);
            $this->generic_model->startTransaction();

            if ($type == "regenerate") {
                if ($this->event_model->deleteToken($event_id)) {
                    $result = $this->event_model->insertToken($event_id, $token);
                }
            } else if ($type == "generate") {
                $result = $this->event_model->insertToken($event_id, $token);
            }

            if ($result) {
                $this->generic_model->commitTransaction();
                $this->Logger->info("New token successfully inserted");
                echo true;
                return true;
            } else {
                echo false;
                return false;
            }
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new token");
            $this->generic_model->rollbackTransaction();
            echo false;

            return false;
        }
    }

    public function manageEvents($message = null) {
        $this->Logger->info("Starting " . __METHOD__);

        if (!$this->checkSession())
            redirect("login/index");

        if (!$this->checkPermition(array(COMMON_USER, SECRETARY, SYSTEM_ADMIN))) {
            $this->denyAcess(___METHOD___);
        }

        $events = $this->event_model->getAllEvents();
        $eventsToScreen = array();
        foreach ($events as $event) {
            $payments = $this->event_model->getEventPaymentPeriods($event->getEventId());
            $event->setIsValid($payments);
            $eventsToScreen[] = $event;
        }
        $data["events"] = $eventsToScreen;
        $data["message"] = $message;


        $this->loadReportView("admin/events/manage", $data);
    }

    public function camp() {
        $type = $this->input->get('type', TRUE);
        $data["validation"] = "";
        $data["discount"] = "";
        if ($type) {
            if ($type == "validation")
                $data["validation"] = "selected";
            else if ($type == "discount")
                $data["discount"] = "selected";
        } else
            $data["validation"] = "selected";
        $this->loadView("admin/camps/camp_admin_container", $data);
    }

    public function manageCamps($message = null) {
        $data['camps'] = $this->summercamp_model->getAllSummerCamps();
        $data['message'] = $message;
        $this->loadReportView("admin/camps/manage_camps", $data);
    }
    							
    public function createCamp($errors = array(), $camp_name = NULL, $date_start = NULL, $date_finish = NULL, $date_start_pre_associate = NULL, $date_finish_pre_associate = NULL, $date_start_pre = NULL, $date_finish_pre = NULL,  $capacity_male = NULL, $capacity_female = NULL, $payments = array(), $type = NULL, $schooling_description = NULL) {
        $data['payments'] = $payments;
        $data['errors'] = $errors;
        $data['camp_name'] = $camp_name;
        $data['date_start'] = $date_start;
        $data['date_finish'] = $date_finish;
        $data['date_start_pre_associate'] = $date_start_pre_associate;
        $data['date_finish_pre_associate'] = $date_finish_pre_associate;
        $data['date_start_pre'] = $date_start_pre;
        $data['date_finish_pre'] = $date_finish_pre;
        $data['capacity_male'] = $capacity_male;
        $data['capacity_female'] = $capacity_female;
        $data['schooling_description'] = $schooling_description;
        
        if($type == NULL)
        	$type = false;
        
        $data['mini_camp'] = $type;

        $this->loadReportView("admin/camps/insert_camp", $data);
    }

    public function editCamp($camp_id = NULL, $errors = array(),$payments = array()) {
        $campId = $camp_id;

        $camp = $this->summercamp_model->getSummerCampById($campId);
        $paymentPeriods = $this->summercamp_model->getSummerCampPaymentPeriods($campId);
        $data['camp_id'] = $campId;
        $data['camp_name'] = $camp->getCampName();
        $data['errors'] = $errors;


        $date = explode("-", $camp->getDateStart());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_start'] = $date;

        $date = explode("-", $camp->getDateFinish());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_finish'] = $date;

        $date = explode("-", $camp->getDateStartPreAssociate());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_start_pre_associate'] = $date;

        $date = explode("-", $camp->getDateFinishPreAssociate());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_finish_pre_associate'] = $date;

        $date = explode("-", $camp->getDateStartPre());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_start_pre'] = $date;

        $date = explode("-", $camp->getDateFinishPre());
        $dateDay = explode(" ", $date[2]);
        $date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        $data['date_finish_pre'] = $date;

        $data['schooling_description'] = $camp->getSchoolingDescription();


        $data['enabled'] = $camp->isEnabled();
        $data['capacity_male'] = $camp->getCapacityMale();
        $this->Logger->info("Capacity Male: " . $camp->getCapacityMale());
        $data['capacity_female'] = $camp->getCapacityFemale();
        $this->Logger->info("Capacity Female: " . $camp->getCapacityFemale());

        $paymentPeriods = $this->summercamp_model->getSummerCampPaymentPeriods($campId);
        $payments = array();

        if ($paymentPeriods) {
            foreach ($paymentPeriods as $payment) {
                $datePayment = explode("-", $payment->getDateStart());
                $dateDay = explode(" ", $datePayment[2]);
                $datePayment = $dateDay[0] . "/" . $datePayment[1] . "/" . $datePayment[0];
                $datePaymentEnd = explode("-", $payment->getDateFinish());
                $dateDay = explode(" ", $datePaymentEnd[2]);
                $datePaymentEnd = $dateDay[0] . "/" . $datePaymentEnd[1] . "/" . $datePaymentEnd[0];

                $payments[] = array(
                    "payment_date_start" => $datePayment,
                    "payment_date_end" => $datePaymentEnd,
                    "full_price" => $payment->getPrice(),
                    "payment_portions" => $payment->getPortions(),
                    "associated_price" => $payment->getAssociatedPrice(),
                );
            }
        }
                
        $data['mini_camp'] = $camp->isMiniCamp();

        $data['payments'] = $payments;
        $this->loadReportView('admin/camps/editCamp', $data);
    }

    public function updateCamp($camp_id) {

        $this->Logger->info("Starting " . __METHOD__);

        $camp_name = $this->input->post('camp_name', TRUE);

        $date_start = $this->input->post('date_start', TRUE);
        $date_finish = $this->input->post('date_finish', TRUE);
        $date_start_pre_associate = $this->input->post('date_start_pre_associate', TRUE);
        $date_finish_pre_associate = $this->input->post('date_finish_pre_associate', TRUE);
        $date_start_pre = $this->input->post('date_start_pre', TRUE);
        $date_finish_pre = $this->input->post('date_finish_pre', TRUE);
        $capacity_male = $this->input->post('capacity_male', TRUE);
        $capacity_female = $this->input->post('capacity_female', TRUE);
        $mini_camp = $this->input->post('mini_camp', TRUE);
        
        $schooling_description = $this->input->post('schooling_description', TRUE);

        $payments = array();
        $payment_date_end = $this->input->post("payment_date_end", TRUE);
        $payment_date_start = $this->input->post("payment_date_start", TRUE);
        $full_price = $this->input->post("full_price", TRUE);
        $payment_portions = $this->input->post("payment_portions", TRUE);
        $associated_price = $this->input->post("associated_price", TRUE);

        $error = $this->input->post("error", TRUE);

        $errors = array();


        if ($camp_name === ""){
            $errors[] = "O campo nome é obrigatório\n";
        }
        if (!$date_start){
            $date_start = NULL;
        }
        if (!$date_start_pre_associate){
            $date_start_pre_associate = NULL;
        }
        if (!$date_start_pre){
            $date_start_pre = NULL;
        }
        if (!$date_finish){
            $date_finish = NULL;
        }
        if (!$date_finish_pre_associate){
            $date_finish_pre_associate = NULL;
        }
        if (!$date_finish_pre){
            $date_finish_pre = NULL;
        }
        
        if ($date_start && $date_finish && !Events::verifyAntecedence($date_start, $date_finish)){
            $errors[] = "A data do ínicio do período do evento não antecede a data de fim do evento\\n";
        }
        if ($date_start_pre_associate && $date_finish_pre_associate && !Events::verifyAntecedence($date_start_pre_associate, $date_finish_pre_associate)){
            $errors[] = "A data do ínicio do período de inscrições para associados não antecede a data de fim do periodo de inscrições para associados\\n";
        }
        if ($date_start && $date_finish_pre_associate && Events::verifyAntecedence($date_start, $date_finish_pre_associate)){
            $errors[] = "A data do ínicio do período da colÃ´nia antecede a data de fim de inscrições para associados\\n";
        }
        if ($date_start && $date_finish_pre && Events::verifyAntecedence($date_start, $date_finish_pre)){
            $errors[] = "A data do ínicio do período da colÃ´nia antecede a data de fim de inscrições\\n";
        }

        if ($capacity_male === ""){
            $capacity_male = 0;
        }
        if ($capacity_female === ""){
            $capacity_female = 0;
        }

        if (is_array($full_price)) {
            for ($i = 0; $i < count($full_price); $i++) {
                if (!$payment_date_start[$i]){
                    $errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem data de inicio\\n";
                }
                if (!$payment_date_end[$i]){
                    $errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem data de fim\\n";
                }
                if (!$full_price[$i]){
                    $errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem valor\\n";
                }
                if (!$associated_price[$i]){
                	$errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem valor para sócio\\n";
                }
                if ($payment_date_start[$i] && $payment_date_end[$i] && !Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$i])) {
                    $errors[] = "O pagamento de numero " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
                }

                for ($j = $i + 1; $j < count($full_price); $j++) {
                    if
                    (
                            (
                            Events::verifyAntecedence($payment_date_start[$i], $payment_date_start[$j]) && Events::verifyAntecedence($payment_date_start[$j], $payment_date_end[$i])
                            ) ||
                            (
                            Events::verifyAntecedence($payment_date_start[$j], $payment_date_start[$i]) && Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$j])
                            )
                    )
                        $errors[] = "Os pagamentos de numero" . ($i + 1) . " e " . ($j + 1) . " se sobrepoem\\n";
                }

                if ($payment_date_start[$i]) {

                    $payment_date_start[$i] = explode("/", $payment_date_start[$i]);
                    $payment_date_start[$i] = strval($payment_date_start[$i][2]) . "-" . strval($payment_date_start[$i][1]) . "-" . strval($payment_date_start[$i][0]);
                }

                if ($payment_date_end[$i]) {
                    $payment_date_end[$i] = explode("/", $payment_date_end[$i]);
                    $payment_date_end[$i] = strval($payment_date_end[$i][2]) . "-" . strval($payment_date_end[$i][1]) . "-" . strval($payment_date_end[$i][0] . " 23:59:59");
                }
                
                $full_price[$i] = str_replace(",", ".", $full_price[$i]);
                $associated_price[$i] = str_replace(",", ".", $associated_price[$i]);

                $payments[] = array(
                    "payment_date_start" => $payment_date_start[$i],
                    "payment_date_end" => $payment_date_end[$i],
                    "full_price" => $full_price[$i],
                    "payment_portions" => $payment_portions[$i],
                    "associated_price" => $associated_price[$i],
                );
            }
        } else if ($full_price !== FALSE) {
            if (!$payment_date_start){
                $errors[] = "O pagamento não tem data de inicio\\n";
            }
            if (!$payment_date_end){
                $errors[] = "O pagamento não tem data de fim\\n";
            }
            if (!$full_price){
                $errors[] = "O pagamento não tem valor\\n";
            }
            if (!$associated_price){
            	$errors[] = "O pagamento não tem valor para sócio\\n";
            }
            if ($payment_date_start[$i] && $payment_date_end[$i] && !Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$i])) {
                $errors[] = "O pagamento de numero " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
            }

            for ($i = 0; $i < count($full_price); $i++) {

                if ($payment_date_start[$i]) {
                    $payment_date_start[$i] = explode("/", $payment_date_start[$i]);
                    $payment_date_start[$i] = strval($payment_date_start[$i][2]) . "-" . strval($payment_date_start[$i][1]) . "-" . strval($payment_date_start[$i][0]);
                }

                if ($payment_date_end[$i]) {
                    $payment_date_end[$i] = explode("/", $payment_date_end[$i]);
                    $payment_date_end[$i] = strval($payment_date_end[$i][2]) . "-" . strval($payment_date_end[$i][1]) . "-" . strval($payment_date_end[$i][0] . " 23:59:59");
                }
            }
            
            $full_price = str_replace(",", ".", $full_price);
            $associated_price = str_replace(",", ".", $associated_price);

            $payments[] = array(
                "payment_date_start" => $payment_date_start,
                "payment_date_end" => $payment_date_end,
                "full_price" => $full_price,
                "payment_portions" => $payment_portions,
                "associated_price" => $associated_price,
            );
        }

        if ($date_start) {
            $date_start = explode("/", $date_start);
            $date_x = explode(" ", $date_start[2]);
            $date_start = strval($date_x[0]) . "-" . strval($date_start[1]) . "-" . strval($date_start[0]);
        }

        if ($date_finish) {
            $date_finish = explode("/", $date_finish);
            $date_x = explode(" ", $date_finish[2]);
            $date_finish = strval($date_x[0]) . "-" . strval($date_finish[1]) . "-" . strval($date_finish[0] . " 23:59:59");
        }

        if ($date_start_pre_associate) {
            $date_start_pre_associate = explode("/", $date_start_pre_associate);
            $date_x = explode(" ", $date_start_pre_associate[2]);
            $date_start_pre_associate = strval($date_x[0]) . "-" . strval($date_start_pre_associate[1]) . "-" . strval($date_start_pre_associate[0]);
        }

        if ($date_finish_pre_associate) {
            $date_finish_pre_associate = explode("/", $date_finish_pre_associate);
            $date_x = explode(" ", $date_finish_pre_associate[2]);
            $date_finish_pre_associate = strval($date_x[0]) . "-" . strval($date_finish_pre_associate[1]) . "-" . strval($date_finish_pre_associate[0] . " 23:59:59");
        }

        if ($date_start_pre) {
            $date_start_pre = explode("/", $date_start_pre);
            $date_x = explode(" ", $date_start_pre[2]);
            $date_start_pre = strval($date_x[0]) . "-" . strval($date_start_pre[1]) . "-" . strval($date_start_pre[0]);
        }

        if ($date_finish_pre) {
            $date_finish_pre = explode("/", $date_finish_pre);
            $date_x = explode(" ", $date_finish_pre[2]);
            $date_finish_pre = strval($date_x[0]) . "-" . strval($date_finish_pre[1]) . "-" . strval($date_finish_pre[0] . " 23:59:59");
        }

        $camps = $this->summercamp_model->getAllSummerCamps();

        foreach ($camps as $camp) {

            if ($camp->getCampId() != $camp_id && $date_start && $date_finish && ((Events::verifyAntecedence($camp->getDateStart(), $date_start) && Events::verifyAntecedence($date_start, $camp->getDateFinish())) || (Events::verifyAntecedence($camp->getDateStart(), $date_finish) && Events::verifyAntecedence($date_finish, $camp->getDateFinish())))) {
                $errors[] = "Há um evento nesse período\\n";
                break;
            }
        }

        if (count($errors) > 0 || $error != "") {

            $paymentsError = array();

            foreach ($payments as $payment) {

                $datePayment = null;
                $datePaymentEnd = null;

                if ($payment['payment_date_start']) {
                    $datePayment = explode("-", $payment['payment_date_start']);
                    $dateDay = explode(" ", $datePayment[2]);
                    $datePayment = $dateDay[0] . "/" . $datePayment[1] . "/" . $datePayment[0];
                }

                if ($payment['payment_date_end']) {
                    $datePaymentEnd = explode("-", $payment['payment_date_end']);
                    $dateDay = explode(" ", $datePaymentEnd[2]);
                    $datePaymentEnd = $dateDay[0] . "/" . $datePaymentEnd[1] . "/" . $datePaymentEnd[0];
                }

                $paymentsError[] = array(
                    "payment_date_start" => $datePayment,
                    "payment_date_end" => $datePaymentEnd,
                    "full_price" => $payment['full_price'],
                    "payment_portions" => $payment['payment_portions'],
                    "associated_price" => $payment['associated_price'],
                );
            }

            if ($error != "") {
                $errors[] = $error;
            }

            foreach ($errors as $e) {
                $this->Logger->info("Error: " . $e);
            }

            return $this->editCamp($camp_id, $errors, $payments);
        }

        try {
            $this->Logger->info("Updating SummerCamp " . $camp_name);
            $this->generic_model->startTransaction();

            $campId = $this->summercamp_model->updateCamp($camp_id, $camp_name, $date_start, $date_finish, $date_start_pre_associate, $date_finish_pre_associate, $date_start_pre, $date_finish_pre, $capacity_male, $capacity_female, $mini_camp, $schooling_description);

            if ($campId) {
                $this->summercamp_model->deleteSummerCampPaymentPeriods($camp_id);

                foreach ($payments as $payment) {
                    $this->summercamp_model->insertNewSummercampPaymentPeriod($camp_id, $payment["payment_date_start"], $payment["payment_date_end"], $payment["full_price"], $payment["payment_portions"], $payment["associated_price"]);
                }

                $this->generic_model->commitTransaction();
                $this->Logger->info("New SummerCamp successfully inserted");
                return $this->manageCamps('Colônia atualizada com sucesso!');
            } else
                return $this->manageCamps('Ocorreu um erro ao atualizar a colônia. Tente novamente.');
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new summercamp");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;

            return $this->manageCamps('Ocorreu um erro ao atualizar a colônia. Tente novamente.');

//$this->loadReportView('admin/events/event_edit', $data);
        }
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

        $campChosen = 0;
        $camps = array(0 => "Colônia Verão", 1 => "Mini Kinderland");

        if (isset($_GET['colonia_f']))
            $campChosen = $_GET['colonia_f'];

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;

        $miniCamp = $campChosen;

        $statusCamps = $this->summercamp_model->getMiniCampsOrNotByYear($year, $miniCamp);

        $campsId = array();

        if ($statusCamps != null) {
            foreach ($statusCamps as $statusCamp) {
                $campsId[] = $statusCamp->getCampId();
            }
        }

        $selected = 2;
        $opcoes = array(0 => "Sócios e Indicados", 1 => "Não Sócios", 2 => "Todos");

//        if (isset($_GET['opcao_f']))
//            $selected = $_GET['opcao_f'];

        $data['selecionado'] = $selected;
        $data['opcoes'] = $opcoes;

        $people = array();
        $peopleId = array();
        $peopleFinal = array();
        $campsIdStr = "";
        if ($campsId != null && count($campsId) > 0) {
            $campsIdStr = $campsId[0];
            for ($i = 1; $i < count($campsId); $i++)
                $campsIdStr .= "," . $campsId[$i];
        }
        $people = $this->summercamp_model->getAssociatedOrNotByStatusAndSummerCamp($campsIdStr, $selected);

        $peopleID = [];
        
        foreach($people as $person) {
            array_push($peopleID, $person -> person_id);
        }

        $nextPosition = $this->summercamp_model->getNextAvailablePosition($campsIdStr);

        $data['nextPosition'] = $nextPosition;
        $data['people'] = $people;
        $data['peopleID'] = $peopleID;
        $this->loadReportView("admin/camps/queue", $data);
    }

    public function insertNewCamp() {
        $this->Logger->info("Running: " . __METHOD__);

        $date_start = $_POST['date_start'];

        $date_finish = $_POST['date_finish'];

        $date_start_pre = $_POST['date_start_pre'];

        $date_finish_pre = $_POST['date_finish_pre'];

        $date_start_pre_associate = $_POST['date_start_pre_associate'];

        $date_finish_pre_associate = $_POST['date_finish_pre_associate'];

        $camp_name = $_POST['camp_name'];
        $capacity_male = $_POST['capacity_male'];
        $capacity_female = $_POST['capacity_female'];
        $mini_camp = $_POST['mini_camp'];
        
        $error = $this->input->post("error", TRUE);
        
        $errors = array();

        $payments = array();
        $payment_date_end = $this->input->post("payment_date_end", TRUE);
        $payment_date_start = $this->input->post("payment_date_start", TRUE);
        $full_price = $this->input->post("price", TRUE);
        $payment_portions = $this->input->post("payment_portions", TRUE);
        $associated_price = $this->input->post("associated_price", TRUE);
              
        $schooling_description = $_POST['schooling_description'];
        
        if ($camp_name === ""){
        	$errors[] = "O campo nome é obrigatório\n";
        }
        if (!$date_start){
        	$date_start = NULL;
        }
        if (!$date_start_pre_associate){
        	$date_start_pre_associate = NULL;
        }
        if (!$date_start_pre){
        	$date_start_pre = NULL;
        }
        if (!$date_finish){
        	$date_finish = NULL;
        }
        if (!$date_finish_pre_associate){
        	$date_finish_pre_associate = NULL;
        }
        if (!$date_finish_pre){
        	$date_finish_pre = NULL;
        }
        
        if ($date_start && $date_finish && !Events::verifyAntecedence($date_start, $date_finish)){
        	$errors[] = "A data do ínicio do período do evento não antecede a data de fim do evento\\n";
        }
        if ($date_start_pre_associate && $date_finish_pre_associate && !Events::verifyAntecedence($date_start_pre_associate, $date_finish_pre_associate)){
        	$errors[] = "A data do ínicio do período de inscrições para associados não antecede a data de fim do periodo de inscrições para associados\\n";
        }
        if ($date_start && $date_finish_pre_associate && Events::verifyAntecedence($date_start, $date_finish_pre_associate)){
        	$errors[] = "A data do ínicio do período da colÃ´nia antecede a data de fim de inscrições para associados\\n";
        }
        if ($date_start && $date_finish_pre && Events::verifyAntecedence($date_start, $date_finish_pre)){
        	$errors[] = "A data do ínicio do período da colÃ´nia antecede a data de fim de inscrições\\n";
        }
        
        if ($capacity_male === ""){
        	$capacity_male = 0;
        }
        if ($capacity_female === ""){
        	$capacity_female = 0;
        }
        
        if (is_array($full_price)) {
        	for ($i = 0; $i < count($full_price); $i++) {
        		if (!$payment_date_start[$i]){
        			$errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem data de inicio\\n";
        		}
        		if (!$payment_date_end[$i]){
        			$errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem data de fim\\n";
        		}
        		if (!$full_price[$i]){
        			$errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem valor\\n";
        		}
        		if (!$associated_price[$i]){
        			$errors[] = "O periodo de pagamento de numero " . ($i + 1) . " não tem valor para sócio\\n";
        		}
        		if ($payment_date_start[$i] && $payment_date_end[$i] && !Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$i])) {
        			$errors[] = "O pagamento de numero " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
        		}
        
        		for ($j = $i + 1; $j < count($full_price); $j++) {
        			if
        			(
        					(
        							Events::verifyAntecedence($payment_date_start[$i], $payment_date_start[$j]) && Events::verifyAntecedence($payment_date_start[$j], $payment_date_end[$i])
        							) ||
        					(
        							Events::verifyAntecedence($payment_date_start[$j], $payment_date_start[$i]) && Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$j])
        							)
        					)
        				$errors[] = "Os pagamentos de numero" . ($i + 1) . " e " . ($j + 1) . " se sobrepoem\\n";
        		}
        
        		if ($payment_date_start[$i]) {
        
        			$payment_date_start[$i] = explode("/", $payment_date_start[$i]);
        			$payment_date_start[$i] = strval($payment_date_start[$i][2]) . "-" . strval($payment_date_start[$i][1]) . "-" . strval($payment_date_start[$i][0]);
        		}
        
        		if ($payment_date_end[$i]) {
        			$payment_date_end[$i] = explode("/", $payment_date_end[$i]);
        			$payment_date_end[$i] = strval($payment_date_end[$i][2]) . "-" . strval($payment_date_end[$i][1]) . "-" . strval($payment_date_end[$i][0] . " 23:59:59");
        		}
        		
        		$full_price[$i] = str_replace(",", ".", $full_price[$i]);
        		$associated_price[$i] = str_replace(",", ".", $associated_price[$i]);
        
        		$payments[] = array(
        				"payment_date_start" => $payment_date_start[$i],
        				"payment_date_end" => $payment_date_end[$i],
        				"price" => $full_price[$i],
        				"payment_portions" => $payment_portions[$i],
        				"associated_price" => $associated_price[$i],
        		);
        	}
        } else if ($full_price !== FALSE) {
        	if (!$payment_date_start){
        		$errors[] = "O pagamento não tem data de inicio\\n";
        	}
        	if (!$payment_date_end){
        		$errors[] = "O pagamento não tem data de fim\\n";
        	}
        	if (!$full_price){
        		$errors[] = "O pagamento não tem valor\\n";
        	}
        	if (!$associated_price){
        		$errors[] = "O pagamento não tem valor para sócio\\n";
        	}
        	if ($payment_date_start[$i] && $payment_date_end[$i] && !Events::verifyAntecedence($payment_date_start[$i], $payment_date_end[$i])) {
        		$errors[] = "O pagamento de numero " . ($i + 1) . " tinha data de fim anterior a data de inicio\\n";
        	}
        
        	for ($i = 0; $i < count($full_price); $i++) {
        
        		if ($payment_date_start[$i]) {
        			$payment_date_start[$i] = explode("/", $payment_date_start[$i]);
        			$payment_date_start[$i] = strval($payment_date_start[$i][2]) . "-" . strval($payment_date_start[$i][1]) . "-" . strval($payment_date_start[$i][0]);
        		}
        
        		if ($payment_date_end[$i]) {
        			$payment_date_end[$i] = explode("/", $payment_date_end[$i]);
        			$payment_date_end[$i] = strval($payment_date_end[$i][2]) . "-" . strval($payment_date_end[$i][1]) . "-" . strval($payment_date_end[$i][0] . " 23:59:59");
        		}
        	}
        	
        	$full_price = str_replace(",", ".", $full_price);
        	$associated_price = str_replace(",", ".", $associated_price);
        
        	$payments[] = array(
        			"payment_date_start" => $payment_date_start,
        			"payment_date_end" => $payment_date_end,
        			"price" => $full_price,
        			"payment_portions" => $payment_portions,
        			"associated_price" => $associated_price,
        	);
        }
        
        if ($date_start) {
        	$date_start = explode("/", $date_start);
        	$date_x = explode(" ", $date_start[2]);
        	$date_start = strval($date_x[0]) . "-" . strval($date_start[1]) . "-" . strval($date_start[0]);
        }
        
        if ($date_finish) {
        	$date_finish = explode("/", $date_finish);
        	$date_x = explode(" ", $date_finish[2]);
        	$date_finish = strval($date_x[0]) . "-" . strval($date_finish[1]) . "-" . strval($date_finish[0] . " 23:59:59");
        }
        
        if ($date_start_pre_associate) {
        	$date_start_pre_associate = explode("/", $date_start_pre_associate);
        	$date_x = explode(" ", $date_start_pre_associate[2]);
        	$date_start_pre_associate = strval($date_x[0]) . "-" . strval($date_start_pre_associate[1]) . "-" . strval($date_start_pre_associate[0]);
        }
        
        if ($date_finish_pre_associate) {
        	$date_finish_pre_associate = explode("/", $date_finish_pre_associate);
        	$date_x = explode(" ", $date_finish_pre_associate[2]);
        	$date_finish_pre_associate = strval($date_x[0]) . "-" . strval($date_finish_pre_associate[1]) . "-" . strval($date_finish_pre_associate[0] . " 23:59:59");
        }
        
        if ($date_start_pre) {
        	$date_start_pre = explode("/", $date_start_pre);
        	$date_x = explode(" ", $date_start_pre[2]);
        	$date_start_pre = strval($date_x[0]) . "-" . strval($date_start_pre[1]) . "-" . strval($date_start_pre[0]);
        }
        
        if ($date_finish_pre) {
        	$date_finish_pre = explode("/", $date_finish_pre);
        	$date_x = explode(" ", $date_finish_pre[2]);
        	$date_finish_pre = strval($date_x[0]) . "-" . strval($date_finish_pre[1]) . "-" . strval($date_finish_pre[0] . " 23:59:59");
        }
        
        $camp = new SummerCamp(null, $camp_name, null, $date_start, $date_finish, $date_start_pre, $date_finish_pre, $date_start_pre_associate, $date_finish_pre_associate, null, //description
        		true, //preEnabled
        		$_POST['capacity_male'], $_POST['capacity_female'], $_POST['mini_camp'], 5, false, "", $schooling_description
        );
        $camps = $this->summercamp_model->getAllSummerCamps();
        
        foreach ($camps as $c) {
        
        	if ($date_start && $date_finish && ((Events::verifyAntecedence($c->getDateStart(), $date_start) && Events::verifyAntecedence($date_start, $c->getDateFinish())) || (Events::verifyAntecedence($c->getDateStart(), $date_finish) && Events::verifyAntecedence($date_finish, $c->getDateFinish())))) {
        		$errors[] = "Há um evento nesse período\\n";
        		break;
        	}
        }
        
        if (count($errors) > 0 || $error != "") {
        
        	$paymentsError = array();
        
        	foreach ($payments as $payment) {
        
        		$datePayment = null;
        		$datePaymentEnd = null;
        
        		if ($payment['payment_date_start']) {
        			$datePayment = explode("-", $payment['payment_date_start']);
        			$dateDay = explode(" ", $datePayment[2]);
        			$datePayment = $dateDay[0] . "/" . $datePayment[1] . "/" . $datePayment[0];
        		}
        
        		if ($payment['payment_date_end']) {
        			$datePaymentEnd = explode("-", $payment['payment_date_end']);
        			$dateDay = explode(" ", $datePaymentEnd[2]);
        			$datePaymentEnd = $dateDay[0] . "/" . $datePaymentEnd[1] . "/" . $datePaymentEnd[0];
        		}
        
        		$paymentsError[] = array(
        				"payment_date_start" => $datePayment,
        				"payment_date_end" => $datePaymentEnd,
        				"price" => $payment['price'],
        				"payment_portions" => $payment['payment_portions'],
        				"associated_price" => $payment['associated_price'],
        		);
        	}
        
        	if ($date_start) {
        		$date = explode("-", $date_start);
        		$dateDay = explode(" ", $date[2]);
        		$date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        		$date_start = $date;
        	}
        
        	if ($date_finish) {
        		$date = explode("-", $date_finish);
        		$dateDay = explode(" ", $date[2]);
        		$date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        		$date_finish = $date;
        	}
        
        	if ($date_start_pre_associate) {
        		$date = explode("-", $date_start_pre_associate);
        		$dateDay = explode(" ", $date[2]);
        		$date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        		$date_start_pre_associate = $date;
        	}
        
        	if ($date_finish_pre_associate) {
        		$date = explode("-", $date_finish_pre_associate);
        		$dateDay = explode(" ", $date[2]);
        		$date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        		$date_finish_pre_associate = $date;
        	}
        
        	if ($date_start_pre) {
        		$date = explode("-", $date_start_pre);
        		$dateDay = explode(" ", $date[2]);
        		$date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        		$date_start_pre = $date;
        	}
        
        	if ($date_finish_pre) {
        		$date = explode("-", $date_finish_pre);
        		$dateDay = explode(" ", $date[2]);
        		$date = $dateDay[0] . "/" . $date[1] . "/" . $date[0];
        		$date_finish_pre = $date;
        	}
        
        	if ($error != "") {
        		$errors[] = $error;
        	}
        
        	foreach ($errors as $e) {
        		$this->Logger->info("Error: " . $e);
        	}
        
        	return $this->createCamp($errors, $camp_name, $date_start, $date_finish, $date_start_pre_associate, $date_finish_pre_associate, $date_start_pre, $date_finish_pre, $capacity_male, $capacity_female,$paymentsError, $mini_camp, $schooling_description);
        }  

        try {
            $this->Logger->info("Inserting new summer camp");
            $this->generic_model->startTransaction();

            $campId = $this->summercamp_model->insertNewCamp($camp);

            if ($campId !== null) {
                foreach ($payments as $payment) {
                    $this->summercamp_model->insertNewSummercampPaymentPeriod($campId, $payment["payment_date_start"], $payment["payment_date_end"], $payment["price"], $payment["payment_portions"], $payment["associated_price"]);
                }

                $this->generic_model->commitTransaction();
                $this->Logger->info("New summer camp successfully inserted");
                return $this->manageCamps('Colônia criada com sucesso!');
            } else 
            	return $this->manageCamps('Ocorreu um erro ao tentar criar a colônia. Tente novamente!');
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new camp");
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            $this->loadView('admin/camps/create_error', $data);
        }
    }

    public function changeCampEnabledStatus($campId) {
        $this->Logger->info("Running: " . __METHOD__);

        $camp = $this->summercamp_model->getSummerCampById($campId);
        $payments = $this->summercamp_model->getSummerCampPaymentPeriods($camp->getCampId());

        if ($camp->isEnabled() || $payments)
            echo $this->summercamp_model->updateCampPreEnabled($campId);
        else
            echo "0";
    }
    
    public function changeEditFriendsEnabledStatus($campId) {
    	$this->Logger->info("Running: " . __METHOD__);
    
    	$camp = $this->summercamp_model->getSummerCampById($campId);
    
    	if ($camp->isEditFriendsEnabled() !== null)
    		echo $this->summercamp_model->updateEditFriendsEnabled($campId);
    	else
    		echo "0";
    }

    public function validateColonists() {
        $this->Logger->info("Running: " . __METHOD__);

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

        $campCount = array();
        $count = null;

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $count = $this->summercamp_model->getCountStatusBySummerCamp($camp->getCampId());

            if ($count != null) {
                $campCount[] = $count;
                $camps[] = $camp->getCampName();
            }

            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;
        $data['campCount'] = $campCount;

        $statusChosen = 'Aguardando Validação';

        if (isset($_GET['status_f']))
            $statusChosen = $_GET['status_f'];

        $status = array('Aguardando Validação', 'Não Validada', 'Validada', 'Todos');

        $data['status_escolhido'] = $statusChosen;
        $data['status'] = $status;

        if ($statusChosen == 'Aguardando Validação') {
            $data['colonists'] = $this->summercamp_model->getAllColonistsByYearSummerCampAndStatus($year, $campChosenId, 1);
        } else if ($statusChosen == 'Não Validada') {
            $data['colonists'] = $this->summercamp_model->getAllColonistsByYearSummerCampAndStatus($year, $campChosenId, 6);
        } else if ($statusChosen == 'Validada') {
            $data['colonists'] = $this->summercamp_model->getAllColonistsByYearSummerCampAndStatus($year, $campChosenId, 2);
        } else if ($statusChosen == 'Todos') {
            $data['colonists'] = $this->summercamp_model->getAllColonistsByYearSummerCampAndStatus($year, $campChosenId, null);
        }

        $this->loadReportView("admin/camps/validate_colonists", $data);
    }

    public function colonist_exclusion() {

        $this->Logger->info("Running: " . __METHOD__);
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

        $campCount = array();
        $count = null;

        $campChosenId = null;
        foreach ($allCamps as $camp) {
            $count = $this->summercamp_model->getCountStatusBySummerCamp($camp->getCampId());

            if ($count != null) {
                $campCount[] = $count;
                $camps[] = $camp->getCampName();
            }

            if ($camp->getCampName() == $campChosen)
                $campChosenId = $camp->getCampId();
        }

        $data['colonia_escolhida'] = $campChosen;
        $data['camps'] = $camps;
        $data['campCount'] = $campCount;

        $shownStatus = SUMMER_CAMP_SUBSCRIPTION_STATUS_WAITING_VALIDATION . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_EXCLUDED . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_GIVEN_UP . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED . "," . SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS;

        $data['colonists'] = $this->summercamp_model->getAllColonistsBySummerCampAndYear($year, $shownStatus);
        $this->loadReportView("admin/camps/colonist_exclusion", $data);
    }

    public function password() {
        $this->Logger->info("Running: " . __METHOD__);


        $pass = $_POST['senha'];
        $id = $this->session->userdata("user_id");
        $person = $this->personuser_model->getUserById($id);
        $login = $person->getLogin();
        $colonistId = $_POST['colonist_id'];
        $summerCampId = $_POST['summer_camp_id'];
        $situation = $_POST['situation'];
        $cancel_reason = $_POST['cancel_reason'];
        $discount = $_POST['discount'];

        $userId = $this->personuser_model->userLogin($login, $pass);


        if ($userId != null) {

            $result = $this->summercamp_model->updateStatus($colonistId, $summerCampId, $situation, $discount, $cancel_reason);
            if ($result != null)
                echo "true";
            else
                echo "false";
        } else
            echo "false";
    }

    public function setDiscount() {
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

        $this->Logger->info("Running: " . __METHOD__);
        $data['colonists'] = $this->summercamp_model->getAllColonistsForDiscount($year);
        $data['discountReasons'] = $this->summercamp_model->getDefaultDiscountReasons();
        $this->loadReportView("admin/camps/set_discount", $data);
    }

    public function setDiscountValue() {
        $this->Logger->info("Running: " . __METHOD__);
        $colonistId = $this->input->get('colonist_id', TRUE);
        $summerCampId = $this->input->get('summer_camp_id', TRUE);
        $discount_value = $this->input->get('discount_value', TRUE);
        $discount_reason_id = $this->input->get('discount_reason_id', TRUE);
        if ($discount_reason_id == -2) {
            $discount_reason_other = $this->input->get('discount_reason_other', TRUE);
            $discount_reason_id = $this->summercamp_model->insertDiscountReason($discount_reason_other);
        }
        if ($this->summercamp_model->updateDiscount($colonistId, $summerCampId, $discount_value, $discount_reason_id))
            echo "alert('Problema ao modificar o desconto, tente novamente')";
        redirect("admin/setDiscount?type=discount");
    }

    public function paymentLiberation() {
        $data = array();

        $years = array();
        $start = 2015;
        $date = intval(date('Y'));
        $campsByYear = null;
        do {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        } while ($campsByYear != null);

        while ($start <= $end) {
            $years[] = $start;
            $start++;
        }
        $data["years"] = $years;

        if (isset($_POST['year'])) {
            $yearChosen = $_POST['year'];
            $data["year_selected"] = $yearChosen;
            if (isset($_POST['camp_id'])) {
                $selectedCamp = $this->summercamp_model->getSummerCampById($_POST['camp_id']);
                if ($selectedCamp != null) {
                    $data["camp_selected_id"] = $selectedCamp->getCampId();
                    $data["camp_selected_name"] = $selectedCamp->getCampName();
                    $data["camp_selected_male_capacity"] = $selectedCamp->getCapacityMale();
                    $data["camp_selected_female_capacity"] = $selectedCamp->getCapacityFemale();

                    $campSubscriptions = $this->summercamp_model->getSummerCampSubscriptionsByStatusAndGender($_POST["camp_id"]);
                    $data["camp_details"] = $campSubscriptions;

                    $subscriptions = $this->summercamp_model->getAllColonistsWithQueueNumberBySummerCamp($selectedCamp->getCampId());
                    if ($subscriptions != null)
                        $data["subscriptions"] = $subscriptions;
                }
            }

            $allCamps = $this->summercamp_model->getAllSummerCampsByYear($yearChosen);
            $data["camps"] = $allCamps;
        } else {
            $allCamps = $this->summercamp_model->getAllSummerCampsByYear(intval(date('Y')));
            $data["camps"] = $allCamps;
            $data["year_selected"] = date('Y');
        }

        $this->loadReportView("admin/camps/payment_liberation", $data);
    }

    public function liberatePayments() {
        $this->Logger->info("Running: " . __METHOD__);
        echo "<script>alert('Ainda nao funcional(Em desenvolvimento).'); window.location.replace('" . $this->config->item('url_link') . "admin/paymentLiberation');</script>";
    }

    public function managePaymentLiberation() {
        $this->Logger->info("Running: " . __METHOD__);

        $data = array();

        $years = array();
        $start = 2015;
        $date = intval(date('Y'));
        $campsByYear = null;
        do {
            $end = $date;
            $date++;
            $campsByYear = $this->summercamp_model->getAllSummerCampsByYear($date);
        } while ($campsByYear != null);

        while ($start <= $end) {
            $years[] = $start;
            $start++;
        }
        $data["years"] = $years;

        if (isset($_POST['year'])) {
            $yearChosen = $_POST['year'];
            $data["year_selected"] = $yearChosen;
            if (isset($_POST['camp_id'])) {
                $selectedCamp = $this->summercamp_model->getSummerCampById($_POST['camp_id']);
                if ($selectedCamp != null) {
                    $data["camp_selected_id"] = $selectedCamp->getCampId();
                    $data["camp_selected_name"] = $selectedCamp->getCampName();
                    $data["camp_selected_male_capacity"] = $selectedCamp->getCapacityMale();
                    $data["camp_selected_female_capacity"] = $selectedCamp->getCapacityFemale();

                    $campSubscriptions = $this->summercamp_model->getSummerCampSubscriptionsByStatusAndGender($_POST["camp_id"]);
                    $data["camp_details"] = $campSubscriptions;

                    $subscriptions = $this->summercamp_model->getAllColonistsWaitingPaymentBySummerCamp($selectedCamp->getCampId());
                    if ($subscriptions != null)
                        $data["subscriptions"] = $subscriptions;
                }
            }

            $allCamps = $this->summercamp_model->getAllSummerCampsByYear($yearChosen);
            $data["camps"] = $allCamps;
        } else {
            $data["year_selected"] = date('Y');
            $allCamps = $this->summercamp_model->getAllSummerCampsByYear(intval(date('Y')));
            $data["camps"] = $allCamps;
        }

        $this->loadReportView("admin/camps/manage_payment_liberation", $data);
    }

    public function updateColonistValidation() {
        $this->Logger->info("Running: " . __METHOD__);
        $colonistId = $_POST['colonist_id'];
        $summerCampId = $_POST['summer_camp_id'];

        $genderOk = (isset($_POST['gender'])) ? $_POST['gender'] : null;
        $pictureOk = (isset($_POST['picture'])) ? $_POST['picture'] : null;
        $medicalCardOk = (isset($_POST['medical_card'])) ? $_POST['medical_card'] : null;
        $identityOk = (isset($_POST['identity'])) ? $_POST['identity'] : null;
        $birthdayOk = (isset($_POST['birthday'])) ? $_POST['birthday'] : null;
        $parentsNameOk = (isset($_POST['parents_name'])) ? $_POST['parents_name'] : null;
        $colonistNameOk = (isset($_POST['colonist_name'])) ? $_POST['colonist_name'] : null;

        $msgGender = ($genderOk == "false") ? $_POST['msg_gender'] : "";
        $msgPicture = ($pictureOk == "false") ? $_POST['msg_picture'] : "";
        $msgMedicalCard = ($medicalCardOk == "false") ? $_POST['msg_medical_card'] : "";
        $msgIdentity = ($identityOk == "false") ? $_POST['msg_identity'] : "";
        $msgBirthdate = ($birthdayOk == "false") ? $_POST['msg_birthday'] : "";
        $msgParentsName = ($parentsNameOk == "false") ? $_POST['msg_parents_name'] : "";
        $msgColonistName = ($colonistNameOk == "false") ? $_POST['msg_colonist_name'] : "";

        $validationReturn = $this->validation_model->updateColonistValidation($colonistId, $summerCampId, $genderOk, $pictureOk, $medicalCardOk, $identityOk, $birthdayOk, $parentsNameOk, $colonistNameOk, $msgGender, $msgPicture, $msgMedicalCard, $msgIdentity, $msgBirthdate, $msgParentsName, $msgColonistName);

        if ($validationReturn)
            echo "true";
        else
            echo "false";
    }

    public function confirmValidation() {
        $this->Logger->info("Running: " . __METHOD__);
        $colonistId = $_POST['colonist_id'];
        $summerCampId = $_POST['summer_camp_id'];
        $gender = $_POST['gender'];
        $picture = $_POST['picture'];
        $medicalCard = $_POST['medical_card'];
        $identity = $_POST['identity'];
        $birthday = $_POST['birthday'];
        $parentsName = $_POST['parents_name'];
        $colonistName = $_POST['colonist_name'];

        $this->Logger->info("User validating this colonist[id: " . $colonistId . "] -> User: " . $this->session->userdata("fullname") . "[user id: " . $this->session->userdata("user_id") . "]");
        $summerCampSubscription = $this->summercamp_model->getSummerCampSubscription($colonistId, $summerCampId);
        if ($summerCampSubscription->getSituationId() == SUMMER_CAMP_SUBSCRIPTION_STATUS_FILLING_IN) {
            $this->Logger->error("Cannot validate because the colonist returned to filling in status");
            return;
        }

        $status = 0;
        if ($gender == "true" && $picture == "true" && $medicalCard == "true"  && $identity == "true" && $birthday == "true" && $parentsName == "true" && $colonistName == "true")
            $status = SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED;
        else
            $status = SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED_WITH_ERRORS;

        $this->summercamp_model->updateColonistStatus($colonistId, $summerCampId, $status);
        if ($status == SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED)
            $this->sendValidatedEmail($colonistId, $summerCampId);
        else
            $this->sendNotValidatedEmail($colonistId, $summerCampId);
        echo $this->summercamp_model->getStatusDescription($status);
    }

    public function sendNotValidatedEmail($colonistId, $summerCampId) {
        $this->Logger->info("Running: " . __METHOD__);

        $summercamp = $this->summercamp_model->getSummerCampById($summerCampId);
        if (!$summercamp) {
            $this->Logger->error("Camp not found, cannot send an email");
            return;
        }

        $colonist = $this->colonist_model->getColonist($colonistId);
        if (!$colonist) {
            $this->Logger->error("Colonist not found");
            return;
        }

        $personuser = $this->colonist_model->getColonistPersonUser($colonistId, $summerCampId);
        if (!$personuser) {
            $this->Logger->error("PersonUser related to colonist not found");
            return;
        }

        $this->Logger->info("Sending email");

        $responsableId = $personuser->getPersonId();

        $father = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
        $mother = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");

        $emailArray = array();
        if ($father && $responsableId != $father) {
            $father = $this->person_model->getPersonFullById($father);
            $emailArray[] = $father->email;
        }
        if ($mother && $mother != $responsableId) {
            $mother = $this->person_model->getPersonFullById($mother);
            $emailArray[] = $mother->email;
        }


        $this->sendValidationWithErrorsEmail($personuser, $colonist, $summercamp->getCampName(), $emailArray);
    }

    public function sendValidatedEmail($colonistId, $summerCampId) {
        $this->Logger->info("Running: " . __METHOD__);

        $summercamp = $this->summercamp_model->getSummerCampById($summerCampId);
        if (!$summercamp) {
            $this->Logger->error("Camp not found, cannot send an email");
            return;
        }

        $colonist = $this->colonist_model->getColonist($colonistId);
        if (!$colonist) {
            $this->Logger->error("Colonist not found");
            return;
        }

        $personuser = $this->colonist_model->getColonistPersonUser($colonistId, $summerCampId);
        if (!$personuser) {
            $this->Logger->error("PersonUser related to colonist not found");
            return;
        }

        $this->Logger->info("Sending email");

        $responsableId = $personuser->getPersonId();

        $father = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
        $mother = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");

        $emailArray = array();
        if ($father && $responsableId != $father) {
            $father = $this->person_model->getPersonFullById($father);
            $emailArray[] = $father->email;
        }
        if ($mother && $mother != $responsableId) {
            $mother = $this->person_model->getPersonFullById($mother);
            $emailArray[] = $mother->email;
        }


        $this->sendValidationOkEmail($personuser, $colonist, $summercamp->getCampName(), $emailArray);
    }

    public function users() {
        $this->Logger->info("Running: " . __METHOD__);
        $this->loadView("admin/users/user_admin_container");
    }

    public function userPermissions() {
        $this->Logger->info("Running: " . __METHOD__);
        $i = 'A';
        for ($j = 0; $j < 26; $j++) {
            $letters[] = $i;
            $i++;
        }
        $letter = null;

        if (isset($_GET['letter_chosen']))
            $letter = $_GET['letter_chosen'];
        else {
            $letter = 'A';
        }

        $data['letter_chosen'] = $letter;
        $data['letters'] = $letters;
        $data['users'] = $this->person_model->getUserPermissionsDetailed($letter);
        $this->loadReportView("admin/users/user_permissions", $data);
    }

    public function userPermissionsFilter() {
        $this->Logger->info("Running: " . __METHOD__);
        $letra = $this->input->post('letra', TRUE);

        $data['users'] = $this->person_model->getUserPermissionsDetailed($letra);
        $this->loadReportView("admin/users/user_permissions", $data);
    }

    public function updatePersonPermissions() {
        $this->Logger->info("Running: " . __METHOD__);

        $this->Logger->info("Array POST: " . print_r($_POST, true));
        $personId = $_POST['person_id'];
        $arrNewPermissions = array(
            'system_admin' => isset($_POST['system_admin']),
            'director' => isset($_POST['director']),
            'secretary' => isset($_POST['secretary']),
            'coordinator' => isset($_POST['coordinator']),
            'doctor' => isset($_POST['doctor']),
            'monitor' => isset($_POST['monitor_instructor'])
        );

        $this->Logger->info("Array New Permissions: " . print_r($arrNewPermissions, true));
        try {
            $this->Logger->info("Updating user's permissions");
            $this->generic_model->startTransaction();

            $this->person_model->updateUserPermissions($personId, $arrNewPermissions);

            $this->generic_model->commitTransaction();
            $this->Logger->info("Updated user's permissions");
            echo "true";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to update user's permissions");
            $this->generic_model->rollbackTransaction();
            echo "false";
        }
    }

    public function viewColonistInfo() {
        $this->Logger->info("Starting " . __METHOD__);
        if (($this->input->get('type', TRUE)) !== null) {
            $type = $this->input->get('type', TRUE);
        } else {
            $type = null;
        }
        $data['type'] = $type;
        $colonistId = $this->input->get('colonistId', TRUE);
        $summerCampId = $this->input->get('summerCampId', TRUE);
        $camper = $this->summercamp_model->getSummerCampSubscription($colonistId, $summerCampId);
        $address = $this->address_model->getAddressByPersonId($camper->getPersonId());
        $responsableId = $camper->getPersonUserId();
        $responsableAddress = $this->address_model->getAddressByPersonId($responsableId);
        $data["sameAddressResponsable"] = "n";
        if ($responsableAddress)
            if ($address->getAddressId() == $responsableAddress->getAddressId())
                $data["sameAddressResponsable"] = "s";
        $data["colonistId"] = $colonistId;
        $data["summerCamp"] = $this->summercamp_model->getSummerCampById($summerCampId);
        $data["id"] = $summerCampId;
        $data["fullName"] = $camper->getFullName();
        $data["Gender"] = $camper->getGender();
        $data["birthdate"] = date("d-m-Y", strtotime($camper->getBirthDate()));
        $data["school"] = $camper->getSchool();
        $data["schoolYear"] = $camper->getSchoolYear();
        $data["documentNumber"] = $camper->getDocumentNumber();
        $data["documentType"] = $camper->getDocumentType();
        $data["phone1"] = $camper->getDocumentType();
        $data["phone2"] = $camper->getDocumentType();
        $data["street"] = $address->getStreet();
        $data["number"] = $address->getPlaceNumber();
        $data["city"] = $address->getCity();
        $data["cep"] = $address->getCEP();
        $data["complement"] = $address->getComplement();
        $data["neighborhood"] = $address->getNeighborhood();
        $data["uf"] = $address->getUf();
        $telephones = $this->telephone_model->getTelephonesByPersonId($camper->getPersonId());
        $data["phone1"] = isset($telephones[0]) ? $telephones[0] : FALSE;
        $data["phone2"] = isset($telephones[1]) ? $telephones[1] : FALSE;
        $father = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Pai");
        $mother = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, "Mãe");
        if ($father) {
            if ($father == $responsableId)
                $data["responsableDadMother"] = "dad";
            $father = $this->person_model->getPersonFullById($father);
            $data["dadFullName"] = $father->fullname;
            $data["dadEmail"] = $father->email;
            $data["dadPhone"] = $father->phone1;
        } else {
            $data["noFather"] = TRUE;
        }
        if ($mother) {
            if ($mother == $responsableId)
                $data["responsableDadMother"] = "mother";
            $mother = $this->person_model->getPersonFullById($mother);
            $data["motherFullName"] = $mother->fullname;
            $data["motherEmail"] = $mother->email;
            $data["motherPhone"] = $mother->phone1;
        } else {
            $data["noMother"] = TRUE;
        }

        if ($camper->getRoommate1())
            $data['roommate1'] = $camper->getRoommate1();
        if ($camper->getRoommate2())
            $data['roommate2'] = $camper->getRoommate2();
        if ($camper->getRoommate3())
            $data['roommate3'] = $camper->getRoommate3();

        $data['specialCare'] = $camper->getSpecialCare();

        if ($camper->getSpecialCareObs())
            $data['specialCareObs'] = $camper->getSpecialCareObs();

        if ($data["summerCamp"]->isMiniCamp()) {
            $miniCamp = $this->summercamp_model->getMiniCampObs($summerCampId, $colonistId);
            $data['miniCamp'] = $miniCamp;
        }
        $this->loadView('summercamps/viewColonistInfo', $data);
    }

    public function verifyDocument() {
        $this->Logger->info("Starting " . __METHOD__);
        $camp_id = $this->input->get('camp_id', TRUE);
        $colonist_id = $this->input->get('colonist_id', TRUE);
        $document_type = $this->input->get('document_type', TRUE);
        $document = $this->summercamp_model->getNewestDocument($camp_id, $colonist_id, $document_type);
        if ($document) {
            if (strtolower($document["extension"]) == "pdf")
                header("Content-type: application/pdf");
            else
                header("Content-type: image/jpeg");
            echo pg_unescape_bytea($document["data"]);
        } else {
            $this->loadView("admin/users/documentNotFound");
        }
    }

    public function verifyDocumentExpense() {
        $this->Logger->info("Starting " . __METHOD__);
        $upload_id = $this->input->get('upload_id', TRUE);
        $document = $this->documentexpense_model->getUploadById($upload_id);
        if ($document) {
            if (strtolower($document["extension"]) == "pdf")
                header("Content-type: application/pdf");
            else
                header("Content-type: image/jpeg");
            echo pg_unescape_bytea($document["data"]);
        } else {
            $this->loadView("admin/users/documentNotFound");
        }
    }
	
	   public function verifyPostingExpense() {
        $this->Logger->info("Starting " . __METHOD__);
        $upload_id = $this->input->get('upload_id', TRUE);
        $document = $this->documentexpense_model->getPostingUploadById($upload_id);
        if ($document) {
            if (strtolower($document["extension"]) == "pdf")
                header("Content-type: application/pdf");
            else
                header("Content-type: image/jpeg");
            echo pg_unescape_bytea($document["data"]);
        } else {
            $this->loadView("admin/users/documentNotFound");
        }
    }
    

    public function viewPostingUpload($document_id = NULL, $errors = array()) {
        if (!isset($document_id) || empty($document_id)) {
            $document_id = $this->input->get('document_id', TRUE);
        }
        $portions = 1;
        $upload = $this->finance_model->hasPostingUpload($document_id, $portions);
        $data['document_id'] = $document_id;
        $data['portions'] = $portions;
        $data['upload_id'] = $upload;
        $data['errors'] = $errors;
        $this->loadReportView("admin/finances/viewPostingUpload", $data);
    }

    public function viewDocumentUpload($document_id = NULL, $errors = array()) {

        if (!isset($document_id) || empty($document_id)) {
            $document_id = $this->input->get('document_id', TRUE);
        }
        $upload = $this->documentexpense_model->getUploadId($document_id);
        $data['document_id'] = $document_id;
        $data['upload_id'] = $upload;
        $data['errors'] = $errors;
        $this->loadReportView("admin/finances/viewDocumentUpload", $data);
    }

    public function updateDocumentUpload() {
        $id = $this->input->get('upload_id', TRUE);
        $upload = $this->input->post('has_document', TRUE);
        $document_id = $this->input->post('document_id', TRUE);
        $operation = "create";
        $fileName = $_FILES['uploadedfile']['name'];
        if (isset($_FILES['uploadedfile']['tmp_name']) && !empty($_FILES['uploadedfile']['tmp_name'])) {
            $file = file_get_contents($_FILES['uploadedfile']['tmp_name']);
        }
        $errors = array();
        if (empty($file) || !isset($file))
            $errors[] = 'Não foi passado nenhum arquivo para upload\n';
        if (count($errors) > 0)
            return $this->viewDocumentUpload($document_id, $errors);
        try {
            $this->generic_model->startTransaction();
            if ($upload) {
                $uploadId = $this->documentexpense_model->updateUploadDocument($id, $fileName, $file, $operation);
            } else {
                $uploadId = $this->documentexpense_model->uploadDocument($fileName, $file, $operation);
                $new_id = $this->documentexpense_model->getNewUpload();
                $result = $this->documentexpense_model->attatchUploadId($document_id, $new_id);
            }
            if ($_FILES['uploadedfile'] ['error'] > 0 || !$uploadId) {
                echo "<script>alert('Erro ao enviar documento, verifique se ele se adequa as regras de envio e tente novamente. Lembramos que somente aceitamos arquivos até 2MB.');
            window.location.replace('" . $this->config->item('url_link') . "admin/manageDocuments');</script>";
            }
            $this->generic_model->commitTransaction();
            $this->Logger->info("Document successfully updated");
            $url = $this->config->item('url_link') . "admin/manageDocuments";
            if ($uploadId) {
                echo "<SCRIPT LANGUAGE='JavaScript'>
           		window.alert('Documento modificado com sucesso')
            	window.location.href='" . $url . "'</SCRIPT>";
            } else
                echo "<SCRIPT LANGUAGE='JavaScript'>
          			window.alert('Ocorreu um erro ao modificar o documento. Tente novamente mais tarde')
           			 window.location.href='" . $url . "'</SCRIPT>";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to update document upload" . $id);
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            $this->loadReportView('admin/finances/manage_documents', $data);
        }
    }
	
	   public function updatePostingUpload() {
        $id = $this->input->get('upload_id', TRUE);
        $upload = $this->input->post('has_upload', TRUE);
        $document_id = $this->input->post('document_id', TRUE);
        $portions = $this->input->post('portions', TRUE);
        $fileName = $_FILES['uploadedfile']['name'];
        if (isset($_FILES['uploadedfile']['tmp_name']) && !empty($_FILES['uploadedfile']['tmp_name'])) {
            $file = file_get_contents($_FILES['uploadedfile']['tmp_name']);
        }
        $errors = array();
        if (empty($file) || !isset($file))
            $errors[] = 'Não foi passado nenhum arquivo para upload\n';
        if (count($errors) > 0)
            return $this->viewDocumentUpload($document_id, $portions, $errors);
        try {
            $this->generic_model->startTransaction();
            if ($upload) {
                $uploadId = $this->documentexpense_model->updateUploadPosting($id, $fileName, $file);
            } else {
                $uploadId = $this->documentexpense_model->uploadPosting($fileName, $file);
                $new_id = $this->documentexpense_model->getNewUploadPosting();
                $result = $this->documentexpense_model->attatchPostingUploadId($document_id, $portions, $new_id);
            }
            if ($_FILES['uploadedfile'] ['error'] > 0 || !$uploadId) {
                echo "<script>alert('Erro ao enviar documento, verifique se ele se adequa as regras de envio e tente novamente. Lembramos que somente aceitamos arquivos até 2MB.');
            window.location.replace('" . $this->config->item('url_link') . "reports/postingExpenses');</script>";
            }
            $this->generic_model->commitTransaction();
            $this->Logger->info("Document successfully updated");
            $url = $this->config->item('url_link') . "reports/postingExpenses";
            if ($uploadId) {
                echo "<SCRIPT LANGUAGE='JavaScript'>
           		window.alert('Documento modificado com sucesso.')
            	window.location.href='" . $url . "'</SCRIPT>";
            } else
                echo "<SCRIPT LANGUAGE='JavaScript'>
          			window.alert('Ocorreu um erro ao modificar o documento. Tente novamente mais tarde')
           			 window.location.href='" . $url . "'</SCRIPT>";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to update posting upload" . $id);
            $this->generic_model->rollbackTransaction();
            $data['error'] = true;
            $this->loadReportView('reports/finances/postingExpenses', $data);
        }
    }

    public function viewEmails($userId) {
        $this->Logger->info("Starting " . __METHOD__);
        $person = $this->person_model->getPersonById($userId);
        $emails = $this->email_model->getEmailsSentToUserById($userId);

        $data['emails'] = $emails;
        $data['person'] = $person;

        $this->loadView("admin/users/emailsSent", $data);
    }

    public function writeEmail($userId) {
        $this->Logger->info("Starting " . __METHOD__);
        $person = $this->person_model->getPersonById($userId);

        $data['person'] = $person;

        $this->loadView("admin/users/writeEmail", $data);
    }

    public function sendEmail() {
        $this->Logger->info("Starting " . __METHOD__);
        $userId = $this->input->post('user_id', TRUE);
        $userEmail = $this->input->post('user_email', TRUE);
        $subject = $this->input->post('subject', TRUE);
        $message = $this->input->post('message', TRUE);

        $person = $this->person_model->getPersonById($userId);

        if ($this->sendMail($subject, $message, $person)) {
            echo "<script>alert('Envio realizado com sucesso'); window.location.replace('" . $this->config->item('url_link') . "admin/viewEmails/" . $userId . "');</script>";
        } else {
            echo "<script>alert('Houve um problema ao enviar o email. Por favor, tente novamente.'); window.history.back(-1);</script>";
        }
    }

    public function checaPrimeiraLiberacao() {

        $this->Logger->info("Starting " . __METHOD__);

        $summer_camp_id = $this->input->post('summer_camp_id');

        if(!sizeof($this->summercamp_model->jaFoiLiberado($summer_camp_id)))
            echo("true");

    }

    public function sorteiaTodos() {
        
        $this->Logger->info("Starting " . __METHOD__);
        
        $usersId = $this->input->post('users_id', TRUE);
        $usersId = explode("-", $usersId);
        array_pop($usersId);
        $summerCampType = $this->input->post('summer_camp_type', TRUE);
        $yearSelected = $this->input->post('year', TRUE);

        if($usersId != null && sizeof($usersId) > 0) {
        
            try {
                $this->Logger->info("Getting summer camps id");
                $summerCamps = $this->summercamp_model->getMiniCampsOrNotByYear($yearSelected, $summerCampType);
                $campsIdStr = "";
                if ($summerCamps != null && count($summerCamps) > 0) {
                    $campsIdStr = $summerCamps[0]->getCampId();
                    for ($i = 1; $i < count($summerCamps); $i++)
                        $campsIdStr .= "," . $summerCamps[$i]->getCampId();
                }
                $this->Logger->debug("Summer Camp Ids: " . $campsIdStr);
                if (strlen($campsIdStr) == 0)
                    throw new Exception("Nenhum evento encontrado com os parâmetros dados.");

                $this->Logger->info("Check for open subscriptions");
                // VERIFICA SE A DATA DE PRÉ-INSCRIÇÃO AINDA ESTÁ ABERTA
                if(sizeof($this->summercamp_model->checaPreInscAberta($campsIdStr))) {
                    echo("pre-inscricoes abertas");
                    return;
                }

                $this->Logger->info("Check for called students");
                // VERIFICA SE HÁ CANDIDATOS JÁ LIBERADOS E IMPEDE O USO DE SORTEAR TODOS
                $usersIdStr = $usersId[0];
                
                for ($i = 1; $i < count($usersId); $i++)
                        $usersIdStr .= "," . $usersId[$i];

                if(sizeof($this->summercamp_model->checaLiberados($usersIdStr, $campsIdStr))) {
                    echo("candidato ja liberado");
                    return;
                }
                
                // FAZ O SORTEIO
                $sorteiaPeople = [];
                $sizeUsers = sizeof($usersId);

                $this->Logger->info("First lottery started");

                for($i = 0; $i < $sizeUsers; $i++) {
                    
                    // sorteia um índice
                    $temp = 0;
                    if($i !== $sizeUsers-1)
                        $temp = rand(0,$sizeUsers-$i-1);
                    
                    // adiciona o elemento da lista desse índice a uma lista sorteio
                    $sorteiaPeople[$i] = $usersId[$temp];
                    
                    // retira o elemento já usado e reenumera a lista de pessoas
                    unset($usersId[$temp]);
                    $usersId = array_values($usersId);
                }
                
                // REFAZ O SORTEIO
                $this->Logger->info("Second lottery started");

                for($i = 0; $i < $sizeUsers; $i++) {
                    
                    // sorteia um índice
                    $temp = 0;
                    if($i !== $sizeUsers-1)
                        $temp = rand(0,$sizeUsers-$i-1);
                    
                    // adiciona o elemento da lista desse índice a uma lista sorteio
                    $usersId[$i] = $sorteiaPeople[$temp];
                    
                    // retira o elemento já usado e reenumera a lista de pessoas
                    unset($sorteiaPeople[$temp]);
                    $sorteiaPeople = array_values($sorteiaPeople);
                }
                // TERMINOU A FASE DE SORTEIO
                $this->Logger->info("Lottery phase finished");

                $this->Logger->info("Updating queue number in database for each subscription");
                $this->generic_model->startTransaction();
                foreach($usersId as $position=>$userId) {
                    if (!$this->summercamp_model->updateQueueNumber($userId, $campsIdStr, $position+2))
                        throw new Exception("Falha ao atualizar o banco de dados");
                    $this->generic_model->commitTransaction();
                }
                echo "true";
                return;
            } catch (Exception $e) {
                $this->Logger->error("Failed to insert new user");
                $this->generic_model->rollbackTransaction();
                echo utf8_decode($ex->getMessage());
            }
        } else {
            echo("Não há usuários na fila de espera.");
            return;
        }
    }

    public function updateQueueNumber() {
        $this->Logger->info("Starting " . __METHOD__);
        $userId = $this->input->post('user_id', TRUE);
        $summerCampType = $this->input->post('summer_camp_type', TRUE);
        $yearSelected = $this->input->post('year', TRUE);
        $position = $this->input->post('position', TRUE);

        try {
            $this->Logger->info("Getting summer camps id");
            $summerCamps = $this->summercamp_model->getMiniCampsOrNotByYear($yearSelected, $summerCampType);
            $campsIdStr = "";
            if ($summerCamps != null && count($summerCamps) > 0) {
                $campsIdStr = $summerCamps[0]->getCampId();
                for ($i = 1; $i < count($summerCamps); $i++)
                    $campsIdStr .= "," . $summerCamps[$i]->getCampId();
            }
            $this->Logger->debug("Summer Camp Ids: " . $campsIdStr);
            if (strlen($campsIdStr) == 0)
                throw new Exception("Nenhuma colonia encontrada com os parametros dados.");

            $this->Logger->info("Checking if the given position is already occupied by another person");
            if (!$this->summercamp_model->checkQueueNumberAvailability($userId, $campsIdStr, $position))
                throw new Exception("Falha ao atualizar fila de espera, verifique se outra pessoa possui o mesmo valor");

            $this->Logger->info("Updating queue number in database");
            $this->generic_model->startTransaction();
            if (!$this->summercamp_model->updateQueueNumber($userId, $campsIdStr, $position))
                throw new Exception("Falha ao atualizar o banco de dados");
            $this->generic_model->commitTransaction();

            echo "true";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new user");
            $this->generic_model->rollbackTransaction();
            echo utf8_decode($ex->getMessage());
        }
    }





    public function updateQueueNumberNEAM() {
        $this->Logger->info("Starting " . __METHOD__);
        $userId = $this->input->post('user_id', TRUE);
        $summerCampType = $this->input->post('summer_camp_type', TRUE);
        $yearSelected = $this->input->post('year', TRUE);
        $position = $this->input->post('position', TRUE);

        try {
            $this->Logger->info("Getting summer camps id");
            $summerCamps = $this->summercamp_model->getMiniCampsOrNotByYear($yearSelected, $summerCampType);
            $campsIdStr = "";
            if ($summerCamps != null && count($summerCamps) > 0) {
                $campsIdStr = $summerCamps[0]->getCampId();
                for ($i = 1; $i < count($summerCamps); $i++)
                    $campsIdStr .= "," . $summerCamps[$i]->getCampId();
            }
            $this->Logger->debug("Summer Camp Ids: " . $campsIdStr);
            if (strlen($campsIdStr) == 0)
                throw new Exception("Nenhuma colonia encontrada com os parametros dados.");

            $this->Logger->info("Checking if the user was already called for presential subscription"); // from neam
            if ($this->summercamp_model->checaLiberados($userId, $campsIdStr)) {
                echo("ja liberado");
                return;
            }

            $this->Logger->info("Checking if the given position is already occupied by another person");
            if (!$this->summercamp_model->checkQueueNumberAvailability($userId, $campsIdStr, $position))
                throw new Exception("Falha ao atualizar fila de espera, verifique se outra pessoa possui o mesmo valor");

            $this->Logger->info("Updating queue number in database");
            $this->generic_model->startTransaction();
            if (!$this->summercamp_model->updateQueueNumber($userId, $campsIdStr, $position))
                throw new Exception("Falha ao atualizar o banco de dados");
            $this->generic_model->commitTransaction();

            echo "true";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to insert new user");
            $this->generic_model->rollbackTransaction();
            echo utf8_decode($ex->getMessage());
        }
    }

    public function updateToWaitingPaymentIndividual() {
        $this->Logger->info("Starting " . __METHOD__);
        $colonistId = $this->input->post('colonist_id', TRUE);
        $summerCampId = $this->input->post('summer_camp_id', TRUE);

        try {
            $this->generic_model->startTransaction();
            $summerCamp = $this->summercamp_model->getSummerCampById($summerCampId);

            $status = SUMMER_CAMP_SUBSCRIPTION_STATUS_PENDING_PAYMENT . ", " . SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED;
            $countSubs = $this->summercamp_model->getCountSubscriptionsBySummerCampAndStatus($summerCamp->getCampId(), $status);

            $colonist = $this->colonist_model->getColonist($colonistId);

            foreach ($countSubs as $countGender) {
                if ($countGender->gender == $colonist->getGender()) {
                    if ($colonist->getGender() == "M") {
                        if ($summerCamp->getCapacityMale() <= $countGender->count) {
                            echo "Sem vagas para liberar pagamento no masculino.";
                            return;
                        }
                    } else {
                        if ($summerCamp->getCapacityFemale() <= $countGender->count) {
                            echo "Sem vagas para liberar pagamento no feminino.";
                            return;
                        }
                    }
                }
            }

            if (!$this->summercamp_model->updateColonistToWaitingPayment($colonistId, $summerCampId))
                throw new Exception("Falha ao mudar status de colonista.");

            $this->generic_model->commitTransaction();

            $summerCampSub = $this->summercamp_model->getSummerCampSubscription($colonistId, $summerCampId);
            $personuser = $this->colonist_model->getColonistPersonUser($colonistId, $summerCampId);

            $this->sendPaymentLiberationEmail($personuser, $colonist, $summerCamp->getCampName(), $summerCampSub->getDatePaymentLimitFormatted());

            echo "true";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to update user status to waiting payment");
            $this->generic_model->rollbackTransaction();
            echo utf8_decode($ex->getMessage());
        }
    }

    public function cancelSubscriptionIndividual() {
        $this->Logger->info("Starting " . __METHOD__);
        $colonistId = $this->input->post('colonist_id', TRUE);
        $summerCampId = $this->input->post('summer_camp_id', TRUE);

        try {
            $this->generic_model->startTransaction();
            if (!$this->summercamp_model->updateColonistStatus($colonistId, $summerCampId, SUMMER_CAMP_SUBSCRIPTION_STATUS_CANCELLED))
                throw new Exception("Falha ao mudar status de colonista.");

            $this->generic_model->commitTransaction();

// Enviar email?

            echo "true";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to update user status to waiting payment");
            $this->generic_model->rollbackTransaction();
            echo utf8_decode($ex->getMessage());
        }
    }

    public function updateDatePaymentLimit() {
        $this->Logger->info("Starting " . __METHOD__);
        $colonistId = $this->input->post('colonist_id', TRUE);
        $summerCampId = $this->input->post('summer_camp_id', TRUE);
        $dateLimit = $this->input->post('date_limit', TRUE);

        try {
            $this->generic_model->startTransaction();
            if (!$this->summercamp_model->updateDatePaymentLimit($colonistId, $summerCampId, $dateLimit))
                throw new Exception("Falha ao mudar data de prazo.");

            $this->generic_model->commitTransaction();

//Enviar Email??

            echo "true";
        } catch (Exception $ex) {
            $this->Logger->error("Failed to update user status to waiting payment");
            $this->generic_model->rollbackTransaction();
            echo utf8_decode($ex->getMessage());
        }
    }

    public function editColonist() {
        print_r($this->input->post('personId', TRUE));
        $this->Logger->info("Starting " . __METHOD__);
        $colonistId = $this->input->post('colonistId', TRUE);
        $summerCampId = $this->input->post('summerCampId', TRUE);
        $personId = $this->input->post('personId', TRUE);
        $birthdate = $this->input->post('birthdate', TRUE);
        $documentType = $this->input->post('documentType', TRUE);
        $documentNumber = $this->input->post('documentNumber', TRUE);
        try {
            $this->Logger->info("Editing colonist $summerCampId");
            $this->generic_model->startTransaction();
            $this->colonist_model->updateColonist($personId, $birthdate, $documentNumber, $documentType, $colonistId);
            $this->generic_model->commitTransaction();
            $this->Logger->info("Colonist sucessfully edited");
            redirect("admin/camp");
        } catch (Exception $ex) {
            $this->Logger->error("Failed to edit colonist subscription");
            $this->generic_model->rollbackTransaction();
        }
    }

    public function editColonistForm() {
        $this->Logger->info("Starting " . __METHOD__);
        $colonistId = $this->input->get('colonistId', TRUE);
        $summerCampId = $this->input->get('summerCampId', TRUE);
        $camper = $this->summercamp_model->getSummerCampSubscription($colonistId, $summerCampId);
        $data["fullName"] = $camper->getFullName();
        $data["summerCampId"] = $summerCampId;
        $data["colonistId"] = $colonistId;
        $data["personId"] = $camper->getPersonId();
        $data["birthdate"] = date("d-m-Y", strtotime($camper->getBirthDate()));
        $data["documentNumber"] = $camper->getDocumentNumber();
        $data["documentType"] = $camper->getDocumentType();
        $this->loadView('admin/camps/edit_colonist_form', $data);
    }

}
