<?php
    class CieloTransaction {
        private $tId;
        private $payment_type;
        private $payment_portions;
        private $cardflag;
        private $donation_id;
        private $payment_status;
        private $date_created;
        private $date_updated;
        private $transaction_value;

        public function __construct($tId, $payment_type, $payment_portions, $cardflag, $donation_id, $payment_status, $date_created, $date_updated, $transaction_value) {
            $this -> tId = $tId;
            $this -> payment_type = $payment_type;
            $this -> payment_portions = $payment_portion;
            $this -> cardflag = $cardflag;
            $this -> donation_id = $donation_id;
            $this -> payment_status = $payment_status;
            $this -> date_created = $date_created;
            $this -> date_updated = $date_updated;
            $this -> transaction_value = $transaction_value;
        }
        
        public static function loadCieloTransactionObject($resultRow){
            return new CieloTransaction(
                $resultRow->tId,
                $resultRow->payment_type,
                $resultRow->payment_portion,
                $resultRow->cardflag,
                $resultRow->donation_id,
                $resultRow->payment_status,
                $resultRow->date_created,
                $resultRow->date_updated,
                $resultRow->transaction_value
            );
        }
        

        function setTId($tId) {
            $this -> tId = $tId;
        }

        function getTId() {
            return $this -> tId;
        }

        function setPayment_type($payment_type) {
            $this -> payment_type = $payment_type;
        }

        function getPayment_type() {
            return $this -> payment_type;
        }

        function setPayment_portions($payment_portions) {
            $this -> payment_portions = $payment_portions;
        }

        function getPayment_portions() {
            return $this -> payment_portions;
        }

        function setCardflag($cardflag) {
            $this -> cardflag = $cardflag;
        }

        function getCardflag() {
            return $this -> cardflag;
        }

        function setDonation_id($donation_id) {
            $this -> donation_id = $donation_id;
        }

        function getDonation_id() {
            return $this -> donation_id;
        }

        function setPayment_status($payment_status) {
            $this -> payment_status = $payment_status;
        }

        function getPayment_status() {
            return $this -> payment_status;
        }

        function setDate_created($date_created) {
            $this -> date_created = $date_created;
        }

        function getDate_created() {
            return $this -> date_created;
        }

        function setDate_updated($date_updated) {
            $this -> date_updated = $date_updated;
        }

        function getDate_updated() {
            return $this -> date_updated;
        }

        function setTransaction_value($transaction_value) {
            $this -> transaction_value = $transaction_value;
        }

        function getTransaction_value() {
            return $this -> transaction_value;
        }

    }
?>