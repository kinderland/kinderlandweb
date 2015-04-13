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
		$this->load->model('donation_model');
		$this->load->model('event_model');
		$this->load->model('eventsubscription_model');

		$this->person_model->setLogger($this->Logger);
		$this->generic_model->setLogger($this->Logger);
		$this->event_model->setLogger($this->Logger);
		$this->personuser_model->setLogger($this->Logger);
		$this->donation_model->setLogger($this->Logger);
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
			$price = $this->eventsubscription_model->getEventPrices($eventId);

			$data['event'] = $event;
			$data['subscriptions'] = $subscriptions;
			$data['price'] = $price;
			$data['age_groups'] = $this->eventsubscription_model->getAgeGroups();
			$data['user_id'] = $this->session->userdata("user_id");
			$data['user_associate'] = false;///true;//$this->personuser_model->isAssociate($this->session->userdata("user_id"));
			$data['people'] = $this->eventsubscription_model->getPeopleRelatedToUser($this->session->userdata("user_id"));
			$data['peoplejson'] = json_encode($data['people']);

			$this->Logger->debug("People json: ".$data['peoplejson']);

			$this->Logger->info("Loading screen");


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
			$data['age_group'] = $this->eventsubscription_model->getAgeGroups();
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

	public function unsubscribeUsers(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$eventId = $_POST['event_id'];
		$userIds = $_POST['user_ids'];

		$this->Logger->info("EventID: $eventId => List of user ids to unsubscribe: $userIds");

		try{
			$this->generic_model->startTransaction();

			$this->eventsubscription_model->unsubscribeUsersFromEvent($userIds, $eventId);

			$this->generic_model->commitTransaction();

			$this->info($eventId);
		} catch (Exception $ex) {
			$this->generic_model->rollbackTransaction();
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
		$age_group_id = $_POST['age_group'];
		$isAssociate = (isset($_POST['associate']))? $_POST['associate']: 'false';

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

			$this->eventsubscription_model->createSubcription($event, $userId, $personId, SUSCRIPTION_STATUS_WAITING_PAYMENT, $age_group_id, $isAssociate);
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

	public function checkoutSubscriptions(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$personIds  = $_POST['person_ids'];
		$userId 	= $this->session->userdata("user_id");//$_POST['user_id'];
		$eventId 	= $_POST['event_id'];

		try {
			$this->generic_model->startTransaction();

			$this->Logger->info("Getting subscriptions: ". $personIds);
			//Get subscriptions
			$subscriptions = $this->eventsubscription_model->getSubscriptions($userId, $eventId, $personIds);

			$this->Logger->info("Getting prices");
			//Get prices
			$prices = $this->eventsubscription_model->getEventPrices($eventId);
			if(!$prices)
				throw new Exception("Prices array not set, payment period probably expired");

			$this->Logger->info("Calculating price");
			//Evaluate price to donate
			$totalPrice = $this->eventsubscription_model->evaluateCheckoutValues($subscriptions, $prices);
			$this->Logger->info("=====> Price: " . print_r($totalPrice, true));

			$this->Logger->info("Creating donation");
			//Create donation
			$donationId = $this->donation_model->createDonation($userId, $totalPrice["total_price"], DONATION_TYPE_SUBSCRIPTION);
			$this->Logger->info("Created donation with id: ". $donationId);

			$this->Logger->info("Total of subscriptions to update: ". count($subscriptions));
			//Update subscriptions
			$this->eventsubscription_model->updateSubscriptionsDonationId($personIds, $userId, $eventId, $donationId);
			$this->Logger->info("Successfully updated");

			$this->generic_model->commitTransaction();

			//Redirect to checkout
			redirect("payments/checkout/".$donationId);
		} catch (Exception $ex) {
			$this->generic_model->rollbackTransaction();
			$this->Logger->error("Failed to proceed with checkout");
			$this->info($eventId, true);
		}


	}

	public function eventCreate(){
		$this->Logger->info("Starting " . __METHOD__);
		$data = array();
		$this->loadView('event/event_create', $data);
	}

	public function reportPanel(){
		$this->Logger->info("Starting " . __METHOD__);
		$data = array();
		$this->loadView('event/report_panel', $data);
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
		
	}*/

	public function completeEvent(){
		$this->Logger->info("Starting " . __METHOD__);

		$event_name = $this -> input -> post('event_name', TRUE);
		$description = $this -> input -> post('description', TRUE);
		$date_start = $this -> input -> post('date_start', TRUE);
		$date_finish = $this -> input -> post('date_finish', TRUE);
		$date_start_show = $this -> input -> post('date_start_show', TRUE);
		$date_finish_show = $this -> input -> post('date_finish_show', TRUE);
		$capacity_male = $this -> input -> post('capacity_male', TRUE);
		$capacity_female = $this -> input -> post('capacity_female', TRUE);
		$capacity_nonsleeper = $this -> input -> post('capacity_nonsleeper', TRUE);
		$payments = array();
		$payment_date_end = $this -> input -> post("payment_date_end", TRUE);		
		$payment_date_start = $this -> input -> post("payment_date_start", TRUE); 
		$full_price=$this -> input -> post("full_price", TRUE);
		$children_price=$this -> input -> post("children_price", TRUE);
		$middle_price=$this -> input -> post("middle_price", TRUE);
		$payment_portions=$this -> input -> post("payment_portions", TRUE);
		$associated_discount=$this -> input -> post("associated_discount", TRUE);
		
		if(is_array($full_price)){
			for($i=0;$i<count($full_price);$i++){
				$payments[] = array(
					"payment_date_start" => $payment_date_start[$i],
					"payment_date_end"=> $payment_date_end[$i],		
					"full_price"=>$full_price[$i],
					"children_price"=>$children_price[$i],
					"middle_price"=>$middle_price[$i],
					"payment_portions"=>$payment_portions[$i],
					"associated_discount"=>$associated_discount[$i]/100,			
				);
			}	
		} else if($full_price !== FALSE){
			$payments[] = array(
				"payment_date_start" => $payment_date_start,
				"payment_date_end"=> $payment_date_end,		
				"full_price"=>$full_price,
				"children_price"=>$children_price,
				"middle_price"=>$middle_price,
				"payment_portions"=>$payment_portions,
				"associated_discount"=>$associated_discount/100,			
			);			
		}
		
		try{
			$this->Logger->info("Inserting new event");
			$this->generic_model->startTransaction();
			
			$eventId = $this->event_model->insertNewEvent($event_name, $description, $date_start, $date_finish, 
				$date_start_show, $date_finish_show, "false", $capacity_male, $capacity_female,$capacity_nonsleeper);
			
			foreach($payments as $payment){
				$this->event_model->insertNewPaymentPeriod($eventId,$payment["payment_date_start"],$payment["payment_date_end"],$payment["full_price"],$payment["middle_price"],
				$payment["children_price"],$payment["associated_discount"],$payment["payment_portions"]);
			}
			
			$this->generic_model->commitTransaction();
			$this->Logger->info("New event successfully inserted");
			redirect("events/index");

		} catch (Exception $ex) {
			$this->Logger->error("Failed to insert new event");
			$this->generic_model->rollbackTransaction();
			$data['error'] = true;
			$this->loadView('event/event_create', $data);
		}
	}

    public function manageEvents() {
        $this -> Logger -> info("Starting " . __METHOD__);
        
        if (!$this -> checkSession())
            redirect("login/index");
        
        if (!$this -> checkPermition(array(COMMON_USER,SECRETARY, SYSTEM_ADMIN))) {
            $this -> denyAcess(___METHOD___);
        }
        
        $events = $this->event_model->getAllEvents();
        $data["events"] = $events;
        
        $this -> loadView("event/manage", $data);
    }

}

?>