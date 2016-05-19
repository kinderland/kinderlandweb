<?php
require_once APPPATH . 'core/CK_Model.php';
require_once APPPATH . 'core/document_expense.php';
require_once APPPATH . 'core/bankdata.php';
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
    
    public function getAllBankData(){
    	$sql = "SELECT * FROM bank_data";
    	$resultSet = $this->executeRows($this->db, $sql);
    	
    	$bankdataArray = array();
    	
    	if ($resultSet)
    		foreach ($resultSet as $row)
    			$bankdataArray[] = BankData::createBankDataObject($row);
    	
    			return $bankdataArray;
    	
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
        
        public function insertNewPostingExpense($documentexpenseId,$postingDate,$postingValue,$postingType,$accountName){
        	$sql = "INSERT into posting_expense (document_expense_id, posting_date, posting_value, posting_type, account_name)
					VALUES (?,?,?,?,?)";
        	$Id=$this->executeReturningId($this->db,$sql,array($documentexpenseId,$postingDate,$postingValue,$postingType,$accountName));
        	return $Id;
        }
        
        public function insertNewPostingCreditCardPayment($portions,$documentexpenseId,$postingDate,$postingValue){
        	$sql = "INSERT into posting_credit_card (portions, document_expense_id, posting_date, posting_value)
					VALUES (?,?,?,?)";
        	$Id=$this->executeReturningId($this->db,$sql,array($portions,$documentexpenseId,$postingDate,$postingValue));
        	return $Id;
        	
        }
        
        public function insertNewBankTransferPayment($bankDataId,$documentexpenseId,$postingDate,$postingValue){
        	$sql = "INSERT into posting_bank_transfer(bank_data_id, document_expense_id, posting_date, posting_value)
					VALUES (?,?,?,?)";
        	$Id=$this->executeReturningId($this->db,$sql,array($bankDataId,$documentexpenseId,$postingDate,$postingValue));
        	return $Id;
        	
        }
        
        public function insertNewBankSlipPayment($portionNumber,$documentexpenseId,$postingDate,$postingValue){
        	$sql = "INSERT into posting_bank_slip (portion_number, document_expense_id, posting_date, posting_value)
					VALUES (?,?,?,?)";
        	$Id=$this->executeReturningId($this->db,$sql,array($portionNumber,$documentexpenseId,$postingDate,$postingValue));
        	return $Id;
        	
        }
        
        public function inserNewBankCheckPayment($check_number,$documentexpenseId,$postingDate,$postingValue){
        	$sql = "INSERT into posting_bank_check(check_number, document_expense_id, posting_date, posting_value)
					VALUES (?,?,?,?)";
        	$Id=$this->executeReturningId($this->db,$sql,array($check_number,$documentexpenseId,$postingDate,$postingValue));
        	return $Id;        	
        	
        }
        
        public function InsertNewDocument($date,$number,$description,$type,$value,$name){
            $sql="INSERT INTO document_expense (document_number,document_date,document_type,description,document_value, document_name)
                  VALUES (?,?,?,?,?,?)";
            $Id=$this->executeReturningId($this->db,$sql,array($number,$date,$type,$description,$value,$name));
            return $Id;
        }
        
        public function updateDocument($id, $date,$number,$description,$value,$name){
         $sql = "UPDATE document_expense SET "
                 . "document_date = ?, "
                 . "document_number=?, "
                 . "description=?, "
                 . "document_value=? "
                 . "document_name=? "
                 . "WHERE document_expense_id='?'";
         $resultSet = $this->execute($this->db, $sql, array($date,$number,$description,$value,$name,intval($id)));
         return $resultSet;
        }
}

?>