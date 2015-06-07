<?php
require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/summercamp.php';

class summercamp_model extends CK_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getAllSummerCamps() {
		$sql = "SELECT * FROM summer_camp ORDER BY date_created DESC";
		$resultSet = $this -> executeRows($this -> db, $sql);

		$campArray = array();

		if ($resultSet)
			foreach ($resultSet as $row)
				$campArray[] = SummerCamp::createCampObject($row);

		return $campArray;
	}

	public function getAvailableSummerCamps() {
		$sql = "SELECT * FROM summer_camp where pre_subscriptions_enabled ORDER BY date_start_pre_subscriptions ASC";
		$resultSet = $this -> executeRows($this -> db, $sql);

		$campArray = array();

		if ($resultSet)
			foreach ($resultSet as $row)
				$campArray[] = SummerCamp::createCampObject($row);

		return $campArray;
	}

	public function getSummerCampById($id) {
		$sql = "SELECT * FROM summer_camp where summer_camp_id = ?";
		$resultSet = $this -> executeRow($this -> db, $sql, array($id));

		$camp = NULL;

		if ($resultSet)
			$camp = SummerCamp::createCampObject($resultSet);

		return $camp;
	}

	public function getSummerCampSubscriptionsOfUser($userId) {
		$sql = "Select * from summer_camp sc 
		join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id 
		join colonist c on scs.colonist_id = c.colonist_id 
		join person p on c.person_id = p.person_id
		join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status 
		where scs.person_user_id = ?";
		$resultSet = $this -> executeRows($this -> db, $sql, array($userId));

		$summerCampSubscription = NULL;

		if ($resultSet)
			foreach ($resultSet as $row)
				$summerCampSubscription[] = SummerCampSubscription::createSummerCampSubscriptionObject($row);

		return $summerCampSubscription;
	}

	public function insertNewCamp($camp) {
		$sql = "INSERT INTO summer_camp (
                    camp_name, 
                    date_start, 
                    date_finish, 
                    date_start_pre_subscriptions, 
                    date_finish_pre_subscriptions,
                    date_start_pre_subscriptions_associate, 
                    date_finish_pre_subscriptions_associate, 
                    description, 
                    pre_subscriptions_enabled, 
                    capacity_male, 
                    capacity_female
                ) VALUES (
                    ?,?,?,?,?,?,?,?," . (($camp -> isEnabled()) ? "true" : "false") . ",?,?
                )";

		$paramArray = array($camp -> getCampName(), $camp -> getDateStart(), $camp -> getDateFinish(), $camp -> getDateStartPre(), $camp -> getDateFinishPre(), $camp -> getDateStartPreAssociate(), $camp -> getDateFinishPreAssociate(), $camp -> getDescription(), intval($camp -> getCapacityMale()), intval($camp -> getCapacityFemale()));

		$campId = $this -> executeReturningId($this -> db, $sql, $paramArray);

		if ($campId)
			return $campId;

		throw new ModelException("Insert object in the database");

	}

	public function updateCampPreEnabled($campId, $enabled) {
		$sql = "UPDATE summer_camp SET pre_subscriptions_enabled = " . (($enabled) ? "true" : "false") . " WHERE summer_camp_id = ?";
		$result = $this -> execute($this -> db, $sql, array(intval($campId)));

		return $result;
	}

	public function subscribeColonist($summerCampId, $colonistId, $userId, $situation, $schoolName, $schoolYear) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'INSERT INTO summer_camp_subscription (summer_camp_id,colonist_id,person_user_id,situation,school_name,school_year) VALUES (?, ?, ?, ?,?,?)';
		$returnId = $this -> execute($this -> db, $sql, array($summerCampId, $colonistId, $userId, $situation, $schoolName, $schoolYear));
		if ($returnId)
			return TRUE;

		return FALSE;
	}

}
?>