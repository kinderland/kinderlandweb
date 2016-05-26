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
	
	public function getPostingsExpensesByDate($year,$type,$month = null){
		$sql = "SELECT *
				FROM v_all_posting_expenses_info 
				WHERE DATE_PART('YEAR',".$type."_date) = ?";
		 
		if($month){
			$sql = $sql."AND DATE_PART('MONTH',".$type."_date) = ?
						ORDER BY ".$type."_date ASC"; 
	
			$result = $this->executeRows($this->db, $sql, array(intval($year),intval($month)));
		}else {
			$sql = $sql."ORDER BY ".$type."_date ASC";
			
			$result = $this->executeRows($this->db, $sql, array(intval($year)));
		}
		 
		if($result)
			return $result;
		else
			return NULL;
	}
	
	public function getAllPostingExpenses(){
		$sql = "SELECT *
				FROM posting_expense";
		
		$result = $this->executeRows($this->db, $sql);		
			
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
		$sql = "SELECT account_name FROM account ORDER BY account_name ASC";
		 $result = $this->executeRows($this->db, $sql);
		 if($result)
			return $result;
		else
			return NULL;
	}
	
	public function updateAccountName($document_id, $posting_value, $posting_date, $account_name) {
	
		$this -> Logger -> info("Running: " . __METHOD__);
	
		$sql = 'UPDATE posting_expense SET account_name = ?
				WHERE document_expense_id = ?
				AND posting_value = ?
				AND posting_date = ?';
	
		$returnId = $this -> execute($this -> db, $sql, array($account_name, $document_id, $posting_value, $posting_date));
	
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
	
	public function deleteAccount($account_name){
		$this -> Logger -> info("Running: " . __METHOD__);
	
		$deleteSql = 'DELETE FROM account WHERE account_name = ?';
	
		return $this->execute($this->db, $deleteSql, array($account_name));
	}
}