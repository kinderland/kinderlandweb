<?php
    require_once APPPATH . 'core/CK_Model.php';

    class cielotransaction_model extends CK_Model {
        const SelectQuery = 'Select tid, payment_type, cardflag, payment_portions, donation_id, description as payment_status, date_created, date_updated, transaction_value 
        from cielo_transaction join payment_status on cielo_transaction.payment_status = payment_status.payment_status ';

        public function __construct() {
            parent::__construct();
        }

        public function getAllPayments() {
            $sql = self::SelectQuery;
            $resultSet = $this -> executeRows($this -> db, $sql);
            $paymentsArray = array();

            if ($resultSet)
                foreach ($resultSet as $row)
                    $paymentsArray[] = CieloTransaction::loadCieloTransactionObject($row);

            return $paymentsArray;
        }

        public function getAllPaymentsByDonationId($donation_id) {
            $sql = self::SelectQuery . " where donation_id = $donation_id order by date_created";
            $resultSet = $this -> executeRows($this -> db, $sql);
            $paymentsArray = array();

            if ($resultSet)
                foreach ($resultSet as $row)
                    $paymentsArray[] = CieloTransaction::loadCieloTransactionObject($row);
				
            return $paymentsArray;
        }

        public function getPaymentById($tId) {
            $sql = self::SelectQuery . " WHERE tid=?";

            $resultSet = $this -> executeRow($this -> db, $sql, array($tId));

            if ($resultSet)
                return CieloTransaction::loadCieloTransactionObject($resultSet);

            return null;
        }

        public function updatePaymentStatus($payment, $status) {
            $payment->setPayment_status($status);

            $sql = "update cielo_transaction set payment_status = ?, date_updated = NOW() WHERE tid=?";

            $resultSet = $this -> execute($this -> db, $sql, array($status, $payment -> getTId()));

            return $resultSet;
        }

        public function insertNewPayment($payment) {
            $sql = 'INSERT INTO cielo_transaction (tid, payment_type, cardflag, payment_portions, donation_id,payment_status,date_created,date_updated,transaction_value)
         VALUES (?, ?, ?, ?, ?,0,NOW(),NOW(),?)';
            $returnId = $this -> execute($this -> db, $sql, array((string)$payment -> getTId(), $payment -> getPayment_type(), $payment -> getCardflag(), $payment -> getPayment_portions(), $payment -> getDonation_id(), $payment -> getTransaction_value()));
            return $payment;
            if ($returnId)
                return $returnId;

            return false;
        }
		
		public function statisticsPaymentsByCardFlag($searchfor,$option){
			$where = "";
			if($searchfor !== FALSE){
				$where = "where payment_status = $searchfor";
			}
			if($option == PAYMENT_REPORTBYCARD_QUANTITY)
				$aggregator = "count(distinct donation_id)";
			else if ($option == PAYMENT_REPORTBYCARD_VALUES)
				$aggregator = "sum(transaction_value)";

            $sql = "Select payment_type,cardflag,payment_portions,".$aggregator." as aggregator from cielo_transaction $where group by payment_type,cardflag,payment_portions";

            $resultSet = $this -> executeRows($this -> db, $sql);
			$result = array();
			foreach($resultSet as $row){
				$payment_type = $row->payment_type;
				$cardflag = $row->cardflag;
				$payment_portions = $row->payment_portions;
				$result[$payment_type][$cardflag][$payment_portions] = $row->aggregator;
			}

            return $result;

			
		}

    }
?>