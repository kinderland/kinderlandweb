<?php
require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/document_expense.php';

class documentexpense_model extends CK_Model {

	public function __construct() {
		parent::__construct();
	}
	
	public function getAllDocumentsExpense() {
		$sql = " SELECT * FROM document_expense ORDER BY document_date DESC";
		$resultSet = $this->executeRows($this->db, $sql);
	
		$documentArray = array();
	
		if ($resultSet)
			foreach ($resultSet as $row)
				$documentArray[] = DocumentExpense::createDocumentExpenseObject($row);
	
				return $documentArray;
	}
	
	public function getAllDocumentsExpensePayed($documentexpenseId){
		$sql = "select distinct document_expense_id
				from document_expense
				where document_expense_id = documentexpenseId and document_expense_id in(
					select document_expense_id
					from posting_expense
				)
				";
		$resultSet = $this->executeRows($this->db, $sql, array($documentexpenseId));
		
	
        if ($resultSet)
            return $resultSet;
        else
            return null;
    }
	
}

?>