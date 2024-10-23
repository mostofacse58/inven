<?php
class Modelwisereport_model extends CI_Model {

	 function reportResult($product_id){
    $condition='';
    if($product_id!='All'){
      $condition.=" AND p.product_id=$product_id ";
    }
    /////////////////
    $result=$this->db->query("SELECT p.product_id,p.product_name,p.product_model,p.china_name,
        (SELECT COUNT(pd.product_detail_id) FROM product_detail_info pd 
        WHERE p.product_id=pd.product_id) as totalqty 
        FROM  product_info p
        WHERE p.department_id=12 AND p.product_type=1 $condition 
        ORDER BY p.product_id ASC")->result();
      return $result;
          
	}
  function getModelWiseStatus($product_id,$machine_status){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT count(ps.product_status_id) as total
          FROM  product_status_info ps,
          product_detail_info pd 
          WHERE ps.product_detail_id=pd.product_detail_id 
          AND pd.product_id=$product_id AND ps.machine_status=$machine_status
          AND ps.take_over_status=1  AND ps.department_id=12")->row('total');
        return $result;
  }
  function getModelWiseFloor($product_id,$floor_id){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT count(ps.product_status_id) as total
          FROM  product_status_info ps,
          product_detail_info pd,
          floorline_info fl,floor_info f 
          WHERE ps.product_detail_id=pd.product_detail_id  AND ps.line_id=fl.line_id AND fl.floor_id=f.floor_id 
          AND f.floor_id=$floor_id AND pd.product_id=$product_id 
          AND ps.take_over_status=1  AND ps.department_id=12")->row('total');
        return $result;
  }
  function NotfoundMachine($product_id,$detail_status){
    $result=$this->db->query("SELECT count(pd.product_detail_id) as total
      FROM  product_detail_info pd
      WHERE pd.detail_status=$detail_status
      AND pd.department_id=12  AND product_id=$product_id")->row('total');
    return $result;

  }
  
}