<?php
class Ireceived_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
      if($this->input->get('employee_name')!=''){
        $employee_name=$this->input->get('employee_name');
        $condition=$condition."  AND (sm.employee_id LIKE '%$employee_name%' OR sm.requisition_no LIKE '%$employee_name%') ";
      }
      if($this->input->get('location_id')!=''){
        $location_id=$this->input->get('location_id');
        $condition=$condition."  AND sm.location_id='$location_id' ";
      }
     }
   $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(sm.issue_id) as counts
          FROM  store_issue_master sm 
          WHERE sm.take_department_id=$department_id 
          AND sm.medical_yes=2 $condition")->row('counts');
      //$data = count($query->result());
      return $data;
    }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
      if($this->input->get('employee_name')!=''){
        $employee_name=$this->input->get('employee_name');
        $condition=$condition."  AND (sm.employee_id LIKE '%$employee_name%' OR sm.requisition_no LIKE '%$employee_name%') ";
      }
      if($this->input->get('location_id')!=''){
        $location_id=$this->input->get('location_id');
        $condition=$condition."  AND sm.location_id='$location_id' ";
      }
     }
     $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT sm.*,d.department_name,
          u.user_name,sm.employee_id as  employee_cardno,l.location_name,
          'View' as totalquantity
          FROM  store_issue_master sm 
          LEFT JOIN department_info d ON(sm.department_id=d.department_id)
          LEFT JOIN location_info l ON(sm.location_id=l.location_id)
          LEFT JOIN user u ON(u.id=sm.user_id) 
          WHERE sm.take_department_id=$department_id 
          AND sm.medical_yes=2 $condition 
          ORDER BY sm.issue_id DESC 
         LIMIT $start,$limit")->result();
      return $result;
    }

 
 function receivedby(){
    $issue_id=$this->input->post('issue_id');
    $data2['received_by']=$this->session->userdata('user_id');
    $data2['received_date']=date('Y-m-d');
    $data2['receive_comments']=$this->input->post('receive_comments');
    $data2['issue_status']=2;
    $this->db->where('issue_id', $issue_id);
    $query=$this->db->update('store_issue_master',$data2);
    return $query;
  }

    
  
}
