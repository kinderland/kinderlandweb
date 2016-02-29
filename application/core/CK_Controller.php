<?php

include_once APPPATH . 'core/personuser.php';
include_once APPPATH . 'core/event.php';
include_once APPPATH . 'core/donation.php';
include_once APPPATH . 'libraries/logger.php';
include_once APPPATH . 'libraries/csv.php';

// Colonia Kinderland Controller -> CK_Controller
class CK_Controller extends CI_Controller {

    protected $pid;
    protected $Logger;

    public function __construct() {
        parent::__construct();
        $this->pid = getmypid();
        $this->setLogger();
        $this->load->model('personuser_model');
        $this->load->model('summercamp_model');
        $this->personuser_model->setLogger($this->Logger);
        $this->summercamp_model->setLogger($this->Logger);
    }

    public function __destruct() {
        if ($this->Logger)
            $this->Logger->endTransaction();
    }

    public function sendSignupEmail($person) {
        $this->Logger->info("Running :" . __METHOD__);

        $emailString = "Olá " . $person->getFullname() . ", <br><br>" . "Seu cadastro foi efetuado com sucesso.<br><br><br><br>" . "Diretoria da Associação Kinderland";
        $emailSubject = "[Kinderland] Confirmação de cadastro";

        return $this->sendMail($emailSubject, $emailString, $person);
    }

