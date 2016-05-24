<?php

class DocumentExpense {

    private $documentExpenseId;
    private $documentExpenseNumber;
    private $beneficiaryId;
    private $documentExpenseValue;
    private $documentExpenseDate;
    private $documentExpenseUploadId;
    private $documentExpenseType;
    private $documentExpenseDescription;
    private $documentExpenseName;
    private $documentPayed;

    public function __construct($documentExpenseId, $documentExpenseNumber, $beneficiaryId, $documentExpenseValue, $documentExpenseDate, $documentExpenseUploadId, $documentExpenseType, $documentExpenseDescription, $documentExpenseName, $documentPayed) {
        $this->documentExpenseId = $documentExpenseId;
        $this->documentExpenseNumber = $documentExpenseNumber;
        $this->beneficiaryId = $beneficiaryId;
        $this->documentExpenseValue = $documentExpenseValue;
        $this->documentExpenseDate = $documentExpenseDate;
        $this->documentExpenseUploadId = $documentExpenseUploadId;
        $this->documentExpenseType = $documentExpenseType;
        $this->documentExpenseDescription = $documentExpenseDescription;
        $this->documentExpenseName = $documentExpenseName;
        $this->documentPayed = $documentPayed;
    }

    public static function createDocumentExpenseObject($resultRow) {
        return new DocumentExpense(
                $resultRow->document_expense_id, $resultRow->document_number, $resultRow->beneficiary_id, $resultRow->document_value, $resultRow->document_date, $resultRow->document_expense_upload_id, $resultRow->document_type, $resultRow->description, $resultRow->document_name, $resultRow->payed
        );
    }

    public function setDocumentExpenseId($documentExpenseId) {
        $this->documentExpenseId = $documentExpenseId;
    }

    public function getDocumentExpenseId() {
        return $this->documentExpenseId;
    }

    public function setDocumentExpenseNumber($documentExpenseNumber) {
        $this->documentExpenseNumber = $documentExpenseNumber;
    }

    public function getDocumentExpenseNumber() {
        return $this->documentExpenseNumber;
    }

    public function setBeneficiaryId($beneficiaryId) {
        $this->beneficiaryId = $beneficiaryId;
    }

    public function getBeneficiaryId() {
        return $this->beneficiaryId;
    }

    public function setDocumentExpenseValue($documentExpenseValue) {
        $this->documentExpenseValue = $documentExpenseValue;
    }

    public function getDocumentExpenseValue() {
        return $this->documentExpenseValue;
    }

    public function setDocumentExpenseDate($documentExpenseDate) {
        $this->documentExpenseDate = $documentExpenseDate;
    }

    public function getDocumentExpenseDate() {
        return $this->documentExpenseDate;
    }

    public function setDocumentExpenseUploadId($documentExpenseUploadId) {
        $this->documentExpenseUploadId = $documentExpenseUploadId;
    }

    public function getDocumentExpenseUploadId() {
        return $this->documentExpenseUploadId;
    }

    public function setDocumentExpenseType($documentExpenseType) {
        $this->documentExpenseType = $documentExpenseType;
    }

    public function getDocumentExpenseType() {
        return $this->documentExpenseType;
    }

    public function setdocumentExpenseDescription($documentExpenseDescription) {
        $this->documentExpenseDescription = $documentExpenseDescription;
    }

    public function getDocumentExpenseDescription() {
        return $this->documentExpenseDescription;
    }

    public function setDocumentExpenseName($documentExpenseName) {
        $this->documentExpenseNumber = $documentExpenseName;
    }

    public function getDocumentExpenseName() {
        return $this->documentExpenseName;
    }
    
    public function setDocumentPayed($documentPayed) {
    	$this->documentPayed = $documentPayed;
    }
    
    public function getDocumentPayed() {
    	if ($this->documentPayed == "t")
    		return TRUE;
    	return FALSE;
    }

}

?>