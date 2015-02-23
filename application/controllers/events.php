<?php 
require_once APPPATH . 'core/CK_Controller.php';
require_once APPPATH . 'core/event.php';
class Events extends CK_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('person_model');
		$this->load->model('generic_model');
		$this->load->model('personuser_model');
		$this->load->model('event_model');

		$this->person_model->setLogger($this->Logger);
		$this->generic_model->setLogger($this->Logger);
		$this->event_model->setLogger($this->Logger);
		$this->personuser_model->setLogger($this->Logger);
	}

	public function index(){
		$eventList = $this->event_model->getPublicOpenEvents();
		$data['events'] = $eventList;

		$this->loadView("event/home", $data);
	}

	public function info($eventId){
		$event = $this->event_model->getEventById($eventId);
		$data['event'] = $event;

		$this->loadView('event/info', $data);
	}

}

?>