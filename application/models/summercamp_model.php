<?php

require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/summercamp.php';
require_once APPPATH . 'core/summercampSubscription.php';
require_once APPPATH . 'core/summerCampPaymentPeriod.php';

class summercamp_model extends CK_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getAllSummerCamps() {
        $sql = "SELECT * FROM summer_camp ORDER BY date_created DESC";
        $resultSet = $this->executeRows($this->db, $sql);

        $campArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);

        return $campArray;
    }

    public function getColonistInformationById($id) {
        $sql = "select c.colonist_id as colonist_id, scs.summer_camp_id as camp_id, p.gender as pavilhao, scs.room_number as room,
    			DATE_PART('YEAR',scs.date_created) as year, p.fullname as colonist_name from summer_camp_subscription scs INNER JOIN colonist c on
    			c.colonist_id = scs.colonist_id INNER JOIN person p on p.person_id = c.person_id
    			WHERE c.colonist_id = ?";
        $resultSet = $this->executeRow($this->db, $sql, array($id));

        return $resultSet;
    }

    public function getRoomQuantityForSummerCamp($campChosenId, $pavilhao){
        $sql = "Select count(distinct room_id) as num_quartos 
                from summer_camp_room 
                where summer_camp_id = ? and gender = ?";

        $resultSet = $this->executeRow($this->db, $sql, array($campChosenId,$pavilhao));

        return $resultSet->num_quartos;

    }

    public function getPersonUserIdByColonistId($colonist_id, $summercamp_id) {
        $sql = "SELECT person_user_id from summer_camp_subscription where colonist_id = ? and summer_camp_id = ?";

        $resultSet = $this->executeRow($this->db, $sql, array(intval($colonist_id), intval($summercamp_id)));

        if ($resultSet)
            return $resultSet;
        else
            return null;
    }

    public function getAllColonistsForDiscount($year) {
        $sql = "Select sc.*, scs.*, c.*, p.*, pr.*, scss.*,
        p.fullname as colonist_name, pr.fullname as user_name, p.person_id as person_colonist_id, dr.*
        from summer_camp sc
        join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
        left join discount_reason dr on scs.discount_reason_id = dr.discount_reason_id
        join colonist c on scs.colonist_id = c.colonist_id
        join person p on c.person_id = p.person_id
        join person pr on pr.person_id = scs.person_user_id
        join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status where scss.status >= 0 and DATE_PART('YEAR',sc.date_created) = ? order by pr.fullname,colonist_name";
        $resultSet = $this->executeRows($this->db, $sql, array($year));

        return $resultSet;
    }

    public function getAllSummerCampsWithDiscountsByYear($year) {
        $sql = "SELECT * FROM summer_camp
				WHERE summer_camp_id in (SELECT summer_camp_id FROM summer_camp_subscription WHERE discount > 0)
				AND DATE_PART('YEAR',date_created) = ?";

        $resultSet = $this->executeRows($this->db, $sql, array($year));

        $campArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);

        return $campArray;
    }

    public function getColonistsInformationWithDiscounts($year, $summercampId = null) {

        $sql = "SELECT * FROM v_discount WHERE year = ?";

        if ($summercampId != null) {
            $sql = $sql . " AND camp_id = ?";
            $resultSet = $this->executeRows($this->db, $sql, array($year, $summercampId));
        } else {
            $resultSet = $this->executeRows($this->db, $sql, array($year));
        }

        return $resultSet;
    }

    public function getCountSubscriptionsbyAssociated($year) {

        $sql = "SELECT p.person_id,
			    p.fullname,
			    p.date_created,
			    p.date_updated,
			    p.gender,
			    p.email,
			    p.address_id,
			    count(scs.colonist_id) AS total_inscritos
			   FROM associates a
			     JOIN person p ON p.person_id = a.person_id
			     LEFT JOIN summer_camp_subscription scs ON scs.person_user_id = a.person_id AND scs.summer_camp_id IN ( SELECT summer_camp.summer_camp_id
			           FROM summer_camp
			          WHERE DATE_PART('YEAR',summer_camp.date_created) =  ?)
			  GROUP BY p.person_id;";

        $rows = $this->executeRows($this->db, $sql, array(intval($year)));
        return $rows;
    }
    
    public function getTemporaryAssociatesByYear($year) {
    
    	$sql = "SELECT *
				FROM temporary_associates
				WHERE summercamp_year = ?";
    
    	$rows = $this->executeRows($this->db, $sql, array(strval($year)));
    	
    	$result = array();
    	
    	if($rows){
    		foreach($rows as $row){
    			$result[] = $row;
    		}
    		
    		return $result;
    	} else{
    		return null;
    	}
    }
    
    public function getCountSubscriptionsByTemporaryAssociates($userId, $year){
    	$sql = "SELECT distinct p1.person_id as responsable_id,p1.fullname as responsable_name, p1.email as responsable_email,
				p2.person_id as associate_id, p2.fullname as associate_name, (SELECT count(colonist_id)
											      FROM summer_camp_subscription
											      WHERE person_user_id = ?
											      AND DATE_PART('YEAR',date_created) = ?
											      AND situation in (0,1,2,3,4,6)) AS presubscription,
				
											      (SELECT count(colonist_id)
											      FROM summer_camp_subscription
											      WHERE person_user_id = ?
											      AND DATE_PART('YEAR',date_created) = ?
											      AND situation = 5) as subscription
				FROM person p1
				INNER JOIN summer_camp_subscription scs on scs.person_user_id = p1.person_id
				INNER JOIN temporary_associates ta on (ta.temporary_associate_id = p1.person_id)
				INNER JOIN person p2 on p2.person_id = ta.associate_id
				WHERE ta.summercamp_year = ?
				AND DATE_PART('YEAR',scs.date_created) = ?
				AND p1.person_id = ?";
    	
    	$row = $this->executeRow($this->db, $sql, array(intval($userId),intval($year),intval($userId),intval($year),strval($year),intval($year),intval($userId)));
    	
    	if($row)
    		return $row;
    	else 
    		return null;
    	
    }

    public function getAllSummerCampsByYear($year) {
        $sql = "SELECT * FROM summer_camp WHERE DATE_PART('YEAR',date_created) = ? ORDER BY date_created ASC";
        $resultSet = $this->executeRows($this->db, $sql, array(intval($year)));

        $campArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);

        return $campArray;
    }

    public function getAllSummerCampsYears() {
        $sql = "
            SELECT distinct(EXTRACT(YEAR FROM date_created)) as anos
            FROM summer_camp
            ORDER BY anos DESC;";

        $resultSet = $this->executeRows($this->db, $sql);

        $yearsArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $yearsArray[] = $row->anos;

        return $yearsArray;
    }


    public function getAllMiniCampsByYear($year) {
/*  aaa */
        $sql = "SELECT * FROM summer_camp WHERE DATE_PART('YEAR',date_created) = ? ORDER BY date_created ASC";
        $resultSet = $this->executeRows($this->db, $sql, array(intval($year)));

        $campArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);

        return $campArray;
    }

    public function getMiniCampsOrNotByYear($year, $minicamp) {
        $sql = "SELECT * FROM summer_camp
    			WHERE mini_camp " . (($minicamp != 0) ? "!" : "") . "= FALSE
    			AND DATE_PART('YEAR',date_created) = ?";

        $resultSet = $this->executeRows($this->db, $sql, array($year));

        $campArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);

        return $campArray;
    }

    public function getColonistsDetailedMultiplesSubscriptions($year) {

        $sql = "SELECT c1.colonist_id as colonist_id, p1.fullname as colonist_name, sc1.summer_camp_id as camp_id, sc1.camp_name as camp_name,
				pr.person_id as responsable_id, pr.fullname as responsable_name, scs1.situation as situation, scss1.description as situation_description, DATE_PART('YEAR',sc1.date_created) as year
				FROM person p1
				INNER JOIN colonist c1 on c1.person_id = p1.person_id
				INNER JOIN summer_camp_subscription scs1 on scs1.colonist_id = c1.colonist_id
				INNER JOIN summer_camp sc1 on sc1.summer_camp_id = scs1.summer_camp_id
				INNER JOIN summer_camp_subscription_status scss1 on scss1.status = scs1.situation
				INNER JOIN person pr on pr.person_id = scs1.person_user_id
				WHERE c1.colonist_id in (
						SELECT DISTINCT scs1.colonist_id FROM summer_camp sc1, summer_camp sc2, summer_camp_subscription scs1, summer_camp_subscription scs2, person p1, person p2, colonist c1, colonist c2
						WHERE c1.person_id= p1.person_id
						AND c2.person_id = p2.person_id
						AND c1.colonist_id = scs1.colonist_id
						AND c2.colonist_id = scs2.colonist_id
						AND scs1.summer_camp_id != scs2.summer_camp_id
						AND sc1.summer_camp_id = scs1.summer_camp_id
						AND sc2.summer_camp_id = scs2.summer_camp_id
						AND (UPPER(p1.fullname) = UPPER(p2.fullname) OR c1.document_number = c2.document_number)
						AND c1.colonist_id != c2.colonist_id
						AND DATE_PART('YEAR',sc1.date_created) = ?
						AND DATE_PART('YEAR',sc2.date_created) = ?)
        		AND DATE_PART('YEAR',sc1.date_created) = ?";

        $resultSet = $this->executeRows($this->db, $sql, array($year, $year,$year));

        return $resultSet;
    }

    /*
     * $associateType: 0 = Sócio; 1 = Não sócio; 2 = Todos
     */

    public function getAssociatedOrNotByStatusAndSummerCamp($summercampId, $associateType) {
        $sql = "SELECT distinct(vrauad.person_id), vrauad.fullname, scs.queue_number FROM v_report_all_users_association_detailed vrauad
				INNER JOIN summer_camp_subscription scs on scs.person_user_id = person_id
				WHERE scs.situation in ('2','3','4','5')
				AND scs.summer_camp_id in (" . $summercampId . ")";
        if ($associateType != 2)
            $sql .= " AND vrauad.associate " . (($associateType == 0) ? "!" : "") . "= 'não sócio'";

        $resultSet = $this->executeRows($this->db, $sql);

        if ($resultSet)
            return $resultSet;

        return array();
    }

    public function getAvailableSummerCamps($isAssociate) {
        $sql = "";
        if ($isAssociate) {
            $sql = "SELECT * FROM summer_camp where pre_subscriptions_enabled and
            (date_start_pre_subscriptions_associate <= now()
                and date_finish_pre_subscriptions_associate >= now())
            ORDER BY date_start_pre_subscriptions ASC, summer_camp_id ASC";
        } else {
            $sql = "SELECT * FROM summer_camp where pre_subscriptions_enabled and
            (date_start_pre_subscriptions <= now() and date_finish_pre_subscriptions >= now())
            ORDER BY date_start_pre_subscriptions ASC, summer_camp_id ASC";
        }

        $resultSet = $this->executeRows($this->db, $sql);

        $campArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);

        return $campArray;
    }

    public function getColonistsAgeAndSchoolYearBySummerCampAndGender($summercampId, $gender) {

        $sql = "SELECT scs.situation as situation, scss.description as situation_description,scs.summer_camp_id as camp_id, c.colonist_id as colonist_id, p.fullname as colonist_name, age(c.birth_date) as age, scs.school_year as school_year
				FROM colonist c INNER JOIN summer_camp_subscription scs on scs.colonist_id = c.colonist_id
				INNER JOIN person p on c.person_id = p.person_id
				INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
				WHERE scs.situation in ('5','4') AND scs.summer_camp_id = ? AND p.gender = ?";

        $resultSet = $this->executeRows($this->db, $sql, array($summercampId, $gender));

        return $resultSet;
    }

    public function getSummerCampById($id) {
        $sql = "SELECT * FROM summer_camp where summer_camp_id = ?";
        $resultSet = $this->executeRow($this->db, $sql, array($id));

        $camp = NULL;

        if ($resultSet)
            $camp = SummerCamp::createCampObject($resultSet);

        return $camp;
    }

    public function updateCamp($camp_id, $camp_name, $date_start, $date_finish, $date_start_pre_associate, $date_finish_pre_associate, $date_start_pre, $date_finish_pre, $capacity_male, $capacity_female, $mini_camp, $schooling_description) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'UPDATE summer_camp SET camp_name = ?, date_start = ?, date_finish = ?, date_start_pre_subscriptions = ?, date_finish_pre_subscriptions = ?, 
    			date_start_pre_subscriptions_associate = ?, date_finish_pre_subscriptions_associate =?,  capacity_male = ?, capacity_female = ?, mini_camp = ? , schooling_description = ?
				WHERE summer_camp_id = ?';

        $result = $this->execute($this->db, $sql, array($camp_name, $date_start, $date_finish, $date_start_pre, $date_finish_pre,
            $date_start_pre_associate, $date_finish_pre_associate, $capacity_male, $capacity_female, $mini_camp, $schooling_description, $camp_id));

        return $result;
    }
    
    public function changeCamp($colonistId,$campId,$newCampId) {
    	$this->Logger->info("Running: " . __METHOD__);
    	
//    	$oldCamp = $this->getSummerCampById($campId);
    	
//    	$number = explode(" ",$oldCamp->getCampName());
    	
//    	if($number[0] == "1a")
//    		$campNumber = 2;
//    	else
//    		$campNumber = 1;

        if($newCampId == "1a")
            $campNumber = 1;
    	else 
            if($newCampId == "2a")
                $campNumber = 2;
            else
                $campNumber = 3;

    	$sql = "select * 
    			from summer_camp 
    			where camp_name like '%?a%' 
    			and date_part('year',date_created) = ".date("Y");
    	
    	$result = $this->executeRow($this->db, $sql, array($campNumber));
    	
    	if($result)
    		$newCamp = $result;
    	else 
    		return false;
    		
    	$oldSubs = $this->getSummerCampSubscription($colonistId,$campId);
    	
    	$sql = 'INSERT INTO summer_camp_subscription (summer_camp_id,colonist_id,person_user_id,situation,school_name,school_year,accepted_terms,accepted_travel_terms,roommate1,roommate2,roommate3,special_care, special_care_obs) VALUES (?, ?, ?, ?,?,?,?,?,?,?,?,?,?)';
    	$returnId = $this->execute($this->db, $sql, array($newCamp->summer_camp_id, $colonistId, $oldSubs->getPersonUserId(), $oldSubs->getSituationId(), $oldSubs->getSchool(), $oldSubs->getSchoolYear(),$oldSubs->getAcceptedTerms(), $oldSubs->getAcceptedTravelTerms(), $oldSubs->getRoommate1(), $oldSubs->getRoommate2(), $oldSubs->getRoommate3(), $oldSubs->getSpecialCare(), $oldSubs->getSpecialCareObs()));
    	
    	if(!$returnId)
    		return false;
    		
    	//MUDANDO A TABELA PARENT_SUMMER_CAMP_SUBSCRIPTION
    	
    	$sql = "select * from parent_summer_camp_subscription 
				where summer_camp_id = ?
				and colonist_id = ?";
    	
    	$result = $this->executeRows($this->db, $sql, array(intval($campId),intval($colonistId)));
    	
    	if($result){
    		$sql = "UPDATE parent_summer_camp_subscription SET summer_camp_id = ?
					WHERE summer_camp_id = ?
					AND colonist_id = ?";
    		
    		$result = $this->execute($this->db, $sql, array(intval($newCamp->summer_camp_id),intval($campId),intval($colonistId)));
    		
    		if(!$result)
    			return false;
    	
    	}
    	
    	//MUDANDO A TABELA DOCUMENT
    	
    	$sql = "select * from document
				where summer_camp_id = ?
				and colonist_id = ?";
    	 
    	$result = $this->executeRows($this->db, $sql, array(intval($campId),intval($colonistId)));
    	 
    	if($result){
    		$sql = "UPDATE document SET summer_camp_id = ?
					WHERE summer_camp_id = ?
					AND colonist_id = ?";
    	
    		$result = $this->execute($this->db, $sql, array(intval($newCamp->summer_camp_id),intval($campId),intval($colonistId)));
    		
    		if(!$result)
    			return false;
    	
    	}
    	
    	//MUDANDO A TABELA MEDICAL_FILE
    	 
    	$sql = "select * from medical_file
				where summer_camp_id = ?
				and colonist_id = ?";
    	
    	$result = $this->executeRows($this->db, $sql, array(intval($campId),intval($colonistId)));
    	
    	if($result){
    		$sql = "UPDATE medical_file SET summer_camp_id = ?
					WHERE summer_camp_id = ?
					AND colonist_id = ?";
    		 
    		$result = $this->execute($this->db, $sql, array(intval($newCamp->summer_camp_id),intval($campId),intval($colonistId)));
    		
    		if(!$result)
    			return false;
    	
    	}
    	
    	//MUDANDO A TABELA SUMMER_CAMP_OLD_SUBSCRIPTION
    	 
    	$sql = "select * from summer_camp_old_subscription
				where summer_camp_id = ?
				and colonist_id = ?";
    	
    	$result = $this->executeRows($this->db, $sql, array(intval($campId),intval($colonistId)));
    	
    	if($result){
    		$sql = "UPDATE summer_camp_old_subscription SET summer_camp_id = ?
					WHERE summer_camp_id = ?
					AND colonist_id = ?";
    		 
    		$result = $this->execute($this->db, $sql, array(intval($newCamp->summer_camp_id),intval($campId),intval($colonistId)));
    		
    		if(!$result)
    			return false;
    	}
    	
    	//MUDANDO A TABELA VALIDATION
    	
    	$sql = "select * from validation
				where summer_camp_id = ?
				and colonist_id = ?";
    	 
    	$result = $this->executeRows($this->db, $sql, array(intval($campId),intval($colonistId)));
    	 
    	if($result){
    		$sql = "UPDATE validation SET summer_camp_id = ?
					WHERE summer_camp_id = ?
					AND colonist_id = ?";
    		 
    		$result = $this->execute($this->db, $sql, array(intval($newCamp->summer_camp_id),intval($campId),intval($colonistId)));
    	
    		if(!$result)
    			return false;
    	}
    	
    	//DELETANDO A INSCRIÇÃO ANTIGA
    	 
    	$sql = "delete from summer_camp_subscription
				where summer_camp_id = ?
				and colonist_id = ?";
    	
    	$result = $this->execute($this->db, $sql, array(intval($campId),intval($colonistId)));
    	  	
    	if($result)
    		return true;
    	else 
    		return false;
    	
    
    }
    
    public function getOldSubscriptionByUserId($userId){
    	
    	
    	$year = date("Y",strtotime("-1 year"));
    	
    	while(!isset($resultSet) && $year != '2014'){
    	
	    	$sql = "Select * 
					from summer_camp_subscription scs
					where scs.person_user_id = ?
					AND DATE_PART('YEAR',date_created) = ?
	    			AND situation not in (-1,-2,-3,0,1,6)
	    			AND colonist_id not in(
	    			SELECT colonist_id
	    			FROM summer_camp_subscription
	    			WHERE date_part('year',now()) = date_part('year',date_created))";
	    	
	    	$resultSet = $this->executeRows($this->db, $sql, array(intval($userId),$year));
	    	
	    	$year = date("Y",strtotime("-1 year",strtotime($year)));
    	}
    	
    	$r = array();
    	
    	if($resultSet){
    		foreach($resultSet as $row){
    			$r[] = $row;
    		}
    		
    		return $r;
    	}else 
    		return NULL;
    	
    }
    
    public function getOldSubscriptionByUserIdAndColonistIdAndInsertNew($userId, $colonistId,$summercampId){
    	 
    	 $sql = "Select *
					from summer_camp_subscription scs
					where scs.person_user_id = ?
					AND scs.colonist_id = ?
    	 			AND scs.date_created in(
    	 				Select max(scs.date_created)
						from summer_camp_subscription scs
						where scs.person_user_id = ?
						AND scs.colonist_id = ?)";
    
    		$resultSet = $this->executeRow($this->db, $sql, array(intval($userId),intval($colonistId),intval($userId),intval($colonistId)));
        	 
    	if($resultSet){
    		if($this->subscribeColonist($summercampId, $colonistId, $userId, 0, $resultSet->school_name, $resultSet->school_year, $resultSet->roommate1, $resultSet->roommate2, $resultSet->roommate3, $resultSet->special_care, $resultSet->special_care_obs)){
    			
    			$sql = "INSERT INTO summer_camp_old_subscription(summer_camp_id,colonist_id) VALUES (?,?)";
    			
    			$this->execute($this->db,$sql,array(intval($summercampId),intval($colonistId)));
    			
    			$medicalFile = $this->medical_file_model->getMedicalFile($resultSet->summer_camp_id, $colonistId);
    			
    			$this->medical_file_model->insertNewMedicalFile($summercampId, $colonistId, $medicalFile->getBloodType(), $medicalFile->getRH(), $medicalFile->getWeight(), $medicalFile->getHeight(), $medicalFile->getPhysicalActivityRestriction(),
    					$medicalFile->getVacineTetanus(), $medicalFile->getVacineMMR(), $medicalFile->getVacineHepatitis(), $medicalFile->getVacineYellowFever, $medicalFile->getInfectoContagiousAntecedents(), $medicalFile->getRegularUseMedicine(),
    					$medicalFile->getMedicineRestrictions(), $medicalFile->getAllergies(), $medicalFile->getAnalgesicAntipyretic(), $medicalFile->getDoctorId(), $medicalFile->getSpecialCareMedical, $medicalFile->getPsychMedication);
    			
    			$document = $this->getNewestDocument($resultSet->summer_camp_id, $colonistId, 3);
    			if($document){
    				$sql = "INSERT INTO document (summer_camp_id,colonist_id,date_created,user_id,filename,extension,document_type,file)
    						VALUES (?,?,now(),(SELECT distinct user_id FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 3    				
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 3)),(SELECT distinct filename FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 3
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 3)),(SELECT distinct extension FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 3
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 3)),(SELECT distinct document_type FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 3
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 3)),(SELECT distinct file FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 3
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 3)))";
    				$resultSetT = $this->execute($this->db, $sql, array(intval($summercampId),intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId),intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId),intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId),intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId)));
    				
    			}
 /* Nao vamos mais recuperar foto 3x4  
    			$document = $this->getNewestDocument($resultSet->summer_camp_id, $colonistId, 5);
    			if($document){
    				$sql = "INSERT INTO document (summer_camp_id,colonist_id,date_created,user_id,filename,extension,document_type,file)
    						VALUES (?,?,now(),(SELECT distinct user_id FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 5    				
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 5)),(SELECT distinct filename FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 5
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 5)),(SELECT distinct extension FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 5
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 5)),(SELECT distinct document_type FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 5
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 5)),(SELECT distinct file FROM document WHERE summer_camp_id = ? 
							AND colonist_id = ?
    						AND document_type = 5
    						AND date_created in
    						(SELECT max(date_created)
    						 FROM document
    						 WHERE summer_camp_id = ? 
						 AND colonist_id = ?
    						 AND document_type = 5)))";
    				$resultSetT = $this->execute($this->db, $sql, array(intval($summercampId),intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId),intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId),intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId),intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId), intval($resultSet->summer_camp_id), intval($colonistId)));
    				
    			}
*/    			
    			return true;
    		}
    		
    	}else
    		return NULL;
    	 
    }

    public function getSummerCampSubscriptionsOfUser($userId) {
        $sql = "Select * from summer_camp sc
		join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		join colonist c on scs.colonist_id = c.colonist_id
		join person p on c.person_id = p.person_id
		join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status
		where scs.person_user_id = ? 
        AND DATE_PART('YEAR',scs.date_created) = DATE_PART('YEAR',now())
        order by p.fullname";
        $resultSet = $this->executeRowsNoLog($this->db, $sql, array($userId));

        $summerCampSubscription = NULL;

        if ($resultSet)
            foreach ($resultSet as $row)
                $summerCampSubscription[] = SummerCampSubscription::createSummerCampSubscriptionObject($row);

        return $summerCampSubscription;
    }
    
    public function getSummerCampSubscriptionsOfUserByYear($userId,$year) {
    	$sql = "Select * from summer_camp sc
		join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		join colonist c on scs.colonist_id = c.colonist_id
		join person p on c.person_id = p.person_id
		join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status
		where scs.person_user_id = ?
        AND DATE_PART('YEAR',scs.date_created) = ?
        order by p.fullname";
    	$resultSet = $this->executeRowsNoLog($this->db, $sql, array($userId,$year));
    
    	$summerCampSubscription = NULL;
    
    	if ($resultSet)
    		foreach ($resultSet as $row)
    			$summerCampSubscription[] = SummerCampSubscription::createSummerCampSubscriptionObject($row);
    
    		return $summerCampSubscription;
    }
    
    public function hasValidSubscription($userId) {
    	$sql = "Select * from summer_camp_subscription
				where person_user_id = ?
				AND DATE_PART('YEAR',date_created) = DATE_PART('YEAR',now())
				AND situation not in(-1,-2,-3)";
    	$resultSet = $this->executeRowsNoLog($this->db, $sql, array(intval($userId)));
    
    	if($resultSet)
    		return true;
    	else 
    		return false;
    }
    
    public function temporaryHasSubscription($userId){
    	$sql = "Select * from summer_camp_subscription scs
				inner join temporary_associates ta on ta.temporary_associate_id = scs.person_user_id
				where ta.associate_id = ?
				AND DATE_PART('YEAR',date_created) = DATE_PART('YEAR',now())
				AND situation not in(-1,-2,-3)";
    	$resultSet = $this->executeRowsNoLog($this->db, $sql, array(intval($userId)));
    	
    	if($resultSet)
    		return true;
    	else
    		return false;
    }
    
    public function isTemporaryAssociate($userId,$year){
    	$sql = "Select * from temporary_associates 
				where temporary_associate_id = ?
				AND summercamp_year = ?";
    	
    	$resultSet = $this->executeRow($this->db, $sql, array(intval($userId),strval($year)));
    	 
    	if($resultSet)
    		return true;
    	else
    		return false;
    }
    
    public function getInfoAboutAssociateWithTemporaryAssociate($temporaryAssociateId,$year){
    	$sql = "SELECT *
				FROM temporary_associates ta
				INNER JOIN person p on p.person_id = ta.associate_id
				WHERE summercamp_year = ?
				AND temporary_associate_id = ?";
    	 
    	$resultSet = $this->executeRow($this->db, $sql, array(strval($year),intval($temporaryAssociateId)));
    
    	if($resultSet)
    		return $resultSet;
    	else
    		return null;
    }
    
    public function getSummerCampSubscription($colonistId, $summerCampId) {
        $sql = "Select * from summer_camp sc
		join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		join colonist c on scs.colonist_id = c.colonist_id
		join person p on c.person_id = p.person_id
		join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status
		where scs.colonist_id = ? and scs.summer_camp_id = ?";
        $resultSet = $this->executeRow($this->db, $sql, array($colonistId, $summerCampId));
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
                    capacity_female,
                    mini_camp,
                    schooling_description
                ) VALUES (
                    ?,?,?,?,?,?,?,?," . (($camp->isEnabled()) ? "true" : "false") . ",?,?," . (($camp->isMiniCamp()) ? "true" : "false") . ",?
                )";

        $paramArray = array($camp->getCampName(), $camp->getDateStart(), $camp->getDateFinish(), $camp->getDateStartPre(), $camp->getDateFinishPre(), $camp->getDateStartPreAssociate(), $camp->getDateFinishPreAssociate(), $camp->getDescription(), intval($camp->getCapacityMale()), intval($camp->getCapacityFemale()), $camp->getSchoolingDescription());

        $campId = $this->executeReturningId($this->db, $sql, $paramArray);

        if ($campId)
            return $campId;

        throw new ModelException("Insert object in the database");
    }

    public function updateCampPreEnabled($campId) {
    	
        $sql = "UPDATE summer_camp SET pre_subscriptions_enabled = NOT pre_subscriptions_enabled WHERE summer_camp_id = ?";
        $result = $this->execute($this->db, $sql, array(intval($campId)));

        return $result;
    }
    
    public function updateEditFriendsEnabled($campId) {
    	 
    	$sql = "UPDATE summer_camp SET edit_friends_enabled = NOT edit_friends_enabled WHERE summer_camp_id = ?";
    	$result = $this->execute($this->db, $sql, array(intval($campId)));
    
    	return $result;
    }

    public function subscribeColonist($summerCampId, $colonistId, $userId, $situation, $schoolName, $schoolYear, $roommate1, $roommate2, $roommate3, $specialCare, $specialCareObs) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = 'INSERT INTO summer_camp_subscription (summer_camp_id,colonist_id,person_user_id,situation,school_name,school_year,roommate1,roommate2,roommate3, special_care, special_care_obs) VALUES (?, ?, ?, ?,?,?,?,?,?,?,?)';
        $returnId = $this->execute($this->db, $sql, array($summerCampId, $colonistId, $userId, $situation, $schoolName, $schoolYear, $roommate1, $roommate2, $roommate3, $specialCare, $specialCareObs));
        if ($returnId)
            return TRUE;

        return FALSE;
    }

    public function editColonistSubscription($summerCampId, $colonistId, $schoolName, $schoolYear, $roommate1, $roommate2, $roommate3, $specialCare, $specialCareObs) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'UPDATE summer_camp_subscription SET school_name=?, school_year=?, roommate1=?, roommate2=?, roommate3=?, special_care = ?, special_care_obs=? where summer_camp_id = ? and colonist_id = ? ';
        $returnId = $this->execute($this->db, $sql, array($schoolName, $schoolYear, $roommate1, $roommate2, $roommate3, $specialCare, $specialCareObs, intval($summerCampId), intval($colonistId)));
        if ($returnId)
            return TRUE;

        return FALSE;
    }

    public function addParentToSummerCampSubscripted($summerCampId, $colonistId, $parentId, $relation) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'INSERT INTO parent_summer_camp_subscription (summer_camp_id,colonist_id,parent_id,relation) VALUES (?, ?, ?, ?)';
        $returnId = $this->execute($this->db, $sql, array($summerCampId, $colonistId, $parentId, $relation));
        if ($returnId) {
            $this->Logger->info("Parente do colonista $colonistId e summer_camp_id = $summerCampId inserido com sucesso");
            return TRUE;
        }
        $this->Logger->error("Problema ao inserir parente do colonista $colonistId e summer_camp_id = $summerCampId");
        return FALSE;
    }

    public function removeParentFromSummerCampSubscripted($summerCampId, $colonistId, $relation) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'DELETE FROM parent_summer_camp_subscription where summer_camp_id = ? and colonist_id = ? and relation = ?';
        $returnId = $this->execute($this->db, $sql, array($summerCampId, $colonistId, $relation));
        if ($returnId) {
            return TRUE;
        }
        return FALSE;
    }

    public function getParentIdOfSummerCampSubscripted($summerCampId, $colonistId, $relation) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'Select parent_id from parent_summer_camp_subscription where summer_camp_id = ? and colonist_id = ? and relation = ?';
        $row = $this->executeRow($this->db, $sql, array($summerCampId, $colonistId, $relation));
        if ($row) {
            return $row->parent_id;
        } else {
            $this->Logger->info("Não encontrei parente do colonista $colonistId e summer_camp_id = $summerCampId com relação = $relation");
            return FALSE;
        }
    }

    public function uploadDocument($summerCampId, $colonistId, $userId, $fileName, $file, $type) {
        $this->Logger->info("Running: " . __METHOD__);

        $splitByDot = explode(".", $fileName);
        $extension = $splitByDot[count($splitByDot) - 1];
        if (!
                (strcasecmp("jpg", $extension) == 0 || strcasecmp("jpeg", $extension) == 0 || strcasecmp("png", $extension) == 0 || strcasecmp("pdf", $extension) == 0)
        )
            return FALSE;
        $sql = 'INSERT INTO document (summer_camp_id,colonist_id,user_id,filename,extension,document_type,file) VALUES (?, ?, ?, ?,?,?,?)';
        $returnId = $this->execute($this->db, $sql, array($summerCampId, $colonistId, $userId, $fileName, $extension, $type, pg_escape_bytea($file)));
        if ($returnId) {
            $this->Logger->info("Documento inserido com sucesso");
            return TRUE;
        }
        $this->Logger->error("Problema ao inserir documento");
        return FALSE;
    }

    public function getNewestDocument($camp_id, $colonist_id, $document_type) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'Select * from document where summer_camp_id = ? and colonist_id = ? and document_type = ? order by date_created desc';
        $resultSet = $this->executeRowsNoLog($this->db, $sql, array($camp_id, $colonist_id, $document_type));

        $document = FALSE;

        if ($resultSet)
            foreach ($resultSet as $row) {
                $this->Logger->info("Documento encontrado com sucesso, criando array");
                $document = array("data" => $row->file, "name" => $row->filename, "extension" => $row->extension, "document_id" => $row->document_id);
                return $document;
            }
        $this->Logger->info("Nao achei o documento");
        return $document;
    }

    public function hasDocument($camp_id, $colonist_id, $document_type) {
        $this->Logger->info("Running: " . __METHOD__);

        if ($document_type != DOCUMENT_MEDICAL_FILE && $document_type != DOCUMENT_TRIP_AUTHORIZATION && $document_type != DOCUMENT_GENERAL_RULES) {

            $sql = 'Select * from document where summer_camp_id = ? and colonist_id = ? and document_type = ? order by date_created desc';
            $resultSet = $this->executeRowsNoLog($this->db, $sql, array($camp_id, $colonist_id, $document_type));

            if ($resultSet)
                foreach ($resultSet as $row) {
                    return TRUE;
                }
            return FALSE;
        } else if ($document_type == DOCUMENT_MEDICAL_FILE) {
            $sql = "Select colonist_id from medical_file where summer_camp_id = ? and colonist_id = ?";
            $resultSet = $this->executeRow($this->db, $sql, array($camp_id, $colonist_id));
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
            $resultSet = $this->executeRow($this->db, $sql, array($camp_id, $colonist_id));
            if ($resultSet) {
                if ($document_type == DOCUMENT_GENERAL_RULES && $resultSet->accepted_terms === "t") {
                    return TRUE;
                }
                if ($document_type == DOCUMENT_TRIP_AUTHORIZATION && $resultSet->accepted_travel_terms === "t")
                    return TRUE;
            }
            return FALSE;
        }
    }

    public function hasDocumentStaff($person_id, $document_type) {
        $this->Logger->info("Running: " . __METHOD__);

        if ($document_type != DOCUMENT_MEDICAL_FILE && $document_type != DOCUMENT_TRIP_AUTHORIZATION && $document_type != DOCUMENT_GENERAL_RULES) {

            $sql = 'Select * from document where person_id = ? and document_type = ? order by date_created desc';
            $resultSet = $this->executeRowsNoLog($this->db, $sql, array($person_id, $document_type));

            if ($resultSet)
                foreach ($resultSet as $row) {
                    return TRUE;
                }
            return FALSE;
        } else if ($document_type == DOCUMENT_MEDICAL_FILE) {
            $sql = "Select person_id from medical_file_staff where person_id = ?";
            $resultSet = $this->executeRow($this->db, $sql, array($person_id));
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
            $sql = "Select $column from summer_camp_subscription where person_id = ?";
            $resultSet = $this->executeRow($this->db, $sql, array($person_id));
            if ($resultSet) {
                if ($document_type == DOCUMENT_GENERAL_RULES && $resultSet->accepted_terms === "t") {
                    return TRUE;
                }
                if ($document_type == DOCUMENT_TRIP_AUTHORIZATION && $resultSet->accepted_travel_terms === "t")
                    return TRUE;
            }
            return FALSE;
        }
    }
    
    public function isOldSubscriptionRestored($summercampId, $colonistId){
    	$sql = "SELECT *
				FROM summer_camp_old_subscription
				WHERE summer_camp_id = ?
				AND colonist_id = ?";
    	
    	$resultSet = $this->executeRow($this->db, $sql, array(intval($summercampId),intval($colonistId)));
    	
    	if($resultSet)
    		return $resultSet;
    	else 
    		return null;    	
    }
    
    public function turnOnSummerCampOldSubscriptionStatus($summercampId,$colonistId,$status){
    	$sql = "UPDATE summer_camp_old_subscription
    			SET ".$status." = TRUE
    			WHERE summer_camp_id = ?
    			AND colonist_id = ?";
    	
    	$resultSet = $this->execute($this->db, $sql, array(intval($summercampId),intval($colonistId)));
    	
    	if($resultSet)
    		return TRUE;
    	else 
    		return FALSE;
    
    }

    public function getAllColonistsBySummerCampAndYearForValidation($year, $status = null) {
        $sql = "Select sc.*, scs.*, c.*, p.*, pr.*, scss.*,
        v.colonist_gender_ok, v.colonist_picture_ok, v.colonist_medical_card_ok, v.colonist_identity_ok,
        v.colonist_parents_name_ok, v.colonist_birthday_ok, v.colonist_name_ok,
        v.colonist_gender_msg, v.colonist_picture_msg, v.colonist_medical_card_msg, v.colonist_identity_msg,
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
            $sql = $sql . " WHERE scs.situation in (" . $status . ") AND DATE_PART('YEAR',sc.date_created) = ?";
        } else {
            $sql = $sql . " WHERE DATE_PART('YEAR',sc.date_created) = ?";
        }

        $resultSet = $this->executeRows($this->db, $sql, array($year));

        return $resultSet;
    }

    public function getAllColonistsByYearSummerCampAndStatus($year, $summercampId = null, $status = null) {
        $sql = "Select sc.*, scs.*, c.*, p.*, pr.*, scss.*,
        v.colonist_gender_ok, v.colonist_picture_ok, v.colonist_medical_card_ok, v.colonist_identity_ok,
        v.colonist_parents_name_ok, v.colonist_birthday_ok, v.colonist_name_ok,
        v.colonist_gender_msg, v.colonist_picture_msg, v.colonist_medical_card_msg, v.colonist_identity_msg,
        v.colonist_parents_name_msg, v.colonist_birthday_msg, v.colonist_name_msg,
        p.fullname as colonist_name, pr.fullname as user_name, p.person_id as person_colonist_id,
        age(c.birth_date) as age
        from summer_camp sc
        join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
        join colonist c on scs.colonist_id = c.colonist_id
        join person p on c.person_id = p.person_id
        join person pr on pr.person_id = scs.person_user_id
        join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status
        left join validation v on v.colonist_id = c.colonist_id and v.summer_camp_id = sc.summer_camp_id ";


        if ($summercampId !== null && $status !== null) {
            $sql = $sql . " WHERE DATE_PART('YEAR',sc.date_created) = ? AND sc.summer_camp_id = ? AND scs.situation in (" . $status . ") order by p.fullname";
            $resultSet = $this->executeRows($this->db, $sql, array($year, $summercampId));
        } else if ($summercampId !== null && $status === null) {
            $sql = $sql . " WHERE DATE_PART('YEAR',sc.date_created) = ? AND sc.summer_camp_id = ? AND scs.situation in ('1','2','6') order by p.fullname";
            $resultSet = $this->executeRows($this->db, $sql, array($year, $summercampId));
        } else if ($summercampId === null && $status !== null) {
            $sql = $sql . " WHERE DATE_PART('YEAR',sc.date_created) = ? AND scs.situation in (" . $status . ")  order by p.fullname";
            $resultSet = $this->executeRows($this->db, $sql, array($year));
        } else {
            $sql = $sql . " WHERE DATE_PART('YEAR',sc.date_created) = ? AND scs.situation in ('1','2','6') order by p.fullname";
            $resultSet = $this->executeRows($this->db, $sql, array($year));
        }

        return $resultSet;
    }

    public function getAllColonistsBySummerCampAndYear($year, $status = null, $summercampId = null, $gender = null, $room = null) {
        $sql = "Select sc.*, scs.*, c.*, p.*, pr.*, scss.*,scs.date_created as date_to_get,
		v.colonist_gender_ok, v.colonist_picture_ok, v.colonist_medical_card_ok, v.colonist_identity_ok,
		v.colonist_parents_name_ok, v.colonist_birthday_ok, v.colonist_name_ok,
		v.colonist_gender_msg, v.colonist_picture_msg, v.colonist_medical_card_msg, v.colonist_identity_msg,
		v.colonist_parents_name_msg, v.colonist_birthday_msg, v.colonist_name_msg,
		p.fullname as colonist_name, pr.fullname as user_name, p.person_id as person_colonist_id,
        p.gender as colonist_gender, age(c.birth_date) as age
		from summer_camp sc
		join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		join colonist c on scs.colonist_id = c.colonist_id
		join person p on c.person_id = p.person_id
		join person pr on pr.person_id = scs.person_user_id
		join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status
		left join validation v on v.colonist_id = c.colonist_id and v.summer_camp_id = sc.summer_camp_id
        where DATE_PART('YEAR', sc.date_created) = ? ";

        $arrParam = array($year);
        if ($status !== null) {
            $sql = $sql . " and scs.situation in (" . $status . ") ";
        }
        if ($summercampId !== null) {
            $sql = $sql . " and sc.summer_camp_id = ? ";
            $arrParam[] = $summercampId;
        }
        if ($gender !== null) {
            $sql = $sql . " and p.gender = ? ";
            $arrParam[] = $gender;
        }
        if ($room !== null) {
            if ($room == 0) {
                $sql = $sql . " and scs.room_number is NULL ";
            } else if ($room == -1) {
                $sql = $sql . " and scs.room_number in (1,2,3,4,5,6) ";
            } else {
                $sql = $sql . " and scs.room_number = ? ";
                $arrParam[] = $room;
            }
        }

        $sql .= " ORDER BY colonist_name ";
        $resultSet = $this->executeRows($this->db, $sql, $arrParam);
        return $resultSet;
    }

    public function getColonistRelationDetailedBySummerCamp($summercampId) {
        $sql = "SELECT *,
	COALESCE((SELECT 1 FROM parent_summer_camp_subscription pscs WHERE relation = 'Pai' and pscs.colonist_id = scs.colonist_id), 0) as pai,
	COALESCE((SELECT 1 FROM parent_summer_camp_subscription pscs WHERE relation = 'Mãe' and pscs.colonist_id = scs.colonist_id), 0) as mae
	FROM
	summer_camp_subscription scs INNER JOIN summer_camp sc on sc.summer_camp_id = scs.summer_camp_id
	INNER JOIN colonist c on c.colonist_id = scs.colonist_id
	INNER JOIN person p on p.person_id = c.person_id
	WHERE scs.colonist_id in(SELECT colonist_id FROM summer_camp_subscription WHERE summer_camp_id in(" . $summercampId . "));";

        $resultSet = $this->executeRows($this->db, $sql);

        return $resultSet;
    }

    public function getColonistDetailedSameParentsByYearAndSummerCamp($year) {
        $sql = "SELECT DISTINCT c.colonist_id as colonist_id, pc.fullname as colonist_name, p.fullname as responsable, p.person_id as responsable_id,
				sc.summer_camp_id as camp_id, sc.camp_name as camp_name, DATE_PART('YEAR',sc.date_created) as year,
    			scss.description as situation_description, scs.situation as situation
				FROM summer_camp sc
				INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
    			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
				INNER JOIN colonist c on c.colonist_id = scs.colonist_id
				INNER JOIN person p on p.person_id = scs.person_user_id
				INNER JOIN parent_summer_camp_subscription pscs on pscs.parent_id = p.person_id
				INNER JOIN person pc on c.person_id = pc.person_id
				WHERE scs.person_user_id in (SELECT DISTINCT scs1.person_user_id FROM summer_camp sc1, summer_camp sc2, summer_camp_subscription scs1, summer_camp_subscription scs2, colonist c1, colonist c2
							WHERE c1.colonist_id = scs1.colonist_id
							AND c2.colonist_id = scs2.colonist_id
							AND scs1.colonist_id != scs2.colonist_id
							AND sc1.summer_camp_id = scs1.summer_camp_id
							AND sc2.summer_camp_id = scs2.summer_camp_id
							AND scs1.person_user_id = scs2.person_user_id
							AND DATE_PART('YEAR',sc1.date_created)=?
							AND DATE_PART('YEAR',sc2.date_created)=?)";


        $resultSet = $this->executeRows($this->db, $sql, array($year, $year));


        return $resultSet;
    }

    public function getColonistsDatailedSubscriptionsNotSubmitted($year, $summercampId = null) {

        $sql = "SELECT * FROM v_subscriptions_not_submitted WHERE year = ?";

        if ($summercampId != null) {
            $sql = $sql . "AND camp_id = ?";
            $resultSet = $this->executeRows($this->db, $sql, array($year, $summercampId));
        } else {
            $resultSet = $this->executeRows($this->db, $sql, array($year));
        }

        return $resultSet;
    }

    public function getColonistsDetailsSubscriptionsMinikInterest1Turma($year, $summercampId){

        $sql = "SELECT  p.fullname AS colonist_name,
                        p1.fullname AS responsable_name
                FROM person p
                        JOIN colonist c ON c.person_id = p.person_id
                        JOIN summer_camp_subscription scs ON c.colonist_id = scs.colonist_id
                        JOIN person p1 ON p1.person_id = scs.person_user_id
                        JOIN mini_colonist_observations m ON scs.summer_camp_id = m.summer_camp_id AND scs.colonist_id = m.colonist_id
                        WHERE m.summer_interest = true AND AND scs.summer_camp_id = ?";

        $resultSet = $this->executeRows($this->db, $sql, array($summercampId));

        return $resultSet;
    }


    public function getColonistsResponsableNotParentsByYear($year) {

        $sql = "SELECT * FROM v_colonists_with_responsables_not_parents
    			WHERE ano = ?";

        $resultSet = $this->executeRows($this->db, $sql, array($year));

        return $resultSet;
    }

    public function getCountDiscountsBySummerCamp($year, $summercampId = null, $status = null) {
        $sql = "SELECT DISTINCT COALESCE(same_school,0) as same_school, COALESCE(second_brother,0) as second_brother, COALESCE (third_brother,0) as third_brother, COALESCE (child_home,0) as child_home, COALESCE (others,0) as others
				FROM( SELECT sum(discount) as same_school FROM summer_camp_subscription scs INNER JOIN summer_camp sc on sc.summer_camp_id = scs.summer_camp_id WHERE scs.discount_reason_id=1 AND DATE_PART('YEAR',sc.date_created) = ? " . (($summercampId != null) ? " AND sc.summer_camp_id = ? " : "") . " " . (($status != null) ? "AND scs.situation = 5" : "") . ") same_school,
				( SELECT sum(discount) as second_brother FROM summer_camp_subscription scs INNER JOIN summer_camp sc on sc.summer_camp_id = scs.summer_camp_id WHERE scs.discount_reason_id=2 AND DATE_PART('YEAR',sc.date_created) = ? " . (($summercampId != null) ? " AND sc.summer_camp_id = ? " : "") . " " . (($status != null) ? "AND scs.situation = 5" : "") . ") second_brother,
				( SELECT sum(discount) as third_brother FROM summer_camp_subscription scs INNER JOIN summer_camp sc on sc.summer_camp_id = scs.summer_camp_id WHERE scs.discount_reason_id=3 AND DATE_PART('YEAR',sc.date_created) = ? " . (($summercampId != null) ? " AND sc.summer_camp_id = ? " : "") . " " . (($status != null) ? "AND scs.situation = 5" : "") . ") third_brother,
				( SELECT sum(discount) as child_home FROM summer_camp_subscription scs INNER JOIN summer_camp sc on sc.summer_camp_id = scs.summer_camp_id WHERE scs.discount_reason_id=4 AND DATE_PART('YEAR',sc.date_created) = ? " . (($summercampId != null) ? " AND sc.summer_camp_id = ? " : "") . " " . (($status != null) ? "AND scs.situation = 5" : "") . ") child_home,
                ( SELECT sum(discount) as others FROM summer_camp_subscription scs INNER JOIN summer_camp sc on sc.summer_camp_id = scs.summer_camp_id WHERE scs.discount_reason_id>4 AND DATE_PART('YEAR',sc.date_created) = ? " . (($summercampId != null) ? " AND sc.summer_camp_id = ? " : "") . " " . (($status != null) ? "AND scs.situation = 5" : "") . ") others, summer_camp
				WHERE " . (($summercampId != null) ? "summer_camp_id = ? AND" : "") . " DATE_PART('YEAR',date_created) = ?";
        if ($summercampId != null) {
            $resultSet = $this->executeRow($this->db, $sql, array($year, $summercampId, $year, $summercampId, $year, $summercampId, $year, $summercampId, $year, $summercampId, $summercampId, $year));
        } else {
            $resultSet = $this->executeRow($this->db, $sql, array($year, $year, $year, $year, $year, $year));
        }

        return $resultSet;
    }

    public function getCountStatusColonistBySummerCampYearAndGender($year, $summerCampId = null, $gender = null) {
        $sql = "select (
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 0
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as elaboracao, (
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 1
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as aguardando_validacao,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 2
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as validada,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 3
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as fila_espera,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 4
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as aguardando_pagamento,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 5
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as inscrito, (
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 6
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as nao_validada,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = -1
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as desistente,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = -2
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as excluido,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = -3
			AND DATE_PART('YEAR',sc.date_created) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as cancelado;";
        if ($summerCampId !== null && $gender === null) {
            $resultSet = $this->executeRow($this->db, $sql, array(intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year,
                intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year));

            return $resultSet;
        } else if ($summerCampId === null && $gender !== null) {
            $resultSet = $this->executeRow($this->db, $sql, array($year, $gender, $year, $gender, $year,
                $gender, $year, $gender, $year, $gender, $year, $gender, $year, $gender, $year, $gender, $year, $gender, $year, $gender));

            return $resultSet;
        } else if ($summerCampId !== null && $gender !== null) {
            $resultSet = $this->executeRow($this->db, $sql, array(intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender,
                intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender,
                intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender));

            return $resultSet;
        } else {
            $resultSet = $this->executeRow($this->db, $sql, array($year, $year, $year, $year, $year, $year, $year, $year, $year, $year));
            return $resultSet;
        }
    }

    public function getColonistsDetailedByYearSummerCampAssociationStatusAndGender($year, $status, $gender, $associated = null, $summercampId = null) {
        $sql = "SELECT c.colonist_id as colonist_id, p.fullname as colonist_name, pr.person_id as responsable_id,
				pr.fullname as responsable_name, vrauad.associate as associate, sc.summer_camp_id as camp_id, sc.camp_name as camp_name
				FROM colonist c INNER JOIN person p on c.person_id = p.person_id
				INNER JOIN summer_camp_subscription scs on scs.colonist_id = c.colonist_id
				INNER JOIN summer_camp sc on scs.summer_camp_id = sc.summer_camp_id
				INNER JOIN person pr on scs.person_user_id = pr.person_id
				INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = pr.person_id
				WHERE DATE_PART('YEAR',sc.date_created) = ?
    			AND p.gender = ?
				AND scs.situation = ?
				" . (($associated) ? "" . (($associated != 'true') ? "AND vrauad.associate = 'não sócio'" : "AND vrauad.associate != 'não sócio'") . "" : "") . "
				" . (($summercampId !== null) ? "AND sc.summer_camp_id = ?" : "") . "";

        if ($summercampId !== null) {
            $resultSet = $this->executeRows($this->db, $sql, array($year, $gender, $status, $summercampId));
        } else {
            $resultSet = $this->executeRows($this->db, $sql, array($year, $gender, $status));
        }

        return $resultSet;
    }

    public function getCountStatusColonistAssociatedOrNotBySummerCampYearGender($year, $associated, $summerCampId = null, $gender = null) {
        $sql = "select (
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = 0
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as elaboracao, (
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = 1
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as aguardando_validacao,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = 2
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as validada,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = 3
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as fila_espera,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = 4
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as aguardando_pagamento,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = 5
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as inscrito, (
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = 6
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as nao_validada,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = -1
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as desistente,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = -2
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as excluido,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			INNER JOIN v_report_all_users_association_detailed vrauad on vrauad.person_id = scs.person_user_id
			WHERE status = -3
			AND vrauad.associate " . (($associated) ? "!" : "") . "= 'não sócio'
    		" . (($summerCampId != null) ? "AND sc.summer_camp_id = ?" : "") . "
			AND DATE_PART('YEAR',sc.date_created) = ?
    		" . (($gender != null) ? " AND gender = ?" : "") . "
		) as cancelado;";
        if ($summerCampId !== null && $gender === null) {
            $resultSet = $this->executeRow($this->db, $sql, array(intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year,
                intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year, intval($summerCampId), $year));

            return $resultSet;
        } else if ($summerCampId === null && $gender !== null) {
            $resultSet = $this->executeRow($this->db, $sql, array($year, $gender, $year, $gender, $year,
                $gender, $year, $gender, $year, $gender, $year, $gender, $year, $gender, $year, $gender, $year, $gender, $year, $gender));

            return $resultSet;
        } else if ($summerCampId !== null && $gender !== null) {
            $resultSet = $this->executeRow($this->db, $sql, array(intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender,
                intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender,
                intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender, intval($summerCampId), $year, $gender));

            return $resultSet;
        } else {
            $resultSet = $this->executeRow($this->db, $sql, array($year, $year, $year, $year, $year, $year, $year, $year, $year, $year));
            return $resultSet;
        }
    }

    public function getCountStatusSchoolBySchoolName($schoolName, $year, $summercampId = null) {
        $sql = "select DISTINCT school_name,
		(SELECT count(status) as elaboracao
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE status = 2 AND school_name = ? AND DATE_PART('YEAR',sc.date_created) = ?" . (($summercampId != null) ? "AND sc.summer_camp_id = ?" : "") . ") as validada,
		(SELECT count(status) as elaboracao
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE status = 3 AND school_name = ? AND DATE_PART('YEAR',sc.date_created) = ?" . (($summercampId != null) ? "AND sc.summer_camp_id = ?" : "") . ") as fila_espera,
		(SELECT count(status) as elaboracao
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE status = 4 AND school_name = ? AND DATE_PART('YEAR',sc.date_created) = ?" . (($summercampId != null) ? "AND sc.summer_camp_id = ?" : "") . ") as aguardando_pagamento,
		(SELECT count(status) as elaboracao
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE status = 5 AND school_name = ? AND DATE_PART('YEAR',sc.date_created) = ?" . (($summercampId != null) ? "AND sc.summer_camp_id = ?" : "") . ") as inscrito
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE school_name = ?";

        if ($summercampId != null) {
            $resultSet = $this->executeRow($this->db, $sql, array($schoolName, $year, $summercampId, $schoolName, $year, $summercampId,
                $schoolName, $year, $summercampId, $schoolName, $year, $summercampId, $schoolName));
        } else {
            $resultSet = $this->executeRow($this->db, $sql, array($schoolName, $year, $schoolName, $year,
                $schoolName, $year, $schoolName, $year, $schoolName));
        }

        return $resultSet;
    }

    public function getCountStatusBySummerCamp($summercampId) {
        $sql = "SELECT DISTINCT sc.camp_name, (SELECT count(situation) as waiting_validation FROM summer_camp_subscription WHERE situation = 1 AND summer_camp_id = ?) as waiting_validation,
				(SELECT count(situation) as validated FROM summer_camp_subscription WHERE situation = 2 AND summer_camp_id = ?) as validated,
				(SELECT count(situation) as validated_with_errors FROM summer_camp_subscription WHERE situation = 6 AND summer_camp_id = ?) as validated_with_errors
				FROM summer_camp_subscription scs INNER JOIN summer_camp sc on sc.summer_camp_id = scs.summer_camp_id
				WHERE sc.summer_camp_id = ?";

        $resultSet = $this->executeRow($this->db, $sql, array($summercampId, $summercampId, $summercampId, $summercampId));

        return $resultSet;
    }

    public function getSchoolNamesByStatusSummerCampAndYear($year, $summercampId = null) {

        $sql = "SELECT DISTINCT scs.school_name
				FROM summer_camp_subscription scs
				INNER JOIN summer_camp sc on sc.summer_camp_id = scs.summer_camp_id
				WHERE situation in (2,3,4,5)
				AND DATE_PART('YEAR',sc.date_created) = ?";

        if ($summercampId !== null) {
            $sql = $sql . "AND sc.summer_camp_id = ?";
            $resultSet = $this->executeRows($this->db, $sql, array($year, intval($summercampId)));
        } else {
            $resultSet = $this->executeRows($this->db, $sql, array($year));
        }

        if ($resultSet) {
            $schools = array();
            foreach ($resultSet as $row) {
                $schools[] = $row->school_name;
            }
            return $schools;
        }
        return null;
    }

    public function updateGeneralRules($summerCampId, $colonistId, $value) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'UPDATE summer_camp_subscription SET accepted_terms = ? WHERE summer_camp_id = ? AND colonist_id = ?';
        $returnId = $this->execute($this->db, $sql, array($value, intval($summerCampId), intval($colonistId)));
        if ($returnId)
            return TRUE;

        return FALSE;
    }

    public function updateTripAuthorization($summerCampId, $colonistId, $value) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'UPDATE summer_camp_subscription SET accepted_travel_terms = ? WHERE summer_camp_id = ? AND colonist_id = ?';
        $returnId = $this->execute($this->db, $sql, array($value, intval($summerCampId), intval($colonistId)));
        if ($returnId)
            return TRUE;

        return FALSE;
    }

    public function updateColonistStatus($colonistId, $summerCampId, $status) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'UPDATE summer_camp_subscription SET situation = ? WHERE summer_camp_id = ? AND colonist_id = ?';
        $return = $this->execute($this->db, $sql, array($status, intval($summerCampId), intval($colonistId)));
        if ($return)
            return TRUE;

        return FALSE;
    }

    public function getStatusDescription($status) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT description FROM summer_camp_subscription_status WHERE status = ?";
        $resultSet = $this->executeRow($this->db, $sql, array($status));
        if ($resultSet)
            return $resultSet->description;

        return "";
    }

    public function getStatusArray() {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT * FROM summer_camp_subscription_status order by status desc";
        $resultSet = $this->executeRows($this->db, $sql, array());
        $array = array();
        if ($resultSet) {
            foreach ($resultSet as $row) {
                $array[] = array("database_id" => $row->status, "text" => $row->description);
            }
            return $array;
        }
        return "";
    }

    public function getColonistStatus($colonistId, $summerCampId) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT situation FROM summer_camp_subscription WHERE colonist_id = ? AND summer_camp_id = ?";
        $resultSet = $this->executeRow($this->db, $sql, array($colonistId, $summerCampId));
        if ($resultSet)
            return $resultSet->situation;

        return null;
    }

    public function getSchools() {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT * FROM school ORDER BY school_name ASC";
        $resultSet = $this->executeRows($this->db, $sql);
        if ($resultSet) {
            $schools = array();
            foreach ($resultSet as $row) {
                $schools[] = $row->school_name;
            }
            return $schools;
        }
        return null;
    }

    public function getDefaultDiscountReasons() {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT * FROM discount_reason where discount_reason_id < 5";
        $resultSet = $this->executeRows($this->db, $sql);
        return $resultSet;
    }

    public function insertDiscountReason($discountReason) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "Select * from discount_reason where discount_reason = ?";
        $resultSet = $this->executeRow($this->db, $sql, array($discountReason));
        if ($resultSet) {
            return $resultSet->discount_reason_id;
        }

        $sql = "insert into discount_reason(discount_reason) values (?)";
        $resultSet = $this->executeReturningId($this->db, $sql, array($discountReason));
        return $resultSet;
    }

    public function insertSchool($school) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "Select * from school where school_name = ?";
        $resultSet = $this->executeRow($this->db, $sql, array($school));
        if ($resultSet) {
            return TRUE;
        }

        $sql = "insert into school values (?)";
        $resultSet = $this->execute($this->db, $sql, array($school));
        if ($resultSet) {
            return TRUE;
        }
        return FALSE;
    }

    public function saveSummerCampMini($summerCampId, $colonistId, $sleepOut, $summerInterest, $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible) {

	if ($summerInterest == NULL) { $summerInterest = "0"; }
        $sql = "INSERT INTO mini_colonist_observations(
            summer_camp_id, colonist_id, sleep_out, summer_interest, wake_up_early, food_restriction,
            eat_by_oneself, bathroom_freedom, sleep_routine, bunk_restriction,
            wake_up_at_night, sleep_enuresis, sleepwalk, observation, responsible_name,
            responsible_number)
            VALUES (?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?,
                    ?, ?, ?, ?, ?,
                    ?);";
        $paramArray = array($summerCampId, $colonistId, $sleepOut, $summerInterest, $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible);
        $campId = $this->executeReturningId($this->db, $sql, $paramArray);
        if ($campId)
            return $campId;
        throw new ModelException("Insert object in the database");
    }

    public function updateSummerCampMini($summerCampId, $colonistId, $sleepOut, $summerInterest, $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible) {
	if ($summerInterest == NULL) { $summerInterest = "0"; }
        $sql = "UPDATE mini_colonist_observations
                SET sleep_out=?, summer_interest=?, wake_up_early=?,
                    food_restriction=?, eat_by_oneself=?, bathroom_freedom=?, sleep_routine=?,
                    bunk_restriction=?, wake_up_at_night=?, sleep_enuresis=?, sleepwalk=?,
                    observation=?, responsible_name=?, responsible_number=?
                WHERE summer_camp_id=? and colonist_id=?;";
        $paramArray = array($sleepOut, $summerInterest, $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible, $summerCampId, $colonistId);
        if ($this->execute($this->db, $sql, $paramArray)) {
            return true;
        }
        throw new ModelException("UPDATE object in the database");
    }

    public function getMiniCampObs($summerCampId, $colonistId) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT * FROM  mini_colonist_observations WHERE colonist_id = ? AND summer_camp_id = ?";
        $resultSet = $this->executeRow($this->db, $sql, array($colonistId, $summerCampId));
        if ($resultSet)
            return $resultSet;
        return null;
    }

    public function checkQueueNumberAvailability($userId, $summerCamps, $position) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT *
                FROM summer_camp_subscription scs
                WHERE
                    person_user_id != ?
                    AND summer_camp_id in (" . $summerCamps . ")
                    AND queue_number = ?";
        $resultSet = $this->executeRow($this->db, $sql, array(intval($userId), intval($position)));
        if ($resultSet)
            return false;
        return true;
    }

        public function jaFoiLiberado($summerCamp) {

        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT *
                FROM summer_camp_subscription
                WHERE summer_camp_id = ?
                AND situation = 5";

        return $this->executeRows($this->db, $sql, array(intval($summerCamp)));

    }

    public function checaPreInscAberta($summerCamps) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT *
                FROM summer_camp
                WHERE now() < date_finish_pre_subscriptions
                AND summer_camp_id in (" . $summerCamps . ")";
        
        return $this->executeRows($this->db, $sql);
    }

    public function checaLiberados($usersId, $summerCamps) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT *
                FROM summer_camp_subscription
                WHERE situation = 5
                AND summer_camp_id in (" . $summerCamps . ")
                AND person_user_id in (" . $usersId . ")";

        return $this->executeRows($this->db, $sql);
    }

    public function updateQueueNumber($userId, $summerCamps, $position) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "UPDATE summer_camp_subscription
                SET queue_number = ?, situation = " . SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE . "
                WHERE
                    person_user_id = ?
                    AND (situation = " . SUMMER_CAMP_SUBSCRIPTION_STATUS_VALIDATED . "
                        OR situation = " . SUMMER_CAMP_SUBSCRIPTION_STATUS_QUEUE . ")
                    AND summer_camp_id in (" . $summerCamps . ")";
        return $this->execute($this->db, $sql, array(intval($position), intval($userId)));
    }

    public function getSummerCampPaymentPeriod($campId) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "Select * from summer_camp_payment_period where now() >= date_start and now() <= date_finish and summer_camp_id = ?";

        $resultSet = $this->executeRow($this->db, $sql, array($campId));

        $paymentPeriod = false;

        if ($resultSet)
            $paymentPeriod = SummerCampPaymentPeriod::createSummerCampPaymentPeriodObject($resultSet);

        return $paymentPeriod;
    }

    public function getSummerCampPaymentPeriods($campId) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "Select * from summer_camp_payment_period where summer_camp_id = ?";

        $payment_periods = $this->executeRows($this->db, $sql, array($campId));

        $retorno = array();

        foreach ($payment_periods as $payment_period) {
            $retorno[] = SummerCampPaymentPeriod::createSummerCampPaymentPeriodObject($payment_period);
        }

        return $retorno;
    }

    public function deleteSummerCampPaymentPeriods($campId) {
        $this->Logger->info("Running: " . __METHOD__);

        $deleteSql = 'DELETE FROM summer_camp_payment_period WHERE summer_camp_id = ?';

        return $this->execute($this->db, $deleteSql, array(intval($campId)));
    }

    public function associateDonation($campId, $colonistId, $donationId,$price) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "UPDATE summer_camp_subscription
                SET donation_id = ?,individual_price= ?
                WHERE colonist_id = ? AND summer_camp_id = ?";
        return $this->execute($this->db, $sql, array(intval($donationId), intval($price),intval($colonistId), intval($campId)));
    }

    public function paidDonation($donation_id) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "UPDATE summer_camp_subscription SET situation = ? WHERE donation_id = ?";
        return $this->execute($this->db, $sql, array(intval(SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED), intval($donation_id)));
    }

    public function getSubscriptionsByDonation($donationId) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "Select * from summer_camp sc
		join summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		join colonist c on scs.colonist_id = c.colonist_id
		join person p on c.person_id = p.person_id
		join (Select status,description as situation_description from summer_camp_subscription_status) scss on scs.situation = scss.status
		where donation_id = ?";

        $resultSet = $this->executeRows($this->db, $sql, array($donationId));
        $r = array();

        foreach ($resultSet as $resultSetIteration)
            $r[] = SummerCampSubscription::createSummerCampSubscriptionObject($resultSetIteration);

        return $r;
    }

    public function updateDiscount($colonistId, $summerCampId, $discount_value, $discount_reason_id) {
        $this->Logger->info("Running: " . __METHOD__);
        if ($discount_reason_id < -1) {
            $this->Logger->error("Tentativa de inserir desconto com razão inválida");
            return;
        }
        $insertDiscountReasonId = intval($discount_reason_id);
        if ($discount_reason_id == -1)
            $insertDiscountReasonId = null;
        $sql = "UPDATE summer_camp_subscription SET discount = ?, discount_reason_id=? WHERE colonist_id = ? and summer_camp_id = ?";
        return $this->execute($this->db, $sql, array(intval($discount_value), $insertDiscountReasonId, intval($colonistId), intval($summerCampId)));
    }

    public function getSummerCampSubscriptionsByStatusAndGender($summerCampId, $status = null, $gender = null) {
        $paramArray = array($summerCampId);
        $sql = "SELECT
                    scs.situation,
                    p.gender
                FROM summer_camp_subscription scs
                INNER JOIN colonist c on c.colonist_id = scs.colonist_id
                INNER JOIN person p on p.person_id = c.person_id
                WHERE scs.summer_camp_id = ? ";
        if ($status != null) {
            $sql .= " AND scs.situation = ? ";
            $paramArray[] = $status;
        }
        if ($gender != null) {
            $sql .= " AND p.gender = ? ";
            $paramArray[] = $gender;
        }

        $resultSet = $this->executeRows($this->db, $sql, $paramArray);
        $countDetail = array(
            -3 => array('M' => 0, 'F' => 0),
            -2 => array('M' => 0, 'F' => 0),
            -1 => array('M' => 0, 'F' => 0),
            0 => array('M' => 0, 'F' => 0),
            1 => array('M' => 0, 'F' => 0),
            2 => array('M' => 0, 'F' => 0),
            3 => array('M' => 0, 'F' => 0),
            4 => array('M' => 0, 'F' => 0),
            5 => array('M' => 0, 'F' => 0),
            6 => array('M' => 0, 'F' => 0)
        );
        foreach ($resultSet as $row)
            $countDetail[$row->situation][$row->gender] += 1;

        return $countDetail;
    }

    public function getAllColonistsWithQueueNumberBySummerCamp($summerCampId, $gender = null) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT * FROM v_colonists_with_queue_number WHERE summer_camp_id = ?
        		" . (($gender != null) ? " AND gender = ?" : "") . "";

        if ($gender !== null) {
            $resultSet = $this->executeRowsNoLog($this->db, $sql, array($summerCampId, $gender));
        } else {
            $resultSet = $this->executeRowsNoLog($this->db, $sql, array($summerCampId));
        }

        if ($resultSet)
            return $resultSet;

        return null;
    }

    public function getAllColonistsWaitingPaymentBySummerCamp($summerCampId) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT * FROM v_colonists_waiting_payment WHERE summer_camp_id = ?";
        $resultSet = $this->executeRowsNoLog($this->db, $sql, array($summerCampId));

        if ($resultSet)
            return $resultSet;

        return null;
    }

    public function getCountSubscriptionsBySummerCampAndStatus($summerCampId, $status) {
        $sql = "SELECT count(scs.colonist_id), gender, summer_camp_id
                FROM summer_camp_subscription scs
                INNER JOIN colonist c on c.colonist_id = scs.colonist_id
                INNER JOIN person p on p.person_id = c.person_id
                WHERE summer_camp_id = ? AND situation in (" . $status . ")
                GROUP BY gender, summer_camp_id";
        $resultSet = $this->executeRows($this->db, $sql, array($summerCampId));

        if ($resultSet) {
            return $resultSet;
        }

        return array();
    }

    public function updateColonistToWaitingPayment($colonistId, $summerCampId) {
        $sql = "SELECT * FROM set_colonist_subscription_waiting_payment(?,?)";
        $result = $this->executeRow($this->db, $sql, array(intval($colonistId), intval($summerCampId)));

        if ($result && $result->set_colonist_subscription_waiting_payment == 't')
            return true;

        return false;
    }

    public function updateDatePaymentLimit($colonistId, $summerCampId, $dateLimit) {
        $sql = "UPDATE summer_camp_subscription SET date_payment_limit = ? WHERE summer_camp_id = ? AND colonist_id = ?";
        $result = $this->execute($this->db, $sql, array($dateLimit, intval($summerCampId), intval($colonistId)));

        return $result;
    }

    public function getNextAvailablePosition($campsIdStr) {
        $sql = "SELECT MAX(queue_number) as lastposition FROM summer_camp_subscription WHERE summer_camp_id in (" . $campsIdStr . ");";
        $result = $this->executeRow($this->db, $sql);

        if ($result)
            return $result->lastposition + 1;
        else
            return 1;
    }

    public function updateRoomates($colonistId, $summerCampId, $roommate1, $roommate2, $roommate3) {
        $sql = "UPDATE summer_camp_subscription SET roommate1 = ?, roommate2 = ?, roommate3 = ? WHERE summer_camp_id = ? AND colonist_id = ?";
        $result = $this->execute($this->db, $sql, array($roommate1, $roommate2, $roommate3, intval($summerCampId), intval($colonistId)));

        return $result;
    }

    public function updateStatus($colonistId, $summerCampId, $situation, $discount, $cancel_reason) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "UPDATE summer_camp_subscription SET situation = ?, discount = ?, discount_reason_id = null, cancel_reason = ? WHERE summer_camp_id = ? AND colonist_id = ?";
        $result = $this->execute($this->db, $sql, array(intval($situation), intval($discount), $cancel_reason, intval($summerCampId), intval($colonistId)));

        return $result;
    }

    public function updateRoomNumber($colonistId, $summerCampId, $roomNumber) {
        $sql = "UPDATE summer_camp_subscription SET room_number = ? WHERE summer_camp_id = ? AND colonist_id = ?";
        $result = $this->execute($this->db, $sql, array(intval($roomNumber), intval($summerCampId), intval($colonistId)));

        return $result;
    }

    public function getColonistsToDistributeInRooms($summerCampId, $gender) {
        $sql = "SELECT *, date_part('year',age(c.birth_date)) as age
                FROM summer_camp_subscription scs
                INNER JOIN colonist c on c.colonist_id = scs.colonist_id
                INNER JOIN person p on p.person_id = c.person_id
                WHERE summer_camp_id = ? AND situation = ?
                AND p.gender = ?
                ORDER BY age";
        $resultSet = $this->executeRowsNoLog($this->db, $sql, array(intval($summerCampId),
            SUMMER_CAMP_SUBSCRIPTION_STATUS_SUBSCRIBED, $gender));

        if (!$resultSet)
            return array();

        return $resultSet;
    }

    public function getColonistDataFromPDF($id) {
    	$this->Logger->info("///////// ID: ".$id);
        $sql = "Select
                p.person_id,
        		c.colonist_id as colonist_id,
        		p.fullname,
                c.birth_date,
                scs.*,
        		scs.summer_camp_id as camp_id,
                pr.person_id as responsable_id,
                motherPS.parent_id as mother_id,
                fatherPS.parent_id as father_id

                 from colonist as c
                        join person p on c.person_id = p.person_id
                        join summer_camp_subscription scs on scs.colonist_id = c.colonist_id
                        join person pr on pr.person_id = scs.person_user_id
                        left join parent_summer_camp_subscription fatherPS on fatherPS.colonist_id = c.colonist_id and fatherPS.relation = 'Pai'
                        left join parent_summer_camp_subscription motherPS on motherPS.colonist_id = c.colonist_id and motherPS.relation = 'Mãe'
                where c.colonist_id = ? order by p.gender, scs.room_number, p.fullname";
        $resultSet = $this->executeRows($this->db, $sql,array(intval($id)));
        
        if (!$resultSet)
            return array();
        else{
        	return $resultSet[count($resultSet)-1];
        }        
    }

    public function getPersonFullById($personId) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT *, (SELECT phone_number FROM telephone WHERE person_id = ? LIMIT 1) AS phone1,
                    (SELECT phone_number FROM telephone WHERE person_id = ? LIMIT 1 OFFSET 1) AS phone2
    			FROM person p
                        JOIN colonist c on p.person_id = c.person_id
    			LEFT JOIN address a on a.address_id = p.address_id
    			LEFT JOIN person_user pu on pu.person_id = p.person_id
    			WHERE p.person_id = ?";
        $result = $this->executeRow($this->db, $sql, array(intval($personId), intval($personId), intval($personId)));

        if (!$result)
            return null;

        return $result;
    }

    public function getLastRoom($summer_camp_id,$gender){
        $this->Logger->info("Running: " . __METHOD__);

        $sql = "Select MAX(room_id) as id
                from summer_camp_room
                where summer_camp_id = ? and gender = ?";

        $result = $this->executeRow($this->db, $sql, array(intval($summer_camp_id),$gender));

        return $result;
        
    }

    public function addRoom($summer_camp_id,$gender)
    {
        $this->Logger->info("Running: " . __METHOD__);

        $result = $this->getLastRoom($summer_camp_id,$gender);
        if(!$result)
            $id = 1;
        else
            $id = $result->id + 1;

        $sql = "Insert into summer_camp_room(summer_camp_id,gender,room_id,room_name)
                values (?,?,?,?);";

        $room_name = "$gender$id";

        if($this->execute($this->db, $sql, array(intval($summer_camp_id), $gender, intval($id),$room_name)))
            echo "true";
        else
            echo "false";

    }

    public function dropRoom($summer_camp_id,$gender,$room_id,$ids)
    {
        $this->Logger->info("Running: " . __METHOD__);


        $sql = "Delete from summer_camp_room where gender = ? and summer_camp_id = ? and room_id = ?";
        if($this->execute($this->db, $sql, array($gender,intval($summer_camp_id), intval($room_id))))
        {
            foreach($ids as $id)
            {
                $sql = "update summer_camp_subscription set room_number = NULL  where colonist_id = ? and summer_camp_id = ? and room_number = ?";        
                if(!$this->execute($this->db, $sql, array(intval($id),intval($summer_camp_id), intval($room_id))))
                    return FALSE;
            }
        }
        else
            return FALSE;
        return TRUE;
    }


    public function getCampStaff($summerCampId) {
        $sql = "SELECT * FROM summer_camp_staff staff
                INNER JOIN summer_camp_staff_function staff_f on staff_f.staff_function = staff.staff_function
                INNER JOIN person p on p.person_id = staff.person_id
                WHERE summer_camp_id = ?
                ORDER BY staff.staff_function, staff.room_number";
        $result = $this->executeRows($this->db, $sql, array(intval($summerCampId)));

        if (!$result)
            return null;

        return $result;
    }

    public function getCampStaffAlphabetic($summerCampId) {
        $sql = "SELECT * FROM summer_camp_staff staff
                INNER JOIN summer_camp_staff_function staff_f on staff_f.staff_function = staff.staff_function
                INNER JOIN person p on p.person_id = staff.person_id
                WHERE summer_camp_id = ?
                ORDER BY staff.staff_function, p.fullname";
        $result = $this->executeRows($this->db, $sql, array(intval($summerCampId)));

        if (!$result)
            return null;

        return $result;
    }

    public function getCampStaffByFunction($summerCampId, $function) {
        $sql = "SELECT * FROM summer_camp_staff staff
                INNER JOIN summer_camp_staff_function staff_f on staff_f.staff_function = staff.staff_function
                INNER JOIN person p on p.person_id = staff.person_id
                WHERE summer_camp_id = ?
    			AND staff.staff_function = ?
                ORDER BY staff.staff_function, staff.room_number";
        $result = $this->executeRows($this->db, $sql, array(intval($summerCampId), intval($function)));

        if (!$result)
            return null;

        return $result;
    }

    public function updateCampStaff($personId, $summerCampId, $staffFunction, $room = null) {

        if ($staffFunction != 1 || $room != null) {
            $deleteSql = "DELETE FROM summer_camp_staff
	                      WHERE summer_camp_id = ? AND staff_function = ? AND person_id = ? ";
            if ($room != null)
                $deleteSql .= " AND room_number = '" . $room . "'";

            $deleteResult = $this->execute($this->db, $deleteSql, array(intval($summerCampId), intval($staffFunction), intval($personId)));
        }

        $sql = "INSERT INTO summer_camp_staff (person_id, summer_camp_id, staff_function, room_number)
                VALUES (?, ?, ?, '" . $room . "')";

        return $this->execute($this->db, $sql, array(intval($personId), intval($summerCampId), intval($staffFunction)));
    }

    public function insertNewSummercampPaymentPeriod($camp_id, $date_start, $date_finish, $price, $portions, $associate_price) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'INSERT INTO summer_camp_payment_period(summer_camp_id, date_start, date_finish, price, portions, associate_price) VALUES (?,?,?,?,?,?)';

        $returnId = $this->executeReturningId($this->db, $sql, array($camp_id, $date_start, $date_finish, $price, $portions, $associate_price));

        if ($returnId)
            return $returnId;

        return false;
    }

    public function updateAllCampStaffByFunction($summerCampId, $ids, $staffFunction) {

        $sql = "INSERT INTO summer_camp_staff (person_id, summer_camp_id, staff_function, room_number)
                VALUES ";

        $i = 0;

        foreach ($ids as $id) {
            if ($i == 0) {
                $sql .= "(" . intval($id->id) . ", " . intval($summerCampId) . ", " . intval($staffFunction) . ", '" . $id->room . "')";
                $i++;
            } else {
                $sql .= ",(" . intval($id->id) . ", " . intval($summerCampId) . ", " . intval($staffFunction) . ", '" . $id->room . "')";
            }
        }

        return $this->execute($this->db, $sql);
    }

    public function deleteCampStaff($personId, $summerCampId, $staffFunction, $room = null) {


        $deleteSql = "DELETE FROM summer_camp_staff
	                      WHERE summer_camp_id = ? AND staff_function = ? AND person_id = ?";
        if ($room != null)
            $deleteSql .= " AND room_number = '" . $room . "'";

        return $this->execute($this->db, $deleteSql, array(intval($summerCampId), intval($staffFunction), intval($personId)));
    }

    public function deleteAllCoordinatorsBySummercamp($summerCampId) {


        $deleteSql = "DELETE FROM summer_camp_staff
	                      WHERE summer_camp_id = ? AND staff_function = 1";

        return $this->execute($this->db, $deleteSql, array(intval($summerCampId)));
    }

    public function deleteAllMonitorsBySummercamp($summerCampId) {


        $deleteSql = "DELETE FROM summer_camp_staff
	                      WHERE summer_camp_id = ? AND staff_function = 2 AND room_number!=''";

        return $this->execute($this->db, $deleteSql, array(intval($summerCampId)));
    }

    public function deleteAllAssistantsBySummercamp($summerCampId) {


        $deleteSql = "DELETE FROM summer_camp_staff
	                      WHERE summer_camp_id = ? AND staff_function = 2 AND room_number==''";

        return $this->execute($this->db, $deleteSql, array(intval($summerCampId)));
    }

    public function deleteAllDoctorsBySummercamp($summerCampId) {


        $deleteSql = "DELETE FROM summer_camp_staff
	                      WHERE summer_camp_id = ? AND staff_function = 3";

        return $this->execute($this->db, $deleteSql, array(intval($summerCampId)));
    }

    public function getMonitorRooms($personId, $summerCampId) {
        $sql = "SELECT * FROM summer_camp_staff WHERE person_id = ? AND summer_camp_id = ?";
        $result = $this->executeRows($this->db, $sql, array(intval($personId), intval($summerCampId)));

        if (!$result)
            return null;

        return $result;
    }

    public function getMonitorIdByRoom($summerCampId, $room) {
        $sql = "SELECT * FROM summer_camp_staff WHERE summer_camp_id = ? AND room_number = ?";
        $result = $this->executeRow($this->db, $sql, array(intval($summerCampId), $room));

        if (!$result)
            return null;

        return $result;
    }

    /*  Ver se isso aqui ainda pode ser útil no futuro. Código pronto, pegando por Mini e por Verão os valores.
      public function getSubscribersByPeriod($year, $month) {
      $sql = "SELECT sum(d.donated_value),ss.camp_name
      FROM donation d,summer_camp ss, (SELECT DISTINCT ON (s.donation_id) *
      FROM summer_camp_subscription s) a
      WHERE d.donation_id=a.donation_id
      AND d.donation_status=2
      AND  EXTRACT(YEAR FROM d.date_created) = '?'
      AND  EXTRACT(MONTH FROM d.date_created) = '?'
      AND a.summer_camp_id = ss.summer_camp_id
      AND ss.mini_camp=FALSE
      GROUP BY ss.camp_name";
      $result = $this->executeRows($this->db, $sql, array(intval($year), intval($month)));
      $total = 0.0;
      foreach ($result as $colony) {
      if (isset($colony->sum) && !empty($colony->sum)) {
      $total += $colony->sum;
      }
      }
      return $total;
      }

      public function getMiniSubsByPeriod($year, $month) {
      $sql = "SELECT sum(d.donated_value),ss.camp_name
      FROM donation d,summer_camp ss, (SELECT DISTINCT ON (s.donation_id) *
      FROM summer_camp_subscription s) a
      WHERE d.donation_id=a.donation_id
      AND d.donation_status=2
      AND  EXTRACT(YEAR FROM d.date_created) = '?'
      AND  EXTRACT(MONTH FROM d.date_created) = '?'
      AND a.summer_camp_id = ss.summer_camp_id
      AND ss.mini_camp=TRUE
      GROUP BY ss.camp_name";
      $result = $this->executeRow($this->db, $sql, array(intval($year), intval($month)));
      if (isset($result->sum) && !empty($result->sum))
      return $result->sum;
      return 0.0;
      } */

    public function getSummerCampDonationsSum($year, $month) {
        $sql = "SELECT sum(d.donated_value)
                FROM donation d,summer_camp ss, (SELECT DISTINCT ON (s.donation_id) *
                                                 FROM summer_camp_subscription s) a
                WHERE d.donation_id=a.donation_id
                AND d.donation_status=2
                AND  EXTRACT(YEAR FROM d.date_created) = '?'
                AND  EXTRACT(MONTH FROM d.date_created) = '?'
                AND a.summer_camp_id = ss.summer_camp_id";
        $result = $this->executeRow($this->db, $sql, array(intval($year), intval($month)));
        return $result->sum;
    }

}

?>
