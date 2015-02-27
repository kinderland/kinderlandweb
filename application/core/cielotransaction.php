<?php

    function extract_payment_type($cardflag) {

        if ($cardflag === "maestro" || $cardflag === "visaelectron") {
            return "debito";
        } else {
            return "credito";
        }

    }

    function extract_real_cardflag($cardflag) {

        if ($cardflag === "maestro")
            return "mastercard";
        if ($cardflag === "visaelectron")
            return "visa";
        return $cardflag;

    }

    function addZero($value) {
        if ($value < 10) {
            return "0" . $value;
        }
        return $value;
    }

    function defineCieloProductCode($payment_type, $payment_portions) {

        if ($payment_type === "credito") {
            return $payment_portions === "1" ? $payment_portions : "2";
        } else {
            return "A";
        }
    }

    function getCieloDateNow() {
        date_default_timezone_set('America/Sao_Paulo');
        $today = getdate();
        return toCieloDate($today);
    }

    function toCieloDate($date) {
        $dateCielo = $date["year"];
        $dateCielo .= "-" . addZero($date["mon"]);
        $dateCielo .= "-" . addZero($date["mday"]);
        $dateCielo .= "T" . addZero($date["hours"]);
        $dateCielo .= ":" . addZero($date["minutes"]);
        $dateCielo .= ":" . addZero($date["seconds"]);
        return $dateCielo;
    }

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
        const CIELO_SHOP_ID_TEST = 1001734898;
        const CIELO_SHOP_KEY_TEST = "e84827130b9837473681c2787007da5914d6359947015a5cdb2b8843db0fa832";
        const CIELO_URL_TEST = "https://qasecommerce.cielo.com.br/servicos/ecommwsec.do";

        public function __construct($tId, $payment_type, $payment_portions, $cardflag, $donation_id, $payment_status, $date_created, $date_updated, $transaction_value) {
            $this -> tId = $tId;
            $this -> payment_type = $payment_type;
            $this -> payment_portions = $payment_portions;
            $this -> cardflag = $cardflag;
            $this -> donation_id = $donation_id;
            $this -> payment_status = $payment_status;
            $this -> date_created = $date_created;
            $this -> date_updated = $date_updated;
            $this -> transaction_value = $transaction_value;
        }

        public static function createCieloTransaction($donation_id, $transaction_value, $cardflag, $payment_portions) {
            $payment_type = extract_payment_type($cardflag);
            $cardflag = extract_real_cardflag($cardflag);
            return new CieloTransaction(NULL, $payment_type, $payment_portions, $cardflag, $donation_id, NULL, NULL, NULL, $transaction_value);
        }

        function createTransactionCieloBuyPage($description) {

            $xml = $this -> generateTransactionXML($description);

            $url = CieloTransaction::CIELO_URL_TEST;

            $params = array("mensagem" => $xml);

            //Opções de contexto para garantir um cabeçalho HTTP bem formado
            $opts = array('http' => array('header' => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query($params)), "ssl" => array("ciphers" => 'AES256-SHA'), );

            $stream = stream_context_create($opts);

            $result = file_get_contents($url, false, $stream);

            $XML = simplexml_load_string($result);

            return $XML;
        }

        function generateTransactionXML($description) {
            $date = getCieloDateNow();
            $productCodeCielo = defineCieloProductCode($this -> payment_type, $this -> payment_portions);
            $authCode = ($productCodeCielo === "A") ? "2" : "3";
            $transaction_value = preg_replace("/\D/", "", $this -> transaction_value);

            // Codigo informando que queremos uma transação.
            $xml = " <requisicao-transacao id=\"b646a02f-9983-4df8-91b9-75b48345715a\" versao=\"1.3.0\"> ";
            // Numero do comerciante
            $xml .= " <dados-ec> " . " <numero>" . CieloTransaction::CIELO_SHOP_ID_TEST . "</numero> ";
            //Chave do comerciante
            $xml .= " <chave>" . CieloTransaction::CIELO_SHOP_KEY_TEST . "</chave> ";
            //Numero do pagamento, por enquanto só temos tId que só recebemos
            // depois então estou usando donation_id
            $xml .= " </dados-ec> " . " <dados-pedido> " . " <numero>" . $this -> donation_id . "</numero> ";
            //Valor e data em formato cielo
            $xml .= " <valor>" . $transaction_value . "</valor> " . " <moeda>986</moeda> " . " <data-hora>" . $date . "</data-hora> ";
            // Descrição do pagamento.
            $xml .= " <descricao>[origem:172.16.34.66] " . $description . "</descricao> " . " <idioma>PT</idioma> " . " <soft-descriptor></soft-descriptor> ";
            //Bandeira e codigo de produto
            $xml .= " </dados-pedido> " . " <forma-pagamento> " . " <bandeira>" . $this -> cardflag . "</bandeira> " . " <produto>" . $productCodeCielo . "</produto> ";
            //Parcelas
            $xml .= " <parcelas>" . $this -> payment_portions . "</parcelas> " . " </forma-pagamento> ";
            //Define url que deve tratar o retorno
            $xml .= " <url-retorno>" . site_url("payments/resultadoPagamentoSimples") . "?tId=" . $this -> donation_id . "</url-retorno> ";
            //Code de autenticação 3 significa Pular autenticação.
            $xml .= " <autorizar>" . $authCode . "</autorizar> ";
            $xml .= " <capturar>true</capturar> ";
            $xml .= " <gerar-token>false</gerar-token> " . " </requisicao-transacao>";
            return $xml;
        }

        public static function loadCieloTransactionObject($resultRow) {
            return new CieloTransaction($resultRow -> tid, $resultRow -> payment_type, $resultRow -> payment_portions, $resultRow -> cardflag, $resultRow -> donation_id, $resultRow -> payment_status, $resultRow -> date_created, $resultRow -> date_updated, $resultRow -> transaction_value);
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