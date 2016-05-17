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
	
	
	public function getDocumentExpensePaidById($documentexpenseId){
		$sql = "select distinct document_expense_id
				from posting_expense
				where document_expense_id = ?
				";
		$resultSet = $this->executeRows($this->db, $sql, array($documentexpenseId));

        if ($resultSet)
            return $resultSet;
        else
            return null;
    }
    	

        
        public function getDocumentById($id){
            $sql="SELECT * FROM document_expense WHERE document_expense_id=?";
            $document=$this->executeRow($this->db,$sql,$id);
            if ($document){
                $documentObject=DocumentExpense::createDocumentExpenseObject($document);
                return $documentObject;
            }
            return false;
        }
        
        public function InsertNewDocument($date,$number,$description,$type,$value){
            $sql="INSERT INTO document_expense (document_number,document_date,document_type,description,document_value)
                  VALUES (?,?,?,?,?)";
            $Id=$this->executeReturningId($this->db,$sql,array($number,$date,$type,$description,$value));
            return $Id;
        }
        
        public function updateDocument($id, $date,$number,$description,$value){
         $sql = "UPDATE document_expense SET "
                 . "document_date = ?, "
                 . "document_number=?, "
                 . "description=?, "
                 . "document_value=? "      
                 . "WHERE document_expense_id='?'";
         $resultSet = $this->execute($this->db, $sql, array($date,$number,$description,$value,intval($id)));
         return $resultSet;
        }
}

?>