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

	public function info($eventId, $error=false,$age_group=NULL,$nonsleeper=NULL,$gender=NULL){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		try{
			$this->Logger->info("Retrieving information about event with id: ". $eventId);
			$event = $this->event_model->getEventById($eventId);

			$subscriptions = $this->eventsubscription_model->getSubscriptionsForEventByUserId($this->session->userdata("user_id"), $eventId);
			$p = $this->eventsubscription_model->getEventPrices($eventId,"all");
			$price = $this->eventsubscription_model->getEventPrices($eventId);
			$totalPrice = 0.00;
			$subtotalPrice = 0.00;
			$discount = 0.00;
			$qtd = 0;
			$singlePrice;
			
			foreach($subscriptions as $sub){
				if($sub->subscription_status == 2){
					if($sub->age_group_id == 1){
						$singlePrice = $price->children_price;															
					} else if($sub->age_group_id == 2){
						$singlePrice = $price->middle_price;
					} else if($sub->age_group_id == 3){
						$singlePrice = $price->full_price;
					}
					
					$subtotalPrice += $singlePrice;
					
					if(!empty($sub->associate) && ($sub->associate === "t")){
						$discount += $singlePrice*$price->associate_discount;
						$singlePrice = $singlePrice - ($singlePrice*$price->associate_discount);					
					}
					
					$totalPrice += $singlePrice;
					$qtd++;
				}
			}
			
			$data['totalPrice'] = $totalPrice;
			$data['subtotalPrice'] = $subtotalPrice;
			$data['discount'] = $discount;
			$data['qtd'] = $qtd;
			$data['event'] = $event;
			$data['subscriptions'] = $subscriptions;
			$data['prices'] = $p;
			$data['price'] = $price;
			$data['age_groups'] = $this->eventsubscription_model->getAgeGroups();
			$data['user_id'] = $this->session->userdata("user_id");
			$data['user_associate'] = $this->personuser_model->isAssociate($this->session->userdata("user_id"));
			$data['people'] = $this->eventsubscription_model->getPeopleRelatedToUser($this->session->userdata("user_id"));
			$data['peoplejson'] = json_encode($data['people']);
			$data['age_group'] = $age_group; 
			$data['nonsleeper'] = $nonsleeper;
			$data['gender'] = $gender;
			$data['name'] = "";
			
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

			$result = $this->eventsubscription_model->createSubcription($event, $userId, $userId, SUSCRIPTION_STATUS_WAITING_PAYMENT);
			
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
			echo true;
		} catch (Exception $ex) {
			$this->generic_model->rollbackTransaction();
			$this->Logger->error("Failed to subscribe user on event");
			$this->info($eventId, true);
			echo false;
		}
	}
	
	public function checkVacancy(){
		$this->Logger->info("Starting VAGAS " . __METHOD__);
		
			$nonsleeper = $this -> input -> post('nonsleeper',TRUE);
			$gender = $this -> input -> post('gender',TRUE);
			$event_id = $this -> input -> post('event_id',TRUE);
			
			$event = $this -> event_model -> getEventById($event_id);
			
			$avaiable = null;
			
			if($nonsleeper == "true"){
				$avaiable = $event -> getCapacityNonSleeper();
			}
			else if($nonsleeper == "false") {
				if($gender == 'M'){
					$avaiable = $event -> getCapacityMale();
				}
				else if($gender == 'F'){
					$avaiable = $event -> getCapacityFemale();
				}
			}
			
			if($avaiable > 0){
				echo true;
				return;
			}
			else{
				echo false;
				return;
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
		$nonSleeper = (isset($_POST['nonsleeper']))? $_POST['nonsleeper']: 'false';

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

			$result = $this->eventsubscription_model->createSubcription($event, $userId, $personId, SUSCRIPTION_STATUS_WAITING_PAYMENT, $age_group_id, $isAssociate, $nonSleeper);
			
			if($result == true){			
				$this->generic_model->commitTransaction();
				$this->Logger->info("Person subscribed");
				$this->Logger->info("Loading event details page");
	
				$this->info($eventId);
			}
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
    
    public function toggleEnable($eventId){
    	$event = $this->event_model->getEventById($eventId);
		$payments = $this->event_model->getEventPaymentPeriods($event->getEventId());
		$event->setIsValid($payments);
		
        if($event->getIsValid())
            echo $this->event_model->toggleEventEnable($eventId);
        else
            echo "0";
		
    }
    
    public function token(){
    	$data = null;    	
    	
    	$this->loadView("event/token", $data);    	
    }
    
    public function validateToken(){
    	$token = $this -> input -> post('token',TRUE);
    	
    	$event_id = $this -> event_model -> getEventIdByToken($token);
    	
    	if($event_id)
    		return openEvent($event_id);
    	else {
    		echo false;
    		return false;
    	}   		
    	
    }
    
    public function openEvent($eventId, $error=false,$age_group=NULL,$nonsleeper=NULL,$gender=NULL){
    	$this->Logger->info("Starting " . __METHOD__);
    
    	if(!$this->checkSession())
    		redirect("login/index");
    
    	try{
    		$this->Logger->info("Retrieving information about event with id: ". $eventId);
    		$event = $this->event_model->getEventById($eventId);
    
    		// $subscriptions = $this->eventsubscription_model->getSubscriptionsForEventByUserId($this->session->userdata("user_id"), $eventId);
    		$subscriptions = null;
    		$p = $this->eventsubscription_model->getEventPrices($eventId,"all");
    		$price = $this->eventsubscription_model->getEventPrices($eventId);
    		$totalPrice = 0.00;
    		$subtotalPrice = 0.00;
    		$discount = 0.00;
    		$qtd = 0;
    		$singlePrice;
    			
    		foreach($subscriptions as $sub){
    			if($sub->subscription_status == 2){
    				if($sub->age_group_id == 1){
    					$singlePrice = $price->children_price;
    				} else if($sub->age_group_id == 2){
    					$singlePrice = $price->middle_price;
    				} else if($sub->age_group_id == 3){
    					$singlePrice = $price->full_price;
    				}
    					
    				$subtotalPrice += $singlePrice;
    					
    				if(!empty($sub->associate) && ($sub->associate === "t")){
    					$discount += $singlePrice*$price->associate_discount;
    					$singlePrice = $singlePrice - ($singlePrice*$price->associate_discount);
    				}
    					
    				$totalPrice += $singlePrice;
    				$qtd++;
    			}
    		}
    			
    		$data['totalPrice'] = $totalPrice;
    		$data['subtotalPrice'] = $subtotalPrice;
    		$data['discount'] = $discount;
    		$data['qtd'] = $qtd;
    		$data['event'] = $event;
    		$data['subscriptions'] = $subscriptions;
    		$data['prices'] = $p;
    		$data['price'] = $price;
    		$data['age_groups'] = $this->eventsubscription_model->getAgeGroups();
    		$data['user_id'] = $this->session->userdata("user_id");
    		$data['user_associate'] = $this->personuser_model->isAssociate($this->session->userdata("user_id"));
    		$data['people'] = $this->eventsubscription_model->getPeopleRelatedToUser($this->session->userdata("user_id"));
    		$data['peoplejson'] = json_encode($data['people']);
    		$data['age_group'] = $age_group;
    		$data['nonsleeper'] = $nonsleeper;
    		$data['gender'] = $gender;
    		$data['name'] = "";
    			
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

}

?>