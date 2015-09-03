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
		
		if($donation -> getDonationType() == DONATION_TYPE_SUMMERCAMP_SUBSCRIPTION){
			$sql = "select * from summer_camp_payment_period where summer_camp_id in (select summer_camp_id from summer_camp_subscription where donation_id = ?)
                and date_start <= now() and date_finish >= now() order by portions desc";
			$result = $this -> executeRow($this -> db, $sql, array($donation -> getDonationId()));
			if ($result)
				return $result -> portions;
			else 
				return 1;
		} else{

			$sql = "select * from payment_period where event_id in (select event_id from event_subscription where donation_id = ?)
                and date_start <= ? and date_finish >= ?";
			$result = $this -> executeRow($this -> db, $sql, array($donation -> getDonationId(), $donation -> getDateCreated(), $donation -> getDateCreated()));
			
			if ($result)
				return $result -> portions;
			else {
				if ($donation -> getDonationType() == 1) {
					return 6;
				} else {
					return 1;
				}
			}
		}
	}

	public function createDonation($userId, $totalPrice, $donationType) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "INSERT INTO donation(person_id, donated_value, donation_type, donation_status)
                VALUES (?,?,?, 1)";
        $result = $this->executeReturningId($this->db, $sql,array($userId,$totalPrice,$donationType));

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

	public function sumPayingAssociates() {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "Select sum(donated_value) as sum from donation d
				  WHERE d.donation_type = 2 AND date_part('year'::text, d.date_created) = date_part('year'::text, now()) AND d.donation_status = 2";
		$result = $this -> executeRow($this -> db, $sql);

		if ($result) {
			return $result -> sum;
		}

	}

	public function sumDonationsColony() {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "Select sum(donated_value) as sum from donation d
				  WHERE d.donation_type = 4 AND date_part('year'::text, d.date_created) = date_part('year'::text, now()) AND d.donation_status = 2";
		$result = $this -> executeRow($this -> db, $sql);

		if ($result) {
			return $result -> sum;
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
		$sql = "SELECT * FROM donation_detailed WHERE (donation_status like 'pago' OR donation_status like 'estornado') AND person_id = ? ORDER BY date_created DESC";
		return $this -> executeRows($this -> db, $sql, array(intval($userId)));
	}

	public function countFreeDonations() {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT count(distinct donation_id) as contagem FROM donation_detailed WHERE donation_status like 'pago' and donation_type like 'avulsa'";
		return $this->executeRow($this -> db, $sql)-> contagem;
	}

	public function countDonationsColony() {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT count(distinct donation_id) as contagem FROM donation WHERE donation_status = ".DONATION_STATUS_PAID." and donation_type = ".DONATION_TYPE_SUMMERCAMP_SUBSCRIPTION;
		return $this->executeRow($this -> db, $sql)-> contagem;
	}

	public function sumFreeDonations() {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT sum(donated_value) as contagem FROM donation_detailed WHERE donation_status like 'pago' and donation_type like 'avulsa'";
		return $this->executeRow($this -> db, $sql)-> contagem;
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

	public function getDonationsDetailed($donationType=null, $mes=null, $ano=null){
		$sql = "SELECT * 
				FROM v_report_free_donations ";
		if($donationType != null || $mes != null || $ano != null) {
			$sql .= " WHERE ";

			if($donationType != null)
				$sql .= " donation_type = " .$donationType. " AND";

			if($ano != null)
				$sql .= " to_char(date_created, 'YYYY')::integer = " .$ano. " AND";

			if($mes != null)
				$sql .= " to_char(date_created, 'MM')::integer = " .$mes. " AND";

			$sql = substr($sql, 0, strlen($sql) -3);
		}

		$sql .= " ORDER BY date_created DESC";

		$resultSet = $this -> executeRows($this -> db, $sql);

		return $resultSet;
	}

	public function getTransactionAttemptFails($month=null, $year=null) {
		if($year == null){
			$year  = date('Y');
		}

		$year  = intval($year);

		$arrParam = array();
		$sql = "
			select d.donation_id, p.person_id, dt.description as donation_type, ps.description as payment_status, 
			ct.date_created, p.fullname
			from donation d
			inner join cielo_transaction ct on ct.donation_id = d.donation_id
			inner join person p on p.person_id = d.person_id
			inner join donation_type dt on dt.donation_type = d.donation_type
			inner join payment_status ps on ps.payment_status = ct.payment_status
			where ct.payment_status <> 6
			and to_char(ct.date_created, 'YYYY')::integer = ? 
			";
		$arrParam[] = $year;
		if($month != null){
			$sql .= " and to_char(ct.date_created, 'MM')::integer = ? ";
			$arrParam[] = intval($month);
		}
		$sql .= " 
			and (d.person_id, d.donation_type) not in (
				select distinct person_id, donation_type
				from donation d
				inner join cielo_transaction ct on ct.donation_id = d.donation_id
				where ct.payment_status = 6
				and to_char(ct.date_created, 'YYYY')::integer = ? ";

		$arrParam[] = $year;
		if($month != null){
			$sql .= " and to_char(ct.date_created, 'MM')::integer = ? ";
			$arrParam[] = intval($month);
		} 
		$sql .= ")";


		$resultSet = $this->executeRows($this->db, $sql, $arrParam);

		return $resultSet;
	}

}
?>