<?php
require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/summercamp.php';
require_once APPPATH . 'core/summercampSubscription.php';

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

	public function getAvailableSummerCamps($isAssociate) {
		$associate = " ";
		if ($isAssociate)
			$associate = " or 
		(
			date_start_pre_subscriptions_associate <= now() and date_finish_pre_subscriptions_associate > now() 		
		)";
		$sql = "SELECT * FROM summer_camp where pre_subscriptions_enabled and 
		(
			date_start_pre_subscriptions <= now() and date_finish_pre_subscriptions > now() 
		) $associate ORDER BY date_start_pre_subscriptions ASC";
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
		where scs.person_user_id = ? order by p.fullname";
		$resultSet = $this -> executeRows($this -> db, $sql, array($userId));

		$summerCampSubscription = NULL;

		if ($resultSet)
			foreach ($resultSet as $row)
				$summerCampSubscription[] = SummerCampSubscription::createSummerCampSubscriptionObject($row);

		return $summerCampSubscription;
	}

	public function getSummerCampSubscription($colonistId, $summerCampId) {
		$sql = "Select * from summer_camp sc 
		join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id 
		join colonist c on scs.colonist_id = c.colonist_id 
		join person p on c.person_id = p.person_id
		join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status 
		where scs.colonist_id = ? and scs.summer_camp_id = ?";
		$resultSet = $this -> executeRow($this -> db, $sql, array($colonistId, $summerCampId));
		$summerCampSubscription = FALSE;

		if ($resultSet)
			$summerCampSubscription = SummerCampSubscription::createSummerCampSubscriptionObject($resultSet);

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

	public function editColonistSubscription($summerCampId, $colonistId, $schoolName, $schoolYear) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'UPDATE summer_camp_subscription SET school_name=?, school_year=? where summer_camp_id = ? and colonist_id = ? ';
		$returnId = $this -> execute($this -> db, $sql, array($schoolName, $schoolYear,intval($summerCampId),intval($colonistId)));
		if ($returnId)
			return TRUE;

		return FALSE;
	}


	public function addParentToSummerCampSubscripted($summerCampId, $colonistId, $parentId, $relation) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'INSERT INTO parent_summer_camp_subscription (summer_camp_id,colonist_id,parent_id,relation) VALUES (?, ?, ?, ?)';
		$returnId = $this -> execute($this -> db, $sql, array($summerCampId, $colonistId, $parentId, $relation));
		if ($returnId) {
			$this -> Logger -> info("Parente do colonista $colonistId e summer_camp_id = $summerCampId inserido com sucesso");
			return TRUE;
		}
		$this -> Logger -> error("Problema ao inserir parente do colonista $colonistId e summer_camp_id = $summerCampId");
		return FALSE;
	}

	public function removeParentFromSummerCampSubscripted($summerCampId, $colonistId, $relation) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'DELETE FROM parent_summer_camp_subscription where summer_camp_id = ? and colonist_id = ? and relation = ?';
		$returnId = $this -> execute($this -> db, $sql, array($summerCampId, $colonistId, $relation));
		if ($returnId) {
			return TRUE;
		}
		return FALSE;
	}


	public function getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, $relation) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'Select parent_id from parent_summer_camp_subscription where summer_camp_id = ? and colonist_id = ? and relation = ?';
		$row = $this -> executeRow($this -> db, $sql, array($summerCampId, $colonistId, $relation));
		if ($row) {
			return $row -> parent_id;
		} else {
			$this -> Logger -> info("Não encontrei parente do colonista $colonistId e summer_camp_id = $summerCampId com relação = $relation");
			return FALSE;
		}
	}

	public function uploadDocument($summerCampId, $colonistId, $userId, $fileName, $file, $type) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$splitByDot = explode(".", $fileName);
		$extension = $splitByDot[count($splitByDot) - 1];
		if ($extension != "jpg" && $extension != "jpeg" && $extension != "png" && $extension != "pdf")
			return FALSE;
		$sql = 'INSERT INTO document (summer_camp_id,colonist_id,user_id,filename,extension,document_type,file) VALUES (?, ?, ?, ?,?,?,?)';
		$returnId = $this -> execute($this -> db, $sql, array($summerCampId, $colonistId, $userId, $fileName, $extension, $type, pg_escape_bytea($file)));
		if ($returnId) {
			$this -> Logger -> info("Documento inserido com sucesso");
			return TRUE;
		}
		$this -> Logger -> error("Problema ao inserir documento");
		return FALSE;

	}

	public function getNewestDocument($camp_id, $colonist_id, $document_type) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'Select * from document where summer_camp_id = ? and colonist_id = ? and document_type = ? order by date_created desc';
		$resultSet = $this -> executeRows($this -> db, $sql, array($camp_id, $colonist_id, $document_type));

		$document = FALSE;

		if ($resultSet)
			foreach ($resultSet as $row) {
				$this -> Logger -> info("Documento encontrado com sucesso, criando array");
				$document = array("data" => $row -> file, "name" => $row -> filename);
				return $document;
			}
		$this -> Logger -> info("Nao achei o documento");
		return $document;
	}

	public function hasDocument($camp_id, $colonist_id, $document_type) {
		$this -> Logger -> info("Running: " . __METHOD__);

		if ($document_type != DOCUMENT_MEDICAL_FILE && $document_type != DOCUMENT_TRIP_AUTHORIZATION && $document_type != DOCUMENT_GENERAL_RULES) {

			$sql = 'Select * from document where summer_camp_id = ? and colonist_id = ? and document_type = ? order by date_created desc';
			$resultSet = $this -> executeRows($this -> db, $sql, array($camp_id, $colonist_id, $document_type));

			if ($resultSet)
				foreach ($resultSet as $row) {
					return TRUE;
				}
			return FALSE;
		} else if($document_type == DOCUMENT_MEDICAL_FILE) {
			$sql = "Select colonist_id from medical_file where summer_camp_id = ? and colonist_id = ?";
			$resultSet = $this -> executeRow($this -> db, $sql, array($camp_id, $colonist_id));
			if ($resultSet) 
				return TRUE;
			else
				return FALSE;
		} else {
			$column = "";
			if ($document_type == DOCUMENT_TRIP_AUTHORIZATION) {
				$column = "accepted_travel_terms";
			} else if ($document_type == DOCUMENT_GENERAL_RULES) {
				$column = "accepted_terms";
			}
			$sql = "Select $column from summer_camp_subscription where summer_camp_id = ? and colonist_id = ?";
			$resultSet = $this -> executeRow($this -> db, $sql, array($camp_id, $colonist_id));
			if ($resultSet) {
				if ($document_type == DOCUMENT_GENERAL_RULES && $resultSet -> accepted_terms === "t") {
					return TRUE;
				}
				if ($document_type == DOCUMENT_TRIP_AUTHORIZATION && $resultSet -> accepted_travel_terms === "t")
					return TRUE;
			}
			return FALSE;
		}
	}

	public function getAllColonistsBySummerCamp($status = null) {
		$sql = "Select sc.*, scs.*, c.*, p.*, pr.*, scss.*, 
		v.colonist_gender_ok, v.colonist_picture_ok, v.colonist_identity_ok, 
		v.colonist_parents_name_ok, v.colonist_birthday_ok, v.colonist_name_ok,
		v.colonist_gender_msg, v.colonist_picture_msg, v.colonist_identity_msg, 
		v.colonist_parents_name_msg, v.colonist_birthday_msg, v.colonist_name_msg,
		p.fullname as colonist_name, pr.fullname as user_name, p.person_id as person_colonist_id
		from summer_camp sc 
		join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id 
		join colonist c on scs.colonist_id = c.colonist_id 
		join person p on c.person_id = p.person_id
		join person pr on pr.person_id = scs.person_user_id
		join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status
		left join validation v on v.colonist_id = c.colonist_id and v.summer_camp_id = sc.summer_camp_id ";
		if ($status !== null) {
			$sql = $sql . " WHERE scs.situation in (" . $status . ")";
		}
		$resultSet = $this -> executeRows($this -> db, $sql);

		return $resultSet;
	}

	public function acceptGeneralRules($summerCampId, $colonistId) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'UPDATE summer_camp_subscription SET accepted_terms = true WHERE summer_camp_id = ? AND colonist_id = ?';
		$returnId = $this -> execute($this -> db, $sql, array(intval($summerCampId), intval($colonistId)));
		if ($returnId)
			return TRUE;

		return FALSE;

	}

	public function updateTripAuthorization($summerCampId, $colonistId,$value) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'UPDATE summer_camp_subscription SET accepted_travel_terms = ? WHERE summer_camp_id = ? AND colonist_id = ?';
		$returnId = $this -> execute($this -> db, $sql, array($value,intval($summerCampId), intval($colonistId)));
		if ($returnId)
			return TRUE;

		return FALSE;

	}

	public function updateColonistStatus($colonistId, $summerCampId, $status) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = 'UPDATE summer_camp_subscription SET situation = ? WHERE summer_camp_id = ? AND colonist_id = ?';
		$return = $this -> execute($this -> db, $sql, array($status, intval($summerCampId), intval($colonistId)));
		if ($return)
			return TRUE;

		return FALSE;
	}

	public function getStatusDescription($status) {
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT description FROM summer_camp_subscription_status WHERE status = ?";
		$resultSet = $this -> executeRow($this -> db, $sql, array($status));
		if ($resultSet)
			return $resultSet -> description;

		return "";
	}

	public function getColonistStatus($colonistId, $summerCampId){
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT situation FROM summer_camp_subscription WHERE colonist_id = ? AND summer_camp_id = ?" ;
		$resultSet = $this -> executeRow($this -> db, $sql, array($colonistId, $summerCampId));
		if ($resultSet)
			return $resultSet -> situation;

		return null;
	}

	public function getSchools(){
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "SELECT * FROM school" ;
		$resultSet = $this -> executeRows($this -> db, $sql);
		if ($resultSet){
			$schools = array();
			foreach ($resultSet as $row) {
				$schools[] = $row->school_name;
			}
			return $schools;
		}
		return null;
	}
	
	public function insertSchool($school){
		$this -> Logger -> info("Running: " . __METHOD__);
		$sql = "insert into school values (?)" ;
		$resultSet = $this -> execute($this -> db, $sql,array($school));
		if ($resultSet){
			return TRUE;
		}
		return FALSE;
	}


}
?>