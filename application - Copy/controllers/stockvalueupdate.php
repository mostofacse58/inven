<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stockvalueupdate extends CI_Controller {
  function __construct() {
	  parent::__construct();
  }

 function index(){
    $pdata=$this->db->query("SELECT p.product_id,
      (SELECT IFNULL(SUM(ss.TOTALAMT_HKD),0) FROM stock_master_detail ss 
           WHERE ss.product_id=p.product_id) as stock_value 
      FROM product_info p
      WHERE p.product_type=2     
      ORDER BY p.product_id ASC LIMIT 0,1000 ")->result();
    foreach ($pdata as  $row){
      $dataarray=array();
      $dataarray['stock_value_hkd']=$row->stock_value;   
      $this->db->WHERE('product_id',$row->product_id);
      $this->db->UPDATE('product_info',$dataarray);
    }
     echo "Success";
     exit();
     //wget -q -O- https://vlmbd.com/inventory/stockvalueupdate 
  }
	function stockupdate(){
        $result=$this->db->query("SELECT p.*
          FROM  product_info p   
          WHERE p.product_type=2 
          ORDER BY p.product_id ASC")->result();
      foreach ($result as  $value) {
        $stock=$this->look_up_model->get_sparesStock($value->product_id);
        $data['main_stock']=$stock;
        $this->db->WHERE('product_id',$value->product_id);
        $query=$this->db->update('product_info',$data);
        }
        
    
    echo "done";
  }
}