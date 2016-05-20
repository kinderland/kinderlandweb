<?php

require_once APPPATH . 'core/CK_Model.php';

class finance_model extends CK_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getDocumentInformationsById($document_id){
		$sql = "SELECT * FROM document_expense WHERE document_expense_id = ?";
		 
		$result = $this->executeRow($this->db, $sql, array(intval($document_id)));
				 
		if($result)
			return $result;
		else
			return NULL;
	}
	
	public function getPostingsExpensesByDate($year,$month = null){
		$sql = "SELECT *
				FROM v_all_posting_expenses_info 
				WHERE DATE_PART('YEAR',posting_date) = ?";
		 
		if($month){
			$sql = $sql."AND DATE_PART('MONTH',posting_date) = ? ORDER BY posting_date ASC";
	
			$result = $this->executeRows($this->db, $sql, array(intval($year),intval($month)));
		}else {
			$sql = $sql."ORDER BY posting_date ASC";
			$result = $this->executeRows($this->db, $sql, array(intval($year)));
		}
		 
		if($result)
			return $result;
		else
			return NULL;
	}
	
	public function getAllAccountsInformations(){
		$sql = "SELECT a.account_name as account_name, a.description as account_description, at.name as account_type 
				FROM account a
				INNER JOIN account_type at ON a.account_type_id = at.account_type_id
				ORDER BY a.account_name ASC";
			
		$result = $this->executeRows($this->db, $sql);
			
		if($result)
			return $result;
		else
			return NULL;
	}
	
	public function getAllAccountTypes(){
		$sql = "SELECT *
				FROM account_type";
			
		$result = $this->executeRows($this->db, $sql);
			
		if($result)
			return $result;
		else
			return NULL;
	}
	
	public function getAllAccountNames(){
		$sql = "SELECT account_name FROM account";
		 $result = $this->executeRows($this->db, $sql);
		 if($result)
			return $result;
		else
			return NULL;
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
	
	public function insertNewAccount($account_name, $account_type, $account_description) {

		$sql = 'INSERT INTO account(account_name, description, account_type_id) VALUES (?,?,?)';

		$returnId = $this -> executeReturningId($this -> db, $sql, array($account_name, $account_description, intval($account_type)));

		if ($returnId)
			return $returnId;

		return false;
	}
}