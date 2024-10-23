<?php
class Lgatepass_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if(isset($_POST)){
      if($this->input->post('gatepass_no')!=''){
        $gatepass_no=$this->input->post('gatepass_no');
        $condition=$condition."  AND (g.gatepass_no LIKE '%$gatepass_no%' OR l.sn_no='$gatepass_no') ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $query=$this->db->query("SELECT g.*,l.*,e.employee_name
      FROM  gatepass_laptop g 
      INNER JOIN  laptop_info l ON(g.laptop_id=l.laptop_id)
      INNER JOIN  employee_info e ON(l.employee_id=e.employee_id)
      WHERE 1  $condition");
      $data = count($query->result());
      return $data;
    }

  public  function lists($limit,$start){
    $condition=' ';
    if(isset($_POST)){
      if($this->input->post('gatepass_no')!=''){
      $gatepass_no=$this->input->post('gatepass_no');
      $condition=$condition."  AND (g.gatepass_no LIKE '%$gatepass_no%' OR l.sn_no='$gatepass_no') ";
      }
     }
    $result=$this->db->query("SELECT g.*,l.*,e.employee_name
      FROM  gatepass_laptop g 
      INNER JOIN  laptop_info l ON(g.laptop_id=l.laptop_id)
      INNER JOIN  employee_info e ON(l.employee_id=e.employee_id)
      WHERE 1  $condition
      ORDER BY g.gatepass_id DESC 
      LIMIT $start, $limit")->result();
    return $result;
  }

  // function get_info($gatepass_id){
  //     $result=$this->db->query("SELECT g.*,u.user_name as created_by,l.*
  //     FROM  gatepass_laptop g 
  //     INNER JOIN  laptop_info l ON(g.laptop_id=l.laptop_id)
  //     INNER JOIN  employee_info e ON(l.employee_id=e.employee_id)
  //     LEFT JOIN user u ON(u.id=g.user_id)
  //     WHERE g.gatepass_id=$gatepass_id")->row();
  //     return $result;
  //   }
    
  

  
}
