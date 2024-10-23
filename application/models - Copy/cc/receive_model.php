<?php
class Receive_model extends CI_Model {
  function __construct(){
    parent::__construct();
    //$msdb = $this->load->database('msdb', TRUE);
 }
  public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND g.requisition_no LIKE '%$requisition_no%' ";
      }
     }
    $user_id=$this->session->userdata('user_id');
    $query=$this->db->query("SELECT * FROM courier_master g
        WHERE g.courier_status>=3  
        $condition");
    $data = count($query->result());
    return $data;
  }

  public  function lists($limit,$start){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('requisition_no')!=''){
      $requisition_no=$this->input->get('requisition_no');
      $condition=$condition."  AND g.requisition_no LIKE '%$requisition_no%' ";
      }
    }
    $user_id=$this->session->userdata('user_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by_name,i.*,d.department_name
      FROM  courier_master g 
      LEFT JOIN  chargeback_info i ON(g.chargeback_id=i.chargeback_id)
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.prepared_by)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.courier_status>=3
      $condition
      ORDER BY g.courier_id DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }

  function getCCompany(){
     $result=$this->db->query("SELECT * FROM courier_name_info
      ORDER BY courier_company ASC")->result();
      return $result;
  }
 
   
 


  
}
