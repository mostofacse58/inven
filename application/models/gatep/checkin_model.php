<?php
class Checkin_model extends CI_Model {
 public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
        $gatepass_no=$this->input->get('gatepass_no');
        $condition=$condition." AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
     $user_id=$this->session->userdata('user_id');
      if($user_id==143){
        $condition=$condition." AND  (g.wh_whare='SFB-01' OR g.wh_whare='CDF') ";
      }elseif($user_id==125){
        $condition=$condition." AND  g.wh_whare='MSSFB-3' ";
      }elseif($user_id==157){
        $condition=$condition." AND  g.wh_whare='CGN' ";
      }elseif($user_id==172){
        $condition=$condition." AND  g.wh_whare='VD' ";
      }else{
        $condition=$condition." AND  g.wh_whare='Ventura' ";
      }
      $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(*) as counts FROM gatepass_master g
        WHERE  g.gatepass_status>=5 $condition")->row('counts');
      return $data;
    }

  public  function lists($limit,$start){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('gatepass_no')!=''){
      $gatepass_no=$this->input->get('gatepass_no');
      $condition=$condition." AND g.gatepass_no LIKE '%$gatepass_no%' ";
      }
     }
     $user_id=$this->session->userdata('user_id');
      if($user_id==143){
        $condition=$condition." AND  (g.wh_whare='SFB-01' OR g.wh_whare='CDF') ";
      }elseif($user_id==125){
        $condition=$condition." AND  g.wh_whare='MSSFB-3' ";
      }elseif($user_id==157){
        $condition=$condition." AND  g.wh_whare='CGN' ";
      }elseif($user_id==172){
        $condition=$condition." AND  g.wh_whare='VD' ";
      }else{
        $condition=$condition." AND  g.wh_whare='Ventura' ";
      }
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,i.*,d.department_name
      FROM  gatepass_master g 
      LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE  g.gatepass_status>=5  $condition
      ORDER BY g.gatepass_status ASC,g.create_date DESC  
      LIMIT $start,$limit")->result();
    return $result;
  }

  function checkingBarcode(){
  	$gatepass_no=$this->input->post('gatepass_no');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
    u1.user_name as approved_by,i.*,d.department_name
    FROM  gatepass_master g 
    LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
    INNER JOIN department_info d ON(g.department_id=d.department_id)
    LEFT JOIN user u ON(u.id=g.user_id)
    LEFT JOIN user u1 ON(u1.id=g.approved_by) 
    WHERE g.gatepass_status=5 AND g.gatepass_no='$gatepass_no'")->row();
    return $result;
  }
  
  function get_info($gatepass_id){
      $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by,i.*,d.department_name
      FROM  gatepass_master g 
      LEFT JOIN  issue_to_master i ON(g.issue_to=i.issue_to)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.gatepass_no='$gatepass_no'")->row();
      return $result;
    }
    function get_detail($gatepass_id){
    $result=$this->db->query("SELECT gd.*
          FROM  gatepass_details gd 
          WHERE gd.gatepass_id=$gatepass_id")->result();
    return $result;
  }

    
   

  
}
