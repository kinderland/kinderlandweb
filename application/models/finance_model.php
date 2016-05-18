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
}