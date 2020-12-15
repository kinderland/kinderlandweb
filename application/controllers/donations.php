<?php 
require_once APPPATH . 'core/CK_Controller.php';

class Donations extends CK_Controller {

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

	public function associate(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$this->loadView("donations/associate", array());
	}

	public function freeDonation(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$data['minimumPrice'] = $this->donation_model->getDonationTypeMinimumPrice(DONATION_TYPE_FREEDONATION);
		$this->Logger->info("Donation Type: ". DONATION_TYPE_FREEDONATION ." - price R$ ". $data['minimumPrice']);

		$this->loadView("donations/freedonation", $data);
	}

	public function checkoutAssociate(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$userId = $this->session->userdata("user_id");

		try{
			if($this->donation_model->userIsAlreadyAssociate($userId)){
				$this->Logger->info("The user - $userId - is already an associate!");
				$this->Logger->info("Show screen telling the user is already an associate");
				$person = $this->person_model->getPersonById($userId);
				$data['gender'] = $person->getGender();
				$this->loadView("donations/already_associate", $data);
				return;
			}

			$this->generic_model->startTransaction();

			$associatePrice = $this->donation_model->getDonationTypeMinimumPrice(DONATION_TYPE_ASSOCIATE);
			$this->Logger->info("Donation Type: ". DONATION_TYPE_ASSOCIATE ." - price R$ ". $associatePrice);

			$donationId = $this->donation_model->createDonation($userId, $associatePrice, DONATION_TYPE_ASSOCIATE);
			$this->Logger->info("Created donation with id: ". $donationId);

			$this->generic_model->commitTransaction();

			redirect("payments/checkout/".$donationId);
		} catch (Exception $ex) {
			$this->generic_model->rollbackTransaction();
			$this->Logger->error("Failed to proceed with checkout");
			$this->associate();
		}
	}

	public function checkoutFreeDonation(){
		$this->Logger->info("Starting " . __METHOD__);

		if(!$this->checkSession())
			redirect("login/index");

		$donationValueString = $_POST['donation_value'];
		$userId = $this->session->userdata("user_id");
		$donationValue = floatval(str_replace(",",".",$donationValueString));

		$visitorName = $_POST['visitorname_value'];

		try{
			$this->generic_model->startTransaction();

			$this->Logger->info("Value to be donated: R$". $donationValue);

			$this->Logger->info("To be donated by: ". $visitorName);
			$this->Logger->info("donationId: ". $donationId);

			$donationId = $this->donation_model->createDonation($userId, $donationValue, DONATION_TYPE_FREEDONATION);
			$this->Logger->info("Created donation with id: ". $donationId);

			$this->generic_model->commitTransaction();

			redirect("payments/checkout/".$donationId);
		} catch (Exception $ex) {
			$this->generic_model->rollbackTransaction();
			$this->Logger->error("Failed to proceed with checkout");
			$this->associate();
		}
	}
}

?>