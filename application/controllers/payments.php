<?php
    require_once APPPATH . 'core/CK_Controller.php';
    require_once APPPATH . 'core/cielotransaction.php';
    class Payments extends CK_Controller {

        public function __construct() {
            parent::__construct();
            $this -> load -> helper('url');
            $this -> load -> model('cielotransaction_model');
            $this->cielotransaction_model->setLogger($this->Logger);
        }

        public function index() {
            $this -> Logger -> info("Starting " . __METHOD__);
            $transactionList = $this -> cielotransaction_model -> getAllPayments();
            $data['transactions'] = $transactionList;
            $this -> loadView("payments/home", $data);
        }

        public function info($tId) {
            $this -> Logger -> info("Starting " . __METHOD__);

            $transaction = $this -> cielotransaction_model -> getPaymentById($tId);
            $data['transaction'] = $transaction;
            
            $this -> loadView('payments/info', $data);
        }

        public function test() {
            $this -> Logger -> info("Starting " . __METHOD__);

            $data = "";
            $this -> loadView("payments/test", $data);
        }

        public function executarPagamentoSimples() {
            $this -> Logger -> info("Starting " . __METHOD__);

            $donation_id = $this -> input -> post('donation_id', TRUE);
            $transaction_value = $this -> input -> post('transaction_value', TRUE);
            $description = $this -> input -> post('description', TRUE);
            $card_flag = $this -> input -> post('card_flag', TRUE);
            $payment_portions = $this -> input -> post('payment_portions', TRUE);

            $transaction_value = preg_replace("/\D/", ".", $transaction_value);
            

            $transaction = CieloTransaction::createCieloTransaction($donation_id, $transaction_value, $card_flag, $payment_portions);
            $xml = $transaction -> createTransactionCieloBuyPage($description);

            $status = $xml->status;
            if ($status == NULL || $status != "0") {
                $this -> Logger -> error("Erro ao iniciar operação com a Cielo, código de erro: " . $status . "\nDetalhes do erro: " . $xml);
                //TODO Pagina de erro.                
                return;
            }
            
            $tid = $xml->tid;
            $url_redirect = $xml->{'url-autenticacao'};
            if ($tid == NULL || $url_redirect == NULL || strlen($tid) < 3 || strlen($url_redirect) < 3) {
                $this -> Logger -> error("Mensagem inválida recebida da operadora.");
                //TODO Pagina de erro.                
                return;
            }

            $transaction -> setTId($tid);

            $data["data"] = $this -> cielotransaction_model -> insertNewPayment($transaction);
            header("Location: ".$url_redirect);
            die();
        }

    }
?>