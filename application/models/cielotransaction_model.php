<?php
    require_once APPPATH . 'core/CK_Model.php';
    require_once APPPATH . 'core/cielotransaction.php';

    class cielotransaction_model extends CK_Model {
        const SelectQuery = 'Select tid, payment_type, cardflag, payment_portions, donation_id, description as payment_status, date_created, date_updated, transaction_value 
        from cielo_transaction join payment_status on cielo_transaction.payment_status = payment_status.payment_status ';

        public function __construct() {
            parent::__construct();
        }

        public function getPaymentYears() {
			$this -> Logger -> info("Running: " . __METHOD__);
        	$sql = "Select distinct to_char(date_created, 'YYYY') as ano from cielo_transaction";
            $resultSet = $this -> executeRows($this -> db, $sql);
            $yearsArray = array();

            if ($resultSet)
                foreach ($resultSet as $row)
					$yearsArray[] = $row->ano;
			
			return $yearsArray;			

		}


        public function getAllPayments() {
			$this -> Logger -> info("Running: " . __METHOD__);
            $sql = self::SelectQuery;
            $resultSet = $this -> executeRows($this -> db, $sql);
            $paymentsArray = array();

            if ($resultSet)
                foreach ($resultSet as $row)
                    $paymentsArray[] = CieloTransaction::loadCieloTransactionObject($row);

            return $paymentsArray;
        }

        public function getPaymentsDetailed($ano = FALSE) {
			$this -> Logger -> info("Running: " . __METHOD__);
			$where = "";
        	if($ano)
				$where = " where to_char(ct.date_created, 'YYYY') = ? ";
            $sql = "Select to_char(ct.date_created, 'DD/MM/YY HH24:MI:SS') as date_created, payment_type,ct.tid, ps.description as description,
            p.fullname,ct.cardflag,ct.payment_portions, d.donated_value as value, dt.description as reason from 
            cielo_transaction ct join payment_status ps on ct.payment_status = ps.payment_status 
            join donation d on d.donation_id = ct.donation_id join person p on p.person_id = d.person_id
            join donation_type dt on dt.donation_type = d.donation_type $where 
            order by ct.date_created desc";
			if(!$ano)
	            $resultSet = $this -> executeRows($this -> db, $sql);
			else
	            $resultSet = $this -> executeRows($this -> db, $sql,array($ano));				 
            $paymentsArray = array();

            if ($resultSet)
                foreach ($resultSet as $row){
                 	$payment = array();
					$payment["date_created"] = $row->date_created;
					$payment["tid"] = $row->tid;
					$payment["payment_status"] = $row->description;
					$payment["name"] = $row->fullname;
					$payment["cardflag"] = $row->payment_type." ".$row->cardflag;						
					$payment["payment_portions"] = $row->payment_portions;
					$payment["value"] = $row->value;						
					$payment["reason"] = $row->reason;						
					$paymentsArray[] = $payment;
				}

            return $paymentsArray;
        }


        public function getAllPaymentsByDonationId($donation_id) {
        	$this -> Logger -> info("Running: " . __METHOD__);
            $sql = self::SelectQuery . " where donation_id = $donation_id order by date_created";
            $resultSet = $this -> executeRows($this -> db, $sql);
            $paymentsArray = array();

            if ($resultSet)
                foreach ($resultSet as $row)
                    $paymentsArray[] = CieloTransaction::loadCieloTransactionObject($row);
				
            return $paymentsArray;
        }

        public function getPaymentById($tId) {
			$this -> Logger -> info("Running: " . __METHOD__);    	
            $sql = self::SelectQuery . " WHERE tid=?";
            $resultSet = $this -> executeRow($this -> db, $sql, array($tId));

            if ($resultSet)
                return CieloTransaction::loadCieloTransactionObject($resultSet);

            return null;
        }

        public function updatePaymentStatus($payment, $status) {
			$this -> Logger -> info("Running: " . __METHOD__);
            $payment->setPayment_status($status);

            $sql = "update cielo_transaction set payment_status = ?, date_updated = NOW() WHERE tid=?";

            $resultSet = $this -> execute($this -> db, $sql, array($status, $payment -> getTId()));

            return $resultSet;
        }

        public function insertNewPayment($payment) {
			$this -> Logger -> info("Running: " . __METHOD__);
            $sql = 'INSERT INTO cielo_transaction (tid, payment_type, cardflag, payment_portions, donation_id,payment_status,date_created,date_updated,transaction_value)
         VALUES (?, ?, ?, ?, ?,0,NOW(),NOW(),?)';
            $returnId = $this -> execute($this -> db, $sql, array((string)$payment -> getTId(), $payment -> getPayment_type(), $payment -> getCardflag(), $payment -> getPayment_portions(), $payment -> getDonation_id(), $payment -> getTransaction_value()));
            return $payment;
            if ($returnId)
                return $returnId;

            return false;
        }
		
		public function statisticsPaymentsByCardFlag($searchfor,$option,$year,$month=FALSE){
			$this -> Logger -> info("Running: " . __METHOD__);
			$where = "where EXTRACT(YEAR FROM date_created) = $year ";
			if($searchfor !== FALSE){
				$where .= " and payment_status = $searchfor ";
			}
			if($month !== FALSE){
				$where .= " and EXTRACT(MONTH from date_created) = $month ";
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