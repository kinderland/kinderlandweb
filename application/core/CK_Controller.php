<?php
include_once APPPATH.'core/personuser.php';
include_once APPPATH.'libraries/logger.php';

// Colonia Kinderland Controller -> CK_Controller
class CK_Controller extends CI_Controller{

	protected $pid;
    protected $Logger;

	public function __construct(){
		parent::__construct();
		$this->pid = getmypid();
        $this->setLogger();
	}

	public function __destruct() {
        if ($this->Logger) 
            $this->Logger->endTransaction(); 
    }

	private function setLogger(){
        $this->config->load('logger', true);
        $logPath = $this->config->item('log_path', 'logger');
        //$logFilename = strtolower(get_class($this));
        $logLevel = $this->config->item('log_level', 'logger');
        //$this->Logger = new Logger($logLevel, $logPath, $logFilename);
        $this->Logger = new Logger($logLevel, $logPath, "kinderland");
        $this->Logger->startTransaction();
        $this->Logger->info('[ENVIRONMENT]['.strtoupper(ENVIRONMENT).']');
        $this->Logger->info("[PROCESS ID][{$this->pid}]");
    }

	public function loadView($viewName, $data=array()){
		if($this->session->userdata("fullname")){
			$data['fullname'] = $this->session->userdata("fullname");
			$data['user_id'] = $this->session->userdata("user_id");
		}

		$output  = $this->load->view('include/header', $data, true);
		$output .= $this->load->view($viewName, $data, true);
		$output .= $this->load->view('include/footer', $data, true);
		$this->output->set_output($output);
	}

	public function checkSession(){
		$this->Logger->info("Running: ". __METHOD__);
		//print_r($this->session->userdata('operator'));
		if(!$this->session->userdata('user_id') || !$this->session->userdata('fullname')){
			$this->Logger->info("Session expired or doesnt exist");
			return false;
		}
		
		$this->Logger->info("Session ok - User ". $this->session->userdata('user_id'));
		return true;
	}
    
    public function denyAcess($methodName){
            $this->Logger->warn("Usuário com id =".$this->session->userdata("user_id")." tentou se conectar ao methodo ".$methodName." que ele não possui acesso.");    
            return redirect("login/index");
    }
    
    public function checkPermition($permitions = array() ){
        
        foreach($permitions as $permition){
            foreach($this->session->userdata('user_types') as $permitionUser){
                if($permition == $permitionUser)
                    return true;
            }
        }
        return false;
    }
}
?>