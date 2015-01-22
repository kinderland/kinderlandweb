<?php
class teste_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	public function getInfo(){
		$sql = 'SELECT * FROM teste_table';
		$result = $this->db->query($sql);
		return $result->result();
	}
}
?>