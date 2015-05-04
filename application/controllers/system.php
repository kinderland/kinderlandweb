<?php 
require_once APPPATH . 'core/CK_Controller.php';
class System extends CK_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('person_model');
		$this->load->model('address_model');
		$this->load->model('generic_model');
		$this->load->model('telephone_model');
		$this->load->model('personuser_model');
		
		$this->person_model->setLogger($this->Logger);
		$this->address_model->setLogger($this->Logger);
		$this->generic_model->setLogger($this->Logger);
		$this->telephone_model->setLogger($this->Logger);
		$this->personuser_model->setLogger($this->Logger);
	}

	public function menu(){
		$this->Logger->info("Starting " . __METHOD__);
		$data['fullname'] = $this->session->userdata("fullname");
		$permissions = $this->session->userdata("user_types");

		$this->Logger->debug(print_r($data ,true));

		if(count($permissions) == 1){
			$this->redirectToSystemScreen($permissions[0]);
		} else {
			$data['permissions'] = $permissions;
			$this->loadView("system/menu", $data);
		}


	}

	private function redirectToSystemScreen($permission){
		$this->Logger->info("Starting " . __METHOD__);
		switch($permission){
			case COMMON_USER:
				redirect("user/menu");
				break;
			case SYSTEM_ADMIN:
				//TO DO LATER
				break;
			case DIRECTOR:
				redirect("user/director");
				break;
			case SECRETARY:
				//TO DO LATER
				break;
			case COORDINATOR:
				//TO DO LATER
				break;
			default:
				redirect("login/index?error=true");
				break;
		}
		return;
	}
}

?>