<?php
class BankData {

	private $bankDataId;
	private $bankNumber;
	private $bankAgency;
	private $accountNumber;

	public function __construct($bankDataId, $bankNumber, $bankAgency, $accountNumber) {
		$this->bankDataId = $bankDataId;
		$this->bankNumber = $bankNumber;
		$this->bankAgency = $bankAgency;
		$this->accountNumber = $accountNumber;

	}

	public static function createBankDataObject($resultRow) {
		return new BankData(
				$resultRow->bank_data_id,
				$resultRow->bank_number,
				$resultRow->bank_agency,
				$resultRow->account_number
				);
	}

	public function setBankDataId($bankDataId) {
		$this->bankDataId = $bankDataId;
	}

	public function getBankDataId() {
		return $this->bankDataId;
	}

	public function setBankNumber($bankNumber) {
		$this->bankNumber = $bankNumber;
	}

	public function getBankNumber() {
		return $this->bankNumber;
	}

	public function setBankAgency($bankAgency) {
		$this->bankAgency = $bankAgency;
	}

	public function getBankAgency() {
		return $this->bankAgency;
	}

	public function setAccountNumber($accountNumber) {
		$this->accountNumber = $accountNumber;
	}

	public function getAccountNumber() {
		return $this->accountNumber;
	}
}

?>