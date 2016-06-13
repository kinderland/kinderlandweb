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
	
	public function getPostingExpenseById($document_id,$posting_portions){
		$sql = "SELECT * FROM posting_expense 
				WHERE document_expense_id = ?
				AND posting_portions = ?";
			
		$result = $this->executeRow($this->db, $sql, array(intval($document_id),$posting_portions));
			
		if($result)
			return $result;
			else
				return NULL;
	}
	
	public function getPeopleOperationByPostingExpense(){
		
		$sql = "SELECT *
				FROM posting_expense pe
				INNER JOIN posting_expense_log pel ON pe.document_expense_id = pel.document_expense_id AND pe.posting_portions = pel.posting_portions
				WHERE pel.log_type = 'criou forma de pag'
				AND pe.payment_status = 'caixinha'";
		
		$result = $this->executeRows($this->db,$sql);
		
		if($result)
			return $result;
		else 
			return null;
		
	}
	
	public function togglePostingExpensePayed($document_id,$posting_portions,$posting_date) {
		$this -> Logger -> info("Running: " . __METHOD__);
		
		$payed = 'select payment_status from posting_expense
				  WHERE document_expense_id = ?
				  AND posting_portions = ?';
		
		$result = $this -> executeRow($this -> db, $payed, array(intval($document_id),$posting_portions));
	
		if($result->payment_status == 'pago'){
			
			$sql = "update posting_expense set payment_status = 'a pagar', posting_date = ? 
					WHERE document_expense_id = ?
					AND posting_portions = ?";
		
			$posting_date = null;
			$log_type = "desfez pagamento";
			
		} else if($result->payment_status == 'a pagar'){
			
			$sql = "update posting_expense set payment_status = 'pago', posting_date = ? 
					WHERE document_expense_id = ?
					AND posting_portions = ?";
			
			$log_type = "pagou";
		}
	
		$toggle = $this -> execute($this -> db, $sql, array($posting_date,intval($document_id),$posting_portions));
		
		if($toggle)
			$postingExpense = $this -> getPostingExpenseById($document_id,$posting_portions);
		
		if($postingExpense){
			$person_id = $this -> session -> userdata('user_id');
			$log = $this -> insertNewLog($person_id, $document_id, $posting_date, $postingExpense -> posting_value, $posting_portions, $log_type);
			
			if($log)
				return $log;
			else 
				return null;
			
		}else{
			return null;
		}
	
	}
	
	
	public function insertNewLog($person_id, $document_expense_id, $posting_date, $posting_value, $posting_portions, $log_type) {
	
		$log = 'INSERT INTO posting_expense_log(person_id, document_expense_id, posting_date, posting_value, log_date, posting_portions, log_type) VALUES (?,?,?,?,current_timestamp,?,?)';
	
		$result = $this -> execute($this -> db, $log, array(intval($person_id), intval($document_expense_id), $posting_date, $posting_value, $posting_portions, $log_type));
	
		if ($result)
			return $result;
	
		return false;
	}
	
	public function getPostingsExpensesByBankSlipDate($year,$month = null){
		$sql = "SELECT *
				FROM v_all_posting_expenses_info 
				WHERE DATE_PART('YEAR',bank_slip_date) = ?";
		 
		if($month){
			$sql = $sql." AND DATE_PART('MONTH',bank_slip_date) = ?
						  ORDER BY bank_slip_date ASC"; 
	
			$result = $this->executeRows($this->db, $sql, array(intval($year),intval($month)));
		}else {
			$sql = $sql." ORDER BY bank_slip_date ASC";
			
			$result = $this->executeRows($this->db, $sql, array(intval($year)));
		}
		 
		if($result)
			return $result;
		else
			return NULL;
	}
	
	public function getPostingsExpensesNotPayed($year,$month){
		$sql = "SELECT *
				FROM v_all_posting_expenses_info
				WHERE payment_status = 'a pagar'
				AND (DATE_PART('YEAR',posting_date) = ? OR DATE_PART('YEAR',bank_slip_date) = ?)
				AND (DATE_PART('MONTH',posting_date) < ? OR DATE_PART('MONTH',bank_slip_date) < ?)
				ORDER BY bank_slip_date,posting_date ASC";
	
		$result = $this->executeRows($this->db, $sql, array(intval($year),intval($year),intval($month),intval($month)));
		
		if($result)
			return $result;
		else
			return NULL;
	}
	
	public function getPostingsExpensesByPostingDate($year,$month = null){
		$sql = "SELECT *
				FROM v_all_posting_expenses_info
				WHERE posting_type != 'Boleto'
				AND DATE_PART('YEAR',posting_date) = ?";
			
		if($month){
			$sql = $sql." AND DATE_PART('MONTH',posting_date) = ?
						  ORDER BY posting_date ASC";
	
			$result = $this->executeRows($this->db, $sql, array(intval($year),intval($month)));
		}else {
			$sql = $sql." ORDER BY posting_date ASC";
				
			$result = $this->executeRows($this->db, $sql, array(intval($year)));
		}
			
		if($result)
			return $result;
		else
			return NULL;
	}
	
	public function getDocumentsByDate($year,$month = null){
		$sql = "SELECT *
				FROM v_all_posting_expenses_info
				WHERE DATE_PART('YEAR',log_date) = ?";
			
		if($month){
			$sql = $sql." AND DATE_PART('MONTH',log_date) = ?
						 ORDER BY log_date ASC";
	
			$result = $this->executeRows($this->db, $sql, array(intval($year),intval($month)));
		}else {
			$sql = $sql." ORDER BY log_date ASC";
				
			$result = $this->executeRows($this->db, $sql, array(intval($year)));
		}
			
		if($result)
			return $result;
		else
			return NULL;
	}
	
	public function getPostingsExpensesWithoutDate(){
		$sql = "SELECT *
				FROM v_all_posting_expenses_info
				WHERE posting_date is null
				AND posting_value is not null
				AND posting_portions is not null
				AND posting_type != 'Boleto'";
				
		$result = $this->executeRows($this->db, $sql);
			
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
		$sql = "SELECT a.account_name as account_name, a.description as account_description, a.account_type_id as account_type_id, at.name as account_type 
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
				FROM account_type
				ORDER BY name ASC";
			
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
	
	public function updateAccountName($document_id, $posting_portions, $account_name) {
	
		$this -> Logger -> info("Running: " . __METHOD__);
	
		$sql = 'UPDATE posting_expense SET account_name = ?
				WHERE document_expense_id = ?
				AND posting_portions = ?';
	
		$returnId = $this -> execute($this -> db, $sql, array($account_name, $document_id, $posting_portions));
	
		if ($returnId)
			return $returnId;
	
		return false;
	}

	public function insertNewAccount($account_name, $account_type, $account_description) {

		$sql = 'INSERT INTO account(account_name, description, account_type_id) VALUES (?,?,?)';

		$returnId = $this -> execute($this -> db, $sql, array($account_name, $account_description, intval($account_type)));

		if ($returnId)
			return $returnId;

		return null;
	}
	
	public function insertNewAccountType($account_type_name) {
	
		$sql = 'INSERT INTO account_type(name) VALUES (?)';
	
		$returnId = $this -> executeReturningId($this -> db, $sql, array($account_type_name));
	
		if ($returnId)
			return $returnId;
	
		return false;
	}
	
	public function deleteAccount($account_name){
		$this -> Logger -> info("Running: " . __METHOD__);
	
		$deleteSql = 'DELETE FROM account WHERE account_name = ?';
	
		return $this->execute($this->db, $deleteSql, array($account_name));
	}
	
	public function deleteAccountType($account_type_id){
		$this -> Logger -> info("Running: " . __METHOD__);
	
		$deleteSql = 'DELETE FROM account_type WHERE account_type_id = ?';
	
		return $this->execute($this->db, $deleteSql, array($account_type_id));
	}
        
        public function hasPostingUpload($id,$portions){
            $sql = "SELECT posting_expense_upload_id FROM posting_expense WHERE document_expense_id=? AND posting_portions=?";
            $result=$this->executeRow($this->db,$sql,array($id,$portions));
            if (!(empty($result->posting_expense_upload_id)) && isset($result->posting_expense_upload_id)){
                return $result->posting_expense_upload_id;
            }
            return 0;
        }
}