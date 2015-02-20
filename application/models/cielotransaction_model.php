<?php

    class cielotransaction_model extends CI_Model {
        const SelectQuery = 'Select tid, payment_type, cardflag, payment_portions, donation_id, description as payment_status, date_created, date_updated, transaction_value 
        from cielo_transaction join payment_status on cielo_transaction.payment_status = payment_status.payment_status ';
        
        public function __construct() {
            parent::__construct();
        }

        public function getAllPayments() {
            $sql = self::SelectQuery;
            $resultSet = $this -> db -> query($sql);

            $paymentsArray = array();

            if ($resultSet -> num_rows() > 0)
                foreach ($resultSet->result() as $row)
                    $paymentsArray[] = CieloTransaction::loadCieloTransactionObject($row);

            return $paymentsArray;
        }

        public function getPaymentById($tId) {
            $sql = self::SelectQuery." WHERE tid=?";
            
            $resultSet = $this -> db -> query($sql, array(intval($tId)));

            if ($resultSet -> num_rows() > 0)
                return CieloTransaction::loadCieloTransactionObject($resultSet -> row());

            return null;
        }

    }
?>