    public function sendPaymentConfirmationMail($donation, $payment) {
        if ($donation->getDonationType() == DONATION_TYPE_ASSOCIATE) {
            $person = $this->person_model->getPersonById($donation->getPersonId());
            $year = date("Y");
            $emailString = "Prezad" . (($person->getGender() == 'F') ? 'a' : 'o') . " " . $person->getFullname() . ", <br><br>" .
                    "Sua doação para a Associação Kinderland foi recebida com sucesso. Estamos registrando seu
			CPF em nossa base de associados do ano" . $year . ".<br><br>" .
                    "Esta contribuição é muito importante para nós, pois permite que façamos diversos investimentos
			no patrimônio da Colônia para que as futuras gerações possam usufruir desta experiência única
			que é a Kinderland.<br><br>
			Da mesma forma, sua colaboração permite que continuemos a promover os projetos sociais em
			parceria com outras instituições, com o objetivo de contribuir para a construção de uma
			sociedade mais justa e igualitária.<br><br>
			Os sócios-doadores da Kinderland têm, entre outros, os seguintes benefícios:<br><br>" .
                    "<ul>" .
                    "<li>" . "Desconto nas doações pela cessão do espaço físico da colônia Kinderland para festas de aniversário, finais de semana com amigos ou outros eventos particulares;</li>" .
                    "<li>" . "Desconto nos eventos especiais organizados e realizados pela Associação Kinderland (ex. evento MaCK - Mostre a Colônia Kinderland);</li>" .
                    "<li>" . "Pré-inscrição antecipada <b>sem garantia de vaga</b> para a temporada de verão</li>" .
                    "</ul>" .
                    "<br><br>" .
                    "Recomendamos que leiam atentamente as condições dos sócios-doadores  disponíveis no nosso site:
			<a href='http://www.kinderland.com.br/como-ajudar/quero-ser-socio/' target='_blank'>http://www.kinderland.com.br/como-ajudar/quero-ser-socio/</a> <br><br>
 			Mais uma vez, nosso MUITO OBRIGADO!<br><br>Diretoria da Associação Kinderland";
            $emailSubject = "[Kinderland] Doacao campanha associados";

            return $this->sendMail($emailSubject, $emailString, $person, array("secretaria@kinderland.com.br"));
        } else if ($donation->getDonationType() == DONATION_TYPE_FREEDONATION) {
            $person = $this->person_model->getPersonById($donation->getPersonId());
            $emailString = "Prezad" . (($person->getGender() == 'F') ? 'a' : 'o') . " " . $person->getFullname() . ", <br><br>" . "Sua doação para a Kinderland
			foi recebida com sucesso. <br><br>" .
                    "A Associação KINDERLAND é uma entidade sem fins lucrativos que necessita de <br>" .
                    "contribuições e doações regulares. Elas são utilizadas na manutenção do espaço onde <br>" .
                    "a Colônia de Férias é realizada, além de ajudar com os custos operacionais durante o ano <br><br>" .
                    "Agradecemos a todos que indistintamente contribuem como associados ou doadores.<br>" .
                    "A Associação Kinderland realiza projetos sociais com jovens de comunidades carentes,<br>" .
                    "oferece bolsas parciais ou integrais para crianças do Lar da Criança nas temporadas <br>" .
                    "de verão e participa de várias outras iniciativas comunitárias. Somente com estas <br>" .
                    "contribuições regulares isto torna-se possível. <br><br>" .
                    "Muito obrigado pela sua contribuição, ela é muito importante para
			nós.<br><br><br><br>" . "Diretoria da Associação Kinderland";
            $emailSubject = "[Kinderland] Doacao avulsa";

            return $this->sendMail($emailSubject, $emailString, $person, array("secretaria@kinderland.com.br"));
        } else if ($donation->getDonationType() == DONATION_TYPE_SUBSCRIPTION) {
            $person = $this->person_model->getPersonById($donation->getPersonId());
            $event = $this->event_model->getDonationEvent($donation->getDonationId());
            $personsDonation = $this -> eventsubscription_model -> getPersonsIdByEventIdAndDonationId($event -> getEventId(), $donation->getDonationId());
            $emailString = "Prezad" . (($person->getGender() == 'F') ? 'a' : 'o') . " " . $person->getFullname() . ", <br><br>" . "Sua inscrição para o " . $event->getEventName() . " foi recebida com sucesso. <br><br>" . "Seguem os convites 
            desta inscrição:<br><br>";
            foreach($personsDonation as $p){
            	$name = $this->person_model->getPersonById($p->person_id);
            	
            	$nonsleeper = null;
            	
            	if($p->nonsleeper == "t")
            		$nonsleeper = "sem pernoite";
            	else 
            		$nonsleeper = "com pernoite";
            	
            	$emailString = $emailString . $name->getFullname() . ", " . $p -> description . ", " . $nonsleeper . "<br><br>";
            }
            
            $emailString = $emailString . "Muito obrigado pela sua contribuição e no interesse pelos evento da Kinderland!<br><br>" . "Diretoria da Associação Kinderland";
            $emailSubject = "[Kinderland] Inscricao " . $event->getEventName() . " confirmada";

            return $this->sendMail($emailSubject, $emailString, $person, array("secretaria@kinderland.com.br"));
        }
		else if ($donation->getDonationType() == DONATION_TYPE_SUMMERCAMP_SUBSCRIPTION) {
			$responsableId = $donation->getPersonId();
            $summerCampSubscriptionArray = $this->summercamp_model->getSubscriptionsByDonation($donation->getDonationId());
            foreach($summerCampSubscriptionArray as $summerCampSubscription){
				if(!$this->sendSubscriptionFinalMail($responsableId,$summerCampSubscription))
					return FALSE;				
        	}
			return TRUE;
    	}
		
	}

	public function sendSubscriptionFinalMail($responsableId,$summerCampSubscription){
		$person = $this->person_model->getPersonById($responsableId);
		$cc = array("secretaria@kinderland.com.br");
		$father = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampSubscription->getSummerCampId(), $summerCampSubscription->getColonistId(), "Pai");
		$mother = $this->summercamp_model->getParentIdOfSummerCampSubscripted($summerCampSubscription->getSummerCampId(), $summerCampSubscription->getColonistId(), "Mãe");
		
