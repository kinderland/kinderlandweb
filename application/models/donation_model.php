<?php

require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/donation.php';

class donation_model extends CK_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getDonationById($donationId) {
		$sql = "SELECT * FROM donation WHERE donation_id = ?";
		$resultSet = $this -> executeRow($this -> db, $sql, array(intval($donationId)));

		if ($resultSet)
			$donation = Donation::createDonationObject($resultSet);

		return $donation;
	}

	public function getDonationPortionsMax($donation) {
		$sql = "select * from payment_period where event_id in (select event_id from event_subscription where donation_id = ?)
                and date_start <= ? and date_finish >= ?";
		$result = $this -> executeRow($this -> db, $sql, array($donation -> getDonationId(), $donation -> getDateCreated(), $donation -> getDateCreated()));

		if ($result)
			return $result -> portions;
		else {
			if ($donation -> getDonationType() == 1) {
				return 6;
			} else {
				return 2;
			}
		}
	}

	public function createDonation($userId, $totalPrice, $donationType) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "INSERT INTO donation(person_id, donated_value, donation_type, donation_status)
                VALUES ($userId, $totalPrice, $donationType, 1)";

		if ($result) {
			return $result;
		}
	}

	public function countPayingAssociates() {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "Select count(distinct person_id) from donation d
				  WHERE d.donation_type = 2 AND date_part('year'::text, d.date_created) = date_part('year'::text, now()) AND d.donation_status = 2";
		$result = $this -> executeRow($this -> db, $sql);

		if ($result) {
			return $result -> count;
		}

	}

	public function updateDonationStatus($donationId, $donationStatus) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "UPDATE donation SET donation_status = ? WHERE donation_id = ?";
		$result = $this -> execute($this -> db, $sql, array($donationStatus, intval($donationId)));

		if ($result)
			return true;

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
		$sql = "SELECT * FROM donation_detailed WHERE donation_status like 'pago' AND person_id = ? ORDER BY date_created DESC";
		return $this -> executeRows($this -> db, $sql, array(intval($userId)));
	}

	public function getAllPendingTransactions() {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT * FROM donations_pending";
		$resultSet = $this -> executeRows($this -> db, $sql);
		$donations = array();
		foreach ($resultSet as $row) {
			$donations[] = Donation::createDonationObject($row);
		}
		return $donations;
	}

}
?>