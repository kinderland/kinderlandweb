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
        $resultSet = $this->executeRows($this->db, $sql);

        $campArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);

        return $campArray;
    }

    public function getCountSubscriptionsbyAssociated($year) {

        $sql = "SELECT * FROM v_socios_count_inscricoes
    			WHERE DATE_PART('YEAR',date_created) = ?";

        $rows = $this->executeRows($this->db, $sql, array($year));
        return $rows;
    }

    public function getAllSummerCampsByYear($year) {
        $sql = "SELECT * FROM summer_camp WHERE DATE_PART('YEAR',date_start) = ? ORDER BY date_created DESC";
        $resultSet = $this->executeRows($this->db, $sql, array(intval($year)));

        $campArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);

        return $campArray;
    }
    
    public function getMiniCampsOrNotByYear($year,$minicamp) {
    	$sql = "SELECT * FROM summer_camp 
    			WHERE mini_camp ". (($minicamp!=0) ? "!" : "") . "= FALSE
    			AND DATE_PART('YEAR',date_start) = ?";
    	
    	$resultSet = $this->executeRows($this->db, $sql, array($year));
    	
    	$campArray = array();
    	
    	if ($resultSet)
    		foreach ($resultSet as $row)
    			$campArray[] = SummerCamp::createCampObject($row);
    	
    		return $campArray;
    }
    
    /*
     * $associateType: 0 = Sócio; 1 = Não sócio; 2 = Todos
     */
    public function getAssociatedOrNotByStatusAndSummerCamp($summercampId,$associateType) {
    	$sql = "SELECT distinct(vrauad.person_id), vrauad.fullname, scs.queue_number FROM v_report_all_users_association_detailed vrauad 
				INNER JOIN summer_camp_subscription scs on scs.person_user_id = person_id
				WHERE scs.situation in ('2','3','4','5')
				AND scs.summer_camp_id in (" .$summercampId. ") ";
        if($associateType != 2)
			$sql .= " AND vrauad.associate ". (($associateType==0) ? "!" : "") ."= 'não sócio'";
    	
    	$resultSet = $this -> executeRows($this->db,$sql);
    	
    	if($resultSet)
    		return $resultSet;

    	return array();
    }

    public function getAvailableSummerCamps($isAssociate) {
        $associate = " ";
        if ($isAssociate)
            $associate = " or
		(
			date_start_pre_subscriptions_associate <= now() and date_finish_pre_subscriptions_associate >= now()
		)";
        $sql = "SELECT * FROM summer_camp where pre_subscriptions_enabled and
		(
			date_start_pre_subscriptions <= now() and date_finish_pre_subscriptions >= now()
		) $associate ORDER BY date_start_pre_subscriptions ASC";
        $resultSet = $this->executeRows($this->db, $sql);

        $campArray = array();

        if ($resultSet)
            foreach ($resultSet as $row)
                $campArray[] = SummerCamp::createCampObject($row);

        return $campArray;
    }

    public function getSummerCampById($id) {
        $sql = "SELECT * FROM summer_camp where summer_camp_id = ?";
        $resultSet = $this->executeRow($this->db, $sql, array($id));

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
        $resultSet = $this->executeRows($this->db, $sql, array($userId));

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
                    mini_camp
                ) VALUES (
                    ?,?,?,?,?,?,?,?," . (($camp->isEnabled()) ? "true" : "false") . ",?,?," . (($camp->isMiniCamp()) ? "true" : "false") . "
                )";

        $paramArray = array($camp->getCampName(), $camp->getDateStart(), $camp->getDateFinish(), $camp->getDateStartPre(), $camp->getDateFinishPre(), $camp->getDateStartPreAssociate(), $camp->getDateFinishPreAssociate(), $camp->getDescription(), intval($camp->getCapacityMale()), intval($camp->getCapacityFemale()));

        $campId = $this->executeReturningId($this->db, $sql, $paramArray);

        if ($campId)
            return $campId;

        throw new ModelException("Insert object in the database");
    }

    public function updateCampPreEnabled($campId, $enabled) {
        $sql = "UPDATE summer_camp SET pre_subscriptions_enabled = " . (($enabled) ? "true" : "false") . " WHERE summer_camp_id = ?";
        $result = $this->execute($this->db, $sql, array(intval($campId)));

        return $result;
    }

    public function subscribeColonist($summerCampId, $colonistId, $userId, $situation, $schoolName, $schoolYear, $roommate1, $roommate2, $roommate3) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = 'INSERT INTO summer_camp_subscription (summer_camp_id,colonist_id,person_user_id,situation,school_name,school_year,roommate1,roommate2,roommate3) VALUES (?, ?, ?, ?,?,?,?,?,?)';
        $returnId = $this->execute($this->db, $sql, array($summerCampId, $colonistId, $userId, $situation, $schoolName, $schoolYear, $roommate1, $roommate2, $roommate3));
        if ($returnId)
            return TRUE;

        return FALSE;
    }

    public function editColonistSubscription($summerCampId, $colonistId, $schoolName, $schoolYear) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'UPDATE summer_camp_subscription SET school_name=?, school_year=? where summer_camp_id = ? and colonist_id = ? ';
        $returnId = $this->execute($this->db, $sql, array($schoolName, $schoolYear, intval($summerCampId), intval($colonistId)));
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
        if ($extension != "jpg" && $extension != "jpeg" && $extension != "png" && $extension != "pdf")
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
        $resultSet = $this->executeRows($this->db, $sql, array($camp_id, $colonist_id, $document_type));

        $document = FALSE;

        if ($resultSet)
            foreach ($resultSet as $row) {
                $this->Logger->info("Documento encontrado com sucesso, criando array");
                $document = array("data" => $row->file, "name" => $row->filename);
                return $document;
            }
        $this->Logger->info("Nao achei o documento");
        return $document;
    }

    public function hasDocument($camp_id, $colonist_id, $document_type) {
        $this->Logger->info("Running: " . __METHOD__);

        if ($document_type != DOCUMENT_MEDICAL_FILE && $document_type != DOCUMENT_TRIP_AUTHORIZATION && $document_type != DOCUMENT_GENERAL_RULES) {

            $sql = 'Select * from document where summer_camp_id = ? and colonist_id = ? and document_type = ? order by date_created desc';
            $resultSet = $this->executeRows($this->db, $sql, array($camp_id, $colonist_id, $document_type));

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

    public function getAllColonistsBySummerCampAndYear($year, $status = null) {
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
            $sql = $sql . " WHERE scs.situation in (" . $status . ") AND DATE_PART('YEAR',date_start) = ?";
        } else {
            $sql = $sql . " WHERE DATE_PART('YEAR',date_start) = ?";
        }

        $resultSet = $this->executeRows($this->db, $sql, array($year));

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
	WHERE scs.colonist_id in(SELECT colonist_id FROM summer_camp_subscription WHERE summer_camp_id in(".$summercampId."));";
    	
    	$resultSet = $this->executeRows($this->db, $sql);
    	
    	return $resultSet;    	
    }

    public function getCountStatusColonistBySummerCampYearAndGender($year, $summerCampId = null, $gender = null) {
        $sql = "select (
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 0
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as elaboracao, (
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 1
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as aguardando_validacao,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 2
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as validada,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 3
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as fila_espera,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 4
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as aguardando_pagamento,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 5
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as inscrito, (
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = 6
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as nao_validada,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = -1
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as desistente,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = -2
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
		) as excluido,(
			SELECT count(scss.status) as elaboracao FROM summer_camp sc INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
			INNER JOIN colonist c on scs.colonist_id = c.colonist_id
			INNER JOIN person p on c.person_id = p.person_id
			INNER JOIN summer_camp_subscription_status scss on scss.status = scs.situation
			WHERE " . (($summerCampId != null) ? " sc.summer_camp_id = ? AND" : "") . " status = -3
			AND DATE_PART('YEAR',date_start) = ? " . (($gender != null) ? " AND gender = ?" : "") . "
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
			AND DATE_PART('YEAR',date_start) = ?
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
			AND DATE_PART('YEAR',date_start) = ?
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
			AND DATE_PART('YEAR',date_start) = ?
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
			AND DATE_PART('YEAR',date_start) = ?
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
			AND DATE_PART('YEAR',date_start) = ?
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
			AND DATE_PART('YEAR',date_start) = ?
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
			AND DATE_PART('YEAR',date_start) = ?
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
			AND DATE_PART('YEAR',date_start) = ?
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
			AND DATE_PART('YEAR',date_start) = ?
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
			AND DATE_PART('YEAR',date_start) = ?
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
    

    public function getCountStatusSchoolBySchoolName($schoolName) {
        $sql = "select school_name,
		(SELECT count(status) as elaboracao
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE status = 2 AND school_name = ?) as validada,
		(SELECT count(status) as elaboracao
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE status = 3 AND school_name = ?) as fila_espera,
		(SELECT count(status) as elaboracao
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE status = 4 AND school_name = ?) as aguardando_pagamento,
		(SELECT count(status) as elaboracao
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE status = 5 AND school_name = ?) as inscrito
		FROM summer_camp sc
		INNER JOIN summer_camp_subscription scs on sc.summer_camp_id = scs.summer_camp_id
		INNER JOIN summer_camp_subscription_status scss on scs.situation=scss.status
		WHERE school_name = ?";


        $resultSet = $this->executeRow($this->db, $sql, array($schoolName, $schoolName,
            $schoolName, $schoolName, $schoolName));

        return $resultSet;
    }

    public function getSchoolNamesByStatusSummerCampAndYear($year, $summercampId = null) {

        $sql = "SELECT scs.school_name
				FROM summer_camp_subscription scs
				INNER JOIN summer_camp sc on sc.summer_camp_id = scs.summer_camp_id
				WHERE situation in (2,3,4,5)
				AND DATE_PART('YEAR',sc.date_start) = ?";

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

    public function acceptGeneralRules($summerCampId, $colonistId) {
        $this->Logger->info("Running: " . __METHOD__);

        $sql = 'UPDATE summer_camp_subscription SET accepted_terms = true WHERE summer_camp_id = ? AND colonist_id = ?';
        $returnId = $this->execute($this->db, $sql, array(intval($summerCampId), intval($colonistId)));
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
        $sql = "SELECT * FROM school";
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

    public function insertSchool($school) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "insert into school values (?)";
        $resultSet = $this->execute($this->db, $sql, array($school));
        if ($resultSet) {
            return TRUE;
        }
        return FALSE;
    }

    public function saveSummerCampMini($summerCampId, $colonistId, $sleepOut, $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible) {
        $sql = "INSERT INTO mini_colonist_observations(
            summer_camp_id, colonist_id, sleep_out, wake_up_early, food_restriction,
            eat_by_oneself, bathroom_freedom, sleep_routine, bunk_restriction,
            wake_up_at_night, sleep_enuresis, sleepwalk, observation, responsible_name,
            responsible_number)
            VALUES (?, ?, ?, ?, ?,
                    ?, ?, ?, ?,
                    ?, ?, ?, ?, ?,
                    ?);";
        $paramArray = array($summerCampId, $colonistId, $sleepOut, $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible);
        $campId = $this->executeReturningId($this->db, $sql, $paramArray);
        if ($campId)
            return $campId;
        throw new ModelException("Insert object in the database");
    }

    public function updateSummerCampMini($summerCampId, $colonistId, $sleepOut, $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible) {
        $sql = "UPDATE mini_colonist_observations
                SET sleep_out=?, wake_up_early=?,
                    food_restriction=?, eat_by_oneself=?, bathroom_freedom=?, sleep_routine=?,
                    bunk_restriction=?, wake_up_at_night=?, sleep_enuresis=?, sleepwalk=?,
                    observation=?, responsible_name=?, responsible_number=?
                WHERE summer_camp_id=? and colonist_id=?;";
        $paramArray = array($sleepOut, $wakeUpEarly, $foodRestriction, $feedsIndependently, $wcIndependent, $routineToFallAsleep, $bunkBed, $awakeAtNight, $sleepEnuresis, $sleepwalk, $observationMini, $nameResponsible, $phoneResponsible, $summerCampId, $colonistId);
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

    public function checkQueueNumberAvailability($userId, $summerCamps, $position){
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "SELECT *
                FROM summer_camp_subscription scs
                WHERE
                    person_user_id != ?
                    AND summer_camp_id in (".$summerCamps.")
                    AND queue_number = ?";
        $resultSet = $this->executeRow($this->db, $sql, array(intval($userId), intval($position)));
        if ($resultSet)
            return false;
        return true;
    }

    public function updateQueueNumber($userId, $summerCamps, $position) {
        $this->Logger->info("Running: " . __METHOD__);
        $sql = "UPDATE summer_camp_subscription
                SET queue_number = ?
                WHERE
                    person_user_id = ?
                    AND summer_camp_id in (".$summerCamps.")";
        return $this->execute($this->db, $sql, array(intval($position), intval($userId)));
    }

}

?>