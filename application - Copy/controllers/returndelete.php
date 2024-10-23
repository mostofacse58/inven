<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Returndelete extends CI_Controller {
  function __construct() {
	  parent::__construct();
  }

 function index(){
		$lists=$this->db->query("SELECT * 
      FROM purchase_detail 
      WHERE status=5 AND department_id=17  ")->result();
   // print_r($lists); exit;

		  foreach ($lists as  $value){
        $data=array();
        $fifo=$value->FIFO_CODE;
        $product_id=$value->product_id;
        $this->db->WHERE('FIFO_CODE',$fifo);
        $this->db->WHERE('product_id',$product_id);
        $this->db->WHERE('department_id',17);
        $this->db->delete("item_issue_detail");
        //////////////////////////
        $this->db->WHERE('FIFO_CODE',$fifo);
        $this->db->WHERE('product_id',$product_id);
        $this->db->WHERE('department_id',17);
        $this->db->WHERE('TRX_TYPE','ISSUE');
        $this->db->delete('stock_master_detail');
      }
     echo "Success";
    }

	
}