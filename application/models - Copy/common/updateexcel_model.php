<?php
class Updateexcel_model extends CI_Model{
     ////////////// save Excel ///////////
    function updateData($pdatas,$data) {
      //print_r($pdatas); exit();
      $product_code=$pdatas['product_code'];
      $department_id=$this->input->post('department_id');
      $this->db->WHERE('product_code',$product_code);
       $this->db->WHERE('department_id',$department_id);
      $query=$this->db->UPDATE('product_info',$data);
      return $query;
    }

     

  
}
