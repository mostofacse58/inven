<?php 
class Pcapproval_model extends CI_Model {
  public function get_count(){
    /// 22, 6 Robert, 17 SPark, 16 all thomas
    $condition=' ';
    $department_id=$this->session->userdata('department_id');
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
        $gatepass_no=$this->input->get('gatepass_no');
        $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $query=$this->db->query("SELECT * FROM gatepass_master g
        WHERE g.gatepass_status>=3 
        AND g.gatepass_type=3 AND g.issue_from='Ventura' $condition");
      $data = count($query->result());
      return $data;
    }

  public  function lists($limit,$start){
    $condition=' ';
    $department_id=$this->session->userdata('department_id');
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
      $gatepass_no=$this->input->get('gatepass_no');
      $condition=$condition."  AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,i.*,d.department_name
      FROM  gatepass_master g 
      LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_status>=3 AND g.gatepass_type=3 AND g.issue_from='Ventura'
      $condition
      ORDER BY g.gatepass_status ASC,g.create_date DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }

    
  

  
}
