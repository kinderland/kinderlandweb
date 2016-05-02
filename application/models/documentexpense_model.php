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
}

?>