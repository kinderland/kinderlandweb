<?php
require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/payment_period.php';

class event_model extends CK_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getAllEvents() {
		$sql = "SELECT * FROM event order by date_start ASC";
		$resultSet = $this -> executeRows($this -> db, $sql);

		$eventArray = array();

		if ($resultSet)
			foreach ($resultSet as $row)
				$eventArray[] = Event::createEventObject($row);

		return $eventArray;
	}
	
	public function getAllEventsTokens() {
		$sql = "SELECT * FROM event_token";
		$resultSet = $this -> executeRows($this -> db, $sql);
	
		if($resultSet)
			return $resultSet;
		else 
			return null;
	}
	
	public function getEventTokenById($event_id) {
		$sql = "SELECT token FROM event_token WHERE event_id = ?";
		$resultSet = $this -> executeRow($this -> db, $sql, array(intval($event_id)));
	
		if($resultSet)
			return $resultSet;
		else
			return null;
	}

	public function getPublicOpenEvents() {
		$sql = "SELECT * FROM open_public_events ORDER BY date_start ASC";
		$resultSet = $this -> executeRows($this -> db, $sql);

		$eventArray = array();

		if ($resultSet)
			foreach ($resultSet as $row)
				$eventArray[] = Event::createEventObject($row);

		return $eventArray;
	}

	public function getEventById($eventId) {
		$sql = "SELECT * FROM event WHERE event_id=?";
		$resultSet = $this -> executeRow($this -> db, $sql, array(intval($eventId)));

		$sqlCapacity = "
            SELECT (select count(es.event_id) as male_vagas_ocupadas
            from person p
            left outer join event_subscription es
                on es.person_id = p.person_id
            where es.event_id = ? and es.subscription_status in (2,3)
                and p.gender = 'M'
                and es.nonsleeper = 'FALSE') as male_vagas_ocupadas,

            (select count(es.event_id) as female_vagas_ocupadas
            from person p
            left outer join event_subscription es
                on es.person_id = p.person_id
            where es.event_id = ? and es.subscription_status in (2,3)
                and p.gender = 'F'
                and es.nonsleeper = 'FALSE') as female_vagas_ocupadas,
            (select count(es.event_id) as nonsleeper_vagas_ocupadas
            from person p
            left outer join event_subscription es
                on es.person_id = p.person_id
            where es.event_id = ? and es.subscription_status in (2,3)
                and es.nonsleeper = 'TRUE') as nonsleeper_vagas_ocupadas
        ";

		$capacityResultSet = $this -> executeRow($this -> db, $sqlCapacity, array(intval($eventId), intval($eventId), intval($eventId)));

		$resultSet -> capacity_male = $resultSet -> capacity_male - $capacityResultSet -> male_vagas_ocupadas;
		$resultSet -> capacity_female = $resultSet -> capacity_female - $capacityResultSet -> female_vagas_ocupadas;
		$resultSet -> capacity_nonsleeper = $resultSet -> capacity_nonsleeper - $capacityResultSet -> nonsleeper_vagas_ocupadas;

		if ($resultSet)
			return Event::createEventObject($resultSet);

		return null;
	}
	
	public function getAllEventsPostDate($date){
		$sql = "SELECT * FROM event WHERE date_finish > ?
				ORDER BY date_finish ASC";		
		
		$resultSet = $this -> executeRows($this->db,$sql,array($date));
		
		if($resultSet)
			return $resultSet;
		else 
			return null;
	}
	
	public function getAllEventsByYear($year){
		$sql = "SELECT * FROM event WHERE DATE_PART('YEAR',date_finish) = ?
				ORDER BY date_finish ASC";
	
		$resultSet = $this -> executeRows($this->db,$sql,array($year));
	
		if($resultSet)
			return $resultSet;
		else
			return null;
	}
	
	public function getAllEventsYears() {
		$sql = "
            SELECT distinct(EXTRACT(YEAR FROM date_finish)) as anos
            FROM event
            ORDER BY anos DESC;";
	
		$resultSet = $this->executeRows($this->db, $sql);
	
		$yearsArray = array();
	
		if ($resultSet)
			foreach ($resultSet as $row)
				$yearsArray[] = $row->anos;
	
			return $yearsArray;
	}

	public function insertNewEvent($event_name, $description, $date_start, $date_finish, $date_start_show, $date_finish_show, $enabled, $capacity_male, $capacity_female, $capacity_nonsleeper, $type) {

		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'INSERT INTO event(event_name, description, date_created, date_start, date_finish, 
            date_start_show, date_finish_show, enabled, capacity_male, capacity_female,capacity_nonsleeper,type_id) VALUES (?,?, current_timestamp,?,?,?,?,?,?,?,?,?)';

		$returnId = $this -> executeReturningId($this -> db, $sql, array($event_name, $description, $date_start, $date_finish, $date_start_show, $date_finish_show, $enabled, $capacity_male, $capacity_female, $capacity_nonsleeper,intval($type)));

		if ($returnId)
			return $returnId;

		return false;
	}
	
	public function updateEvent($event_id, $event_name, $description, $date_start, $date_finish, $date_start_show, $date_finish_show, $enabled, $capacity_male, $capacity_female, $capacity_nonsleeper, $type) {
		$this -> Logger -> info("Running: " . __METHOD__);
		
		$sql = 'UPDATE event SET event_name = ?,  description = ?, date_start = ?, date_finish = ?, date_start_show = ?, date_finish_show = ?, enabled = ?, capacity_male = ?, capacity_female = ?, capacity_nonsleeper = ?, type_id = ?
				WHERE event_id = ?';
		
		$result = $this -> execute($this->db, $sql, array($event_name, $description, $date_start, $date_finish, $date_start_show, $date_finish_show, $enabled, $capacity_male, $capacity_female, $capacity_nonsleeper, intval($type), $event_id));
		
		return $result;
	}

	public function insertNewPaymentPeriod($eventId, $date_start, $date_finish, $full_price, $middle_price, $children_price, $associate_discount, $portions) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'INSERT INTO payment_period(event_id, date_start, date_finish, full_price, middle_price, 
            children_price, associate_discount, portions) VALUES (?,?,?,?,?,?,?,?)';

		$returnId = $this -> executeReturningId($this -> db, $sql, array($eventId, $date_start, $date_finish, $full_price, $middle_price, $children_price, $associate_discount, $portions, ));

		if ($returnId)
			return $returnId;

		return false;

	}
	
	public function insertToken($eventId,$token) {
		$this -> Logger -> info("Running: " . __METHOD__);
	
		$sql = 'INSERT INTO event_token(event_id, token) VALUES (?,?)';
	
		$returnId = $this -> executeReturningId($this -> db, $sql, array($eventId, $token));
	
		if ($returnId)
			return true;
	
		return null;
	
	}
	
	public function deleteToken($eventId){
		$this -> Logger -> info("Running: " . __METHOD__);
	
		$deleteSql = 'DELETE FROM event_token WHERE event_id = ?';
	
		return $this->execute($this->db, $deleteSql, array(intval($eventId)));
	}
	
	public function deleteEventPaymentPeriods($eventId){
		$this -> Logger -> info("Running: " . __METHOD__);
		
		$deleteSql = 'DELETE FROM payment_period WHERE event_id = ?';
		
		return $this->execute($this->db, $deleteSql, array(intval($eventId)));
	}

	public function getEventPaymentPeriods($eventId) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'Select * from payment_period where event_id = ?';

		$payment_periods = $this -> executeRows($this -> db, $sql, array($eventId));
		
		$retorno = array();
		
		foreach ($payment_periods as $payment_period) {
			$retorno[] = Payment_period::createPaymentPeriodObject($payment_period);
		}
		
		return $retorno;

	}

	public function toggleEventEnable($eventId) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'update event set enabled = NOT enabled where event_id = ?;';

		return $this -> execute($this -> db, $sql, array($eventId));

	}

	public function getDonationEvent($donationId) {
		$sql = "select e.* from event e 
            inner join event_subscription es
            on es.event_id = e.event_id
            where es.donation_id = ?";

		$resultSet = $this -> executeRows($this -> db, $sql, array(intval($donationId)));

		if ($resultSet)
			return Event::createEventObject($resultSet[0]);

		return null;

	}

}
?>