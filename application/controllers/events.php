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
		$this->load->model('eventsubscription_model');

		$this->person_model->setLogger($this->Logger);
		$this->generic_model->setLogger($this->Logger);
		$this->event_model->setLogger($this->Logger);
		$this->personuser_model->setLogger($this->Logger);
		$this->eventsubscription_model->setLogger($this->Logger);
	}

	public function index(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$eventList = $this->event_model->getPublicOpenEvents();
		$data['events'] = $eventList;

		$this->loadView("event/home", $data);
	}

	public function info($eventId, $error=false){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		try{
			$this->Logger->info("Retrieving information about event with id: ". $eventId);
			$event = $this->event_model->getEventById($eventId);

			$subscriptions = $this->eventsubscription_model->getSubscriptionsForEventByUserId($this->session->userdata("user_id"), $eventId);

			$data['event'] = $event;
			$data['subscriptions'] = $subscriptions;
			$data['user_id'] = $this->session->userdata("user_id");
			
			if($error)
				$data['error'] = $error;

			$this->loadView('event/info', $data);
		} catch (Exception $ex) {
			$this->Logger->error("No event found with id: ". $eventId);
			$this->index();
		}
		
	}

	public function subscribeUser(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$eventId = $_POST['event_id'];
		$userId = $_POST['user_id'];

		try{
			$this->Logger->info("Subscribing user {$userId} on event {$eventId}");
			$event = $this->event_model->getEventById($eventId);

			$this->eventsubscription_model->createSubcription($event, $userId, $userId, SUSCRIPTION_STATUS_WAITING_PAYMENT);

			$this->info($eventId);
		} catch (Exception $ex) {
			$this->Logger->error("Failed to subscribe user on event");
			$this->info($eventId, true);
		}
	}

}

?>