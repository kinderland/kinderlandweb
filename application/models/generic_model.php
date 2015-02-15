<?php
	class generic_model extends CI_Model{
		public function __construct(){
			parent::__construct();
		}

		public function startTransaction(){
			$this->db->query("BEGIN TRANSACTION");
		}

		public function commitTransaction(){
			$this->db->query("COMMIT TRANSACTION");
		}

		public function rollbackTransaction(){
			$this->db->query("ROLLBACK");
		}
	}
?>