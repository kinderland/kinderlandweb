<?php
require_once APPPATH . 'core/CK_Model.php';

class donation_model extends CK_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getDonationById($donationId) {
		$sql = "SELECT * FROM donation WHERE donation_id = ?";
		$resultSet = $this -> executeRow($this -> db, $sql, array(intval($donationId)));

		if ($resultSet)
			return $resultSet;
		Donation::createDonationObject($row);

		return null;
	}

	public function getDonationPortionsMax($donation) {
		$sql = "select * from payment_period where event_id in (select event_id from event_subscription where donation_id = ?) 
                and date_start <= ? and date_finish >= ?";
		$result = $this -> executeRow($this -> db, $sql, array($donation -> donation_id, $donation -> date_created, $donation -> date_created));

		if ($result)
			return $result -> portions;
		else
			return 1;
	}

	public function createDonation($userId, $totalPrice, $donationType) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "INSERT INTO donation(person_id, donated_value, donation_type, donation_status) 
                VALUES ($userId, $totalPrice, $donationType, 1)";
		$result = $this -> executeReturningId($this -> db, $sql);

		if ($result) {
			return $result;
		}
	}

	public function updateDonationStatus($donationId, $donationStatus) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "UPDATE donation SET donation_status = ? WHERE donation_id = ?";
		$result = $this -> execute($this -> db, $sql, array($donationStatus, intval($donationId)));

		if ($result) {
			$donation = getDonationById($donationId);
			if ($donation.isForAssociation()) {
				$this->sendMail($donation.getPersonId());
				
												// Cadastra sócio
			}
			return true;

		}

		return false;
	}

	public function userIsAlreadyAssociate($userId) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT * FROM associates WHERE person_id = ?";
		$resultSet = $this -> executeRow($this -> db, $sql, array(intval($userId)));

		if ($resultSet)
			return true;

		return false;
	}

	public function getDonationTypeMinimumPrice($donationType) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT minimum_price FROM donation_type WHERE donation_type = ?";
		$resultSet = $this -> executeRow($this -> db, $sql, array($donationType));

		if ($resultSet)
			return $resultSet -> minimum_price;

		return 0.00;
	}

	public function getDonationsByUserId($userId) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT * FROM donation_detailed WHERE person_id = ? ORDER BY date_created DESC";
		return $this -> executeRows($this -> db, $sql, array(intval($userId)));
	}

}
?>