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

			$this->Logger->debug("Subscriptions: ".print_r($subscriptions, true));
			$this->Logger->debug("Count subscriptions = ". count($subscriptions));
			
			if($error)
				$data['error'] = $error;

			$this->loadView('event/info', $data);
		} catch (Exception $ex) {
			$this->Logger->error("No event found with id: ". $eventId);
			$this->index();
		}
		
	}

	public function subscribeNewPerson($eventId){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$userId = $this->session->userdata("user_id");

		try{
			$event = $this->event_model->getEventById($eventId);

			$data['event'] = $event;
			$data['user_id'] = $userId;
			$data['people'] = $this->eventsubscription_model->getPeopleRelatedToUser($userId);
			$data['peoplejson'] = json_encode($data['people']);

			$this->Logger->debug("People json: ".$data['peoplejson']);

			$this->Logger->info("Loading screen");
			$this->loadView("event/subscribe_person", $data);

		} catch (Exception $ex) {
			$this->Logger->error("Failed to open event subscription screen");
			$this->info($eventId, true);
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

	public function subscribePerson(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$eventId = $_POST['event_id'];
		$userId = $_POST['user_id'];
		$personId = (isset($_POST['person_id'])) ? $_POST['person_id'] : null;

		try{
			$this->generic_model->startTransaction();
			if($personId == null){
				$gender = $_POST['gender'];
				$fullname = $_POST['fullname'];
				$this->Logger->info("Subscribing new person.");
				$this->Logger->info("Inserting person in database");

				$personId = $this->person_model->insertPersonSimple($fullname, $gender);
				if(!$personId)
					throw new Exception("Failed to create person");
			} else {
				$this->Logger->info("The user to be subscribed is already registered as a person (id={$personId})");
			}

			$this->Logger->info("Subscribing person {$personId} on event {$eventId} under responsability of user {$userId}");
			$event = $this->event_model->getEventById($eventId);

			$this->eventsubscription_model->createSubcription($event, $userId, $personId, SUSCRIPTION_STATUS_WAITING_PAYMENT);
			$this->generic_model->commitTransaction();
			$this->Logger->info("Person subscribed");
			$this->Logger->info("Loading event details page");

			$this->info($eventId);
		} catch (Exception $ex) {
			$this->generic_model->rollbackTransaction();
			$this->Logger->error("Failed to subscribe person on event");
			$this->info($eventId, true);
		}
	}

}

?>