<?php
class Inapproval_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
        $gatepass_no=$this->input->get('gatepass_no');
        $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT * FROM gatepass_master_stock g
        WHERE g.department_id=$department_id 
        AND g.gatepass_status>=3 $condition");
      $data = count($query->result());
      return $data;
    }

  public  function lists($limit,$start){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
      $gatepass_no=$this->input->get('gatepass_no');
      $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,d.department_name
      FROM  gatepass_master_stock g 
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.department_id=$department_id AND g.gatepass_status>=3
      $condition
      ORDER BY g.gatepass_id DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }

   
  

  
}
