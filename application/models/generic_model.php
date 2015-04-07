<?php
	require_once APPPATH . 'core/CK_Model.php';
	class generic_model extends CK_Model{
		public function __construct(){
			parent::__construct();
		}

		public function startTransaction(){
			$this->Logger->info("[START TRANSACTION]");
//			$this->db->query("BEGIN TRANSACTION");
			$this->db->trans_start();
		}

		public function commitTransaction(){
			$this->Logger->info("[COMMIT TRANSACTION]");
//			$this->db->query("COMMIT TRANSACTION");
			$this->db->trans_complete();
		}

		public function rollbackTransaction(){
			$this->Logger->info("[ROLLBACK TRANSACTION]");
//			$this->db->query("ROLLBACK");
			$this->db->trans_rollback();
		}
	}
?>