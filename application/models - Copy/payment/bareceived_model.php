<?php
class Bareceived_model extends CI_Model {
    function lists() {
        $department_id=4;
        $result=$this->db->query("SELECT a.*,d.department_name
            FROM budget_adjustment_master a 
            INNER JOIN department_info d ON(d.department_id=a.by_department)
            WHERE a.department_id=$department_id
            AND a.status>=2
            ORDER BY a.master_id DESC")->result();
        return $result;
    }
   
   function approved($master_id) {
        $data=array();
        $data['status']=4;
        $data['received_by']=$this->session->userdata('user_id');
        $data['received_date']=date('Y-m-d');
        $this->db->WHERE('master_id',$master_id);
        $query=$this->db->Update('budget_adjustment_master',$data);
        return $query;
     }
    ////////////////////////
  
}
