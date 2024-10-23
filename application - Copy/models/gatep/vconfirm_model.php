<?php
class Vconfirm_model extends CI_Model {
  public function get_count(){
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($department_id==6){
      $condition=$condition."  AND (g.department_id=6 OR g.department_id=22 OR g.department_id=34  OR g.department_id=36) ";
    }else{
      $condition=$condition."  AND g.department_id=$department_id ";
    }
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
        $gatepass_no=$this->input->get('gatepass_no');
        $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
     $data=$this->db->query("SELECT count(*) as counts FROM gatepass_master g
        WHERE  g.gatepass_status>=2 $condition")->row('counts');
      return $data;
    }

  public  function lists($limit,$start){
    $department_id=$this->session->userdata('department_id');
    $condition=' ';
    if($department_id==6){
      $condition=$condition."  AND (g.department_id=6 OR g.department_id=22 OR g.department_id=34  OR g.department_id=36) ";
    }else{
      $condition=$condition."  AND g.department_id=$department_id ";
    }
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
      $gatepass_no=$this->input->get('gatepass_no');
      $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
    }
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,i.*,d.department_name
      FROM  gatepass_master g 
      LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status>=2 $condition
      ORDER BY g.gatepass_status ASC,g.create_date DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }

    
  

  
}