		if($father && $responsableId != $father){
			$father = $this->person_model->getPersonFullById($father);
			$cc[] = $father->email;		
		}
		if($mother && $mother != $responsableId){
			$mother = $this->person_model->getPersonFullById($mother);
			$cc[] = $mother->email;
		}
				
				
		$emailString = "Prezad" . (($person->gender == 'F') ? 'a' : 'o') . " " . $person->fullname . ", <br><br>" . "O processo de inscrição do(a) colonista " . $summerCampSubscription->getFullname() . " está agora completo 
		e a inscrição para a colônia " . $this -> summercamp_model -> getSummerCampById($summerCampSubscription->getSummerCampId()) -> getCampName() . " está confirmada. <br><br>" . "Por favor, aguarde novas mensagens e comunicados, 
		referentes às próximas etapas: reunião de pais e responsáveis, reunião de quartos, entre outros. <br><br> Muito obrigado por sua doação e interesse na(s) colônia(s) Kinderland! <br><br><br><br>" . "Diretoria da Associação Kinderland";
        $emailSubject = "[Kinderland] Inscricao " . $summerCampSubscription->getFullname() . " confirmada";
		if(!$this->sendMail($emailSubject, $emailString, $person, $cc)){
			$this->Logger->error("Error sending mail to $person to confirm subscription of colonist with campId/colonistId : ".$summerCampSubscription->getSummerCampId()."/".getColonistId());
			return FALSE;
		}            	
        return TRUE;
	}

    public function sendNewPasswordEmail($person, $randomString) {
        $emailSubject = "[Kinderland] Nova senha";
        $emailString = "Prezad" . (($person->getGender() == 'F') ? 'a' : 'o') . " " . $person->getFullname() . ", <br><br>" . "Sua nova senha é: " .
                $randomString . "<br><br>" . "Por favor, lembre-se de alterar essa senha para uma senha de sua preferência quando entrar no sistema." .
                "<br><br>" . "Caso você não tenha solicitado essa mudança de senha, favor entrar em contato com a secretaria Kinderland." .
                "<br><br><br><br>" . "Diretoria da Associação Kinderland";

        return $this->sendPasswordMail($emailSubject, $emailString, $person);
    }

    public function sendValidationWithErrorsEmail($person, $colonist, $summerCampName, $parentsMailArray = array()) {
        $cc = array();
		$cc[] = "secretaria@kinderland.com.br";
		foreach ($parentsMailArray as $mail) {
			if($mail != $person->getEmail())
				$cc[] = $mail;
		}
        $emailSubject = "[Kinderland] ". $colonist->getFullname() . "colônia [". $summerCampName ."]: correções necessárias na pré-inscrição";
        $emailString = "A pré-inscrição de " . $colonist->getFullname() . " na colônia " . $summerCampName . " ainda não foi validada pois são necessárias correções e complementos. 
        Pode ter sido algum dado não corretamente preenchido ou algum problema relacionados com a foto ou documento de identificação do colonista.<br /><br /><br />
        Mas não se preocupe: pedimos por gentileza que acesse o Sistema Kinderland onde você poderá visualizar os motivos e resolver as pendências facilmente. 
        Não se esqueça de, após as correções, reenviar a pré-inscrição para que a mesma possa passar novamente pelo processo de validação.<br /><br /><br />
        Associação Kinderland";
		
        return $this->sendMail($emailSubject, $emailString, $person, $cc);
    }

    public function sendValidationOkEmail($person, $colonist, $summerCampName,$parentsMailArray = array()) {
        $cc = array();
		$cc[] = "secretaria@kinderland.com.br";
		foreach ($parentsMailArray as $mail) {
			if($mail != $person->getEmail())
				$cc[] = $mail;
		}
        $emailSubject = "[Kinderland] Pré-inscrição de " . $colonist->getFullname() . " na colônia ". $summerCampName ." validada";
        $emailString = "A pré-inscrição de " . $colonist->getFullname() . " na colônia " . $summerCampName . " já foi validada pois todos os dados foram corretamente preenchidos.<br /><br /><br />
            Pedimos por gentileza que aguardem o chamado para a próxima etapa de confirmação da inscrição.  Em função da ordem definida em sorteio - se houver necessidade, convidaremos seguindo a posição na fila de espera.<br /><br /><br />
            Associação Kinderland";

        return $this->sendMail($emailSubject, $emailString, $person, $cc);
    }

    public function sendEmailSubmittedPreSubscription($person, $colonist, $summerCampName,$parentsMailArray = array()) {
    	$cc = array();
		$cc[] = "secretaria@kinderland.com.br";
		foreach ($parentsMailArray as $mail) {
			if($mail != $person->getEmail())
				$cc[] = $mail;
		}
        $emailSubject = "[Kinderland] Pré-inscrição de " . $colonist->getFullname() . " na colônia " . $summerCampName . " recebida";
        $emailString = "A pré-inscrição de " . $colonist->getFullname() . " na colonia " . $summerCampName . " foi recebida pela Associação Kinderland. Aguarde nova comunicação por email validando (ou não) os dados preenchidos e documentos enviados.<br><br>
        Acompanhe sempre as novidades em nosso site e a situação da pré-inscrição no Sistema Kinderland. Em caso de dúvidas, entrar em contato por telefone (21-2266-1980) ou, preferencialmente, por email.<br><br>
        
        Muito obrigado pelo interesse em participar das nossas colônias!<br><br>
        Associação Kinderland";

        return $this->sendMail($emailSubject, $emailString, $person, $cc);
    }

    public function sendEmailExcluded($person, $colonist, $summerCampName, $parentsMailArray = array()) {
        $cc = array();
        $cc[] = "secretaria@kinderland.com.br";
        foreach ($parentsMailArray as $mail) {
            if($mail != $person->getEmail())
                $cc[] = $mail;
        }
        $emailSubject = "[Kinderland]  Solicitação de exclusão: inscricao de " . $colonist->getFullname() . " na colonia " . $summerCampName;
        $emailString = "Prezado (a) " .$person->getFullname(). ",<br /><br /> Sua solicitação de exclusão da inscrição de " .$colonist->getFullname(). " na colonia ". $summerCampName ." foi encaminhada à secretaria.<br /><br />
        Aguarde contato para confirmação da exclusão. Eventual reembolso de doações serão tratados seguindo os critérios estabelecidos pela Associação Kinderland.
        <br /><br />Obrigado pelo interesse na(s) colônia(s) Kinderland! 
        <br /><br />Diretoria da Associação Kinderland";

        return $this->sendMail($emailSubject, $emailString, $person, $cc);
    }
    
    public function sendPaymentLiberationEmail($person, $colonist, $summerCampName, $dateLimit, $parentsMailArray = array()) {
    	$cc = array();
    	$cc[] = "secretaria@kinderland.com.br";
    	foreach ($parentsMailArray as $mail) {
    		if($mail != $person->getEmail())
    			$cc[] = $mail;
    	}
    	$emailSubject = "[Kinderland] ". $summerCampName . " inscricao disponivel para " . $colonist->getFullname();
    	$emailString = "Prezad" . (($person->getGender() == 'F') ? 'a' : 'o') . " " . $person->getFullname() . ", <br><br>A inscrição 
    		do colonista " . $colonist->getFullname() . " na colonia " . $summerCampName . " já pode ser finalizada.<br>
			Para tanto, acesse o sistema kinderland e realize a doação até o dia " . $dateLimit.  ". Esta é a única forma de efetivar a inscrição.<br>
			Solicitamos que não aguarde até o prazo final.<br><br> 
			Obrigado pelo interesse nas Colonias Kinderland.<br><br>
			Secretaria Kinderland";
    
    	return $this->sendMail($emailSubject, $emailString, $person, $cc);
    }

    protected function sendMail($subject, $content, $person, $cc = NULL, $bcc = NULL) {
        //$myMail = "testekinderland2015@gmail.com";
        //$config = Array('protocol' => 'smtp', 'smtp_host' => 'ssl://smtp.gmail.com', 'smtp_port' => 465, 'smtp_user' => $myMail, 'smtp_pass' => 'testandoteste', 'mailtype' => 'html', 'charset' => mb_internal_encoding(), 'wordwrap' => TRUE);
        
        $myMail = "secretaria@kinderland.com.br";
        $config = Array('protocol' => 'smtp', 'smtp_host' => 'ssl://br154.hostgator.com.br', 'smtp_port' => 465, 'smtp_user' => $myMail, 'smtp_pass' => 'Kinder155', 'mailtype' => 'html', 'charset' => mb_internal_encoding(), 'wordwrap' => TRUE);

        $this->load->library('email', $config);
        $this->load->model('email_model');
        $this->email_model->setLogger($this->Logger);

        $to = $person->getEmail();

        if ($cc == NULL) {
            $cc = array("secretaria@kinderland.com.br");
        }

        if (ENVIRONMENT != 'production') {
            $addToSubject = "[TESTE][to:$to][cc=";
            if($cc != null){
                foreach ($cc as $carboncopy) {
                    $addToSubject.=$carboncopy;
                }
            }
            $addToSubject.="][bcc=";
            if ($bcc != null) {
                foreach ($bcc as $carboncopy) {
                    $addToSubject.=$carboncopy;
                }
            }
            $addToSubject.="]";
            
            $to = "teste_suporte@kinderland.com.br";
            $cc = NULL;
            $bcc = NULL;
            $subject = $addToSubject . $subject;
        }

        $this->email->from($myMail);
        $this->email->to($to);
        $this->email->set_newline("\r\n");
        $this->email->subject($subject);
        $this->email->message($content);
        if ($cc != NULL)
            $this->email->cc($cc);
        if ($bcc != NULL)
            $this->email->bcc($bcc);
        if ($this->email->send()) {
            $this->email_model->saveEmail($subject, $content, $person->getEmail(), $cc, $bcc, TRUE);
            $this->Logger->info("Email enviado com sucesso para: " . $person->getFullname() . " com o assunto " . $subject);
            return TRUE;
        } else {
            $this->email_model->saveEmail($subject, $content, $person->getEmail(), $cc, $bcc, FALSE);
            $this->Logger->error("Problema ao enviar email para: " . $person->getFullname() . " com o assunto " . $subject . "\n Texto de debug foi: " . $this->email->print_debugger());
            return FALSE;
        }
    }

    protected function sendPasswordMail($subject, $content, $person) {
        //$myMail = "testekinderland2015@gmail.com";
        //$config = Array('protocol' => 'smtp', 'smtp_host' => 'ssl://smtp.gmail.com', 'smtp_port' => 465, 'smtp_user' => $myMail, 'smtp_pass' => 'testandoteste', 'mailtype' => 'html', 'charset' => mb_internal_encoding(), 'wordwrap' => TRUE);

        $myMail = "secretaria@kinderland.com.br";
        $config = Array('protocol' => 'smtp', 'smtp_host' => 'ssl://br154.hostgator.com.br', 'smtp_port' => 465, 'smtp_user' => $myMail, 'smtp_pass' => 'Kinder155', 'mailtype' => 'html', 'charset' => mb_internal_encoding(), 'wordwrap' => TRUE);

        $this->load->library('email', $config);
        $this->load->model('email_model');
        $this->email_model->setLogger($this->Logger);

        $to = $person->getEmail();

        if (ENVIRONMENT != 'production') {
            $addToSubject = "[TESTE]";/*[to:$to][cc=";
            foreach ($cc as $carboncopy) {
                $addToSubject.=$carboncopy;
            }
            $addToSubject.="][bcc=";
            if ($bcc != null) {
                foreach ($bcc as $carboncopy) {
                    $addToSubject.=$carboncopy;
                }
            }
            $addToSubject.="]";
            $to = "teste.kinderland@gmail.com";
            $cc = NULL;
            $bcc = NULL;*/
            $subject = $addToSubject . $subject;
        }

        $this->email->from($myMail);
        $this->email->to($to);
        $this->email->set_newline("\r\n");
        $this->email->subject($subject);
        $this->email->message($content);
        if ($cc != NULL)
            $this->email->cc($cc);
        if ($bcc != NULL)
            $this->email->bcc($bcc);
        if ($this->email->send()) {
            $this->email_model->saveEmail($subject, "Conteúdo não armazenado por questões de privacidade", $person->getEmail(), $cc, $bcc, TRUE);
            $this->Logger->info("Email enviado com sucesso para: " . $person->getFullname() . " com o assunto " . $subject);
            return TRUE;
        } else {
            $this->email_model->saveEmail($subject, "Conteúdo não armazenado por questões de privacidade", $person->getEmail(), $cc, $bcc, FALSE);
            $this->Logger->error("Problema ao enviar email para: " . $person->getFullname() . " com o assunto " . $subject . "\n Texto de debug foi: " . $this->email->print_debugger());
            return FALSE;
        }
    }

    private function setLogger() {
        $this->config->load('logger', true);
        $logPath = $this->config->item('log_path', 'logger');
        //$logFilename = strtolower(get_class($this));
        $logLevel = $this->config->item('log_level', 'logger');
        //$this->Logger = new Logger($logLevel, $logPath, $logFilename);
        $this->Logger = new Logger($logLevel, $logPath, "kinderland");
        $this->Logger->startTransaction();
        $this->Logger->info('[ENVIRONMENT][' . strtoupper(ENVIRONMENT) . ']');
        $this->Logger->info("[PROCESS ID][{$this->pid}]");
    }

    public function loadView($viewName, $data = array()) {
        if ($this->session->userdata("fullname")) {
            $data['fullname'] = $this->session->userdata("fullname");
            $data['user_id'] = $this->session->userdata("user_id");
            $data['gender'] = $this->session->userdata("gender");
            $data['permissions'] = $this->session->userdata("user_types");
        }

        $output = $this->load->view('include/header', $data, true);
        $output .= $this->load->view($viewName, $data, true);
        $output .= $this->load->view('include/footer', $data, true);
        $this->output->set_output($output);
    }

    public function loadReportView($viewName, $data = array()) {
    	$data['permissions'] = $this->session->userdata("user_types");
        $output = $this->load->view('include/report/header', true);
        $output .= $this->load->view($viewName, $data, true);
        $this->output->set_output($output);
    }

    public static function toMMDDYYYY($date) {
        if ($date !== "" && $date !== FALSE && $date !== NULL) {
            $date = explode("/", $date);
            return $date[1] . "/" . $date[0] . "/" . $date[2];
        }
    }

    public static function verifyAntecedence($dateBefore, $dateAfter) {
        if ($dateBefore == NULL || $dateAfter == NULL)
            return FALSE;
        $dateBefore = implode('', array_reverse(explode('/', $dateBefore)));
        $dateAfter = implode('', array_reverse(explode('/', $dateAfter)));
        return $dateBefore <= $dateAfter;
    }

    public function checkSession() {
        $this->Logger->info("Running: " . __METHOD__);
        if (!$this->session->userdata('user_id') || !$this->session->userdata('fullname')) {
            $this->Logger->info("Session expired or doesnt exist");
            return false;
        }
        $this->Logger->info("Session ok - User " . $this->session->userdata('user_id'));
        return true;
    }

    public function checkPermition($permitions = array()) {
        foreach ($permitions as $permition) {
            foreach ($this->session->userdata('user_types') as $permitionUser) {
                if ($permition == $permitionUser)
                    return true;
            }
        }
        return false;
    }

    public static function toYYYYMMDD($date) {
        if ($date !== "" && $date !== FALSE && $date !== NULL) {
            $date = explode("/", $date);
            return $date[2] . "-" . $date[1] . "-" . $date[0];
        }
    }

    public function checkPermission($class, $method) {
        $permission = '0';
  //      $allPermissions = array();
        
  //      $allFreePermissions = $this -> personuser_model -> getMethodsAndClassesByUserType('0');
        
  //      if($allFreePermissions){
//	        foreach ($allFreePermissions as $p){
	//        	if(strcmp($class,$p->controller_name) == 0 && strcmp($method,$p->method_name) == 0){
//	        		$permission = '1';
//	        		break;
	//        	}
	//        }
  //      }
        
   //     $i = 0;
        
  //      $this -> Logger -> info("PERMISSION: ".$permission);
        
  //      if($permission === '0'){
   //     	$this -> Logger -> info("ENTROU EM PERMISSION!!!");
	        
	//        if($this->session->userdata($class)!== null){
	//        	$methods = $this->session->userdata('admin');
	//        	$this -> Logger -> info("CLASS: ".$class);
	 //       	$this -> Logger -> info("METHODS: ".$methods);
	        	
	//        	$methods = explode(",",$methods);
	        	
	 //       	foreach($methods as $m){
	//        		if($method == $m){
	 //       			$permission = "1";
	 //       			break;
	 //       		}
	  //      	}
	 //       }
     //   }

        if (!$this->session->userdata('user_types')) {
            $permission = $this->personuser_model->checkPermission($class, $method, array(0));
        } else {
            $permission = $this->personuser_model->checkPermission($class, $method, $this->session->userdata('user_types'));
        }

        if ($permission === '0') {
            $this->Logger->warn("Usuário com id =" . $this->session->userdata("user_id") . " tentou se conectar ao metodo " . $method . " da classe " . $class . " que ele não possui acesso.");
            return redirect("user/permissionNack");
        }
    }

    public function permissionNack() {
        $this->loadView("user/permission_nack");
    }

}

?>