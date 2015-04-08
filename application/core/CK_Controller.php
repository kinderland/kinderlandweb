<?php
include_once APPPATH . 'core/personuser.php';
include_once APPPATH . 'libraries/logger.php';

// Colonia Kinderland Controller -> CK_Controller
class CK_Controller extends CI_Controller {

	protected $pid;
	protected $Logger;

	public function __construct() {
		parent::__construct();
		$this -> pid = getmypid();
		$this -> setLogger();
	}

	public function __destruct() {
		if ($this -> Logger)
			$this -> Logger -> endTransaction();
	}

	public function sendPaymentConfirmationMail($donation, $payment) {
		if ($donation -> getDonationType() == DONATION_TYPE_ASSOCIATE) {
			$person = $this -> person_model -> getPersonById($donation -> getPersonId());
			$emailString = "Prezado (a)" . $person -> getFullname() . ", <br><br>" . "Sua doação para a Kinderland com a finalidade de se tornar sócio foi recebida com sucesso. <br><br>" . "Muito obrigado pela sua contribuição, ela é muito importante para nós.<br><br><br><br>" . "Diretoria da Associação Kinderland";
			$emailSubject = "[Kinderland] Grato pela doacao: " . $person -> getFullname();

			return $this -> sendMail($emailSubject,$emailString, $person);
		}
		else if ($donation -> getDonationType() == DONATION_TYPE_FREEDONATION) {
			$person = $this -> person_model -> getPersonById($donation -> getPersonId());
			$emailString = "Prezado (a)" . $person -> getFullname() . ", <br><br>" . "Sua doação para a Kinderland foi recebida com sucesso. <br><br>" . "Muito obrigado pela sua contribuição, ela é muito importante para nós.<br><br><br><br>" . "Diretoria da Associação Kinderland";
			$emailSubject = "[Kinderland] Grato pela doacao: " . $person -> getFullname();

			return $this -> sendMail($emailSubject,$emailString, $person);
		}else if($donation -> getDonationType() == DONATION_TYPE_SUBSCRIPTION){
			
		} 
		
	}

	protected function sendMail($subject,$content, $person) {
		$myMail = "testekinderland2015@gmail.com";
		$config = Array('protocol' => 'smtp', 'smtp_host' => 'ssl://smtp.gmail.com', 'smtp_port' => 465, 'smtp_user' => $myMail, 
		'smtp_pass' => 'testandoteste', 'mailtype' => 'html', 'charset' => mb_internal_encoding(), 'wordwrap' => TRUE);

		$this -> load -> library('email', $config);
		$this -> email -> from($myMail);
		$this -> email -> to($person -> getEmail());
		$this -> email -> set_newline("\r\n");
		$this -> email -> subject($subject);
		$this -> email -> message($content);
		if ($this -> email -> send()) {
			$this -> Logger -> info("Email enviado com sucesso para: " . $person -> getFullname()." com o assunto ".$subject);
			return TRUE;
		} else {
			$this -> Logger -> error("Problema ao enviar email para: " . $person -> getFullname(). " com o assunto ".$subject);
			return FALSE;
		}

	}

	private function setLogger() {
		$this -> config -> load('logger', true);
		$logPath = $this -> config -> item('log_path', 'logger');
		//$logFilename = strtolower(get_class($this));
		$logLevel = $this -> config -> item('log_level', 'logger');
		//$this->Logger = new Logger($logLevel, $logPath, $logFilename);
		$this -> Logger = new Logger($logLevel, $logPath, "kinderland");
		$this -> Logger -> startTransaction();
		$this -> Logger -> info('[ENVIRONMENT][' . strtoupper(ENVIRONMENT) . ']');
		$this -> Logger -> info("[PROCESS ID][{$this->pid}]");
	}

	public function loadView($viewName, $data = array()) {
		if ($this -> session -> userdata("fullname")) {
			$data['fullname'] = $this -> session -> userdata("fullname");
			$data['user_id'] = $this -> session -> userdata("user_id");
			$data['gender'] = $this -> session -> userdata("gender");
		}

		$output = $this -> load -> view('include/header', $data, true);
		$output .= $this -> load -> view($viewName, $data, true);
		$output .= $this -> load -> view('include/footer', $data, true);
		$this -> output -> set_output($output);
	}

	public function checkSession() {
		$this -> Logger -> info("Running: " . __METHOD__);
		//print_r($this->session->userdata('operator'));
		if (!$this -> session -> userdata('user_id') || !$this -> session -> userdata('fullname')) {
			$this -> Logger -> info("Session expired or doesnt exist");
			return false;
		}

		$this -> Logger -> info("Session ok - User " . $this -> session -> userdata('user_id'));
		return true;
	}

	public function denyAcess($methodName) {
		$this -> Logger -> warn("Usuário com id =" . $this -> session -> userdata("user_id") . " tentou se conectar ao methodo " . $methodName . " que ele não possui acesso.");
		return redirect("login/index");
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

}
?>