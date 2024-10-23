<?php

class Model_navigation extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
  		}
      
	public function lists(){
		$result=$this->db->query("SELECT * FROM sys_menu")->result();
		return $result;
	}
	function get_menu(){
		$result=$this->db->query("SELECT * FROM sys_menu WHERE 1")->result();
		return $result;
	}
	public function checkBankToDelete($bank_id = ''){
		$this->db->where('id !=', $productId);
		$this->db->where('product_code', $productCode);
		$query = $this->db->get('products');
		if($query->num_rows() > 0) {
			return '1';
		} else {
			return '0';
		}
	}

}